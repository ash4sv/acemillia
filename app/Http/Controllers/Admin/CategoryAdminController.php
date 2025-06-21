<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\CategoryAdminDataTable;
use App\Http\Controllers\Controller;
use App\Models\Admin\MenuSetup;
use App\Models\Shop\Category;
use App\Services\ImageUploader;
use App\Services\ModelResponse;
use App\Services\SlugGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryAdminController extends Controller
{
    protected string $view = 'apps.admin.shop.categories.';

    public function __construct()
    {
        $this->menus = MenuSetup::active()->get();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(CategoryAdminDataTable $dataTable)
    {
        $title = 'Delete Category!';
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
            'menus' => $this->menus,
            'category' => null
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->updateOrCreateCategory($request);
        return ModelResponse::make()
            ->title('Successfully Created!')
            ->message('Category has been successfully created!')
            ->type('success')
            ->close();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view($this->view . 'show', [
            'category' => $this->findOrFailCategory($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view($this->view . 'form', [
            'menus' => $this->menus,
            'category' => $this->findOrFailCategory($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->updateOrCreateCategory($request, $id);
        return ModelResponse::make()
            ->title('Successfully Updated!')
            ->message('Category has been successfully updated.')
            ->type('success')
            ->close();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = $this->findOrFailCategory($id);
        $category->delete();
        Alert::success('Successfully Deleted!', 'Category has been deleted!');
        return back();
    }

    /**
     * Fetch Event by ID or fail.
     */
    private function findOrFailCategory(string $id): Category
    {
        return Category::findOrFail($id);
    }

    /**
     * Save or update a customer.
     */
    private function updateOrCreateCategory(Request $request, string $id = null): Category
    {
        DB::beginTransaction();
        try {
            $data = $request->only([
                'menu',
                'name',
                'description',
                'image',
                'publish',
            ]);

            $categoryData = $id !== null ? $this->findOrFailCategory($id) : null;

            $imageFilePath = $request->file('image')
                ? ImageUploader::uploadSingleImage($request->file('image'), 'assets/upload/', 'category_image')
                : ($categoryData->image ?? null);

            $slugCategory = SlugGenerator::generateUniqueSlug($data['name'], Category::class, $id);

            $category = Category::updateOrCreate(
                ['id' => $id],
                [
                    'merchant_id' => null,
                    'name'        => $data['name'],
                    'slug'        => $slugCategory,
                    'description' => $data['description'],
                    'icon'        => null,
                    'image'       => $imageFilePath,
                    'status'      => strtolower($data['publish']),
                ]
            );

            if ($request->has('menu')) {
                $menus = $request->input('menu');
                $category->menus()->sync($menus ? [$menus] : []);
            }

            DB::commit();
            return $category;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
