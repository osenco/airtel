<?php

namespace Osen\Airtel;

use GuzzleHttp\Exception\BadResponseException;

class Collection extends Service
{
    public function __construct(array $config)
    {
        parent::__construct($config);
    }

    public function ussdPush($amount, $phone, $id = null, $reference = null, $currency = null, $country = null, $callback = null)
    {
        try {
            $response = $this->client->request(
                'POST',
                '/merchant/v1/payments/',
                array(
                    'headers' =>array(
                        'Content-Type'  => 'application/json',
                        'X-Country'     => $this->country,
                        'X-Currency'    => $this->currency,
                        'Authorization' => 'Bearer ' . $this->token,
                    ),
                    'json'    => array(
                        'reference'   => is_null($reference) ? random_bytes(8) : $reference,
                        'subscriber'  => array(
                            'country'  => is_null($country) ? $this->country : $country,
                            'currency' => is_null($currency) ? $this->currency : $currency,
                            'msisdn'   => $phone,
                        ),
                        'transaction' => array(
                            'amount'   => $amount,
                            'country'  => is_null($country) ? $this->country : $country,
                            'currency' => is_null($currency) ? $this->currency : $currency,
                            'id'       => is_null($id) ? random_bytes(8) : $id,
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
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function refund($id, $country = null, $currency = null, $callback = null)
    {
        try {
            $response = $this->client->request(
                'POST',
                '/standard/v1/payments/refund',
                array(
                    'headers' => array(
                        'Content-Type'  => 'application/json',
                        'X-Country'     => is_null($country) ? $this->country : $country,
                        'X-Currency'    => is_null($currency) ? $this->currency : $currency,
                        'Authorization' => 'Bearer ' . $this->token,
                    ),
                    'json'    => array(
                        'transaction' => array(
                            'airtel_money_id' => $id,
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
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function statusQuery($id, $country = null, $currency = null, $callback = null)
    {
        try {
            $response = $this->client->request(
                'GET',
                '/standard/v1/payments/{$id}',
                array(
                    'headers' => array(
                        'Content-Type'  => 'application/json',
                        'X-Country'     => is_null($country) ? $this->country : $country,
                        'X-Currency'    => is_null($currency) ? $this->currency : $currency,
                        'Authorization' => 'Bearer ' . $this->token,
                    ),
                    'json'    => array(
                        'transaction' => array(
                            'airtel_money_id' => $id,
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
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function reconcile($payload, $callback = null)
    {
        $data = json_decode($payload, true);
        return is_null($callback)
            ? $data['transaction']
            : call_user_func_array($callback, $data['transaction']);
    }
}
