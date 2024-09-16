<?php

namespace App\Providers\Filament;


use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Navigation\MenuItem;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;
use Filament\Navigation\NavigationItem;
use App\Filament\User\Pages\Auth\Register;
use Filament\Http\Middleware\Authenticate;
use Filament\Support\Facades\FilamentView;
use App\Filament\User\Pages\Auth\EditProfile;
use App\Filament\User\Pages\Auth\Login;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use App\Filament\User\Widgets\FilamentInfoWidget;
use App\Http\Middleware\EnsureRegistrationCompletion;
use Illuminate\Routing\Middleware\SubstituteBindings;
// use App\Filament\User\Resources\SubjectResource\Pages\PricingPage;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use App\Filament\User\Pages\EmailVerification\EmailVerificationPrompt;
use App\Filament\User\Resources\CourseResource\Pages\PricingPage as CoursePricingPage;
use App\Filament\User\Resources\SubjectResource\Pages\PricingPage as SubjectPricingPage;

class UserPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
       
        return $panel
            ->id('user')
            ->path('user')
            ->login(Login::class)
            ->colors([
                'primary' => Color::Green,
            ])
            ->userMenuItems([

                MenuItem::make()
                    ->label('Pricing')
                    ->url(function (): string {
                        $user = auth()->user(); // get the authenticated user

                        if ($user->subjects->count() > 0) {
                            return SubjectPricingPage::getUrl();
                        } else {
                            return CoursePricingPage::getUrl();
                        }
                    })
                    ->icon('heroicon-o-currency-dollar'),


                // ...
            ])

            ->sidebarCollapsibleOnDesktop()
            ->viteTheme('resources/css/filament/user/theme.css')
            ->discoverResources(in: app_path('Filament/User/Resources'), for: 'App\\Filament\\User\\Resources')
            ->discoverPages(in: app_path('Filament/User/Pages'), for: 'App\\Filament\\User\\Pages')

            ->pages([
                // Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/User/Widgets'), for: 'App\\Filament\\User\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                FilamentInfoWidget::class,

            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,

            ])
            ->authMiddleware([
                Authenticate::class,
                EnsureRegistrationCompletion::class
            ])->registration(Register::class)
            ->passwordReset()
            ->emailVerification(EmailVerificationPrompt::class)
            ->profile(EditProfile::class, isSimple: false);
    }
}
