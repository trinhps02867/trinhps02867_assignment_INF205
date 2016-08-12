<?php
namespace app\extension\guzzlehttp\guzzle\src\Tests\Stream\Exception;

use app\extension\app\extension\guzzlehttp\guzzle\src\streams\src\Exception\SeekException;
use app\extension\app\extension\guzzlehttp\guzzle\src\streams\src\Stream;

class SeekExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testHasStream()
    {
        $s = Stream::factory('foo');
        $e = new SeekException($s, 10);
        $this->assertSame($s, $e->getStream());
        $this->assertContains('10', $e->getMessage());
    }
}
