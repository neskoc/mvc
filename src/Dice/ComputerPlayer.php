<?php

declare(strict_types=1);

namespace neskoc\Dice;

/**
 * ComputerPlayer class.
 */

class ComputerPlayer extends Player
{

    public function __construct($bitcoins = 100)
    {
        parent::__construct($bitcoins);
    }

    public function removeBitcoins($bitcoins): float
    {
        if ($bitcoins <= $this->bitcoinBalance) {
            $this->bitcoinBalance -= $bitcoins;
        }

        return $this->bitcoinBalance;
    }
}
