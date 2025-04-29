<?php

namespace App\Http\Controllers\WebPage;

use App\Http\Controllers\Controller;
use App\Models\Admin\Blog\Post;
use App\Models\Admin\Blog\PostCategory;
use App\Models\Admin\Blog\PostTag;
use App\Models\Admin\CarouselSlider;
use App\Models\Admin\MenuSetup;
use App\Models\Shop\Category;
use App\Models\Shop\Product;
use App\Models\Shop\SpecialOffer;
use App\Models\Shop\SubCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WebController extends Controller
{
    protected $tagsSidebar, $categoriesSidebar, $recentPosts;

    public function __construct()
    {
        parent::__construct();
        $this->tagsSidebar = PostTag::active()->get();
        $this->categoriesSidebar = PostCategory::active()->get();
        $this->recentPosts = Post::where('created_at', '>=', Carbon::now()->subWeeks(4))->orderBy('created_at', 'desc')->get();
    }

    public function index()
    {
        $carousels = CarouselSlider::active()->get();
        $categories = Category::active()->get();
        $products = Product::active()->where('price', '<=', 500)->inRandomOrder()->take(8)->get();
        $specialOffers = SpecialOffer::with([
            'product',
            'product.categories',
            'product.categories.menus',
            'product.sub_categories',
        ])->approved()->active()->get();
        $blogPosts = Post::active()->get();
        return view('webpage.index', [
            'carousels' => $carousels,
            'categories' => $categories,
            'specialOffers' => $specialOffers,
            'blogPosts' => $blogPosts,
            'products' => $products,
        ]);
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

        $subCategories = $categories->flatMap(function ($category) {
            return $category->sub_categories()
                ->active()
                ->orderBy('name', 'asc')
                ->get();
        })->unique('id')->sortBy('name')->values();

        $breadcrumbs = array_merge($this->breadcrumbs, [
            ['label' => $menuSlug->name],
        ]);

        return view('webpage.shop-page', [
            'menuSlug' => $menuSlug,
            'products' => $products,
            'categories' => null,
            'subCategories' => $subCategories,
            'breadcrumbs' => $breadcrumbs,
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

        // Retrieve all active categories linked to the MenuSetup, ordered by name.
        $allCategories = $menuSlug->categories()
            ->active()
            ->orderBy('name', 'asc')
            ->get();

        // Retrieve active subcategories for the current category, ordered by name.
        $subCategories = $categoryModel->sub_categories()
            ->active()
            ->orderBy('name', 'asc')
            ->get();

        $breadcrumbs = array_merge($this->breadcrumbs, [
            ['label' => $menuSlug->name, 'url' => route('web.shop.index', $menuSlug->slug)],
            ['label' => $categoryModel->name, 'url' => route('web.shop.category', [$menuSlug->slug, $categoryModel->slug])],
        ]);

        return view('webpage.shop-page', [
            'menuSlug' => $menuSlug,
            'category' => $categoryModel,
            'products' => $products,
            'categories' => null,
            'subCategories' => $subCategories,
            'breadcrumbs' => $breadcrumbs,
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

        $breadcrumbs = array_merge($this->breadcrumbs, [
            ['label' => $menuSlug->name, 'url' => route('web.shop.index', $menuSlug->slug)],
            ['label' => $categoryModel->name, 'url' => route('web.shop.category', [$menuSlug->slug, $categoryModel->slug])],
            ['label' => $product->name,]
        ]);

        // Pass all the necessary data to the view
        return view('webpage.shop-single', [
            'menuSlug'        => $menuSlug,
            'category'        => $categoryModel,
            'product'         => $product,
            'relatedProducts' => $relatedProducts,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    public function shopIndexSort(Request $request, string $menu)
    {
        // Get the active menu setup
        $menuSlug = MenuSetup::active()->where('slug', $menu)->firstOrFail();

        // Retrieve active categories with their active products
        $categories = $menuSlug->categories()
            ->active()
            ->orderBy('name', 'asc')
            ->with(['products' => function ($query) {
                $query->active();
            }])
            ->get();

        // Merge products from each category, ensuring uniqueness by id
        $products = $categories->flatMap(function ($category) {
            return $category->products;
        })->unique('id')->values();

        // Get sort parameter (default is "asc")
        $sort = $request->get('sort', 'asc');

        // Apply sorting based on the sort parameter
        switch ($sort) {
            case 'desc':
                $products = $products->sortByDesc('name');
                break;
            case 'low-high':
                $products = $products->sortBy('price');
                break;
            case 'high-low':
                $products = $products->sortByDesc('price');
                break;
            case 'asc':
            default:
                $products = $products->sortBy('name');
                break;
        }

        // (Optional) Retrieve subcategories if needed in your view
        $subCategories = $categories->flatMap(function ($category) {
            return $category->sub_categories()
                ->active()
                ->orderBy('name', 'asc')
                ->get();
        })->unique('id')->sortBy('name')->values();

        // Render and return only the partial view containing the products markup
        return view('webpage.partials.shop-products', [
            'menuSlug'      => $menuSlug,
            'products'      => $products,
            'subCategories' => $subCategories,
        ])->render();
    }

    public function shopCategorySort(Request $request, string $menu, string $category)
    {
        // Retrieve the active menu setup
        $menuSlug = MenuSetup::active()->where('slug', $menu)->firstOrFail();

        // Verify that the provided category slug belongs to this menu
        $categoryModel = $menuSlug->categories()
            ->active()
            ->where('slug', $category)
            ->firstOrFail();

        // Get sort parameter (default is "asc")
        $sort = $request->get('sort', 'asc');

        // Build the query for active products linked to this category
        $query = $categoryModel->products()->active()->with('categories');

        // Apply sorting using the query builder based on the sort parameter
        switch ($sort) {
            case 'desc':
                $query->orderBy('name', 'desc');
                break;
            case 'low-high':
                $query->orderBy('price', 'asc');
                break;
            case 'high-low':
                $query->orderBy('price', 'desc');
                break;
            case 'asc':
            default:
                $query->orderBy('name', 'asc');
                break;
        }

        $products = $query->get();

        // Retrieve active subcategories for the current category
        $subCategories = $categoryModel->sub_categories()
            ->active()
            ->orderBy('name', 'asc')
            ->get();

        // Render and return only the partial view containing the products markup
        return view('webpage.partials.shop-products', [
            'menuSlug'      => $menuSlug,
            'category'      => $categoryModel,
            'products'      => $products,
            'subCategories' => $subCategories,
        ])->render();
    }

    public function quickview(string $slug)
    {
        $product  = Product::with(['images', 'options', 'options.values', 'categories', 'sub_categories', 'tags'])->active()->where('slug', $slug)->firstOrFail();
        return view('webpage.quick-view', [
            'product' => $product,
        ]);
    }

    public function blog()
    {
        $posts = Post::active()->paginate(12);
        $breadcrumbs = array_merge($this->breadcrumbs, [
            ['label' => 'Blog'],
        ]);
        return response()->view('webpage.blog-page', [
            'categoriesSidebar' => $this->categoriesSidebar,
            'tagsSidebar' => $this->tagsSidebar,
            'recentPosts' => $this->recentPosts,
            'posts' => $posts,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    public function blogCategory(string $category)
    {
        $categories = PostCategory::active()->where('slug', $category)->firstOrFail();
        $posts = $categories->posts()->active()->paginate(12);
        $breadcrumbs = array_merge($this->breadcrumbs, [
            ['label' => 'Blog', 'url' => route('web.blog.index')],
            ['label' => $categories->name],
        ]);
        return response()->view('webpage.blog-page', [
            'categoriesSidebar' => $this->categoriesSidebar,
            'tagsSidebar' => $this->tagsSidebar,
            'recentPosts' => $this->recentPosts,
            'posts' => $posts,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    public function blogPost(string $category, string $post)
    {
        $posting = PostCategory::active()->where('slug', $category)->firstOrFail();
        $post = $posting->posts()->active()->where('slug', $post)->firstOrFail();
        $breadcrumbs = array_merge($this->breadcrumbs, [
            ['label' => 'Blog', 'url' => route('web.blog.index')],
            ['label' => $post->category?->name, 'url' => route('web.blog.category', $post->category?->slug)],
            ['label' => $post->title, 'url' => route('web.blog.post', [$post->category?->slug, $post->slug])],
        ]);
        return response()->view('webpage.blog-post', [
            'post' => $post,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    public function about()
    {
        $breadcrumbs = array_merge($this->breadcrumbs, [
            ['label' => 'About Us']
        ]);
        return view('webpage.about', [
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function privacyPolicy()
    {
        $breadcrumbs = array_merge($this->breadcrumbs, [
            ['label' => 'Privacy Policy']
        ]);
        return view('webpage.privacy-policy', [
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function termsConditions()
    {
        $breadcrumbs = array_merge($this->breadcrumbs, [
            ['label' => 'Terms And Condition']
        ]);
        return view('webpage.terms-and-conditions', [
            'breadcrumbs' => $breadcrumbs
        ]);
    }
}
