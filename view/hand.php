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

Number of dices: <?= $nrOfDices ?><br><br>

Your bet: &#8383;<?= $bet ?><br><br>

Your score:  <?= $humanScore ?> <br>
Your last hand: <?= $humanLastHand ?> 
<div class="dice-utf8">
<?php
foreach ($graphicalHand as $value) {
    echo('<div class="dice-' . $value . '"></div>');
}
?>
</div>

<form action="game21" method="POST">
    <button name="roll">Roll dice(s)</button>
    <input name="stop" type="submit" value="Stop">
</form>
<br>
