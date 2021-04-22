<?php

/**
 * Standard view template to generate a simple web page, or part of a web page.
 */

declare(strict_types=1);

use function Mos\Functions\url;

?>
<!doctype html>
<head>
    <meta charset="utf-8">
    <title><?= $title ?? "mvc" ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="<?= url("/favicon.ico") ?>">
    <link rel="stylesheet" type="text/css" href="<?= url("/css/style.css") ?>">
</head>

<body>

<header>
    <nav>
        <a href="<?= url("/") ?>">Home</a> |
        <a href="<?= url("/session") ?>">Session</a> |
        <a href="<?= url("/debug") ?>">Debug</a> |
        <a href="<?= url("/some/where") ?>">some/where</a> |
        <a href="<?= url("/no/such/path") ?>">Show 404 example</a> |
        <a href="<?= url("/game21") ?>">Game 21</a> |
        <a href="<?= url("/yatzy") ?>">Yatzy</a>
    </nav>
</header>
<main>
