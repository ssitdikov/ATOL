<?php

declare(strict_types=1);

namespace SSitdikov\ATOL\Object;

/**
 * Class Company
 * Организация
 *
 * @package SSitdikov\ATOL\Object
 */
class Company implements \JsonSerializable
{

    private $email = '';
    private $payment_address = '';
    private $sno = ReceiptSno::RECEIPT_SNO_USN_INCOME;
    private $inn = '';

    public function __construct($inn, $payment_address, $email, $sno)
    {
        $this->setInn($inn);
        $this->setPaymentAddress($payment_address);
        $this->setEmail($email);
        $this->setSno($sno);
    }

    public function jsonSerialize(): array
    {
        return [
            'sno' => $this->getSno(),
            'email' => $this->getEmail(),
            'inn' => $this->getInn(),
            'payment_address' => $this->getPaymentAddress()
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
     * @return Company
     */
    public function setSno(string $sno): self
    {
        $this->sno = $sno;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Company
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }
    /**
     * @return string
     */
    public function getInn(): string
    {
        return $this->inn;
    }

    /**
     * @param string $inn
     * @return Company
     */
    public function setInn(string $inn): self
    {
        $this->inn = $inn;
        return $this;
    }

    /**
     * @return string
     */
    public function getPaymentAddress(): string
    {
        return $this->payment_address;
    }

    /**
     * @param string $payment_address
     * @return Company
     */
    public function setPaymentAddress(string $payment_address): self
    {
        $this->payment_address = $payment_address;
        return $this;
    }
}
