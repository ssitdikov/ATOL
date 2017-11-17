<?php

namespace SSitdikov\ATOL\Response;

class PayloadResponse implements ResponseInterface
{
    private $total;
    private $fns_site;
    private $fn_number;
    private $shift_number;
    private $receipt_datetime;
    private $fiscal_receipt_number;
    private $fiscal_document_number;
    private $fiscal_document_attribute;
    private $ecr_registration_number;

    public function __construct(\stdClass $json)
    {
        $this->total = $json->total;
        $this->fns_site = $json->fns_site;
        $this->fn_number = $json->fn_number;
        $this->shift_number = $json->shift_number;
        $this->receipt_datetime = $json->receipt_datetime;
        $this->fiscal_receipt_number = $json->fiscal_receipt_number;
        $this->fiscal_document_number = $json->fiscal_document_number;
        $this->fiscal_document_attribute = $json->fiscal_document_attribute;
        $this->ecr_registration_number = $json->ecr_registration_number;
    }

    /**
     * @return mixed
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @return mixed
     */
    public function getFnsSite()
    {
        return $this->fns_site;
    }

    /**
     * @return mixed
     */
    public function getFnNumber()
    {
        return $this->fn_number;
    }

    /**
     * @return mixed
     */
    public function getShiftNumber()
    {
        return $this->shift_number;
    }

    /**
     * @return mixed
     */
    public function getReceiptDatetime()
    {
        return $this->receipt_datetime;
    }

    /**
     * @return mixed
     */
    public function getFiscalReceiptNumber()
    {
        return $this->fiscal_receipt_number;
    }

    /**
     * @return mixed
     */
    public function getFiscalDocumentNumber()
    {
        return $this->fiscal_document_number;
    }

    /**
     * @return mixed
     */
    public function getFiscalDocumentAttribute()
    {
        return $this->fiscal_document_attribute;
    }

    /**
     * @return mixed
     */
    public function getEcrRegistrationNumber()
    {
        return $this->ecr_registration_number;
    }
}
