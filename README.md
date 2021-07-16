# Airtel Money API PHP SDK
Airtel Money API PHP SDK

## Installation
```bash
composer require osenco/airtel
```

## Collection APIs
### Instantiate
```php
use Osen\Airtel\Collection as CollectAPI;

CollectAPI::init(
    array(
        'env'           => 'live',
        'client_id'     => 'YOUR_CLIENT_ID',
        'client_secret' => 'YOUR_CLIENT_SECRET',
        'public_key'    => 'YOUR_PUBLIC_KEY',
        'country'       => 'Transaction Country Code e.g KE',
        'currency'      => 'Transaction Currency Code e.g KES'
    )
);
```

### STK/USSD Push
```php
CollectAPI::authorize()->stkPush($phone, $amount);
```

Note : Do not send country code in phone number.

You can pass a token to the authorize method if you have a caching mechanism instead of creating a new one each time. You can pass a second argument that is a callback function that updates your token

```php
$token = ''; // Get your token from database, redis or whichever cache you use.
Collection::authorize($token, function($new_token) {
    print_r($new_token);
    // Save/update $new_token in your database
})->stkPush($phone, $amount);
```

## Disbursement APIs
```php
use Osen\Airtel\Disbursement as DisburseAPI;

DisburseAPI::init(
    array(
        'env'           => 'live',
        'client_id'     => 'YOUR_CLIENT_ID',
        'client_secret' => 'YOUR_CLIENT_SECRET',
        'public_key'    => 'YOUR_PUBLIC_KEY',
        'country'       => 'Transaction Country Code e.g KE',
        'currency'      => 'Transaction Currency Code e.g KES'
    )
);
```

Then send the money
```php
DisburseAPI::authorize()->send($phone, $amount);
```