<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function index()
    {
        if (session()->get('user_id')) {
            return redirect()->to('/profile');
        }

        $categoryModel = new \App\Models\CategoryModel();
        $data = [
            'title' => 'Login / Register — Amjad\'s Mart',
            'cartCount' => 0,
            'categories' => $categoryModel->getActive(),
        ];

        return view('templates/header', $data)
            . view('auth/index', $data)
            . view('templates/footer', $data);
    }

    public function login()
    {

        $throttler = \Config\Services::throttler();

        if ($throttler->check(md5($this->request->getIPAddress()), 5, MINUTE) === false) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Too many attempts. Wait 1 minute.'
            ]);
        }

        $email = trim($this->request->getPost('email'));
        $password = $this->request->getPost('password');
        $remember = $this->request->getPost('remember');

        $userModel = new UserModel();
        $user = $userModel->findByEmail($email);

        if (!$user || !$userModel->verifyPassword($password, $user['password'])) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid email or password.']);
        }

        session()->set([
            'user_id' => $user['id'],
            'user_name' => $user['full_name'],
            'user_email' => $user['email'],
            'user_role' => $user['role'],
            'user_data' => $user,
        ]);

        if ($remember) {
            $token = bin2hex(random_bytes(32));
            $userModel->update($user['id'], ['remember_token' => $token]);
            setcookie('remember_token', $token, time() + (86400 * 30), '/', '', false, true);
        }

        $redirect = $user['role'] === 'admin'
            ? base_url('admin/dashboard')
            : base_url();
        return $this->response->setJSON(['success' => true, 'redirect' => $redirect]);
    }

    public function register()
    
    {
        dd($this->request->getPost());
        $post = $this->request->getPost();

        $validation = \Config\Services::validation();

$validation->setRules([
    'full_name' => 'required|min_length[2]|max_length[100]',
    'email' => 'required|valid_email',

    'phone' => [
        'rules' => 'required|regex_match[/^[0-9]{11}$/]',
        'errors' => [
            'regex_match' => 'Phone number must be exactly 11 digits.'
        ]
    ],

    'password' => [
        'rules' => 'required|min_length[8]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/]',
        'errors' => [
            'regex_match' => 'Password must contain uppercase, lowercase, number and special character.'
        ]
    ],

    'confirm_password' => 'required|matches[password]',
]);

        if (!$validation->run($post)) {
            return $this->response->setJSON(['success' => false, 'errors' => $validation->getErrors()]);
        }

        $userModel = new UserModel();
        if ($userModel->emailExists($post['email'])) {
            return $this->response->setJSON(['success' => false, 'message' => 'Email already registered.']);
        }

        $userId = $userModel->insert([
            'full_name' => $post['full_name'],
            'email' => $post['email'],
            'phone' => $post['phone'] ?? '',
            'password' => $post['password'],
            'role' => 'customer',
            'is_active' => 1,
        ]);

        $user = $userModel->find($userId);
        session()->set([
            'user_id' => $user['id'],
            'user_name' => $user['full_name'],
            'user_email' => $user['email'],
            'user_role' => $user['role'],
            'user_data' => $user,
        ]);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'You have successfully registered. You can now login.',
            'redirect' => base_url('login')
        ]);
    }

    public function logout()
    {
        session()->destroy();
        setcookie('remember_token', '', time() - 3600, '/');
        return redirect()->to('/login');
    }

    public function checkEmail()
    {
        $email = trim($this->request->getGet('email'));
        $userModel = new UserModel();
        $exists = $userModel->emailExists($email);
        return $this->response->setJSON(['exists' => $exists]);
    }
}