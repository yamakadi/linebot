<?php

namespace Yamakadi\LineBot\Messages\Outgoing\Templates;

use DateTimeImmutable;
use InvalidArgumentException;

class DateTimePickerAction extends TemplateAction
{
    const TYPE = 'datetimepicker';

    /** @var string */
    protected $data;

    /** @var string */
    protected $mode;

    /** @var \DateTimeImmutable */
    protected $initial;

    /** @var \DateTimeImmutable */
    protected $min;

    /** @var \DateTimeImmutable */
    protected $max;

    /**
     * Create a new DateTimePickerAction Instance
     *
     * @param string                  $label
     * @param string                  $data
     * @param string                  $mode
     * @param \DateTimeImmutable|null $initial
     */
    public function __construct(string $label, string $data, string $mode, ?DateTimeImmutable $initial = null)
    {
        $this->data = $data;
        $this->label = $label;
        $this->initial = $initial;

        $this->withMode($mode);
    }

    public function withInitial(DateTimeImmutable $initial): self
    {
        $this->initial = $initial;

        return $this;
    }

    public function withMin(DateTimeImmutable $min): self
    {
        $this->min = $min;

        return $this;
    }

    public function withMax(DateTimeImmutable $max): self
    {
        $this->max = $max;

        return $this;
    }

    public function withMode($mode): self
    {
        if (!in_array($mode, ['date', 'time', 'datetime'])) {
            throw new InvalidArgumentException('Mode can only be one of "date", "time", or "datetime"');
        }

        $this->mode = $mode;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'type' => self::TYPE,
            'label' => $this->label,
            'data' => $this->data,
            'mode' => $this->mode,
            'initial' => $this->formatDate($this->initial),
            'min' => $this->formatDate($this->min),
            'max' => $this->formatDate($this->max),
        ];
    }

    protected function formatDate(DateTimeImmutable $datetime): string
    {
        switch($this->mode) {
            case 'date':
                return $datetime->format('Y-m-d');
            case 'time':
                return $datetime->format('H:i');
            case 'datetime':
                return $datetime->format('Y-m-d\TH:i');
            default:
                throw new InvalidArgumentException('Mode can only be one of "date", "time", or "datetime"');
        }
    }
}