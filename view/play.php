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

Current Balance <br>
You: &#8383;<?= $humanBalance ?> | Computer: &#8383;<?= $computerBalance ?><br><br>
<form action="game21" method="POST">
    <label for="nrOfDices">Choose number of dices:</label>
    <select name="nrOfDices" id="nrOfDices">
        <option value="1">1</option>
        <option value="2" selected>2</option>
    </select><br>
    <label for="bet">Bet value (&#8383;):</label>
    <input class="shortInput" type="number" step="0.1" value='2' placeholder='0.0' min='0.1' max='<?= $maxBet ?>' id="bet" name="bet">
    <br><br>
    <input name="playHand" type="submit" value="Play hand">
</form>
<br>
