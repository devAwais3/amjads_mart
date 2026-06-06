<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;

class OrdersController extends BaseController
{
    public function index()
    {
        $orderModel = new OrderModel();
        $status = $this->request->getGet('status') ?? '';
        $search = $this->request->getGet('search') ?? '';

        $db = \Config\Database::connect();
        $builder = $db->table('orders o')
            ->select('o.*, u.full_name, u.email')
            ->join('users u', 'u.id = o.user_id', 'left')
            ->orderBy('o.created_at', 'DESC');

        if ($status)
            $builder->where('o.status', $status);
        if ($search)
            $builder->like('o.id', $search);

        $orders = $builder->get()->getResultArray();

        $data = [
            'title' => 'Orders — Admin',
            'orders' => $orders,
            'status' => $status,
            'search' => $search,
        ];

        return view('admin/partials/admin_header', ['title' => 'Orders — Admin'])
            . view('admin/orders', [
                'title' => 'Orders — Admin',
                'orders' => $orders,
                'status' => $status,
                'search' => $search,
            ])
            . view('admin/partials/admin_footer');
    }

    public function get(int $id)
    {
        $orderModel = new OrderModel();
        $order = $orderModel->getOrderDetail($id);
        return $this->response->setJSON($order ?: ['error' => 'Not found']);
    }

    public function updateStatus()
    {
        $id = (int) $this->request->getPost('order_id');
        $status = $this->request->getPost('status');

        $allowed = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        if (!in_array($status, $allowed)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid status.']);
        }

        $orderModel = new OrderModel();
        $orderModel->update($id, ['status' => $status]);
        return $this->response->setJSON(['success' => true, 'message' => 'Status updated!']);
    }

    public function exportCsv()
    {
        $db = \Config\Database::connect();
        $orders = $db->table('orders o')
            ->select('o.id, o.created_at, u.full_name, u.email, o.total, o.status, o.payment_method, o.delivery_city')
            ->join('users u', 'u.id = o.user_id', 'left')
            ->orderBy('o.created_at', 'DESC')
            ->get()->getResultArray();

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="orders_' . date('Y-m-d') . '.csv"');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['Order ID', 'Date', 'Customer', 'Email', 'Total (Rs.)', 'Status', 'Payment', 'City']);

        foreach ($orders as $order) {
            fputcsv($output, [
                '#' . str_pad($order['id'], 5, '0', STR_PAD_LEFT),
                $order['created_at'],
                $order['full_name'],
                $order['email'],
                $order['total'],
                $order['status'],
                $order['payment_method'],
                $order['delivery_city'],
            ]);
        }

        fclose($output);
        exit;
    }
}