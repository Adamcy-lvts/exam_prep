<?php

namespace App\Filament\User\Resources\SubjectResource\Pages;

use App\Models\Plan;
use App\Models\Payment;
use Filament\Forms\Form;
use Filament\Support\RawJs;
use Filament\Resources\Pages\Page;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Tabs;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
// use Unicodeveloper\Paystack\Facades\Paystack;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Redirect;
use Filament\Forms\Components\Actions\Action;
use Unicodeveloper\Paystack\Facades\Paystack;
use Filament\Forms\Concerns\InteractsWithForms;
use App\Filament\User\Resources\SubjectResource;

class PaymentForm extends Page implements HasForms
{
    use InteractsWithForms;
    protected static string $resource = SubjectResource::class;

    protected static string $view = 'filament.user.resources.subject-resource.pages.payment-form';

    public $plan;
    public $first_name;
    public $last_name;
    public $email;
    public $amount;
    public $reference;
    public $price;
    public $payment_method;
    public ?array $data = [];

    public function mount($planId)
    {

        $this->plan = Plan::findOrFail($planId);

        $this->price = formatNaira($this->plan->price);

        $user = auth()->user();

        $this->form->fill([
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'amount' => $this->plan->price,
            'method' => $this->payment_method,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Pay with Card')
                            ->schema([
                                Section::make($this->plan->title)
                                    ->description("You are paying {$this->price} for Jamb exam experience plan")
                                    ->schema([
                                        Select::make('payment_method')->options([
                                            'pay_with_card' => 'Pay with Card',
                                            'bank_transfer' => 'Pay via Bank Transfer',
                                        ])->default('pay_with_card')->hidden(),
                                        TextInput::make('first_name')->disabled()
                                            ->required(),
                                        TextInput::make('last_name')->disabled()
                                            ->required(),
                                        TextInput::make('email')->disabled()
                                            ->required(),
                                        TextInput::make('amount')->prefix('₦')
                                            ->mask(RawJs::make('$money($input)'))
                                            ->stripCharacters(',')
                                            ->numeric()->disabled(),
                                        // TextInput::make('reference')->default(Paystack::genTranxRef()),

                                    ])
                            ]),
                        Tabs\Tab::make('Pay via Bank Transfer')
                            ->schema([
                                Section::make($this->plan->title)
                                    ->description(new HtmlString(
                                        "Use the following bank details to make payment for {$this->price},
                                    <br>
                                    <br> Bank: GTBank
                                    <br> Account Name: Adamu Mohammed
                                    <br> Account Number: 0172791950
                                    <br>
                                    <br> After payment, send proof of payment through whatsapp to 07060741999 or email to lv4mj1@gmail.com"
                                    ))
                                    ->schema([
                                        // TextInput::make('method')->default('bank_transfer')->hidden(),
                                        TextInput::make('first_name')->disabled()
                                            ->required(),
                                        TextInput::make('last_name')->disabled()
                                            ->required(),
                                        TextInput::make('email')->disabled()
                                            ->required(),
                                        TextInput::make('amount')->prefix('₦')
                                            ->mask(RawJs::make('$money($input)'))
                                            ->stripCharacters(',')
                                            ->numeric()->disabled(),
                                        // TextInput::make('reference')->default(Paystack::genTranxRef()),

                                    ])
                            ]),
                    ])->persistTab()
                    ->id('bank-transfer-tab'),




            ]);
    }

    public function redirectToGateway()
    {
        
dd($this->payment_method);
        if ($this->method === 'pay_with_card') {
            $data = [
                'amount' => $this->plan->price * 100,
                'email' => $this->email,
                'reference' => Paystack::genTranxRef(),
                'metadata' => ['planId' => $this->plan->id]
            ];
            dd($data);
            try {
                return Paystack::getAuthorizationUrl($data)->redirectNow();
            } catch (\Exception $e) {
                // Log the error
                Log::error('Payment failed:', [
                    'message' => $e->getMessage(),
                    'stack' => $e->getTraceAsString(), // Optional: if you want the stack trace
                ]);
                // Redirect back with an error message
                return Redirect::back()->withErrors('The paystack token has expired or there was an error processing the payment. Please refresh the page and try again.');
            }
        } else {
            // Save payment details in the database
            dd($this->method);
            $payment = new Payment();
            $payment->method = $this->method;
            $payment->first_name = $this->first_name;
            $payment->last_name = $this->last_name;
            $payment->email = $this->email;
            $payment->amount = $this->amount;
            $payment->save();

            // Redirect to success page or show a success message
            return Redirect::to('/success')->with('message', 'Payment details saved successfully.');
        }
    }


    // public function redirectToGateway()
    // {
    //     $response = Http::withHeaders([
    //             'Authorization' => 'Bearer ' . env('PAYSTACK_SECRET_KEY'),
    //             'Content-Type' => 'application/json',
    //             'Accept' => 'application/json',
    //         ])->post('https://api.paystack.co/transaction/initialize', [
    //             'amount' => $this->plan->price * 100, // Paystack expects the amount in kobo
    //             'email' => $this->email,
    //             'reference' => Paystack::genTranxRef(),
    //             // other fields like currency, callback_url, etc. can be added here
    //         ]);

    //     if ($response->successful()) {
    //         $authorizationUrl = $response->json()['data']['authorization_url'];
    //         return redirect()->away($authorizationUrl);
    //     } else {
    //         // Handle error, log response and show error message to user
    //         Log::error('Payment initialization failed:', [
    //             'response' => $response->body(),
    //         ]);
    //         return Redirect::back()->withErrors('There was an error processing the payment. Please try again.');
    //     }
    // }
}
