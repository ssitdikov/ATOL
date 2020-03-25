<?php

declare(strict_types=1);

namespace SSitdikov\ATOL\Object;

use JsonSerializable;

/**
 * Class Receipt.
 *  «Приход», «Возврат прихода», «Расход», «Возврат расхода»
 *
 * @package SSitdikov\ATOL\Object
 */
class Receipt implements JsonSerializable
{

    private $sno = ReceiptSno::RECEIPT_SNO_USN_INCOME;

    /**
     * @var string
     */
    private $email = '';

    /**
     * @var string
     */
    private $phone = '';

    /**
     * @var array
     */
    private $items = [];

    /**
     * @var array
     */
    private $payments = [];

    /**
     * @var float
     */
    private $total = 0.0;

    /**
     * @var array
     */
    private $vats = [];

    /**
     * @var string
     */
    private $inn = '';

    /**
     * @var string
     */
    private $companyEmail = '';

    /**
     * @var string
     */
    private $paymentAddress = '';

    /**
     * ФИО кассира.
     * Максимальная длина строки – 64 символа.
     *
     * @var string
     */
    private $cashier = '';

    /**
     * Дополнительный реквизит пользователя
     *
     * @var UserProp
     */
    private $additional_user_props;

    /**
     * Дополнительный реквизит чека.
     * Максимальная длина строки – 16 символов.
     *
     * @var string
     */
    private $additional_check_props;


    /**
     * @return UserProp
     */
    public function getAdditionalUserProps(): UserProp
    {
        return $this->additional_user_props;
    }


    /**
     * @param string $name
     * @param string $value
     */
    public function setAdditionalUserProps(string $name, string $value): void
    {
        $this->additional_user_props = new UserProp($name, $value);
    }


    /**
     * @return string
     */
    public function getAdditionalCheckProps(): string
    {
        return $this->additional_check_props;
    }


    /**
     * @param string $additional_check_props
     */
    public function setAdditionalCheckProps(string $additional_check_props): void
    {
        $this->additional_check_props = $additional_check_props;
    }


    /**
     * @return array
     */
    public function getVats(): array
    {
        return $this->vats;
    }


    /**
     * @param array $vats
     *
     * @return Receipt
     */
    public function setVats(array $vats): self
    {
        $this->vats = $vats;
        return $this;
    }


    /**
     * @param $vat
     *
     * @return Receipt
     */
    public function addVat($vat): self
    {
        $this->vats[] = $vat;
        return $this;
    }


    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'client'   => [
                'email' => $this->getEmail(),
                'phone' => $this->getPhone(),
            ],
            'company'  => [
                'email'           => $this->getCompanyEmail(),
                'sno'             => $this->getSno(),
                'inn'             => $this->getInn(),
                'payment_address' => $this->getPaymentAddress(),
            ],
            'items'    => $this->getItems(),
            'total'    => $this->getTotal(),
            'payments' => $this->getPayments(),
            'cashier ' => $this->getCashier(),
        ];
    }


    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }


    /**
     * @param string $email
     *
     * @return Receipt
     */
    public function setEmail(string $email): Receipt
    {
        $this->email = $email;
        return $this;
    }


    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }


    /**
     * @param string $phone
     *
     * @return Receipt
     */
    public function setPhone(string $phone): Receipt
    {
        $this->phone = $phone;
        return $this;
    }


    /**
     * @return string
     */
    public function getCompanyEmail(): string
    {
        return $this->companyEmail;
    }


    /**
     * @param string $companyEmail
     *
     * @return Receipt
     */
    public function setCompanyEmail(string $companyEmail): self
    {
        $this->companyEmail = $companyEmail;
        return $this;
    }


    /**
     * @return string
     */
    public function getSno(): string
    {
        return $this->sno;
    }


    /**
     * @param string $sno
     *
     * @return Receipt
     */
    public function setSno(string $sno): Receipt
    {
        $this->sno = $sno;
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
     * @return Receipt
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
     * @return Receipt
     */
    public function setPaymentAddress(string $paymentAddress): self
    {
        $this->paymentAddress = $paymentAddress;
        return $this;
    }


    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }


    /**
     * @param array $items
     *
     * @return Receipt
     */
    public function setItems(array $items): Receipt
    {
        foreach ($items as $element) {
            $this->addItem($element);
        }

        return $this;
    }


    /**
     * @return float
     */
    public function getTotal(): float
    {
        return $this->total;
    }


    /**
     * @return array
     */
    public function getPayments(): array
    {
        return $this->payments;
    }


    /**
     * @param array $payments
     *
     * @return Receipt
     */
    public function setPayments(array $payments): Receipt
    {
        $this->payments = $payments;
        return $this;
    }


    /**
     * @return string
     */
    public function getCashier(): string
    {
        return $this->cashier;
    }


    /**
     * ФИО кассира.
     * Максимальная длина строки – 64 символа.
     *
     * @param string $cashier
     *
     * @return Receipt
     */
    public function setCashier(string $cashier): self
    {
        $this->cashier = mb_substr($cashier, 64);
        return $this;
    }


    /**
     * @param Item $item
     *
     * @return $this
     */
    public function addItem(Item $item): Receipt
    {
        $this->items[] = $item;
        $this->addTotal($item->getSum());

        return $this;
    }


    /**
     * @param float $sum
     */
    private function addTotal($sum): void
    {
        $this->total += $sum;
    }


    /**
     * @param Payment $payment
     *
     * @return $this
     */
    public function addPayment(Payment $payment): Receipt
    {
        $this->payments[] = $payment;

        return $this;
    }
}
