<?php

use Illuminate\Support\Facades\Http;
use Tests\Config;
use Tests\Configs\AlpinaAiConfig;

beforeEach(function () {
    /** @var Config $this */
    $alpina = new AlpinaAiConfig('https://admin');
    $this->alpinaAiConfig = $alpina;
});

test('Аутентификация', function () {
    /** @var Config $this */
    $res = $this->alpinaHttp()->post('v2/auth/login', [
        'email' => $this->alpinaAiConfig->admin->email,
        'password' => $this->alpinaAiConfig->admin->password,
    ]);
    expect($res->status())->toBe(200);
});
