<?php
declare(strict_types = 1);

namespace Dark\PW\InvoiceManager;

use OutOfRangeException;
use PHPUnit_Framework_TestCase;

/**
 * @covers \Dark\PW\InvoiceManager\Tax
 */
class TaxTest extends PHPUnit_Framework_TestCase
{

    public function testHasAmount()
    {
        $tax = new Tax(19);
        
        $this->assertSame(19, $tax->getAmount());
    }

    /**
     * @expectedException OutOfRangeException
     * @expectedExceptionMessage Tax can only be between 0 and 100
     */
    public function testAmountCannotBeUnder0()
    {
        new Tax(-1);
    }

    /**
     * @expectedException OutOfRangeException
     * @expectedExceptionMessage Tax can only be between 0 and 100
     */
    public function testAmountCannotBeAbove100()
    {
        new Tax(101);
    }

}