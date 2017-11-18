<?php

namespace SSitdikov\ATOL\Object;

class Correction implements \JsonSerializable
{
    /**
     * @var string
     */
    private $sno = ReceiptSno::RECEIPT_SNO_USN_INCOME;
    /**
     * @var string
     */
    private $tax = '';
    /**
     * @var array
     */
    private $payments = [];

    public function addPayment(Payment $payment)
    {
        $this->payments[] = $payment;
    }

    public function jsonSerialize()
    {
        return [
            'attributes' => [
                'sno' => $this->getSno(),
                'tax' => $this->getTax(),
                'payments' => $this->getPayments(),
            ],
        ];
    }

    /**
     * @return string
     */
    public function getSno(): string
    {
        return $this->sno;
    }

    /**
     * @param string $sno
     */
    public function setSno(string $sno)
    {
        $this->sno = $sno;
    }

    /**
     * @return string
     */
    public function getTax(): string
    {
        return $this->tax;
    }

    /**
     * @param string $tax
     */
    public function setTax(string $tax)
    {
        $this->tax = $tax;
    }

    /**
     * @return array
     */
    public function getPayments(): array
    {
        return $this->payments;
    }

    /**
     * @param array $payments
     */
    public function setPayments(array $payments)
    {
        $this->payments = $payments;
    }
}
