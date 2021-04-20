<?php

declare(strict_types=1);

namespace neskoc\Yatzy;

/**
 * YatzyColumn class.
 */

class YatzyColumn implements YatzyColumnInterface
{
    public array $yatzyColumn; // objects
    public array $occupiedSlots; // booleans
    public array $disabledSlots; // booleans
    public int $yatzy = 0;

    public function __construct()
    {
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
        foreach ($this->yatzyColumn as $key => $slot) {
            if (!in_array($key, $this->occupiedSlots) && $this->checkIfSlotAllowed($key, $hand)) {
                array_push($availableSlots, $key);
            }
        }
        return $availableSlots;
    }

    public function disableSlot(int $rowNr): void
    {
        $this->disabledSlots[$rowNr - 1] = true;
        $this->yatzyColumn[$rowNr - 1] = 0;
    }

    public function checkIfSlotAllowed(int $value, array $hand): bool
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
                    if ($this->nrOfFourOfAKind($arrayCountValues) === 1) {
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

    public function saveValue(int $value, array $hand)
    {
        $score = 0;
        sort($hand);
        $arrayCountValues = array_count_values($hand);
        if ($value > 0 && $$value < 7) {
            $score = $value * $this->nrOfAKind($arrayCountValues, $value);
        } else {
            switch ($value) {
                case 7:
                    $score = $this->getAllPairValues($arrayCountValues)[0];
                    break;
                case 8:
                    $pairValues = $this->getAllPairValues($arrayCountValues);
                    $score = 2 * ($pairValues[0] + $pairValues[1]);
                    break;
                case 9:
                    $score = 3 * $this->valueOfXOfAKind($arrayCountValues, 3);
                    break;
                case 10:
                    $score = 4 * $this->valueOfXOfAKind($arrayCountValues, 4);
                    break;
                case 11:
                    $score = $this->valueOfXOfAKind($arrayCountValues, 2) +
                        $this->valueOfXOfAKind($arrayCountValues, 3);
                    break;
                case 12:
                    $score = 15;
                    break;
                case 13:
                    $score = 20;
                    break;
                case 14:
                    $score = array_sum($hand);
                    break;
            }
        }
        $this->yatzyColumn[$value] = $score;
    }

    private function checkFirst6(int $value, array $hand): bool
    {
        if (in_array($value, $hand)) {
            return true;
        }
        return false;
    }

    private function getAllPairValues(array $arrayCountValues): array
    {
        $pairValues = [];
        foreach ($arrayCountValues as $key => $value) {
            if ($value === 2) {
                $pairValues[] = (int) $key;
            }
        }
        return $pairValues;
    }

    private function valueOfXOfAKind(array $arrayCountValues, int $x): int
    {
        foreach ($arrayCountValues as $key => $value) {
            if ($value === $x) {
                return (int) $key;
            }
        }
    }

    private function nrOfPairs(array $arrayCountValues): int
    {
        return count(array_keys(array_values($arrayCountValues), 2));
    }

    private function nrOfAKind(array $arrayCountValues, int $value): int
    {
        return count(array_keys(array_values($arrayCountValues), $value));
    }

    private function nrOfFourOfAKind(array $arrayCountValues): int
    {
        return $this->nrOfAKind($arrayCountValues, 4);
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
