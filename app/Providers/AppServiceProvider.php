<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Route;
use SocialiteProviders\Manager\SocialiteWasCalled;

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
        Event::listen(function (SocialiteWasCalled $event): void {
            $event->extendSocialite('apple', \SocialiteProviders\Apple\Provider::class);
        });

        //
        VerifyEmail::createUrlUsing(function ($notifiable) {
        
        
        $verifyUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );

        $appUrl = config('app.url');

        // استبدل الـ URL ليشمل اللغة الصحيحة
        return str_replace(
            url('/'),
            url('/') ,
            $verifyUrl
        );
    });
    }
}
