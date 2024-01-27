<?php

namespace App\Filament\User\Pages\EmailVerification;

use Exception;
use App\Models\User;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Notifications\Auth\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Pages\Auth\EmailVerification\EmailVerificationPrompt as EmailVerification;

class EmailVerificationPrompt extends EmailVerification
{
    

    protected static string $view = 'filament.user.pages.email-verification.email-verification-prompt';

    use WithRateLimiting;

    /**
     * @var view-string
     */

    public function mount(): void
    {
        /** @var MustVerifyEmail $user */
        $user = Filament::auth()->user();

        // If the user's email is verified, check their registration status
        if ($user->hasVerifiedEmail()) {
            if ($user->registration_status === User::STATUS_REGISTRATION_COMPLETED) {
                // If registration is completed, redirect to the dashboard
                $this->redirectRoute('filament.user.pages.dashboard');
            } else {
                // If registration is not completed, redirect to the choose-exam page
                $this->redirectRoute('choose-exam');
            }
        }
    }

    public function resendNotificationAction(): Action
    {
        return Action::make('resendNotification')
        ->link()
            ->label(__('filament-panels::pages/auth/email-verification/email-verification-prompt.actions.resend_notification.label') . '.')
            ->action(function (): void {
                try {
                    $this->rateLimit(2);
                } catch (TooManyRequestsException $exception) {
                    Notification::make()
                        ->title(__('filament-panels::pages/auth/email-verification/email-verification-prompt.notifications.notification_resend_throttled.title', [
                            'seconds' => $exception->secondsUntilAvailable,
                            'minutes' => ceil($exception->secondsUntilAvailable / 60),
                        ]))
                        ->body(array_key_exists('body', __('filament-panels::pages/auth/email-verification/email-verification-prompt.notifications.notification_resend_throttled') ?: []) ? __('filament-panels::pages/auth/email-verification/email-verification-prompt.notifications.notification_resend_throttled.body', [
                            'seconds' => $exception->secondsUntilAvailable,
                            'minutes' => ceil($exception->secondsUntilAvailable / 60),
                        ]) : null)
                        ->danger()
                        ->send();

                    return;
                }

                $user = Filament::auth()->user();

                if (!method_exists($user, 'notify')) {
                    $userClass = $user::class;

                    throw new Exception("Model [{$userClass}] does not have a [notify()] method.");
                }

                $notification = new VerifyEmail();
                $notification->url = Filament::getVerifyEmailUrl($user);

                $user->notify($notification);

                Notification::make()
                    ->title(__('filament-panels::pages/auth/email-verification/email-verification-prompt.notifications.notification_resent.title'))
                    ->success()
                    ->send();
            });
    }

    public function getTitle(): string | Htmlable
    {
        return __('filament-panels::pages/auth/email-verification/email-verification-prompt.title');
    }

    public function getHeading(): string | Htmlable
    {
        return __('filament-panels::pages/auth/email-verification/email-verification-prompt.heading');
    }
}
