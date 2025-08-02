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

    $this->groupId = Cache::remember('alpina_chat_group_id', now()->addMinutes(10), function () {
        $res = $this->alpinaHttp()
            ->post('v2/chat/prompts/groups', [
                'name' => 'auto-test-client-group#'.fake()->numberBetween(1, 10000),
            ]);

        expect($res->status())->toBe(200);

        return $res->json('id');
    });
});

test('Получить список ассисентов ИИ​', function () {
    /** @var Config $this */
    $res = $this->alpinaHttp()
        ->get('v2/chat/cabinet/prompts/assistants');

    expect($res->status())->toBe(200);
});

test('Получить список личных промптов​', function () {
    /** @var Config $this */
    $res = $this->alpinaHttp()
        ->get('v2/chat/prompts');

    expect($res->status())->toBe(200);
});

test('Создание личного промпта', function () {
    /** @var Config $this */
    $res = $this->alpinaHttp()
        ->post('v2/chat/prompts', [
            'name' => 'Авто-тестовый промпт'.uniqid(),
            'group_id' => $this->groupId,
            'content' => fake()->text(200),
            'type' => 'user',
        ]);

    expect($res->status())->toBe(200);
    Cache::put('alpina_chat_prompt_id', $res->json('id'), now()->addMinutes(10));
});


test('Получить личную группу по id', function () {
    /** @var Config $this */
    $promptId = Cache::get('alpina_chat_prompt_id');

    $res = $this->alpinaHttp()
        ->get("v2/chat/prompts/$promptId");

    expect($res->status())->toBe(200);
});

test('Обновить данные личного промпта по id', function () {
    /** @var Config $this */
    $promptId = Cache::get('alpina_chat_prompt_id');

    $res = $this->alpinaHttp()
        ->patch("v2/chat/prompts/$promptId", [
            'name' => 'Авто-тестовый промпт. Обновленный'.uniqid(),
            'group_id' => $this->groupId,
            'content' => 'Обновленный контент',
        ]);

    expect($res->status())->toBe(200);
});


test('Удалить личный промпт по id', function () {
    /** @var Config $this */
    $prompt = Cache::get('alpina_chat_prompt_id');

    $res = $this->alpinaHttp()
        ->delete("v2/chat/prompts/$prompt");

    expect($res->status())->toBe(204);
});

