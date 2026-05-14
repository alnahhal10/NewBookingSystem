<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ App::getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'BookingPal') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --auth-blue: #06a9df;
                --auth-blue-dark: #087aa4;
                --auth-border: #168aa4;
                --auth-ink: #172934;
                --auth-muted: #6d7b83;
                --auth-surface: #fbfdfe;
            }

            body {
                margin: 0;
                background: var(--auth-surface);
            }

            .auth-shell {
                min-height: 100vh;
                display: grid;
                grid-template-columns: minmax(360px, 1fr) minmax(420px, 1fr);
                color: var(--auth-ink);
                overflow: hidden;
                font-family: Figtree, ui-sans-serif, system-ui, sans-serif;
            }

            .auth-visual {
                position: relative;
                min-height: 100vh;
                background-image: linear-gradient(to bottom, rgba(0, 88, 132, .16), rgba(0, 0, 0, .1)), url('{{ asset('assets/images/auth-travel.jpg') }}');
                background-size: cover;
                background-position: center;
                display: flex;
                align-items: flex-start;
                justify-content: center;
                padding: clamp(2rem, 5vw, 4rem);
                text-align: center;
                color: white;
            }

            .auth-brand {
                margin-top: .5rem;
                text-shadow: 0 2px 18px rgba(0, 0, 0, .3);
            }

            .auth-brand h1 {
                font-size: clamp(2.75rem, 5vw, 4.6rem);
                line-height: 1;
                font-family: "Brush Script MT", "Segoe Script", cursive;
                font-weight: 700;
            }

            .auth-brand p {
                max-width: 30rem;
                margin: 1.2rem auto 0;
                font-size: clamp(1rem, 1.4vw, 1.3rem);
                line-height: 1.35;
                font-weight: 700;
            }

            .auth-panel {
                position: relative;
                min-height: 100vh;
                display: grid;
                place-items: center;
                padding: clamp(2rem, 6vw, 5rem);
                background: #fdfefe;
            }

            .auth-panel::before {
                content: "";
                position: absolute;
                top: 2.25rem;
                inset-inline-end: 0;
                width: 13rem;
                height: 4rem;
                background: no-repeat center / contain url("data:image/svg+xml,%3Csvg width='260' height='80' viewBox='0 0 260 80' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M70 28c58-25 127-22 185 18' stroke='%2306A9DF' stroke-width='2' stroke-dasharray='4 7' stroke-linecap='round'/%3E%3Cpath d='M31 27l34-15-7 19 23 11-9 8-23-7-17 22-8-6 9-24-24-5 9-9 13 6z' fill='%2306A9DF'/%3E%3C/svg%3E");
                opacity: .95;
            }

            .auth-panel::after {
                content: "";
                position: absolute;
                right: 0;
                bottom: 0;
                width: 16rem;
                height: 8.5rem;
                background: no-repeat bottom right / contain url("data:image/svg+xml,%3Csvg width='310' height='170' viewBox='0 0 310 170' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%2306A9DF'%3E%3Cpath d='M18 43h57v127H18V43zm11 13v9h9v-9h-9zm19 0v9h9v-9h-9zm-19 24v9h9v-9h-9zm19 0v9h9v-9h-9zm-19 24v9h9v-9h-9zm19 0v9h9v-9h-9z'/%3E%3Cpath d='M98 78h90v92H98V78zm19 18h14v18h-14V96zm38 0h14v18h-14V96zm-37 39h52v35h-52v-35z'/%3E%3Cpath d='M202 52h72v118h-72V52zm20 18h11v54h-11V70zm28 0h11v54h-11V70zM190 142h105v28H190v-28z'/%3E%3C/g%3E%3C/svg%3E");
                opacity: .95;
            }

            [dir="rtl"] .auth-panel::after {
                right: auto;
                left: 0;
                transform: scaleX(-1);
            }

            .auth-card {
                position: relative;
                z-index: 1;
                width: min(100%, 27rem);
            }

            .auth-title {
                color: var(--auth-blue);
                font-size: clamp(3rem, 5.4vw, 4.35rem);
                font-weight: 800;
                line-height: .98;
                text-align: center;
                letter-spacing: 0;
            }

            .auth-subtitle {
                margin-top: .45rem;
                color: var(--auth-muted);
                text-align: center;
                font-size: .95rem;
            }

            .auth-form {
                margin-top: 2rem;
                display: grid;
                gap: 1.15rem;
            }

            .auth-field label {
                display: inline-block;
                margin-inline-start: 1rem;
                margin-bottom: -.45rem;
                padding: 0 .35rem;
                position: relative;
                z-index: 1;
                background: #fdfefe;
                color: var(--auth-blue-dark);
                font-size: .78rem;
                font-weight: 800;
            }

            .auth-input-wrap {
                display: flex;
                align-items: center;
                gap: .75rem;
                min-height: 3.2rem;
                border: 1.5px solid var(--auth-border);
                border-radius: .55rem;
                padding: 0 .95rem;
                background: white;
                transition: border-color .16s ease, box-shadow .16s ease;
            }

            .auth-input-wrap:focus-within {
                border-color: var(--auth-blue);
                box-shadow: 0 0 0 4px rgba(6, 169, 223, .12);
            }

            .auth-input-wrap svg {
                width: 1.25rem;
                height: 1.25rem;
                color: #111;
                flex: 0 0 auto;
            }

            .auth-input {
                width: 100%;
                min-width: 0;
                border: 0;
                padding: .8rem 0;
                font-size: .95rem;
                background: transparent;
                color: #111827;
            }

            .auth-input:focus {
                outline: none;
                box-shadow: none;
                border-color: transparent;
            }

            .auth-row {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 1rem;
                color: var(--auth-muted);
                font-size: .82rem;
            }

            .auth-link {
                color: #34444c;
                text-decoration: none;
                font-weight: 600;
            }

            .auth-link:hover {
                color: var(--auth-blue-dark);
            }

            .auth-submit {
                justify-self: center;
                min-width: 7.25rem;
                min-height: 2.85rem;
                border: 0;
                border-radius: .4rem;
                background: var(--auth-blue);
                color: white;
                font-size: .85rem;
                font-weight: 800;
                text-transform: uppercase;
                box-shadow: 0 12px 28px rgba(6, 169, 223, .24);
                transition: transform .16s ease, background .16s ease;
            }

            .auth-submit:hover {
                background: #069bd0;
                transform: translateY(-1px);
            }

            .auth-divider {
                display: grid;
                grid-template-columns: 1fr auto 1fr;
                align-items: center;
                gap: .7rem;
                margin: .55rem auto 0;
                width: 75%;
                color: #111;
                font-size: .82rem;
                font-weight: 700;
            }

            .auth-divider::before,
            .auth-divider::after {
                content: "";
                height: 1px;
                background: #d7dee2;
            }

            .auth-socials {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: .7rem;
            }

            .auth-social {
                display: grid;
                place-items: center;
                min-height: 3.15rem;
                border-radius: .45rem;
                background: #edf7fa;
                color: #0b1a22;
                text-decoration: none;
                font-size: 1.35rem;
                font-weight: 800;
                transition: transform .16s ease, background .16s ease;
            }

            .auth-social:hover {
                background: #dff1f7;
                transform: translateY(-1px);
            }

            .auth-social.google {
                color: #df4930;
            }

            .auth-social.facebook {
                color: #1778f2;
            }

            .auth-footnote {
                text-align: center;
                font-size: .9rem;
                color: #111;
            }

            .auth-footnote a {
                color: #111;
                font-weight: 800;
                text-decoration: none;
            }

            .auth-error {
                margin-top: .45rem;
                color: #be123c;
                font-size: .78rem;
            }

            .auth-status {
                margin: 0 0 1rem;
                border-radius: .5rem;
                background: #e8f8ee;
                color: #176a3a;
                padding: .8rem 1rem;
                font-size: .9rem;
                font-weight: 700;
            }

            @media (max-width: 900px) {
                .auth-shell {
                    grid-template-columns: 1fr;
                }

                .auth-visual {
                    min-height: 16rem;
                    padding: 2rem 1.25rem;
                }

                .auth-panel {
                    min-height: auto;
                    padding: 2.5rem 1.25rem 7rem;
                }
            }
        </style>
    </head>
    <body>
        <main class="auth-shell">
            <section class="auth-visual" aria-label="{{ __('auth.brand_name') }}">
                <div class="auth-brand">
                    <h1>{{ __('auth.brand_name') }}</h1>
                    <p>{{ __('auth.brand_tagline') }}</p>
                </div>
            </section>

            <section class="auth-panel">
                <div class="auth-card">
                    {{ $slot }}
                </div>
            </section>
        </main>
    </body>
</html>
