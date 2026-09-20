<?php

namespace App\Models;

use CodeIgniter\Model;

class HomeContentModel extends Model
{
    protected $table            = 'home_content';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'hero_image',
        'bridal_image',
        'engagement_image',
        'party_image',
    ];

    protected $useTimestamps = true;

    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
