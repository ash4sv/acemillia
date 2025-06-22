<?php

namespace App\Http\Controllers\Merchant;

use App\DataTables\Merchant\WalletTransactionMerchantDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class WalletWithdrawRequestMerchantController extends Controller
{
    protected string $view = 'apps.merchant.';

    private $auth;

    public function __construct()
    {
        parent::__construct();
        $this->auth = auth()->guard('merchant')->user();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(WalletTransactionMerchantDataTable $dataTable)
    {
        return $dataTable->render('apps.merchant.wallet.index', [
            'authUser' => $this->auth,
            'wallet'   => $this->auth->wallet,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('apps.merchant.wallet.create', [
            'merchant' => $this->auth,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $merchant = auth()->guard('merchant')->user();
        $request->validate([
            'amount' => 'required|numeric|min:10',
            'bank_name' => 'required|string',
            'bank_account_name' => 'required|string',
            'bank_account_number' => 'required|string',
        ]);

        if ($request->amount > $merchant->wallet->balance) {
            return back()->with('error', 'Insufficient balance.');
        }

        $withdraw = $merchant->withdrawRequests()->create($request->only([
            'amount', 'bank_name', 'bank_account_name', 'bank_account_number'
        ]));



        Alert::success('Success', 'Withdrawal request submitted.');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
