<?php

namespace Yamakadi\LineBot\Messages\Outgoing\Values;

class Position
{
    /** @var int */
    private $x;

    /** @var int */
    private $y;

    /**
     * Create a new Placement Instance
     *
     * @param int $x
     * @param int $y
     */
    public function __construct(int $x, int $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    public static function leftMost(): self
    {
        return new static(0,0);
    }

    public function coordinates(): array
    {
        return [
            'x' => $this->x,
            'y' => $this->y
        ];
    }

    public function x(): int
    {
        return $this->x;
    }

    public function y(): int
    {
        return $this->y;
    }

}