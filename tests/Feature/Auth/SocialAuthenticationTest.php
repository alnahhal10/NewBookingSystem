<?php

use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Contracts\Provider;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use Spatie\Permission\Models\Role;

function socialiteUser(array $overrides = []): SocialiteUser
{
    $user = new SocialiteUser;

    return $user->setRaw($overrides)->map(array_merge([
        'id' => 'provider-user-123',
        'name' => 'Social Traveler',
        'email' => 'social@example.com',
        'avatar' => 'https://example.com/avatar.jpg',
    ], $overrides));
}

function mockSocialiteProvider(string $provider, SocialiteUser $user): void
{
    $driver = Mockery::mock(Provider::class);
    $driver->shouldReceive('user')->once()->andReturn($user);

    Socialite::shouldReceive('driver')
        ->once()
        ->with($provider)
        ->andReturn($driver);
}

test('social redirect only accepts supported providers', function () {
    $provider = Mockery::mock(Provider::class);
    $provider->shouldReceive('redirect')->once()->andReturn(redirect('https://accounts.example.test'));

    Socialite::shouldReceive('driver')
        ->once()
        ->with('google')
        ->andReturn($provider);

    $this->get('/auth/google/redirect')
        ->assertRedirect('https://accounts.example.test');

    $this->get('/auth/github/redirect')
        ->assertNotFound();
});

test('social callback creates a user and social account', function () {
    Role::firstOrCreate(['name' => 'user']);
    mockSocialiteProvider('google', socialiteUser());

    $this->get('/auth/google/callback')
        ->assertRedirect(route('my.bookings', absolute: false));

    $this->assertAuthenticated();
    $this->assertDatabaseHas('users', [
        'email' => 'social@example.com',
    ]);
    expect(User::where('email', 'social@example.com')->first()->email_verified_at)->not->toBeNull();
    $this->assertDatabaseHas('social_accounts', [
        'provider' => 'google',
        'provider_id' => 'provider-user-123',
        'provider_email' => 'social@example.com',
    ]);
});

test('social callback links to an existing user by email', function () {
    Role::firstOrCreate(['name' => 'user']);
    $user = User::factory()->create(['email' => 'social@example.com']);
    mockSocialiteProvider('facebook', socialiteUser(['id' => 'facebook-456']));

    $this->get('/auth/facebook/callback')
        ->assertRedirect(route('my.bookings', absolute: false));

    $this->assertAuthenticatedAs($user->fresh());
    $this->assertDatabaseHas('social_accounts', [
        'user_id' => $user->id,
        'provider' => 'facebook',
        'provider_id' => 'facebook-456',
    ]);
});

test('social callback logs in an existing social account', function () {
    Role::firstOrCreate(['name' => 'user']);
    $user = User::factory()->create(['email' => 'social@example.com']);
    SocialAccount::create([
        'user_id' => $user->id,
        'provider' => 'apple',
        'provider_id' => 'apple-789',
        'provider_email' => 'social@example.com',
    ]);
    mockSocialiteProvider('apple', socialiteUser(['id' => 'apple-789']));

    $this->get('/auth/apple/callback')
        ->assertRedirect(route('my.bookings', absolute: false));

    expect(Auth::id())->toBe($user->id);
});
