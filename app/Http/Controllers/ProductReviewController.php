<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\ReviewImage;
use App\Http\Requests\ReviewRequest;

class ProductReviewController extends Controller
{
    public function __invoke(ReviewRequest $request, Review $review)
    {
        $review = Review::updateOrCreate(
            ['product_id' => $request->product_id, 'user_id' => $request->user_id],
            $request->validated()
        );
        ReviewImage::deleteItem($review);
        ReviewImage::storeItem($review, request('images', []));
        session()->put('success', 'Operation successful');
        return redirect()->route('product-details', ['product' => $request->product_id]);
    }
}
