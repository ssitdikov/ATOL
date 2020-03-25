<?php

namespace SSitdikov\ATOL\Tests;

use PHPUnit\Framework\TestCase;
use SSitdikov\ATOL\Request\ReportRequest;
use SSitdikov\ATOL\Request\RequestInterface;
use SSitdikov\ATOL\Response\TokenResponse;
use function json_decode;

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
        $token = new TokenResponse(json_decode('{"error":null, "timestamp":"", "token":"' . $token . '"}'));
        $report = new ReportRequest($groupId, $uuid, $token);

        $this->assertEquals(RequestInterface::METHOD_GET, $report->getMethod());
        $this->assertEquals($groupId . '/report/' . $uuid . '?token=' . $token->getToken(), $report->getUrl());
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
        $response = json_decode($json);

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
}
