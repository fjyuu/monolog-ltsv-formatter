<?php

declare(strict_types=1);

namespace Test\Ltsv;

use PHPUnit\Framework\TestCase;
use Tyamahori\Monolog\Formatter\Ltsv\LtsvLineBuilder;

class LtsvLineBuilderTest extends TestCase
{
    private LtsvLineBuilder $builder;

    public function setUp(): void
    {
        $this->builder = new LtsvLineBuilder(
            ["\r" => '', "\n" => '', "\t" => '', ':' => ''],
            ["\r" => '\r', "\n" => '\n', "\t" => '\t']
        );
    }

    public function testAddItem(): void
    {
        $this->builder->addItem('a', 'b');
        $this->builder->addItem('c', 'd');

        $expected = "a:b\tc:d" . PHP_EOL;
        $this->assertSame($expected, $this->builder->build());
    }

    public function testAddRecord(): void
    {
        $this->builder->addRecord([
            'a' => 'b',
            'c' => 'd',
        ]);
        $this->builder->addRecord([
            'e' => 'f',
        ]);

        $expected = "a:b\tc:d\te:f" . PHP_EOL;
        $this->assertSame($expected, $this->builder->build());
    }

    public function testBuildWithDuplicateLabels(): void
    {
        $this->builder->addItem('a', 'b');
        $this->builder->addItem('a', 'b');

        $expected = "a:b\ta:b" . PHP_EOL;
        $this->assertSame($expected, $this->builder->build());
    }

    public function testBuildWithReplacement(): void
    {
        $this->builder->addItem("a:\tb\r\nc", "d:\te\r\nf");

        $expected = 'abc:d:\te\r\nf' . PHP_EOL;
        $this->assertSame($expected, $this->builder->build());
    }
}
