<?php

require __DIR__ . '/../vendor/autoload.php';

$http = new \GuzzleHttp\Client([
    'base_uri' => 'https://online.atol.ru/possystem/v3/',
]);

$atol = new SSitdikov\ATOL\ApiClient($http);
$token = $atol->getToken(
    new \SSitdikov\ATOL\Request\GetTokenRequest('login', 'pass')
);