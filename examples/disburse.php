<?php
use Osen\Airtel\Disbursement;

$DisburseAPI =  new Disbursement(
    array(
        'env'           => 'live',
        'client_id'     => 'YOUR_CLIENT_ID',
        'client_secret' => 'YOUR_CLIENT_SECRET',
        'public_key'    => 'YOUR_PUBLIC_KEY',
        'country'       => 'Transaction Country Code e.g KE',
        'currency'      => 'Transaction Currency Code e.g KES'
    )
);

$DisburseAPI->authorize()->send($phone, $amount);