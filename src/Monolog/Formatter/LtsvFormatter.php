<?php
namespace Hikaeme\Monolog\Formatter;

use Hikaeme\Monolog\Formatter\Ltsv\LtsvLineBuilder;
use Monolog\Formatter\NormalizerFormatter;

/**
 * Formats incoming records into a line of LTSV.
 */
class LtsvFormatter extends NormalizerFormatter
{
    /** @var array */
    protected $labeling;

    /** @var bool */
    protected $includeContext;

    /** @var bool */
    protected $includeExtra;

    /** @var array */
    protected $labelReplacement;

    /** @var array */
    protected $valueReplacement;

    /**
     * @param string $dateFormat The format of the timestamp: one supported by DateTime::format.
     * @param array $labeling Associative array of a Monolog record to a LTSV record mapping.
     * @param bool $includeContext Whether to include context fields in a LTSV record.
     * @param bool $includeExtra Whether to include extra fields in a LTSV record.
     * @param array $labelReplacement Rule of replacement for LTSV labels.
     * @param array $valueReplacement Rule of replacement for LTSV values.
     */
    public function __construct(
        $dateFormat = null,
        array $labeling = array('datetime' => 'time', 'level_name' => 'level', 'message' => 'message'),
        $includeContext = true,
        $includeExtra = true,
        array $labelReplacement = array("\r" => '', "\n" => '', "\t" => '', ':' => ''),
        array $valueReplacement = array("\r" => '\r', "\n" => '\n', "\t" => '\t')
    ) {
        parent::__construct($dateFormat);
        $this->labeling = $labeling;
        $this->includeContext = $includeContext;
        $this->includeExtra = $includeExtra;
        $this->labelReplacement = $labelReplacement;
        $this->valueReplacement = $valueReplacement;
    }

    /**
     * {@inheritdoc}
     */
    public function format(array $record)
    {
        $builder = new LtsvLineBuilder($this->labelReplacement, $this->valueReplacement);

        $ltsvRecord = array();
        foreach ($this->labeling as $monologKey => $ltsvLabel) {
            if (isset($record[$monologKey])) {
                $ltsvRecord[$ltsvLabel] = $record[$monologKey];
            }
        }
        $builder->addRecord($this->normalizeRecord($ltsvRecord));

        if ($this->includeContext && isset($record['context'])) {
            $builder->addRecord($this->normalizeRecord($record['context']));
        }

        if ($this->includeExtra && isset($record['extra'])) {
            $builder->addRecord($this->normalizeRecord($record['extra']));
        }

        return $builder->build();
    }

    /**
     * @param array $record
     * @return array
     */
    protected function normalizeRecord(array $record)
    {
        $normalized = $this->normalize($record);
        $converted = array();
        foreach ($normalized as $key => $value) {
            $converted[$key] = $this->convertToString($value);
        }
        return $converted;
    }

    /**
     * @param mixed $data
     * @return string
     */
    protected function convertToString($data)
    {
        if (null === $data || is_bool($data)) {
            return var_export($data, true);
        }

        if (is_scalar($data)) {
            return (string) $data;
        }

        return $this->toJson($data, true);
    }
}
