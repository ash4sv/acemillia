<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User\Compare;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CompareUserController extends Controller
{
    public function __construct()
    {
        if (auth()->guard('web')->check() && ! session()->pull('_compare_migrated')) {
            Compare::migrate();
            session()->put('_compare_migrated', true); // run only once per session
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('apps.user.purchase.compare', [
            'products' => Compare::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $added = Compare::add((int) $request->product_id);

        if ($added) {
            $message = 'Product added to compare.';
            $type = 'success';
        } else {
            switch (Compare::error()) {
                case Compare::ERR_DUPLICATE:
                    $message = 'Product is already in your compare list.';
                    break;
                case Compare::ERR_LIMIT_REACHED:
                    $message = 'You can only compare up to ' . Compare::MAX_ITEMS . ' products.';
                    break;
                case Compare::ERR_CATEGORY_MISMATCH:
                    $message = 'Products must belong to the same category to be compared.';
                    break;
                default:
                    $message = 'Unable to add product to compare.';
            }
            $type = 'warning';
        }

        // If AJAX request, return JSON response
        if ($request->ajax()) {
            return response()->json([
                'type' => $type,
                'message' => $message,
            ]);
        }

        return back()->with(
            $added ? 'status' : 'warning',
            $message
        );
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Compare::remove((int) $id);
        Alert::success('Successfully Deleted!', 'Product removed from compare!');
        return back();
    }
}
