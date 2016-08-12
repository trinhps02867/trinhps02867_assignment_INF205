<?php

namespace app\extension\guzzlehttp\guzzle\src\Tests\Adapter\Curl;

use app\extension\guzzlehttp\guzzle\src\Adapter\Transaction;
use app\extension\guzzlehttp\guzzle\src\Client;
use app\extension\guzzlehttp\guzzle\src\Event\CompleteEvent;
use app\extension\guzzlehttp\guzzle\src\Event\ErrorEvent;
use app\extension\guzzlehttp\guzzle\src\Exception\RequestException;
use app\extension\guzzlehttp\guzzle\src\Message\Request;
use app\extension\guzzlehttp\guzzle\src\Message\Response;
use app\extension\guzzlehttp\guzzle\src\Tests\Server;
use app\extension\guzzlehttp\guzzle\src\Url;

abstract class AbstractCurl extends \PHPUnit_Framework_TestCase
{
    abstract protected function getAdapter($factory = null, $options = []);

    public function testSendsRequest()
    {
        Server::flush();
        Server::enqueue("HTTP/1.1 200 OK\r\nFoo: bar\r\nContent-Length: 0\r\n\r\n");
        $t = new Transaction(new Client(), new Request('GET', Server::$url));
        $a = $this->getAdapter();
        $response = $a->send($t);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('bar', $response->getHeader('Foo'));
    }

    /**
     * @expectedException \app\extension\guzzlehttp\guzzle\src\Exception\RequestException
     */
    public function testCatchesErrorWhenPreparing()
    {
        $r = new Request('GET', Server::$url);
        $f = $this->getMockBuilder('app\extension\guzzlehttp\guzzle\src\Adapter\Curl\CurlFactory')
            ->setMethods(['__invoke'])
            ->getMock();
        $f->expects($this->once())
            ->method('__invoke')
            ->will($this->throwException(new RequestException('foo', $r)));

        $t = new Transaction(new Client(), $r);
        $a = $this->getAdapter(null, ['handle_factory' => $f]);
        $a->send($t);
    }

    public function testDispatchesAfterSendEvent()
    {
        Server::flush();
        Server::enqueue("HTTP/1.1 201 OK\r\nContent-Length: 0\r\n\r\n");
        $r = new Request('GET', Server::$url);
        $t = new Transaction(new Client(), $r);
        $a = $this->getAdapter();
        $ev = null;
        $r->getEmitter()->on('complete', function (CompleteEvent $e) use (&$ev) {
            $ev = $e;
            $e->intercept(new Response(200, ['Foo' => 'bar']));
        });
        $response = $a->send($t);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('bar', $response->getHeader('Foo'));
    }

    public function testDispatchesErrorEventAndRecovers()
    {
        Server::flush();
        Server::enqueue("HTTP/1.1 201 OK\r\nContent-Length: 0\r\n\r\n");
        $r = new Request('GET', Server::$url);
        $t = new Transaction(new Client(), $r);
        $a = $this->getAdapter();
        $r->getEmitter()->once('complete', function (CompleteEvent $e) {
            throw new RequestException('Foo', $e->getRequest());
        });
        $r->getEmitter()->on('error', function (ErrorEvent $e) {
            $e->intercept(new Response(200, ['Foo' => 'bar']));
        });
        $response = $a->send($t);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('bar', $response->getHeader('Foo'));
    }

    public function testStripsFragmentFromHost()
    {
        Server::flush();
        Server::enqueue("HTTP/1.1 200 OK\r\n\r\nContent-Length: 0\r\n\r\n");
        // This will fail if the removal of the #fragment is not performed
        $url = Url::fromString(Server::$url)->setPath(null)->setFragment('foo');
        $client = new Client();
        $client->get($url);
    }
}
