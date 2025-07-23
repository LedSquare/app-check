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

    $name = fake('ru')->company();
    $res = Http::withHeaders($this->authHeader)
        ->post($this->testUrl.'v2/cabinet/management/offers/create', [
            'name' => $name,
            'slug' => \Str::slug($name),
            'system_prompt' => 'Нужно захватить мир',
            'max_users' => 20,
            'expired_at' => now()->addDays(3),
        ]);

    $this->offerId = $res->json('id');
});

test('Пополнить баланс', function () {
    $res = Http::withHeaders($this->authHeader)
        ->post($this->testUrl."v2/cabinet/billing/balance/{$this->offerId}/increase", [
            'value' => 15000,
            'discount' => 10,
            'bonus_tokens' => 15,
            'transaction_date' => [
                'somse' => 'asdsd',
            ],
            'payment_number' => (string) fake()->numberBetween(2302424, 230293024),
        ]);

    expect($res->status())->toBe(200);
});




