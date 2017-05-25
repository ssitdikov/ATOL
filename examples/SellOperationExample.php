<?php

require __DIR__ . '/../vendor/autoload.php';

$http = new \GuzzleHttp\Client([
    'base_uri' => 'https://online.atol.ru/possystem/v3/',
]);

$atol = new SSitdikov\ATOL\ApiClient($http);
$token = $atol->getToken(
    new \SSitdikov\ATOL\Request\GetTokenRequest('login', 'pass')
);

$item = new \SSitdikov\ATOL\Object\Item('Объект', 10, 1, \SSitdikov\ATOL\Object\Item::TAX_NONE);
$payment = new \SSitdikov\ATOL\Object\Payment(\SSitdikov\ATOL\Object\Payment::PAYMENT_TYPE_ELECTR, 10);

$receipt = new \SSitdikov\ATOL\Object\Receipt();
$receipt->addItem($item);
$receipt->addPayment($payment);
$receipt->setPhone('917123456');
$receipt->setEmail('example@gmail.com');

$info = new \SSitdikov\ATOL\Object\Info('1111111111', 'test1.atol.ru', '');

$sellOperationRequest = new \SSitdikov\ATOL\Request\SellOperationRequest('group_id', '1',
    $receipt, $info, $token);

$sell = $atol->sellOperation($sellOperationRequest);
echo $sell->getUuid();