<?php

namespace SSitdikov\ATOL\Tests;

use PHPUnit\Framework\TestCase;
use SSitdikov\ATOL\Object\Info;
use SSitdikov\ATOL\Object\Item;
use SSitdikov\ATOL\Object\Payment;
use SSitdikov\ATOL\Object\Receipt;
use SSitdikov\ATOL\Object\ReceiptSno;
use SSitdikov\ATOL\Request\OperationRequest;
use SSitdikov\ATOL\Response\TokenResponse;

class OperationRequestTest extends TestCase
{
    public function setUp()
    {
    }

    /**
     * @test
     */
    public function newItem()
    {
        $title = 'Title';
        $price = 1200.00;
        $quantity = 3;
        $tax = Item::TAX_NONE;
        $sum = $price * $quantity;
        $taxSum = 0;

        $item = new Item($title, $price, $quantity, $tax);

        $this->assertEquals($title, $item->getName());
        $this->assertEquals($price, $item->getPrice());
        $this->assertEquals($quantity, $item->getQuantity());
        $this->assertEquals($sum, $item->getSum());
        $this->assertEquals(Item::TAX_NONE, $item->getTax());
        $this->assertEquals($taxSum, $item->getTaxSum());
        $this->assertJson(
            json_encode([
                'name' => $title,
                'price' => $price,
                'quantity' => $quantity,
                'sum' => $sum,
                'tax' => $tax,
                'tax_sum' => $taxSum,
            ]),
            $item->jsonSerialize()
        );

        return $item;
    }

    /**
     * @test
     */
    public function newPayment()
    {
        $payment = new Payment(Payment::PAYMENT_TYPE_CASH, 3600);

        $this->assertEquals(3600, $payment->getSum());
        $this->assertEquals(Payment::PAYMENT_TYPE_CASH, $payment->getType());
        $this->assertJson('{"sum":3600, "type": 0}', $payment->jsonSerialize());

        return $payment;
    }

    /**
     * @test
     * @depends newItem
     * @depends newPayment
     */
    public function newReceipt(Item $item, Payment $payment)
    {
        $this->assertEquals($item->getSum(), $payment->getSum());

        $email = 'test@test.ru';
        $phone = '1234567890';

        $receipt = new Receipt();
        $receipt->setSno(ReceiptSno::RECEIPT_SNO_USN_INCOME)
            ->setEmail($email)
            ->setPhone($phone)
            ->setPayments([$payment])
            ->setItems([$item]);

        $this->assertEquals($email, $receipt->getEmail());
        $this->assertEquals($phone, $receipt->getPhone());
        $this->assertEquals(ReceiptSno::RECEIPT_SNO_USN_INCOME, $receipt->getSno());
        $this->assertEquals($item->getSum(), $receipt->getTotal());

        $this->assertJson(json_encode([
            'attributes' => [
                'sno' => ReceiptSno::RECEIPT_SNO_USN_INCOME,
                'email' => $email,
                'phone' => $phone,
            ],
            'items' => [$item],
            'total' => $payment->getSum(),
            'payments' => [$payment],
        ]), $receipt->jsonSerialize());

        $receipt->addItem($item);
        $this->assertEquals([$item, $item], $receipt->getItems());

        $receipt->addPayment($payment);
        $this->assertEquals([$payment, $payment], $receipt->getPayments());
    }

}
