<?php

namespace App\Models;

use CodeIgniter\Model;

class NewsletterModel extends Model
{
    protected $table         = 'newsletter_subscribers';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['email','is_active'];

    public function subscribe(string $email): array
    {
        $existing = $this->where('email', $email)->first();
        if ($existing) {
            if ($existing['is_active']) {
                return ['success' => false, 'message' => 'Already subscribed!'];
            }
            $this->update($existing['id'], ['is_active' => 1]);
            return ['success' => true, 'message' => 'Welcome back! You\'re re-subscribed.'];
        }
        $this->insert(['email' => $email, 'is_active' => 1]);
        return ['success' => true, 'message' => 'Subscribed! Welcome to Amjad\'s Mart 🎉'];
    }
}