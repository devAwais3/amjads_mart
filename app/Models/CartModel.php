<?php

namespace App\Models;

use CodeIgniter\Model;

class CartModel extends Model
{
    protected $table = 'cart';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = ['user_id', 'product_id', 'quantity'];
    protected $useTimestamps = true;

    public function getCartWithProducts(int $userId): array
    {
        $db = \Config\Database::connect();

        return $db->table('cart')
            ->select('cart.id, cart.quantity, p.id as product_id, p.name, p.slug, p.price,
                  p.original_price, p.image_url, p.unit, p.stock, p.discount_percent')
            ->join('products p', 'p.id = cart.product_id')
            ->where('cart.user_id', $userId)
            ->where('p.is_active', 1)
            ->get()
            ->getResultArray();
    }

    public function addOrUpdate(int $userId, int $productId, int $qty = 1): void
    {
        $existing = $this->where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();
        if ($existing) {
            $this->update($existing['id'], ['quantity' => $existing['quantity'] + $qty]);
        } else {
            $this->insert(['user_id' => $userId, 'product_id' => $productId, 'quantity' => $qty]);
        }
    }

    public function updateQty(int $userId, int $productId, int $qty): void
    {
        $this->where('user_id', $userId)
            ->where('product_id', $productId)
            ->set(['quantity' => $qty])
            ->update();
    }

    public function removeItem(int $userId, int $productId): void
    {
        $this->where('user_id', $userId)->where('product_id', $productId)->delete();
    }

    public function clearCart(int $userId): void
    {
        $this->where('user_id', $userId)->delete();
    }

    public function getCount(int $userId): int
    {
        return $this->where('user_id', $userId)->countAllResults();
    }
}