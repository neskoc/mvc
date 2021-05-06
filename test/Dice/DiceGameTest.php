<?php

declare(strict_types=1);

namespace neskoc\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for the controller Debug.
 */
final class DiceGameTest extends TestCase
{
    /**
     * Test Game class.
     */
    private Game $game;

    protected function setUp(): void
    {
        $this->game = new Game();
    }

    public function testCreateGameClass(): void
    {
        $this->assertInstanceOf("\\neskoc\Dice\Game", $this->game);
    }

    public function testPlayHumanHandFalse(): void
    {
        $humanPlayer = $this->createStub(HumanPlayer::class);
        $humanPlayer->method('playHand')
            ->willReturn(15);
        $this->game->addHumanPlayer($humanPlayer);

        $this->assertFalse($this->game->playHumanHand());
    }

    public function testPlayHumanHandTrue(): void
    {
        $humanPlayer = $this->createStub(HumanPlayer::class);

        $humanPlayer->method('playHand')
            ->willReturn(22);
        $this->game->addHumanPlayer($humanPlayer);

        $this->assertTrue($this->game->playHumanHand());
    }

    public function testPlayComputerHand(): void
    {
        $rolls = ["⚅", "⚃"];
        $computerPlayer = $this->createStub(ComputerPlayer::class);
        $computerPlayer->method('getLastGraphicalHand')
            ->willReturn($rolls);
        $computerPlayer->method('playHand')
            ->willReturn(10);
        $humanPlayer = $this->createStub(HumanPlayer::class);
        $humanPlayer->method('getRoundScore')
            ->willReturn(5);

        $this->game->addComputerPlayer($computerPlayer);
        $this->game->addHumanPlayer($humanPlayer);

        $this->assertEquals([$rolls], $this->game->playComputerHand());
    }


    public function testNewGame(): void
    {
        $body = $this->game->newGame();

        $this->assertStringContainsString("&#8383;10", $body, $body);
    }

    public function testPlayGame(): void
    {
        $body = $this->game->playGame();

        $this->assertStringContainsString("&#8383;10", $body, $body);
    }

    public function testPlayRoundLost(): void
    {
        $_POST['bet'] = "2";
        $_POST['nrOfDices'] = "2";
        $_POST['roll'] = "";
        $rolls = ["⚅", "⚃"];

        $body = $this->game->playRound();

        $this->assertEquals(1, $this->game->getRounds());
        $this->assertStringContainsString("&#8383;10", $body, $body);

        unset($_POST['roll']);

        $computerPlayer = $this->createStub(ComputerPlayer::class);
        $computerPlayer->method('getLastGraphicalHand')
            ->willReturn($rolls);
        $computerPlayer->method('playHand')
            ->willReturn(10);
        $computerPlayer->method('getRoundScore')
            ->willReturn(20);
        $humanPlayer = $this->createStub(HumanPlayer::class);
        $humanPlayer->method('getRoundScore')
            ->willReturn(5);
        $computerPlayer->method('getRoundScore')
            ->willReturn(22);

        $this->game->addComputerPlayer($computerPlayer);
        $this->game->addHumanPlayer($humanPlayer);

        $this->game->playRound();
        $this->assertEquals(2, $this->game->getRounds());
    }

    public function testPlayRoundWin(): void
    {
        $_POST['bet'] = "2";
        $_POST['nrOfDices'] = "2";
        $_POST['stop'] = "";
        $rolls = ["⚅", "⚃"];


        $computerPlayer = $this->createStub(ComputerPlayer::class);
        $computerPlayer->method('getLastGraphicalHand')
            ->willReturn($rolls);
        $computerPlayer->method('playHand')
            ->willReturn(10);
        $computerPlayer->method('getRoundScore')
            ->willReturn(22);
        $humanPlayer = $this->createStub(HumanPlayer::class);
        $humanPlayer->method('getRoundScore')
            ->willReturn(5);
        $computerPlayer->method('getRoundScore')
            ->willReturn(19);

        $this->game->addComputerPlayer($computerPlayer);
        $this->game->addHumanPlayer($humanPlayer);

        $this->game->playRound();
        $this->assertEquals(1, $this->game->getRounds());
    }

    public function testAddWin(): void
    {
        $this->game->addWin(true);
        $score = $this->game->getScore();

        $this->assertEquals(0, $score["human"]);
        $this->assertEquals(1, $score["computer"]);

        $this->game->addWin(false);
        $score = $this->game->getScore();

        $this->assertEquals(1, $score["human"]);
        $this->assertEquals(1, $score["computer"]);
    }
}
