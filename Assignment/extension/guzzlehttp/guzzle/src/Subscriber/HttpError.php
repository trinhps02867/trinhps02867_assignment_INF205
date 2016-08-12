<?php

namespace app\extension\guzzlehttp\guzzle\src\Subscriber;

use app\extension\guzzlehttp\guzzle\src\Event\CompleteEvent;
use app\extension\guzzlehttp\guzzle\src\Event\RequestEvents;
use app\extension\guzzlehttp\guzzle\src\Event\SubscriberInterface;
use app\extension\guzzlehttp\guzzle\src\Exception\RequestException;

/**
 * Throws exceptions when a 4xx or 5xx response is received
 */
class HttpError implements SubscriberInterface
{
    public function getEvents()
    {
        return ['complete' => ['onComplete', RequestEvents::VERIFY_RESPONSE]];
    }

    /**
     * Throw a RequestException on an HTTP protocol error
     *
     * @param CompleteEvent $event Emitted event
     * @throws RequestException
     */
    public function onComplete(CompleteEvent $event)
    {
        $code = (string) $event->getResponse()->getStatusCode();
        // Throw an exception for an unsuccessful response
        if ($code[0] === '4' || $code[0] === '5') {
            throw RequestException::create($event->getRequest(), $event->getResponse());
        }
    }
}
