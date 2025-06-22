<?php

namespace Tests;

class Config extends TestCase
{
    public string $testUrl;

    public function setTestUri(string $subDomain): void
    {
        $this->testUrl = $subDomain.'.'.env('TEST_TOP_DOMAIN').'/';
    }
}
