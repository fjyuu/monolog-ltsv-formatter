<?php

namespace Hikaeme\Monolog\Formatter;

use Monolog\Logger;

class LtsvFormatterTest extends \PHPUnit_Framework_TestCase
{
    public function testFormat()
    {
        $dateTime = new \DateTime();
        $record = $this->getRecord(
            $dateTime,
            "t\ne\ts\rt\\",
            ["a:b\nc" => "d:e\rf"],
            ["g:h\ti" => "j:k\nl", 'm:n\\o' => 'p:q\\r']
        );

        $formatter = new LtsvFormatter('Y-m-d');
        $formatted = $formatter->format($record);
        $expected = implode("\t", [
                'time:'.$dateTime->format('Y-m-d'),
                'level:WARNING',
                'message:t\ne\ts\rt\\',
                'abc:d:e\rf',
                'ghi:j:k\nl',
                'mn\\o:p:q\\r',
            ]).PHP_EOL;
        $this->assertSame($expected, $formatted);
    }

    public function testFormatWithDuplicatedLabel()
    {
        $dateTime = new \DateTime();
        $record = $this->getRecord(
            $dateTime,
            'test',
            ['k1' => 'v1', 'message' => 'message'],
            ['k1' => 'v2']
        );

        $formatter = new LtsvFormatter('Y-m-d');
        $formatted = $formatter->format($record);
        $expected = implode("\t", [
                'time:'.$dateTime->format('Y-m-d'),
                'level:WARNING',
                'message:test',
                'k1:v1',
                'message:message',
                'k1:v2',
            ]).PHP_EOL;
        $this->assertSame($expected, $formatted);
    }

    public function testFormatWithSettings()
    {
        $dateTime = new \DateTime();
        $record = $this->getRecord(
            $dateTime,
            "test\ntest",
            ['k1' => 'v1'],
            ['k2' => 'v2']
        );

        $formatter = new LtsvFormatter(
            'H:i:s Y-m-d',
            ['datetime' => 'date', 'message' => "mess\nage"],
            false,
            false,
            [],
            []
        );
        $formatted = $formatter->format($record);
        $expected = implode("\t", [
                'date:'.$dateTime->format('H:i:s Y-m-d'),
                "mess\nage:test\ntest",
            ]).PHP_EOL;
        $this->assertSame($expected, $formatted);
    }

    public function testFormatContextContainingObjects()
    {
        $dateTime = new \DateTime();
        $record = $this->getRecord(
            $dateTime,
            'test',
            [
                'null'  => null,
                'bool'  => true,
                'array' => [1, 2, 3],
            ]
        );

        $formatter = new LtsvFormatter('Y-m-d');
        $formatted = $formatter->format($record);
        $expected = implode("\t", [
                'time:'.$dateTime->format('Y-m-d'),
                'level:WARNING',
                'message:test',
                'null:NULL',
                'bool:true',
                'array:[1,2,3]',
            ]).PHP_EOL;
        $this->assertSame($expected, $formatted);
    }

    /**
     * @param \DateTime $dateTime
     * @param string    $message
     * @param array     $context
     * @param array     $extra
     *
     * @return array Record
     */
    private function getRecord(\DateTime $dateTime, $message = 'test', $context = [], $extra = [])
    {
        return [
            'message'    => $message,
            'context'    => $context,
            'level'      => Logger::WARNING,
            'level_name' => Logger::getLevelName(Logger::WARNING),
            'channel'    => 'test',
            'datetime'   => $dateTime,
            'extra'      => $extra,
        ];
    }
}
