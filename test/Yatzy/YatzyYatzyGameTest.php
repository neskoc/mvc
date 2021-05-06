<?php

declare(strict_types=1);

namespace neskoc\Yatzy;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for the controller Debug.
 */
final class YatzyYatzyGameTest extends TestCase
{
    /**
     * @runInSeparateProcess
     */
    private YatzyGame $yatzyGame;

    protected function setUp(): void
    {
        $this->yatzyGame = new YatzyGame();
        $this->yatzyGame->diceHand->roll();
    }

    public function testCreateYatzyGameClass(): void
    {
        $this->assertInstanceOf("\\neskoc\Yatzy\YatzyGame", $this->yatzyGame);
    }

    public function testInitialize(): void
    {
        $testStr = "Yatzy (startsida)";
        $this->assertStringContainsString($testStr, $this->yatzyGame->initialize());
    }

    public function testPlayHand(): void
    {
        $testStr = "Yatzy (omgångar)";
        $_POST['nrOfPlayers'] = '1';
        $this->assertStringContainsString($testStr, $this->yatzyGame->playHand());
    }

    public function testSaveHand(): void
    {

        $nrOfPlayers = 1;
        $this->yatzyGame->nrOfPlayers = $nrOfPlayers;

        for ($i = 1; $i <= $this->yatzyGame->nrOfPlayers; $i += 1) {
            $this->yatzyGame->yatzyPlayers[$i] = new YatzyPlayer($i);
        }
        $this->yatzyGame->currentPlayer = $this->yatzyGame->yatzyPlayers[1];
        $this->yatzyGame->yatzyTable = new YatzyTable($this->yatzyGame->nrOfPlayers);

        $this->yatzyGame->yatzyTable->setLastHand([1, 2, 3, 4, 5]);

        $testStr = "Yatzy (spara)";
        $_POST['keep'] = 'Spara handen';
        $_POST['choice'] = '7';

        $this->assertStringContainsString($testStr, $this->yatzyGame->saveHand());
    }

    public function testGameOver(): void
    {
        $_POST['nrOfPlayers'] = '1';
        $this->yatzyGame->playHand();

        $testStr = "Yatzy (slut)";
        $this->assertStringContainsString($testStr, $this->yatzyGame->gameOver());
    }
}
