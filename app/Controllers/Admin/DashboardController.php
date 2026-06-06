<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\ProductModel;
use App\Models\UserModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $orderModel = new OrderModel();
        $productModel = new ProductModel();
        $userModel = new UserModel();
        $db = \Config\Database::connect();

        $data = [
            'title' => 'Admin Dashboard — Amjad\'s Mart',
            'totalOrders' => $orderModel->countAll(),
            'totalRevenue' => $orderModel->getTotalRevenue(),
            'totalProducts' => $productModel->where('is_active', 1)->countAllResults(),
            'totalUsers' => $userModel->where('role', 'customer')->countAllResults(),
            'recentOrders' => $orderModel->getOrdersWithUser(10),
            'lowStock' => $productModel->getLowStock(10),
        ];

        //return view('admin/dashboard', $data);
        return view('admin/partials/admin_header', $data)
            . view('admin/dashboard', $data)
            . view('admin/partials/admin_footer');
    }

    public function chartData()
    {
        $orderModel = new OrderModel();
        $raw = $orderModel->getLast7Days();

        $labels = [];
        $counts = [];
        $revenues = [];

        // fill all 7 days
        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-{$i} days"));
            $labels[] = date('D d', strtotime($date));

            $found = array_filter($raw, fn($r) => $r['date'] === $date);
            $found = array_values($found);

            $counts[] = $found ? (int) $found[0]['count'] : 0;
            $revenues[] = $found ? (float) $found[0]['revenue'] : 0;
        }

        return $this->response->setJSON([
            'labels' => $labels,
            'counts' => $counts,
            'revenues' => $revenues,
        ]);
    }

    public function login()
    {
        if (session()->get('user_role') === 'admin') {
            return redirect()->to('/admin/dashboard');
        }
        return view('admin/login');
    }

    public function doLogin()
    {

        //(BRUTE FORCE PROTECTION)
        $throttler = \Config\Services::throttler();

        if ($throttler->check(md5($this->request->getIPAddress() . 'admin'), 5, MINUTE) === false) {
            return redirect()->back()->with('error', 'Too many attempts. Wait 1 minute.');
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
        $user = $userModel->findByEmail($email);

        if (!$user || $user['role'] !== 'admin' || !$userModel->verifyPassword($password, $user['password'])) {
            return redirect()->back()->with('error', 'Invalid admin credentials.');
        }

        session()->set([
            'user_id' => $user['id'],
            'user_name' => $user['full_name'],
            'user_email' => $user['email'],
            'user_role' => $user['role'],
        ]);

        return redirect()->to('/admin/dashboard');
    }
}