<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Merchant\WalletWithdrawRequest;
use App\Services\MerchantWalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class WalletWithdrawRequestApprovalAdminController extends Controller
{
    public function approve($id)
    {
        $withdraw = WalletWithdrawRequest::where('status', 'pending')->findOrFail($id);

        DB::transaction(function () use ($withdraw) {
            $withdraw->update([
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => auth()->guard('admin')->id(),
            ]);

            MerchantWalletService::debit($withdraw->merchant, $withdraw->amount, $withdraw, 'WITHDRAW', 'Withdraw Approved');
        });

        Alert::success('Success', 'Withdrawal approved and wallet debited.');
        return back();
    }
}
