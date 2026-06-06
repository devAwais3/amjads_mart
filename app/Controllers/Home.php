<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\NewsletterModel;

class Home extends BaseController
{
    public function index()
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();

        $data = [
            'title' => "Amjad's Mart — Fresh. Fast. Local.",
            'categories' => $categoryModel->getActive(),
            'featured' => $productModel->getFeatured(8),
            'onSale' => $productModel->getOnSale(8),
            'cartCount' => $this->getCartCount(),
        ];

        return view('templates/header', $data)
            . view('home/index', $data)
            . view('templates/footer', $data);
    }

    public function subscribe()
    {
        //$this->request->isAJAX() ?: redirect()->back();
        //if (!$this->request->isAJAX()) return redirect()->back();
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $email = trim($this->request->getPost('email'));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid email address.']);
        }

        $model = new NewsletterModel();
        $result = $model->subscribe($email);

        if ($result['success']) {
            $mailer = new \App\Libraries\ResendMailer();
            $mailer->sendWelcomeNewsletter($email);
        }

        return $this->response->setJSON($result);
    }

    private function getCartCount(): int
    {
        if (!session()->get('user_id'))
            return 0;
        $cartModel = new \App\Models\CartModel();
        return $cartModel->getCount(session()->get('user_id'));
    }
}