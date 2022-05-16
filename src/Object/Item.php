<?php

declare(strict_types=1);

namespace SSitdikov\ATOL\Object;

/**
 * Class Item.
 *
 * @package SSitdikov\ATOL\Object
 */
class Item implements \JsonSerializable
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

    private $sum = 0.0;

    private $vat = null;

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
     * Информация об агенте
     *
     * @var AgentInfo
     */
    private $agent_info;

    /**
     * Информация о поставщике
     *
     * @var SupplierInfo
     */
    private $supplier_info;


    /**
     * Продаваемый товар по чеку.
     *
     * @param  string  $name
     * @param  float   $price
     * @param  float   $quantity
     * @param  Vat     $vat
     * @param  string  $payment_object
     * @param  string  $payment_method
     */
    public function __construct($name, $price, $quantity, $vat, $payment_object = 'commodity', $payment_method = 'full_payment')
    {
        $this->setName($name);
        $this->setPrice($price);
        $this->setQuantity($quantity);
        $this->setVat($vat);
        $this->setSum(round($price * $quantity, 2));
        $this->setPaymentObject($payment_object);
        $this->setPaymentMethod($payment_method);
    }


    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return array_filter([
            'name'              => $this->getName(),
            'price'             => $this->getPrice(),
            'quantity'          => $this->getQuantity(),
            'sum'               => $this->getSum(),
            'vat'               => $this->getVat(),
            'payment_object'    => $this->getPaymentObject(),
            'payment_method'    => $this->getPaymentMethod(),
            'measurement_unit'  => $this->getMeasurementUnit(),
            'agent_info'        => $this->getAgentInfo(),
            'supplier_info'     => $this->getSupplierInfo(),
        ], function ($property) {
            return !is_null($property);
        });
    }


    /**
     * @return AgentInfo
     */
    public function getAgentInfo()
    {
        return $this->agent_info;
    }


    /**
     * @param AgentInfo $agent_info
     *
     * @return Item
     */
    public function setAgentInfo(AgentInfo $agent_info): self
    {
        $this->agent_info = $agent_info;
        return $this;
    }


    /**
     * @return SupplierInfo
     */
    public function getSupplierInfo()
    {
        return $this->supplier_info;
    }


    /**
     * @param SupplierInfo $supplier_info
     *
     * @return Item
     */
    public function setSupplierInfo(SupplierInfo $supplier_info): self
    {
        $this->supplier_info = $supplier_info;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }


    /**
     * @param  string  $name
     *
     * @return Item
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }


    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }


    /**
     * @param  float  $price
     *
     * @return Item
     */
    public function setPrice(float $price): self
    {
        $this->price = $price;
        return $this;
    }


    /**
     * @return float
     */
    public function getQuantity(): float
    {
        return $this->quantity;
    }


    /**
     * @param  float  $quantity
     *
     * @return Item
     */
    public function setQuantity(float $quantity): self
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return Vat|null
     */
    public function getVat()
    {
        return $this->vat;
    }

    /**
     * @param Vat $vat
     */
    public function setVat(Vat $vat): self
    {
        $this->vat = $vat;
        return $this;
    }


    /**
     * @return float
     */
    public function getSum(): float
    {
        return $this->sum;
    }


    /**
     * @param  float  $sum
     *
     * @return Item
     */
    public function setSum(float $sum): self
    {
        $this->sum = $sum;
        return $this;
    }


    /**
     * @return string
     */
    public function getPaymentObject(): string
    {
        return $this->payment_object;
    }


    /**
     * @param  string  $payment_object
     *
     * @return Item
     */
    public function setPaymentObject(string $payment_object): self
    {
        $this->payment_object = $payment_object;
        return $this;
    }


    /**
     * @return string
     */
    public function getPaymentMethod(): string
    {
        return $this->payment_method;
    }


    /**
     * @param  string  $payment_method
     *
     * @return Item
     */
    public function setPaymentMethod(string $payment_method): self
    {
        $this->payment_method = $payment_method;
        return $this;
    }


    /**
     * @return string
     */
    public function getMeasurementUnit(): string
    {
        return $this->measurement_unit;
    }


    /**
     * @param  string  $measurement_unit
     *
     * @return Item
     */
    public function setMeasurementUnit(string $measurement_unit): self
    {
        $this->measurement_unit = $measurement_unit;
        return $this;
    }
}
