<?php

namespace App\Filament\User\Pages\Auth;

use App\Models\User;
use Filament\Forms\Form;
use Filament\Facades\Filament;
use Illuminate\Support\HtmlString;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Blade;
use Filament\Forms\Components\Checkbox;
use Illuminate\Support\Facades\Session;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Validation\ValidationException;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Notifications\Livewire\DatabaseNotifications;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

class Login extends BaseLogin
{
    protected static string $view = 'filament.user.pages.auth.login';

    public function authenticate(): ?LoginResponse
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            $this->getRateLimitedNotification($exception)?->send();

            return null;
        }

        $data = $this->form->getState();

        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            $this->throwFailureValidationException();
        }

        // Check user status
        if (!$this->checkUserStatus($user)) {
            return null;
        }

        if (!Filament::auth()->attempt($this->getCredentialsFromFormData($data), $data['remember'] ?? false)) {
            $this->throwFailureValidationException();
        }

        Session::regenerate();

        // Send login notification
        $this->sendLoginNotification($user);

        return app(LoginResponse::class);
    }

    protected function sendLoginNotification(User $user)
    {
        DatabaseNotifications::pollingInterval('15s');

        $notification = Notification::make()
            ->title("User Logged In")
            ->body("{$user->full_name} has logged in.")
            ->success();

        // Send notification to super admins
        $superAdmins = Role::findByName('super_admin')->users;

        foreach ($superAdmins as $admin) {
            $notification->sendToDatabase($admin);
        }
    }

    protected function checkUserStatus(User $user): bool
    {
        if (!$this->isUserStatusActive($user)) {
            return false;
        }

        return true;
    }

    protected function isUserStatusActive(User $user): bool
    {
        $status = $user->status;

        if (!$status) {
            $this->sendStatusNotification('User status not set.');
            return false;
        }

        switch ($status) {
            case 'Active':
                return true;
            case 'Banned':
                $this->sendStatusNotification('Your account is banned. Please contact support.');
                return false;
            case 'Suspended':
                $this->sendStatusNotification('Your account is suspended. Please contact support.');
                return false;
            default:
                $this->sendStatusNotification('Invalid account status. Please contact support.');
                return false;
        }
    }

    protected function sendStatusNotification(string $message): void
    {
        Notification::make()
            ->title('Login Failed')
            ->body($message)
            ->danger()
            ->send();
    }

    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('email')
            ->label('Email')
            ->email()
            ->required()
            ->autocomplete()
            ->autofocus();
    }

    protected function getPasswordFormComponent(): Component
    {
        return TextInput::make('password')
            ->label('Password')
            ->password()
            ->required()
            ->revealable(filament()->arePasswordsRevealable())
            ->autocomplete('current-password')
            ->hint(filament()->hasPasswordReset() ? new HtmlString(Blade::render('<x-filament::link :href="filament()->getRequestPasswordResetUrl()" tabindex="3"> {{ __(\'filament-panels::pages/auth/login.actions.request_password_reset.label\') }}</x-filament::link>')) : null);
    }

    protected function getRememberFormComponent(): Component
    {
        return Checkbox::make('remember')
            ->label(__('filament-panels::pages/auth/login.form.remember.label'));
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getRememberFormComponent(),
            ]);
    }
}
