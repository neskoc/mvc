<?php

declare(strict_types=1);

namespace neskoc\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for the controller Debug.
 */
class DiceGraphicalDiceTest extends TestCase
{
    /**
     * Try to create the GraphicalDice class.
     */
    public function testCreateGraphicalDiceClass()
    {
        $graphic = [
            1 => "⚀",
            2 => "⚁",
            3 => "⚂",
            4 => "⚃",
            5 => "⚄",
            6 => "⚅"
        ];
        // default nr of faces = 6
        $graphicalDice = new GraphicalDice();
        $this->assertInstanceOf("\\neskoc\Dice\GraphicalDice", $graphicalDice);

        $roll = $graphicalDice->roll();
        $this->assertEquals($graphicalDice->graphic(), $graphic[$roll]);
    }
}
