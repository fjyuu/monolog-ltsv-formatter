<?php
namespace Hikaeme\Monolog\Formatter\Ltsv;

class LtsvLineBuilderTest extends \PHPUnit_Framework_TestCase
{
    /** @var LtsvLineBuilder */
    private $builder;

    public function setUp()
    {
        $this->builder = new LtsvLineBuilder(
            array("\r" => '', "\n" => '', "\t" => '', ':' => ''),
            array("\r" => '\r', "\n" => '\n', "\t" => '\t')
        );
    }

    public function testAddItem()
    {
        $this->builder->addItem('a', 'b');
        $this->builder->addItem('c', 'd');

        $expected = "a:b\tc:d" . PHP_EOL;
        $this->assertSame($expected, $this->builder->build());
    }

    public function testAddRecord()
    {
        $this->builder->addRecord(array(
            'a' => 'b',
            'c' => 'd',
        ));
        $this->builder->addRecord(array(
            'e' => 'f',
        ));

        $expected = "a:b\tc:d\te:f" . PHP_EOL;
        $this->assertSame($expected, $this->builder->build());
    }

    public function testBuildWithDuplicateLabels()
    {
        $this->builder->addItem('a', 'b');
        $this->builder->addItem('a', 'b');

        $expected = "a:b\ta:b" . PHP_EOL;
        $this->assertSame($expected, $this->builder->build());
    }

    public function testBuildWithReplacement()
    {
        $this->builder->addItem("a:\tb\r\nc", "d:\te\r\nf");

        $expected = 'abc:d:\te\r\nf' . PHP_EOL;
        $this->assertSame($expected, $this->builder->build());
    }
}
