<?php

namespace core\database\migration;

class Blueprint
{
    public $columns = [];
    public $forginId = [];

    public function id(string $column = 'id'): static
    {
        $this->columns[$column] = ['INT', 'PRIMARY KEY', 'AUTO_INCREMENT'];
        return $this;
    }

    public function string(string $column): static
    {
        $this->columns[$column] = ['VARCHAR(255)'];
        return $this;
    }

    public function timestamps(): static
    {
        $this->columns['created_at'] = ['DATETIME'];
        $this->columns['updated_at'] = ['DATETIME'];
        return $this;
    }

    public function unique(): static
    {
        $this->columns[array_key_last($this->columns)][] = 'UNIQUE';
        return $this;
    }

    public function forginId(string $column, string $refColumn, string $table): static
    {
        $this->columns[$column] = ['INT'];
        $this->forginId[$column] = [$table, $refColumn];
        return $this;
    }
}
