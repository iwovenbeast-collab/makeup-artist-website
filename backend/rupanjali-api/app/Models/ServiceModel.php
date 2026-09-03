<?php

namespace App\Models;

use CodeIgniter\Model;

class ServiceModel extends Model
{
    protected $table = 'services';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'title',
        'subtitle',
        'description',
        'includes',
        'duration',
        'price',
        'icon',
        'sort_order',
        'status',
    ];

    protected $useTimestamps = true;
}