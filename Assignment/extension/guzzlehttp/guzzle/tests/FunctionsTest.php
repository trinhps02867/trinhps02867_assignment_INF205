<?php

namespace app\extension\guzzlehttp\guzzle\src\Tests;

use app\extension\guzzlehttp\guzzle\src\Client;
use app\extension\guzzlehttp\guzzle\src\Event\BeforeEvent;
use app\extension\guzzlehttp\guzzle\src\Event\CompleteEvent;
use app\extension\guzzlehttp\guzzle\src\Event\ErrorEvent;
use app\extension\guzzlehttp\guzzle\src\Message\Response;
use app\extension\guzzlehttp\guzzle\src\Subscriber\Mock;

class FunctionsTest extends \PHPUnit_Framework_TestCase
{
    public function testExpandsTemplate()
    {
        $this->assertEquals('foo/123', \app\extension\guzzlehttp\guzzle\src\uri_template('foo/{bar}', ['bar' => '123']));
    }

    public function noBodyProvider()
    {
        return [['get'], ['head'], ['delete']];
    }

    /**
     * @dataProvider noBodyProvider
     */
    public function testSendsNoBody($method)
    {
        Server::flush();
        Server::enqueue([new Response(200)]);
        call_user_func("app\extension\guzzlehttp\guzzle\src\\{$method}", Server::$url, [
            'headers' => ['foo' => 'bar'],
            'query' => ['a' => '1']
        ]);
        $sent = Server::received(true)[0];
        $this->assertEquals(strtoupper($method), $sent->getMethod());
        $this->assertEquals('/?a=1', $sent->getResource());
        $this->assertEquals('bar', $sent->getHeader('foo'));
    }

    public function testSendsOptionsRequest()
    {
        Server::flush();
        Server::enqueue([new Response(200)]);
        \app\extension\guzzlehttp\guzzle\src\options(Server::$url, ['headers' => ['foo' => 'bar']]);
        $sent = Server::received(true)[0];
        $this->assertEquals('OPTIONS', $sent->getMethod());
        $this->assertEquals('/', $sent->getResource());
        $this->assertEquals('bar', $sent->getHeader('foo'));
    }

    public function hasBodyProvider()
    {
        return [['put'], ['post'], ['patch']];
    }

    /**
     * @dataProvider hasBodyProvider
     */
    public function testSendsWithBody($method)
    {
        Server::flush();
        Server::enqueue([new Response(200)]);
        call_user_func("app\extension\guzzlehttp\guzzle\src\\{$method}", Server::$url, [
            'headers' => ['foo' => 'bar'],
            'body'    => 'test',
            'query'   => ['a' => '1']
        ]);
        $sent = Server::received(true)[0];
        $this->assertEquals(strtoupper($method), $sent->getMethod());
        $this->assertEquals('/?a=1', $sent->getResource());
        $this->assertEquals('bar', $sent->getHeader('foo'));
        $this->assertEquals('test', $sent->getBody());
    }

    /**
     * @expectedException \PHPUnit_Framework_Error_Deprecated
     * @expectedExceptionMessage app\extension\guzzlehttp\guzzle\src\Tests\HasDeprecations::baz() is deprecated and will be removed in a future version. Update your code to use the equivalent app\extension\guzzlehttp\guzzle\src\Tests\HasDeprecations::foo() method instead to avoid breaking changes when this shim is removed.
     */
    public function testManagesDeprecatedMethods()
    {
        $d = new HasDeprecations();
        $d->baz();
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testManagesDeprecatedMethodsAndHandlesMissingMethods()
    {
        $d = new HasDeprecations();
        $d->doesNotExist();
    }

    public function testBatchesRequests()
    {
        $client = new Client();
        $responses = [
            new Response(301, ['Location' => 'http://foo.com/bar']),
            new Response(200),
            new Response(200),
            new Response(404)
        ];
        $client->getEmitter()->attach(new Mock($responses));
        $requests = [
            $client->createRequest('GET', 'http://foo.com/baz'),
            $client->createRequest('HEAD', 'http://httpbin.org/get'),
            $client->createRequest('PUT', 'http://httpbin.org/put'),
        ];

        $a = $b = $c = 0;
        $result = \app\extension\guzzlehttp\guzzle\src\batch($client, $requests, [
            'before'   => function (BeforeEvent $e) use (&$a) { $a++; },
            'complete' => function (CompleteEvent $e) use (&$b) { $b++; },
            'error'    => function (ErrorEvent $e) use (&$c) { $c++; },
        ]);

        $this->assertEquals(4, $a);
        $this->assertEquals(2, $b);
        $this->assertEquals(1, $c);
        $this->assertCount(3, $result);

        foreach ($result as $i => $request) {
            $this->assertSame($requests[$i], $request);
        }

        // The first result is actually the second (redirect) response.
        $this->assertSame($responses[1], $result[$requests[0]]);
        // The second result is a 1:1 request:response map
        $this->assertSame($responses[2], $result[$requests[1]]);
        // The third entry is the 404 RequestException
        $this->assertSame($responses[3], $result[$requests[2]]->getResponse());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid event format
     */
    public function testBatchValidatesTheEventFormat()
    {
        $client = new Client();
        $requests = [$client->createRequest('GET', 'http://foo.com/baz')];
        \app\extension\guzzlehttp\guzzle\src\batch($client, $requests, ['complete' => 'foo']);
    }

    public function testJsonDecodes()
    {
        $data = \app\extension\guzzlehttp\guzzle\src\json_decode('true');
        $this->assertTrue($data);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Unable to parse JSON data: JSON_ERROR_SYNTAX - Syntax error, malformed JSON
     */
    public function testJsonDecodesWithErrorMessages()
    {
        \app\extension\guzzlehttp\guzzle\src\json_decode('!narf!');
    }
}

class HasDeprecations
{
    function foo()
    {
        return 'abc';
    }
    function __call($name, $arguments)
    {
        return \app\extension\guzzlehttp\guzzle\src\deprecation_proxy($this, $name, $arguments, [
            'baz' => 'foo'
        ]);
    }
}
