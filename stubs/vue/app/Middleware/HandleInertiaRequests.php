<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Laravel\Fortify\Features;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => function () use ($request) {
                    if (!$request->user()) {
                        return;
                    }

                    return array_merge($request->user()->toArray(), [
                        'two_factor_enabled' => !is_null($request->user()->two_factor_secret),
                    ]);
                },
                'canUpdateProfileInformation' => Features::canUpdateProfileInformation(),
                'canManageTwoFactorAuthentication' => Features::canManageTwoFactorAuthentication(),
                'canUpdatePassword' => Features::enabled(Features::updatePasswords()),
            ],
        ]);
    }
}
