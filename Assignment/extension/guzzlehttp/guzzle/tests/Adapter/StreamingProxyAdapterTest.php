<?php

namespace app\extension\guzzlehttp\guzzle\src\Tests\Adapter;

use app\extension\guzzlehttp\guzzle\src\Adapter\StreamingProxyAdapter;
use app\extension\guzzlehttp\guzzle\src\Adapter\Transaction;
use app\extension\guzzlehttp\guzzle\src\Client;
use app\extension\guzzlehttp\guzzle\src\Message\Request;
use app\extension\guzzlehttp\guzzle\src\Message\Response;

/**
 * @covers app\extension\guzzlehttp\guzzle\src\Adapter\StreamingProxyAdapter
 */
class StreamingProxyAdapterTest extends \PHPUnit_Framework_TestCase
{
    public function testSendsWithDefaultAdapter()
    {
        $response = new Response(200);
        $mock = $this->getMockBuilder('app\extension\guzzlehttp\guzzle\src\Adapter\AdapterInterface')
            ->setMethods(['send'])
            ->getMockForAbstractClass();
        $mock->expects($this->once())
            ->method('send')
            ->will($this->returnValue($response));
        $streaming = $this->getMockBuilder('app\extension\guzzlehttp\guzzle\src\Adapter\AdapterInterface')
            ->setMethods(['send'])
            ->getMockForAbstractClass();
        $streaming->expects($this->never())
            ->method('send');

        $s = new StreamingProxyAdapter($mock, $streaming);
        $this->assertSame($response, $s->send(new Transaction(new Client(), new Request('GET', '/'))));
    }

    public function testSendsWithStreamingAdapter()
    {
        $response = new Response(200);
        $mock = $this->getMockBuilder('app\extension\guzzlehttp\guzzle\src\Adapter\AdapterInterface')
            ->setMethods(['send'])
            ->getMockForAbstractClass();
        $mock->expects($this->never())
            ->method('send');
        $streaming = $this->getMockBuilder('app\extension\guzzlehttp\guzzle\src\Adapter\AdapterInterface')
            ->setMethods(['send'])
            ->getMockForAbstractClass();
        $streaming->expects($this->once())
            ->method('send')
            ->will($this->returnValue($response));
        $request = new Request('GET', '/');
        $request->getConfig()->set('stream', true);
        $s = new StreamingProxyAdapter($mock, $streaming);
        $this->assertSame($response, $s->send(new Transaction(new Client(), $request)));
    }
}
