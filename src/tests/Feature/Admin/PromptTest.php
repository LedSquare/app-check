<?php

beforeEach(function () {
    $this->setTestUri('https://admin');

    $res = Http::post($this->testUrl.'v2/auth/login', [
        'email' => 'admin@admin.com',
        'password' => '123123',
    ]);

    Cache::put('auth_token', 'Bearer '.$res->json('access_token'), now()->addMinutes(10));
    $this->authHeader = ['Authorization' => Cache::get('auth_token')];

    $res = Http::withHeaders($this->authHeader)
        ->post($this->testUrl.'v2/cabinet/prompts/groups', [
            'name' => 'Автотест. Общая группа#'.fake()->numberBetween(1, 100000),
        ]);

    $this->groupId = Cache::put('group_id', $res->json('id'));
});

test('Создание публичного промпта', function () {
    // v2/cabinet/prompts
});

test('Получить публичный промпт по id', function () {
    // v2/cabinet/prompts/{{id}}
});

test('Обновить данные публичного промпта по id', function () {
    // v2/cabinet/prompts/{{id}}
});
