<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.11.17
 * Time: 6:29
 */

namespace SSitdikov\ATOL\Tests;

use PHPUnit\Framework\TestCase;
use SSitdikov\ATOL\Exception\ErrorException;
use SSitdikov\ATOL\Exception\ErrorGroupCodeToTokenException;
use SSitdikov\ATOL\Exception\ErrorIncomingBadRequestException;
use SSitdikov\ATOL\Exception\ErrorIncomingExistExternalIdException;
use SSitdikov\ATOL\Exception\ErrorIncomingExpiredTokenException;
use SSitdikov\ATOL\Exception\ErrorIncomingMissingTokenException;
use SSitdikov\ATOL\Exception\ErrorIncomingNotExistTokenException;
use SSitdikov\ATOL\Exception\ErrorIncomingOperationNotSupportException;
use SSitdikov\ATOL\Exception\ErrorIsNullExternalIdException;
use SSitdikov\ATOL\Object\Correction;
use SSitdikov\ATOL\Object\Info;
use SSitdikov\ATOL\Object\Item;
use SSitdikov\ATOL\Object\Payment;
use SSitdikov\ATOL\Object\ReceiptSno;
use SSitdikov\ATOL\Request\CorrectionRequest;
use SSitdikov\ATOL\Request\RequestInterface;
use SSitdikov\ATOL\Response\TokenResponse;

class CorrectionRequestTest extends TestCase
{

    /**
     * @test
     */
    public function newPayment()
    {
        $payment = new Payment(Payment::PAYMENT_TYPE_CASH, 3600);

        $this->assertEquals(3600, $payment->getSum());
        $this->assertEquals(Payment::PAYMENT_TYPE_CASH, $payment->getType());
        $this->assertJson('{"sum":3600, "type": 0}', $payment->jsonSerialize());

        return $payment;
    }

    /**
     * @test
     * @depends newPayment
     */
    public function newCorrection(Payment $payment)
    {
        $correction = new Correction();
        $correction->setSno(ReceiptSno::RECEIPT_SNO_USN_INCOME);
        $correction->setPayments([$payment]);
        $correction->setTax(Item::TAX_NONE);

        $this->assertEquals(ReceiptSno::RECEIPT_SNO_USN_INCOME,
            $correction->getSno());
        $this->assertEquals(Item::TAX_NONE, $correction->getTax());
        $this->assertEquals([$payment], $correction->getPayments());
        $this->assertEquals([
            'attributes' => [
                'sno' => ReceiptSno::RECEIPT_SNO_USN_INCOME,
                'tax' => Item::TAX_NONE,
                'payments' => [$payment],
            ],
        ], $correction->jsonSerialize());

        $correction->addPayment($payment);
        $this->assertEquals([$payment, $payment], $correction->getPayments());

        return $correction;
    }

    /**
     * @test
     * @depends newCorrection
     */
    public function doCorrection(Correction $correction)
    {
        $groupId = 'test';
        $uuid = rand(1, 100);
        $operationType = CorrectionRequest::OPERATION_SELL_CORRECTION;
        $token = new TokenResponse(\json_decode('{"text":"", "code":"0", "token":"token"}'));

        $inn = '1111111111';
        $payment_address = 'test.mystore.dev';
        $callback_url = 'http://test.mystore.dev/callback/api/url';
        $info = new Info($inn, $payment_address, $callback_url);

        $request = new CorrectionRequest($groupId, $operationType, $uuid,
            $correction, $info, $token);

        $this->assertEquals(RequestInterface::POST, $request->getMethod());
        $this->assertEquals($groupId.'/'.$operationType.'?tokenid='.$token->getToken(),
            $request->getUrl());
        /**
         * @todo Возможно будет возникать ошибка с timestamp
         */
        $this->assertEquals([
            'json' => [
                'timestamp' => date('d.m.Y H:i:s'),
                'external_id' => $uuid,
                'service' => $info,
                'correction' => $correction,
            ],
        ], $request->getParams());

        return $request;

    }

    /**
     * @test
     * @depends doCorrection
     */
    public function getSuccessResponse(CorrectionRequest $request)
    {
        $uuid = md5(time());
        $timestamp = date('Y-m-d H:i:s');
        $status = 'wait';

        $response = \json_decode(
            '{"uuid":"'.$uuid.'", "error":null, "status":"'.$status.'", "timestamp":"'.$timestamp.'"}'
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

    /**
     * @test
     * @depends doCorrection
     */
    public function getError(CorrectionRequest $request)
    {
        $uuid = md5(time());
        $timestamp = date('Y-m-d H:i:s');
        $status = 'fail';

        $response = \json_decode(
            '{"uuid":"'.$uuid.'", "error": {"code":"1", "text":"", "type":""} , ' .
            '"status":"'.$status.'", "timestamp":"'.$timestamp.'"}'
        );

        $this->expectException(ErrorException::class);
        $request->getResponse($response);
    }

    /**
     * @test
     * @depends doCorrection
     */
    public function getErrorIncomingBadRequest(CorrectionRequest $request)
    {
        $uuid = md5(time());
        $timestamp = date('Y-m-d H:i:s');
        $status = 'fail';

        $response = \json_decode(
            '{"uuid":"'.$uuid.'", "error": {"code":"2", "text":"", "type":""} , "status":"'.$status.
            '", "timestamp":"'.$timestamp.'"}'
        );

        $this->expectException(ErrorIncomingBadRequestException::class);
        $request->getResponse($response);
    }

    /**
     * @test
     * @depends doCorrection
     */
    public function getErrorIncomingOperationNotSupport(
        CorrectionRequest $request
    ) {
        $uuid = md5(time());
        $timestamp = date('Y-m-d H:i:s');
        $status = 'fail';

        $response = \json_decode(
            '{"uuid":"'.$uuid.'", "error": {"code":"3", "text":"", "type":""} , "status":"'.$status.
            '", "timestamp":"'.$timestamp.'"}'
        );

        $this->expectException(ErrorIncomingOperationNotSupportException::class);
        $request->getResponse($response);
    }

    /**
     * @test
     * @depends doCorrection
     */
    public function getErrorIncomingMissingToken(CorrectionRequest $request)
    {
        $uuid = md5(time());
        $timestamp = date('Y-m-d H:i:s');
        $status = 'fail';

        $response = \json_decode(
            '{"uuid":"'.$uuid.'", "error": {"code":"4", "text":"", "type":""} , "status":"'.$status.'", "timestamp":"'.$timestamp.'"}'
        );

        $this->expectException(ErrorIncomingMissingTokenException::class);
        $request->getResponse($response);
    }

    /**
     * @test
     * @depends doCorrection
     */
    public function getErrorIncomingNotExistToken(CorrectionRequest $request)
    {
        $uuid = md5(time());
        $timestamp = date('Y-m-d H:i:s');
        $status = 'fail';

        $response = \json_decode(
            '{"uuid":"'.$uuid.'", "error": {"code":"5", "text":"", "type":""} , "status":"'.$status.'", "timestamp":"'.$timestamp.'"}'
        );

        $this->expectException(ErrorIncomingNotExistTokenException::class);
        $request->getResponse($response);
    }

    /**
     * @test
     * @depends doCorrection
     */
    public function getErrorIncomingExpiredToken(CorrectionRequest $request)
    {
        $uuid = md5(time());
        $timestamp = date('Y-m-d H:i:s');
        $status = 'fail';

        $response = \json_decode(
            '{"uuid":"'.$uuid.'", "error": {"code":"6", "text":"", "type":""} , "status":"'.$status.'", "timestamp":"'.$timestamp.'"}'
        );

        $this->expectException(ErrorIncomingExpiredTokenException::class);
        $request->getResponse($response);
    }

    /**
     * @test
     * @depends doCorrection
     */
    public function getErrorIncomingExistExternalId(CorrectionRequest $request)
    {
        $uuid = md5(time());
        $timestamp = date('Y-m-d H:i:s');
        $status = 'fail';

        $response = \json_decode(
            '{"uuid":"'.$uuid.'", "error": {"code":"10", "text":"", "type":""} , "status":"'.$status.'", "timestamp":"'.$timestamp.'"}'
        );

        $this->expectException(ErrorIncomingExistExternalIdException::class);
        $request->getResponse($response);
    }

    /**
     * @test
     * @depends doCorrection
     */
    public function getErrorGroupCodeToToken(CorrectionRequest $request)
    {
        $uuid = md5(time());
        $timestamp = date('Y-m-d H:i:s');
        $status = 'fail';

        $response = \json_decode(
            '{"uuid":"'.$uuid.'", "error": {"code":"22", "text":"", "type":""} , "status":"'.$status.'", "timestamp":"'.$timestamp.'"}'
        );

        $this->expectException(ErrorGroupCodeToTokenException::class);
        $request->getResponse($response);
    }

    /**
     * @test
     * @depends doCorrection
     */
    public function getErrorIsNullExternalId(CorrectionRequest $request)
    {
        $uuid = md5(time());
        $timestamp = date('Y-m-d H:i:s');
        $status = 'fail';

        $response = \json_decode(
            '{"uuid":"'.$uuid.'", "error": {"code":"23", "text":"", "type":""} , "status":"'.$status.'", "timestamp":"'.$timestamp.'"}'
        );

        $this->expectException(ErrorIsNullExternalIdException::class);
        $request->getResponse($response);
    }

    /**
     * @test
     * @depends doCorrection
     */
    public function getException(CorrectionRequest $request)
    {
        $uuid = md5(time());
        $timestamp = date('Y-m-d H:i:s');
        $status = 'fail';

        $response = \json_decode(
            '{"uuid":"'.$uuid.'", "error": {"code":"400", "text":"", "type":""} , "status":"'.$status.'", "timestamp":"'.$timestamp.'"}'
        );

        $this->expectException(\Exception::class);
        $request->getResponse($response);
    }
}
