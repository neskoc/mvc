<?php

declare(strict_types=1);

namespace neskoc\Controller;

use neskoc\Dice\Game;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseInterface;

/**
 * Controller for a Game21 route an controller class.
 */
class Game21
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
        $callable = new Game();
        $_SESSION['game'] = serialize($callable);

        $body = $callable->newGame();

        return $this->gamePsr17Factory($body);
    }

    public function start(): ResponseInterface
    {
        $callable = new Game();
        $_SESSION['game'] = serialize($callable);

        $body = $callable->newGame();

        return $this->gamePsr17Factory($body);
    }

    public function playGame(): ResponseInterface
    {
        $callable = unserialize($_SESSION['game']);
        $body = $callable->playGame();

        return $this->gamePsr17Factory($body);
    }

    public function playRound(): ResponseInterface
    {
        $callable = unserialize($_SESSION['game']);
        $body = $callable->playRound();

        return $this->gamePsr17Factory($body);
    }

    public function roll(): ResponseInterface
    {
        $callable = unserialize($_SESSION['game']);
        $body = $callable->roll();

        return $this->gamePsr17Factory($body);
    }
}
