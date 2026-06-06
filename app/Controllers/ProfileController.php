<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\OrderModel;

class ProfileController extends BaseController
{
    public function index()
    {
        $userId = session()->get('user_id');
        $userModel = new UserModel();
        $user = $userModel->find($userId);

        $orderModel = new OrderModel();
        $orders = $orderModel->getUserOrders($userId);

        $db = \Config\Database::connect();

        $wishlist = $db->table('wishlist')
            ->select('wishlist.id, wishlist.product_id, wishlist.created_at, p.name, p.price, p.image_url, p.slug, p.rating')
            ->join('products p', 'p.id = wishlist.product_id')
            ->where('wishlist.user_id', $userId)
            ->get()->getResultArray();

        $categoryModel = new \App\Models\CategoryModel();
        $data = [
            'title' => 'My Profile — Amjad\'s Mart',
            'user' => $user,
            'orders' => $orders,
            'wishlist' => $wishlist,
            'cartCount' => (new \App\Models\CartModel())->getCount($userId),
            'categories' => $categoryModel->getActive(),
        ];

        return view('templates/header', $data)
            . view('profile/index', $data)
            . view('templates/footer', $data);
    }

    public function update()
    {
        $userId = session()->get('user_id');
        $userModel = new UserModel();
        $post = $this->request->getPost();

        if ($userModel->emailExists($post['email'], $userId)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Email already in use.']);
        }

        $userModel->update($userId, [
            'full_name' => $post['full_name'],
            'email' => $post['email'],
            'phone' => $post['phone'] ?? '',
            'address' => $post['address'] ?? '',
            'city' => $post['city'] ?? '',
        ]);

        session()->set(['user_name' => $post['full_name'], 'user_email' => $post['email']]);
        return $this->response->setJSON(['success' => true, 'message' => 'Profile updated!']);
    }

    public function changePassword()
    {
        $userId = session()->get('user_id');
        $userModel = new UserModel();
        $user = $userModel->find($userId);

        $current = $this->request->getPost('current_password');
        $new = $this->request->getPost('new_password');
        $confirm = $this->request->getPost('confirm_password');

        if (!$userModel->verifyPassword($current, $user['password'])) {
            return $this->response->setJSON(['success' => false, 'message' => 'Current password incorrect.']);
        }

        if ($new !== $confirm) {
            return $this->response->setJSON(['success' => false, 'message' => 'Passwords do not match.']);
        }

        if (strlen($new) < 6) {
            return $this->response->setJSON(['success' => false, 'message' => 'Minimum 6 characters required.']);
        }

        $userModel->update($userId, ['password' => $new]);
        return $this->response->setJSON(['success' => true, 'message' => 'Password changed successfully!']);
    }

    public function orders()
    {
        $userId = session()->get('user_id');
        $orderModel = new OrderModel();
        $orders = $orderModel->getUserOrders($userId);
        return $this->response->setJSON(['success' => true, 'orders' => $orders]);
    }

    public function wishlist()
    {
        $userId = session()->get('user_id');
        $db = \Config\Database::connect();
        $items = $db->table('wishlist')
            ->select('wishlist.product_id, p.name, p.price, p.image_url, p.slug')
            ->join('products p', 'p.id = wishlist.product_id')
            ->where('wishlist.user_id', $userId)
            ->get()->getResultArray();

        return $this->response->setJSON(['success' => true, 'items' => $items]);
    }

    public function toggleWishlist()
    {
        $userId = session()->get('user_id');
        $productId = (int) $this->request->getPost('product_id');
        $db = \Config\Database::connect();

        $existing = $db->table('wishlist')
            ->where('user_id', $userId)
            ->where('product_id', $productId)
            ->get()->getRowArray();

        if ($existing) {
            $db->table('wishlist')->where('user_id', $userId)->where('product_id', $productId)->delete();
            $inWishlist = false;
            $message = 'Removed from wishlist.';
        } else {
            $db->table('wishlist')->insert(['user_id' => $userId, 'product_id' => $productId]);
            $inWishlist = true;
            $message = 'Added to wishlist!';
        }

        $count = $db->table('wishlist')->where('user_id', $userId)->countAllResults();
        return $this->response->setJSON(['success' => true, 'in_wishlist' => $inWishlist, 'message' => $message, 'count' => $count]);
    }
}