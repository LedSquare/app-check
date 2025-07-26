<?php

use Tests\Config;
use Tests\Configs\AlpinaAiConfig;

beforeEach(function () {
    /** @var Config $this */
    $alpina = new AlpinaAiConfig('https://admin');
    $this->alpinaAiConfig = $alpina;

    $this->authHeader = ['Authorization' => $this->alpinaAiConfig->adminAuth()];
    $this->alpinaHttp()->withHeaders($this->authHeader);

    if (Cache::get('user_offer_id')) {
        return;
    }

    $name = fake('ru')->company();
    $res = $this->alpinaHttp()
        ->post('v2/cabinet/management/offers/create', [
            'name' => $name,
            'slug' => \Str::slug($name),
            'system_prompt' => 'Нужно захватить мир',
            'max_users' => 20,
            'expired_at' => now()->addDays(3),
        ]);

    Cache::put('user_offer_id', $res->json('id'), now()->addMinutes(10));
});


test('Создание пользователя', function () {
    $offerId = Cache::get('user_offer_id');
    $res = $this->alpinaHttp()
        ->post('v2/cabinet/users', [
            'firstName' => fake()->firstName(),
            'lastName' => fake()->lastName(),
            'role' => 'MEMBER',
            'email' => fake()->email(),
            'password' => 'password',
            'entityId' => $offerId,
            'send_email' => false,
        ]);

    Cache::put('user_id', $res->json('user')['id'], now()->addMinutes(10));

    expect($res->status())->toBe(201);
});


test('Получить список пользователей', function () {
    $res = $this->alpinaHttp()
        ->get('v2/cabinet/users', [
            'per_page' => 20,
            'page' => 1,
            'roles' => ['ADMIN'],
        ]);

    expect($res->status())->toBe(200);
});

test('Получить пользователя по id', function () {
    $userId = Cache::get('user_id');

    $res = $this->alpinaHttp()
        ->get('v2/cabinet/users/'.$userId);

    expect($res->status())->toBe(200);
});

test('Обновить данные пользователя', function () {
    $userId = Cache::get('user_id');

    $res = $this->alpinaHttp()
        ->patch('v2/cabinet/users/'.$userId, [
            'lastName' => 'LastName_updated',
        ]);

    expect($res->status())->toBe(200);
});

test('Сменить статус блокировки пользователя - blocked', function () {
    $userId = Cache::get('user_id');

    $res = $this->alpinaHttp()
        ->patch("v2/cabinet/users/$userId/status", [
            'status' => 'blocked',
        ]);

    expect($res->status())->toBe(200);
});

test('Сменить статус блокировки пользователя - active', function () {
    $userId = Cache::get('user_id');

    $res = $this->alpinaHttp()
        ->patch("v2/cabinet/users/$userId/status", [
            'status' => 'active',
        ]);

    expect($res->status())->toBe(200);
});

test('Перенос пользователя в оффер', function () {
    $userId = Cache::get('user_id');

    $transOfferId = $this->alpinaHttp()
        ->post('v2/cabinet/management/offers/create', [
            'name' => 'test-transfer-offer',
            'slug' => fake()->slug(),
            'system_prompt' => 'Нужно перенести мир',
            'max_users' => 20,
            'expired_at' => now()->addDays(3),
        ])->json('id');

    $res = $this->alpinaHttp()
        ->post("v2/cabinet/users/transfer-to-offer", [
            'user_id' => $userId,
            'offer_id' => $transOfferId,
        ]);

    expect($res->status())->toBe(200);
});

test('Массовая регистрация', function () {
    $offerId = Cache::get('user_offer_id');
    $email = fake()->email();
    $res = $this->alpinaHttp()
        ->post("v2/cabinet/users/mass-registration", [
            'emails' => [
                $email
            ],
            'offer_id' => $offerId,
        ]);

    expect($res->status())->toBe(200);

    // sleep(1);

    // $res = $this->alpinaHttp()->withHeaders($this->authHeader)
    //     ->get('v2/cabinet/users', [
    //         'search' => $email,
    //     ]);

    // expect($res->status())->toBe(200);
});

test('Сбросить пароль​', function () {
    $userId = Cache::get('user_id');

    $res = $this->alpinaHttp()
        ->post('v2/cabinet/users/password/reset', [
            'user_id' => $userId,
        ]);

    expect($res->status())->toBe(200);
});
