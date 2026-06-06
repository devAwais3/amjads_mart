<?php

namespace App\Controllers;

use App\Models\ContactModel;
use App\Libraries\ResendMailer;

class ContactController extends BaseController
{
    public function index()
    {
        $categoryModel = new \App\Models\CategoryModel();
        $data = [
            'title'      => 'Contact Us — Amjad\'s Mart',
            'cartCount'  => session()->get('user_id') ? (new \App\Models\CartModel())->getCount(session()->get('user_id')) : 0,
            'categories' => $categoryModel->getActive(),
        ];
        return view('templates/header', $data)
             . view('contact/index', $data)
             . view('templates/footer', $data);
    }

    public function send()
    {
        $post = $this->request->getPost();

        $validation = \Config\Services::validation();
        $validation->setRules([
            'name'    => 'required|min_length[2]',
            'email'   => 'required|valid_email',
            'subject' => 'required|min_length[3]',
            'message' => 'required|min_length[100]',
        ]);

        if (! $validation->run($post)) {
            return $this->response->setJSON(['success' => false, 'errors' => $validation->getErrors()]);
        }

        $contactModel = new ContactModel();
        $contactModel->insert([
            'name'    => esc($post['name']),
            'email'   => esc($post['email']),
            'subject' => esc($post['subject']),
            'message' => esc($post['message']),
            'is_read' => 0,
        ]);

        $mailer = new ResendMailer();
        $mailer->sendContactNotification([
            'name'    => $post['name'],
            'email'   => $post['email'],
            'subject' => $post['subject'],
            'message' => $post['message'],
        ]);

        return $this->response->setJSON(['success' => true, 'message' => 'Message sent! We will reply within 24 hours.']);
    }
}