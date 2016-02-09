<?php
declare(strict_types = 1);

namespace Dark\PW\InvoiceManager;

use PHPUnit_Framework_TestCase;
use SplObjectStorage;

/**
 * @covers \Dark\PW\InvoiceManager\Invoice
 * @uses \Dark\PW\InvoiceManager\InvoiceLineItem
 * @uses \Dark\PW\InvoiceManager\Currency
 * @uses \Dark\PW\InvoiceManager\Tax
 * @uses \Dark\PW\InvoiceManager\Money
 */
class InvoiceTest extends PHPUnit_Framework_TestCase
{

    public function testHasLineItems()
    {
        $netAmount = new Money(100, new Currency('EUR'));
        $tax = new Tax(19);

        $invoiceLineItem1 = new InvoiceLineItem($netAmount, $tax);
        $invoiceLineItem2 = new InvoiceLineItem($netAmount, $tax);
        $invoiceLineItem3 = new InvoiceLineItem($netAmount, $tax);
        
        $lineItems = new SplObjectStorage();
        $lineItems->attach($invoiceLineItem1);
        $lineItems->attach($invoiceLineItem2);
        $lineItems->attach($invoiceLineItem3);
        
        $invoice = new Invoice($lineItems);
        
        $this->assertCount(3, $invoice->getLineItems());
        $this->assertContains($invoiceLineItem1, $invoice->getLineItems());
        $this->assertContains($invoiceLineItem2, $invoice->getLineItems());
        $this->assertContains($invoiceLineItem3, $invoice->getLineItems());
    }
    
    public function testHasGrossAmount()
    {
        $netAmount = new Money(100, new Currency('EUR'));
        $tax = new Tax(19);

        $invoiceLineItem1 = new InvoiceLineItem($netAmount, $tax);
        $invoiceLineItem2 = new InvoiceLineItem($netAmount, $tax);
        $invoiceLineItem3 = new InvoiceLineItem($netAmount, $tax);
        
        $lineItems = new SplObjectStorage();
        $lineItems->attach($invoiceLineItem1);
        $lineItems->attach($invoiceLineItem2);
        $lineItems->attach($invoiceLineItem3);
        
        $invoice = new Invoice($lineItems);
        
        $this->assertEquals(new Money(357, new Currency('EUR')), $invoice->getGrossAmount());
    }
    
    public function testHasTaxAmount()
    {
        $netAmount = new Money(100, new Currency('EUR'));
        $tax = new Tax(19);

        $invoiceLineItem1 = new InvoiceLineItem($netAmount, $tax);
        $invoiceLineItem2 = new InvoiceLineItem($netAmount, $tax);
        $invoiceLineItem3 = new InvoiceLineItem($netAmount, $tax);
        
        $lineItems = new SplObjectStorage();
        $lineItems->attach($invoiceLineItem1);
        $lineItems->attach($invoiceLineItem2);
        $lineItems->attach($invoiceLineItem3);
        
        $invoice = new Invoice($lineItems);
        
        $this->assertEquals(new Money(57, new Currency('EUR')), $invoice->getTaxAmount());
    }

}