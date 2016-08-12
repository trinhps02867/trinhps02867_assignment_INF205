<?php

namespace app\extension\guzzlehttp\guzzle\src\Tests\Adapter;

use app\extension\guzzlehttp\guzzle\src\Adapter\Transaction;
use app\extension\guzzlehttp\guzzle\src\Client;
use app\extension\guzzlehttp\guzzle\src\Message\Request;
use app\extension\guzzlehttp\guzzle\src\Message\Response;

/**
 * @covers app\extension\guzzlehttp\guzzle\src\Adapter\Transaction
 */
class TransactionTest extends \PHPUnit_Framework_TestCase
{
    public function testHasRequestAndClient()
    {
        $c = new Client();
        $req = new Request('GET', '/');
        $response = new Response(200);
        $t = new Transaction($c, $req);
        $this->assertSame($c, $t->getClient());
        $this->assertSame($req, $t->getRequest());
        $this->assertNull($t->getResponse());
        $t->setResponse($response);
        $this->assertSame($response, $t->getResponse());
    }
}
