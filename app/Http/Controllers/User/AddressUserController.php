<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User\AddressBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class AddressUserController extends Controller
{
    protected string $view = 'apps.user.address-book.';
    protected $authUser;

    public function __construct()
    {
        parent::__construct();
        $this->authUser = auth()->guard('web')->user();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = array_merge($this->breadcrumbs, [
            ['label' => 'My Account', 'url' => route('dashboard')],
            ['label' => 'Saved Address'],
        ]);

        return response()->view($this->view . 'index', [
            'authUser' => $this->authUser,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->view($this->view . 'form', [
            'addressBook' => null
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->updateOrCreateAddressBook($request);
        Alert::success('Successfully Create!', 'Menu has been created!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return response()->view($this->view . 'form', [
            'addressBook' => $this->findOrFailAddressBook($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->updateOrCreateAddressBook($request, $id);
        Alert::success('Successfully Update!', 'Menu has been updated!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $addressBook = $this->findOrFailAddressBook($id);
        $addressBook->delete();
        Alert::success('Successfully Deleted!', 'Menu has been deleted!');
        return redirect()->back();

    }

    /**
     * Fetch CarouselSlider by ID or fail.
     */
    private function findOrFailAddressBook(string $id): AddressBook
    {
        return AddressBook::findOrFail($id);
    }

    /**
     * Save or update a CarouselSlider.
     */
    private function updateOrCreateAddressBook(Request $request, string $id = null): AddressBook
    {
        DB::beginTransaction();
        try {
            $data = $request->only([
                'title',
                'address',
                'phone',
                'country',
                'state',
                'city',
                'recipient_name',
                'street_address',
                'postcode',
            ]);

            $addressBook = auth()->guard('web')->user()->addressBooks()->updateOrCreate(
                ['id' => $id],
                $data
            );

            DB::commit();
            return $addressBook;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Load and cache the states CSV data.
     *
     * @return array
     */
    protected function loadStatesData()
    {
        return Cache::remember('malaysia_states', now()->addHours(1), function () {
            $path = public_path('assets/data/malaysia-postcode-states.csv');
            $states = [];
            if (($handle = fopen($path, 'r')) !== false) {
                // Each row: [state value, state name]
                while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                    $states[] = [
                        'value' => trim($data[0]),
                        'name'  => trim($data[1]),
                    ];
                }
                fclose($handle);
            }
            return $states;
        });
    }

    /**
     * Load and cache the postcodes CSV data.
     *
     * @return array
     */
    protected function loadPostcodesData()
    {
        return Cache::remember('malaysia_postcodes', now()->addHours(1), function () {
            $path = public_path('assets/data/malaysia-postcode-postcodes.csv');
            $postcodes = [];
            if (($handle = fopen($path, 'r')) !== false) {
                // Each row: [postcode, street, city, state]
                while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                    $postcodes[] = [
                        'postcode' => trim($data[0]),
                        'street'   => trim($data[1]),
                        'city'     => trim($data[2]),
                        'state'    => trim($data[3]),
                    ];
                }
                fclose($handle);
            }
            return $postcodes;
        });
    }

    public function getCountries()
    {
        $countries = \Illuminate\Support\Facades\Cache::remember('countries_data', now()->addHours(1), function () {
            $path = public_path('assets/data/countries.json');
            if (file_exists($path)) {
                $json = file_get_contents($path);
                return json_decode($json, true);
            }
            return [];
        });
        return response()->json($countries);
    }

    /**
     * Endpoint: GET /api/states
     * Returns a list of states.
     */
    public function getStates()
    {
        $states = $this->loadStatesData();
        return response()->json($states);
    }

    /**
     * Endpoint: GET /api/cities?state=STATE_VALUE
     * Returns distinct cities for a given state.
     */
    public function getCities(Request $request)
    {
        $state = $request->input('state');
        $data = $this->loadPostcodesData();
        $cities = [];

        foreach ($data as $row) {
            if ($row['state'] === $state) {
                $cities[$row['city']] = $row['city'];
            }
        }
        // Return cities as an array of objects
        $cities = array_map(function ($city) {
            return ['name' => $city, 'value' => $city];
        }, array_values($cities));

        return response()->json(array_values($cities));
    }

    /**
     * Endpoint: GET /api/streets?state=STATE_VALUE&city=CITY_VALUE
     * Returns distinct streets for a given state and city.
     */
    public function getStreets(Request $request)
    {
        $state = $request->input('state');
        $city  = $request->input('city');
        $data  = $this->loadPostcodesData();
        $streets = [];

        foreach ($data as $row) {
            if ($row['state'] === $state && $row['city'] === $city) {
                $streets[$row['street']] = $row['street'];
            }
        }
        $streets = array_map(function ($street) {
            return ['name' => $street, 'value' => $street];
        }, array_values($streets));

        return response()->json(array_values($streets));
    }

    /**
     * Endpoint: GET /api/postcodes?state=STATE_VALUE&city=CITY_VALUE&street=STREET_VALUE
     * Returns postcodes for a given state, city, and street.
     */
    public function getPostcodes(Request $request)
    {
        $state  = $request->input('state');
        $city   = $request->input('city');
        $street = $request->input('street');
        $data   = $this->loadPostcodesData();
        $postcodes = [];

        foreach ($data as $row) {
            if ($row['state'] === $state && $row['city'] === $city && $row['street'] === $street) {
                $postcodes[$row['postcode']] = $row['postcode'];
            }
        }
        $postcodes = array_map(function ($pc) {
            return ['name' => $pc, 'value' => $pc];
        }, array_values($postcodes));

        return response()->json(array_values($postcodes));
    }
}
