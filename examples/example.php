<?php

use \SSitdikov\ATOL\Client\ApiClient;
use \SSitdikov\ATOL\Response\OperationResponse;
use \SSitdikov\ATOL\Response\TokenResponse;
use \SSitdikov\ATOL\Request\TokenRequest;
use \SSitdikov\ATOL\Request\OperationRequest;
use \SSitdikov\ATOL\Request\ReportRequest;
use \SSitdikov\ATOL\Object\Info;
use \SSitdikov\ATOL\Object\Item;
use \SSitdikov\ATOL\Object\Payment;
use \SSitdikov\ATOL\Object\Receipt;
use \SSitdikov\ATOL\Object\ReceiptSno;
use \SSitdikov\ATOL\Object\Vat;
use \SSitdikov\ATOL\Object\Company;
use \SSitdikov\ATOL\Object\Client;

require __DIR__ . '/../vendor/autoload.php';

$client = new ApiClient();

try {
    /**
     * @var TokenResponse $token
     */
    $token = $client->getToken(
        new TokenRequest('login', 'password')
    );

    try {
        $uuid = '00001/11-2017';
        $groupId = 'GroupId';

        // Позиции чека
        $itemA = new Item('Товар 1', 1200.50, 1, new Vat(Vat::TAX_NONE), Item::PAYMENT_OBJECT_COMMODITY, Item::PAYMENT_METHOD_FULL_PREPAYMENT);
        // Или так (по умолчанию будет установлено Item::PAYMENT_OBJECT_COMMODITY и  Item::PAYMENT_METHOD_FULL_PAYMENT)
        $itemB = new Item('Товар 2', 3200.50, 1, new Vat(Vat::TAX_NONE));
        $totalSum = 4401.00;

        // Виды оплат
        $paymentElectr = new Payment(Payment::PAYMENT_TYPE_ELECTR, 4400.00);
        $paymentCredit = new Payment(Payment::PAYMENT_TYPE_CREDIT, 1.00);

        // Налоги
        $vat = new Vat(Vat::TAX_VAT20, round($totalSum * 20 / 120, 2));

        // Организация
        $companyINN = '1111111111';
        // Адрес магазина
        // В случае мобильного приложения URL приложения в кабинете (см что указано в кабинете АТОЛ)
        $companyAddress = 'test.mystore.dev';
        $companyEmail = 'company@mail.ru';
        $company = new Company($companyINN, $companyAddress, $companyEmail, ReceiptSno::RECEIPT_SNO_OSN);

        // Покупатель
        $buyerEmail = 'buyer@mail.ru';
        $buyerPhone = '+79170123456';
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
        $info = new Info($callback_url);

        /**
         * @var OperationResponse $operation
         */
        $operation = $client->doOperation(
            new OperationRequest($groupId, OperationRequest::OPERATION_SELL, $uuid, $receipt, $info, $token)
        );

        // Идентификатор фискального чека
        $uuidAtol = $operation->getUuid();
        sleep(10);

        try {
            $report = $client->getReport(
                new ReportRequest($groupId, $uuidAtol, $token)
            );
        } catch (\Exception $e) {
            // ...
        }
    } catch (\Exception $e) {
        // ...
    }
} catch (\Exception $e) {
    // wrong user or password Exception
}
