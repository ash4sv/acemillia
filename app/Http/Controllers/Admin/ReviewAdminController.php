<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\ReviewAdminDataTable;
use App\Http\Controllers\Controller;
use App\Models\Shop\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class ReviewAdminController extends Controller
{
    protected string $view = 'apps.admin.shop.review.';

    /**
     * Display a listing of the resource.
     */
    public function index(ReviewAdminDataTable $dataTable)
    {
        $title = 'Delete Review!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return $dataTable->render('apps.admin.shop.review.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view($this->view . 'form', [
            'review' => null
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->updateOrCreateReview($request);
        Alert::success('Successfully Create!', 'Review has been created!');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view($this->view . 'show', [
            'review' => $this->findOrFailReview($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view($this->view . 'form', [
            'review' => $this->findOrFailReview($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->updateOrCreateReview($request, $id);
        Alert::success('Successfully Update!', 'Review has been updated!');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $reivew = $this->findOrFailReview($id);
        $reivew->delete();
        Alert::success('Successfully Deleted!', 'Review has been deleted!');
        return back();
    }

    /**
     * Fetch Review by ID or fail.
     */
    private function findOrFailReview(string $id): Review
    {
        return Review::findOrFail($id);
    }

    /**
     * Save or update a Review.
     */
    private function updateOrCreateReview(Request $request, string $id = null): Review
    {
        DB::beginTransaction();
        try {
            $data = $request->only([
                'approval_status',
            ]);

            $review = Review::updateOrCreate(
                ['id' => $id],
                $data
            );

            DB::commit();
            return $review;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
