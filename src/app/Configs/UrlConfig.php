<?php

namespace App\Configs;

use Illuminate\Http\Request;

class UrlConfig
{
    public readonly string $baseUri;

    public function __construct(
        Request $request
    ) {
        $this->baseUri = $request->input('uri');
    }
}
