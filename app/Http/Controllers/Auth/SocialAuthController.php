<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse as SymfonyRedirectResponse;

class SocialAuthController extends Controller
{
    private const PROVIDERS = ['google', 'facebook', 'apple'];

    public function redirect(string $provider): SymfonyRedirectResponse
    {
        $this->ensureSupportedProvider($provider);

        return Socialite::driver($provider)->redirect();
    }

    public function callback(string $provider): RedirectResponse
    {
        $this->ensureSupportedProvider($provider);

        $socialUser = Socialite::driver($provider)->user();
        $providerId = (string) $socialUser->getId();
        $email = $socialUser->getEmail();

        $socialAccount = SocialAccount::where('provider', $provider)
            ->where('provider_id', $providerId)
            ->first();

        if ($socialAccount) {
            Auth::login($socialAccount->user, remember: true);

            return $this->authenticatedRedirect();
        }

        if (! $email) {
            return redirect()
                ->route('login')
                ->withErrors(['email' => __('auth.social_email_missing')]);
        }

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $socialUser->getName() ?: $socialUser->getNickname() ?: Str::before($email, '@'),
                'password' => Hash::make(Str::random(32)),
                'email_verified_at' => now(),
            ]
        );

        if (! $user->hasVerifiedEmail()) {
            $user->forceFill(['email_verified_at' => now()])->save();
        }

        $user->socialAccounts()->create([
            'provider' => $provider,
            'provider_id' => $providerId,
            'provider_email' => $email,
            'avatar' => $socialUser->getAvatar(),
        ]);

        Auth::login($user, remember: true);

        return $this->authenticatedRedirect();
    }

    private function ensureSupportedProvider(string $provider): void
    {
        abort_unless(in_array($provider, self::PROVIDERS, true), 404);
    }

    private function authenticatedRedirect(): RedirectResponse
    {
        if (Auth::user()?->hasRole('admin')) {
            return redirect()->route('dashboard');
        }

        return redirect()->route('my.bookings');
    }
}
