<?php

namespace core\database;

use core\helpers\Str;
use core\main\APP;
use Exception;

class QueryBuilder
{
    protected string $table;
    protected array $attr = [];

    protected array $args = [];
    protected string $conditions = '1 = 1';
    protected string $orderBy = '';
    protected int $limit = -1;

    protected int $offset = -1;

    public function __construct(string $table)
    {
        $this->table = $table;
    }

    public function all(array $attr = []): static
    {
        $this->attr = array_merge($this->attr, $attr);

        return $this;
    }

    public function where(string $conditions, array $args = []): static
    {
        $this->args = array_merge($this->args, $args);

        $this->conditions .= ' AND ' . $conditions;

        return $this;
    }

    public function orderBy(string $column, bool $asc = true): static
    {
        if (isset($this->orderBy)) $this->orderBy .= ',';
        $this->orderBy .= $column . ($asc ? '' : 'DESC');

        return $this;
    }

    public function limit(int $limit): static
    {
        $this->limit = $limit;

        return $this;
    }

    public function offset(int $offset): static
    {
        $this->offset = $offset;

        return $this;
    }

    private function build(): string
    {
        $query = "SELECT "
            . (empty($this->attr) ? "*" : Str::concat($this->attr, ','))
            . " FROM $this->table"
            . " WHERE $this->conditions";

        if (!empty($this->orderBy)) $query .= " ORDER BY $this->orderBy";

        if ($this->limit !== -1) $query .= " LIMIT $this->limit";

        if ($this->offset !== -1) $query .= " OFFSET $this->offset";

        return $query . ";";
    }

    /**
     * @throws Exception
     */
    public function get(): array|int
    {
        return APP::resolver(Database::class)->query($this->build(), $this->args)->get();
    }

    /**
     * @throws Exception
     */
    public function findOrFail(): mixed
    {
        return APP::resolver(Database::class)->query($this->build(), $this->args)->findOrFail();
    }

    /**
     * @throws Exception
     */
    public function find(): mixed
    {
        return APP::resolver(Database::class)->query($this->build(), $this->args)->find();
    }
}