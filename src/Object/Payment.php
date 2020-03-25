<?php

declare(strict_types=1);

namespace SSitdikov\ATOL\Object;

use JsonSerializable;

/**
 * Class Payment
 *
 * @package SSitdikov\ATOL\Object
 */
class Payment implements JsonSerializable
{

    public const PAYMENT_TYPE_CASH = 0;
    public const PAYMENT_TYPE_ELECTR = 1;
    public const PAYMENT_TYPE_PREPAID = 2;
    public const PAYMENT_TYPE_CREDIT = 3;
    public const PAYMENT_TYPE_OTHER = 4;
    /**
     * 5 - 9 расширенные типы оплаты, устанавливаются отдельно
     */

    /**
     * @var int
     */
    private $type = self::PAYMENT_TYPE_ELECTR;

    /**
     * @var float
     */
    private $sum = 0.0;

    /**
     * Payment constructor.
     *
     * @param int   $type
     * @param float $sum
     */
    public function __construct($type = self::PAYMENT_TYPE_ELECTR, $sum = 0.0)
    {
        $this->setType($type);
        $this->setSum($sum);
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'sum'  => $this->getSum(),
            'type' => $this->getType(),
        ];
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
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType(int $type): void
    {
        $this->type = $type;
    }
}
