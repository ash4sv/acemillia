<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User\AddressBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class AddressUserController extends Controller
{
    protected string $view = 'apps.user.address-book.';
    protected $authUser;

    public function __construct()
    {
        $this->authUser = auth()->guard('web')->user();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->view($this->view . 'index', [
            'authUser' => $this->authUser
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
}
