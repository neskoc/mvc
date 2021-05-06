<?php

declare(strict_types=1);

namespace neskoc\Controller;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * Test cases for the controller Sample.
 */
class ControllerYatzyTest extends TestCase
{
    /**
     * Try to create the controller class.
     */
    public function testCreateTheControllerClass()
    {
        $controller = new Game21();
        $this->assertInstanceOf("\\neskoc\Controller\Game21", $controller);
    }

    /**
     * Check that the controller returns a response.
     */
    public function testControllerReturnsResponse()
    {
        $controller = new Game21();

        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $controller();
        $this->assertInstanceOf($exp, $res);
    }

    public function testControllerStartReturnsResponse()
    {
        $controller = new Game21();

        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $controller->start();
        $this->assertInstanceOf($exp, $res);
    }

    public function testControllerPlayGameReturnsResponse()
    {
        $controller = new Game21();

        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $controller->playGame();
        $this->assertInstanceOf($exp, $res);
    }

    public function testControllerPlayRoundReturnsResponse()
    {
        $controller = new Game21();
        $_POST['nrOfDices'] = '2';
        $_POST['bet'] = '2';
        $_POST['roll'] = "";

        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $controller->playRound();
        $this->assertInstanceOf($exp, $res);
    }

    public function testControllerRollReturnsResponse()
    {
        $controller = new Game21();

        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $controller->roll();
        $this->assertInstanceOf($exp, $res);
    }
}
