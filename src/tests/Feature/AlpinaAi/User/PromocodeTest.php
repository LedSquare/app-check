<?php

use App\Models\AlpinaAi\Client;
use Tests\Config;
use Tests\Configs\AlpinaAiConfig;

beforeEach(function () {
    /** @var Config $this */
    $alpina = new AlpinaAiConfig('https://gateway');
    $this->alpinaAiConfig = $alpina;

    $this->alpinaAiConfig->client = $this->alpinaAiConfig->clientAuth();

    $this->authHeader = ['authorization' => $this->alpinaAiConfig->client->token];
    $this->alpinaHttp()->withHeaders($this->authHeader);
});

test('Возвращает количество дней промокода, а также его тип', function () {
    /** @var Config $this */

    $offerId = $this->alpinaAiConfig->client->offer_id;
    $this->alpinaAiConfig = new AlpinaAiConfig('https://admin');

    $code = 'AUTO_PROMOCODE_USER_SERVICE#'.fake()->numberBetween(1, 10000);

    $res = $this->alpinaHttp()
        ->withHeader('authorization', $this->alpinaAiConfig->adminAuth())
        ->post('v2/cabinet/users/promocodes', [
            'offer_id' => $offerId,
            'code' => $code,
            'is_active' => true,
            'promo_text' => 'Опа автотестовый промокод',
            'start_at' => now()->format('Y-m-d'),
            'ended_at' => now()->addYear()->format('Y-m-d'),
            'promo_days' => 100,
            'register_limit' => 10,
            'type' => 'default',
        ]);

    Cache::put('promocode_name_for_registration', $code, now()->addMinutes(10));

    $alpina = new AlpinaAiConfig('https://gateway');
    $this->alpinaAiConfig = $alpina;
    $this->alpinaAiConfig->client = $this->alpinaAiConfig->clientAuth();

    $res = $this->alpinaHttp()
        ->withHeaders(['authorization' => $this->alpinaAiConfig->client->token])
        ->get('v2/user/promocodes/promo-days', [
            'name' => $code,
        ]);

    expect($res->status())->toBe(200);
});

test('Регистрация пользователя по промокоду', function () {
    /** @var Config $this */
    $code = Cache::get('promocode_name_for_registration');

    $res = $this->alpinaHttp()
        ->post('v2/user/auth/users/promo-user-registration', [
            'promocode' => $code,
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->email(),
        ]);

    expect($res->status())->toBe(201);
});
