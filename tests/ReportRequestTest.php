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
        $uuid = rand(1000, 9999);
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
        $fns_site = 'www.nalog.ru';
        $fn_number = rand(1, 100);
        $shift_number = rand(1, 100);
        $receipt_datetime = date('Y-m-d H:i:s', strtotime('-' . rand(1, 5) . 'h'));
        $fiscal_receipt_number = rand(1, 100);
        $fiscal_document_number = rand(1, 100);
        $fiscal_document_attribute = rand(10000, 99999);
        $ecr_registration_number = rand(11111, 99999);
        $group_code = 'TestShop';
        $daemon_code = 'prod-agent-1';
        $device_code = 'TEST01-00-01';
        $callback_url = '';
        $json = '{
            "uuid":"' . $uuid . '",
            "error":null,
            "status":"done",
            "payload": {
                "total":"' . $total . '",
                "fns_site":"' . $fns_site . '",
                "fn_number":"' . $fn_number . '",
                "shift_number":"' . $shift_number . '",
                "receipt_datetime":"' . $receipt_datetime . '",
                "fiscal_receipt_number":"' . $fiscal_receipt_number . '",
                "fiscal_document_number":"' . $fiscal_document_number . '",
                "fiscal_document_attribute":"' . $fiscal_document_attribute . '",
                "ecr_registration_number":"' . $ecr_registration_number . '"
             },
            "timestamp":"' . $timestamp . '",
            "group_code":"' . $group_code . '",
            "daemon_code":"' . $daemon_code . '",
            "device_code":"' . $device_code . '",
            "callback_url":"' . $callback_url . '"
        }';
        $response = \json_decode($json);

        $this->assertEquals($timestamp, $request->getResponse($response)->getTimestamp());
        $this->assertEquals($uuid, $request->getResponse($response)->getUuid());
        $this->isNull($request->getResponse($response)->getError());
        $this->assertEquals('done', $request->getResponse($response)->getStatus());
        $this->assertEquals($total, $request->getResponse($response)->getPayload()->getTotal());
        $this->assertEquals($fns_site, $request->getResponse($response)->getPayload()->getFnsSite());
        $this->assertEquals($fn_number, $request->getResponse($response)->getPayload()->getFnNumber());
        $this->assertEquals($shift_number, $request->getResponse($response)->getPayload()->getShiftNumber());
        $this->assertEquals($receipt_datetime, $request->getResponse($response)->getPayload()->getReceiptDatetime());
        $this->assertEquals(
            $fiscal_receipt_number,
            $request->getResponse($response)->getPayload()->getFiscalReceiptNumber()
        );
        $this->assertEquals(
            $fiscal_document_number,
            $request->getResponse($response)->getPayload()->getFiscalDocumentNumber()
        );
        $this->assertEquals(
            $fiscal_document_attribute,
            $request->getResponse($response)->getPayload()->getFiscalDocumentAttribute()
        );
        $this->assertEquals(
            $ecr_registration_number,
            $request->getResponse($response)->getPayload()->getEcrRegistrationNumber()
        );
        $this->assertEquals($timestamp, $request->getResponse($response)->getTimestamp());
        $this->assertEquals($group_code, $request->getResponse($response)->getGroupCode());
        $this->assertEquals($daemon_code, $request->getResponse($response)->getDaemonCode());
        $this->assertEquals($device_code, $request->getResponse($response)->getDeviceCode());
        $this->assertEquals($callback_url, $request->getResponse($response)->getCallbackUrl());
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
