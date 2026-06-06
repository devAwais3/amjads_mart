<?php

namespace App\Models;

use CodeIgniter\Model;

class CouponModel extends Model
{
    protected $table         = 'coupons';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['code','discount_percent','min_order_amount','is_active','expires_at'];

    public function validateCoupon(string $code, float $orderAmount): array
    {
        $coupon = $this->where('code', strtoupper($code))
                       ->where('is_active', 1)
                       ->first();

        if (! $coupon) {
            return ['valid' => false, 'message' => 'Invalid coupon code.'];
        }

        if ($coupon['expires_at'] && strtotime($coupon['expires_at']) < time()) {
            return ['valid' => false, 'message' => 'Coupon has expired.'];
        }

        if ($orderAmount < $coupon['min_order_amount']) {
            return [
                'valid'   => false,
                'message' => 'Minimum order Rs.' . number_format($coupon['min_order_amount'], 0) . ' required.'
            ];
        }

        $discount = ($orderAmount * $coupon['discount_percent']) / 100;
        return [
            'valid'            => true,
            'discount_percent' => $coupon['discount_percent'],
            'discount_amount'  => round($discount, 2),
            'message'          => $coupon['discount_percent'] . '% discount applied!',
        ];
    }
}