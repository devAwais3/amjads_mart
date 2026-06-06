<?php

namespace App\Controllers;

use App\Models\CartModel;
use App\Models\ProductModel;
use App\Models\CouponModel;

class CartController extends BaseController
{
    private CartModel $cartModel;
    private ProductModel $productModel;

    public function __construct()
    {
        $this->cartModel = new CartModel();
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        $userId = session()->get('user_id');
        $items = $userId ? $this->cartModel->getCartWithProducts($userId) : [];

        [$subtotal, $deliveryFee, $total] = $this->calculateTotals($items);

        $categoryModel = new \App\Models\CategoryModel();
        $data = [
            'title' => 'Cart — Amjad\'s Mart',
            'items' => $items,
            'subtotal' => $subtotal,
            'deliveryFee' => $deliveryFee,
            'total' => $total,
            'cartCount' => count($items),
            'categories' => $categoryModel->getActive(),
        ];

        return view('templates/header', $data)
            . view('cart/index', $data)
            . view('templates/footer', $data);
    }

    public function add()
    {
        if (!session()->get('user_id')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Login required', 'redirect' => base_url('login')]);
        }

        $productId = (int) $this->request->getPost('product_id');
        $qty = max(1, (int) $this->request->getPost('quantity'));
        $product = $this->productModel->find($productId);

        if (!$product || !$product['is_active']) {
            return $this->response->setJSON(['success' => false, 'message' => 'Product not found.']);
        }

        if ($product['stock'] < 1) {
            return $this->response->setJSON(['success' => false, 'message' => 'Out of stock.']);
        }

        $this->cartModel->addOrUpdate(session()->get('user_id'), $productId, $qty);
        $count = $this->cartModel->getCount(session()->get('user_id'));

        return $this->response->setJSON([
            'success' => true,
            'message' => $product['name'] . ' added to cart!',
            'cart_count' => $count,
        ]);
    }

    public function update()
    {
        if (!session()->get('user_id')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Login required.']);
        }

        $productId = (int) $this->request->getPost('product_id');
        $qty = max(1, (int) $this->request->getPost('quantity'));
        $userId = session()->get('user_id');

        $product = $this->productModel->find($productId);

        if (!$product) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Product not found.'
            ]);
        }

        if ($qty > $product['stock']) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Only ' . $product['stock'] . ' items available.'
            ]);
        }

        $this->cartModel->updateQty($userId, $productId, $qty);
        $items = $this->cartModel->getCartWithProducts($userId);
        [$subtotal, $deliveryFee, $total] = $this->calculateTotals($items);

        return $this->response->setJSON([
            'success' => true,
            'subtotal' => number_format($subtotal, 2),
            'delivery_fee' => number_format($deliveryFee, 2),
            'total' => number_format($total, 2),
            'cart_count' => count($items),
        ]);
    }

    public function remove()
    {
        if (!session()->get('user_id')) {
            return $this->response->setJSON(['success' => false]);
        }

        $productId = (int) $this->request->getPost('product_id');
        $userId = session()->get('user_id');
        $this->cartModel->removeItem($userId, $productId);

        $items = $this->cartModel->getCartWithProducts($userId);
        [$subtotal, $deliveryFee, $total] = $this->calculateTotals($items);

        return $this->response->setJSON([
            'success' => true,
            'subtotal' => number_format($subtotal, 2),
            'delivery_fee' => number_format($deliveryFee, 2),
            'total' => number_format($total, 2),
            'cart_count' => count($items),
        ]);
    }

    public function count()
    {
        $userId = session()->get('user_id');
        $count = $userId ? $this->cartModel->getCount($userId) : 0;
        return $this->response->setJSON(['count' => $count]);
    }

    public function applyCoupon()
    {
        $code = trim($this->request->getPost('coupon'));
        $amount = (float) $this->request->getPost('amount');

        $couponModel = new CouponModel();
        $result = $couponModel->validateCoupon($code, $amount);

        return $this->response->setJSON($result);
    }

    private function calculateTotals(array $items): array
    {
        $subtotal = array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $items));
        $deliveryFee = ($subtotal > 0 && $subtotal < 1000) ? 150 : 0;
        $total = $subtotal + $deliveryFee;
        return [$subtotal, $deliveryFee, $total];
    }
}