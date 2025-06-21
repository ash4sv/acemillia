<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\ProductAdminDataTable;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Shared\ProductBaseController;
use App\Models\Shop\Category;
use App\Models\Shop\Product;
use App\Models\Shop\Tag;
use App\Services\ImageUploader;
use App\Services\ModelResponse;
use App\Services\SlugGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class ProductAdminController extends ProductBaseController
{
    protected string $view = 'apps.admin.shop.products.';

    /**
     * Display a listing of the resource.
     */
    public function index(ProductAdminDataTable $dataTable)
    {
        $title = 'Delete Product!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return $dataTable->render($this->view . 'index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view($this->view . 'form', [
            'product' => null,
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
        return ModelResponse::make()
            ->title('Successfully Created!')
            ->message('Product has been successfully created!')
            ->type('success')
            ->close();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view($this->view . 'show', [
            'product' => $this->findOrFailProduct($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view($this->view . 'form', [
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
        // return $request->all();
        $this->updateOrCreateProduct($request, $id);
        return ModelResponse::make()
            ->title('Successfully Updated!')
            ->message('Product has been successfully updated.')
            ->type('success')
            ->close();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = $this->findOrFailProduct($id);
        $product->images()->delete();
        $product->options()->delete();
        $product->options()->values()->delete();
        $product->delete();
        Alert::success('Successfully Deleted!', 'Sub Category has been deleted!');
        return redirect()->back();
    }
}
