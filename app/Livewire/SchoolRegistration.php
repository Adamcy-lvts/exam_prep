<?php

namespace App\Livewire;

use App\Models\Bank;
use App\Models\User;
use App\Models\Agent;
use Filament\Forms\Form;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use App\Jobs\CreatePaystackSubaccount;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Validation\Rules\Password;
// use Filament\Pages\Auth\Register as AgentRegister;
use App\Filament\Agent\Pages\Auth\Register;
use Filament\Http\Responses\Auth\RegistrationResponse;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

class SchoolRegistration extends Register
{
    protected static string $view = 'livewire.school-registration';

    public ?string $token = null;
    public ?Agent $parentAgent = null;

    public function mount(): void
    {
        parent::mount();

        $this->token = request()->route('token');

        $this->parentAgent = Agent::whereHas('schoolRegistrationLinks', function ($query) {
            $query->where('token', $this->token)
                ->where('expires_at', '>', now());
        })->firstOrFail();
    }

    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getBusinessNameFormComponent()->columnSpan('full'),
                        $this->getFirstNameFormComponent(),
                        $this->getLastNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPhoneFormComponent(),
                        $this->getAccountNumberFormComponent(),
                        $this->getAccountNameFormComponent(),
                        $this->getBankFormComponent()->columnSpan('full'),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                    ])->columns(2)
                    ->statePath('data'),
            ),
        ];
    }

    public function register(): ?RegistrationResponse
    {
        try {
            $this->rateLimit(2);
        } catch (TooManyRequestsException $exception) {
            Notification::make()
                ->title(__('filament-panels::pages/auth/register.notifications.throttled.title', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]))
                ->body(array_key_exists('body', __('filament-panels::pages/auth/register.notifications.throttled') ?: []) ? __('filament-panels::pages/auth/register.notifications.throttled.body', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]) : null)
                ->danger()
                ->send();

            return null;
        }

        $data = $this->form->getState();

        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'user_type' => 'school_agent',
            'password' => $data['password'],
        ]);

        $bank = Bank::find($data['bank']);

        $agent = Agent::create([
            'user_id' => $user->id,
            'business_name' => $data['business_name'],
            'account_number' => $data['account_number'],
            'account_name' => $data['account_name'],
            'bank_id' => $bank->id,
            'is_school' => true,
            'parent_agent_id' => $this->parentAgent->id,
        ]);

        // Delete the used registration link
        // $this->parentAgent->schoolRegistrationLinks()
        //     ->where('token', $this->token)
        //     ->delete();

        // Prepare data for the subaccount
        $subaccountData = [
            'business_name' => $data['business_name'],
            'settlement_bank' => $data['bank'],
            'account_number' => $data['account_number'],
            'percentage_charge' => 80,
            'primary_contact_email' => $data['email'],
        ];

        // Dispatch the job to create the subaccount
        dispatch(new CreatePaystackSubaccount($agent, $subaccountData));

        // $this->sendEmailVerificationNotification($user);

        Filament::auth()->login($user);

        session()->regenerate();

        Notification::make()
            ->title('School Registration Successful')
            ->success()
            ->send();

            return $this->getRegistrationResponse($agent);
    }

    protected function getRegistrationResponse(): RegistrationResponse
    {
        $response = app(RegistrationResponse::class);
        
        // Set the intended URL for redirection after registration
        session()->put('url.intended', route('filament.agent.pages.dashboard'));
        
        return $response;
    }

    public function getTitle(): string
    {
        return 'School Registration';
    }

    public function getHeading(): string
    {
        return 'School Registration';
    }

    protected function getBusinessNameFormComponent(): Component
    {
        return TextInput::make('business_name')
            // ->helperText('Business, Organisation, Company name etc. If any.')
            ->label(__('School Name'))
            ->maxLength(255)
            ->autofocus();
    }

    protected function getFirstNameFormComponent(): Component
    {
        return TextInput::make('first_name')
            ->label(__('First Name'))
            ->required()
            ->maxLength(255)
            ->autofocus();
    }

    protected function getLastNameFormComponent(): Component
    {
        return TextInput::make('last_name')
            ->label(__('Last Name'))
            ->required()
            ->maxLength(255)
            ->autofocus();
    }

    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('email')
            ->label(__('filament-panels::pages/auth/register.form.email.label'))
            ->email()
            ->required()
            ->maxLength(255)
            ->unique($this->getUserModel());
    }

    protected function getPhoneFormComponent(): Component
    {
        return TextInput::make('phone')
            ->label(__('Phone'))
            ->required()
            ->maxLength(255)
            ->autofocus();
    }

    protected function getAccountNumberFormComponent(): Component
    {
        return TextInput::make('account_number')
            ->label(__('Account Number'))
            ->numeric()
            ->inputMode('decimal')
            ->required()
            ->maxLength(255)
            ->autofocus();
    }

    protected function getAccountNameFormComponent(): Component
    {
        return TextInput::make('account_name')
            ->label(__('Account Name'))
            ->required()
            ->maxLength(255)
            ->autofocus();
    }

    protected function getBankFormComponent(): Component
    {
        return Select::make('bank')
            ->label('Bank')
            ->required()
            ->options(Bank::all()->pluck('name', 'code')) // This will make the bank code the value and bank name the label
            ->searchable();
    }


    protected function getPasswordFormComponent(): Component
    {
        return TextInput::make('password')
            ->label(__('filament-panels::pages/auth/register.form.password.label'))
            ->password()
            ->required()
            ->rule(Password::default())
            ->dehydrateStateUsing(fn($state) => Hash::make($state))
            ->same('passwordConfirmation')
            ->validationAttribute(__('filament-panels::pages/auth/register.form.password.validation_attribute'));
    }

    protected function getPasswordConfirmationFormComponent(): Component
    {
        return TextInput::make('passwordConfirmation')
            ->label(__('filament-panels::pages/auth/register.form.password_confirmation.label'))
            ->password()
            ->required()
            ->dehydrated(false);
    }
}
