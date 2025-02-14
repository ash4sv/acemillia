<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\SubCategoryAdminDataTable;
use App\Http\Controllers\Controller;
use App\Models\Shop\SubCategory;
use App\Services\ImageUploader;
use App\Services\SlugGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class SubCategoryAdminController extends Controller
{
    protected string $view = 'apps.admin.shop.sub-categories.';

    /**
     * Display a listing of the resource.
     */
    public function index(SubCategoryAdminDataTable $dataTable)
    {
        $title = 'Delete Sub Category!';
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
            'subCategory' => null
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->updateOrCreateSubCategory($request);
        Alert::success('Successfully Create!', 'Sub Category has been created!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view($this->view . 'show', [
            'subCategory' => $this->findOrFailSubCategory($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view($this->view . 'form', [
            'subCategory' => $this->findOrFailSubCategory($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->updateOrCreateSubCategory($request, $id);
        Alert::success('Successfully Update!', 'Sub Category has been updated!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subCategory = $this->findOrFailSubCategory($id);
        $subCategory->delete();
        Alert::success('Successfully Deleted!', 'Sub Category has been deleted!');
        return redirect()->back();
    }

    /**
     * Fetch Event by ID or fail.
     */
    private function findOrFailSubCategory(string $id): SubCategory
    {
        return SubCategory::findOrFail($id);
    }

    /**
     * Save or update a customer.
     */
    private function updateOrCreateSubCategory(Request $request, string $id = null): SubCategory
    {
        DB::beginTransaction();
        try {
            $data = $request->only([
                'name',
                'description',
                'image',
                'publish',
            ]);

            $subCategoryData = $id !== null ? $this->findOrFailSubCategory($id) : null;

            $imageFilePath = $request->file('image')
                ? ImageUploader::uploadSingleImage($request->file('image'), 'assets/upload/', 'sub_category_image')
                : ($subCategoryData->image ?? null);

            $slugSubCategory = SlugGenerator::generateUniqueSlug($data['name'], SubCategory::class, $id);

            $subCategory = SubCategory::updateOrCreate(
                ['id' => $id],
                [
                    'merchant_id' => null,
                    'name'        => $data['name'],
                    'slug'        => $slugSubCategory,
                    'description' => $data['description'],
                    'icon'        => null,
                    'image'       => $imageFilePath,
                    'status'      => strtolower($data['publish']),
                ]
            );

            DB::commit();
            return $subCategory;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
