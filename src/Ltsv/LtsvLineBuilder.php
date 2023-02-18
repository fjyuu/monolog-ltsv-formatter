<?php
declare(strict_types=1);

namespace Tyamahori\Monolog\Formatter\Ltsv;

/**
 * Build a line of LTSV which can contain duplicate labels.
 */
class LtsvLineBuilder
{
    /** @var array[] Association list. */
    private array $items = [];

    /**
     * @param array $labelReplacement
     * @param array $valueReplacement
     */
    public function __construct(
        private array $labelReplacement = [],
        private array $valueReplacement = []
    ) {
    }

    /**
     * @param string $label
     * @param string $value
     */
    public function addItem(string $label, string $value): void
    {
        $this->items[] = [$label, $value];
    }

    /**
     * @param array $record
     */
    public function addRecord(array $record): void
    {
        foreach ($record as $label => $value) {
            $this->addItem((string)$label, (string)$value);
        }
    }

    /**
     * @return string
     */
    public function build(): string
    {
        $itemStrings = [];
        foreach ($this->items as $item) {
            [$label, $value] = $item;
            $itemStrings[] = $this->replaceLabel($label) . ':' . $this->replaceValue($value);
        }

        return implode("\t", $itemStrings) . PHP_EOL;
    }

    /**
     * @param string $key
     * @return string
     */
    private function replaceLabel(string $key): string
    {
        return strtr($key, $this->labelReplacement);
    }

    /**
     * @param string $value
     * @return string
     */
    private function replaceValue(string $value): string
    {
        return strtr($value, $this->valueReplacement);
    }
}
