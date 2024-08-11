<?php

namespace AthenaEVS;

use GuzzleHttp\Client as GuzzleClient;
use Exception;

class Client
{
    protected $apiKey;
    protected $client;

    // const BASE_URI = 'http://em.com/api/v1/';
    const BASE_URI = 'https://athenaevs.com/api/v1/';

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

    private function makeRequest($method, $uri, $params = [])
    {
        $client = $this->getClient();

        try {
            $options = [
                'headers' => [
                    'Authorization' => "Bearer {$this->apiKey}",
                    'Accept' => 'application/json',
                ],
            ];

            // If the method is POST, add form_params
            if (strtoupper($method) == 'POST') {
                $options['form_params'] = $params;
            }

            $response = $client->request($method, $uri, $options);

            // // Get the status code of the response
            // $statusCode = $response->getStatusCode();

            // // Get the response body
            // $body = $response->getBody();

            // // Decode the JSON response if necessary
            // $data = json_decode($body, true);

            // Output the data
            return $response;
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            // Handle client exceptions
            echo 'ClientException: ' . $e->getMessage() . "\n";
            echo 'Response: ' . $e->getResponse()->getBody()->getContents() . "\n";
            echo 'Stack Trace: ' . $e->getTraceAsString() . "\n";
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            // Handle request exceptions
            echo 'RequestException: ' . $e->getMessage() . "\n";
            if ($e->hasResponse()) {
                echo 'Response: ' . $e->getResponse()->getBody()->getContents() . "\n";
            }
            echo 'Stack Trace: ' . $e->getTraceAsString() . "\n";
        } catch (Exception $e) {
            // Handle all other exceptions
            echo 'Exception: ' . $e->getMessage() . "\n";
            echo 'Stack Trace: ' . $e->getTraceAsString() . "\n";
        }
    }

    public function verify($email)
    {
        $response = $this->makeRequest('POST', 'verify', [
            'email' => $email,
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
        $response = $this->makeRequest('POST', 'batch-verify', [
            'emails' => $emails,
        ]);

        if ($response->getStatusCode() != 200) {
            throw new Exception("Error verifying batch of emails! {$response->getStatusCode()}, {$response->getReasonPhrase()}");
        }

        $raw = (string)$response->getBody();
        $json = json_decode($raw, true);

        return $json;
    }
    
    public function getBatchStatus($batchId)
    {
        $response = $this->makeRequest('POST', 'batch-status', [
            'batch_id' => $batchId,
        ]);

        if ($response->getStatusCode() != 200) {
            throw new Exception("Error get batch status! {$response->getStatusCode()}, {$response->getReasonPhrase()}");
        }

        $raw = (string)$response->getBody();
        $json = json_decode($raw, true);

        return $json;
    }

    public function getBatchResult($batchId)
    {
        $response = $this->makeRequest('POST', 'batch-result', [
            'batch_id' => $batchId,
        ]);

        if ($response->getStatusCode() != 200) {
            throw new Exception("Error get batch result! {$response->getStatusCode()}, {$response->getReasonPhrase()}");
        }

        $raw = (string)$response->getBody();
        $json = json_decode($raw, true);

        return $json;
    }
}
