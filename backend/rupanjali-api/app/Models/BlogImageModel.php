<?php

namespace App\Models;

use CodeIgniter\Model;

class BlogImageModel extends Model
{
    protected $table = 'blog_images';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'blog_id',
        'image_path',
        'sort_order',
        'created_at',
    ];

    protected $useTimestamps = false;

    protected $returnType = 'array';
}
