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
        return $this->start();
    }

    public function initialize(): ResponseInterface
    {
        $callable = new YatzyGame();
        $_SESSION['yatzy-game'] = serialize($callable);

        $body = $callable->initialize();

        return $this->gamePsr17Factory($body);
    }

    public function start(): ResponseInterface
    {
        $callable = unserialize($_SESSION['yatzy-game']);

        $body = $callable->newGame();

        return $this->gamePsr17Factory($body);
    }

    public function playGame(): ResponseInterface
    {
        $callable = unserialize($_SESSION['yatzy-game']);
        $body = $callable->playGame();

        return $this->gamePsr17Factory($body);
    }

    public function playRound(): ResponseInterface
    {
        $callable = unserialize($_SESSION['yatzy-game']);
        $body = $callable->playRound();

        return $this->gamePsr17Factory($body);
    }

    public function roll(): ResponseInterface
    {
        $callable = unserialize($_SESSION['yatzy-game']);
        $body = $callable->roll();

        return $this->gamePsr17Factory($body);
    }
}
