<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\PostAdminDataTable;
use App\Http\Controllers\Controller;
use App\Models\Admin\Blog\Post;
use App\Models\Admin\Blog\PostCategory;
use App\Models\Admin\Blog\PostTag;
use App\Services\ImageUploader;
use App\Services\SlugGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class PostAdminController extends Controller
{
    protected string $view = 'apps.admin.blog.posts.';
    protected $postCategories, $postTags;

    public function __construct()
    {
        $this->postCategories = PostCategory::active()->get();
        $this->postTags = PostTag::active()->get();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(PostAdminDataTable $dataTable)
    {
        $title = 'Delete Post!';
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
            'post' => null,
            'categories' => $this->postCategories,
            'tags' => $this->postTags
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->updateOrCreatePost($request);
        Alert::success('Successfully Create!', 'Post has been created!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->view($this->view . 'show', [
            'post' => $this->findOrFailPost($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return response()->view($this->view . 'form', [
            'post' => $this->findOrFailPost($id),
            'categories' => $this->postCategories,
            'tags' => $this->postTags
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->updateOrCreatePost($request, $id);
        Alert::success('Successfully Update!', 'Post has been updated!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = $this->findOrFailPost($id);
        Alert::success('Successfully Deleted!', 'Post has been deleted!');
        return redirect()->back();
    }

    /**
     * Fetch Post Category by ID or fail.
     */
    private function findOrFailPost(string $id): Post
    {
        return Post::findOrFail($id);
    }

    /**
     * Save or update a Post Category.
     */
    private function updateOrCreatePost(Request $request, string $id = null): Post
    {
        DB::beginTransaction();
        try {
            $data = $request->only([
                'category',
                'title',
                'body',
                'banner',
            ]);

            $data['slug'] = SlugGenerator::generateUniqueSlug($data['title'], Post::class, $id);

            if ($request->hasFile('banner')) {
                $uploadedSingleImagePath = ImageUploader::uploadSingleImage(
                    $request->file('banner'),
                    'assets/upload/',
                    'post_banner_image'
                );
                $data['banner'] = $uploadedSingleImagePath;
            }

            // Assign merchant_id based on logged-in context
            $data['admin_id'] = auth()->guard('admin')->check()
                ? auth()->guard('admin')->id()
                : $request->input('admin_id');

            $post = Post::updateOrCreate(
                ['id' => $id],
                array_merge($data, [
                    'post_category_id' => $data['category'],
                    'status' => $request->input('publish', 'draft'),
                ])
            );

            $post->tags()->sync($request->input('tags', []));

            DB::commit();
            return $post;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
