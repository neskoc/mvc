<?php

/**
 * View template for Dice Game.
 */

declare(strict_types=1);

namespace neskoc\Yatzy;

$header = $header ?? null;
$message = $message ?? null;

?>

<h1><?= $header ?></h1>

<p><?= $message ?></p>

<form action="#" method="POST">
    <label for="nrOfPlayers">Ange antal spelare</label>
    <input class="shortInput" type="number" step="1" value='1' 
        placeholder='1' min='1' id="nrOfPlayers" name="nrOfPlayers">
    <input name="playGame" type="submit" value="Play">
</form>
<br>
