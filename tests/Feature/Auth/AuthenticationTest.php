<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;





test('login screen can be rendered', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('users can authenticate using the login screen', function () {
    Role::firstOrCreate(['name' => 'user']);
    $user = User::factory()->create();

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('my.bookings', absolute: false));
});

test('admins are redirected to the dashboard after login', function () {
    Role::firstOrCreate(['name' => 'admin']);
    $user = User::factory()->create();
    $user->assignRole('admin');

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});

test('regular users can not access the admin dashboard', function () {
    $this->withoutMiddleware([
        \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
        \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
        \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class,
    ]);

    Role::firstOrCreate(['name' => 'user']);
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $response = $this->actingAs($user)->get(route('dashboard', absolute: false));

    $response->assertForbidden();
});

test('users can not authenticate with invalid password', function () {
    $user = User::factory()->create();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('users can logout', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/logout');

    $this->assertGuest();
    $response->assertRedirect('/');
});
