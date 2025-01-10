<?php

namespace App\Providers;

use Config;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Schema::defaultStringLength(191);
        /* Bootstrap Pagination */
        Paginator::useBootstrap();

        if ($this->alreadyInstalled() !==false) {

            /* Define Blade Admin */
            Blade::if('admin', function () {
                return Auth::check() && Auth::user()->role == 3 || Auth::check() && Auth::user()->role == 4;
            });
            /* Define Blade Customer */
            Blade::if('customer', function () {
                return Auth::check() && Auth::user()->role == 1;
            });
            /* Define Blade Merchant */
            Blade::if('merchant', function () {
                return Auth::check() && Auth::user()->role == 2;
            });

            // Code to create table

            if (get_setting('mail_driver')) {
                $config = [
                    'driver' => get_setting('mail_driver'),
                    'host' => get_setting('mail_host'),
                    'port' => get_setting('mail_port'),
                    'from' => ['address' => get_setting('mail_from_address'), 'name' => get_setting('mail_from_name')],
                    'encryption' => get_setting('mail_encryption'),
                    'username' => get_setting('mail_username'),
                    'password' => get_setting('mail_password'),
                    'sendmail' => '/usr/sbin/sendmail -bs',
                    'pretend' => false,
                ];
                Config::set('mail', $config);
            }

            if (get_setting('time_zone')) {

                Config::set('app.timezone', get_setting('time_zone'));
            }
            if (get_setting('gdpr_cookie_enabled')) {

                Config::set('cookie-consent.enabled', true);
            }
        }
    }


    public function alreadyInstalled()
    {
        return file_exists(storage_path('installed'));
    }
}
