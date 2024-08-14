<?php

use PHPUnit\Framework\TestCase;
use AthenaEvs\Client;

final class General extends TestCase
{
    private $batchId;

    private function getClient()
    {
        return new Client($api = 'lzvxz9bp1zuyr7539vw6b7ftw9gha'); // athenaeves
        // return new Client($api = 'cgunm52cx4h1bs6q6rqtto47w7vkh'); // local
    }

    public function testAttemptWithInvalidKey()
    {
        $client = new Client($api = 'xxxx');

        $email = 'zyx@gmail.com';

        $response = $client->testApi($email);

        $this->assertTrue($response->getResponse()->getStatusCode() == 403 );
    }

    public function testVerifyASingleEmailAddress(): void
    {
        $email = 'zyx@gmail.com';

        $response = $this->getClient()->verify($email);

        // return [ 'status' => 'deliverable' ]

        $this->assertTrue(  array_key_exists('status', $response) );
    }

    public function testSendBatchOfEmailsForVerification(): array
    {
        $emails = [
            'zyx@yahoo.com',
            'abc@gmail.com',
        ];

        $response = $this->getClient()->batchVerify($emails);

        $this->batchId = $response['batch_id'];

        $this->assertTrue( array_key_exists( 'batch_id', $response ) );

        // Return the batchId to be used in the dependent test
        return $response;
    }

    /**
     * @depends testSendBatchOfEmailsForVerification
     */
    public function testGetBatchStatus(array $response): void
    {
        $batchId = $response['batch_id'];

        // Use the batchId stored in the previous test
        $this->assertNotEmpty($batchId, 'Batch ID should not be empty');

        $response = $this->getClient()->getBatchStatus($batchId);

        $this->assertTrue( array_key_exists('status', $response) );
    }

    /**
     * @depends testSendBatchOfEmailsForVerification
     */
    public function testGetBatchResult(array $response): void
    {
        $batchId = $response['batch_id'];

        // Use the batchId stored in the previous test
        $this->assertNotEmpty($batchId, 'Batch ID should not be empty');

        $response = $this->getClient()->getBatchResult($batchId);

        $this->assertTrue( array_key_exists('status', $response) );
        $this->assertTrue( array_key_exists('result', $response) );
    }
}
