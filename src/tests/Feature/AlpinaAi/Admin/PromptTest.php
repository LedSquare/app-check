<?php

use Tests\Config;
use Tests\Configs\AlpinaAiConfig;

beforeEach(function () {
    /** @var Config $this */
    $alpina = new AlpinaAiConfig('https://admin');
    $this->alpinaAiConfig = $alpina;

    $this->authHeader = ['Authorization' => $this->alpinaAiConfig->adminAuth()];

    $res = $this->alpinaHttp()->withHeaders($this->authHeader)
        ->post('v2/cabinet/prompts/groups', [
            'name' => 'Автотест. Общая группа#'.fake()->numberBetween(1, 100000),
        ]);

    $this->groupId = Cache::put('group_id', $res->json('id'));
});

test('Получить список публичных промптов', function () {

    $res = $this->alpinaHttp()->withHeaders($this->authHeader)
        ->get("v2/cabinet/prompts?per_page=10&page=1");

    expect($res->status())->toBe(200);
});

test('Создание публичного промпта', function () {
    $groupId = Cache::get('group_id');

    $res = $this->alpinaHttp()->withHeaders($this->authHeader)
        ->post("v2/cabinet/prompts", [
            'name' => 'Автотест. промпт#'.fake()->numberBetween(1, 100000),
            'group_id' => $groupId,
            'content' => fake()->text(200),
        ]);

    Cache::put('prompt_id', $res->json('id'));

    expect($res->status())->toBe(200);
});

test('Получить публичный промпт по id', function () {
    $promptId = Cache::get('prompt_id');

    $res = $this->alpinaHttp()->withHeaders($this->authHeader)
        ->get("v2/cabinet/prompts/$promptId");

    expect($res->status())->toBe(200);
});

test('Обновить данные публичного промпта по id', function () {
    $groupId = Cache::get('group_id');
    $promptId = Cache::get('prompt_id');

    $res = $this->alpinaHttp()->withHeaders($this->authHeader)
        ->patch("v2/cabinet/prompts/$promptId", [
            'name' => 'Автотест. Измененный промпт#'.fake()->numberBetween(1, 100000),
            'group_id' => $groupId,
            'content' => fake()->text(200),
        ]);

    expect($res->status())->toBe(200);
});


test('Удалить публичный промпт по id', function () {
    $groupId = Cache::get('group_id');
    $promptId = Cache::get('prompt_id');

    $res = $this->alpinaHttp()->withHeaders($this->authHeader)
        ->patch("v2/cabinet/prompts/$promptId");

    expect($res->status())->toBe(200);
});


