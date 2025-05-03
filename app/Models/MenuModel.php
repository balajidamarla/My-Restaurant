<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table = 'menu_items';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'description', 'price', 'image'];
    // public function filterMenuItems($searchTerm)
    // {
    //     return $this->like('name', $searchTerm)->findAll();
    
    // }
}
