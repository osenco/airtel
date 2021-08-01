<?php

namespace Osen\Airtel;

use GuzzleHttp\Exception\BadResponseException;
use Osen\Airtel\Factories\Product;

class Remittance extends Service implements Product
{
    public function __construct(array $config)
    {
        parent::__construct($config);
    }

    function checkEligibility($phone, $callback = null)
    {
        $headers = array(
            'Content-Type' => 'application/json',
            'Authorization'  =>  'Bearer  UCLcp1oeq44KPXr8X*******xCzki2w',
        );
        // Define array of request body.
        $payload = array();
        try {
            $response = $this->client->request(
                'POST',
                '/openapiuat.airtel.africa/openapi/moneytransfer/v2/validate',
                array(
                    'headers' => $headers,
                    'json' => $payload,
                )
            );

            $response = $response->getBody()->getContents();
            $result   = json_decode($response, true);

            return is_null($callback) ? $result : $callback($result);
        } catch (BadResponseException $e) {
            // handle exception or api errors.
            print_r($e->getMessage());
        }
    }

    public function transferCredit($callback = null)
    {
        $headers = array(
            'Content-Type'  => 'application/json',
            'Authorization' => 'Bearer '.$this->token,
        );
        // Define array of request body.
        $payload = array(
            'amount' => 10,
            'channelName' => 'M******Y',
            'country' => 'KENYA',
            'currency' => 'KES',
            'extTRID' => 'random-txn-id',
            'msisdn' => '98*****21',
            'mtcn' => '5**21',
            'payerCountry' => 'MG',
            'payerFirstName' => 'Bob',
            'payerLastName' => 'Builder',
            'pin' => 'KYJExln8rZwb14G1K5UE5YF/lD7KheNUM171MUEG3/f/QD8nmNKRsa44UZkh6A4cR8****'
        );

        try {
            $response = $this->client->request(
                'POST',
                '/openapiuat.airtel.africa/openapi/moneytransfer/v2/credit',
                array(
                    'headers' => $headers,
                    'json' => $payload,
                )
            );

            $response = $response->getBody()->getContents();
            $result   = json_decode($response, true);

            return is_null($callback) ? $result : $callback($result);
        } catch (BadResponseException $e) {
            // handle exception or api errors.
            print_r($e->getMessage());
        }
    }

    public function send($callback = null)
    {
        $headers = array(
            'Content-Type'  => 'application/json',
            'Authorization' => 'Bearer '.$this->token,
        );
        // Define array of request body.
        $payload = array(
            'channelName' => 'M******Y',
            'country' => 'KENYA',
            'txnID' => '************',
            'pin' => 'KYJExln8rZwb14G1K5UE5YF/lD7KheNUM171MUEG3/f/QD8nmNKRsa44UZkh6A4cR8*'
        );

        try {
            $response = $this->client->request(
                'POST',
                '/openapiuat.airtel.africa/openapi/moneytransfer/v2/refund',
                array(
                    'headers' => $headers,
                    'json' => $payload,
                )
            );

            $response = $response->getBody()->getContents();
            $result   = json_decode($response, true);

            return is_null($callback) ? $result : $callback($result);
        } catch (BadResponseException $e) {
            // handle exception or api errors.
            print_r($e->getMessage());
        }
    }

    public function refund($callback = null)
    {
        $headers = array(
            'Content-Type'  => 'application/json',
            'Authorization' => 'Bearer '.$this->token,
        );
        // Define array of request body.
        $payload = array(
            'channelName' => 'M******Y',
            'country' => 'KENYA',
            'txnID' => '************',
            'pin' => 'KYJExln8rZwb14G1K5UE5YF/lD7KheNUM171MUEG3/f/QD8nmNKRsa44UZkh6A4cR8*'
        );

        try {
            $response = $this->client->request(
                'POST',
                '/openapiuat.airtel.africa/openapi/moneytransfer/v2/refund',
                array(
                    'headers' => $headers,
                    'json' => $payload,
                )
            );

            $response = $response->getBody()->getContents();
            $result   = json_decode($response, true);

            return is_null($callback) ? $result : $callback($result);
        } catch (BadResponseException $e) {
            // handle exception or api errors.
            print_r($e->getMessage());
        }
    }

    public function statusQuery($id, $callback = null)
    {
        $headers = array(
            'Content-Type'        => 'application/json',
            'Authorization' => 'Bearer '.$this->token,
        );

        // Define array of request body.
        $payload = array();
        try {
            $response = $this->client->request(
                'POST',
                '/openapiuat.airtel.africa/openapi/moneytransfer/v2/checkstatus',
                array(
                    'headers' => $headers,
                    'json' => $payload,
                )
            );

            $response = $response->getBody()->getContents();
            $result   = json_decode($response, true);

            return is_null($callback) ? $result : $callback($result);
        } catch (BadResponseException $e) {
            // handle exception or api errors.
            print_r($e->getMessage());
        }
    }
}
