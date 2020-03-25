<?php

declare(strict_types=1);

namespace SSitdikov\ATOL\Object;

use JsonSerializable;

/**
 * Class Info.
 *
 * @package SSitdikov\ATOL\Object
 */
class Info implements JsonSerializable
{

    /**
     * @var string
     */
    private $inn = '';

    /**
     * @var string
     */
    private $paymentAddress = '';

    /**
     * @var string URL, на который необходимо ответить после обработки документ
     */
    private $callbackUrl = '';


    /**
     * Сервисная часть чека, включает в себя ИНН, адрес сайта и callback_url (на него приходят POST, если указано).
     *
     * @param string $inn
     * @param string $paymentAddress
     * @param string $callbackUrl
     */
    public function __construct($inn, $paymentAddress, $callbackUrl = '')
    {
        $this->setInn($inn);
        $this->setPaymentAddress($paymentAddress);
        if ($callbackUrl !== '') {
            $this->setCallbackUrl($callbackUrl);
        }
    }


    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'callback_url'    => $this->getCallbackUrl(),
            'inn'             => $this->getInn(),
            'payment_address' => $this->getPaymentAddress(),
        ];
    }


    /**
     * @return string
     */
    public function getCallbackUrl(): string
    {
        return $this->callbackUrl;
    }


    /**
     * @param string $callbackUrl
     *
     * @return Info
     */
    public function setCallbackUrl(string $callbackUrl): self
    {
        // TODO
        //  Корректность заполненного поля определяется по регулярному выражению
        //  ^http(s?)\:\/\/[0-9a-zA-Zа-яА-Я]([-.\w]*[0-9a-zA-Zа-яА-Я])*(:(0-9)*)*(\/?)([a-zAZ0-9а-яА-Я\-\.\?\,\'\/\\\+&=%\$#_]*)?$
        $this->callbackUrl = $callbackUrl;
        return $this;
    }


    /**
     * @return string
     */
    public function getInn(): string
    {
        return $this->inn;
    }


    /**
     * @param string $inn
     *
     * @return Info
     */
    public function setInn(string $inn): self
    {
        $this->inn = $inn;
        return $this;
    }


    /**
     * @return string
     */
    public function getPaymentAddress(): string
    {
        return $this->paymentAddress;
    }


    /**
     * @param string $paymentAddress
     *
     * @return Info
     */
    public function setPaymentAddress(string $paymentAddress): self
    {
        $this->paymentAddress = $paymentAddress;
        return $this;
    }
}
