<?php

namespace App\DotsAPI\Fetcher\v2;

use GuzzleHttp\Client;

class AuthApiFetcher
{
    public function get($endpoint, $field = 'items') {
        $client = new Client();

        $baseUrl = config('dotsapi.base_url');
        $apiToken = config('dotsapi.api_token');
        $apiAccountToken = config('dotsapi.api_account_token');
        $apiAuthToken = config('dotsapi.api_auth_token');

        $apiUrl = $baseUrl . $endpoint;

        $response = $client->get(
            $apiUrl,
            [
                'headers' => [
                    'Api-Auth-Token' => $apiAuthToken,
                    'Api-Token' => $apiToken,
                    'Api-Account-Token' => $apiAccountToken,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'query' => [
                    'v'=> '2.0.0',
                ],
            ]
        );

        $data = json_decode($response->getBody()->getContents(), true);

        if($field == '')
            return $data;

        return $data[$field];
    }
}
