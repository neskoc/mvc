<?php

declare(strict_types=1);

namespace neskoc\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for the controller Debug.
 */
class DiceGameTest extends TestCase
{
    /**
     * Test Game class.
     */
    private Game $game;

    protected function setUp(): void
    {
        $this->game = new Game();
    }

    public function testCreateGameClass()
    {
        $this->assertInstanceOf("\\neskoc\Dice\Game", $this->game);
        $this->assertInstanceOf("\\neskoc\Dice\HumanPlayer", $this->game->humanPlayer);
        $this->assertInstanceOf("\\neskoc\Dice\ComputerPlayer", $this->game->computerPlayer);
    }
}
