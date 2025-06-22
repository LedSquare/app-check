<?php

use App\Models\Token;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use function Pest\Laravel\postJson;


beforeEach(function () {
    $this->setTestUri('https://admin');
});

test('Аутентификация', function () {
    $res = Http::post($this->testUrl.'v2/auth/login', [
        'email' => 'admin@admin.com',
        'password' => '123123',
    ]);

    expect($res->status())->toBe(200);

    Cache::put('auth_token', 'Bearer '.$res->json('access_token'), now()->addMinutes(10));
});
