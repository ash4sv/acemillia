<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Merchant\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletMerchantController extends Controller
{
    public function transactions()
    {
        $merchant = Auth::guard('merchant')->user();

        return datatables()->of(
            WalletTransaction::where('merchant_id', $merchant->id)->latest()
        )
            ->addColumn('type', function ($row) {
                return ucfirst(str_replace('_', ' ', strtolower($row->type->value)));
            })
            ->editColumn('amount', function ($row) {
                $amount = number_format(abs($row->amount), 2);
                return $row->amount >= 0
                    ? "<span class='text-success'>+RM $amount</span>"
                    : "<span class='text-danger'>-RM $amount</span>";
            })
            ->editColumn('created_at', fn($row) => $row->created_at->format('Y-m-d H:i'))
            ->rawColumns(['amount'])
            ->make(true);
    }
}
