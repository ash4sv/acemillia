<?php

namespace App\Services\Coupons;

use RealRashid\Cart\Coupon\Coupon as CouponContract;
use App\Models\Organizer\BoothConfig\BoothPromo as CouponModel;
use RealRashid\Cart\Facades\Cart;

class PercentageCoupon implements CouponContract
{

    protected $coupon;

    public function __construct(CouponModel $coupon)
    {
        $this->coupon = $coupon;
    }

    public function getCode(): string
    {
        return $this->coupon->code;
    }

    public function isValid(): bool
    {
        $now = now();
        if ($this->coupon->start_date > $now || $this->coupon->end_date < $now) {
            return false;
        }
        if (!$this->coupon->publish) {
            return false;
        }
        return true;
    }

    public function getDiscountType(): string
    {
        return 'percentage';
    }

    public function getExpiryDate()
    {
        return $this->coupon->end_date->format('Y-m-d H:i:s');
    }

    public function getDiscountAmount(): float
    {
        $discount = $this->coupon->discount_percentage;

        return round($discount, 2);
    }
}
