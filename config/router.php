<?php

/**
 * Load the routes into the router, this file is included from
 * `htdocs/index.php` during the bootstrapping to prepare for the request to
 * be handled.
 */

declare(strict_types=1);

namespace neskoc\Router;

use FastRoute\RouteCollector;

$router->addRoute("GET", "/test", function () {
    // A quick and dirty way to test the router or the request.
    return "Testing response";
});

$router->addRoute("GET", "/", "\Mos\Controller\Index");
$router->addRoute("GET", "/debug", "\Mos\Controller\Debug");
// $router->addRoute("GET", "/game21", ["\\neskoc\Controller\Game21", "start"]);

$router->addGroup("/session", function (RouteCollector $router) {
    $router->addRoute("GET", "", ["\Mos\Controller\Session", "index"]);
    $router->addRoute("GET", "/destroy", ["\Mos\Controller\Session", "destroy"]);
});

$router->addGroup("/some", function (RouteCollector $router) {
    $router->addRoute("GET", "/where", ["\Mos\Controller\Sample", "where"]);
});

$router->addGroup("/form", function (RouteCollector $router) {
    $router->addRoute("GET", "/view", ["\Mos\Controller\Form", "view"]);
    $router->addRoute("POST", "/process", ["\Mos\Controller\Form", "process"]);
});

$router->addGroup("/game21", function (RouteCollector $router) {
    // $router->addRoute("GET", "", "\\neskoc\Controller\Game21");
    $router->addRoute("GET", "", ["\\neskoc\Controller\Game21", "start"]);
    if (isset($_POST['resetGame'])) {
        $router->addRoute("POST", "", ["\\neskoc\Controller\Game21", "start"]);
    } elseif (isset($_POST['playGame'])) {
        $router->addRoute("POST", "", ["\\neskoc\Controller\Game21", "playGame"]);
    } elseif (isset($_POST['playHand'])) {
        $router->addRoute("POST", "", ["\\neskoc\Controller\Game21", "playRound"]);
    } elseif (isset($_POST['roll']) || isset($_POST['stop'])) {
        $router->addRoute("POST", "", ["\\neskoc\Controller\Game21", "roll"]);
    }
});

$router->addGroup("/yatzy", function (RouteCollector $router) {
    $router->addRoute("GET", "", ["\\neskoc\Controller\Yatzy", "initialize"]);
    $router->addRoute("GET", "/play", ["\\neskoc\Controller\Yatzy", "playHand"]);
    $router->addRoute("POST", "/play", ["\\neskoc\Controller\Yatzy", "playHand"]);
    $router->addRoute("GET", "/save", ["\\neskoc\Controller\Yatzy", "saveHand"]);
    $router->addRoute("POST", "/save", ["\\neskoc\Controller\Yatzy", "saveHand"]);
    $router->addRoute("GET", "/game-over", ["\\neskoc\Controller\Yatzy", "gameOver"]);
});
