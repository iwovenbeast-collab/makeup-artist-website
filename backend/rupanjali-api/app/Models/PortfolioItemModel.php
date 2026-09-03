<?php

namespace App\Models;

use CodeIgniter\Model;

class PortfolioItemModel extends Model
{
    protected $table = 'portfolio_items';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'title',
        'category',
        'image',
        'sort_order',
        'status',
    ];

    protected $useTimestamps = true;
}