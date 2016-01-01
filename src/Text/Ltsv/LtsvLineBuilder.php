<?php
namespace Hikaeme\Text\Ltsv;

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
    private $items = array();

    /**
     * @param array $labelReplacement
     * @param array $valueReplacement
     */
    public function __construct(array $labelReplacement = array(), array $valueReplacement = array())
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
        $this->items[] = array($label, $value);
    }

    /**
     * @param array $record
     */
    public function addRecord(array $record)
    {
        foreach ($record as $label => $value)
        {
            $this->addItem((string) $label, (string) $value);
        }
    }

    /**
     * @param bool $appendLineFeed
     * @return string
     */
    public function build($appendLineFeed = false)
    {
        $itemStrings = [];
        foreach ($this->items as $item) {
            list($label, $value) = $item;
            $itemStrings[] = $this->replaceLabel($label) . ':' . $this->replaceValue($value);
        }

        $line = join("\t", $itemStrings);
        if ($appendLineFeed) {
            $line .= PHP_EOL;
        }
        return $line;
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
