<?php

namespace app\extension\guzzlehttp\guzzle\src\Tests\Message;

use app\extension\guzzlehttp\guzzle\src\Adapter\Transaction;
use app\extension\guzzlehttp\guzzle\src\Client;
use app\extension\guzzlehttp\guzzle\src\Event\CompleteEvent;
use app\extension\guzzlehttp\guzzle\src\Message\Request;
use app\extension\guzzlehttp\guzzle\src\Message\Response;
use app\extension\guzzlehttp\guzzle\src\Subscriber\HttpError;
use app\extension\guzzlehttp\guzzle\src\Subscriber\Mock;

/**
 * @covers app\extension\guzzlehttp\guzzle\src\Subscriber\HttpError
 */
class HttpErrorTest extends \PHPUnit_Framework_TestCase
{
    public function testIgnoreSuccessfulRequests()
    {
        $event = $this->getEvent();
        $event->intercept(new Response(200));
        (new HttpError())->onComplete($event);
    }

    /**
     * @expectedException \app\extension\guzzlehttp\guzzle\src\Exception\ClientException
     */
    public function testThrowsClientExceptionOnFailure()
    {
        $event = $this->getEvent();
        $event->intercept(new Response(403));
        (new HttpError())->onComplete($event);
    }

    /**
     * @expectedException \app\extension\guzzlehttp\guzzle\src\Exception\ServerException
     */
    public function testThrowsServerExceptionOnFailure()
    {
        $event = $this->getEvent();
        $event->intercept(new Response(500));
        (new HttpError())->onComplete($event);
    }

    private function getEvent()
    {
        return new CompleteEvent(new Transaction(new Client(), new Request('PUT', '/')));
    }

    /**
     * @expectedException \app\extension\guzzlehttp\guzzle\src\Exception\ClientException
     */
    public function testFullTransaction()
    {
        $client = new Client();
        $client->getEmitter()->attach(new Mock([
            new Response(403)
        ]));
        $client->get('http://httpbin.org');
    }
}
