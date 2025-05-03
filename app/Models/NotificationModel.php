<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $table = 'notifications';
    protected $primaryKey = 'id';
    protected $allowedFields = ['order_id', 'customer_id', 'message', 'is_read', 'created_at'];
    protected $useTimestamps = false;
}
