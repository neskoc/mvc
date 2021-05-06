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
        $controller = new Yatzy();
        $this->assertInstanceOf("\\neskoc\Controller\Yatzy", $controller);
    }

    /**
     * Check that the controller returns a response.
     */
    public function testControllerReturnsResponse()
    {
        $controller = new Yatzy();

        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $controller();
        $this->assertInstanceOf($exp, $res);
    }

    public function testControllerPlayHandReturnsResponse()
    {
        $controller = new Yatzy();
        $_POST['nrOfPlayers'] = '1';

        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $controller->playHand();
        $this->assertInstanceOf($exp, $res);
    }

    public function testControllerSaveHandReturnsResponse()
    {
        $controller = new Yatzy();

        $_POST['keep'] = 'Spara handen';
        $_POST['choice'] = '7';

        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $controller->saveHand();
        $this->assertInstanceOf($exp, $res);
    }
    public function testControllerGameOverReturnsResponse()
    {
        $controller = new Yatzy();

        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $controller->gameOver();
        $this->assertInstanceOf($exp, $res);
    }
}
