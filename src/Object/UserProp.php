<?php

declare(strict_types=1);

namespace SSitdikov\ATOL\Object;

/**
 * Class UserProp.
 *
 * @package SSitdikov\ATOL\Object
 */
class UserProp implements \JsonSerializable
{

    /**
     * Наименование дополнительного реквизита пользователя.
     * Максимальная длина строки – 64 символа.
     *
     * @var string
     */
    private $name;

    /**
     * Значение дополнительного реквизита пользователя.
     * Максимальная длина строки – 256 символов.
     *
     * @var string
     */
    private $value;


    /** 
     * UserProp constructor.
     *
     * @param $name
     * @param $value
     */
    public function __construct($name, $value)
    {
        $this->setName($name);
        $this->setValue($value);
    }


    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return [
            'name'  => $this->getName(),
            'value' => $this->getValue(),
        ];
    }


    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * @param string $name
     *
     * @return UserProp
     */
    public function setName(string $name): self
    {
        $this->name = mb_substr($name, 64);
        return $this;
    }


    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }


    /**
     * @param string $value
     *
     * @return UserProp
     */
    public function setValue(string $value): self
    {
        $this->value = mb_substr($value, 256);
        return $this;
    }
}
