<?php

declare(strict_types=1);

namespace SSitdikov\ATOL\Object;

/**
 * Class Correction.
 * «Коррекция прихода», «Коррекция расхода»
 *
 * @package SSitdikov\ATOL\Object
 */
class Correction implements \JsonSerializable
{

    /**
     * @var Company
     */
    private $company;

    /**
     * @var CorrectionInfo
     */
    private $correction_info;

    /**
     * @var Payment[]
     */
    private $payments = [];

    /**
     * Атрибуты налогов на чек коррекции.
     *
     * @var array
     */
    private $vats;

    /**
     * Correction constructor.
     *
     * @param string $type
     *
     * @throws Exception
     */
    public function __construct($company, $correction_info, $payments, $vats)
    {
        $this->setCompany($company);
        $this->setCorrectionInfo($correction_info);
        $this->setPayments($payments);
        $this->setVats($vats);
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'company'         => $this->getCompany(),
            'correction_info' => $this->getCorrectionInfo(),
            'payments'        => $this->getPayments(),
            'vats'            => $this->getVats(),
        ];
    }

    /**
     * @return Company
     */
    public function getCompany(): Company
    {
        return $this->company;
    }

    /**
     * @param Company $company
     * @return Correction
     */
    public function setCompany(Company $company): Correction
    {
        $this->company = $company;
        return $this;
    }

    /**
     * @return CorrectionInfo
     */
    public function getCorrectionInfo(): CorrectionInfo
    {
        return $this->correction_info;
    }

    /**
     * @param CorrectionInfo $correction_info
     * @return Correction
     */
    public function setCorrectionInfo(CorrectionInfo $correction_info): Correction
    {
        $this->correction_info = $correction_info;
        return $this;
    }


    /**
     * @return Payment[]
     */
    public function getPayments(): array
    {
        return $this->payments;
    }


    /**
     * @param array $payments
     *
     * @return Correction
     */
    public function setPayments(array $payments): self
    {
        $this->payments = $payments;
        return $this;
    }

    /**
     * @param Payment $payment
     *
     * @return Correction
     */
    public function addPayment(Payment $payment): self
    {
        $this->payments[] = $payment;
        return $this;
    }


    /**
     * @return array
     */
    public function getVats(): array
    {
        return $this->vats;
    }


    /**
     * @param array $vats
     *
     * @return Correction
     */
    public function setVats(array $vats): self
    {
        $this->vats = $vats;
        return $this;
    }

    /**
     * @param $vat
     *
     * @return Correction
     */
    public function addVat($type, $sum): self
    {
        $this->vats[] = new Vat($type, $sum);
        return $this;
    }

}
