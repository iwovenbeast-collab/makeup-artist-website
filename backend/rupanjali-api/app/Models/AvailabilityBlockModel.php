<?php

namespace App\Models;

use CodeIgniter\Model;

class AvailabilityBlockModel extends Model
{
    protected $table = 'availability_blocks';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'block_date',
        'start_time',
        'end_time',
        'all_day',
        'reason',
        'created_at',
    ];

    protected $useTimestamps = false;

    protected $returnType = 'array';
}