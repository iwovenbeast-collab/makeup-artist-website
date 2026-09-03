<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\PortfolioItemModel;

class PortfolioController extends BaseController
{
    protected $portfolioModel;

    public function __construct()
    {
        $this->portfolioModel = new PortfolioItemModel();
    }

    public function index()
    {
        $portfolio = $this->portfolioModel
            ->where('status', 'active')
            ->orderBy('sort_order', 'ASC')
            ->orderBy('id', 'DESC')
            ->findAll();

        return $this->response
            ->setStatusCode(200)
            ->setJSON([
                'status' => true,
                'data' => $portfolio,
            ]);
    }
}