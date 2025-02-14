<?php

namespace App\Services\Coupons;

use RealRashid\Cart\Coupon\Coupon as CouponContract;
use App\Models\Organizer\BoothConfig\BoothPromo as CouponModel;

class FixedAmountCoupon implements CouponContract
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
        return 'fixed_amount';
    }

    public function getExpiryDate()
    {
        return $this->coupon->end_date->format('Y-m-d H:i:s');
    }

    public function getDiscountAmount(): float
    {
        return $this->coupon->discount_amount;
    }
}
