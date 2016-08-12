<?php

namespace app\extension\guzzlehttp\guzzle\src\Adapter;

use app\extension\guzzlehttp\guzzle\src\ClientInterface;
use app\extension\guzzlehttp\guzzle\src\Message\RequestInterface;
use app\extension\guzzlehttp\guzzle\src\Message\ResponseInterface;

/**
 * Represents a transactions that consists of a request, response, and client
 */
interface TransactionInterface
{
    /**
     * @return RequestInterface
     */
    public function getRequest();

    /**
     * @return ResponseInterface|null
     */
    public function getResponse();

    /**
     * Set a response on the transaction
     *
     * @param ResponseInterface $response Response to set
     */
    public function setResponse(ResponseInterface $response);

    /**
     * @return ClientInterface
     */
    public function getClient();
}
