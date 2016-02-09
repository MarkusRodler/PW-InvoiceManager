<?php
declare(strict_types = 1);

namespace Dark\PW\InvoiceManager;

use OutOfRangeException;

final class Tax
{
    /**
     * @var int
     */
    private $amount;

    public function __construct(int $amount)
    {
        $this->ensureTaxAmountIsBetween0and100($amount);
        $this->amount = $amount;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     * @throws OutOfRangeException
     */
    private function ensureTaxAmountIsBetween0and100(int $amount)
    {
        if ($amount < 0 || $amount > 100) {
            throw new OutOfRangeException('Tax can only be between 0 and 100');
        }
    }
}