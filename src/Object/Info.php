<?php

namespace SSitdikov\ATOL\Object;

class Info implements \JsonSerializable
{

    private $inn = '';
    private $paymentAddress = '';
    private $callbackUrl = '';

    /**
     * Сервисная часть чека, включает в себя ИНН, адрес сайта и callback_url (на него приходят POST, если указано)
     * @param string $inn
     * @param string $payment_address
     * @param string $callback_url
     */
    public function __construct($inn, $payment_address, $callback_url = '')
    {
        $this->setInn($inn);
        $this->setPaymentAddress($payment_address);
        if ($callback_url) {
            $this->setCallbackUrl($callback_url);
        }
    }

    public function jsonSerialize()
    {
        return [
            'callback_url' => $this->getCallbackUrl(),
            'inn' => $this->getInn(),
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
    public function setCallbackUrl(string $callbackUrl)
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
    public function setInn(string $inn)
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
    public function setPaymentAddress(string $paymentAddress)
    {
        $this->paymentAddress = $paymentAddress;
    }
}
