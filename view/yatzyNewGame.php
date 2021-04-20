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

<h2><?= $message ?></h2>

<form action="#" method="POST">
    <input name="playGame" type="submit" value="Play">
</form>
<br>
