<?php

/**
 * Autoloader for classes.
 *
 * @param string $class the name of the class.
 */

spl_autoload_register(function ($class) {
    //echo "$class<br>";
    $path = "src/Dice/{$class}.php";
    if (is_file($path)) {
        include($path);
    }
    $path = "src/Yatzy/{$class}.php";
    if (is_file($path)) {
        include($path);
    }
});
