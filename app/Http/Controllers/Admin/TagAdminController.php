<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\TagAdminDataTable;
use App\Http\Controllers\Controller;
use App\Models\Shop\Tag;
use App\Services\ImageUploader;
use App\Services\SlugGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class TagAdminController extends Controller
{
    protected string $view = 'apps.admin.shop.tags.';

    /**
     * Display a listing of the resource.
     */
    public function index(TagAdminDataTable $dataTable)
    {
        $title = 'Delete Tag!';
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
            'tag' => null
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->updateOrCreateTag($request);
        Alert::success('Successfully Create!', 'Sub Category has been created!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view($this->view . 'show', [
            'tag' => $this->findOrFailTag($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view($this->view . 'form', [
            'tag' => $this->findOrFailTag($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->updateOrCreateTag($request, $id);
        Alert::success('Successfully Update!', 'Sub Category has been updated!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tag = $this->findOrFailTag($id);
        $tag->delete();
        Alert::success('Successfully Deleted!', 'Sub Category has been deleted!');
        return redirect()->back();
    }

    /**
     * Fetch Event by ID or fail.
     */
    private function findOrFailTag(string $id): Tag
    {
        return Tag::findOrFail($id);
    }

    /**
     * Save or update a customer.
     */
    private function updateOrCreateTag(Request $request, string $id = null): Tag
    {
        DB::beginTransaction();
        try {
            $data = $request->only([
                'name',
                'description',
                'image',
                'publish',
            ]);

            $tagData = $id !== null ? $this->findOrFailTag($id) : null;

            $imageFilePath = $request->file('image')
                ? ImageUploader::uploadSingleImage($request->file('image'), 'assets/upload/', 'tag_image')
                : ($tagData->image ?? null);

            $slugTag = SlugGenerator::generateUniqueSlug($data['name'], Tag::class, $id);

            $tag = Tag::updateOrCreate(
                ['id' => $id],
                [
                    'merchant_id' => null,
                    'name'        => $data['name'],
                    'slug'        => $slugTag,
                    'description' => $data['description'],
                    'icon'        => null,
                    'image'       => $imageFilePath,
                    'status'      => strtolower($data['publish']),
                ]
            );

            DB::commit();
            return $tag;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
