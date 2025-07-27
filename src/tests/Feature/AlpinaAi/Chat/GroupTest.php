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
});
