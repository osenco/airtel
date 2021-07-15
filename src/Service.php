<?php

namespace Osen\Airtel;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;

class Service
{
    public $client_id;
    public $client_secret;
    public Client $client;
    protected $public_key = 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCkq3XbDI1s8Lu7SpUBP+bqOs/MC6PKWz
    6n/0UkqTiOZqKqaoZClI3BUDTrSIJsrN1Qx7ivBzsaAYfsB0CygSSWay4iyUcnMVEDrNVO
    JwtWvHxpyWJC5RfKBrweW9b8klFa/CfKRtkK730apy0Kxjg+7fF0tB4O3Ic9Gxuv4pFkbQ
    IDAQAB';
    protected $token;
    protected $country = 'KE';
    protected $currency = 'KES';

    public function __construct(array $options = [])
    {
        $this->client_id = $options['client_id'];
        $this->client_secret = $options['client_secret'];
        $this->public_key = $options['public_key'];
        $this->country = $options['country'];
        $this->currency = $options['currency'];

        $this->client = new Client(
            array(
                'base_uri' => $options['env'] == 'staging'
                    ? 'https://openapiuat.airtel.africa/'
                    : 'https://openapi.airtel.africa/',
            )
        );
    }

    public function authorize($token = null)
    {
        if (!is_null($token)) {
            $this->token = $token;
        } else {
            $headers = array(
                'Content-Type' => 'application/json',
            );
            // Define array of request body.
            $request_body = array(
                "client_id"     => $this->client_id,
                "client_secret" => $this->client_secret,
                "grant_type"    => "client_credentials",
            );
            try {
                $response = $this->client->request(
                    'POST',
                    '/auth/oauth2/token',
                    array(
                        'headers' => $headers,
                        'json'    => $request_body,
                    )
                );
                $response = $response->getBody()->getContents();

                $data = json_decode($response, true);

                $this->token = $data['access_token'];
            } catch (BadResponseException $e) {
                // handle exception or api errors.
                throw $e;
            }
        }

        return $this;
    }

    public function encrypt($data)
    {
        // Load public key
        $publicKey = openssl_pkey_get_public(array($this->public_key, ""));
        if (!$publicKey) {
            echo "Public key NOT Correct";
        }
        if (!openssl_public_encrypt($data, $encrypted, $publicKey)) {
            echo "Error encrypting with public key";
        }

        return base64_encode($encrypted);
    }

    public function userEnquiry($phone)
    {
        $headers = array(
            'Content-Type'  => 'application/json',
            'X-Country'     => $this->country,
            'X-Currency'    => $this->currency,
            'Authorization' => "Bearer {$this->token}",
        );

        // Define array of request body.
        $request_body = array();
        try {
            $response = $this->client->request(
                'GET',
                "/standard/v1/users/{$phone}",
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
}
