<?php

namespace App\Providers;

use App\Models\User;
use App\Observers\UserObserver;
use Filament\Support\Colors\Color;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentColor;
use Filament\Http\Responses\Auth\LoginResponse;
use App\Http\Controllers\Filament\Auth\EmailVerificationController;
use Filament\Http\Controllers\Auth\EmailVerificationController as FilamentEmailVerificationController;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(LoginViewResponse::class, LoginResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(FilamentEmailVerificationController::class, EmailVerificationController::class);

        Schema::defaultStringLength(191);

        FilamentColor::register([
            'danger' => Color::Red,
            'gray' => Color::Zinc,
            'info' => Color::Blue,
            'primary' => Color::Amber,
            'success' => Color::Green,
            'warning' => Color::Amber,
            'indigo' => Color::Indigo,
        ]);

        User::observe(UserObserver::class);
    }
}
