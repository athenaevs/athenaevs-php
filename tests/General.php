<?php

use PHPUnit\Framework\TestCase;
use AthenaEvs\Client;

final class General extends TestCase
{
    private function getClient()
    {
        return new Client($api = '9HAKsYHqWyYjil9Yrfq3pBKKSmYzmgeGhgpur3Dg4CYomgWkXy2YqzyQITbi');
    }

    public function testVerifyASingleEmailAddress(): void
    {
        $email = 'zyx@gmail.com';

        $response = $this->getClient()->verify($email);

        // return [ 'status' => 'deliverable' ]

        $this->assertTrue(  array_keys_exists('status', $response) );
    }

    public function testSendBatchOfEmailsForVerification(): void
    {
        $emails = [
            'zyx@yahoo.com',
            'abc@gmail.com',
        ];

        $response = $this->getClient()->batchVerify($emails);

        $this->assertTrue( array_keys_exists( 'batch_id', $response ) );
    }

    public function testGetBatchStatus(): void
    {
        $batchId = '3982472938473928';
        $response = $this->getClient()->getBatchStatus($batchId);

        $this->assertTrue( $response['status'] = 'running' );
    }

    public function testGetBatchResult()
    {
        $batchId = '3982472938473928';
        $response = $this->getClient()->getBatchResult($batchId);

        $this->assertTrue( array_keys_exists('emails', $response) );
    }
}
