<?php
/**
 * Created by PhpStorm.
 * User: sitdikov
 * Date: 25.05.17
 * Time: 16:00
 */

namespace SSitdikov\ATOL\Object;


class Receipt implements \JsonSerializable
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

    public function jsonSerialize()
    {
        return [
            'attributes' => [
                'sno' => $this->getSno(),
                'email' => $this->getEmail(),
                'phone' => $this->getPhone(),
            ],
            'items' => $this->getItems(),
            'total' => $this->getTotal(),
            'payments' => $this->getPayments(),
        ];
    }

    public function addItem(Item $item)
    {
        $this->items[] = $item;
        $this->addTotal($item->getSum());
    }

    /**
     * @param float $sum
     */
    private function addTotal($sum)
    {
        $this->setTotal($this->getTotal() + $sum);
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
     */
    public function setSno(string $sno)
    {
        $this->sno = $sno;
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
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
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
     */
    public function setPhone(string $phone)
    {
        $this->phone = $phone;
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
     */
    public function setItems(array $items)
    {
        $this->items = $items;
    }

    /**
     * @return float
     */
    public function getTotal(): float
    {
        return $this->total;
    }

    /**
     * @param float $total
     */
    public function setTotal(float $total)
    {
        $this->total = $total;
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
     */
    public function setPayments(array $payments)
    {
        $this->payments = $payments;
    }

    public function addPayment(Payment $payment){
        $this->payments[] = $payment;
    }


}