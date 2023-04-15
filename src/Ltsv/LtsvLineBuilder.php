<?php

namespace Hikaeme\Monolog\Formatter\Ltsv;

/**
 * Build a line of LTSV which can contain duplicate labels.
 */
class LtsvLineBuilder
{
    /** @var array */
    private $labelReplacement;

    /** @var array */
    private $valueReplacement;

    /** @var array[] Association list. */
    private $items = [];

    /**
     * @param array $labelReplacement
     * @param array $valueReplacement
     */
    public function __construct(array $labelReplacement = [], array $valueReplacement = [])
    {
        $this->labelReplacement = $labelReplacement;
        $this->valueReplacement = $valueReplacement;
    }

    /**
     * @param string $label
     * @param string $value
     */
    public function addItem($label, $value)
    {
        $this->items[] = [$label, $value];
    }

    /**
     * @param array $record
     */
    public function addRecord(array $record)
    {
        foreach ($record as $label => $value) {
            $this->addItem((string) $label, (string) $value);
        }
    }

    /**
     * @return string
     */
    public function build()
    {
        $itemStrings = [];
        foreach ($this->items as $item) {
            [$label, $value] = $item;
            $itemStrings[] = $this->replaceLabel($label) . ':' . $this->replaceValue($value);
        }

        return join("\t", $itemStrings) . PHP_EOL;
    }

    /**
     * @param string $key
     * @return string
     */
    private function replaceLabel($key)
    {
        return strtr($key, $this->labelReplacement);
    }

    /**
     * @param string $value
     * @return string
     */
    private function replaceValue($value)
    {
        return strtr($value, $this->valueReplacement);
    }
}
