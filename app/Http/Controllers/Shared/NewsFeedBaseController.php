<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Models\Social\NewsFeed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsFeedBaseController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->newsFeeds = NewsFeed::active()->orderBy('created_at', 'desc')->get();
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
     * Retrieve a NewsFeed with its options or fail.
     */
    protected function findOrFailNewsFeed(string $id)
    {
        return NewsFeed::findOrFail($id);
    }

    /**
     * Save or update a NewsFeed.
     *
     * If a merchant is logged in, getMerchantId() should return the merchant's id.
     */
    protected function updateOrCreateNewsFeed(Request $request, string $id = null): NewsFeed
    {
        DB::beginTransaction();
        try {
            $actor = $this->getAuthenticatedActor();

            if (!$actor) {
                abort(403, 'Not authenticated.');
            }

            $data = $request->only([
                'newsfeed_text',
                'privacy'
            ]);

            $newsfeed = NewsFeed::updateOrCreate(
                ['id' => $id],
                array_merge($data, [
                    'text'   => $data['newsfeed_text'],
                    'status' => 'active',
                    'model_id'   => $actor->id,
                    'model_type' => get_class($actor),
                ])
            );

            DB::commit();
            return $newsfeed;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
