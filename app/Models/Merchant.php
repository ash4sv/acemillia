<?php

namespace App\Models;

use App\Models\Admin\MenuSetup;
use App\Models\Order\ShippingStatusLog;
use App\Models\Order\SubOrder;
use App\Models\Shop\Product;
use App\Models\Shop\SpecialOffer;
use App\Models\Social\NewsFeed;
use App\Models\Social\NewsFeedComment;
use App\Models\Social\NewsFeedLike;
use App\Notifications\Merchant\MerchantEmailVerificationNotification;
use App\Notifications\Merchant\MerchantResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Merchant extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'remember_token',
        'phone',
        'company_name',
        'company_registration_number',
        'tax_id',
        'business_license_document',
        'bank_name_account',
        'bank_account_details',
        'menu_setup_id',
        'status_submission',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function sendMerchantEmailVerificationNotification()
    {
        $this->notify(new MerchantEmailVerificationNotification());
    }

    public function getEmailForPasswordReset()
    {
        return $this->email;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MerchantResetPasswordNotification($token));
    }

    public function specialOffers()
    {
        return $this->hasMany(SpecialOffer::class, 'product_id', 'id');
    }

    public function menuSetup()
    {
        return $this->belongsTo(MenuSetup::class, 'menu_setup_id', 'id');
    }

    public function scopeApproved($query)
    {
        return $query->where('status_submission', '=', 'approved');
    }

    public function newsfeeds()
    {
        return $this->morphMany(NewsFeed::class, 'newsfeedable', 'model_type', 'model_id');
    }

    public function newsfeedLikes()
    {
        return $this->morphMany(NewsFeedLike::class, 'actor', 'model_type', 'model_id');
    }

    public function newsfeedComments()
    {
        return $this->morphMany(NewsFeedComment::class, 'actor', 'model_type', 'model_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'product_id', 'id');
    }

    public function subOrders()
    {
        return $this->hasMany(SubOrder::class, 'merchant_id', 'id');
    }

    public function shippingLogs()
    {
        return $this->hasMany(ShippingStatusLog::class, 'created_by', 'id');
    }
}
