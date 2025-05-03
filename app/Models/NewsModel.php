<?php

namespace App\Models;
use CodeIgniter\Model;

class NewsModel extends Model
{
    protected $table = 'news';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'slug', 'body'];

    public function getNews($slug = false)
    {
        $builder = $this->builder();
        if ($slug === false) {
            return $builder->get()->getResultArray(); // Get all records
        }

        return $builder->where('slug', $slug)->get()->getRowArray(); // Get a single record by slug
    }
}
