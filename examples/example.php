<?php

use \SSitdikov\ATOL\Client\ApiClient;
use \SSitdikov\ATOL\Response\{OperationResponse, TokenResponse, ReportResponse};
use \SSitdikov\ATOL\Request\{TokenRequest, OperationRequest, ReportRequest};
use \SSitdikov\ATOL\Object\{Info, Item, Payment, Receipt, ReceiptSno};

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

        $itemA = new Item('Товар 1', 1200.50, 1, Item::TAX_NONE);
        $itemB = new Item('Товар 2', 3200.50, 1, Item::TAX_NONE);

        $paymentElectr = new Payment(Payment::PAYMENT_TYPE_ELECTR, 4400.00);
        $paymentCredit = new Payment(Payment::PAYMENT_TYPE_CREDIT, 1.00);

        $receipt = new Receipt();
        $receipt->setSno(ReceiptSno::RECEIPT_SNO_USN_INCOME)
            ->setItems([$itemA, $itemB])
            ->setPhone('9170123456')
            ->setEmail('test@email.com')
            ->setPayments([$paymentElectr, $paymentCredit]);

        $inn = '1111111111';
        $payment_address = 'test.mystore.dev';
        $callback_url = 'http://test.mystore.dev/callback/api/url';

        $info = new Info($inn, $payment_address, $callback_url);

        /**
         * @var OperationResponse $operation
         */
        $operation = $client->doOperation(
            new OperationRequest($groupId, OperationRequest::OPERATION_SELL, $uuid, $receipt, $info, $token)
        );

        $uuidAtol = $operation->getUuid();
        sleep(10);

        try {
            $report = $client->getReport(
                new ReportRequest($groupId, $uuidAtol, $token)
            );
        } catch (\Exception $e) {
            print $e->getMessage();
        }
    } catch (\Exception $e) {
        print $e->getMessage() . PHP_EOL;
    }
} catch (\Exception $e) {
    print $e->getMessage();
}
