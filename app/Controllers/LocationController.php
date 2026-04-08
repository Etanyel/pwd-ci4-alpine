<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BarangayModel;
use App\Models\CityModel;
use App\Models\ProvinceModel;
use App\Models\RegionModel;
use CodeIgniter\HTTP\ResponseInterface;

class LocationController extends BaseController
{
    public function fetchRegions()
    {
        $model = new RegionModel();
        return $this->response->setJSON([
            'regions' => $model->findAll()
        ]);
    }

    public function fetchProvinces($region_id)
    {
        $model = new ProvinceModel();
        return $this->response->setJSON([
            'provinces' => $model->where('region_code', $region_id)->findAll()
        ]);
    }

    public function fetchCities($province_id)
    {
        $model = new CityModel();
        return $this->response->setJSON([
            'cities' => $model->where('province_code', $province_id)->findAll()
        ]);
    }

    public function fetchBarangays($cities_id)
    {
        $model = new BarangayModel();
        return $this->response->setJSON([
            'barangays' => $model->where('city_code', $cities_id)->findAll()
        ]);
    }
}
