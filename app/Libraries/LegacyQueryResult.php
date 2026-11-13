<?php

namespace App\Libraries;

use CodeIgniter\Database\ResultInterface;

final class LegacyQueryResult
{
    public function __construct(private readonly ResultInterface $result)
    {
    }

    /**
     * @return list<object>
     */
    public function result(): array
    {
        return $this->result->getResult();
    }

    public function row(): ?object
    {
        return $this->result->getRow();
    }
}
