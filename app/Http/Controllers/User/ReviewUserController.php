<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Shop\Product;
use App\Models\Shop\Review;
use App\Models\Shop\ReviewReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class ReviewUserController extends Controller
{
    public function create(Product $product)
    {
        return view('apps.user.review.form', [
            'product' => $product,
        ]);
    }

    public function store(Request $request, Product $product)
    {
        $data = $request->validate([
            'rating' => 'required|numeric|min:0.5|max:5',
            'review' => 'nullable|string|max:2000',
            'visibility_type' => 'required|in:public,anonymous',
        ]);

        $data['product_id'] = $product->id;
        $data['user_id']    = auth()->guard('web')->id();

        $review = Review::create($data);

        Alert::success('Review Submitted!', 'Review submitted and pending approval.');
        return back();
    }

    public function storeReply(Request $request, Review $review)
    {
        $request->validate([
            'reply' => 'required|string|max:2000',
        ]);

        ReviewReply::create([
            'review_id' => $review->id,
            'user_id' => auth()->guard('web')->id(),
            'reply' => $request->reply,
            'reply_type' => \App\Enums\ReplyType::USER,
        ]);

        Alert::success('Reply Submitted!', 'Reply submitted successfully.');
        return back();
    }
}
