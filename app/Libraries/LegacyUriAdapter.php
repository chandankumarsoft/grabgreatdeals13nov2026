<?php

namespace App\Libraries;

use CodeIgniter\HTTP\URI;

final class LegacyUriAdapter
{
    public function __construct(private readonly URI $uri)
    {
    }

    public function segment(int $number): ?string
    {
        return $this->uri->getSegment($number);
    }
}
