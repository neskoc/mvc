<?php

declare(strict_types=1);

namespace neskoc\Dice;

/**
 * Dice class.
 */

class GraphicalDice extends Dice
{
    /**
     * @const int SIDES Number of dice sides
     */
    private const SIDES = 6;

    public function __construct()
    {
        parent::__construct(self::SIDES);
    }

    public function graphic(): int
    {
        return parent::getLastRoll();
    }
}
