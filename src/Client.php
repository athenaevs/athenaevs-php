<?php

namespace AthenaEVS;

use GuzzleHttp\Client as GuzzleClient;
use Exception;

class Client
{
    protected $apiKey;
    protected $client;

    const BASE_URI = 'https://athenaevs.jp/v1/';

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    private function getClient()
    {
        if (!$this->client) {
            $this->client = new GuzzleClient([
                'base_uri' => static::BASE_URI,
                'verify' => false,
                'headers' => [
                    // 'Content-Type' => 'application/json',
                    'Authorization' => "Bearer {$this->apiKey}",
                ],
            ]);
        }

        return $this->client;
    }

    public function verify($email)
    {
        $response = $this->getClient()->request('POST', '/verify', [
            // Use JSON type, equiv. to application/json
            //
            // 'json' => [
            //     'email' => $email,
            // ]

            'form_params' => [
                'email' => $email,
            ]
        ]);

        if ($response->getStatusCode() != 200) {
            throw new Exception("Error verifying email {$email}!, {$response->getStatusCode()}, {$response->getReasonPhrase()}");
        }

        $raw = (string)$response->getBody();
        $json = json_decode($raw, true);

        // Something like [ success => true, result => 'deliverable' ]

        return $json;
    }

    public function batchVerify(array $emails)
    {
        $response = $this->getClient()->request('POST', '/batch-verify', [
            // Use JSON type, equiv. to application/json
            //
            // 'json' => [
            //     'email' => $email,
            // ]

            'form_params' => [
                'emails' => $emails,
            ]
        ]);

        if ($response->getStatusCode() != 200) {
            throw new Exception("Error verifying batch of emails! {$response->getStatusCode()}, {$response->getReasonPhrase()}");
        }

        $raw = (string)$response->getBody();
        $json = json_decode($raw, true);

        // Something like [ success => true, batch_id => '100093' ]

        return $json;
    }
}
