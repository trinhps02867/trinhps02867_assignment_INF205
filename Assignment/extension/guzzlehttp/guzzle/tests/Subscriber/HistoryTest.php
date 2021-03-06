<?php

namespace app\extension\guzzlehttp\guzzle\src\Tests\Subscriber;

use app\extension\guzzlehttp\guzzle\src\Adapter\Transaction;
use app\extension\guzzlehttp\guzzle\src\Client;
use app\extension\guzzlehttp\guzzle\src\Event\CompleteEvent;
use app\extension\guzzlehttp\guzzle\src\Event\ErrorEvent;
use app\extension\guzzlehttp\guzzle\src\Exception\RequestException;
use app\extension\guzzlehttp\guzzle\src\Message\Request;
use app\extension\guzzlehttp\guzzle\src\Message\Response;
use app\extension\app\extension\guzzlehttp\guzzle\src\streams\src\Stream;
use app\extension\guzzlehttp\guzzle\src\Subscriber\History;
use app\extension\guzzlehttp\guzzle\src\Subscriber\Mock;

/**
 * @covers app\extension\guzzlehttp\guzzle\src\Subscriber\History
 */
class HistoryTest extends \PHPUnit_Framework_TestCase
{
    public function testAddsForErrorEvent()
    {
        $request = new Request('GET', '/');
        $response = new Response(400);
        $t = new Transaction(new Client(), $request);
        $t->setResponse($response);
        $e = new RequestException('foo', $request, $response);
        $ev = new ErrorEvent($t, $e);
        $h = new History(2);
        $h->onError($ev);
        // Only tracks when no response is present
        $this->assertEquals([], $h->getRequests());
    }

    public function testLogsConnectionErrors()
    {
        $request = new Request('GET', '/');
        $t = new Transaction(new Client(), $request);
        $e = new RequestException('foo', $request);
        $ev = new ErrorEvent($t, $e);
        $h = new History();
        $h->onError($ev);
        $this->assertEquals([$request], $h->getRequests());
    }

    public function testMaintainsLimitValue()
    {
        $request = new Request('GET', '/');
        $response = new Response(200);
        $t = new Transaction(new Client(), $request);
        $t->setResponse($response);
        $ev = new CompleteEvent($t);
        $h = new History(2);
        $h->onComplete($ev);
        $h->onComplete($ev);
        $h->onComplete($ev);
        $this->assertEquals(2, count($h));
        $this->assertSame($request, $h->getLastRequest());
        $this->assertSame($response, $h->getLastResponse());
        foreach ($h as $trans) {
            $this->assertInstanceOf('app\extension\guzzlehttp\guzzle\src\Message\RequestInterface', $trans['request']);
            $this->assertInstanceOf('app\extension\guzzlehttp\guzzle\src\Message\ResponseInterface', $trans['response']);
        }
        return $h;
    }

    /**
     * @depends testMaintainsLimitValue
     */
    public function testClearsHistory($h)
    {
        $this->assertEquals(2, count($h));
        $h->clear();
        $this->assertEquals(0, count($h));
    }

    public function testCanCastToString()
    {
        $client = new Client(['base_url' => 'http://localhost/']);
        $h = new History();
        $client->getEmitter()->attach($h);

        $mock = new Mock(array(
            new Response(301, array('Location' => '/redirect1', 'Content-Length' => 0)),
            new Response(307, array('Location' => '/redirect2', 'Content-Length' => 0)),
            new Response(200, array('Content-Length' => '2'), Stream::factory('HI'))
        ));

        $client->getEmitter()->attach($mock);
        $request = $client->createRequest('GET', '/');
        $client->send($request);
        $this->assertEquals(3, count($h));

        $h = str_replace("\r", '', $h);
        $this->assertContains("> GET / HTTP/1.1\nHost: localhost\nUser-Agent:", $h);
        $this->assertContains("< HTTP/1.1 301 Moved Permanently\nLocation: /redirect1", $h);
        $this->assertContains("< HTTP/1.1 307 Temporary Redirect\nLocation: /redirect2", $h);
        $this->assertContains("< HTTP/1.1 200 OK\nContent-Length: 2\n\nHI", $h);
    }
}
