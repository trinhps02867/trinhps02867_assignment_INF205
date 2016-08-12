<?php

namespace app\extension\guzzlehttp\guzzle\src\tests\Exception;

use app\extension\guzzlehttp\guzzle\src\Exception\XmlParseException;

/**
 * @covers app\extension\guzzlehttp\guzzle\src\Exception\XmlParseException
 */
class XmlParseExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testHasError()
    {
        $error = new \LibXMLError();
        $e = new XmlParseException('foo', null, null, $error);
        $this->assertSame($error, $e->getError());
        $this->assertEquals('foo', $e->getMessage());
    }
}
