<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Models\Social\NewsFeedComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsFeedCommentBaseController extends Controller
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
    protected function findOrFailNewsFeedComment(string $id)
    {
        return NewsFeedComment::findOrFail($id);
    }

    /**
     * Save or update a NewsFeedComment.
     *
     * If a merchant is logged in, getMerchantId() should return the merchant's id.
     */
    protected function updateOrCreateNewsFeedComment(Request $request, string $id = null): NewsFeedComment
    {
        DB::beginTransaction();
        try {
            $actor = $this->getAuthenticatedActor();

            if (!$actor) {
                abort(403, 'Not authenticated.');
            }

            $validate = $request->validate([
                'newsfeed_id' => 'required|exists:newsfeeds,id',
                'comment'     => 'required|string'
            ]);

            $data = [
                'newsfeed_id' => $validate['newsfeed_id'],
                'comment'     => $validate['comment'],
                'model_id'    => $actor->id,
                'model_type'  => get_class($actor),
            ];

            if ($request->filled('parent_id')) {
                $data['parent_id'] = $request->parent_id;
            }

            $comment = NewsFeedComment::create($data);

            DB::commit();
            return $comment;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
