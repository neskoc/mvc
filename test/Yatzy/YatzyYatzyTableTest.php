<?php

declare(strict_types=1);

namespace neskoc\Yatzy;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for the controller Debug.
 */
final class YatzyYatzyTableTest extends TestCase
{
    /**
     * Test YatzyTable class.
     */
    private YatzyTable $yatzyTable;

    protected function setUp(): void
    {
        $this->yatzyTable = new YatzyTable(2);
    }

    public function testCreateYatzyPlayerClass(): void
    {
        $this->assertInstanceOf("\\neskoc\Yatzy\YatzyTable", $this->yatzyTable);
    }

    public function testSlotEnabled(): void
    {
        $rowNr = 11;
        $this->yatzyTable->disableSlot($rowNr);

        $this->assertFalse($this->yatzyTable->isSlotEnabled($rowNr));
    }

    public function testIsChanceAvailableAndEnabled(): void
    {
        $this->assertTrue($this->yatzyTable->isChanceAvailableAndEnabled());
    }

    public function testIsSlotAvailableAllowedAndEnabled(): void
    {
        $lastHand = [1, 2, 3, 4, 5];
        $this->yatzyTable->setLastHand($lastHand);
        $this->assertEquals($lastHand, $this->yatzyTable->getLastHand());

        $rowNr = 1;
        $this->assertTrue($this->yatzyTable->isSlotAvailableAllowedAndEnabled($rowNr));

        $this->yatzyTable->saveValue($rowNr);
        $this->assertTrue($this->yatzyTable->isSlotAllowed($rowNr), 'isSlotAllowed');

        $this->assertFalse($this->yatzyTable->isSlotAvailableAllowedAndEnabled($rowNr));

        $this->assertTrue($this->yatzyTable->isAnySlotAvailableAllowedAndEnabled());
    }
}
