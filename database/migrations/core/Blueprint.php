<?php

namespace database\core;

class Blueprint
{
    public function id(): static
    {
        return $this;
    }

    public function string(string $column): static
    {
        return $this;
    }

    public function timestamps(): static
    {
        return $this;
    }

    public function unique(): static
    {
        return $this;
    }

    public function forginId(string $column): static
    {
        return $this;
    }

    public function references(string $refColumn): static
    {
        return $this;
    }

    public function on(string $table): static
    {
        return $this;
    }
}
