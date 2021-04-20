<?php

declare(strict_types=1);

namespace neskoc\Yatzy;

use neskoc\Dice\NewDiceHand;
use function Mos\Functions\renderView;

/**
 * YatzyGame class.
 */

class YatzyGame
{
    private const NR_OF_DICES = 5;
    private const NR_OF_ROLLS = 3;

    private array $yatzyPlayers;
    private int $nrOfPlayers;
    private NewDiceHand $diceHand;

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
        $this->nrOfPlayers = (int) $_POST['nrOfPlayers'];
        for ($i = 1; $i <= $this->nrOfPlayers; $i += 1) {
            $this->yatzyPlayers[$i] = new YatzyPlayer($i);
        }
        $this->currentPlayer = $this->yatzyPlayers[1];
        // echo '<pre>' . var_export($this->currentPlayer, true) . '</pre>';
        // exit();

        $data = [
            "header" => "Yatzy (new game)",
            "message" => "Player {$this->currentPlayer->playerNr}"
        ];

        $body = renderView("layout/yatzyNewGame.php", $data);

        return $body;
    }
}
