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

    private $inn = '';
    private $paymentAddress = '';
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
     */
    public function setCallbackUrl(string $callbackUrl): void
    {
        $this->callbackUrl = $callbackUrl;
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
     */
    public function setInn(string $inn): void
    {
        $this->inn = $inn;
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
     */
    public function setPaymentAddress(string $paymentAddress): void
    {
        $this->paymentAddress = $paymentAddress;
    }
}
