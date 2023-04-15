<?php
namespace Hikaeme\Monolog\Formatter;

use Monolog\Level;
use Monolog\LogRecord;
use PHPUnit\Framework\TestCase;

class LtsvFormatterTest extends TestCase
{
    public function testFormat()
    {
        $dateTime = new \DateTimeImmutable();
        $record = $this->getRecord(
            $dateTime,
            "t\ne\ts\rt\\",
            array("a:b\nc" => "d:e\rf"),
            array("g:h\ti" => "j:k\nl", "m:n\\o" => "p:q\\r")
        );

        $formatter = new LtsvFormatter('Y-m-d');
        $formatted = $formatter->format($record);
        $expected = join("\t", array(
                'time:' . $dateTime->format('Y-m-d'),
                'level:WARNING',
                'message:t\ne\ts\rt\\',
                'abc:d:e\rf',
                'ghi:j:k\nl',
                'mn\\o:p:q\\r',
            )) . PHP_EOL;
        $this->assertSame($expected, $formatted);
    }

    public function testFormatWithDuplicatedLabel()
    {
        $dateTime = new \DateTimeImmutable();
        $record = $this->getRecord(
            $dateTime,
            "test",
            array('k1' => 'v1', 'message' => 'message'),
            array('k1' => 'v2')
        );

        $formatter = new LtsvFormatter('Y-m-d');
        $formatted = $formatter->format($record);
        $expected = join("\t", array(
                'time:' . $dateTime->format('Y-m-d'),
                'level:WARNING',
                'message:test',
                'k1:v1',
                'message:message',
                'k1:v2',
            )) . PHP_EOL;
        $this->assertSame($expected, $formatted);
    }

    public function testFormatWithSettings()
    {
        $dateTime = new \DateTimeImmutable();
        $record = $this->getRecord(
            $dateTime,
            "test\ntest",
            array('k1' => 'v1'),
            array('k2' => 'v2')
        );

        $formatter = new LtsvFormatter(
            'H:i:s Y-m-d',
            array('datetime' => 'date', 'message' => "mess\nage"),
            false,
            false,
            array(),
            array()
        );
        $formatted = $formatter->format($record);
        $expected = join("\t", array(
                'date:' . $dateTime->format('H:i:s Y-m-d'),
                "mess\nage:test\ntest",
            )) . PHP_EOL;
        $this->assertSame($expected, $formatted);
    }

    public function testFormatContextContainingObjects()
    {
        $dateTime = new \DateTimeImmutable();
        $record = $this->getRecord(
            $dateTime,
            "test",
            array(
                'null' => null,
                'bool' => true,
                'array' => array(1, 2, 3),
            )
        );

        $formatter = new LtsvFormatter('Y-m-d');
        $formatted = $formatter->format($record);
        $expected = join("\t", array(
                'time:' . $dateTime->format('Y-m-d'),
                'level:WARNING',
                'message:test',
                'null:NULL',
                'bool:true',
                'array:[1,2,3]',
            )) . PHP_EOL;
        $this->assertSame($expected, $formatted);
    }

    /**
     * @param \DateTimeImmutable $dateTime
     * @param string $message
     * @param array $context
     * @param array $extra
     * @return LogRecord Record
     */
    private function getRecord(\DateTimeImmutable $dateTime, $message = 'test', $context = array(), $extra = array())
    {
        return new LogRecord(
            $dateTime,
            'test',
            Level::Warning,
            $message,
            $context,
            $extra,
            null,
        );
    }
}
