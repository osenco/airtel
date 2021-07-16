<?php

namespace Osen\Airtel;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;

class Service
{
    public static string $client_id;
    public static string $client_secret;
    protected static Client $client;
    protected static string $token;
    protected static string $country    = 'KE';
    protected static string $currency   = 'KES';
    protected static string $pin        = '';
    protected static string $public_key = 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCkq3XbDI1s8Lu7SpUBP+bqOs/MC6PKWz
    6n/0UkqTiOZqKqaoZClI3BUDTrSIJsrN1Qx7ivBzsaAYfsB0CygSSWay4iyUcnMVEDrNVO
    JwtWvHxpyWJC5RfKBrweW9b8klFa/CfKRtkK730apy0Kxjg+7fF0tB4O3Ic9Gxuv4pFkbQ
    IDAQAB';

    /**
     * @param array $options Config options
     */
    public static function init(array $options = [])
    {
        self::$client_id     = $options['client_id'];
        self::$client_secret = $options['client_secret'];
        self::$public_key    = $options['public_key'];
        self::$country       = $options['country'];
        self::$currency      = $options['currency'];

        self::$client = new Client(
            array(
                'base_uri' => $options['env'] == 'staging'
                ? 'https://openapiuat.airtel.africa/'
                : 'https://openapi.airtel.africa/',
            )
        );
    }

    /**
     * Generate or refresh the access token
     * 
     * @param string $token
     * @param callable $callback
     * 
     * @return Service
     */
    public static function authorize($token = null, callable $callback = null)
    {
        if (is_null($token)) {
            $headers = array(
                'Content-Type' => 'application/json',
            );

            // Define array of request body.
            $request_body = array(
                'client_id'     => self::$client_id,
                'client_secret' => self::$client_secret,
                'grant_type'    => 'client_credentials',
            );

            try {
                $response = self::$client->request(
                    'POST',
                    '/auth/oauth2/token',
                    array(
                        'headers' => $headers,
                        'json'    => $request_body,
                    )
                );
                $response = $response->getBody()->getContents();

                $data = json_decode($response, true);

                self::$token = $data['access_token'];
            } catch (BadResponseException $e) {
                // handle exception or api errors.
                throw $e;
            }
        } else {
            self::$token = $token;
        }

        if (!is_null($callback)) {
            $callback(self::$token);
        }

        return new self;
    }

    public function encrypt($data)
    {
        // Load public key
        $publicKey = openssl_pkey_get_public(array(self::$public_key, ''));
        if (!$publicKey) {
            echo 'Public key NOT Correct';
        }
        if (!openssl_public_encrypt($data, $encrypted, $publicKey)) {
            echo 'Error encrypting with public key';
        }

        return base64_encode($encrypted);
    }

    public function setPin($data) { 
        self::$pin = $this->encrypt($data);

        return $this;
    }

    public function userEnquiry($phone)
    {
        $headers = array(
            'Content-Type'  => 'application/json',
            'X-Country'     => self::$country,
            'X-Currency'    => self::$currency,
            'Authorization' => 'Bearer ' . self::$token,
        );

        // Define array of request body.
        $request_body = array();
        try {
            $response = self::$client->request(
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
