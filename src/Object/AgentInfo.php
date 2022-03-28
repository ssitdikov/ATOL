<?php

declare(strict_types=1);

namespace SSitdikov\ATOL\Object;

/**
 * Class AgentInfo.
 * Агент
 *
 * @package SSitdikov\ATOL\Object
 */
class AgentInfo implements \JsonSerializable
{
    /**
     * «bank_paying_agent» – банковский платежный
     * агент. Оказание услуг покупателю (клиенту)
     * пользователем, являющимся банковским
     * платежным агентом банковским платежным
     * агентом.
     */
    public const BANK_PAYING_AGENT = 'bank_paying_agent';

    /**
     * «bank_paying_subagent» – банковский
     * платежный субагент. Оказание услуг
     * покупателю (клиенту) пользователем,
     * являющимся банковским платежным агентом
     * банковским платежным субагентом.
     */
    public const BANK_PAYING_SUBAGENT = 'bank_paying_subagent';

    /**
     * «paying_agent» – платежный агент. Оказание
     * услуг покупателю (клиенту) пользователем,
     * являющимся платежным агентом.
     */
    public const PAYING_AGENT = 'paying_agent';

    /**
     * «paying_subagent» – платежный субагент.
     * Оказание услуг покупателю (клиенту)
     * пользователем, являющимся платежным
     * субагентом.
     */
    public const PAYING_SUBAGENT = 'paying_subagent';

    /**
     * «attorney» – поверенный. Осуществление
     * расчета с покупателем (клиентом)
     * пользователем, являющимся поверенным.
     */
    public const ATTORNEY = 'attorney';

    /**
     * «commission_agent» – комиссионер.
     * Осуществление расчета с покупателем
     * (клиентом) пользователем, являющимся
     * комиссионером.
     */
    public const COMMISSION_AGENT = 'commission_agent';

    /**
     * «another» – другой тип агента. Осуществление
     * расчета с покупателем (клиентом)
     * пользователем, являющимся агентом и не
     * являющимся банковским платежным агентом
     * (субагентом), платежным агентом
     * (субагентом), поверенным, комиссионером
     */
    public const ANOTHER = 'another';

    /**
     * Признак агента по предмету расчёта (ограничен
     * агентами, введенными в ККТ при фискализации).
     *
     * @var string
     */
    public $type = self::ANOTHER;

    /**
     * Атрибуты платежного агента.
     *
     * @var PayingAgent
     */
    public $paying_agent;

    /**
     * Атрибуты оператора по приему платежей.
     *
     * @var ReceivePaymentsOperator
     */
    public $receive_payments_operator;

    /**
     * Атрибуты оператора перевода.
     *
     * @var MoneyTransferOperator
     */
    public $money_transfer_operator;


    public function jsonSerialize(): array
    {
        return array_filter([
            'type'                          => $this->getType(),
            'paying_agent'                  => $this->getPayingAgent(),
            'receive_payments_operator'     => $this->getReceivePaymentsOperator(),
            'money_transfer_operator'       => $this->getMoneyTransferOperator()
        ], function ($property) {
            return !is_null($property);
        });
    }

    /**
     * Get Признак агента по предмету расчёта
     *
     * @return  string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set Признак агента по предмету расчёта
     *
     * @param  string  $type  Признак агента по предмету расчёта
     *
     * @return  AgentInfo
     */
    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Get атрибуты платежного агента.
     *
     * @return  PayingAgent
     */
    public function getPayingAgent()
    {
        return $this->paying_agent;
    }

    /**
     * Set атрибуты платежного агента.
     *
     * @param  PayingAgent  $paying_agent  Атрибуты платежного агента.
     *
     * @return  self
     */
    public function setPayingAgent(PayingAgent $paying_agent): self
    {
        $this->paying_agent = $paying_agent;
        return $this;
    }

    /**
     * Get атрибуты оператора по приему платежей.
     *
     * @return  ReceivePaymentsOperator
     */
    public function getReceivePaymentsOperator()
    {
        return $this->receive_payments_operator;
    }

    /**
     * Set атрибуты оператора по приему платежей.
     *
     * @param  ReceivePaymentsOperator  $receive_payments_operator  Атрибуты оператора по приему платежей.
     *
     * @return  AgentInfo
     */
    public function setReceivePaymentsOperator(ReceivePaymentsOperator $receive_payments_operator): self
    {
        $this->receive_payments_operator = $receive_payments_operator;
        return $this;
    }

    /**
     * Get атрибуты оператора перевода.
     *
     * @return  MoneyTransferOperator
     */
    public function getMoneyTransferOperator()
    {
        return $this->money_transfer_operator;
    }

    /**
     * Set атрибуты оператора перевода.
     *
     * @param  MoneyTransferOperator  $money_transfer_operator  Атрибуты оператора перевода.
     *
     * @return  AgentInfo
     */
    public function setMoneyTransferOperator(MoneyTransferOperator $money_transfer_operator): self
    {
        $this->money_transfer_operator = $money_transfer_operator;
        return $this;
    }
}
