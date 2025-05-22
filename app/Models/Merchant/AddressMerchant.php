<?php

namespace App\Models\Merchant;

use App\Models\Merchant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AddressMerchant extends Model
{
    use SoftDeletes;

    protected $table = 'address_merchants';

    protected $fillable = [
        'merchant_id',
        'country',
        'state',
        'city',
        'postcode',
        'street_address',
        'business_address',
    ];

    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'merchant_id', 'id');
    }
}
