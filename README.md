# Airtel Money API PHP SDK
Airtel Money API PHP SDK

## Installation
```bash
composer require osenco/airtel
```

## Collection APIs
### Instantiate
```php
$airtel = new \Osenco\Airtel\Collection(array(
    'username' => 'username',
));
```

### STK/USSD Push
```php
$airtel->authorize()->stkPush($phone, $amount);
```

## Disbursement APIs