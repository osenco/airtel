<?php

namespace Osen\Airtel;

use GuzzleHttp\Exception\BadResponseException;

class Disbursement extends Service
{
    public function send()
    {
        $headers = array(
            'Content-Type'  => 'application/json',
            'Accept'        => '*/*',
            'X-Country'     => $this->country,
            'X-Currency'    => $this->currency,
            'Authorization' => "Bearer {$this->token}",
        );
        // Define array of request body.
        $request_body = array();
        try {
            $response = $this->client->request(
                'POST',
                '/openapiuat.airtel.africa/standard/v1/disbursements/',
                array(
                    'headers' => $headers,
                    'json'    => $request_body,
                )
            );
            print_r($response->getBody()->getContents());
        } catch (BadResponseException $e) {
            // handle exception or api errors.
            print_r($e->getMessage());
        }
    }

    public function refund()
    {
        $headers = array(
            'Content-Type'  => 'application/json',
            'Accept'        => '*/*',
            'X-Country'     => $this->country,
            'X-Currency'    => $this->currency,
            'Authorization' => "Bearer {$this->token}",
        );
        // Define array of request body.
        $request_body = array();
        try {
            $response = $this->client->request(
                'POST',
                '/openapiuat.airtel.africa/standard/v1/disbursements/refund',
                array(
                    'headers' => $headers,
                    'json'    => $request_body,
                )
            );
            print_r($response->getBody()->getContents());
        } catch (BadResponseException $e) {
            // handle exception or api errors.
            print_r($e->getMessage());
        }
    }

    public function statusQuery($id)
    {
        $headers = array(
            'Accept'        => '*/*',
            'X-Country'     => $this->country,
            'X-Currency'    => $this->currency,
            'Authorization' => "Bearer {$this->token}",
        );

        // Define array of request body.
        $request_body = array();
        try {
            $response = $this->client->request(
                'GET',
                '/openapiuat.airtel.africa/standard/v1/disbursements/{id}',
                array(
                    'headers' => $headers,
                    'json'    => $request_body,
                )
            );
            print_r($response->getBody()->getContents());
        } catch (BadResponseException $e) {
            // handle exception or api errors.
            print_r($e->getMessage());
        }
    }
}
