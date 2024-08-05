<?php

use PHPUnit\Framework\TestCase;
use AthenaEvs\Client;

final class General extends TestCase
{
    public function testCanBeCreatedFromValidEmail(): void
    {
        $client = new Client;
        echo "Hello world";
        $this->assertSame(1, 1);
    }

    public function testCannotBeCreatedFromInvalidEmail(): void
    {
        $this->assertTrue(true);
    }
}
