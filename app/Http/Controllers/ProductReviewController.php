<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\ReviewImage;
use App\Http\Requests\ReviewRequest;
use App\Services\HttpService;
use Illuminate\Support\Facades\Cookie;

class ProductReviewController extends Controller
{
    public function __invoke(ReviewRequest $request, $product_id)
    {
        $data = $request->all();
        $headers = ['access_token'  => Cookie::get('access_token')];
        if($request->hasFile('images'))
        {
            $options = [
                'multipart' => [
                  [
                    'name' => 'product_id',
                    'contents' => $data['product_id']
                  ],
                  [
                    'name' => 'user_id',
                    'contents' => $data['user_id']
                  ],
                  [
                    'name' => 'rating',
                    'contents' => $data['rating']
                  ],
                  [
                    'name' => 'body',
                    'contents' => $data['body']
                  ],
                ]
            ];
            foreach( $data['images'] as $key => $value)
            {
                $options['multipart'][] = [
                    'name' => 'images[]',
                    'contents' => file_get_contents($request->file('images')[$key]->getRealPath(), 'r'),
                    'filename' => $request->file('images')[$key]->getClientOriginalName(),
                    'headers'  => [
                    'Content-Type' => '<Content-type header>'
                    ]
                ];
            }
            $response = HttpService()->postDataWithOptions('reviews', $options, $headers);
        }
        else
            $response = HttpService()->postDataWithBody('reviews', $data, $headers);

        if( ($response->status ?? 200) == 402)
            return back()->with('errors', $response->errors);

        return back()->with('success', 'Operation successful');
        // $review = Review::updateOrCreate(
        //     ['product_id' => $request->product_id, 'user_id' => $request->user_id],
        //     $request->validated()
        // );
        // ReviewImage::deleteItem($review);
        // ReviewImage::storeItem($review, request('images', []));
        // session()->put('success', 'Operation successful');
        // return redirect()->route('product-details', ['product' => $request->product_id]);
    }
}
