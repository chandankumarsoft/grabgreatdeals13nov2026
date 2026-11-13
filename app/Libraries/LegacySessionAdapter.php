<?php

namespace App\Libraries;

use CodeIgniter\Session\Session;

final class LegacySessionAdapter
{
    public function __construct(private readonly Session $session)
    {
    }

    public function userdata(string $key): mixed
    {
        return $this->session->get($key);
    }

    public function flashdata(string $key): mixed
    {
        return $this->session->getFlashdata($key);
    }

    public function set_userdata(string|array $key, mixed $value = null): void
    {
        $this->session->set($key, $value);
    }

    public function unset_userdata(string $key): void
    {
        $this->session->remove($key);
    }

    public function __get(string $key): mixed
    {
        return $this->userdata($key);
    }
}
