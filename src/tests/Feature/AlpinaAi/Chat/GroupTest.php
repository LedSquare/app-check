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

test('Создать личную группу', function () {
    /** @var Config $this */
    $res = $this->alpinaHttp()
        ->post('v2/chat/prompts/groups', [
            'name' => 'auto-test-client-group#'.fake()->numberBetween(1, 10000),
        ]);

    expect($res->status())->toBe(200);
});

test('Получить список публичных и личных групп с промптами', function () {
    /** @var Config $this */
    $res = $this->alpinaHttp()
        ->get('v2/chat/prompts/groups');

    expect($res->status())->toBe(200);
});

test('Получить личную группу по id', function () {
    /** @var Config $this */
    $res = $this->alpinaHttp()
        ->post('v2/chat/prompts/groups', [
            'name' => 'auto-test-client-group#'.fake()->numberBetween(1, 10000),
        ]);

    expect($res->status())->toBe(200);

    $groupId = $res->json('id');

    $res = $this->alpinaHttp()
        ->get("v2/chat/prompts/groups/$groupId");

    expect($res->status())->toBe(200);
});

test('Обновить личную группу по id', function () {
    /** @var Config $this */
    $res = $this->alpinaHttp()
        ->post('v2/chat/prompts/groups', [
            'name' => 'auto-test-client-group#'.fake()->numberBetween(1, 10000),
        ]);

    expect($res->status())->toBe(200);

    $groupId = $res->json('id');

    $res = $this->alpinaHttp()
        ->patch("v2/chat/prompts/groups/$groupId", [
            'name' => 'auto-test-client-group-updated#'.fake()->numberBetween(1, 10000),
        ]);

    expect($res->status())->toBe(200);
});

test('Удалить личную группу по id', function () {
    /** @var Config $this */
    $res = $this->alpinaHttp()
        ->post('v2/chat/prompts/groups', [
            'name' => 'auto-test-client-group#'.fake()->numberBetween(1, 10000),
        ]);

    expect($res->status())->toBe(200);

    $groupId = $res->json('id');

    $res = $this->alpinaHttp()
        ->delete("v2/chat/prompts/groups/$groupId");

    expect($res->status())->toBe(204);
});

