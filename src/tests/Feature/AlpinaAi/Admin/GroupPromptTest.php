<?php

use Tests\Config;
use Tests\Configs\AlpinaAiConfig;

beforeEach(function () {
    /** @var Config $this */
    $alpina = new AlpinaAiConfig('https://admin');
    $this->alpinaAiConfig = $alpina;

    $this->authHeader = ['Authorization' => $this->alpinaAiConfig->adminAuth()];
    $this->alpinaHttp()->withHeaders($this->authHeader);
});

test('Создание "общей" группы промпта​', function () {
    $res = $this->alpinaHttp()
        ->post('v2/cabinet/prompts/groups', [
            'name' => 'Автотест. Общая группа#'.fake()->numberBetween(1, 100000),
        ]);

    expect($res->status())->toBe(200);

    Cache::put('group_id', $res->json('id'));
});

test('Обновить данные публичной группы по id', function () {
    $groupId = Cache::get('group_id');

    $res = $this->alpinaHttp()
        ->patch("v2/cabinet/prompts/groups/$groupId", [
            'name' => 'Автотест. Общая группа, которую редактировали#'.fake()->numberBetween(1, 100000),
        ]);

    expect($res->status())->toBe(200);
});

test('Поиск групп по наименованию', function () {
    $res = $this->alpinaHttp()
        ->get('v2/cabinet/prompts/groups/search', [
            'limit' => 10,
            'offset' => 0,
        ]);

    expect($res->status())->toBe(200);
});

test('Получить список публичных групп с промптами', function () {
    $res = $this->alpinaHttp()
        ->get('v2/cabinet/prompts/groups', [
            'per_page' => 10,
            'page' => 1,
        ]);

    expect($res->status())->toBe(200);
});

test('Получить публичную группу по id', function () {
    $groupId = Cache::get('group_id');
    $res = $this->alpinaHttp()
        ->get("v2/cabinet/prompts/groups/$groupId");

    expect($res->status())->toBe(200);
});

test('Удалить публичную группу по id', function () {
    $groupId = Cache::get('group_id');
    $res = $this->alpinaHttp()
        ->delete("v2/cabinet/prompts/groups/$groupId");

    expect($res->status())->toBe(204);
});
