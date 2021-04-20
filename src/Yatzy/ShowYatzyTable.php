<?php

declare(strict_types=1);

namespace neskoc\Yatzy;

use neskoc\Yatzy\ShowYatzyTableInterface;

/**
 * ShowYatzyTable trait.
 */

trait ShowYatzyTable
{
    public YatzyTable $yatzyTable;

    public function showYatzyTable(YatzyTable $yatzyTable): string
    {
        /*
        <tr>
            <th>Spelare:</th>
            <th>1</th>
            <th>2</th>
        </tr>
        <tr>
            <td class="left">Ettor</td>
            <td class="right">2</td>
            <td class="right">4</td>
        </tr>
        <tr>
            <td class="left">Ettor</td>
            <td class="right">2</td>
            <td class="right">4</td>
        </tr>
        */
        $htmlTableBlock = "";
        $htmlTableBlock .= '<table class="yatzy-table"';
        $tableHeader = '<tr class="yatzy-header">';
        $tableHeader .= "<th>SPELARE:</th>";
        for ($i = 0; $i < $yatzyTable->yatzyColumns; $i += 1) {
            $tableHeader .= '<th class="center">Player ' . "{$i}</th>";
        }
        $tableHeader .= "</tr>";
        $tableRows = "";
        for ($i = 0; $i < 6; $i += 1) {
            $tableRows .= $this->addTableRow($i);
        }
        for ($i = 6; $i < $yatzyTable::ROWS; $i += 1) {
            $tableRows .= $this->addTableRow($i);
        }
        $htmlTableBlock .= $tableHeader;
        $htmlTableBlock .= $tableRows;
        $htmlTableBlock .= '</table>';
        return $htmlTableBlock;
    }

    private function addTableRow(int $rowNr, bool $addRadioButtons = false): string
    {
        $tableRow = '<tr class="yatzy-row">';
        $tableRow .= '<td class="left">"' . "{$this->yatzyTable::ROW_NAMES[$rowNr]}</td>";
        for ($j = 0; $j < $this->yatzyTable->yatzyColumns; $j += 1) {
            $tableRow .= '<td class="right">' . "{$this->yatzyTable->yatzyColumns[$j]->yatzyColumn[$rowNr]}</td>";
        }
        if ($addRadioButtons) {
            // <input type="radio" id="male" name="gender" value="male">
            // <label for="male">Male</label><br>
            // <input type="radio" id="female" name="gender" value="female">
            $radioButton = '<input class="select" type="radio" id="' . $rowNr . '" name="choice" value="' . $rowNr . '">';
            $tableRow .= '<td class="center">' . "{$radioButton}</td>";
        }
        $tableRow .= '</tr>';
        return $tableRow;
    }
}
