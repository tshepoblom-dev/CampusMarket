<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cookie\Middleware\EncryptCookies;

class CookieConsentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('cookie.index', function ($view) {
            // ...
            $cookieConsentConfig = config('cookie-consent');
            $alreadyConsentedWithCookies = Cookie::has($cookieConsentConfig['cookie_name']);
            $view->with(compact('alreadyConsentedWithCookies', 'cookieConsentConfig'));
        });

        $this->packageBooted();
    }



    public function packageBooted(): void
    {
        $this->app->resolving(EncryptCookies::class, function (EncryptCookies $encryptCookies) {
            $encryptCookies->disableFor(config('cookie-consent.cookie_name'));
        });
    }
}
