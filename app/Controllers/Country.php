<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;

class Country extends BaseController
{
    public function countries(): ResponseInterface
    {
        return $this->response->setJSON(
            db_connect()->table('country')->get()->getResult(),
        );
    }

    public function states(): ResponseInterface
    {
        $countryId = $this->request->getPost('country_id');
        $states = db_connect()->table('region')
            ->where('country_id', $countryId)
            ->get()
            ->getResult();
        $options = "<option value=''>-- state --</option>";

        foreach ($states as $state) {
            $options .= "<option value='" . esc($state->id) . "'>" . esc($state->region) . '</option>';
        }

        return $this->response->setBody($options);
    }

    public function cities(): ResponseInterface
    {
        $stateId = $this->request->getPost('state_id');
        $cities = db_connect()->table('city')
            ->where('region_id', $stateId)
            ->get()
            ->getResult();
        $options = "<option value=''>-- city --</option>";

        foreach ($cities as $city) {
            $options .= "<option value='" . esc($city->id) . "'>" . esc($city->city) . '</option>';
        }

        return $this->response->setBody($options);
    }
}
