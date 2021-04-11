<?php

/**
 * View template for Dice Game.
 */

declare(strict_types=1);

namespace neskoc\Dice;

$header = $header ?? null;
$message = $message ?? null;

?>

<h1><?= $header ?></h1>

<p><?= $message ?></p>

Current Balance <br>
You: &#8383;<?= $humanBalance ?> | Computer: &#8383;<?= $computerBalance ?><br><br>
<form action="game21" method="POST">
    <input name="playGame" type="submit" value="Play">
</form>
<br>