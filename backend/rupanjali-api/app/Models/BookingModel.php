<?php

namespace App\Models;

use CodeIgniter\Model;

class BookingModel extends Model
{
    protected $table = 'bookings';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'name',
        'phone',
        'email',
        'event_type',
        'event_date',
        'start_time',
        'end_time',
        'location',
        'message',
        'status',
        'source',
    ];

    protected $useTimestamps = false;

    protected $returnType = 'array';
}