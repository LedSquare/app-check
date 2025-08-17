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

test('Список переводов пользователя', function () {
    /** @var Config $this */

    $res = $this->alpinaHttp()
        ->get('v2/translate/cabinet/translations', [
            'per_page' => 100,
            'page' => 1,
        ]);

    expect($res->status())->toBe(200);
});

test('Получить список языков', function () {
    /** @var Config $this */

    $res = $this->alpinaHttp()
        ->get('v2/translate/cabinet/deepl/prefer_quality_optimized/langs-list', [
            'type' => 'source',
        ]);

    expect($res->status())->toBe(200);
});

// test('Перевести документ', function () {
//     /** @var Config $this */

//     $res = $this->alpinaHttp()
//         ->get('v2/translate/cabinet/deepl/quality_optimized/trans-file', [
//         ]);

//     expect($res->status())->toBe(200);
// });

