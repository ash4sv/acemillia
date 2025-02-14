<?php

namespace App\Http\Controllers\WebPage;

use App\Http\Controllers\Controller;
use App\Models\Shop\Category;
use App\Models\Shop\Product;
use Illuminate\Http\Request;

class WebController extends Controller
{
    public function index()
    {
        return view('webpage.index');
    }

    public function category($category)
    {
        $category = Category::active()->where('slug', $category)->firstOrFail();
        $products = $category->products()->active()->get();
        $categories = Category::active()->get();
        return view('webpage.shop-page', [
            'category' => $category,
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    public function product($category, $slug)
    {
        $category = Category::active()->where('slug', $category)->firstOrFail();
        $product  = Product::with(['images', 'options', 'options.values', 'categories', 'sub_categories', 'tags'])->active()->where('slug', $slug)->firstOrFail();
        return view('webpage.shop-single', [
            'category' => $category,
            'product' => $product,
        ]);
    }
}
