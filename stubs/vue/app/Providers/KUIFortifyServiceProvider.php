<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Inertia\Inertia;

class KUIFortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fortify::loginView(function () {
            return Inertia::render('Auth/Login');
        });

        Fortify::registerView(function () {
            return Inertia::render('Auth/Register');
        });

        Fortify::requestPasswordResetLinkView(function () {
            return Inertia::render('Auth/ForgotPassword');
        });

        Fortify::resetPasswordView(function ($request) {
            return Inertia::render('Auth/ResetPassword', ['request' => $request]);
        });

        Fortify::verifyEmailView(function () {
            return Inertia::render('Auth/VerifyEmail');
        });

        Fortify::confirmPasswordView(function () {
            return Inertia::render('Auth/ConfirmPassword');
        });

        Fortify::twoFactorChallengeView(function () {
            return Inertia::render('Auth/TwoFactorChallenge');
        });
    }
}
