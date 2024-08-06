<?php

use PHPUnit\Framework\TestCase;
use AthenaEvs\Client;

final class General extends TestCase
{
    private function getClient()
    {
        return new Client($api = '9HAKsYHqWyYjil9Yrfq3pBKKSmYzmgeGhgpur3Dg4CYomgWkXy2YqzyQITbi');
    }

    public function testVerifyEndpointWorks(): void
    {
        $email = 'zyx@gmail.com';

        $response = $this->getClient()->verify($email);

        $this->assertTrue(isset($response['email']));
    }

    public function testBatchVerifyEndpointWorks(): void
    {
        $emails = [
            'zyx@yahoo.com',
            'abc@gmail.com',
        ];

        $response = $this->getClient()->batchVerify($emails);

        $this->assertTrue(isset($response['results']));
    }
}
