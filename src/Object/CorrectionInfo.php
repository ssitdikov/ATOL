<?php

declare(strict_types=1);

namespace SSitdikov\ATOL\Object;

/**
 * Class CorrectionInfo.
 * Коррекция
 *
 * @package SSitdikov\ATOL\Object
 */
class CorrectionInfo implements \JsonSerializable
{
    /**
     * Самостоятельно.
     */
    public const TYPE_SELF = 'self';

    /**
     * По предписанию.
     */
    public const TYPE_INSTRUCTION = 'instruction';

    /**
     * @var string Тип коррекции
     */
    private $type = self::TYPE_SELF;

    /**
     * Дата документа основания для коррекции.
     *
     * В формате: «dd.mm.yyyy»
     *
     * @var string
     */
    private $base_date;

    /**
     * @var string Номер документа основания для коррекции
     */
    private $base_number;

    /**
     * @var string Описание коррекции
     */
    private $base_name;


    /**
     * Correction constructor.
     *
     * @param string $type
     *
     * @throws Exception
     */
    public function __construct(string $type = self::TYPE_SELF, $base_date, $base_number, $base_name)
    {
        $this->setType($type);
        $this->setType($base_date);
        $this->setType($base_number);
        $this->setType($base_name);
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'type'        => $this->getType(),
            'base_date'   => $this->getBaseDate(),
            'base_number' => $this->getBaseNumber(),
            'base_name'   => $this->getBaseName(),
        ];
    }


    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }


    /**
     * @param string $type
     *
     * @throws Exception
     * @return CorrectionInfo
     */
    public function setType(string $type): self
    {
        if ($type !== self::TYPE_SELF && $type !== self::TYPE_INSTRUCTION) {
            throw new \Exception('Не корректный тип коррекции');
        }
        $this->type = $type;
        return $this;
    }


    /**
     * @return string
     */
    public function getBaseDate(): string
    {
        return $this->base_date;
    }


    /**
     * @param string|DateTime $base_date
     *
     * @throws Exception
     * @return self
     */
    public function setBaseDate($base_date): self
    {
        if ($base_date instanceof \DateTime) {
            $this->base_date = $base_date->format('d.m.Y');
        } elseif (is_string($base_date)) {
            $this->base_date = $base_date;
        } else {
            throw new \Exception('Не корректный формат даты');
        }
        return $this;
    }


    /**
     * @return string
     */
    public function getBaseNumber(): string
    {
        return $this->base_number;
    }


    /**
     * @param string $base_number
     *
     * @return self
     */
    public function setBaseNumber(string $base_number): self
    {
        $this->base_number = $base_number;
        return $this;
    }


    /**
     * @return string
     */
    public function getBaseName(): string
    {
        return $this->base_name;
    }


    /**
     * @param string $base_name
     *
     * @return self
     */
    public function setBaseName(string $base_name): self
    {
        $this->base_name = $base_name;
        return $this;
    }
}
