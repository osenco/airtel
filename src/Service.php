<?php

namespace Osen\Airtel;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;

class Service
{
    public string $client_id;
    public string $client_secret;
    protected Client $client;
    protected string $token;
    protected string $country    = 'KE';
    protected string $currency   = 'KES';
    protected string $pin        = '';
    protected string $public_key = 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCkq3XbDI1s8Lu7SpUBP+bqOs/MC6PKWz
    6n/0UkqTiOZqKqaoZClI3BUDTrSIJsrN1Qx7ivBzsaAYfsB0CygSSWay4iyUcnMVEDrNVO
    JwtWvHxpyWJC5RfKBrweW9b8klFa/CfKRtkK730apy0Kxjg+7fF0tB4O3Ic9Gxuv4pFkbQ
    IDAQAB';

    /**
     * @param array $options Config options
     */
    public function __construct(array $options = [])
    {
        $this->client_id     = $options['client_id'];
        $this->client_secret = $options['client_secret'];
        $this->public_key    = $options['public_key'];
        $this->country       = $options['country'];
        $this->currency      = $options['currency'];
        $this->client        = new Client(
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
     * @return $this
     */
    public function authorize($token = null, callable $callback = null)
    {
        if (is_null($token)) {
            try {
                $response = $this->client->request(
                    'POST',
                    '/auth/oauth2/token',
                    array(
                        'headers' => array(
                            'Content-Type' => 'application/json',
                        ),
                        'json'    => array(
                            'client_id'     => $this->client_id,
                            'client_secret' => $this->client_secret,
                            'grant_type'    => 'client_credentials',
                        ),
                    )
                );

                $response = $response->getBody()->getContents();
                $data = json_decode($response, true);
                $this->token = $data['access_token'];
            } catch (BadResponseException $e) {
                throw $e;
            } catch (Exception $e) {
                throw $e;
            }
        } else {
            $this->token = $token;
        }

        if (!is_null($callback)) {
            $callback($this->token);
        }

        return $this;
    }

    public function encrypt($data)
    {
        // Load public key
        $publicKey = openssl_pkey_get_public(array($this->public_key, ''));
        if (!$publicKey) {
            echo 'Public key NOT Correct';
        }
        if (!openssl_public_encrypt($data, $encrypted, $publicKey)) {
            echo 'Error encrypting with public key';
        }

        return base64_encode($encrypted);
    }

    public function setPin($data)
    {
        $this->pin = $this->encrypt($data);

        return $this;
    }

    public function userEnquiry($phone)
    {
        $headers = array(
            'Content-Type'  => 'application/json',
            'X-Country'     => $this->country,
            'X-Currency'    => $this->currency,
            'Authorization' => 'Bearer ' . $this->token,
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
            throw $e;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
