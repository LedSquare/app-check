<?php

use Tests\Config;

beforeEach(function () {
    /** @var Config $this */
    $this->setTestUri('https://admin');

    $res = Http::post($this->testUrl.'v2/auth/login', [
        'email' => 'admin@admin.com',
        'password' => '123123',
    ]);

    Cache::put('auth_token', 'Bearer '.$res->json('access_token'), now()->addMinutes(10));
    $this->authHeader = ['Authorization' => Cache::get('auth_token')];
});

test('Получить настройки курса токена', function () {
    $res = Http::withHeaders($this->authHeader)
        ->get($this->testUrl."v2/cabinet/billing/rate-settings");

    expect($res->status())->toBe(200);
});

test('Настройка курса токена', function () {
    $res = Http::withHeaders($this->authHeader)
        ->post($this->testUrl."v2/cabinet/billing/rate-settings", [
            'markup' => 2,
            'token_rate' => 1.5,
            'base_token_rate' => 1,
            'usd_rate' => 82,
            'base_usd_rate' => 70,
            'markup_type' => 'value',
            'calculation_type' => 'usd',
        ]);

    expect($res->status())->toBe(200);
});




