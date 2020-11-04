[![Build Status](https://travis-ci.org/ssitdikov/ATOL.svg?branch=master)](https://travis-ci.org/ssitdikov/ATOL)
[![Coverage Status](https://coveralls.io/repos/github/ssitdikov/ATOL/badge.svg?branch=master)](https://coveralls.io/github/ssitdikov/ATOL?branch=master)
[![codecov](https://codecov.io/gh/ssitdikov/ATOL/branch/master/graph/badge.svg)](https://codecov.io/gh/ssitdikov/ATOL)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/edfd60d8d87347d29872c19be7a0401a)](https://www.codacy.com/app/sitsalavat/ATOL?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=ssitdikov/ATOL&amp;utm_campaign=Badge_Grade)

# АТОЛ Онлайн

## О проекте
Данная библиотека предназначена для работы с сервисом [АТОЛ Онлайн](https://online.atol.ru).

## Установка
Предполагается установка с использованием composer
```
composer require ssitdikov/atol
```

## Пример использования
### Запрос токена
```php
$client = new ApiClient();

try {
    /**
     * @var TokenResponse $token
     */
    $token = $client->getToken(
        new TokenRequest('login', 'password')
    );
} catch (\Exception $e) {
// smth with exception
}

```

### Операция продажи
```php

//... $token = $client->getToken();
try {
    $uuid = '00001/11-2017'; // Уникальный id заказа
    $groupId = 'GroupId'; // Выдается АТОЛ
    
    $itemA = new Item('Товар 1', 1200.50, 1, Vat::TAX_NONE);
    $itemB = new Item('Товар 2', 3200.50, 1, Vat::TAX_NONE);
    
    $paymentElectr = new Payment(Payment::PAYMENT_TYPE_ELECTR, 4400.00);
    $paymentCredit = new Payment(Payment::PAYMENT_TYPE_CREDIT, 1.00);
    
    $receipt = new Receipt();
    $receipt->setSno(ReceiptSno::RECEIPT_SNO_USN_INCOME)
        ->setItems([$itemA, $itemB])
        ->setPhone('9170123456')
        ->setEmail('test@email.com')
        ->setPayments([$paymentElectr, $paymentCredit]);
    
    $inn = '1111111111'; // Ваш ИНН
    $payment_address = 'test.mystore.dev'; // Адрес вашего сайта
    $callback_url = 'http://test.mystore.dev/callback/api/url';
    
    $info = new Info($inn, $payment_address, $callback_url);

    /**
    * @var OperationResponse $operation
    */
    $operation = $client->doOperation(
        new OperationRequest($groupId, OperationRequest::OPERATION_SELL, $uuid, $receipt, $info, $token)
    );
    
    $uuidAtol = $operation->getUuid(); // Получаем уникальный идентификатор uuid из системы АТОЛ
} catch (\Exception $e) {
// smth with exception
}
```

### Получить отчет по операции
```php
//... $token = $client->getToken();
//... $uuidAtol = $operation->getUuid();
try {
    $groupId = 'GroupId'; // Выдается АТОЛ
    $report = $client->getReport(
        new ReportRequest($groupId, $uuidAtol, $token)
    );
} catch (\Exception $e) {
// smth with exception
}
```