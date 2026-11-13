<?php

namespace App\Controllers;

class Valentine extends SeasonalController
{
    public function index(): string
    {
        return $this->renderSeasonalPage('valentine', 'front/valentine/valentine_page');
    }
}
