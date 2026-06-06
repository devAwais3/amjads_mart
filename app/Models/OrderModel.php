<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table      = 'orders';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'user_id','status','subtotal','delivery_fee','discount_amount','total',
        'payment_method','transaction_id','delivery_name','delivery_phone',
        'delivery_address','delivery_city','delivery_area','order_notes'
    ];

    protected $useTimestamps = true;

    public function getOrdersWithUser(int $limit = 20, int $offset = 0): array
    {
        $db = \Config\Database::connect();
        return $db->table('orders o')
            ->select('o.*, u.full_name, u.email')
            ->join('users u', 'u.id = o.user_id', 'left')
            ->orderBy('o.created_at', 'DESC')
            ->limit($limit, $offset)
            ->get()->getResultArray();
    }

    public function getOrderDetail(int $orderId): ?array
    {
        $db    = \Config\Database::connect();
        $order = $this->find($orderId);
        if (! $order) return null;

        $items = $db->table('order_items oi')
            ->select('oi.*, p.name as product_name, p.image_url')
            ->join('products p', 'p.id = oi.product_id')
            ->where('oi.order_id', $orderId)
            ->get()->getResultArray();

        $order['items'] = $items;
        return $order;
    }

    public function getUserOrders(int $userId): array
    {
        return $this->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    public function getTotalRevenue(): float
    {
        $db = \Config\Database::connect();
        $row = $db->table('orders')
            ->selectSum('total')
            ->where('status !=', 'cancelled')
            ->get()->getRowArray();
        return (float)($row['total'] ?? 0);
    }

    public function getLast7Days(): array
    {
        $db = \Config\Database::connect();
        return $db->table('orders')
            ->select('DATE(created_at) as date, COUNT(*) as count, SUM(total) as revenue')
            ->where('created_at >=', date('Y-m-d', strtotime('-6 days')))
            ->groupBy('DATE(created_at)')
            ->orderBy('date', 'ASC')
            ->get()->getResultArray();
    }
}