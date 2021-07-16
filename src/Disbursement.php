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
            'X-Country'     => $country ?? self::$country,
            'X-Currency'    => $currency ?? self::$currency,
            'Authorization' => 'Bearer '.self::$token,
        );
        // Define array of request body.
        $request_body = array(
            'payee'       => array(
                'msisdn' => $phone,
            ),
            'reference'   => $reference,
            'pin'         => self::$pin,
            'transaction' => array(
                'amount' => $amount,
                'id'     => $id ?? random_bytes(8),
            ),
        );

        try {
            $response = self::$client->request(
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
            'X-Country'     => self::$country,
            'X-Currency'    => self::$currency,
            'Authorization' => 'Bearer '.self::$token,
        );
        // Define array of request body.
        $request_body = array();
        try {
            $response = self::$client->request(
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
            'X-Country'     => self::$country,
            'X-Currency'    => self::$currency,
            'Authorization' => 'Bearer '.self::$token,
        );

        // Define array of request body.
        $request_body = array();
        try {
            $response = self::$client->request(
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
