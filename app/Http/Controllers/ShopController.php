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
        $products = $this->filter();
        $categories = Cache::remember('categories', now()->addMinutes(10), function () {
            return Category::all();
        });
        $subCategories = Cache::remember('subCategories', now()->addMinutes(10), function () {
            return SubCategory::all();
        });
        $sizes = Cache::remember('sizes', now()->addMinutes(10), function () {
            return Size::all();
        });
        $colors = Cache::remember('colors', now()->addMinutes(10), function () {
            return Color::all();
        });
        // $categories = Category::all();
        // $subCategories = SubCategory::all();
        // $sizes = Size::all();
        // $colors = Color::all();
        return view('frontend.shop.index', compact('products', 'categories', 'sizes', 'subCategories', 'colors'));
    }

    public function show($id)
    {
        $response = Http::get("$this->api_url/getProduct" , ['product_id' => $id]);
        if($response->successful())
        {
            $data = json_decode($response->getBody()->getContents());

            $response = Http::get("$this->api_url/getRelatedProduct" , ['product_id' => $id]);
            if($response->successful())
            {
                $relatedProducts = json_decode($response->getBody()->getContents());
            }
            else
                $relatedProducts = [];

            $product = $data->product;
            $reviews = $data->reviews;
            // * Filter data

            $getSizes = function() use ($product){
                $tempSizes = [];
                foreach($product->attributes as $attribute)
                {
                    dd($attribute);
                    $isExist = false;
                    foreach($tempSizes as $size)
                    {
                        if($size->size_id === $attribute->size_id)
                        {
                            $isExist = true;
                            break;
                        }
                    }
                    if(!$isExist)
                        $tempSizes[] = $attribute;
                }
                return $tempSizes;
            };
            $sizes = [];
            $colors = [];
            $this->filterAttributes($sizes,$colors,$product);




            // $sizes = $data->sizes;
            // $colors = $data->colors;
            return view('frontend.shop.show', compact('product', 'relatedProducts', 'reviews', 'sizes', 'colors'));
        }
        return redirect('home')->with('error','Something went wrong...');

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


    private function filterAttributes(&$sizes,&$colors,$product)
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
