<?php

namespace App\Services;

use App\Models\Merchant;

class MerchantWalletService
{
    public static function credit(Merchant $merchant, float $amount, $source, string $type = 'SALE', ?string $remarks = null)
    {
        $wallet = $merchant->wallet()->firstOrCreate([]);
        $wallet->increment('balance', $amount);
        if ($type === 'SALE') {
            $wallet->increment('total_earned', $amount);
        }

        $merchant->walletTransactions()->create([
            'amount' => $amount,
            'type' => $type,
            'source_type' => get_class($source),
            'source_id' => $source->id,
            'remarks' => $remarks,
        ]);
    }

    public static function debit(Merchant $merchant, float $amount, $source, string $type = 'WITHDRAW', ?string $remarks = null)
    {
        $wallet = $merchant->wallet;
        if ($wallet->balance < $amount) {
            throw new \Exception("Insufficient wallet balance.");
        }

        $wallet->decrement('balance', $amount);
        if ($type === 'WITHDRAW') {
            $wallet->increment('total_withdrawn', $amount);
        }

        $merchant->walletTransactions()->create([
            'amount' => -$amount,
            'type' => $type,
            'source_type' => is_object($source) ? get_class($source) : null,
            'source_id' => is_object($source) ? $source->id : null,
            'remarks' => $remarks,
        ]);
    }
}

