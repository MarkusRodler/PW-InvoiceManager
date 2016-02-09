<?php
declare(strict_types = 1);

namespace Dark\PW\InvoiceManager;

class Money
{
    /**
     * @var int
     */
    private $amount;

    /**
     * @var Currency
     */
    private $currency;

    /**
     * 
     * @param int $amount
     * @param Currency $currency
     */
    public function __construct(int $amount, Currency $currency)
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }

    /**
     * @return int
     */
    function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return Currency
     */
    function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function add(Money $other): Money
    {
        $this->ensureSameCurrency($other);

        return $this->newMoney($this->amount + $other->getAmount());
    }

    public function multiplyWithPercent(int $percent): Money
    {
        return $this->newMoney((int) ($this->amount * $percent / 100));
    }

    public function subtract(Money $other): Money
    {
        $this->ensureSameCurrency($other);

        return $this->newMoney($this->amount - $other->getAmount());
    }

    public function equals(Money $other): bool
    {
        return ($this->currency == $other->getCurrency() && $this->amount === $other->getAmount());
    }
    
    public function __toString(): string
    {
        return sprintf('%.2f %s', $this->amount / 100, $this->currency);
    }

    private function newMoney($amount): Money
    {
        return new Money($amount, $this->currency);
    }

    /**
     * @param Money $other
     * @throws CurrencyMismatchException
     */
    private function ensureSameCurrency(Money $other)
    {
        if ($this->getCurrency() != $other->getCurrency()) {
            throw new CurrencyMismatchException('Different Currency is not supported');
        }
    }
}