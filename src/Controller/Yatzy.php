<?php

declare(strict_types=1);

namespace neskoc\Controller;

use neskoc\Yatzy\YatzyGame;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseInterface;

/**
 * Controller for a Yatzy route an controller class.
 */
class Yatzy
{
    private function gamePsr17Factory($body): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();
        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }

    public function __invoke(): ResponseInterface
    {
        return $this->initialize();
    }

    public function initialize(): ResponseInterface
    {
        $callable = new YatzyGame();
        $_SESSION['yatzy-game'] = serialize($callable);

        $body = $callable->initialize();

        return $this->gamePsr17Factory($body);
    }

    public function playHand(): ResponseInterface
    {
        $callable = unserialize($_SESSION['yatzy-game']);
        $body = $callable->playHand();
        $_SESSION['yatzy-game'] = serialize($callable);

        return $this->gamePsr17Factory($body);
    }

    public function saveHand(): ResponseInterface
    {
        $callable = unserialize($_SESSION['yatzy-game']);
        $body = $callable->saveHand();
        $_SESSION['yatzy-game'] = serialize($callable);

        return $this->gamePsr17Factory($body);
    }

    public function gameOver(): ResponseInterface
    {
        $callable = unserialize($_SESSION['yatzy-game']);
        $body = $callable->gameOver();

        return $this->gamePsr17Factory($body);
    }
}
