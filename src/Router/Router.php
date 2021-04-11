<?php

declare(strict_types=1);

namespace neskoc\Router;

use neskoc\Dice\Game;

use function Mos\Functions\{
    destroySession,
    redirectTo,
    renderView,
    renderTwigView,
    sendResponse,
    url
};

/**
 * Class Router.
 */
class Router
{
    public static function dispatch(string $method, string $path): void
    {
        if ($method === "GET" && $path === "/") {
            $data = [
                "header" => "Index page",
                "message" => "Hello, this is the index page, rendered as a layout.",
            ];
            $body = renderView("layout/page.php", $data);
            sendResponse($body);
            return;
        } elseif ($method === "GET" && $path === "/session") {
            $body = renderView("layout/session.php");
            sendResponse($body);
            return;
        } elseif ($method === "GET" && $path === "/session/destroy") {
            destroySession();
            redirectTo(url("/session"));
            return;
        } elseif ($method === "GET" && $path === "/debug") {
            $body = renderView("layout/debug.php");
            sendResponse($body);
            return;
        } elseif ($method === "GET" && $path === "/twig") {
            $data = [
                "header" => "Twig page",
                "message" => "Hey, edit this to do it youreself!",
            ];
            $body = renderTwigView("index.html", $data);
            sendResponse($body);
            return;
        } elseif ($method === "GET" && $path === "/some/where") {
            $data = [
                "header" => "Rainbow page",
                "message" => "Hey, edit this to do it youreself!",
            ];
            $body = renderView("layout/page.php", $data);
            sendResponse($body);
            return;
        } elseif ($method === "GET" && $path === "/game21") {
            $callable = new Game();
            $_SESSION['game'] = serialize($callable);
            $callable->newGame();

            return;
        } elseif ($method === "POST" && $path === "/game21") {
            if (isset($_POST['resetGame'])) {
                $callable = new Game();
                $_SESSION['game'] = serialize($callable);
                $callable->newGame();
            } else {
                $callable = unserialize($_SESSION['game']);
                if (isset($_POST['playGame'])) {
                    $callable->playGame();
                } elseif (isset($_POST['playHand'])) {
                    $callable->playRound();
                } elseif (isset($_POST['roll']) || isset($_POST['stop'])) {
                    $callable->roll();
                }
            }

            return;
        }

        $data = [
            "header" => "404",
            "message" => "The page you are requesting is not here. You may also checkout the HTTP response code, it should be 404.",
        ];
        $body = renderView("layout/page.php", $data);
        sendResponse($body, 404);
    }
}
