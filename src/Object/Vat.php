<?php

declare(strict_types=1);

namespace SSitdikov\ATOL\Object;

/**
 * Class Vat.
 * Налог
 *
 * @package SSitdikov\ATOL\Object
 */
class Vat  implements \JsonSerializable
{
    /**
     * без НДС.
     */
    public const TAX_NONE = 'none';

    /**
     *  НДС по ставке 0%.
     */
    public const TAX_VAT0 = 'vat0';

    /**
     * НДС чека по ставке 10%.
     */
    public const TAX_VAT10 = 'vat10';

    /**
     * НДС чека по ставке 18%.
     */
    public const TAX_VAT18 = 'vat18';

    /**
     * НДС чека по расчетной ставке 10/110.
     */
    public const TAX_VAT110 = 'vat110';

    /**
     * НДС чека по расчетной ставке 18/118.
     */
    public const TAX_VAT118 = 'vat118';

    /**
     * НДС чека по ставке 20%.
     */
    public const TAX_VAT20 = 'vat20';

    /**
     * НДС чека по расчетной ставке 20/120.
     */
    public const TAX_VAT120 = 'vat120';

    /**
     * Вид налога.
     *
     * @var string
     */
    public $type = self::TAX_NONE;

    /**
     * Сумма налога позиции в рублях.
     *  целая часть не более 8 знаков
     *  дробная часть не более 2 знаков
     *
     * @var double|null
     */
    public $sum = null;

    public function __construct($type, $sum = null)
    {
        $this->type = $type;
        $this->sum = $sum;
    }

    public function jsonSerialize(): array
    {
        return [
            'type' => $this->type,
            'sum' => $this->sum
        ];
    }

    /**
     * Get sum
     *
     * @return  double|null
     */
    public function getSum()
    {
        return $this->sum;
    }

    /**
     * Set sum
     *
     * @param  double|null  $sum  sum
     *
     * @return  self
     */
    public function setSum($sum)
    {
        $this->sum = $sum;

        return $this;
    }
}
