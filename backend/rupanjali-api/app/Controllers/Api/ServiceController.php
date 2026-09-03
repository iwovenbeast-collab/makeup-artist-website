<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\ServiceModel;

class ServiceController extends BaseController
{
    protected $serviceModel;

    public function __construct()
    {
        $this->serviceModel = new ServiceModel();
    }

    public function index()
    {
        $services = $this->serviceModel
            ->where('status', 'active')
            ->orderBy('sort_order', 'ASC')
            ->orderBy('id', 'ASC')
            ->findAll();

        foreach ($services as &$service) {
            if (is_string($service['includes'] ?? null)) {
                $decodedIncludes = json_decode($service['includes'], true);

                $service['includes'] = is_array($decodedIncludes)
                    ? $decodedIncludes
                    : [];
            } elseif (!is_array($service['includes'] ?? null)) {
                $service['includes'] = [];
            }
        }

        unset($service);

        return $this->response->setJSON([
            'status' => 200,
            'data'   => $services,
        ]);
    }
}
