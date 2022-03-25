<?php

use \SSitdikov\ATOL\Client\ApiClient;
use \SSitdikov\ATOL\Response\{OperationResponse, TokenResponse, ReportResponse};
use \SSitdikov\ATOL\Request\{TokenRequest, OperationRequest, ReportRequest};
use \SSitdikov\ATOL\Object\{
    Info,
    Item,
    Payment,
    Receipt,
    ReceiptSno,
    Vat,
    AgentInfo,
    SupplierInfo,
    PayingAgent,
    MoneyTransferOperator,
    ReceivePaymentsOperator,
    Company,
    Client
};

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
