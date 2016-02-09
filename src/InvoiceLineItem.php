<?php
declare(strict_types = 1);

namespace Dark\PW\InvoiceManager;

class InvoiceLineItem
{
    /**
     * @var Money Nettobetrag
     */
    private $netAmount;
    
    /**
     * @var Tax tax
     */
    private $tax;

    public function __construct(Money $netAmount, Tax $tax)
    {
        $this->netAmount = $netAmount;
        $this->tax = $tax;
    }

    public function getNetAmount(): Money
    {
        return $this->netAmount;
    }

    public function getGrossAmount(): Money
    {
        return $this->netAmount->add(
            $this->netAmount->multiplyWithPercent($this->tax->getAmount())
        );
    }

    public function getTax(): Tax
    {
        return $this->tax;
    }
    
    public function getTaxAmount(): Money
    {
        return $this->netAmount->multiplyWithPercent($this->tax->getAmount());
    }
}