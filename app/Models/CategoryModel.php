<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table      = 'categories';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'name','slug','icon','image_url','product_count','display_order','is_active'
    ];

    public function getActive(): array
    {
        return $this->where('is_active', 1)
                    ->orderBy('display_order', 'ASC')
                    ->findAll();
    }

    public function findBySlug(string $slug): ?array
    {
        return $this->where('slug', $slug)->where('is_active', 1)->first();
    }

    public function updateProductCount(int $categoryId): void
    {
        $db    = \Config\Database::connect();
        $count = $db->table('products')
                    ->where('category_id', $categoryId)
                    ->where('is_active', 1)
                    ->countAllResults();
        $this->update($categoryId, ['product_count' => $count]);
    }
}