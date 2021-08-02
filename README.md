# Airtel Money API PHP SDK
Airtel Money API PHP SDK

## Installation
```bash
composer require osenco/airtel
```

## Collection APIs
### Instantiate
```php
use Osen\Airtel\Collection;

$collectAPI = new Collection(
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
$collectAPI->authorize()->ussdPush($phone, $amount);
```

Note : Do not send country code in phone number.

You can pass a token to the authorize method if you have a caching mechanism instead of creating a new one each time. You can pass a second argument that is a callback function that updates your token

```php
$token = ''; // Get your token from database, redis or whichever cache you use.
$collectAPI->authorize($token, function($newToken) {
    print($newToken);
    // Save/update $newToken in your database
})->ussdPush($phone, $amount);
```

## Disbursement APIs
```php
use Osen\Airtel\Disbursement;

$disburseAPI = new Disbursement(
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
$disburseAPI->authorize()->send($phone, $amount);
```