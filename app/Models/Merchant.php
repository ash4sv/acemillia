<?php

namespace App\Models;

use App\Models\Admin\MenuSetup;
use App\Models\Shop\SpecialOffer;
use App\Notifications\User\MerchantEmailVerificationNotification;
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

    public function specialOffers()
    {
        return $this->hasMany(SpecialOffer::class, 'product_id', 'id');
    }

    public function menuSetup()
    {
        return $this->belongsTo(MenuSetup::class, 'menu_setup_id', 'id');
    }
}
