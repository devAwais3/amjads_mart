<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CouponModel;

class CouponsController extends BaseController
{
    public function index()
    {
        $couponModel = new CouponModel();
        $data = [
            'title' => 'Coupons — Admin',
            'coupons' => $couponModel->orderBy('created_at', 'DESC')->findAll(),
        ];

        return view('admin/partials/admin_header', ['title' => 'Coupons — Admin'])
            . view('admin/coupons', [
                'title' => 'Coupons — Admin',
                'coupons' => $couponModel->orderBy('created_at', 'DESC')->findAll(),
            ])
            . view('admin/partials/admin_footer');
    }

    public function store()
    {
        $post = $this->request->getPost();

        $couponModel = new CouponModel();
        $couponModel->insert([
            'code' => strtoupper(trim($post['code'])),
            'discount_percent' => (int) $post['discount_percent'],
            'min_order_amount' => (float) $post['min_order_amount'],
            'is_active' => 1,
            'expires_at' => $post['expires_at'] ?: null,
        ]);

        return $this->response->setJSON(['success' => true, 'message' => 'Coupon created!']);
    }

    public function delete(int $id)
    {
        $couponModel = new CouponModel();
        $couponModel->delete($id);
        return $this->response->setJSON(['success' => true, 'message' => 'Coupon deleted.']);
    }
}