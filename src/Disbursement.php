<?php

namespace Osen\Airtel;

use Exception;
use GuzzleHttp\Exception\BadResponseException;

class Disbursement extends Service
{
    public function __construct(array $config)
    {
        parent::__construct($config);
    }

    public function send($phone, $amount, $reference, $id = null, $currency = null, $country = null, $callback = null)
    {
        try {
            $response = $this->client->request(
                'POST',
                '/standard/v1/disbursements/',
                array(
                    'headers' => array(
                        'Content-Type'  => 'application/json',
                        'Accept'        => '*/*',
                        'X-Country'     => $country ?: $this->country,
                        'X-Currency'    => $currency ?: $this->currency,
                        'Authorization' => 'Bearer ' . $this->token,
                    ),
                    'json'    => array(
                        'payee'       => array(
                            'msisdn' => $phone,
                        ),
                        'reference'   => $reference,
                        'pin'         => $this->pin,
                        'transaction' => array(
                            'amount' => $amount,
                            'id'     => $id ?: random_bytes(8),
                        ),
                    ),
                )
            );

            $response = $response->getBody()->getContents();
            $result   = json_decode($response, true);

            return is_null($callback) ? $result : $callback($result);
        } catch (BadResponseException $e) {
            // handle exception or api errors.
            throw $e;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function refund($id, $callback = null)
    {
        try {
            $response = $this->client->request(
                'POST',
                '/standard/v1/disbursements/refund',
                array(
                    'headers' => array(
                        'Content-Type'  => 'application/json',
                        'Accept'        => '*/*',
                        'X-Country'     => $this->country,
                        'X-Currency'    => $this->currency,
                        'Authorization' => 'Bearer ' . $this->token,
                    ),
                    'json'    => array(),
                )
            );

            $response = $response->getBody()->getContents();
            $result   = json_decode($response, true);

            return is_null($callback) ? $result : $callback($result);
        } catch (BadResponseException $e) {
            // handle exception or api errors.
            throw $e;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function statusQuery($id, $callback = null)
    {   try {
            $response = $this->client->request(
                'GET',
                '/standard/v1/disbursements/{id}',
                array(
                    'headers' => array(
                        'Accept'        => '*/*',
                        'X-Country'     => $this->country,
                        'X-Currency'    => $this->currency,
                        'Authorization' => 'Bearer ' . $this->token,
                    ),
                    'json'    => array(),
                )
            );

            $response = $response->getBody()->getContents();
            $result   = json_decode($response, true);

            return is_null($callback) ? $result : $callback($result);
        } catch (BadResponseException $e) {
            // handle exception or api errors.
            throw $e;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
