<?php

namespace app\extension\guzzlehttp\guzzle\src\Tests\Event;

class AbstractEventTest extends \PHPUnit_Framework_TestCase
{
    public function testStopsPropagation()
    {
        $e = $this->getMockBuilder('app\extension\guzzlehttp\guzzle\src\Event\AbstractEvent')
            ->getMockForAbstractClass();
        $this->assertFalse($e->isPropagationStopped());
        $e->stopPropagation();
        $this->assertTrue($e->isPropagationStopped());
    }
}
