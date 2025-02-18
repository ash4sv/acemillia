<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shop\Category;
use Illuminate\Http\Request;

class ShopAdminController extends Controller
{
    public function getSubcategories($categoryId)
    {
        $category = Category::active()->findOrFail($categoryId);
        // Use the exact relationship method name: sub_categories()
        $subcategories = $category->sub_categories()->select('sub_categories.*')->active()->get();
        return response()->json($subcategories);
    }
}
