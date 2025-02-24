<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\CarouselSliderAdminDataTable;
use App\Http\Controllers\Controller;
use App\Models\Admin\CarouselSlider;
use App\Services\ImageUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class CarouselSliderAdminController extends Controller
{
    protected string $view = 'apps.admin.carousel-slider.';

    /**
     * Display a listing of the resource.
     */
    public function index(CarouselSliderAdminDataTable $dataTable)
    {
        $title = 'Delete Carousel Slider!';
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
            'carousel' => null,
            'routes' => $this->getWebRoutes(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->updateOrCreateCarouselSlider($request);
        Alert::success('Successfully Create!', 'Carousel slider has been created!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view($this->view . 'show', [
            'carousel' => $this->findOrFailCarouselSlider($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view($this->view . 'form', [
            'carousel' => $this->findOrFailCarouselSlider($id),
            'routes' => $this->getWebRoutes(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->updateOrCreateCarouselSlider($request, $id);
        Alert::success('Successfully Update!', 'Carousel slider has been updated!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = $this->findOrFailCarouselSlider($id);
        $category->delete();
        Alert::success('Successfully Deleted!', 'Carousel slider has been deleted!');
        return redirect()->back();
    }

    /**
     * Fetch CarouselSlider by ID or fail.
     */
    private function findOrFailCarouselSlider(string $id): CarouselSlider
    {
        return CarouselSlider::findOrFail($id);
    }

    /**
     * Save or update a CarouselSlider.
     */
    private function updateOrCreateCarouselSlider(Request $request, string $id = null): CarouselSlider
    {
        DB::beginTransaction();
        try {
            $data = $request->only([
                'image',
                'url',
                'publish',
            ]);

            $carouselSliderData = $id !== null ? $this->findOrFailCarouselSlider($id) : null;

            $imageFilePath = $request->file('image')
                ? ImageUploader::uploadSingleImage($request->file('image'), 'assets/upload/', 'carousel-slider')
                : ($carouselSliderData->image ?? null);

            $carouselSlider = CarouselSlider::updateOrCreate(
                ['id' => $id],
                [
                    'image' => $imageFilePath,
                    'url' => $data['url'],
                    'status' => strtolower($data['publish']),
                ]
            );

            DB::commit();
            return $carouselSlider;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Retrieve registered routes whose names start with "web."
     *
     * @return array
     */
    protected function getWebRoutes()
    {
        return collect(Route::getRoutes())->filter(function ($route) {
            return $route->getName() && Str::startsWith($route->getName(), 'web.');
        })->map(function ($route) {
            $name = $route->getName();
            $uri = $route->uri();
            $parameters = $route->parameterNames();

            // For routes without parameters, generate a full URL using the route helper.
            if (empty($parameters)) {
                $url = route($name);
            } else {
                // For routes with parameters, we generate the URL based on the URI pattern.
                // This will include the placeholder (e.g. {menu}) as-is.
                $url = url($uri);
            }

            return [
                'name' => $name,
                'url'  => $url,
            ];
        })->toArray();
    }
}
