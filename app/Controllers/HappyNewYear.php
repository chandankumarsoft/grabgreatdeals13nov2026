<?php

namespace App\Controllers;

class HappyNewYear extends SeasonalController
{
    public function index(): string
    {
        return $this->renderSeasonalPage('happynewyear', 'front/happynewyear_page');
    }
}
