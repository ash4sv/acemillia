<?php

namespace App\Models\Merchant;

use App\Models\Merchant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MerchantWallet extends Model
{
    use SoftDeletes;

    protected $table = 'merchant_wallets';

    protected $fillable = [
        'merchant_id',
        'balance',
        'total_earned',
        'total_withdrawn',
    ];

    protected $guarded = [];

    public function merchant() {
        return $this->belongsTo(Merchant::class, 'merchant_id', 'id');
    }
}
