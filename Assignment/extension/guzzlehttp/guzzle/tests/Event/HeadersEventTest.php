<?php

namespace app\extension\guzzlehttp\guzzle\src\Tests\Event;

use app\extension\guzzlehttp\guzzle\src\Adapter\Transaction;
use app\extension\guzzlehttp\guzzle\src\Client;
use app\extension\guzzlehttp\guzzle\src\Event\HeadersEvent;
use app\extension\guzzlehttp\guzzle\src\Message\Request;
use app\extension\guzzlehttp\guzzle\src\Message\Response;

/**
 * @covers app\extension\guzzlehttp\guzzle\src\Event\HeadersEvent
 */
class HeadersEventTest extends \PHPUnit_Framework_TestCase
{
    public function testHasValues()
    {
        $c = new Client();
        $r = new Request('GET', '/');
        $t = new Transaction($c, $r);
        $response = new Response(200);
        $t->setResponse($response);
        $e = new HeadersEvent($t);
        $this->assertSame($c, $e->getClient());
        $this->assertSame($r, $e->getRequest());
        $this->assertSame($response, $e->getResponse());
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testEnsuresResponseIsSet()
    {
        $c = new Client();
        $r = new Request('GET', '/');
        $t = new Transaction($c, $r);
        new HeadersEvent($t);
    }
}
