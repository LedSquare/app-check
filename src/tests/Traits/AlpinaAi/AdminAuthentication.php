<?php

namespace Tests\Traits\AlpinaAi;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

trait AdminAuthentication
{
    public array $authHeader;

    public function adminAuth(string $testUrl): string
    {
        $res = Http::post($testUrl.'v2/auth/login', [
            'email' => 'admin@admin.com',
            'password' => '123123',
        ]);

        $token = $res->json('access_token');
        Cache::put('auth_token', 'Bearer '.$token, now()->addMinutes(10));
        $this->authHeader = ['Authorization' => $token];
        return $token;
    }
}
