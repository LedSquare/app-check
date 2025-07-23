<?php

beforeEach(function () {
    $this->setTestUri('https://admin');

    $res = Http::post($this->testUrl.'v2/auth/login', [
        'email' => 'admin@admin.com',
        'password' => '123123',
    ]);

    Cache::put('auth_token', 'Bearer '.$res->json('access_token'), now()->addMinutes(10));
    $this->authHeader = ['Authorization' => Cache::get('auth_token')];
});

test('Создание "общей" группы промпта​', function () {
    $res = Http::withHeaders($this->authHeader)
        ->post($this->testUrl.'v2/cabinet/prompts/groups', [
            'name' => 'Автотест. Общая группа#'.fake()->numberBetween(1, 100000),
        ]);

    expect($res->status())->toBe(200);

    Cache::put('group_id', $res->json('id'));
});

test('Обновить данные публичной группы по id', function () {
    $groupId = Cache::get('group_id');

    $res = Http::withHeaders($this->authHeader)
        ->patch($this->testUrl."v2/cabinet/prompts/groups/$groupId", [
            'name' => 'Автотест. Общая группа, которую редактировали#'.fake()->numberBetween(1, 100000),
        ]);

    expect($res->status())->toBe(200);
});

test('Поиск групп по наименованию', function () {
    $res = Http::withHeaders($this->authHeader)
        ->get($this->testUrl.'v2/cabinet/prompts/groups/search', [
            'limit' => 10,
            'offset' => 0,
        ]);

    expect($res->status())->toBe(200);
});

test('Получить список публичных групп с промптами', function () {
    $res = Http::withHeaders($this->authHeader)
        ->get($this->testUrl.'v2/cabinet/prompts/groups', [
            'per_page' => 10,
            'page' => 1,
        ]);

    expect($res->status())->toBe(200);
});

test('Получить публичную группу по id', function () {
    $groupId = Cache::get('group_id');
    $res = Http::withHeaders($this->authHeader)
        ->get($this->testUrl."v2/cabinet/prompts/groups/$groupId");

    expect($res->status())->toBe(200);
});

test('Удалить публичную группу по id', function () {
    $groupId = Cache::get('group_id');
    $res = Http::withHeaders($this->authHeader)
        ->delete($this->testUrl."v2/cabinet/prompts/groups/$groupId");

    expect($res->status())->toBe(204);
});
