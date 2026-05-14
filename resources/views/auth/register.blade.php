<x-guest-layout>
    <h2 class="auth-title">{{ __('auth.create_account') }}</h2>
    <p class="auth-subtitle">{{ __('auth.register_with_email') }}</p>

    <form method="POST" action="{{ route('register') }}" class="auth-form">
        @csrf

        <div class="auth-field">
            <label for="name">{{ __('auth.name') }}</label>
            <div class="auth-input-wrap">
                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" stroke="currentColor" stroke-width="1.8"/>
                    <path d="M4.75 20a7.25 7.25 0 0 1 14.5 0" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                </svg>
                <input id="name" class="auth-input" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
            </div>
            @foreach ($errors->get('name') as $message)
                <p class="auth-error">{{ $message }}</p>
            @endforeach
        </div>

        <div class="auth-field">
            <label for="email">{{ __('auth.email') }}</label>
            <div class="auth-input-wrap">
                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M4 6.75A2.75 2.75 0 0 1 6.75 4h10.5A2.75 2.75 0 0 1 20 6.75v10.5A2.75 2.75 0 0 1 17.25 20H6.75A2.75 2.75 0 0 1 4 17.25V6.75Z" stroke="currentColor" stroke-width="1.8"/>
                    <path d="m6.5 8 4.12 3.1a2.3 2.3 0 0 0 2.76 0L17.5 8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <input id="email" class="auth-input" type="email" name="email" value="{{ old('email') }}" required autocomplete="username">
            </div>
            @foreach ($errors->get('email') as $message)
                <p class="auth-error">{{ $message }}</p>
            @endforeach
        </div>

        <div class="auth-field">
            <label for="password">{{ __('auth.password_label') }}</label>
            <div class="auth-input-wrap">
                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M7 10V8a5 5 0 0 1 10 0v2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    <path d="M6.75 10h10.5A2.75 2.75 0 0 1 20 12.75v4.5A2.75 2.75 0 0 1 17.25 20H6.75A2.75 2.75 0 0 1 4 17.25v-4.5A2.75 2.75 0 0 1 6.75 10Z" stroke="currentColor" stroke-width="1.8"/>
                    <path d="M12 14v2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                </svg>
                <input id="password" class="auth-input" type="password" name="password" required autocomplete="new-password">
            </div>
            @foreach ($errors->get('password') as $message)
                <p class="auth-error">{{ $message }}</p>
            @endforeach
        </div>

        <div class="auth-field">
            <label for="password_confirmation">{{ __('auth.confirm_password') }}</label>
            <div class="auth-input-wrap">
                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M7 10V8a5 5 0 0 1 10 0v2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    <path d="M6.75 10h10.5A2.75 2.75 0 0 1 20 12.75v4.5A2.75 2.75 0 0 1 17.25 20H6.75A2.75 2.75 0 0 1 4 17.25v-4.5A2.75 2.75 0 0 1 6.75 10Z" stroke="currentColor" stroke-width="1.8"/>
                    <path d="m9.75 15 1.55 1.55L14.75 13" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <input id="password_confirmation" class="auth-input" type="password" name="password_confirmation" required autocomplete="new-password">
            </div>
            @foreach ($errors->get('password_confirmation') as $message)
                <p class="auth-error">{{ $message }}</p>
            @endforeach
        </div>

        <button class="auth-submit" type="submit">{{ __('auth.register_button') }}</button>

        <div class="auth-divider">{{ __('auth.or') }}</div>

        <div class="auth-socials">
            <a class="auth-social google" href="{{ route('social.redirect', 'google') }}" aria-label="{{ __('auth.continue_with', ['provider' => 'Google']) }}">G</a>
            <a class="auth-social facebook" href="{{ route('social.redirect', 'facebook') }}" aria-label="{{ __('auth.continue_with', ['provider' => 'Facebook']) }}">f</a>
            <a class="auth-social apple" href="{{ route('social.redirect', 'apple') }}" aria-label="{{ __('auth.continue_with', ['provider' => 'Apple']) }}">&#63743;</a>
        </div>

        <p class="auth-footnote">
            {{ __('auth.have_account') }}
            <a href="{{ route('login') }}">{{ __('auth.login_now') }}</a>
        </p>
    </form>
</x-guest-layout>
