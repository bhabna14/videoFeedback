<?php

return [

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'admins' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],
        'business-unit' => [
            'driver' => 'sanctum', // Ensure you are using Sanctum or Passport
            'provider' => 'business-unit', // Matches your 'riders' provider
            'hash' => false,        // Set to true only if using hashed tokens
        ],
        'superadmins' => [
            'driver' => 'session',
            'provider' => 'superadmins',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class, // Replace with your Admin model's namespace
        ],
        'business-unit' => [
            'driver' => 'eloquent',
            'model' => App\Models\BusinessUnit::class,
        ],
        'superadmins' => [
            'driver' => 'eloquent',
            'model' => App\Models\SuperAdmin::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,
];
