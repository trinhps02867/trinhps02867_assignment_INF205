<?php
namespace app\extension\guzzlehttp\guzzle\src\Tests\Stream;

use app\extension\app\extension\guzzlehttp\guzzle\src\streams\src\InflateStream;
use app\extension\app\extension\guzzlehttp\guzzle\src\streams\src\Stream;

class InflateStreamtest extends \PHPUnit_Framework_TestCase
{
    public function testInflatesStreams()
    {
        $content = gzencode('test');
        $a = Stream::factory($content);
        $b = new InflateStream($a);
        $this->assertEquals('test', (string) $b);
    }
}
