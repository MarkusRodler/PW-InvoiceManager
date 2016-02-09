<?php
declare(strict_types = 1);

namespace Dark\PW\InvoiceManager;

use SplObjectStorage;

class Invoice
{

    /**
     * @var SplObjectStorage
     */
    private $lineItems;

    public function __construct(SplObjectStorage $lineItems)
    {
        $this->lineItems = $lineItems;
    }

    public function getLineItems(): SplObjectStorage
    {
        return $this->lineItems;
    }
    
    public function getGrossAmount(): Money
    {
        $counter = 0;
        foreach ($this->lineItems as $item) {
            if ($counter === 0) {
                $grossAmount = new Money(0, $item->getGrossAmount()->getCurrency());
            }
            $grossAmount = $grossAmount->add($item->getGrossAmount());
            $counter++;
        }
        return $grossAmount;
    }
    
    public function getTaxAmount(): Money
    {
        $counter = 0;
        foreach ($this->lineItems as $item) {
            if ($counter === 0) {
                $grossAmount = new Money(0, $item->getTaxAmount()->getCurrency());
            }
            $grossAmount = $grossAmount->add($item->getTaxAmount());
            $counter++;
        }
        return $grossAmount;
    }

}