<?php
declare(strict_types=1);

namespace Tyamahori\Monolog\Formatter;

use Monolog\LogRecord;
use Tyamahori\Monolog\Formatter\Ltsv\LtsvLineBuilder;
use Monolog\Formatter\NormalizerFormatter;

/**
 * Formats incoming records into a line of LTSV.
 */
class LtsvFormatter extends NormalizerFormatter
{
    protected array $labeling;

    protected bool $includeContext;

    protected bool $includeExtra;

    protected array $labelReplacement;

    protected array $valueReplacement;

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
        array $labeling = ['datetime' => 'time', 'level_name' => 'level', 'message' => 'message'],
        bool $includeContext = true,
        bool $includeExtra = true,
        array $labelReplacement = ["\r" => '', "\n" => '', "\t" => '', ':' => ''],
        array $valueReplacement = ["\r" => '\r', "\n" => '\n', "\t" => '\t']
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
    public function format(LogRecord $record)
    {
        $builder = new LtsvLineBuilder(
            $this->labelReplacement,
            $this->valueReplacement
        );

        $ltsvRecord = [];
        $arrayRecords = $record->toArray();

        foreach ($this->labeling as $monologKey => $ltsvLabel) {
            if (isset($record[$monologKey])) {
                $ltsvRecord[$ltsvLabel] = $arrayRecords[$monologKey];
            }
        }
        $builder->addRecord($this->normalizeArray($ltsvRecord));

        if ($this->includeContext && isset($record['context'])) {
            /** @var array $context */
            $context = $record['context'];
            $builder->addRecord($this->normalizeArray($context));
        }

        if ($this->includeExtra && isset($record['extra'])) {
            /** @var array $extra */
            $extra = $record['extra'];
            $builder->addRecord($this->normalizeArray($extra));
        }

        return $builder->build();
    }

    private function normalizeArray(array $record): array
    {
        $normalized = $this->normalize($record);
        $converted = [];
        foreach ($normalized as $key => $value) {
            $converted[$key] = $this->convertToString($value);
        }
        return $converted;
    }

    /**
     * @param mixed $data
     * @return string
     */
    private function convertToString(mixed $data): string
    {
        if ($data === null || is_bool($data)) {
            return var_export($data, true);
        }

        if (is_scalar($data)) {
            return (string) $data;
        }

        return $this->toJson($data, true);
    }
}
