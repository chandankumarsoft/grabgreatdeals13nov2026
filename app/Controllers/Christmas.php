<?php

namespace App\Controllers;

class Christmas extends SeasonalController
{
    public function index(): string
    {
        return $this->renderSeasonalPage('christmas', 'front/christmas_page');
    }
}
