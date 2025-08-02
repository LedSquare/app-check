<?php

use Illuminate\Support\Facades\Cache;
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

test('Список моделей', function () {
    /** @var Config $this */
    $res = $this->alpinaHttp()
        ->get('v2/translate/cabinet/models');

    expect($res->status())->toBe(200);
});

test('Получения списка языков', function () {
    /** @var Config $this */

    $res = $this->alpinaHttp()
        ->get('v2/translate/deepl/9f7f48eb-3b6a-46b9-820d-b89ad2894ef1/langs-list', [
            'per_page' => 15,
            'page' => 1,
        ]);

    expect($res->status())->toBe(200);
});
