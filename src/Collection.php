<?php

namespace Osen\Airtel;

use GuzzleHttp\Exception\BadResponseException;

class Collection extends Service
{

    public function ussdPush($amount, $phone, $id = null, $reference = "", $currency = 'KES', $country = "")
    {
        $headers = array(
            'Content-Type' => 'application/json',
            'X-Country' => $this->country,
            'X-Currency' => $this->currency,
            'Authorization'  =>  "Bearer {$this->token}",
        );

        // Define array of request body.
        $request_body = array(
            "reference"   => $reference,
            "subscriber"  => array(
                "country"  => $country,
                "currency" => $currency,
                "msisdn"   => 9999999999,
            ),
            "transaction" => array(
                "amount"   => 1000,
                "country"  => $country,
                "currency" => $currency,
                "id"       => is_null($id) ? random_bytes(8) : $id,
            ),
        );

        try {
            $response = $this->client->request(
                'POST',
                '/merchant/v1/payments/',
                array(
                    'headers' => $headers,
                    'json'    => $request_body,
                )
            );

            $response = $response->getBody()->getContents();
            return json_decode($response, true);
        } catch (BadResponseException $e) {
            // handle exception or api errors.
            throw $e;
        }
    }

    public function refund($id, $country = 'KE', $currency = 'KES')
    {
        $headers = array(
            'Content-Type' => 'application/json',
            'X-Country' => $this->country,
            'X-Currency' => $this->currency,
            'Authorization'  =>  "Bearer {$this->token}",
        );

        // Define array of request body.
        $request_body = array(
            "transaction" => array(
                "airtel_money_id" => $id
            )
        );

        try {
            $response = $this->client->request(
                'POST',
                '/standard/v1/payments/refund',
                array(
                    'headers' => $headers,
                    'json'    => $request_body,
                )
            );
            return json_decode($response->getBody()->getContents(), true);
        } catch (BadResponseException $e) {
            // handle exception or api errors.
            throw $e;
        }
    }

    function statusQuery($id)
    {
        $headers = array(
            'Content-Type' => 'application/json',
            'X-Country' => $this->country,
            'X-Currency' => $this->currency,
            'Authorization'  =>  "Bearer {$this->token}",
        );
        // Define array of request body.
        $request_body = array();
        try {
            $response = $this->client->request(
                'GET',
                "/standard/v1/payments/{$id}",
                array(
                    'headers' => $headers,
                    'json' => $request_body,
                )
            );

            return json_decode($response->getBody()->getContents(), true);
        } catch (BadResponseException $e) {
            // handle exception or api errors.
            throw $e;
        }
    }

    function reconcile($payload, $callback = null)
    {
        $data = json_decode($payload, true);
        return is_null($callback)
            ? $data['transaction']
            : call_user_func_array($callback, $data['transaction']);
    }
}
