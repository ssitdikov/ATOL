<?php

declare(strict_types=1);

namespace SSitdikov\ATOL\Object;

/**
 * Class MoneyTransferOperator.
 * Атрибуты оператора перевода.
 *
 * @package SSitdikov\ATOL\Object
 */
class MoneyTransferOperator implements \JsonSerializable
{

    /**
     * Наименование оператора перевода.
     * 
     * @var string
     */
    public $name;

    /**
     * Телефоны оператора перевода.
     *
     * @var string[]
     */
    public $phones = [];

    /**
     * Адрес оператора перевода
     * 
     * @var string
     */
    public $address;

    /**
     * ИНН оператора перевода
     * 
     * @var string
     */
    public $inn;

    public function __construct($name, $phones, $address, $inn)
    {
        $this->setName($name);
        $this->setPhones($phones);
        $this->setAddress($address);
        $this->setINN($inn);
    }

    public function jsonSerialize(): array
    {
        return array_filter([
            'name' => $this->getName(),
            'phones' => $this->getPhones(),
            'address' => $this->getAddress(),
            'inn' => $this->getINN()
        ], function($property) { return !is_null($property); });
    }

    /**
     * Возвращает наименование оператора перевода.
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Устанавлиает наименование оператора перевода.
     * 
     * @param string $name
     *
     * @return MoneyTransferOperator
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Возвращает телефоны оператора перевода.
     *
     * @return string[]
     */
    public function getPhones(): array
    {
        return $this->phones;
    }

    /**
     * Устанавливает телефоны оператора перевода.
     *
     * @param array $phones
     *
     * @return MoneyTransferOperator
     */
    public function setPhones(array $phones): self 
    {
        $this->phones = $phones;
        return $this;
    }

    /**
     * Добавляет телефон оператора перевода.
     *
     * @param string $phone
     *
     * @return MoneyTransferOperator
     */
    public function addPhone(string  $phone): self 
    {
        $this->phones[] = $phone;
        return $this;
    }

    /**
     * Возвращает адрес оператора перевода.
     * 
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Устанавлиает адрес оператора перевода.
     * 
     * @param string $address
     *
     * @return MoneyTransferOperator
     */
    public function setAddress(string $address): self
    {
        $this->address = $address;
        return $this;
    }

    /**
     * Возвращает ИНН оператора перевода.
     * 
     * @return string
     */
    public function getINN()
    {
        return $this->inn;
    }

    /**
     * Устанавлиает ИНН оператора перевода.
     * 
     * @param string $inn
     *
     * @return MoneyTransferOperator
     */
    public function setINN(string $inn): self
    {
        $this->inn = $inn;
        return $this;
    }
}