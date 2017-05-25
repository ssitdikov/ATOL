<?php

namespace SSitdikov\ATOL\Object;

class Item implements \JsonSerializable
{

    const TAX_NONE = 'none';
    const TAX_VAT0 = 'vat0';
    const TAX_VAT10 = 'vat10';
    const TAX_VAT18 = 'vat18';
    const TAX_VAT110 = 'vat110';
    const TAX_VAT118 = 'vat118';

    private $sum = 0.0;
    private $tax = 'none';
    private $tax_sum = 0.0;
    private $name = '';
    private $price = 0.0;
    private $quantity = 1.0;

    /**
     * Продаваемый товар по чеку
     * @param string $name
     * @param float $price
     * @param float $quantity
     * @param string $tax
     */
    public function __construct($name, $price, $quantity, $tax)
    {
        $this->setName($name);
        $this->setPrice($price);
        $this->setQuantity($quantity);
        $this->setTax($tax);
        $this->setSum($price * $quantity);
        /**
         * @TODO Разобраться 110/118 как считать?
         */
        switch ($tax) {
            case (self::TAX_VAT10):
                $this->setTaxSum($price * $quantity * 0.1);
                break;
            case (self::TAX_VAT18):
                $this->setTaxSum($price * $quantity * 0.18);
                break;
            case (self::TAX_VAT0):
            case (self::TAX_NONE):
            default:
                $this->setTaxSum(0);
        }
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
    public function setSum(float $sum)
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
    public function setTax(string $tax)
    {
        $this->tax = $tax;
    }

    /**
     * @return float
     */
    public function getTaxSum(): float
    {
        return $this->tax_sum;
    }

    /**
     * @param float $tax_sum
     */
    public function setTaxSum(float $tax_sum)
    {
        $this->tax_sum = $tax_sum;
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
    public function setName(string $name)
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
    public function setPrice(float $price)
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
    public function setQuantity(float $quantity)
    {
        $this->quantity = $quantity;
    }

    public function jsonSerialize()
    {
        return [
            'sum' => $this->getSum(),
            'tax' => $this->getTax(),
            'tax_sum' => $this->getTaxSum(),
            'name' => $this->getName(),
            'price' => $this->getPrice(),
            'quantity' => $this->getQuantity(),

        ];
    }
}
