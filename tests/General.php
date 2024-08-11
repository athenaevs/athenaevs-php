<?php

use PHPUnit\Framework\TestCase;
use AthenaEvs\Client;

final class General extends TestCase
{
    private function getClient()
    {
        return new Client($api = '9HAKsYHqWyYjil9Yrfq3pBKKSmYzmgeGhgpur3Dg4CYomgWkXy2YqzyQITbi'); // athenaeves
        // return new Client($api = 'xHJA1mkiURV5dO4IVfnr2TrcD7cAOg3iCfmO52cnnUgsEuTO7GYw262uyXsf'); // local
    }

    public function testVerifyASingleEmailAddress(): void
    {
        $email = 'zyx@gmail.com';

        $response = $this->getClient()->verify($email);

        // return [ 'status' => 'deliverable' ]

        $this->assertTrue(  array_key_exists('status', $response) );
    }

    public function testSendBatchOfEmailsForVerification(): void
    {
        $emails = [
            'zyx@yahoo.com',
            'abc@gmail.com',
        ];

        $response = $this->getClient()->batchVerify($emails);

        $this->assertTrue( array_key_exists( 'batch_id', $response ) );
    }

    public function testGetBatchStatus(): void
    {
        // $batchId = '66b888d715058'; // local
        $batchId = '66b88b5ac07a2'; // server
        $response = $this->getClient()->getBatchStatus($batchId);

        $this->assertTrue( array_key_exists('status', $response) );
    }

    public function testGetBatchResult()
    {
        // $batchId = '66b888d715058'; // local
        $batchId = '66b88b5ac07a2'; // server
        $response = $this->getClient()->getBatchResult($batchId);

        $this->assertTrue( array_key_exists('status', $response) );
        $this->assertTrue( array_key_exists('result', $response) );
    }
}
