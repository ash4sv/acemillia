<?php

namespace App\Http\Controllers\WebPage;

use App\Http\Controllers\Controller;
use App\Models\Admin\MenuSetup;
use App\Models\Shop\Category;
use App\Models\Shop\Product;
use Illuminate\Http\Request;

class WebController extends Controller
{
    public function index()
    {
        return view('webpage.index');
    }

    public function shopIndex(string $menu)
    {
        // Get the menu setup (as in your original code)
        $menuSlug = MenuSetup::active()->where('slug', $menu)->firstOrFail();

        // Get the active categories associated with the menu, ordered by category name, and eager-load only active products for each category.
        $categories = $menuSlug->categories()
            ->active()
            ->orderBy('name', 'asc')
            ->with(['products' => function ($query) {
                 $query->active();
            }])
            ->get();

        // Merge products from each category into one collection and filter unique products by 'id'
        $products = $categories->flatMap(function ($category) {
            return $category->products;
        })->unique('id')->values();

        return view('webpage.shop-page', [
            'menuSlug' => $menuSlug,
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    public function shopCategory(string $menu, string $category)
    {
        // Retrieve the active MenuSetup using the provided slug
        $menuSlug = MenuSetup::active()->where('slug', $menu)->firstOrFail();

        // Verify that the provided category slug is linked to the menuSlug
        $categoryModel = $menuSlug->categories()
            ->active()
            ->where('slug', $category)
            ->firstOrFail();

        // Fetch active products that are linked to this category,
        $products = $categoryModel->products()
            ->active()
            ->with('categories')
            ->get();

        return view('webpage.shop-page', [
            'menuSlug' => $menuSlug,
            'category' => $categoryModel,
            'products' => $products,
        ]);
    }

    public function shopProduct(string $menu, string $category, string $slug)
    {
        // Retrieve the active MenuSetup using the provided slug
        $menuSlug = MenuSetup::active()->where('slug', $menu)->firstOrFail();

        // Verify that the provided category slug is linked to the menuSlug
        $categoryModel = $menuSlug->categories()
            ->active()
            ->where('slug', $category)
            ->firstOrFail();

        // Retrieve the active product from the category that matches the provided product slug.
        $product = $categoryModel->products()
            ->active()
            ->where('slug', $slug)
            ->with('categories')
            ->firstOrFail();

        // Retrieve related products from the same category, excluding the current product.
        $relatedProducts = $categoryModel->products()
            ->active()
            ->where('products.id', '!=', $product->id)
            ->with('categories')
            ->get();

        // Pass all the necessary data to the view
        return view('webpage.shop-single', [
            'menuSlug'        => $menuSlug,
            'category'        => $categoryModel,
            'product'         => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }

    public function quickview(string $id)
    {
        $product  = Product::with(['images', 'options', 'options.values', 'categories', 'sub_categories', 'tags'])->active()->where('id', $id)->firstOrFail();
        return view('webpage.quick-view', [
            'product' => $product,
        ]);
    }
}
