<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\WidgetAdminDataTable;
use App\Http\Controllers\Controller;
use App\Models\Admin\Widget;
use App\Services\ImageUploader;
use App\Services\ModelResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class WidgetAdminController extends Controller
{
    protected string $view = 'apps.admin.widget.';
    protected string $title = 'Widget';
    protected array $widgetSizes;

    public function __construct()
    {
        parent::__construct();
        $this->widgetSizes = [
            [
                'name' => 'Landscape',
                'data' => '610, 407'
            ],
            [
                'name' => 'Landscape',
                'data' => '670, 306'
            ],
            [
                'name' => 'Portrait',
                'data' => '320, 820'
            ],
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(WidgetAdminDataTable $dataTable)
    {
        $title = 'Delete ' . $this->title . '!';
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
            'widget' => null,
            'widgetSizes' => $this->widgetSizes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->updateOrCreateWidget($request);
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
            'widget' => $this->findOrFailWidget($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view($this->view . 'form', [
            'widget' => $this->findOrFailWidget($id),
            'widgetSizes' => $this->widgetSizes
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->updateOrCreateWidget($request, $id);
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
        $widget = $this->findOrFailWidget($id);
        $widget->delete();
        Alert::success('Successfully Deleted!', $this->title . 'slider has been deleted!');
        return back();
    }

    /**
     * Fetch CarouselSlider by ID or fail.
     */
    private function findOrFailWidget(string $id): Widget
    {
        return Widget::findOrFail($id);
    }

    /**
     * Save or update a CarouselSlider.
     */
    private function updateOrCreateWidget(Request $request, string $id = null): Widget
    {
        DB::beginTransaction();
        try {
            $data = $request->only([
                'name',
                'url',
                'start_at',
                'end_at',
                'size'
            ]);

            $size = $request->input('size');
            $dimensions = array_map('trim', explode(',', $size));

            $widgetData = $id !== null ? $this->findOrFailWidget($id) : null;

            $data['image'] = $request->file('image')
                ? ImageUploader::uploadSingleImage($request->file('image'), 'assets/upload/', 'widget-image', $dimensions)
                : ($widgetData->image ?? null);

            $widget = Widget::updateOrCreate(
                ['id' => $id],
                $data
            );

            DB::commit();
            return $widget;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
