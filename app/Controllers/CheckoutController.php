<?php

namespace App\Controllers;

use App\Models\CartModel;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\ProductModel;
use App\Models\CouponModel;
use App\Libraries\ResendMailer;

class CheckoutController extends BaseController
{
    public function index()
    {
        $userId = session()->get('user_id');
        $cartModel = new CartModel();
        $items = $cartModel->getCartWithProducts($userId);

        if (empty($items)) {
            return redirect()->to('/cart')->with('error', 'Your cart is empty.');
        }

        $subtotal = array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $items));
        $deliveryFee = $subtotal < 1000 ? 150 : 0;
        $total = $subtotal + $deliveryFee;

        $categoryModel = new \App\Models\CategoryModel();
        $data = [
            'title' => 'Checkout — Amjad\'s Mart',
            'items' => $items,
            'subtotal' => $subtotal,
            'deliveryFee' => $deliveryFee,
            'total' => $total,
            'user' => session()->get('user_data') ?? [],
            'cartCount' => count($items),
            'categories' => $categoryModel->getActive(),
        ];

        return view('templates/header', $data)
            . view('checkout/index', $data)
            . view('templates/footer', $data);
    }

    public function placeOrder()
    {

        $userId = session()->get('user_id');
        $cartModel = new CartModel();
        $items = $cartModel->getCartWithProducts($userId);

        if (empty($items)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Cart is empty.']);
        }

        $post = $this->request->getPost();
        $phone = trim($post['delivery_phone'] ?? '');

        // ✅ 11 DIGITS VALIDATION
        if (!preg_match('/^\d{11}$/', $phone)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Phone number must be exactly 11 digits'
            ])->setStatusCode(400);
        }

        $paymentMethod = trim($post['payment_method'] ?? '');
        $transactionId = trim($post['transaction_id'] ?? '');

        // ✅ FINAL HARD VALIDATION (FIXED)
        if (
            ($paymentMethod === 'easypaisa' || $paymentMethod === 'jazzcash') &&
            (empty(trim($transactionId)) || trim($transactionId) === '')
        ) {
            log_message('error', 'BLOCKED ORDER: missing transaction ID');

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Transaction ID is required'
            ])->setStatusCode(400);
        }

        $subtotal = array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $items));
        $deliveryFee = $subtotal < 1000 ? 150 : 0;

        // Coupon
        $discountAmount = 0;
        if (!empty($post['coupon_code'])) {
            $couponModel = new CouponModel();
            $coupon = $couponModel->validateCoupon($post['coupon_code'], $subtotal);
            if ($coupon['valid']) {
                $discountAmount = $coupon['discount_amount'];
            }
        }

        $total = $subtotal + $deliveryFee - $discountAmount;

        $orderModel = new OrderModel();

        $orderData = [
            'user_id' => $userId,
            'status' => 'pending',
            'subtotal' => $subtotal,
            'delivery_fee' => $deliveryFee,
            'discount_amount' => $discountAmount,
            'total' => $total,
            'payment_method' => $paymentMethod ?: 'cod',
            'transaction_id' => $transactionId ?: null,
            'delivery_name' => $post['delivery_name'],
            'delivery_phone' => $post['delivery_phone'],
            'delivery_address' => $post['delivery_address'],
            'delivery_city' => $post['delivery_city'],
            'delivery_area' => $post['delivery_area'] ?? '',
            'order_notes' => $post['order_notes'] ?? '',
        ];

        $orderId = $orderModel->insert($orderData);
        $orderItemModel = new OrderItemModel();

        $productModel = new ProductModel();

        foreach ($items as $item) {
            $orderItemModel->insert([
                'order_id' => $orderId,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
                'subtotal' => $item['price'] * $item['quantity'],
            ]);

            // Decrease stock
            $prod = $productModel->find($item['product_id']);
            if ($prod) {
                $productModel->update(
                    $item['product_id'],
                    ['stock' => max(0, $prod['stock'] - $item['quantity'])]
                );
            }
        }

        $cartModel->clearCart($userId);

        // Send confirmation email
        $orderDetail = $orderModel->getOrderDetail($orderId);
        $userEmail = session()->get('user_email');
        $userName = session()->get('user_name');

        $mailer = new ResendMailer();
        $mailer->sendOrderConfirmation($orderDetail, $userEmail, $userName);

        return $this->response->setJSON([
            'success' => true,
            'order_id' => $orderId,
            'redirect' => base_url('checkout/success/' . $orderId),
        ]);
    }

    public function success(int $orderId)
    {
        $orderModel = new OrderModel();
        $order = $orderModel->getOrderDetail($orderId);

        if (!$order || $order['user_id'] != session()->get('user_id')) {
            return redirect()->to('/');
        }

        $categoryModel = new \App\Models\CategoryModel();
        $data = [
            'title' => 'Order Placed! — Amjad\'s Mart',
            'order' => $order,
            'cartCount' => 0,
            'categories' => $categoryModel->getActive(),
        ];

        return view('templates/header', $data)
            . view('checkout/success', $data)
            . view('templates/footer', $data);
    }
}