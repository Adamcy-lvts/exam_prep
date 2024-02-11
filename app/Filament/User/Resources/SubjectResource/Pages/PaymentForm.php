<?php

namespace App\Filament\User\Resources\SubjectResource\Pages;

use Log;
use App\Models\Plan;
use Filament\Forms\Form;
use Filament\Support\RawJs;
use Filament\Resources\Pages\Page;
use Filament\Forms\Components\Tabs;
use Illuminate\Support\Facades\Http;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
// use Unicodeveloper\Paystack\Facades\Paystack;
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

    public function mount($planId)
    {

        $this->plan = Plan::findOrFail($planId);

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
                        Tabs\Tab::make('Card')
                            ->schema([
                                Section::make($this->plan->title)
                                    ->description('You are paying 1000 for Jamb exam experience plan')
                                    ->schema([
                                        TextInput::make('first_name')->disabled()
                                            ->required(),
                                        TextInput::make('last_name')->disabled()
                                            ->required(),
                                        TextInput::make('email')->disabled()
                                            ->required(),
                                        TextInput::make('amount')->prefix('₦')
                                            ->mask(RawJs::make('$money($input)'))
                                            ->stripCharacters(',')
                                            ->numeric(),
                                        // TextInput::make('reference')->default(Paystack::genTranxRef()),

                                    ])
                            ]),
                        Tabs\Tab::make('Bank Transfer')
                            ->schema([
                                // ...
                            ]),
                    ]),




            ]);

        Action::make('Pay')
            ->icon('heroicon-m-clipboard')
            ->requiresConfirmation();
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
