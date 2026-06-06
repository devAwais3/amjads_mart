<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ContactModel;

class MessagesController extends BaseController
{
    public function index()
    {
        $contactModel = new ContactModel();
        $data = [
            'title' => 'Messages — Admin',
            'messages' => $contactModel->orderBy('created_at', 'DESC')->findAll(),
        ];

        return view('admin/partials/admin_header', ['title' => 'Messages — Admin'])
            . view('admin/messages', [
                'title' => 'Messages — Admin',
                'messages' => $contactModel->orderBy('created_at', 'DESC')->findAll(),
            ])
            . view('admin/partials/admin_footer');
    }

    public function toggleRead(int $id)
    {
        $contactModel = new ContactModel();
        $msg = $contactModel->find($id);
        if (!$msg)
            return $this->response->setJSON(['success' => false]);

        $newStatus = $msg['is_read'] ? 0 : 1;
        $contactModel->update($id, ['is_read' => $newStatus]);

        return $this->response->setJSON(['success' => true, 'is_read' => $newStatus]);
    }
}