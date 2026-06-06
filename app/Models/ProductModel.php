<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table      = 'products';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'name','slug','category_id','price','original_price',
        'stock','unit','image_url','description','rating',
        'review_count','is_featured','is_on_sale','discount_percent','is_active'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getFeatured(int $limit = 8): array
    {
        return $this->where('is_featured', 1)
                    ->where('is_active', 1)
                    ->where('stock >', 0)
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    public function getOnSale(int $limit = 8): array
    {
        return $this->where('is_on_sale', 1)
                    ->where('is_active', 1)
                    ->where('stock >', 0)
                    ->orderBy('discount_percent', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    public function getByCategory(int $categoryId, int $limit = 20, string $sort = 'default'): array
    {
        $builder = $this->where('category_id', $categoryId)
                        ->where('is_active', 1);

        switch ($sort) {
            case 'price_asc':  $builder->orderBy('price', 'ASC');  break;
            case 'price_desc': $builder->orderBy('price', 'DESC'); break;
            case 'rating':     $builder->orderBy('rating', 'DESC'); break;
            default:           $builder->orderBy('is_featured', 'DESC')->orderBy('id', 'ASC');
        }

        return $builder->limit($limit)->findAll();
    }

    public function findBySlug(string $slug): ?array
    {
        return $this->where('slug', $slug)->where('is_active', 1)->first();
    }

    public function getRelated(int $categoryId, int $excludeId, int $limit = 6): array
    {
        return $this->where('category_id', $categoryId)
                    ->where('id !=', $excludeId)
                    ->where('is_active', 1)
                    ->orderBy('rating', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    public function search(string $query, int $limit = 10): array
    {
        return $this->like('name', $query)
                    ->where('is_active', 1)
                    ->orderBy('rating', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    public function getLowStock(int $threshold = 10): array
    {
        return $this->where('stock <', $threshold)
                    ->where('is_active', 1)
                    ->orderBy('stock', 'ASC')
                    ->findAll();
    }

    public function generateSlug(string $name): string
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name), '-'));
        $original = $slug;
        $i = 1;
        while ($this->where('slug', $slug)->countAllResults() > 0) {
            $slug = $original . '-' . $i++;
        }
        return $slug;
    }
}