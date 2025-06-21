<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\MenuAdminDataTable;
use App\Http\Controllers\Controller;
use App\Models\Admin\MenuSetup;
use App\Services\ImageUploader;
use App\Services\ModelResponse;
use App\Services\SlugGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class MenuAdminController extends Controller
{
    protected string $view = 'apps.admin.menus.';
    protected string $title = 'Menu';

    /**
     * Display a listing of the resource.
     */
    public function index(MenuAdminDataTable $dataTable)
    {
        $title = 'Delete Category!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return $dataTable->render($this->view .'index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view($this->view . 'form', [
            'menu' => null
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->updateOrCreateMenu($request);
        return ModelResponse::make()
            ->title('Successfully Created!')
            ->message($this->title . ' has been successfully created!')
            ->type('success')
            ->close();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view($this->view . 'show', [
            'menu' => $this->findOrFailMenu($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view($this->view . 'form', [
            'menu' => $this->findOrFailMenu($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->updateOrCreateMenu($request, $id);
        return ModelResponse::make()
            ->title('Successfully Updated!')
            ->message($this->title . ' has been successfully updated.')
            ->type('success')
            ->close();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = $this->findOrFailMenu($id);
        $category->delete();
        Alert::success('Successfully Deleted!', 'Menu has been deleted!');
        return back();
    }

    /**
     * Fetch Event by ID or fail.
     */
    private function findOrFailMenu(string $id): MenuSetup
    {
        return MenuSetup::findOrFail($id);
    }

    /**
     * Save or update a customer.
     */
    private function updateOrCreateMenu(Request $request, string $id = null): MenuSetup
    {
        DB::beginTransaction();
        try {
            $data = $request->only([
                'name',
                'publish',
            ]);

            $slugMenu = SlugGenerator::generateUniqueSlug($data['name'], MenuSetup::class, $id);

            $menu = MenuSetup::updateOrCreate(
                ['id' => $id],
                [
                    'name'   => $data['name'],
                    'slug'   => $slugMenu,
                    'status' => strtolower($data['publish']),
                ]
            );

            DB::commit();
            return $menu;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
