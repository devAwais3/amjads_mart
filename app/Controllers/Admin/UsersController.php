<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UsersController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $users = $db->table('users u')
            ->select('u.*, (SELECT COUNT(*) FROM orders o WHERE o.user_id = u.id) as order_count')
            ->where('u.role', 'customer')
            ->orderBy('u.created_at', 'DESC')
            ->get()->getResultArray();

        $data = [
            'title' => 'Users — Admin',
            'users' => $users,
        ];

        return view('admin/partials/admin_header', ['title' => 'Users — Admin'])
            . view('admin/users', [
                'title' => 'Users — Admin',
                'users' => $users,
            ])
            . view('admin/partials/admin_footer');
    }

    public function toggle(int $id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);
        if (!$user)
            return $this->response->setJSON(['success' => false]);

        $newStatus = $user['is_active'] ? 0 : 1;
        $userModel->update($id, ['is_active' => $newStatus]);

        return $this->response->setJSON([
            'success' => true,
            'is_active' => $newStatus,
            'message' => $newStatus ? 'User unblocked.' : 'User blocked.',
        ]);
    }
}