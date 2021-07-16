<?php

namespace Osen\Airtel;

use GuzzleHttp\Exception\BadResponseException;

class Remittance extends Service
{
    function checkEligible()
    {
        $headers = array(
            'Content-Type' => 'application/json',
            'Authorization'  =>  'Bearer  UCLcp1oeq44KPXr8X*******xCzki2w',
        );
        // Define array of request body.
        $request_body = array();
        try {
            $response = self::$client->request(
                'POST',
                '/openapiuat.airtel.africa/openapi/moneytransfer/v2/validate',
                array(
                    'headers' => $headers,
                    'json' => $request_body,
                )
            );
            print_r($response->getBody()->getContents());
        } catch (BadResponseException $e) {
            // handle exception or api errors.
            print_r($e->getMessage());
        }
    }

    public function transferCredit()
    {
        $headers = array(
            'Content-Type'  => 'application/json',
            'Authorization' => 'Bearer '.self::$token,
        );
        // Define array of request body.
        $request_body = array(
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
            $response = self::$client->request(
                'POST',
                '/openapiuat.airtel.africa/openapi/moneytransfer/v2/credit',
                array(
                    'headers' => $headers,
                    'json' => $request_body,
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
            'Authorization' => 'Bearer '.self::$token,
        );
        // Define array of request body.
        $request_body = array(
            'channelName' => 'M******Y',
            'country' => 'KENYA',
            'txnID' => '************',
            'pin' => 'KYJExln8rZwb14G1K5UE5YF/lD7KheNUM171MUEG3/f/QD8nmNKRsa44UZkh6A4cR8*'
        );

        try {
            $response = self::$client->request(
                'POST',
                '/openapiuat.airtel.africa/openapi/moneytransfer/v2/refund',
                array(
                    'headers' => $headers,
                    'json' => $request_body,
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
            'Content-Type'        => 'application/json',
            'Authorization' => 'Bearer '.self::$token,
        );

        // Define array of request body.
        $request_body = array();
        try {
            $response = self::$client->request(
                'POST',
                '/openapiuat.airtel.africa/openapi/moneytransfer/v2/checkstatus',
                array(
                    'headers' => $headers,
                    'json' => $request_body,
                )
            );
            print_r($response->getBody()->getContents());
        } catch (BadResponseException $e) {
            // handle exception or api errors.
            print_r($e->getMessage());
        }
    }
}
