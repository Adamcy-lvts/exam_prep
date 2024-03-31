<?php

namespace App\Filament\User\Resources\SubjectResource\Pages;

use App\Models\Plan;
use Filament\Forms\Form;
use Filament\Support\RawJs;
use Filament\Resources\Pages\Page;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Tabs;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Filament\Forms\Components\Section;
// use Unicodeveloper\Paystack\Facades\Paystack;
use Filament\Forms\Components\TextInput;
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
                                        TextInput::make('method')->default('pay_with_card')->hidden(),
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
                                        TextInput::make('method')->default('bank_transfer')->hidden(),
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

        $data = [
            'amount' => $this->plan->price * 100,
            'email' => $this->email,
            'reference' => Paystack::genTranxRef(),
            'metadata' => ['planId' => $this->plan->id]
        ];

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
    }


}
