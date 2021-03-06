<?php

declare(strict_types=1);

namespace neskoc\Yatzy;

use neskoc\Yatzy\YatzyTable;

/**
 * YatzyPlayer class.
 */

class YatzyPlayer
{
    public int $playerNr;

    public function __construct(int $playerNr)
    {
        $this->playerNr = $playerNr;
    }
}
