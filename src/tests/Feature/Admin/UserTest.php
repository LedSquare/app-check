<?php

beforeEach(function () {
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


test('Создание пользователя', function () {
    $res = Http::withHeaders($this->authHeader)
        ->post($this->testUrl.'v2/cabinet/users', [
            'firstName' => fake()->firstName(),
            'lastName' => fake()->lastName(),
            'role' => 'MEMBER',
            'email' => fake()->email(),
            'password' => 'password',
            'entityId' => $this->offerId,
            'send_email' => false,
        ]);

    Cache::put('user_id', $res->json('user')['id'], now()->addMinutes(10));

    expect($res->status())->toBe(201);
});


test('Получить список пользователей', function () {
    $res = Http::withHeaders($this->authHeader)
        ->get($this->testUrl.'v2/cabinet/users', [
            'per_page' => 20,
            'page' => 1,
            'roles' => ['ADMIN'],
        ]);

    expect($res->status())->toBe(200);
});

test('Получить пользователя по id', function () {
    $userId = Cache::get('user_id');

    $res = Http::withHeaders($this->authHeader)
        ->get($this->testUrl.'v2/cabinet/users/'.$userId);

    expect($res->status())->toBe(200);
});

test('Обновить данные пользователя', function () {
    $userId = Cache::get('user_id');

    $res = Http::withHeaders($this->authHeader)
        ->patch($this->testUrl.'v2/cabinet/users/'.$userId, [
            'lastName' => 'LastName_updated',
        ]);

    expect($res->status())->toBe(200);
});

test('Сменить статус блокировки пользователя - blocked', function () {
    $userId = Cache::get('user_id');

    $res = Http::withHeaders($this->authHeader)
        ->patch($this->testUrl."v2/cabinet/users/$userId/status", [
            'status' => 'blocked',
        ]);

    expect($res->status())->toBe(200);
});

test('Сменить статус блокировки пользователя - active', function () {
    $userId = Cache::get('user_id');

    $res = Http::withHeaders($this->authHeader)
        ->patch($this->testUrl."v2/cabinet/users/$userId/status", [
            'status' => 'active',
        ]);

    expect($res->status())->toBe(200);
});

test('Перенос пользователя в оффер', function () {
    $userId = Cache::get('user_id');

    $transOfferId = Http::withHeaders($this->authHeader)
        ->post($this->testUrl.'v2/cabinet/management/offers/create', [
            'name' => 'test-transfer-offer',
            'slug' => fake()->slug(),
            'system_prompt' => 'Нужно перенести мир',
            'max_users' => 20,
            'expired_at' => now()->addDays(3),
        ])->json('id');

    $res = Http::withHeaders($this->authHeader)
        ->post($this->testUrl."v2/cabinet/users/transfer-to-offer", [
            'user_id' => $userId,
            'offer_id' => $transOfferId,
        ]);

    expect($res->status())->toBe(200);
});

test('Массовая регистрация', function () {

    $email = fake()->email();
    $res = Http::withHeaders($this->authHeader)
        ->post($this->testUrl."v2/cabinet/users/mass-registration", [
            'emails' => [
                $email
            ],
            'offer_id' => $this->offerId,
        ]);

    expect($res->status())->toBe(200);

    // sleep(1);

    // $res = Http::withHeaders($this->authHeader)
    //     ->get($this->testUrl.'v2/cabinet/users', [
    //         'search' => $email,
    //     ]);

    // expect($res->status())->toBe(200);
});

test('Сбросить пароль​', function () {
    $userId = Cache::get('user_id');

    $res = Http::withHeaders($this->authHeader)
        ->post($this->testUrl.'v2/cabinet/users/password/reset', [
            'user_id' => $userId,
        ]);

    expect($res->status())->toBe(200);
});
