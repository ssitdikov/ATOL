<?php

declare(strict_types=1);

namespace SSitdikov\ATOL\Object;

use DateTime;
use Exception;
use JsonSerializable;

/**
 * Class Correction.
 * «Коррекция прихода», «Коррекция расхода»
 *
 * @package SSitdikov\ATOL\Object
 */
class Correction implements JsonSerializable
{
    /**
     * Самостоятельно.
     */
    public const TYPE_SELF = 'self';
    /**
     * По предписанию.
     */
    public const TYPE_INSTRUCTION = 'instruction';

    /**
     * @var string
     */
    private $sno = ReceiptSno::RECEIPT_SNO_USN_INCOME;

    /**
     * @var Payment[]
     */
    private $payments = [];

    /**
     * @var string Тип коррекции
     */
    private $type = self::TYPE_SELF;

    /**
     * Дата документа основания для коррекции.
     *
     * В формате: «dd.mm.yyyy»
     *
     * @var string
     */
    private $base_date;

    /**
     * @var string Номер документа основания для коррекции
     */
    private $base_number;

    /**
     * @var string Описание коррекции
     */
    private $base_name;

    /**
     * ИНН организации.
     * Используется для предотвращения ошибочных регистраций чеков на ККТ зарегистрированных с другим ИНН.
     *
     * @var string
     */
    private $inn = '';

    /**
     * Место расчетов.
     * Максимальная длина строки – 256 символов.
     *
     * @var string
     */
    private $paymentAddress = '';

    /**
     * Атрибуты налогов на чек коррекции.
     *
     * @var array
     */
    private $vats;

    /**
     * ФИО кассира.
     * Максимальная длина строки – 64 символа.
     *
     * @var string
     */
    private $cashier = '';


    /**
     * Correction constructor.
     *
     * @param string $type
     *
     * @throws Exception
     */
    public function __construct(string $type = self::TYPE_SELF)
    {
        $this->type = $this->setType($type);
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
    public function jsonSerialize(): array
    {
        return [
            'company'         => [
                'sno'             => $this->getSno(),
                'inn'             => $this->getInn(),
                'payment_address' => $this->getPaymentAddress(),
            ],
            'correction_info' => [
                'type'        => $this->getType(),
                'base_date'   => $this->getBaseDate(),
                'base_number' => $this->getBaseNumber(),
                'base_name'   => $this->getBaseName(),
            ],
            'payments'        => $this->getPayments(),
            'vats'            => $this->getVats(),
            'cashier'         => $this->getCashier(),
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
     *
     * @return Correction
     */
    public function setSno(string $sno): self
    {
        $this->sno = $sno;
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
     *
     * @return self
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
        return $this->paymentAddress;
    }


    /**
     * @param string $paymentAddress
     *
     * @return self
     */
    public function setPaymentAddress(string $paymentAddress): self
    {
        $this->paymentAddress = $paymentAddress;
        return $this;
    }


    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }


    /**
     * @param string $type
     *
     * @throws Exception
     * @return self
     */
    public function setType(string $type): self
    {
        if ($type !== self::TYPE_SELF && $type !== self::TYPE_INSTRUCTION) {
            throw new Exception('Не корректный тип коррекции');
        }
        $this->type = $type;
        return $this;
    }


    /**
     * @return string
     */
    public function getBaseDate(): string
    {
        return $this->base_date;
    }


    /**
     * @param string|DateTime $base_date
     *
     * @throws Exception
     * @return self
     */
    public function setBaseDate($base_date): self
    {
        if ($base_date instanceof DateTime) {
            $this->base_date = $base_date->format('d.m.Y');
        } elseif (is_string($base_date)) {
            $this->base_date = $base_date;
        } else {
            throw new Exception('Не корректный формат даты');
        }
        return $this;
    }


    /**
     * @return string
     */
    public function getBaseNumber(): string
    {
        return $this->base_number;
    }


    /**
     * @param string $base_number
     *
     * @return self
     */
    public function setBaseNumber(string $base_number): self
    {
        $this->base_number = $base_number;
        return $this;
    }


    /**
     * @return string
     */
    public function getBaseName(): string
    {
        return $this->base_name;
    }


    /**
     * @param string $base_name
     *
     * @return self
     */
    public function setBaseName(string $base_name): self
    {
        $this->base_name = $base_name;
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
     * @return string
     */
    public function getCashier(): string
    {
        return $this->cashier;
    }


    /**
     * @param string $cashier
     *
     * @return Correction
     */
    public function setCashier(string $cashier): self
    {
        $this->cashier = $cashier;
        return $this;
    }
}
