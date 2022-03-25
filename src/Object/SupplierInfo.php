<?php

declare(strict_types=1);

namespace SSitdikov\ATOL\Object;

/**
 * Class SupplierInfo.
 * Атрибуты поставщика.
 *
 * @package SSitdikov\ATOL\Object
 */
class SupplierInfo implements \JsonSerializable
{
    /**
     * Наименование поставщика.
     * 
     * @var string
     */
    public $name;

    /**
     * Телефоны поставщика.
     *
     * @var string[]
     */
    public $phones = [];

    /**
     * ИНН поставщика
     * 
     * @var string
     */
    public $inn;

    public function __construct($name, $phones, $inn)
    {
        $this->setName($name);
        $this->setPhones($phones);
        $this->setINN($inn);
    }

    public function jsonSerialize(): array
    {
        return array_filter([
            'name' => $this->getName(),
            'phones' => $this->getPhones(),
            'inn' => $this->getINN()
        ], function ($property) {
            return !is_null($property);
        });
    }

    /**
     * Возвращает наименование поставщика.
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Устанавлиает наименование поставщика.
     * 
     * @param string $name
     *
     * @return SupplierInfo
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Возвращает телефоны поставщика.
     *
     * @return string[]
     */
    public function getPhones(): array
    {
        return $this->phones;
    }

    /**
     * Устанавливает телефоны поставщика.
     *
     * @param array $phones
     *
     * @return SupplierInfo
     */
    public function setPhones(array $phones): self
    {
        $this->phones = $phones;
        return $this;
    }

    /**
     * Добавляет телефон поставщика.
     *
     * @param string $phone
     *
     * @return SupplierInfo
     */
    public function addPhone(string  $phone): self
    {
        $this->phones[] = $phone;
        return $this;
    }

    /**
     * Возвращает ИНН поставщика.
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
     * @return SupplierInfo
     */
    public function setINN(string $inn): self
    {
        $this->inn = $inn;
        return $this;
    }
}
