<?php
namespace app\extension\guzzlehttp\guzzle\src\Tests\Stream;

use app\extension\app\extension\guzzlehttp\guzzle\src\streams\src\Stream;
use app\extension\app\extension\guzzlehttp\guzzle\src\streams\src\NoSeekStream;

/**
 * @covers app\extension\app\extension\guzzlehttp\guzzle\src\streams\src\NoSeekStream
 * @covers app\extension\app\extension\guzzlehttp\guzzle\src\streams\src\StreamDecoratorTrait
 */
class NoSeekStreamTest extends \PHPUnit_Framework_TestCase
{
    public function testCannotSeek()
    {
        $s = $this->getMockBuilder('app\extension\app\extension\guzzlehttp\guzzle\src\streams\src\StreamInterface')
            ->setMethods(['isSeekable', 'seek'])
            ->getMockForAbstractClass();
        $s->expects($this->never())->method('seek');
        $s->expects($this->never())->method('isSeekable');
        $wrapped = new NoSeekStream($s);
        $this->assertFalse($wrapped->isSeekable());
        $this->assertFalse($wrapped->seek(2));
    }

    public function testHandlesClose()
    {
        $s = Stream::factory('foo');
        $wrapped = new NoSeekStream($s);
        $wrapped->close();
        $this->assertFalse($wrapped->write('foo'));
    }
}
