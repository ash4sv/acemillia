<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Shared\ProductBaseController;
use App\Models\Shop\Category;
use App\Models\Shop\Product;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ProductMerchantController extends ProductBaseController
{
    protected string $view = 'apps.merchant.products.';
    protected string $route = 'merchant.products.';

    private $auth;

    public function __construct()
    {
        parent::__construct();
        $this->auth = auth()->guard('merchant')->user();
        if ($this->auth && $this->auth->menuSetup) {
            $this->categories = Category::active()
            ->whereHas('menus', function ($query) {
                $query->where('menu_setups.id', $this->auth->menuSetup->id);
            })->get();
        }
    }

    /**
     * Override to inject the merchant's ID.
     */
    protected function getMerchantId()
    {
        return $this->auth->id;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Delete Product!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view($this->view . 'index', [
            'authUser' => $this->auth,
            'products' => Product::where('merchant_id', $this->getMerchantId())->paginate(12)->appends(['section' => 'products'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view($this->view . 'form', [
            'authUser' => $this->auth,
            'product'  => null,
            'categories' => $this->categories,
            'tags' => $this->tags,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->updateOrCreateProduct($request);
        Alert::success('Successfully Create!', 'Product has been created!');
        return redirect()->route($this->route . 'index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view($this->view . 'show', [
            'authUser' => $this->auth,
            'product' => $this->findOrFailProduct($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view($this->view . 'form', [
            'authUser' => $this->auth,
            'product' => $this->findOrFailProduct($id),
            'categories' => $this->categories,
            'tags' => $this->tags,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->updateOrCreateProduct($request, $id);
        Alert::success('Successfully Update!', 'Product has been updated!');
        return redirect()->route($this->route . 'index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = $this->findOrFailProduct($id);
        // $product->images()->delete();
        // $product->options()->delete();
        // $product->options()->values()->delete();
        $product->delete();
        Alert::success('Successfully Deleted!', 'Product has been deleted!');
        return redirect()->back();
    }
}
