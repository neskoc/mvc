<?php

declare(strict_types=1);

namespace neskoc\Yatzy;

/**
 * ShowYatzyTableInterface
 */

interface ShowYatzyTableInterface
{
    public function showYatzyTable(YatzyTable $yatzyTable): string;
}
