<?php

use PHPUnit\Framework\TestCase;
use AthenaEvs\Client;

final class General extends TestCase
{
    public function testJustWorks(): void
    {
        echo "Hello world\n";


        $client = new Client($api = 'xxxxxxxxxxxxxxxxxxxxx');
        $response = $client->verify('hello@example.jp');


        $this->assertSame(1, 1);
    }

    public function testAnotherCase(): void
    {
        // code here

        $this->assertTrue(true);
    }
}
