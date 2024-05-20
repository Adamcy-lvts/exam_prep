<?php

namespace App\Filament\User\Resources\SubjectResource\Pages;

use App\Models\Plan;
use App\Models\Payment;
use App\Models\Receipt;
use Filament\Forms\Form;
use Filament\Support\RawJs;
use App\Mail\PaymentReceipt;
use Filament\Resources\Pages\Page;
use Illuminate\Support\HtmlString;
use Spatie\LaravelPdf\Facades\Pdf;
// use Unicodeveloper\Paystack\Facades\Paystack;
use Filament\Forms\Components\Tabs;
use Illuminate\Support\Facades\Log;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Redirect;
use Filament\Forms\Components\Actions\Action;
use Unicodeveloper\Paystack\Facades\Paystack;
use App\Filament\User\Resources\SubjectResource;

class PaymentForm extends Page
{
    protected static string $resource = SubjectResource::class;

    protected static string $view = 'filament.user.resources.subject-resource.pages.payment-form';

    public $plan;
    public $first_name;
    public $last_name;
    public $email;
    public $amount;
    public $reference;
    public $price;
    public $method;
    public $payment;
    public $receipt;
    public $user;

    public function mount($planId)
    {

        $this->plan = Plan::findOrFail($planId);

        $this->price = formatNaira($this->plan->price);

        $this->user = auth()->user();

        $this->form->fill([
            'first_name' => $this->user->first_name,
            'last_name' => $this->user->last_name,
            'email' => $this->user->email,
            'amount' => $this->plan->price,
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

                                        Select::make('method')->label('Select Payment Method')
                                            ->default('card')->required()
                                            ->options([
                                                'card' => 'Pay with Card',
                                                'bank_transfer' => 'Pay via Bank Transfer',
                                            ]),

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
                                        Select::make('method')->label('Select Payment Method')
                                            ->default('bank_transfer')->required()
                                            ->options([
                                                'card' => 'Pay with Card',
                                                'bank_transfer' => 'Pay via Bank Transfer',
                                            ]),

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
        $user = auth()->user();
        $agent = $user->referringAgents()->first(); // Assume this returns the agent that referred the user

        $splitData = null;
        if ($agent && $agent->subaccount_code) {
            $splitData = [
                "type" => "percentage",
                "currency" => "NGN", // Assuming your application deals in NGN
                "subaccounts" => [
                    ["subaccount" => $agent->subaccount_code, "share" => 20], // Agent gets 10%
                ],
                "bearer_type" => "all", // Main account bears the transaction charges
                "main_account_share" => 90 // Main account gets 90%
            ];
        }

        $data = [
            'amount' => $this->plan->price * 100, // Convert to kobo
            'email' => $user->email,
            'reference' => Paystack::genTranxRef(),
            'metadata' => ['planId' => $this->plan->id, 'userId' => $user->id, 'agent_id' => isset($agent) ? $agent->id : null],
            'split' => $splitData ? json_encode($splitData) : null
        ];

        try {
            $response = Paystack::getAuthorizationUrl($data)->redirectNow();
            return $response;
        } catch (\Exception $e) {
            Log::error('Payment initialization failed:', ['message' => $e->getMessage(), 'stack' => $e->getTraceAsString()]);
            return Redirect::back()->withErrors('Failed to initiate payment. Please try again.');
        }
    }




    public function processPayment()
    {
        // Check if the 'method' property has been set
        if (!$this->method) {
            // Ideally, you should return some error or handle this case
            return Redirect::back()->withErrors('Please select a payment method.');
        }

        // dd($this->method);
        // Handle the card payment
        if ($this->method === 'card') {
            // Redirect to Paystack gateway
            return $this->redirectToGateway();
        }

        // Handle the bank transfer
        if ($this->method === 'bank_transfer') {
            // Record the payment as pending in your payment table
            // Replace 'Payment' with your actual payment model and set the appropriate fields
            $this->payment = Payment::create([
                'user_id' => auth()->id(),
                'plan_id' => $this->plan->id,
                'amount' => $this->plan->price,
                'status' => 'pending',
                'method' => $this->method,
                'payment_for' => 'subscription plan',
                // Add other necessary fields
            ]);


            Notification::make()
                ->title('success')
                ->body('Your bank transfer payment has been recorded, pending confirmation. we will get back to you.')
                ->success()
                ->send();
            // Redirect to a confirmation page or back with a success message
            return $this->redirectRoute('filament.user.auth.profile');
        }

        // In case of an unsupported method
        return Redirect::back()->withErrors('Unsupported payment method selected.');
    }
}
