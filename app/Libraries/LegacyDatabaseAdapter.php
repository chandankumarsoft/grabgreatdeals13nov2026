<?php

namespace App\Libraries;

use CodeIgniter\Database\ConnectionInterface;
use InvalidArgumentException;
use LogicException;

final class LegacyDatabaseAdapter
{
    private $builder;

    private ?string $selectedFields = null;

    private array $orders = [];

    private array $conditions = [];

    public function __construct(private readonly ConnectionInterface $database)
    {
    }

    public function select(string $fields): self
    {
        $this->selectedFields = $fields;

        if ($this->builder !== null) {
            $this->builder->select($fields);
        }

        return $this;
    }

    public function from(string $table): self
    {
        $table = trim($table);
        if (preg_match('/\A[a-zA-Z0-9_]+(?:\s+[a-zA-Z0-9_]+)?\z/', $table) !== 1) {
            throw new InvalidArgumentException('Invalid legacy table name.');
        }

        $this->builder = $this->database->table($table);

        if ($this->selectedFields !== null) {
            $this->builder->select($this->selectedFields);
        }

        foreach ($this->orders as [$field, $direction]) {
            $this->applyOrder($field, $direction);
        }

        foreach ($this->conditions as [$field, $value]) {
            $this->builder->where($field, $value);
        }

        return $this;
    }

    public function join(string $table, string $condition, string $type = ''): self
    {
        $this->requireBuilder();
        $this->builder->join($table, $condition, $type);

        return $this;
    }

    public function where(string|array $field, mixed $value = null): self
    {
        if ($this->builder === null) {
            $this->conditions[] = [$field, $value];
        } else {
            $this->builder->where($field, $value);
        }

        return $this;
    }

    /**
     * @param list<mixed> $values
     */
    public function where_in(string $field, array $values): self
    {
        $this->requireBuilder();
        $this->builder->whereIn($field, $values);

        return $this;
    }

    public function order_by(string $field, string $direction = ''): self
    {
        if ($this->builder === null) {
            $this->orders[] = [$field, $direction];
        } else {
            $this->applyOrder($field, $direction);
        }

        return $this;
    }

    public function get(?string $table = null): LegacyQueryResult
    {
        if ($table !== null) {
            $this->from($table);
        }

        $this->requireBuilder();
        $result = $this->builder->get();
        $this->reset();

        return new LegacyQueryResult($result);
    }

    public function count_all_results(?string $table = null): int
    {
        if ($table !== null) {
            $this->from($table);
        }

        $this->requireBuilder();
        $count = $this->builder->countAllResults();
        $this->reset();

        return $count;
    }

    private function applyOrder(string $field, string $direction): void
    {
        if (strtoupper($direction) === 'RANDOM') {
            $this->builder->orderBy('RAND()', '', false);

            return;
        }

        $this->builder->orderBy($field, $direction);
    }

    private function requireBuilder(): void
    {
        if ($this->builder === null) {
            throw new LogicException('A table must be selected before querying.');
        }
    }

    private function reset(): void
    {
        $this->builder       = null;
        $this->selectedFields = null;
        $this->orders        = [];
        $this->conditions    = [];
    }
}
