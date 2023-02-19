<?php

declare(strict_types=1);

namespace Test;

use DateTimeImmutable;
use Monolog\Level;
use Monolog\LogRecord;
use PHPUnit\Framework\TestCase;
use Tyamahori\Monolog\Formatter\LtsvFormatter;

class LtsvFormatterTest extends TestCase
{
    public function testFormat(): void
    {
        $dateTime = new DateTimeImmutable();
        $record = $this->getRecord(
            $dateTime,
            "t\ne\ts\rt\\",
            ["a:b\nc" => "d:e\rf"],
            ["g:h\ti" => "j:k\nl", 'm:n\\o' => 'p:q\\r']
        );

        $formatter = new LtsvFormatter('Y-m-d');
        $formatted = $formatter->format($record);
        $expected = implode("\t", [
            'time:' . $dateTime->format('Y-m-d'),
            'level:WARNING',
            'message:t\ne\ts\rt\\',
            'abc:d:e\rf',
            'ghi:j:k\nl',
            'mn\\o:p:q\\r',
        ]) . PHP_EOL;
        static::assertSame($expected, $formatted);
    }

    public function testFormatWithDuplicatedLabel(): void
    {
        $dateTime = new DateTimeImmutable;
        $record = $this->getRecord(
            $dateTime,
            'test',
            ['k1' => 'v1', 'message' => 'message'],
            ['k1' => 'v2']
        );

        $formatter = new LtsvFormatter('Y-m-d');
        $formatted = $formatter->format($record);
        $expected = implode("\t", [
            'time:' . $dateTime->format('Y-m-d'),
            'level:WARNING',
            'message:test',
            'k1:v1',
            'message:message',
            'k1:v2',
        ]) . PHP_EOL;
        static::assertSame($expected, $formatted);
    }

    public function testFormatWithSettings(): void
    {
        $dateTime = new DateTimeImmutable;
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
            'date:' . $dateTime->format('H:i:s Y-m-d'),
            "mess\nage:test\ntest",
        ]) . PHP_EOL;
        static::assertSame($expected, $formatted);
    }

    public function testFormatContextContainingObjects(): void
    {
        $dateTime = new DateTimeImmutable;
        $record = $this->getRecord(
            $dateTime,
            'test',
            [
                'null' => null,
                'bool' => true,
                'array' => [1, 2, 3],
            ]
        );

        $formatter = new LtsvFormatter('Y-m-d');
        $formatted = $formatter->format($record);
        $expected = implode("\t", [
            'time:' . $dateTime->format('Y-m-d'),
            'level:WARNING',
            'message:test',
            'null:NULL',
            'bool:true',
            'array:[1,2,3]',
        ]) . PHP_EOL;
        static::assertSame($expected, $formatted);
    }

    /**
     * @param DateTimeImmutable $dateTime
     * @param string $message
     * @param array $context
     * @param array $extra
     * @return LogRecord Record
     */
    private function getRecord(
        DateTimeImmutable $dateTime,
        string $message = 'test',
        array $context = [],
        array $extra = []
    ): LogRecord {
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
