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
use Illuminate\Support\Facades\Log;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Redirect;
use Filament\Forms\Components\Actions\Action;
use Unicodeveloper\Paystack\Facades\Paystack;
use App\Filament\User\Resources\SubjectResource;
use Filament\Forms\Components\Placeholder;

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
    public $payment;
    public $receipt;
    public $user;
    public $proof_of_payment;
    public $payment_method = 'card'; // Default to 'card' payment method

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
            'payment_method' => $this->payment_method,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make($this->plan->title)
                    ->description("You are paying {$this->price} for Jamb exam experience plan")
                    ->schema([
                        Radio::make('payment_method')
                            ->label('Select Payment Method')
                            ->options([
                                'card' => 'Pay with Card',
                                'bank_transfer' => 'Pay via Bank Transfer',
                            ])
                            ->default('card')
                            ->reactive()
                            ->required(),
                        TextInput::make('first_name')->disabled()->required(),
                        TextInput::make('last_name')->disabled()->required(),
                        TextInput::make('email')->disabled()->required(),
                        TextInput::make('amount')
                            ->prefix('₦')
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->numeric()
                            ->disabled(),
                        Placeholder::make('bank_details')
                            ->label('Bank Transfer Details')
                            ->content(new HtmlString('
                                <div class="text-sm">
                                    <p><strong>Bank:</strong> GTBank</p>
                                    <p><strong>Account Name:</strong> Adamu Mohammed</p>
                                    <p><strong>Account Number:</strong> 0172791950</p>
                                    <p class="mt-2">After payment, please upload your proof of payment below.</p>
                                </div>
                            '))
                            ->visible(fn(callable $get) => $get('payment_method') === 'bank_transfer'),
                        FileUpload::make('proof_of_payment')
                            ->label('Proof of Payment')
                            ->image()
                            ->acceptedFileTypes(['image/*', 'application/pdf'])
                            ->directory('payment_proof')
                            ->required(fn(callable $get) => $get('payment_method') === 'bank_transfer')
                            ->maxSize(5120) // 5MB max
                            ->helperText('Upload a screenshot, photo, or PDF of your payment confirmation (max 5MB)')
                            ->visible(fn(callable $get) => $get('payment_method') === 'bank_transfer')
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    $set('upload_complete', true);
                                }
                            }),
                        Placeholder::make('upload_status')
                            ->content(fn(callable $get) => $get('upload_complete') ? 'Upload complete!' : 'Waiting for file...')
                            ->visible(fn(callable $get) => $get('payment_method') === 'bank_transfer'),
                    ])
            ]);
    }

    // public function redirectToGateway()
    // {
    //     $user = auth()->user();
    //     $agent = $user->referringAgents()->first();

    //     $splitData = null;
    //     if ($agent && $agent->subaccount_code) {
    //         $splitData = [
    //             "type" => "percentage",
    //             "currency" => "NGN",
    //             "subaccounts" => [
    //                 ["subaccount" => $agent->subaccount_code, "share" => 20],
    //             ],
    //             "bearer_type" => "all",
    //             "main_account_share" => 90
    //         ];
    //     }

    //     $data = [
    //         'amount' => $this->plan->price * 100,
    //         'email' => $user->email,
    //         'reference' => Paystack::genTranxRef(),
    //         'metadata' => ['planId' => $this->plan->id, 'userId' => $user->id, 'agent_id' => isset($agent) ? $agent->id : null],
    //         'split' => $splitData ? json_encode($splitData) : null
    //     ];

    //     try {
    //         $response = Paystack::getAuthorizationUrl($data)->redirectNow();
    //         return $response;
    //     } catch (\Exception $e) {
    //         Log::error('Payment initialization failed:', ['message' => $e->getMessage(), 'stack' => $e->getTraceAsString()]);
    //         return Redirect::back()->withErrors('Failed to initiate payment. Please try again.');
    //     }
    // }

    public function redirectToGateway()
    {
        $user = auth()->user();
        $agent = $user->referringAgents()->first();
        $school = $user->getReferringSchool();

        $splitData = null;
        $subaccounts = [];

        // Case 1: User referred by an individual agent
        if ($agent && !$school && $agent->subaccount_code) {
            $subaccounts[] = [
                "subaccount" => $agent->subaccount_code,
                "share" => 20 // 20% to the agent
            ];
        }
        // Case 2: User is a student referred by a school
        elseif ($school && $school->subaccount_code) {
            $subaccounts[] = [
                "subaccount" => $school->subaccount_code,
                "share" => 20 // 15% to the school
            ];

            // Check if the school was referred by an agent
            $schoolAgent = $school->parentAgent()->first();
            if ($schoolAgent && $schoolAgent->subaccount_code) {
                $subaccounts[] = [
                    "subaccount" => $schoolAgent->subaccount_code,
                    "share" => 10 // 5% to the agent who referred the school
                ];
            }
        }

        // Calculate main account share
        $totalShare = array_sum(array_column($subaccounts, 'share'));
        $mainAccountShare = 100 - $totalShare;

        if (!empty($subaccounts)) {
            $splitData = [
                "type" => "percentage",
                "currency" => "NGN",
                "subaccounts" => $subaccounts,
                "bearer_type" => "account",
                "main_account_share" => $mainAccountShare
            ];
        }

        $data = [
            'amount' => $this->plan->price * 100,
            'email' => $user->email,
            'reference' => Paystack::genTranxRef(),
            'metadata' => [
                'planId' => $this->plan->id,
                'userId' => $user->id,
                'agentId' => $agent ? $agent->id : null,
                'schoolId' => $school ? $school->id : null
            ],
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
        $data = $this->form->getState();

        if ($data['payment_method'] === 'card') {
            return $this->redirectToGateway();
        }

        if ($data['payment_method'] === 'bank_transfer') {

            $this->payment = Payment::create([
                'user_id' => auth()->id(),
                'plan_id' => $this->plan->id,
                'amount' => $this->plan->price,
                'status' => 'pending',
                'method' => $data['payment_method'],
                'payment_for' => 'subscription plan',
                'proof_of_payment' => $data['proof_of_payment'],
            ]);

            Notification::make()
                ->title('Payment Received')
                ->body('Your bank transfer payment has been received and is pending confirmation. We will review and activate your subscription shortly.')
                ->success()
                ->send();

            return $this->redirectRoute('filament.user.auth.profile');
        }

        return Redirect::back()->withErrors('Unsupported payment method selected.');
    }
}
