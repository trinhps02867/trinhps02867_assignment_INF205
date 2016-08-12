<?php

namespace app\extension\guzzlehttp\guzzle\src\Tests\Event;

use app\extension\guzzlehttp\guzzle\src\Adapter\Transaction;
use app\extension\guzzlehttp\guzzle\src\Client;
use app\extension\guzzlehttp\guzzle\src\Message\Request;

/**
 * @covers app\extension\guzzlehttp\guzzle\src\Event\AbstractTransferEvent
 */
class AbstractTransferEventTest extends \PHPUnit_Framework_TestCase
{
    public function testHasStats()
    {
        $s = ['foo' => 'bar'];
        $t = new Transaction(new Client(), new Request('GET', '/'));
        $e = $this->getMockBuilder('app\extension\guzzlehttp\guzzle\src\Event\AbstractTransferEvent')
            ->setConstructorArgs([$t, $s])
            ->getMockForAbstractClass();
        $this->assertNull($e->getTransferInfo('baz'));
        $this->assertEquals('bar', $e->getTransferInfo('foo'));
        $this->assertEquals($s, $e->getTransferInfo());
    }
}
