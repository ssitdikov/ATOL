<?php

declare(strict_types=1);

namespace SSitdikov\ATOL\Object;

/**
 * Class ReceivePaymentsOperator.
 * Атрибуты оператора по приему платежей.
 *
 * @package SSitdikov\ATOL\Object
 */
class ReceivePaymentsOperator implements \JsonSerializable
{
    /**
     * Телефоны оператора по приему платежей.
     *
     * @var string[]
     */
    public $phones = [];

    public function __construct($phones)
    {
        $this->setPhones($phones);
    }

    public function jsonSerialize(): array
    {
        return array_filter([
            'phones' => $this->getPhones()
        ], function($property) { return !is_null($property); });
    }

    /**
     * Возвращает телефоны оператора по приему платежей.
     *
     * @return string[]
     */
    public function getPhones(): array
    {
        return $this->phones;
    }

    /**
     * Устанавливает телефоны оператора по приему платежей.
     *
     * @param array $phones
     *
     * @return ReceivePaymentsOperator
     */
    public function setPhones(array $phones): self 
    {
        $this->phones = $phones;
        return $this;
    }

    /**
     * Добавляет телефон оператора по приему платежей.
     *
     * @param string $phone
     *
     * @return ReceivePaymentsOperator
     */
    public function addPhone(string  $phone): self 
    {
        $this->phones[] = $phone;
        return $this;
    }
}