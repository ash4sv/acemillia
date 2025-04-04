<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Social\NewsFeedComment;
use Illuminate\Http\Request;

class NewsFeedCommentMerchantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $actor = auth()->guard('merchant')->user();

        $id = null;

        $data = $request->only([
            'newsfeed_id',
            'comment',
        ]);

        $newsfeedComment = NewsFeedComment::updateOrCreate(
            ['id' => $id],
            array_merge($data, [
                'model_id'   => $actor->id,
                'model_type' => get_class($actor),
            ])
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
        //
    }
}
