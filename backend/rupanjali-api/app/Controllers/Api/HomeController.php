<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\HomeContentModel;

class HomeController extends BaseController
{
    public function index()
    {
        $model = new HomeContentModel();

        $home = $model->first();

        if (!$home) {
            return $this->response->setJSON([
                'status' => true,
                'data'   => null,
            ]);
        }

        return $this->response->setJSON([
            'status' => true,
            'data'   => $home,
        ]);
    }
}
