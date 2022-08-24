<?php

namespace App\Http\Controllers;

use App\Models\Size;
use App\Models\Color;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ViewedProduct;
use App\Services\ShopService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ShopController extends Controller
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }


    public function index()
    {
        $products = getData()->getDataWithParam('filter', request()->all());
        $products = collect($products);
        $categories = getData()->getDataWithParam('categories',['limit' => 3 ,'parent' => 1])->categories;
        $subCategories = getData()->getDataWithParam('categories',['parent' => 0, 'limit' => 'all'])->categories;
        $sizes = getData()->getDataFromType('sizes')->sizes;
        $colors = getData()->getDataFromType('colors')->colors;

        return view('frontend.shop.index', compact('products', 'categories', 'sizes', 'subCategories', 'colors'));
    }

    public function show($id)
    {
        $user_id = session('user','')->id ?? 0;
        $response = Http::withHeaders(['user_id' => $user_id])->get("$this->api_url/getProduct" , ['product_id' => $id]);
        if($response->successful())
        {
            $data = $this->respondToData($response);
            $response = Http::get("$this->api_url/getRelatedProduct" , ['product_id' => $id]);
            if($response->successful())
            {
                $relatedProducts = $this->respondToData($response);
            }
            else
            {
                $relatedProducts = [];
            }

            $product = $data->product;
            $reviews = $data->product->reviews;
            $recentViewProducts = collect($data->recentView);

            $sizes = [];
            $colors = [];
            $this->filterAttributes($sizes,$colors,$product);

            return view('frontend.shop.show', compact('product','recentViewProducts', 'relatedProducts', 'reviews', 'sizes', 'colors'));
        }
        return error();

        // //thêm vào sản phẩm đã xem cho user đã đăng nhâp
        // ViewedProduct::view($product);

        // //xứ lý problems n + 1
        // $product->load(['attributes.images', 'reviews.images']);

        // //$relatedProducts = $product->related;
        // $reviews = $product->reviews()->paginate(10);

        // //các sizes được lấy phải là duy nhất, tránh lỗi hiện thị các size trùng nhau
        // $sizes = $product->attributes->unique('size_id');

        // //lấy colors có quan hệ với thằng product và thằng sizes[0]
        // //chọn thằng sizes[0] vì size[0] được chọn mặc định (dùng nó để lọc bớt các color được hiển thị)
        // //các colors được lấy phải là duy nhất, tránh lỗi hiện thị các color trùng nhau
        // $colors = $product->attributes()->where('size_id', $sizes[0]->size_id)->get()->unique('color_id');
    }

    //dùng để lọc sản phẩm theo category, giá,...
    public function filter()
    {
        $products = Product::query()->active();
        $shopService = new ShopService($products);
        return $shopService->filter();
    }


    private function filterAttributes(&$sizes,&$colors,$product) // Loc attributes
    {
            $tempSizes  = [];
            $tempColors = [];
            foreach($product->attributes as $attribute)
            {
                $isSizeExist = false;
                $isColorExist = false;

                foreach($tempSizes as $size)
                {
                    if($size->size_id === $attribute->size_id)
                    {
                        $isSizeExist = true;
                        break;
                    }
                }
                if(!$isSizeExist)
                    $tempSizes[] = $attribute;
                //  Filter color
                foreach($tempColors as $color)
                {
                    if($color->color_id === $attribute->color_id)
                    {
                        $isColorExist = true;
                        break;
                    }
                }
                if(!$isColorExist)
                    $tempColors[] = $attribute;
            }
        $sizes = $tempSizes;
        $colors = $tempColors;
    }
}
