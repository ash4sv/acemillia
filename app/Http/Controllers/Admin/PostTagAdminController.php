<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\PostTagAdminDataTable;
use App\Http\Controllers\Controller;
use App\Models\Admin\Blog\PostTag;
use App\Services\ImageUploader;
use App\Services\SlugGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class PostTagAdminController extends Controller
{
    protected string $view = 'apps.admin.blog.tags.';

    /**
     * Display a listing of the resource.
     */
    public function index(PostTagAdminDataTable $dataTable)
    {
        $title = 'Delete Post Tag!';
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
            'postTag' => null
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->updateOrCreatePostTag($request);
        Alert::success('Successfully Create!', 'Post Tag has been created!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->view($this->view . 'show', [
            'postTag' => $this->findOrFailPostTag($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return response()->view($this->view . 'form', [
            'postTag' => $this->findOrFailPostTag($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->updateOrCreatePostTag($request, $id);
        Alert::success('Successfully Update!', 'Post Tag has been updated!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $postTag = $this->findOrFailPostTag($id);
        $postTag->delete();
        Alert::success('Successfully Deleted!', 'Post Tag has been deleted!');
        return redirect()->back();
    }

    /**
     * Fetch Post Category by ID or fail.
     */
    private function findOrFailPostTag(string $id): PostTag
    {
        return PostTag::findOrFail($id);
    }

    /**
     * Save or update a Post Category.
     */
    private function updateOrCreatePostTag(Request $request, string $id = null): PostTag
    {
        DB::beginTransaction();
        try {
            $data = $request->only([
                'name',
                'description',
                'image',
            ]);

            $data['slug'] = SlugGenerator::generateUniqueSlug($data['name'], PostTag::class, $id);

            if ($request->hasFile('image')) {
                $uploadedSingleImagePath = ImageUploader::uploadSingleImage(
                    $request->file('image'),
                    'assets/upload/',
                    'post_tag_image'
                );
                $data['image'] = $uploadedSingleImagePath;
            }

            $postTag = PostTag::updateOrCreate(
                ['id' => $id],
                array_merge($data, [
                    'status' => $request->input('publish', 'draft'),
                ])
            );

            DB::commit();
            return $postTag;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
