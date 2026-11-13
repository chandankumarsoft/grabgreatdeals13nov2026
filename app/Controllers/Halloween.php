<?php

namespace App\Controllers;

class Halloween extends SeasonalController
{
    public function index(): string
    {
        return $this->renderSeasonalPage('halloween', 'front/halloween_page');
    }
}
