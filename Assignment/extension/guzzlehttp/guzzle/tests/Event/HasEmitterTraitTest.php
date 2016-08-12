<?php

namespace app\extension\guzzlehttp\guzzle\src\Tests\Event;

use app\extension\guzzlehttp\guzzle\src\Event\HasEmitterInterface;
use app\extension\guzzlehttp\guzzle\src\Event\HasEmitterTrait;

class AbstractHasEmitter implements HasEmitterInterface
{
    use HasEmitterTrait;
}

/**
 * @covers app\extension\guzzlehttp\guzzle\src\Event\HasEmitterTrait
 */
class HasEmitterTraitTest extends \PHPUnit_Framework_TestCase
{
    public function testHelperAttachesSubscribers()
    {
        $mock = $this->getMockBuilder('app\extension\guzzlehttp\guzzle\src\Tests\Event\AbstractHasEmitter')
            ->getMockForAbstractClass();

        $result = $mock->getEmitter();
        $this->assertInstanceOf('app\extension\guzzlehttp\guzzle\src\Event\EmitterInterface', $result);
        $result2 = $mock->getEmitter();
        $this->assertSame($result, $result2);
    }
}
