<?php

namespace app\extension\guzzlehttp\guzzle\src\Tests\Event;

use app\extension\guzzlehttp\guzzle\src\Exception\ParseException;
use app\extension\guzzlehttp\guzzle\src\Message\Response;

/**
 * @covers app\extension\guzzlehttp\guzzle\src\Exception\ParseException
 */
class ParseExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testHasResponse()
    {
        $res = new Response(200);
        $e = new ParseException('foo', $res);
        $this->assertSame($res, $e->getResponse());
        $this->assertEquals('foo', $e->getMessage());
    }
}
