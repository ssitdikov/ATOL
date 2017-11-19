<?php

namespace SSitdikov\ATOL\Tests;

use SSitdikov\ATOL\Code\ErrorCode;
use SSitdikov\ATOL\Exception\ErrorIncomingBadRequestException;
use SSitdikov\ATOL\Exception\ErrorIncomingQueueException;
use SSitdikov\ATOL\Exception\ErrorIncomingQueueTimeoutException;
use SSitdikov\ATOL\Exception\ErrorIncomingValidationException;
use SSitdikov\ATOL\Exception\ErrorStateBadRequestException;
use SSitdikov\ATOL\Exception\ErrorStateExpiredTokenException;
use SSitdikov\ATOL\Exception\ErrorStateMissingTokenException;
use SSitdikov\ATOL\Exception\ErrorStateMissingUuidException;
use SSitdikov\ATOL\Exception\ErrorStateNotExistTokenException;
use SSitdikov\ATOL\Exception\ErrorStateNotFoundException;
use SSitdikov\ATOL\Request\ReportRequest;
use PHPUnit\Framework\TestCase;
use SSitdikov\ATOL\Request\RequestInterface;
use SSitdikov\ATOL\Response\PayloadResponse;
use SSitdikov\ATOL\Response\TokenResponse;

class ReportRequestTest extends TestCase
{

    /**
     * @test
     */
    public function getReport()
    {
        $groupId = 'test';
        $uuid = random_int(1000, 9999);
        $token = md5(time());
        $token = new TokenResponse(\json_decode('{"code":0, "text":"", "token":"' . $token . '"}'));
        $report = new ReportRequest($groupId, $uuid, $token);

        $this->assertEquals(RequestInterface::GET, $report->getMethod());
        $this->assertEquals($groupId . '/report/' . $uuid . '?tokenid=' . $token->getToken(), $report->getUrl());
        $this->assertEquals([], $report->getParams());

        return $report;
    }

    /**
     * @test
     * @depends getReport
     */
    public function getReportResponse(ReportRequest $request)
    {
        $uuid = md5(time());
        $timestamp = date('Y-m-d H:i:s');
        $total = 3660.43;
        $fnsSite = 'www.nalog.ru';
        $fnNumber = random_int(1, 100);
        $shiftNumber = random_int(1, 100);
        $receiptDatetime = date('Y-m-d H:i:s', strtotime('-' . rand(1, 5) . 'h'));
        $fiscalReceiptNumber = random_int(1, 100);
        $fiscalDocumentNumber = random_int(1, 100);
        $fiscalDocumentAttr = random_int(10000, 99999);
        $ecrRegistrationNum = random_int(11111, 99999);
        $groupCode = 'TestShop';
        $daemonCode = 'prod-agent-1';
        $deviceCode = 'TEST01-00-01';
        $callbackUrl = '';
        $json = '{
            "uuid":"' . $uuid . '",
            "error":null,
            "status":"done",
            "payload": {
                "total":"' . $total . '",
                "fns_site":"' . $fnsSite . '",
                "fn_number":"' . $fnNumber . '",
                "shift_number":"' . $shiftNumber . '",
                "receipt_datetime":"' . $receiptDatetime . '",
                "fiscal_receipt_number":"' . $fiscalReceiptNumber . '",
                "fiscal_document_number":"' . $fiscalDocumentNumber . '",
                "fiscal_document_attribute":"' . $fiscalDocumentAttr . '",
                "ecr_registration_number":"' . $ecrRegistrationNum . '"
             },
            "timestamp":"' . $timestamp . '",
            "group_code":"' . $groupCode . '",
            "daemon_code":"' . $daemonCode . '",
            "device_code":"' . $deviceCode . '",
            "callback_url":"' . $callbackUrl . '"
        }';
        $response = \json_decode($json);

        $this->assertEquals($timestamp, $request->getResponse($response)->getTimestamp());
        $this->assertEquals($uuid, $request->getResponse($response)->getUuid());
        $this->isNull($request->getResponse($response)->getError());
        $this->assertEquals('done', $request->getResponse($response)->getStatus());
        $this->assertEquals($total, $request->getResponse($response)->getPayload()->getTotal());
        $this->assertEquals($fnsSite, $request->getResponse($response)->getPayload()->getFnsSite());
        $this->assertEquals($fnNumber, $request->getResponse($response)->getPayload()->getFnNumber());
        $this->assertEquals($shiftNumber, $request->getResponse($response)->getPayload()->getShiftNumber());
        $this->assertEquals($receiptDatetime, $request->getResponse($response)->getPayload()->getReceiptDatetime());
        $this->assertEquals(
            $fiscalReceiptNumber,
            $request->getResponse($response)->getPayload()->getFiscalReceiptNumber()
        );
        $this->assertEquals(
            $fiscalDocumentNumber,
            $request->getResponse($response)->getPayload()->getFiscalDocumentNumber()
        );
        $this->assertEquals(
            $fiscalDocumentAttr,
            $request->getResponse($response)->getPayload()->getFiscalDocumentAttribute()
        );
        $this->assertEquals(
            $ecrRegistrationNum,
            $request->getResponse($response)->getPayload()->getEcrRegistrationNumber()
        );
        $this->assertEquals($timestamp, $request->getResponse($response)->getTimestamp());
        $this->assertEquals($groupCode, $request->getResponse($response)->getGroupCode());
        $this->assertEquals($daemonCode, $request->getResponse($response)->getDaemonCode());
        $this->assertEquals($deviceCode, $request->getResponse($response)->getDeviceCode());
        $this->assertEquals($callbackUrl, $request->getResponse($response)->getCallbackUrl());
    }

    /**
     * @test
     * @depends getReport
     */
    public function getErrorIncomingQueueTimeout($request)
    {
        $code = ErrorCode::ERROR_INCOMING_QUEUE_TIMEOUT;
        $response = \json_decode('{
            "uuid":"",
            "error":{
                "code": ' . $code . ',
                "text": "",
                "type": ""
            },
            "status":"fail",
            "payload":null,
            "timestamp":"",
            "callback_url":""
        }');

        $this->expectException(ErrorIncomingQueueTimeoutException::class);
        $request->getResponse($response);
    }

    /**
     * @test
     * @depends getReport
     */
    public function getErrorIncomingValidationException($request)
    {
        $code = ErrorCode::ERROR_INCOMING_VALIDATION_EXCEPTION;
        $response = \json_decode('{
            "uuid":"",
            "error":{
                "code": ' . $code . ',
                "text": "",
                "type": ""
            },
            "status":"fail",
            "payload":null,
            "timestamp":"",
            "callback_url":""
        }');

        $this->expectException(ErrorIncomingValidationException::class);
        $request->getResponse($response);
    }

    /**
     * @test
     * @depends getReport
     */
    public function getErrorIncomingQueueException($request)
    {
        $code = ErrorCode::ERROR_INCOMING_QUEUE_EXCEPTION;
        $response = \json_decode('{
            "uuid":"",
            "error":{
                "code": ' . $code . ',
                "text": "",
                "type": ""
            },
            "status":"fail",
            "payload":null,
            "timestamp":"",
            "callback_url":""
        }');

        $this->expectException(ErrorIncomingQueueException::class);
        $request->getResponse($response);
    }

    /**
     * @test
     * @depends getReport
     */
    public function getErrorStateBadRequest($request)
    {
        $code = ErrorCode::ERROR_STATE_BAD_REQUEST;
        $response = \json_decode('{
            "uuid":"",
            "error":{
                "code": ' . $code . ',
                "text": "",
                "type": ""
            },
            "status":"fail",
            "payload":null,
            "timestamp":"",
            "callback_url":""
        }');

        $this->expectException(ErrorStateBadRequestException::class);
        $request->getResponse($response);
    }

    /**
     * @test
     * @depends getReport
     */
    public function getErrorStateMissingToken($request)
    {
        $code = ErrorCode::ERROR_STATE_MISSING_TOKEN;
        $response = \json_decode('{
            "uuid":"",
            "error":{
                "code": ' . $code . ',
                "text": "",
                "type": ""
            },
            "status":"fail",
            "payload":null,
            "timestamp":"",
            "callback_url":""
        }');

        $this->expectException(ErrorStateMissingTokenException::class);
        $request->getResponse($response);
    }

    /**
     * @test
     * @depends getReport
     */
    public function getErrorStateNotExistToken($request)
    {
        $code = ErrorCode::ERROR_STATE_NOT_EXIST_TOKEN;
        $response = \json_decode('{
            "uuid":"",
            "error":{
                "code": ' . $code . ',
                "text": "",
                "type": ""
            },
            "status":"fail",
            "payload":null,
            "timestamp":"",
            "callback_url":""
        }');

        $this->expectException(ErrorStateNotExistTokenException::class);
        $request->getResponse($response);
    }

    /**
     * @test
     * @depends getReport
     */
    public function getErrorStateExpiredToken($request)
    {
        $code = ErrorCode::ERROR_STATE_EXPIRED_TOKEN;
        $response = \json_decode('{
            "uuid":"",
            "error":{
                "code": ' . $code . ',
                "text": "",
                "type": ""
            },
            "status":"fail",
            "payload":null,
            "timestamp":"",
            "callback_url":""
        }');

        $this->expectException(ErrorStateExpiredTokenException::class);
        $request->getResponse($response);
    }

    /**
     * @test
     * @depends getReport
     */
    public function getErrorStateMissingUuid($request)
    {
        $code = ErrorCode::ERROR_STATE_MISSING_UUID;
        $response = \json_decode('{
            "uuid":"",
            "error":{
                "code": ' . $code . ',
                "text": "",
                "type": ""
            },
            "status":"fail",
            "payload":null,
            "timestamp":"",
            "callback_url":""
        }');

        $this->expectException(ErrorStateMissingUuidException::class);
        $request->getResponse($response);
    }

    /**
     * @test
     * @depends getReport
     */
    public function getErrorStateNotFound($request)
    {
        $code = ErrorCode::ERROR_STATE_NOT_FOUND;
        $response = \json_decode('{
            "uuid":"",
            "error":{
                "code": ' . $code . ',
                "text": "",
                "type": ""
            },
            "status":"fail",
            "payload":null,
            "timestamp":"",
            "callback_url":""
        }');

        $this->expectException(ErrorStateNotFoundException::class);
        $request->getResponse($response);
    }

    /**
     * @test
     * @depends getReport
     */
    public function getErrorException($request)
    {
        $code = 400;
        $response = \json_decode('{
            "uuid":"",
            "error":{
                "code": ' . $code . ',
                "text": "",
                "type": ""
            },
            "status":"fail",
            "payload":null,
            "timestamp":"",
            "callback_url":""
        }');

        $this->expectException(\Exception::class);
        $request->getResponse($response);
    }
}
