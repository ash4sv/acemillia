<?php

namespace App\Models\Merchant;

use App\Enums\WalletTransactionEnum;
use App\Models\Merchant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WalletTransaction extends Model
{
    use SoftDeletes;

    protected $table = 'wallet_transactions';

    protected $fillable = [
        'merchant_id',
        'type',
        'amount',
        'remarks',
        'source',
    ];

    protected $guarded = [];

    protected $casts = [
        'type' => WalletTransactionEnum::class
    ];

    public function merchant() {
        return $this->belongsTo(Merchant::class, 'merchant_id', 'id');
    }

    public function source() {
        return $this->morphTo(); // Can be SubOrder, Refund, Admin action, etc.
    }
}
