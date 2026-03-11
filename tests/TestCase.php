<?php

namespace Tests;


use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;


abstract class TestCase extends BaseTestCase
{
    
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();

        // امسح الـ cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // أنشئ الـ roles مرة وحدة للكل
        Role::firstOrCreate(['name' => 'user',  'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
    }
}