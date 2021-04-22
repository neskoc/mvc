<?php

/**
 * View template for Dice Game.
 */

declare(strict_types=1);

namespace neskoc\Yatzy;
use function Mos\Functions\url;

$rollNr = $rollNr ?? 1;
$header = $header ?? null;
$message = $message ?? null;
$debug = $debug ?? null;

?>

<section>
<h1><?= $header ?></h1>

<h2>Spelare: <?= $playerNr ?>, Omgång: <?= $round ?>,  Slag: <?= $rollNr ?></h2>
<?php
if ($debug != null) {
    echo("Debug:" . $debug);
}
?>

<p>
    Välj rad du vill spara i. Om du väljer redan spelat slag stryks det.
</p>

<form action="" method="POST">
    <input name="keep" type="submit" value="Spara värdet">
    <?= $hand ?>

    <div>
        <?= $table ?>
    </div>
</form>

</section>
