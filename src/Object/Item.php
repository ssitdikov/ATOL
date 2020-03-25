<?php

declare(strict_types=1);

namespace SSitdikov\ATOL\Object;

use JsonSerializable;

/**
 * Class Item.
 *
 * @package SSitdikov\ATOL\Object
 */
class Item implements JsonSerializable
{
    
    /**
     * товар
     */
    public const PAYMENT_OBJECT_COMMODITY = 'commodity';

    /**
     * подакцизный товар
     */
    public const PAYMENT_OBJECT_EXCISE = 'excise';

    /**
     * работа
     */
    public const PAYMENT_OBJECT_JOB = 'job';

    /**
     * услуга
     */
    public const PAYMENT_OBJECT_SERVICE = 'service';

    /**
     * ставка азартной игры
     */
    public const PAYMENT_OBJECT_GAMBLING_BET = 'gambling_bet';

    /**
     * выигрыш азартной игры
     */
    public const PAYMENT_OBJECT_GAMBLING_PRIZE = 'gambling_prize';

    /**
     * лотерейный билет
     */
    public const PAYMENT_OBJECT_LOTTERY = 'lottery';

    /**
     * выигрыш лотереи
     */
    public const PAYMENT_OBJECT_LOTTERY_PRIZE = 'lottery_prize';

    /**
     * предоставление результатов интеллектуальной деятельности
     */
    public const PAYMENT_OBJECT_INTELLECTUAL_ACTIVITY = 'intellectual_activity';

    /**
     * платеж
     */
    public const PAYMENT_OBJECT_PAYMENT = 'payment';

    /**
     * агентское вознаграждение
     */
    public const PAYMENT_OBJECT_AGENT_COMMISSION = 'agent_commission';

    /**
     * составной предмет расчета
     */
    public const PAYMENT_OBJECT_COMPOSITE = 'composite';

    /**
     * иной предмет расчета
     */
    public const PAYMENT_OBJECT_ANOTHER = 'another';

    /**
     * имущественное право
     */
    public const PAYMENT_OBJECT_PROPERTY_RIGHT = 'property_right';

    /**
     * внереализационный доход
     */
    public const PAYMENT_OBJECT_NON_OPERATING_GAIN = 'non-operating_gain';

    /**
     * страховые взносы
     */
    public const PAYMENT_OBJECT_INSURANCE_PREMIUM = 'insurance_premium';

    /**
     * торговый сбор
     */
    public const PAYMENT_OBJECT_SALES_TAX = 'sales_tax';

    /**
     * курортный сбор
     */
    public const PAYMENT_OBJECT_RESORT_FEE = 'resort_fee';

    /**
     *  предоплата 100%. Полная предварительная оплата до момента передачи предмета расчета
     */
    public const PAYMENT_METHOD_FULL_PREPAYMENT = 'full_prepayment';

    /**
     * предоплата. Частичная предварительная оплата до момента передачи предмета расчета
     */
    public const PAYMENT_METHOD_PREPAYMENT = 'prepayment';

    /**
     * аванс
     */
    public const PAYMENT_METHOD_ADVANCE = 'advance';

    /**
     * полный расчет. Полная оплата, в том числе с учетом аванса (предварительной оплаты) в момент передачи предмета расчета.
     */
    public const PAYMENT_METHOD_FULL_PAYMENT = 'full_payment';

    /**
     *  частичный расчет и кредит. Частичная оплата предмета расчета в момент его передачи с последующей оплатой в кредит.
     */
    public const PAYMENT_METHOD_PARTIAL_PAYMENT = 'partial_payment';

    /**
     * передача в кредит. Передача предмета расчета без его оплаты в момент его передачи с последующей оплатой в кредит
     */
    public const PAYMENT_METHOD_CREDIT = 'credit';

    /**
     * оплата кредита. Оплата предмета расчета после его передачи с оплатой в кредит (оплата кредита)
     */
    public const PAYMENT_METHOD_CREDIT_PAYMENT = 'credit_payment';

    /**
     * товар.
     */
    public const PAYMENT_OBJECT_COMMODITY = 'commodity';

    /**
     * подакцизный товар.
     */
    public const PAYMENT_OBJECT_EXCISE = 'excise';

    /**
     * работа.
     */
    public const PAYMENT_OBJECT_JOB = 'job';

    /**
     * услуга.
     */
    public const PAYMENT_OBJECT_SERVICE = 'service';

    /**
     * ставка азартной игры.
     */
    public const PAYMENT_OBJECT_GAMBLING_BET = 'gambling_bet';

    /**
     * выигрыш азартной игры.
     */
    public const PAYMENT_OBJECT_GAMBLING_PRIZE = 'gambling_prize';

    /**
     * лотерейный билет.
     */
    public const PAYMENT_OBJECT_LOTTERY = 'lottery';

    /**
     * выигрыш лотереи.
     */
    public const PAYMENT_OBJECT_LOTTERY_PRIZE = 'lottery_prize';

    /**
     * предоставление результатов интеллектуальной деятельности.
     */
    public const PAYMENT_OBJECT_INTELLECTUAL_ACTIVITY = 'intellectual_activity';

    /**
     * платеж.
     */
    public const PAYMENT_OBJECT_PAYMENT = 'payment';

    /**
     * агентское вознаграждение.
     */
    public const PAYMENT_OBJECT_AGENT_COMMISSION = 'agent_commission';

    /**
     * составной предмет расчета.
     */
    public const PAYMENT_OBJECT_COMPOSITE = 'composite';

    /**
     * иной предмет расчета.
     */
    public const PAYMENT_OBJECT_ANOTHER = 'another';

    /**
     * имущественное право.
     */
    public const PAYMENT_OBJECT_PROPERTY_RIGHT = 'property_right';

    /**
     * внереализационный доход.
     */
    public const PAYMENT_OBJECT_NON_OPERATING_GAIN = 'non-operating_gain';

    /**
     * страховые взносы.
     */
    public const PAYMENT_OBJECT_INSURANCE_PREMIUM = 'insurance_premium';

    /**
     * торговый сбор.
     */
    public const PAYMENT_OBJECT_SALES_TAX = 'sales_tax';

    /**
     * курортный сбор.
     */
    public const PAYMENT_OBJECT_RESORT_FEE = 'resort_fee';

    /**
     *  предоплата 100%. Полная предварительная оплата до момента передачи предмета расчета.
     */
    public const PAYMENT_METHOD_FULL_PREPAYMENT = 'full_prepayment';

    /**
     * предоплата. Частичная предварительная оплата до момента передачи предмета расчета.
     */
    public const PAYMENT_METHOD_PREPAYMENT = 'prepayment';

    /**
     * аванс.
     */
    public const PAYMENT_METHOD_ADVANCE = 'advance';

    /**
     * полный расчет. Полная оплата, в том числе с учетом аванса (предварительной оплаты) в момент передачи предмета расчета.
     */
    public const PAYMENT_METHOD_FULL_PAYMENT = 'full_payment';

    /**
     *  частичный расчет и кредит. Частичная оплата предмета расчета в момент его передачи с последующей оплатой в кредит.
     */
    public const PAYMENT_METHOD_PARTIAL_PAYMENT = 'partial_payment';

    /**
     * передача в кредит. Передача предмета расчета без его оплаты в момент его передачи с последующей оплатой в кредит.
     */
    public const PAYMENT_METHOD_CREDIT = 'credit';

    /**
     * оплата кредита. Оплата предмета расчета после его передачи с оплатой в кредит (оплата кредита).
     */
    public const PAYMENT_METHOD_CREDIT_PAYMENT = 'credit_payment';

    /**
     * @deprecated
     */
    public const TAX_NONE = 'none';
    /**
     * @deprecated
     */
    public const TAX_VAT0 = 'vat0';
    /**
     * @deprecated
     */
    public const TAX_VAT10 = 'vat10';
    /**
     * @deprecated
     */
    public const TAX_VAT18 = 'vat18';
    /**
     * @deprecated
     */
    public const TAX_VAT110 = 'vat110';
    /**
     * @deprecated
     */
    public const TAX_VAT118 = 'vat118';

    private $sum = 0.0;

    private $tax = 'none';

    private $taxSum = 0.0;

    private $name = '';

    private $price = 0.0;

    private $quantity = 1.0;
    /**
     * @var string $payment_object Признак предмета расчета
     */
    private $payment_object = 'commodity';
    /**
     * @var string $payment_method Признак способа расчета
     */
    private $payment_method = 'full_prepayment';
    /**
     * @var string $measurement_unit Единица измерения предмета расчета
     */
    private $measurement_unit = 'шт.';

    /**
     * @var string Признак предмета расчета
     */
    private $payment_object = 'commodity';

    /**
     * @var string Признак способа расчета
     */
    private $payment_method = 'full_prepayment';

    /**
     * @var string Единица измерения предмета расчета
     */
    private $measurement_unit = 'шт.';


    /**
     * Продаваемый товар по чеку.
     *
     * @param string $name
     * @param float  $price
     * @param float  $quantity
     * @param string $tax
     * @param string $payment_object
     * @param string $payment_method
     */
    public function __construct($name, $price, $quantity, $tax, $payment_object = 'commodity', $payment_method = 'full_payment')
    {
        $this->setName($name);
        $this->setPrice($price);
        $this->setQuantity($quantity);
        $this->setTax($tax);
        $this->setSum($price * $quantity);
        $this->setPaymentObject($payment_object);
        $this->setPaymentMethod($payment_method);
    }


    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'name'             => $this->getName(),
            'price'            => $this->getPrice(),
            'quantity'         => $this->getQuantity(),
            'sum'              => $this->getSum(),
            'tax'              => $this->getTax(),
            'tax_sum'          => $this->getTaxSum(),
            'payment_object'   => $this->getPaymentObject(),
            'payment_method'   => $this->getPaymentMethod(),
            'measurement_unit' => $this->getMeasurementUnit(),
        ];
    }
    
    /**
     * @return string
     */
    public function getPaymentObject(): string
    {
        return $this->payment_object;
    }

    /**
     * @param string $payment_object
     */
    public function setPaymentObject(string $payment_object): void
    {
        $this->payment_object = $payment_object;
    }

    /**
     * @return string
     */
    public function getPaymentMethod(): string
    {
        return $this->payment_method;
    }

    /**
     * @param string $payment_method
     */
    public function setPaymentMethod(string $payment_method): void
    {
        $this->payment_method = $payment_method;
    }


    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }


    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }


    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }


    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }


    /**
     * @return float
     */
    public function getQuantity(): float
    {
        return $this->quantity;
    }


    /**
     * @param float $quantity
     */
    public function setQuantity(float $quantity): void
    {
        $this->quantity = $quantity;
    }


    /**
     * @return float
     */
    public function getSum(): float
    {
        return $this->sum;
    }


    /**
     * @param float $sum
     */
    public function setSum(float $sum): void
    {
        $this->sum = $sum;
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
    public function setTax(string $tax): void
    {
        $this->tax = $tax;
        switch ($tax) {
            case (Vat::TAX_VAT110):
                $this->setTaxSum($this->getPrice() * $this->getQuantity() * 10 / 110);
                break;
            case (Vat::TAX_VAT118):
                $this->setTaxSum($this->getPrice() * $this->getQuantity() * 18 / 118);
                break;
            case (Vat::TAX_VAT10):
                $this->setTaxSum($this->getPrice() * $this->getQuantity() * 0.1);
                break;
            case (Vat::TAX_VAT18):
                $this->setTaxSum($this->getPrice() * $this->getQuantity() * 0.18);
                break;
            case (Vat::TAX_VAT20):
                $this->setTaxSum($this->getPrice() * $this->getQuantity() * 0.2);
                break;
            case (Vat::TAX_VAT120):
                $this->setTaxSum($this->getPrice() * $this->getQuantity() * 20 / 120);
                break;
            case (Vat::TAX_VAT0):
            case (Vat::TAX_NONE):
            default:
                $this->setTaxSum(0);
        }
    }


    /**
     * @return float
     */
    public function getTaxSum(): float
    {
        return $this->taxSum;
    }


    /**
     * @param float $taxSum
     */
    public function setTaxSum(float $taxSum): void
    {
        $this->taxSum = round($taxSum, 2);
    }


    /**
     * @return string
     */
    public function getPaymentObject(): string
    {
        return $this->payment_object;
    }


    /**
     * @param string $payment_object
     */
    public function setPaymentObject(string $payment_object): void
    {
        $this->payment_object = $payment_object;
    }


    /**
     * @return string
     */
    public function getPaymentMethod(): string
    {
        return $this->payment_method;
    }


    /**
     * @param string $payment_method
     */
    public function setPaymentMethod(string $payment_method): void
    {
        $this->payment_method = $payment_method;
    }


    /**
     * @return string
     */
    public function getMeasurementUnit(): string
    {
        return $this->measurement_unit;
    }


    /**
     * @param string $measurement_unit
     */
    public function setMeasurementUnit(string $measurement_unit): void
    {
        $this->measurement_unit = $measurement_unit;
    }
}
