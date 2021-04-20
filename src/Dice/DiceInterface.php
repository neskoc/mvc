<?php

declare(strict_types=1);

namespace neskoc\Dice;

/**
 * DiceInterface interface.
 */

interface DiceInterface
{
    /**
     * @const int SIDES Number of dice sides
     */
    public const SIDES = 6;

    public function __construct();
    public function roll(): int;
    public function getLastRoll(): ?int;
}
