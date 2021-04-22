<?php

declare(strict_types=1);

namespace neskoc\Yatzy;

use neskoc\Yatzy\ShowYatzyTableInterface;

/**
 * ShowYatzyTable trait.
 */

trait ShowYatzyTable
{
    private YatzyTable $yatzyTable;

    public function showYatzyTable(YatzyTable $yatzyTable, bool $addRadioButtons = false): string
    {
        $this->yatzyTable = $yatzyTable;

        $htmlTableBlock = "";
        $htmlTableBlock .= '<table class="table table-bordered">';
        $tableHeader = '<thead>';
        $tableHeader .= "<tr>";
        $tableHeader .= '<th class="right">SPELARE </th>';
        for ($i = 1; $i <= $yatzyTable->nrYazyColumns; $i += 1) {
            $tableHeader .= '<th class="center">Spelare ' . "{$i}</th>";
        }
        if ($addRadioButtons) {
            $tableHeader .= '<th class="center">Val</th>';
        }
        $tableHeader .= "</tr>";
        $tableHeader .= '</thead>';
        $tableBody = "<tbody>";
        for ($i = 0; $i < 6; $i += 1) {
            $tableBody .= $this->addTableRow($i, $addRadioButtons);
        }
        $tableBody .= $this->addRow("SUMMA:", $this->yatzyTable->yatzyColumns, "summa");
        $tableBody .= $this->addRow("BONUS(50)", $this->yatzyTable->yatzyColumns, "bonus");
        for ($i = 6; $i < $yatzyTable::ROWS; $i += 1) {
            $tableBody .= $this->addTableRow($i, $addRadioButtons);
        }
        $tableBody .= $this->addRow("Yatzy(50)", $this->yatzyTable->yatzyColumns, "yatzy");
        $tableBody .= $this->addRow("TOTAL:", $this->yatzyTable->yatzyColumns, "total");
        $tableBody .= "</tbody>";
        $htmlTableBlock .= $tableHeader;
        $htmlTableBlock .= $tableBody;
        $htmlTableBlock .= '</table>';
        return $htmlTableBlock;
    }

    private function addRow(string $rowName, array $handlers, string $value): string
    {
        $tableRow = "<tr>";
        $tableRow .= '<td class="left">' . $rowName . '</td>';
        for ($i = 0; $i < $this->yatzyTable->nrYazyColumns; $i += 1) {
            $tableRow .= '<td class="right">' . $handlers[$i]->$value . '</td>';
        }
        $tableRow .= "</tr>";

        return $tableRow;
    }

    private function addTableRow(int $rowNr, bool $addRadioButtons = false): string
    {
        $tableRow = '<tr class="yatzy-row">';
        $tableRow .= '<td class="left">' . "{$this->yatzyTable::ROW_NAMES[$rowNr]}";
        for ($j = 0; $j < $this->yatzyTable->nrYazyColumns; $j += 1) {
            $rowValue = $this->yatzyTable->yatzyColumns[$j]->yatzyColumn[$rowNr] ?? "";
            $tableRow .= '<td class="right">' . "{$rowValue}</td>";
        }
        if ($addRadioButtons) {
            $radioButton = '<input class="select input" type="radio" id="' . $rowNr .
                '" name="choice" value="' . $rowNr . '" required>';
            $tableRow .= '<td class="center">' . "{$radioButton}</td>";
        }
        $tableRow .= '</tr>';

        return $tableRow;
    }
}
