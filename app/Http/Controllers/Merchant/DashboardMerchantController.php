<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Order\SubOrder;
use App\Models\Shop\Product;
use App\Services\ImageUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class DashboardMerchantController extends Controller
{
    protected string $view = 'apps.merchant.';

    private $auth;

    public function __construct()
    {
        $this->auth = auth()->guard('merchant')->user();
    }

    /**
     * Override to inject the merchant's ID.
     */
    protected function getMerchantId()
    {
        return $this->auth->id;
    }

    public function index()
    {
        return view($this->view . 'dashboard.index', [
            'authUser' => $this->auth,
            'products' => Product::where('merchant_id', $this->getMerchantId())->get()
        ]);
    }

    public function orders()
    {
        $subOrders = SubOrder::with([
            'order.user',
            'items',
            'shippingLogs',
        ])->where('merchant_id', $this->getMerchantId())->get();
        return view($this->view . 'orders.index', [
            'authUser'  => $this->auth,
            'subOrders' => $subOrders
        ]);
    }

    public function profile()
    {
        return view($this->view . 'profile.index', [
            'authUser' => $this->auth
        ]);
    }

    public function profileEdit()
    {
        return view($this->view . 'profile.form', [
            'authUser' => $this->auth
        ]);
    }

    public function profileUpdate(Request $request)
    {
        $merchant = auth()->guard('merchant')->user();

        $companyNameClear = preg_replace('/\s+/', '-', $merchant->company_name);
        $imageFilePath = $request->file('business_license_document')
            ? ImageUploader::uploadSingleImage($request->file('business_license_document'), 'assets/upload/', strtolower($companyNameClear) . '_license')
            : ($merchant->business_license_document ?? null);

        $data = $request->only([
            'company_name', 'company_registration_number', 'tax_id', 'bank_name_account', 'bank_account_details', 'name', 'email', 'phone',
        ]);
        $merchant->update(array_merge($data, [
            'business_license_document' => $imageFilePath
        ]));

        Alert::success('Success', 'Your profile has been updated');
        return redirect()->route('merchant.dashboard', ['section' => 'profile']);
    }

    public function passwordEdit()
    {
        return view($this->view . 'profile.password', [
            'authUser' => $this->auth
        ]);
    }

    public function passwordUpdate(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|confirmed',
        ]);

        $merchant = auth()->guard('merchant')->user();

        if (!Hash::check($request->current_password, $merchant->password)) {
            Alert::error('Error', 'Current password is incorrect.');
            return redirect()->back();
        }

        $merchant->password = Hash::make($request->password);
        $merchant->save();

        Alert::success('Success', 'Password updated successfully.');
        return redirect()->route('merchant.dashboard', ['section' => 'profile']);
    }

    public function settings()
    {
        return view($this->view . 'settings.index', [
            'authUser' => $this->auth
        ]);
    }
}
