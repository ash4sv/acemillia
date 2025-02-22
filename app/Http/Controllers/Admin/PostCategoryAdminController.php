<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\PostCategoryAdminDataTable;
use App\Http\Controllers\Controller;
use App\Models\Admin\Blog\PostCategory;
use App\Services\ImageUploader;
use App\Services\SlugGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class PostCategoryAdminController extends Controller
{
    protected string $view = 'apps.admin.blog.categories.';

    /**
     * Display a listing of the resource.
     */
    public function index(PostCategoryAdminDataTable $dataTable)
    {
        $title = 'Delete Post Category!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return $dataTable->render($this->view . 'index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->view($this->view . 'form', [
            'postCategory' => null
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->updateOrCreatePostCategory($request);
        Alert::success('Successfully Create!', 'Post Category has been created!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->view($this->view . 'show', [
            'postCategory' => $this->findOrFailPostCategory($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return response()->view($this->view . 'form', [
            'postCategory' => $this->findOrFailPostCategory($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->updateOrCreatePostCategory($request, $id);
        Alert::success('Successfully Update!', 'Post Category has been updated!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $postCategory = $this->findOrFailPostCategory($id);
        $postCategory->delete();
        Alert::success('Successfully Deleted!', 'Post Category has been deleted!');
        return redirect()->back();
    }

    /**
     * Fetch Post Category by ID or fail.
     */
    private function findOrFailPostCategory(string $id): PostCategory
    {
        return PostCategory::findOrFail($id);
    }

    /**
     * Save or update a Post Category.
     */
    private function updateOrCreatePostCategory(Request $request, string $id = null): PostCategory
    {
        DB::beginTransaction();
        try {
            $data = $request->only([
                'name',
                'description',
                'image',
            ]);

            $data['slug'] = SlugGenerator::generateUniqueSlug($data['name'], PostCategory::class, $id);

            if ($request->hasFile('image')) {
                $uploadedSingleImagePath = ImageUploader::uploadSingleImage(
                    $request->file('image'),
                    'assets/upload/',
                    'post_category_image'
                );
                $data['image'] = $uploadedSingleImagePath;
            }

            $postCategory = PostCategory::updateOrCreate(
                ['id' => $id],
                array_merge($data, [
                    'status' => $request->input('publish', 'draft'),
                ])
            );

            DB::commit();
            return $postCategory;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
