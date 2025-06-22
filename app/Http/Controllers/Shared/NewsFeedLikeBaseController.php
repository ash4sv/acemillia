<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Models\Social\NewsFeed;
use App\Models\Social\NewsFeedLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsFeedLikeBaseController extends Controller
{
    public function __construct()
    {

    }

    /**
     * Retrieve the currently authenticated actor.
     * Checks for Admin, then Merchant, then User.
     *
     * @return mixed
     */
    protected function getAuthenticatedActor()
    {
        // Check for admin guard first
        if ($actor = auth()->guard('admin')->user()) {
            return $actor;
        }
        // Then check for merchant guard
        if ($actor = auth()->guard('merchant')->user()) {
            return $actor;
        }
        // Finally, check the default web guard (User)
        return auth()->user();
    }

    /**
     * Retrieve a NewsFeedCommend with its options or fail.
     */
    protected function findOrFailNewsFeedLike(string $id)
    {
        return NewsFeedLike::findOrFail($id);
    }

    /**
     * Save or update a NewsFeedLike.
     *
     * If a merchant is logged in, getMerchantId() should return the merchant's id.
     */
    protected function updateOrCreateNewsFeedLike(Request $request, string $id = null): NewsFeedLike
    {
        DB::beginTransaction();
        try {
            $actor = $this->getAuthenticatedActor();

            if (!$actor) {
                abort(403, 'Not authenticated.');
            }

            $validate = $request->validate([
                'newsfeed_id' => 'required|exists:news_feeds,id'
            ]);

            $newsfeed = NewsFeed::findOrFail($validate['newsfeed_id']);

            $like = NewsFeedLike::where('newsfeed_id', $newsfeed->id)
                        ->where('model_id', $actor->id)
                        ->where('model_type', get_class($actor))
                        ->first();

            if ($like) {
                $like->delete();
                $liked = false;
            } else {
                NewsFeedLike::create([
                    'newsfeed_id' => $newsfeed->id,
                    'model_id'    => $actor->id,
                    'model_type'  => get_class($actor),
                ]);
                $liked = true;
            }

            DB::commit();
            return $like;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
