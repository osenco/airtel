<?php

namespace Osen\Airtel;

use GuzzleHttp\Exception\BadResponseException;

class Disbursement extends Service
{
    public function send($phone, $amount, $currency, $country, $reference, $id = null, $callback = null)
    {
        $headers = array(
            'Content-Type'  => 'application/json',
            'Accept'        => '*/*',
            'X-Country'     => $country ?? $this->country,
            'X-Currency'    => $currency ?? $this->currency,
            'Authorization' => "Bearer {$this->token}",
        );
        // Define array of request body.
        $request_body = array(
            "payee"       => array(
                "msisdn" => $phone,
            ),
            "reference"   => $reference,
            "pin"         => $this->pin,
            "transaction" => array(
                "amount" => $amount,
                "id"     => $id ?? random_bytes(8),
            ),
        );

        try {
            $response = $this->client->request(
                'POST',
                '/standard/v1/disbursements/',
                array(
                    'headers' => $headers,
                    'json'    => $request_body,
                )
            );
            print_r($response->getBody()->getContents());
        } catch (BadResponseException $e) {
            // handle exception or api errors.
            throw $e;
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
                '/standard/v1/disbursements/refund',
                array(
                    'headers' => $headers,
                    'json'    => $request_body,
                )
            );
            print_r($response->getBody()->getContents());
        } catch (BadResponseException $e) {
            // handle exception or api errors.
            throw $e;
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
                '/standard/v1/disbursements/{id}',
                array(
                    'headers' => $headers,
                    'json'    => $request_body,
                )
            );
            print_r($response->getBody()->getContents());
        } catch (BadResponseException $e) {
            // handle exception or api errors.
            throw $e;
        }
    }
}
