<?php
/**
 * Created by PhpStorm.
 * User: sitdikov
 * Date: 25.05.17
 * Time: 16:00
 */

namespace SSitdikov\ATOL\Object;


class Payment implements \JsonSerializable
{

    const PAYMENT_TYPE_CASH = 0;
    const PAYMENT_TYPE_ELECTR = 1;
    const PAYMENT_TYPE_PREPAID = 2;
    const PAYMENT_TYPE_CREDIT = 3;
    const PAYMENT_TYPE_OTHER = 4;
    /**
     * 5 - 9 расширенные типы оплаты, устанавливаются отдельно
     */

    /**
     * @var int
     */
    private $type = self::PAYMENT_TYPE_ELECTR;
    private $sum = 0.0;

    /**
     * Payment constructor.
     * @param int $type
     * @param float $sum
     */
    public function __construct($type = self::PAYMENT_TYPE_ELECTR, $sum = 0.0)
    {
        $this->type = $type;
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
    public function setType(int $type)
    {
        $this->type = $type;
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

    public function jsonSerialize()
    {
        return [
            'type' => $this->getType(),
            'sum' => $this->getSum(),
        ];
    }

}