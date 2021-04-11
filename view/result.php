<?php

/**
 * View template for Dice Game.
 */

declare(strict_types=1);

namespace neskoc\Dice;

$header = $header ?? null;
$message = $message ?? null;
$computerRolls = $computerRolls ?? ["" => "Empty"];

?>

<h1><?= $header ?></h1>

<?php
if (!is_null($message)) {
    echo('<p class="big_message">' . $message . "</p>");
}
?>

Current Balance <br>
You: &#8383;<?= $humanBalance ?> | Computer: &#8383;<?= $computerBalance ?><br><br>

Your score:  <?= $humanScore ?><br>
Your last hand: <?= $humanLastHand ?>
<div class="dice-utf8">
<?php
foreach ($graphicalHand as $value) {
    echo('<div class="dice-' . $value . '"></div>');
}
?>
</div>
<p class="big_message"><?= $result ?></p>

Computer score:  <?= $computerScore ?> <br>
Computer hands: | 
<?php
foreach ($computerRolls as $roll) {
    echo(' ' . $roll . " | ");
}
?> 
<br><br>

Status rounds (wins):<br>
You: <?= $score["human"] ?> | Computer: <?= $score["computer"] ?>
<br><br>

<form action="game21" method="POST">
    <button name="resetGame">Reset game</button>
    <input name="playGame" type="submit" value="Play new round">
</form>
<br>
