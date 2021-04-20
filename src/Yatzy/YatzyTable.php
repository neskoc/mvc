<?php

declare(strict_types=1);

namespace neskoc\Yatzy;

/**
 * YatzyTable class.
 */

class YatzyTable
{
    public const ROWS = 14; // extended yatzy
    public const ROW_NAMES = [
        "Ettor",
        "Tvåor",
        "Treor",
        "Fyror",
        "Femmor",
        "Sexor",
        "Par",
        "Två par",
        "Triss",
        "Fyrtal",
        "Kåk",
        "Liten stege",
        "Stor stege",
        "Chans"
    ];
    public array $yatzyColumns; // array of YatzyColumn(s)
    public YatzyColumn $currentColumn;
    public int $nrYazyColumns = 0; // one for each Player

    public function __construct(int $nrOfPlayers) {
        for ($i = 0; $i < $nrOfPlayers; $i += 1) {
            $this->addYatzyColumn(new YatzyColumn());
        }
        $this->currentColumn = $this->yatzyColumns[0];
    }

    public function addYatzyColumn(YatzyColumnInterface $yatzyColumn)
    {
        $this->nrYazyColumns += 1;
        $this->yatzyColumns[] = $yatzyColumn;
    }

    public function getAvailableSlots(array $hand): array
    {
        if ($this->currentColumn->yatzy !== 0 && count(array_unique($hand)) === 5) {
            $this->currentColumn->yatzy = 50;
        };
        return $this->currentColumn->getAvailableSlots($hand);
    }

    public function disableSlot(int $rowNr): void
    {
        $this->currentColumn->disableSlot($rowNr);
    }

    private function checkIfSlotAllowed(int $value, array $hand): bool
    {
        return $this->currentColumn->checkIfSlotAllowed($value, $hand);
    }

    private function saveValue(int $value, array $hand)
    {
        $this->currentColumn->saveValue($value, $hand);
    }
}
