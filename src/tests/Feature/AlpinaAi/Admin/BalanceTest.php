<?php

use Tests\Config;
use Tests\Configs\AlpinaAiConfig;

beforeEach(function () {
    /** @var Config $this */
    $alpina = new AlpinaAiConfig('https://admin');
    $this->alpinaAiConfig = $alpina;

    $this->authHeader = ['Authorization' => $this->alpinaAiConfig->adminAuth()];

    $name = fake('ru')->company();
    $res = $this->alpinaHttp()->withHeaders($this->authHeader)
        ->post('v2/cabinet/management/offers/create', [
            'name' => $name,
            'slug' => \Str::slug($name),
            'system_prompt' => 'Нужно захватить мир',
            'max_users' => 20,
            'expired_at' => now()->addDays(3),
        ]);

    $this->offerId = $res->json('id');
});

test('Пополнить баланс', function () {
    $res = $this->alpinaHttp()->withHeaders($this->authHeader)
        ->post("v2/cabinet/billing/balance/{$this->offerId}/increase", [
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




