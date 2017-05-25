<?php
/**
 * Created by PhpStorm.
 * User: sitdikov
 * Date: 25.05.17
 * Time: 16:01
 */

namespace SSitdikov\ATOL\Object;


class Info implements \JsonSerializable
{

    private $inn = '';
    private $payment_address = '';
    private $callback_url = '';

    /**
     * Service constructor.
     * Сервисная часть чека, включает в себя ИНН, адрес сайта и callback_url (на него приходят POST данные, если указано)
     * @param string $inn
     * @param string $payment_address
     * @param string $callback_url
     */
    public function __construct($inn, $payment_address, $callback_url)
    {
        $this->setInn($inn);
        $this->setPaymentAddress($payment_address);
        $this->setCallbackUrl($callback_url);
    }

    public function jsonSerialize()
    {
        return [
            'inn' => $this->getInn(),
            'payment_address' => $this->getPaymentAddress(),
            'callback_url' => $this->getCallbackUrl(),
        ];
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
        return $this->payment_address;
    }

    /**
     * @param string $payment_address
     */
    public function setPaymentAddress(string $payment_address)
    {
        $this->payment_address = $payment_address;
    }

    /**
     * @return string
     */
    public function getCallbackUrl(): string
    {
        return $this->callback_url;
    }

    /**
     * @param string $callback_url
     */
    public function setCallbackUrl(string $callback_url)
    {
        $this->callback_url = $callback_url;
    }

}