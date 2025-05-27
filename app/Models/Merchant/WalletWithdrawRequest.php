<?php

namespace App\Models\Merchant;

use App\Enums\WalletWithdrawRequestEnum;
use App\Models\Merchant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WalletWithdrawRequest extends Model
{
    use SoftDeletes;

    protected $table = 'wallet_withdraw_requests';

    protected $fillable = [
        'merchant_id',
        'amount',
        'bank_name',
        'bank_account_name',
        'bank_account_number',
        'status',
        'admin_remarks',
        'approved_at',
        'approved_by',
    ];

    protected $guarded = [];

    protected $casts = [
        'status' => WalletWithdrawRequestEnum::class
    ];

    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'merchant_id', 'id');
    }
}
