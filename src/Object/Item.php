<?php

declare(strict_types=1);

namespace SSitdikov\ATOL\Object;

/**
 * Class Item
 * @package SSitdikov\ATOL\Object
 */
class Item implements \JsonSerializable
{

    public const TAX_NONE = 'none';
    public const TAX_VAT0 = 'vat0';
    public const TAX_VAT10 = 'vat10';
    public const TAX_VAT18 = 'vat18';
    public const TAX_VAT110 = 'vat110';
    public const TAX_VAT118 = 'vat118';
    public const TAX_VAT20 = 'vat20';
    public const TAX_VAT120 = 'vat120';

    private $sum = 0.0;
    private $tax = 'none';
    private $taxSum = 0.0;
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
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->getName(),
            'price' => $this->getPrice(),
            'quantity' => $this->getQuantity(),
            'sum' => $this->getSum(),
            'tax' => $this->getTax(),
            'tax_sum' => $this->getTaxSum()
        ];
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
            case (self::TAX_VAT110):
                $this->setTaxSum($this->getPrice() * $this->getQuantity() * 10 / 110);
                break;
            case (self::TAX_VAT118):
                $this->setTaxSum($this->getPrice() * $this->getQuantity() * 18 / 118);
                break;
            case (self::TAX_VAT10):
                $this->setTaxSum($this->getPrice() * $this->getQuantity() * 0.1);
                break;
            case (self::TAX_VAT18):
                $this->setTaxSum($this->getPrice() * $this->getQuantity() * 0.18);
                break;
            case (self::TAX_VAT20):
                $this->setTaxSum($this->getPrice() * $this->getQuantity() * 0.2);
                break;
            case (self::TAX_VAT120):
                $this->setTaxSum($this->getPrice() * $this->getQuantity() * 20 / 120);
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
}
