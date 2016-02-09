<?php
declare(strict_types = 1);

namespace Dark\PW\InvoiceManager;

use PHPUnit_Framework_TestCase;

/**
 * @covers \Dark\PW\InvoiceManager\Money
 * @uses \Dark\PW\InvoiceManager\Currency
 */
class MoneyTest extends PHPUnit_Framework_TestCase
{

    public function testAmountCanBeRetrieved()
    {
        $money = new Money(1, new Currency('EUR'));

        $this->assertEquals(1, $money->getAmount());
    }

    public function testCanMultipyWithPercent()
    {
        $money = new Money(100, new Currency('EUR'));

        $this->assertEquals(3, $money->multiplyWithPercent(3)->getAmount());
    }
    
    public function testCanSubtractSameCurrencies()
    {
        $money1 = new Money(2, new Currency('EUR'));
        $money2 = new Money(1, new Currency('EUR'));

        $this->assertEquals(1, $money1->subtract($money2)->getAmount());
    }
    
    public function testCanAddSameCurrencies()
    {
        $money1 = new Money(1, new Currency('EUR'));
        $money2 = new Money(2, new Currency('EUR'));

        $this->assertEquals(3, $money1->add($money2)->getAmount());
    }

    /**
     * @expectedException \Dark\PW\InvoiceManager\CurrencyMismatchException
     * @expectedExceptionMessage Different Currency is not supported
     */
    public function testWillNotAddDifferentCurrencies()
    {
        $usd = $this->getMockBuilder(Currency::class)
                    ->disableOriginalConstructor()
                    ->getMock();

        $usd->method('currency')->willReturn('USD');

        $money = new Money(1, new Currency('EUR'));
        $money->add(new Money(1, $usd));
    }

    public function testCanCompareSameCurrenciesSameAmount()
    {
        $amount = new Money(1, new Currency('EUR'));

        $this->assertTrue($amount->equals($amount));
    }

    public function testCanCompareSameCurrenciesDifferentAmount()
    {
        $amount1 = new Money(1, new Currency('EUR'));
        $amount2 = new Money(2, new Currency('EUR'));

        $this->assertFalse($amount1->equals($amount2));
    }

    public function testCanCompareDifferentCurrenciesSameAmount()
    {
        $eur = new Money(1, new Currency('EUR'));
        $usd = new Money(1, $this->createUsd());

        $this->assertFalse($eur->equals($usd));
    }

    public function testCanCompareDifferentCurrenciesDifferentAmount()
    {
        $eur = new Money(1, new Currency('EUR'));
        $usd = new Money(2, $this->createUsd());

        $this->assertFalse($eur->equals($usd));
    }

    public function testConvertsToString()
    {
        $money = new Money(100, new Currency('EUR'));
        $this->assertEquals('1.00 EUR', $money->__toString());
    }
    
    private function createUsd()
    {
        $usd = $this->getMockBuilder(Currency::class)
                    ->disableOriginalConstructor()
                    ->getMock();

        $usd->method('currency')->willReturn('USD');

        return $usd;
    }
}

