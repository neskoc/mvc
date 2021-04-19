<?php

declare(strict_types=1);

namespace neskoc\Dice;

use function Mos\Functions\renderView;

/**
 * Game class.
 */

class Game
{
    private HumanPlayer $humanPlayer;
    private ComputerPlayer $computerPlayer;
    private int $rounds = 0;
    private int $bet;

    public function __construct()
    {
        $this->humanPlayer = new HumanPlayer();
        $this->computerPlayer = new ComputerPlayer();
    }

    public function newGame(): string
    {
        $data = [
            "header" => "Game 21 (new game)",
            "humanBalance" => $this->humanPlayer->getBalance(),
            "maxBet" => min($this->humanPlayer->getBalance() / 2, $this->computerPlayer->getBalance()),
            "computerBalance" => $this->computerPlayer->getBalance()
        ];

        $body = renderView("layout/game21.php", $data);

        return $body;
    }

    public function playGame(): string
    {
        $data = [
            "header" => "Game 21 (play)",
            "humanBalance" => $this->humanPlayer->getBalance(),
            "maxBet" => min($this->humanPlayer->getBalance() / 2, $this->computerPlayer->getBalance()),
            "computerBalance" => $this->computerPlayer->getBalance()
        ];

        $body = renderView("layout/play.php", $data);

        return $body;
    }

    public function playRound(): string
    {
        $_SESSION['nrOfDices'] = (int) $_POST['nrOfDices'];
        $this->bet = (int) $_POST['bet'];
        $this->rounds += 1;

        $this->humanPlayer->startRound($_SESSION['nrOfDices']);
        $this->computerPlayer->startRound($_SESSION['nrOfDices']);

        return $this->roll();
    }

    public function roll(): string
    {
        $lost = false;

        if (isset($_POST['roll']) || isset($_POST['playHand'])) {
            $lost = $this->playHumanHand();
            if ($this->humanPlayer->getRoundScore() === 21) {
                $playComputerHand = true;
            } else {
                $playComputerHand = false;
            }
        } else {
            $playComputerHand = true;
        }
        if ($playComputerHand) {
            $computerRolls = $this->playComputerHand();

            $lost = false;

            if ($this->computerPlayer->getRoundScore() >= $this->humanPlayer->getRoundScore() && $this->computerPlayer->getRoundScore() <= 21) {
                $lost = true;
            }
        }

        if ($lost) {
            $this->humanPlayer->removeBitcoins($this->bet);
            $this->computerPlayer->addBitcoins($this->bet);
        } elseif (isset($_POST['stop'])) {
            $this->computerPlayer->removeBitcoins($this->bet);
            $this->humanPlayer->addBitcoins($this->bet);
        }

        $data = [
            "header" => "Play round {$this->rounds}",
            "message" => $this->humanPlayer->getRoundScore() === 21 ? "You've got 21! Congratulation!" : null,
            "humanBalance" => $this->humanPlayer->getBalance(),
            "computerBalance" => $this->computerPlayer->getBalance(),
            "humanScore" => $this->humanPlayer->getRoundScore(),
            "humanLastHand" => $this->humanPlayer->getLastHand(),
            "graphicalHand" => $this->humanPlayer->getLastGraphicalHand(),
            "computerScore" => $this->computerPlayer->getRoundScore() ?? null,
            "computerRolls"  => $computerRolls ?? null,
            "bet" => $this->bet,
            "nrOfDices" => $_SESSION['nrOfDices']
        ];

        if (!$lost && !isset($_POST['stop']) && !$playComputerHand) {
            $_SESSION['game'] = serialize($this);
            $body = renderView("layout/hand.php", $data);
        } else {
            $this->addWin($lost);
            $_SESSION['game'] = serialize($this);
            $data["header"] = "Result round {$this->rounds}";
            $data["score"] = $this->getScore();
            $data["result"] = $lost ? "You lost this round" : "You won this round";
            $body = renderView("layout/result.php", $data);
        }

        return $body;
    }

    public function playHumanHand(): bool
    {
        $res = $this->humanPlayer->playHand();
        // var_dump($this->humanPlayer->getLastHand());
        // exit();
        if ($res > 21) {
            return true;
        }
        return false;
    }

    public function playComputerHand(): array
    {
        $rolls = [];
        do {
            $res = $this->computerPlayer->playHand();
            $rolls[] = $this->computerPlayer->getLastHand();
        } while ($res < 21 && $res < $this->humanPlayer->getRoundScore());

        return $rolls;
    }

    public function addWin($lost): void
    {
        if ($lost) {
            $this->computerPlayer->increaseWins();
        } else {
            $this->humanPlayer->increaseWins();
        }
        /* if ($this->rounds === 4) {
            var_dump($this->getScore());
            exit();
        } */
    }

    public function getRounds(): int
    {
        return $this->rounds;
    }

    public function getScore(): array
    {
        $score = [
            "human" => $this->humanPlayer->getWins(),
            "computer" => $this->computerPlayer->getWins()
        ];
        return $score;
    }
}
