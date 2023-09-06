<?php

namespace core\routes;

class Closure
{
    private int $index;
    private array $fn;

    public function __construct(array $fn)
    {
        $this->index = 0;
        $this->fn = $fn;
        $this();
    }

    public function __invoke(): void
    {
        if ($this->index < count($this->fn))
            $this->fn[$this->index++]($this);
    }
}