<?php

declare(strict_types=1);

namespace neskoc\Yatzy;

use neskoc\Dice\NewDiceHand;
use function Mos\Functions\renderView;
use function Mos\Functions\askForPostAndGetParams as askForPostAndGetParams;

/**
 * YatzyGame class.
 */

class YatzyGame
{
    private const NR_OF_DICES = 5;
    private const NR_OF_ROLLS = 3;

    private int $rollNr = 0;
    private int $round = 1;
    private int $playerNr = 1;
    private array $savedDices = [];

    public array $yatzyPlayers;
    public int $nrOfPlayers;
    public NewDiceHand $diceHand;
    public YatzyTable $yatzyTable;

    public YatzyPlayer $currentPlayer;

    public function __construct()
    {
        $this->diceHand = new NewDiceHand(5);
    }

    public function initialize(): string
    {
        $data = [
            "header" => "Yatzy (startsida)"
        ];

        $body = renderView("layout/yatzy.php", $data);

        return $body;
    }

    public function newGame(): string
    {
        if (isset($_POST['nrOfPlayers'])) {
            $this->nrOfPlayers = (int) $_POST['nrOfPlayers'];

            for ($i = 1; $i <= $this->nrOfPlayers; $i += 1) {
                $this->yatzyPlayers[$i] = new YatzyPlayer($i);
            }
            $this->currentPlayer = $this->yatzyPlayers[$this->playerNr];
            $this->yatzyTable = new YatzyTable($this->nrOfPlayers);
            $this->round = 1;
        }

        $params = askForPostAndGetParams();
        $this->savedDices = $params['dice'] ?? [];

        $res = $this->diceHand->rollSelectively($this->savedDices);
        $this->rollNr += 1;

        // $debug = json_encode($this->savedDices) . json_encode($res);
        $data = [
            "header" => "Yatzy (omgångar)",
            "message" => '',
            "table" => $this->yatzyTable->showYatzyTable($this->yatzyTable),
            "round" => $this->round,
            "playerNr" => $this->playerNr,
            "rollNr" => $this->rollNr,
            "hand" => $this->showHandChoices($this->diceHand->getLastGraphicalHand()),
            "debug" => ''
        ];

        $body = renderView("layout/yatzyNewGame.php", $data);

        return $body;
    }

    public function saveHand(): string
    {
        $params = askForPostAndGetParams();
        $this->savedDices = $params['dice'] ?? [];
        if (isset($params['keep'])) {
            // $debug = json_encode($params);
            $diceHand = $this->diceHand->getLastHand();
            $choice = (int) $params["choice"];
            $this->yatzyTable->currentColumn->saveValue($choice, $diceHand);
        }
        $data = [
            "header" => "Yatzy (spara)",
            "message" => '',
            "table" => $this->yatzyTable->showYatzyTable($this->yatzyTable, true),
            "round" => $this->round,
            "playerNr" => $this->playerNr,
            "rollNr" => $this->rollNr,
            "hand" => $this->showHandChoices($this->diceHand->getLastGraphicalHand()),
            "debug" => '' //$debug
        ];

        $body = renderView("layout/yatzySaveHand.php", $data);

        return $body;
    }

    public function playGame(): string
    {
        $this->currentPlayer = $this->yatzyPlayers[1];
        $this->yatzyTable = new YatzyTable($this->nrOfPlayers);

        $data = [
            "header" => "Yatzy (new game)",
            "message" => "Spelare {$this->currentPlayer->playerNr}",
            "table" => $this->yatzyTable->showYatzyTable($this->yatzyTable)
        ];
        $body = renderView("layout/yatzyNewGame.php", $data);

        return $body;
    }

    private function showHandChoices(array $graphicalHand, bool $withCheckboxes = true): string
    {
        $htmlTextContent = '<ul class="hand-choice">';
        for ($i = 0; $i < self::NR_OF_DICES; $i += 1) {
            $checked = '';
            if (in_array($i, $this->savedDices)) {
                $checked = " checked";
            }
            $htmlTextContent .= '<li class="dice-column">';
            $htmlTextContent .= "<div class=\"dice\">{$graphicalHand[$i]}";
            $htmlTextContent .= '</div>';
            $htmlTextContent .= '<div class="lower-row">';
            if ($withCheckboxes) {
                $htmlTextContent .= '<input type="checkbox" name="dice[]" value="' . "{$i}\"{$checked}>";
            }
            $htmlTextContent .= '</div>';
            $htmlTextContent .= "</div></li>";
        }
        $htmlTextContent .= "</ul>";

        return $htmlTextContent;
    }
}
// echo '<pre>' . var_export($this->currentPlayer, true) . '</pre>';
// exit();
