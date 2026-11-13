<?php

namespace App\Libraries;

use CodeIgniter\HTTP\IncomingRequest;

final class LegacyInputAdapter
{
    public function __construct(private readonly IncomingRequest $request)
    {
    }

    public function get(string $key): mixed
    {
        return $this->request->getGet($key);
    }
}
