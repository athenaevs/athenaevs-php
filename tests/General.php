<?php

use PHPUnit\Framework\TestCase;
use AthenaEvs\Client;

final class General extends TestCase
{
    private function getClient()
    {
        return new Client($api = 'lzvxz9bp1zuyr7539vw6b7ftw9gha'); // athenaeves
        // return new Client($api = 'cgunm52cx4h1bs6q6rqtto47w7vkh'); // local
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
        $batchId = '66b97871ebd00'; // server
        $response = $this->getClient()->getBatchStatus($batchId);

        $this->assertTrue( array_key_exists('status', $response) );
    }

    public function testGetBatchResult()
    {
        // $batchId = '66b888d715058'; // local
        $batchId = '66b97871ebd00'; // server
        $response = $this->getClient()->getBatchResult($batchId);

        $this->assertTrue( array_key_exists('status', $response) );
        $this->assertTrue( array_key_exists('result', $response) );
    }
}
