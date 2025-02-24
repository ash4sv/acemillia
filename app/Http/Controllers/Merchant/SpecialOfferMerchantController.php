<?php

namespace App\Http\Controllers\Merchant;

use App\DataTables\Admin\SpecialOfferAdminDataTable;
use App\Http\Controllers\Controller;
use App\Models\Shop\Product;
use App\Models\Shop\SpecialOffer;
use App\Services\ImageUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class SpecialOfferMerchantController extends Controller
{
    protected string $view = 'apps.admin.shop.special-offer.';

    /**
     * Display a listing of the resource.
     */
    public function index(SpecialOfferAdminDataTable $dataTable)
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
        $products = $this->getActiveProducts(null);
        return view($this->view . 'form', [
            'specialOffer' => null,
            'products' => $products
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->updateOrCreateSpecialOffer($request);
        Alert::success('Successfully Create!', 'Special offer has been created!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view($this->view . 'show', [
            'specialOffer' => $this->findOrFailSpecialOffer($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $specialOffer = $this->findOrFailSpecialOffer($id);
        $products = $this->getActiveProducts($specialOffer->product_id);
        return view($this->view . 'form', [
            'specialOffer' => $specialOffer,
            'products' => $products
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->updateOrCreateSpecialOffer($request, $id);
        Alert::success('Successfully Update!', 'Special offer has been updated!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $specialOffer = $this->findOrFailSpecialOffer($id);
        $specialOffer->delete();
        Alert::success('Successfully Deleted!', 'Special offer has been deleted!');
        return redirect()->back();
    }


    /**
     * Fetch CarouselSlider by ID or fail.
     */
    private function findOrFailSpecialOffer(string $id): SpecialOffer
    {
        return SpecialOffer::findOrFail($id);
    }

    /**
     * Save or update a SpecialOffer.
     */
    private function updateOrCreateSpecialOffer(Request $request, string $id = null): SpecialOffer
    {
        DB::beginTransaction();
        try {
            // Validate and get basic input data
            $data = $request->only([
                'product_id', 'discount_type', 'discount_amount',
                'start_date', 'end_date', 'promotional_text'
            ]);

            // Handle single image upload if provided
            if ($request->hasFile('single_image')) {
                $uploadedSingleImagePath = ImageUploader::uploadSingleImage(
                    $request->file('single_image'),
                    'assets/upload/',
                    'value-images'
                );
                $data['single_image'] = $uploadedSingleImagePath;
            }

            // Handle multiple images upload if provided
            if ($request->hasFile('multiple_images')) {
                $multipleImagePaths = [];
                foreach ($request->file('multiple_images') as $image) {
                    $multipleImagePaths[] = ImageUploader::uploadSingleImage(
                        $image,
                        'assets/upload/',
                        'value-images'
                    );
                }
                $data['multiple_images'] = $multipleImagePaths;
            }

            // Set submission type to 'admin'
            $data['submission_type'] = 'admin';

            // Assign merchant_id based on logged-in context
            $data['merchant_id'] = auth()->guard('merchant')->check()
                ? auth()->guard('merchant')->id()
                : $request->input('merchant_id');

            $specialOffer = SpecialOffer::updateOrCreate(
                ['id' => $id],
                array_merge($data, [
                    'status_submission' => $request->input('submission', 'pending'),
                    'status' => $request->input('publish', 'draft'),
                ])
            );

            DB::commit();
            return $specialOffer;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Load current active products.
     *
     * For admin: Loads all active products.
     * For merchant: Loads only active products belonging to the logged-in merchant.
     *
     * Products are ordered alphabetically by name.
     */
    private function getActiveProducts($currentProductId = null)
    {
        // Get product IDs already used in special offers.
        $usedProductIdsQuery = SpecialOffer::query();
        if ($currentProductId) {
            // Exclude the current product ID from the used list.
            $usedProductIdsQuery->where('product_id', '<>', $currentProductId);
        }
        $usedProductIds = $usedProductIdsQuery->pluck('product_id')->toArray();

        // Base query: active products not already used.
        $query = Product::active()->whereNotIn('id', $usedProductIds);

        // Filter by merchant if logged in as merchant.
        if (auth()->guard('merchant')->check()) {
            $query->where('merchant_id', auth()->guard('merchant')->id());
        }

        return $query->orderBy('name')->get();
    }
}
