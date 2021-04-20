<?php

declare(strict_types=1);

namespace neskoc\Yatzy;

/**
 * YatzyColumnInterface.
 */

interface YatzyColumnInterface
{
    public const ROWS = 14;

    public function __construct();
    public function getAvailableSlots(array $hand): array;
    public function disableSlot(int $rowNr): void;
    public function checkIfSlotAllowed(int $value, array $hand): bool;
    public function saveValue(int $value, array $hand);
}
