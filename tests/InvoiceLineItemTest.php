<?php
declare(strict_types = 1);

namespace Dark\PW\InvoiceManager;

use PHPUnit_Framework_TestCase;

/**
 * @covers \Dark\PW\InvoiceManager\InvoiceLineItem
 * @uses \Dark\PW\InvoiceManager\Money
 * @uses \Dark\PW\InvoiceManager\Currency
 * @uses \Dark\PW\InvoiceManager\Tax
 */
class InvoiceLineItemTest extends PHPUnit_Framework_TestCase
{

    public function testHasNetAmount()
    {
        $netAmount = new Money(100, new Currency('EUR'));
        $tax = new Tax(19);

        $invoiceLineItem = new InvoiceLineItem($netAmount, $tax);
        
        $this->assertSame($netAmount, $invoiceLineItem->getNetAmount());
    }

    public function testHasTax()
    {
        $netAmount = new Money(100, new Currency('EUR'));
        $tax = new Tax(19);

        $invoiceLineItem = new InvoiceLineItem($netAmount, $tax);
        
        $this->assertSame($tax, $invoiceLineItem->getTax());
    }

    public function testHasTaxAmount()
    {
        $netAmount = new Money(100, new Currency('EUR'));
        $tax = new Tax(19);

        $invoiceLineItem = new InvoiceLineItem($netAmount, $tax);
        
        $this->assertEquals(new Money(19, new Currency('EUR')), $invoiceLineItem->getTaxAmount());
    }

    public function testHasGrossAmount()
    {
        $netAmount = new Money(100, new Currency('EUR'));
        $tax = new Tax(19);

        $invoiceLineItem = new InvoiceLineItem($netAmount, $tax);
        
        $this->assertEquals(new Money(119, new Currency('EUR')), $invoiceLineItem->getGrossAmount());
    }

}