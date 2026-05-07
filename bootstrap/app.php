<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',

        
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
        // --- إضافة هذا الجزء لاستثناء الويب هوك من حماية CSRF ---
        $middleware->validateCsrfTokens(except: [
            
            'ar/webhook/stripe',  // استثناء المسار باللغة العربية
        'en/webhook/stripe',  // استثناء المسار باللغة الإنجليزية
        '*/webhook/stripe',   // للأمان: استثناء أي مسار ينتهي بهذا الاسم
        ]);

        $middleware->alias([
        'role' => \App\Http\Middleware\CheckRole::class,
        'localize'                => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
        'localizationRedirect'    => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
        'localeSessionRedirect'   => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
        'localeCookieRedirect'    => \Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect::class,
        'localeViewPath'          => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class,
    ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
