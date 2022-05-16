<?php

namespace SSitdikov\ATOL\Tests;

use PHPUnit\Framework\TestCase;
use SSitdikov\ATOL\Object\Client;
use SSitdikov\ATOL\Object\Company;
use SSitdikov\ATOL\Object\Info;
use SSitdikov\ATOL\Object\Item;
use SSitdikov\ATOL\Object\Payment;
use SSitdikov\ATOL\Object\Receipt;
use SSitdikov\ATOL\Object\ReceiptSno;
use SSitdikov\ATOL\Object\Vat;
use SSitdikov\ATOL\Request\OperationRequest;
use SSitdikov\ATOL\Request\RequestInterface;
use SSitdikov\ATOL\Response\TokenResponse;

class OperationRequestTest extends TestCase
{

    /**
     * @test
     */
    public function newItem()
    {
        $title = 'Title';
        $price = 1200.00;
        $quantity = 3;
        $sum = $price * $quantity;
        $vat = new Vat(Vat::TAX_VAT120, round($sum * 20 / 120, 2));
        $payment_object = 'commodity';
        $payment_method = 'full_payment';
        $measurement_unit = 'шт.';

        $item = new Item($title, $price, $quantity, $vat);

        $this->assertEquals($title, $item->getName());
        $this->assertEquals($price, $item->getPrice());
        $this->assertEquals($quantity, $item->getQuantity());
        $this->assertEquals($sum, $item->getSum());
        $this->assertEquals($vat, $item->getVat());
        $this->assertEquals(
            [
                'name'             => $title,
                'price'            => $price,
                'quantity'         => $quantity,
                'sum'              => $sum,
                'vat'              => $vat,
                'payment_object'   => $payment_object,
                'payment_method'   => $payment_method,
                'measurement_unit' => $measurement_unit,
            ],
            $item->jsonSerialize()
        );


        return $item;
    }

    /**
     * @test
     */
    public function newPayment()
    {
        $payment = new Payment(Payment::PAYMENT_TYPE_CASH, 3600);

        $this->assertEquals(3600, $payment->getSum());
        $this->assertEquals(Payment::PAYMENT_TYPE_CASH, $payment->getType());
        $this->assertEquals(json_decode('{"sum":3600, "type": 0}', true), $payment->jsonSerialize());

        return $payment;
    }

    /**
     * @test
     * @depends newItem
     * @depends newPayment
     */
    public function newReceipt(Item $item, Payment $payment)
    {
        $this->assertEquals($item->getSum(), $payment->getSum());

        $email = 'test@test.ru';
        $phone = '1234567890';

        $client = new Client($email, $phone);

        $companyINN = "1111111111";
        $companyAddress = "test.mystore.dev";
        $companyEmail = "company@mail.ru";
        $company = new Company($companyINN, $companyAddress, $companyEmail, ReceiptSno::RECEIPT_SNO_USN_INCOME);

        $receipt = new Receipt();
        $receipt
            ->setClient($client)
            ->setCompany($company)
            ->setPayments([$payment])
            ->setItems([$item]);

        $this->assertEquals($email, $receipt->getClient()->getEmail());
        $this->assertEquals($phone, $receipt->getClient()->getPhone());

        $this->assertEquals($companyINN, $receipt->getCompany()->getInn());
        $this->assertEquals($companyAddress, $receipt->getCompany()->getPaymentAddress());
        $this->assertEquals($companyEmail, $receipt->getCompany()->getEmail());
        $this->assertEquals(
            ReceiptSno::RECEIPT_SNO_USN_INCOME,
            $receipt->getCompany()->getSno()
        );
        $this->assertEquals($item->getSum(), $receipt->getTotal());


        $this->assertEquals(
            [
                'client'   => $client,
                'company'  => $company,
                'items'    => [$item],
                'total'    => $payment->getSum(),
                'payments' => [$payment],
                'cashier ' => ''
            ],
            $receipt->jsonSerialize()
        );



        $receipt->addItem($item);
        $this->assertEquals([$item, $item], $receipt->getItems());

        $receipt->addPayment($payment);
        $this->assertEquals([$payment, $payment], $receipt->getPayments());

        return $receipt;
    }

    /**
     * @test
     */
    public function newInfo()
    {
        $callbackUrl = 'http://test.mystore.dev/callback/api/url';

        $info = new Info($callbackUrl);
        $this->assertEquals($callbackUrl, $info->getCallbackUrl());
        $this->assertJson(
            json_encode([
                'callbackUrl'     => $callbackUrl,
            ]),
            json_encode($info->jsonSerialize())
        );

        return $info;
    }

    /**
     * @test
     * @depends newReceipt
     * @depends newInfo
     */
    public function doOperation(Receipt $receipt, Info $info)
    {
        $groupId = 'test';
        $uuid = random_int(1, 100);
        $operationType = OperationRequest::OPERATION_SELL;
        $token = new TokenResponse(
            json_decode('{"error":null, "timestamp":"", "token": "' . md5($uuid) . '"}')
        );
        $operation = new OperationRequest(
            $groupId,
            $operationType,
            $uuid,
            $receipt,
            $info,
            $token
        );
        $this->assertEquals(RequestInterface::METHOD_POST, $operation->getMethod());
        $this->assertEquals(
            $groupId . '/' . $operationType . '?token=' . $token->getToken(),
            $operation->getUrl()
        );
        $this->assertEquals(
            [
                'json' => [
                    'external_id' => $uuid,
                    'receipt'     => $receipt,
                    'service'     => $info,
                    'timestamp'   => date('d.m.Y H:i:s'),
                ],
                'headers' => [
                    'Token' => $token->getToken(),
                ],
            ],
            $operation->getParams()
        );

        return $operation;
    }

    /**
     * @test
     * @depends doOperation
     */
    public function getSuccessResponse(OperationRequest $request)
    {
        $uuid = md5(time());
        $timestamp = date('Y-m-d H:i:s');
        $status = 'wait';

        $response = json_decode(
            '{"uuid":"' . $uuid . '", "error":null, "status":"' . $status . '", "timestamp":"' . $timestamp . '"}'
        );

        $this->assertEquals($uuid, $request->getResponse($response)->getUuid());
        $this->assertEquals(
            $status,
            $request->getResponse($response)->getStatus()
        );
        $this->assertEquals(
            $timestamp,
            $request->getResponse($response)->getTimestamp()
        );
        $this->isNull();
        $request->getResponse($response)->getError();
    }
}
