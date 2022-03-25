[![Build Status](https://travis-ci.org/ssitdikov/ATOL.svg?branch=master)](https://travis-ci.org/ssitdikov/ATOL)
[![Coverage Status](https://coveralls.io/repos/github/ssitdikov/ATOL/badge.svg?branch=master)](https://coveralls.io/github/ssitdikov/ATOL?branch=master)
[![codecov](https://codecov.io/gh/ssitdikov/ATOL/branch/master/graph/badge.svg)](https://codecov.io/gh/ssitdikov/ATOL)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/edfd60d8d87347d29872c19be7a0401a)](https://www.codacy.com/app/sitsalavat/ATOL?utm_source=github.com&utm_medium=referral&utm_content=ssitdikov/ATOL&utm_campaign=Badge_Grade)

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
    $uuid = '00001/11-2017';
    $groupId = 'GroupId';

    // Позиции чека
    $itemA = new Item('Товар 1', 1200.50, 1, Vat::TAX_NONE);
    $itemB = new Item('Товар 2', 3200.50, 1, Vat::TAX_NONE);
    $totalSum = 4401.00;

    // Виды оплат
    $paymentElectr = new Payment(Payment::PAYMENT_TYPE_ELECTR, 4400.00);
    $paymentCredit = new Payment(Payment::PAYMENT_TYPE_CREDIT, 1.00);

    // Налоги
    $vat = new Vat(Vat::TAX_VAT20, round($totalSum * 20 / 120, 2));

    // Организация
    $companyINN = "1111111111";
    // Адрес магазина
    // В случае мобильного приложения URL приложения в кабинете (см что указано в кабинете АТОЛ)
    $companyAddress = "test.mystore.dev";
    $companyEmail = "company@mail.ru";
    $company = new Company($companyINN, $companyAddress, $companyEmail, ReceiptSno::RECEIPT_SNO_OSN);

    // Покупатель
    $buyerEmail = "buyer@mail.ru";
    $buyerPhone = "+79170123456";
    $buyer = new Client($buyerEmail, $buyerPhone);

    // Формирование чека
    $receipt = new Receipt();
    $receipt->setClient($buyer)
        ->setCompany($company)
        ->setItems([$itemA, $itemB])
        ->setVats([$vat])
        ->setPayments([$paymentElectr, $paymentCredit]);

    // Куда АТОЛу стучаться с результатом
    $callback_url = 'http://test.mystore.dev/callback/api/url';
    $info = new Info($inn, $payment_address, $callback_url);

    /**
     * @var OperationResponse $operation
     */
    $operation = $client->doOperation(
        new OperationRequest($groupId, OperationRequest::OPERATION_SELL, $uuid, $receipt, $info, $token)
    );

    // Идентификатор фискального чека
    $uuidAtol = $operation->getUuid();
} catch (\Exception $e) {
    // ...
}
```

### Операция продажи через агента и поставщика

```php

//... $token = $client->getToken();
try {
    $uuid = '00001/03-2022';
    $groupId = 'group_code';

    // Позиции чека
    $itemA = new Item('Товар 1', 1200.50, 1, Vat::TAX_NONE);
    $itemB = new Item('Товар 2', 3200.50, 1, Vat::TAX_NONE);
    $totalSum = 4401.00;

    // Виды оплат
    $paymentElectr = new Payment(Payment::PAYMENT_TYPE_ELECTR, 4400.00);
    $paymentCredit = new Payment(Payment::PAYMENT_TYPE_CREDIT, 1.00);

    // Налоги
    $vat = new Vat(Vat::TAX_VAT20, round($totalSum * 20 / 120, 2));

    // Заполнение данных по агенту

    // Атрибуты оператора перевода.
    $moneyTransferOperatorName = "ООО Оператор-Перевода";
    $moneyTransferOperatorPhones = ["+79170123456"];
    $moneyTransferOperatorAddress = "г. Москва";
    $moneyTransferOperatorINN = "3333333333";
    $moneyTransferOperator = new MoneyTransferOperator(
        $moneyTransferOperatorName,
        $moneyTransferOperatorPhones,
        $moneyTransferOperatorAddress,
        $moneyTransferOperatorINN
    );

    // Атрибуты оператора по приему платежей.
    $receivePaymentsOperatorPhones = ["+79170123456"];
    $receivePaymentsOperator = new ReceivePaymentsOperator($receivePaymentsOperatorPhones);

    // Атрибуты платежного агента.
    // Наименование операции. Максимальная длина строки – 24 символа.
    $payingAgentOperation = "ООО Агент";
    $payingAgentPhones = ["+79170123456"];
    $payingAgent = new PayingAgent($payingAgentOperation, $payingAgentPhones);

    // Атрибуты поставщика.
    // Обязателен если указывается AgentInfo
    $supplierInfoName = "ООО Поставщик";
    $supplierInfoPhones = ["+79170123456"];
    $supplierInfoINN = "2222222222";
    $supplierInfo = new SupplierInfo($supplierInfoName, $supplierInfoPhones, $supplierInfoINN);

    // Агент
    $agentInfo = new AgentInfo();
    $agentInfo->setType(AgentInfo::ANOTHER)
        ->setPayingAgent($payingAgent)
        ->setReceivePaymentsOperator($receivePaymentsOperator)
        ->setMoneyTransferOperator($moneyTransferOperator);

    // Организация
    $companyINN = "1111111111";
    // Адрес магазина
    // В случае мобильного приложения URL приложения в кабинете (см что указано в кабинете АТОЛ)
    $companyAddress = "test.mystore.dev";
    $companyEmail = "company@mail.ru";
    $company = new Company($companyINN, $companyAddress, $companyEmail, ReceiptSno::RECEIPT_SNO_OSN);

    // Покупатель
    $buyerEmail = "buyer@mail.ru";
    $buyerPhone = "+79170123456";
    $buyer = new Client($buyerEmail, $buyerPhone);

    // Важно! Агент применяется или ко всему чеку ИЛИ к позициям.
    // Если агент по предметам расчета, иначе смотри ниже
    $itemA->setAgentInfo($agentInfo);

    // Важно! Поставщик применяется или ко всему чеку ИЛИ к позициям.
    // Если поставщик по предметам расчета, иначе смотри ниже
    $itemA->setSupplierInfo($supplierInfo);

    // Чек
    $receipt = new Receipt();
    $receipt->setCompany($company)
        ->setClient($buyer)
        ->setItems([$itemA, $itemB])
        ->setPayments([$paymentElectr, $paymentCredit])
        ->setVats([$vat])
        // Если агент применяется ко всему чеку
        ->setAgentInfo($agentInfo)
        // Если поставщик применяется ко всему чеку
        ->setSupplierInfo($supplierInfo);

    // Куда АТОЛу стучаться с результатом
    $callbackUrl = 'http://test.mystore.dev/callback/api/url';
    $info = new Info($callbackUrl);

    /**
     * @var OperationResponse $operation
     */
    $operation = $client->doOperation(
        new OperationRequest($groupId, OperationRequest::OPERATION_SELL, $uuid, $receipt, $info, $token)
    );

    $uuidAtol = $operation->getUuid();
} catch (\Exception $e) {
    // ...
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
