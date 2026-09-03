<?php

namespace App\Models;

use CodeIgniter\Model;

class BlogModel extends Model
{
    protected $table = 'blogs';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'title',
        'slug',
        'category',
        'excerpt',
        'content',
        'featured_image',
        'video_type',
        'video_path',
        'video_url',
        'status',
        'published_at',
    ];

    protected $useTimestamps = false;

    protected $returnType = 'array';
}