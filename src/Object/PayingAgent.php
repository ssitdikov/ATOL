<?php

declare(strict_types=1);

namespace SSitdikov\ATOL\Object;

/**
 * Class PayingAgent.
 * Атрибуты платежного агента.
 *
 * @package SSitdikov\ATOL\Object
 */
class PayingAgent implements \JsonSerializable
{

    /**
     * Наименование операции.
     * Максимальная длина строки – 24 символа.
     * 
     * @var string
     */
    public $operation;

    /**
     * Телефоны платежного агента.
     *
     * @var string[]
     */
    public $phones = [];

    public function __construct($operation, $phones)
    {
        $this->setOperation($operation);
        $this->setPhones($phones);
    }

    public function jsonSerialize(): array
    {
        return array_filter([
            'operation' => $this->getOperation(),
            'phones' => $this->getPhones()
        ], function ($property) {
            return !is_null($property);
        });
    }

    /**
     * Возвращает наименование операции.
     * 
     * @return string
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * Устанавлиает наименование операции.
     * Максимальная длина строки – 24 символа.
     * 
     * @param string $operation
     *
     * @return PayingAgent
     */
    public function setOperation(string $operation): self
    {
        $this->operation = $operation;
        return $this;
    }

    /**
     * Возвращает телефоны платежного агента.
     *
     * @return string[]
     */
    public function getPhones(): array
    {
        return $this->phones;
    }

    /**
     * Устанавливает телефоны платежного агента.
     *
     * @param array $phones
     *
     * @return PayingAgent
     */
    public function setPhones(array $phones): self
    {
        $this->phones = $phones;
        return $this;
    }

    /**
     * Добавляет телефон платежного агента.
     *
     * @param string $phone
     *
     * @return PayingAgent
     */
    public function addPhone(string  $phone): self
    {
        $this->phones[] = $phone;
        return $this;
    }
}
