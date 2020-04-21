<?php

declare(strict_types=1);

namespace SSitdikov\ATOL\Object;

/**
 * Class Vat.
 * Налог
 *
 * @package SSitdikov\ATOL\Object
 */
class Vat
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
     * @var double
     */
    public $sum = 0.0;

    public function __construct($type, $sum)
    {
        $this->type = $type;
        $this->sum = $sum;
    }
}