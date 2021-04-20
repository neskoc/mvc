<?php

declare(strict_types=1);

namespace neskoc\Yatzy;

/**
 * YatzyTable class.
 */

class YatzyTable
{
    private const ROWS = 14; // extended yatzy
    private array $yatzyTable; // objects
    private array $occupiedSlots; // booleans
    private array $disabledSlots; // booleans
    private int $yatzy = 0;

    public function __construct() {
        for ($i = 0; $i < self::ROWS; $i += 1) {
            $this->occupiedSlots[$i] = false;
        }
    }

    public function getAvailableSlots(array $hand): array
    {
        if ($this->yatzy !== 0 && count(array_unique($hand)) === 5) {
            $this->yatzy = 50;
        };
        sort($hand);
        $availableSlots = [];
        foreach ($this->yatzyTable as $key => $slot) {
            if (!in_array($key, $this->occupiedSlots) && $this->checkIfSlotAllowed($key, $hand)) {
                array_push($availableSlots, $key);
            }
        }
        return $availableSlots;
    }

    public function disableSlot(int $rowNr): void
    {
        $this->disabledSlots[$rowNr - 1] = true;
        $this->yatzyTable[$rowNr - 1] = [0, 0, 0, 0, 0];
    }

    private function checkIfSlotAllowed(int $value, array $hand): bool
    {
        $available = false;
        $unique = array_unique($hand);
        $len = count($unique);
        $arrayCountValues = array_count_values($hand);
        if ($value > 0 && $$value < 7) {
            $available = $this->checkFirst6($value, $hand);
        } else {
            switch ($value) {
                case 7:
                    if ($this->nrOfPairs($arrayCountValues) === 1) {
                        $available = true;
                    };
                    break;
                case 8:
                    $available = $this->checkSlotNr8($arrayCountValues);
                    break;
                case 9:
                    if ($len === 2 || ($len === 3 && $this->nrOfPairs($arrayCountValues) < 2)) {
                        $available = true;
                    }
                    break;
                case 10:
                    if ($this->nrOfForOfAKind($arrayCountValues) === 1) {
                        $available = true;
                    }
                    break;
                case 11:
                    if ($len === 2) {
                        $available = true;
                    };
                    break;
                case 12:
                    $smallStraight = [1, 2, 3, 4, 5];
                    if (!empty(array_diff($smallStraight, $hand))) {
                        $available = true;
                    };
                    break;
                case 13:
                    $largeStraight = [2, 3, 4, 5, 6];
                    if (!empty(array_diff($largeStraight, $hand))) {
                        $available = true;
                    };
                    break;
                case 14:
                    $available = true;
                    break;
            }
        }
        return $available;
    }

    private function saveHand(int $value, array $hand)
    {
        $this->yatzyTable[$value] = $hand;
        $occupiedSlots[$value] = true;
    }

    private function checkFirst6(int $value, array $hand): bool
    {
        if (in_array($value, $hand)) {
            return true;
        }
        return false;
    }

    private function nrOfPairs(array $arrayCountValues): int
    {
        return count(array_keys(array_values($arrayCountValues), 2));
    }

    private function nrOfForOfAKind(array $arrayCountValues): int
    {
        return count(array_keys(array_values($arrayCountValues), 4));
    }

    private function checkSlotNr8(array $arrayCountValues): bool
    {
        $nrOfPairs = $this->nrOfPairs($arrayCountValues);
        if ($nrOfPairs == 2) {
            return true;
        }
        return false;
    }
}
