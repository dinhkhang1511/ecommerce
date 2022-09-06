<?php

namespace App\Http\Controllers;

use App\Models\Size;
use App\Models\Color;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\ProductImage;
use App\Services\ImageServices;
use App\Models\ProductAttribute;
use App\Http\Requests\ProductStoreRequest;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class ProductController extends Controller
{
    public function index()
    {
        // $products = Product::latest()->paginate(10);
        $data = GetData()->getDataWithParam('products',request()->all());
        $products = $data->products;
        return view('backend.product.index', compact('products','data'));
    }

    public function create()
    {
        $categories = GetData()->getDataWithParam('categories', ['limit' => 'all'])->categories;
        $sizes = GetData()->getDataWithParam('sizes', ['limit' => 'all'])->sizes;
        $colors = GetData()->getDataWithParam('colors', ['limit' => 'all'])->colors;
        // $subCategories = SubCategory::all();
        // $sizes = Size::all();
        // $colors = Color::all();
        return view('backend.product.create', compact('categories', 'sizes', 'colors'));
    }

    public function store(ProductStoreRequest $request)
    {
        // Convert request to multipart
        $token = Cookie::get('access_token');
        $headers = [
                    'access_token'  => $token];
        $options = $this->convertRequestToMulipart($request);
        $response = HttpService()->postDataWithOptions('products',$options,$headers);
        if($response->status == 402)
            return back()->with('errors', $response->errors);

        return success('products.index');
    }

    public function show($id)
    {
        $response = GetData()->getDataFromId('products',$id);
        if( ($response->status ?? 200) == 404 )
            return abort(404);
        $product = $response->products;

        return view('backend.product.show', compact('product'));

    }

    public function edit($id)
    {
        $categories = GetData()->getDataWithParam('categories', ['limit' => 'all'])->categories;
        $sizes = GetData()->getDataWithParam('sizes', ['limit' => 'all'])->sizes;
        $colors = GetData()->getDataWithParam('colors', ['limit' => 'all'])->colors;
        $product = GetData()->getDataFromId('products', $id)->products;

        return view('backend.product.edit', compact('product', 'categories', 'sizes', 'colors'));
    }

    public function update(ProductStoreRequest $request, $id)
    {
        $token = Cookie::get('access_token');
        $headers = ['access_token'  => $token];
        if($request->hasFile('images0'))
        {
            $options = $this->convertRequestToMulipart($request);
            $response = HttpService()->updateDataWithOptions('products',$id, $options, $headers);
        }else
        {
            $body = $request->validated();
            $response = HttpService()->updateDataWithBody('products',$id, $body, $headers, 'POST');
        }
        if( ($response->status ?? 200) == 402)
            return back()->with('errors', $response->errors);

        return success('products.index');
    }

    public function destroy($id)
    {
        $token = Cookie::get('access_token');
        $headers = ['access_token'  => $token];
        $response = HttpService()->deletedData('products', $id, [], $headers);

        return back()->with('success', 'Operation Success');
    }

    public function convertRequestToMulipart(Request $request)
    {
        // Convert request to multipart
        $data = $request->all();
        $options = [
            'multipart' => [
              [
                'name' => 'name',
                'contents' => $data['name']
              ],
              [
                'name' => 'description',
                'contents' => $data['description']
              ],
              [
                'name' => 'category_id',
                'contents' => $data['category_id']
              ],
              [
                'name' => 'price',
                'contents' => $data['price']
              ],
              [
                'name' => 'discount',
                'contents' => $data['discount']
              ],
            ]
        ];
        foreach($data['sizes'] as $key => $value)
        {
            $options['multipart'][] = [
                    'name' => 'sizes[]',
                    'contents' => $data['sizes'][$key]
            ];
            $options['multipart'][] = [
                    'name' => 'colors[]',
                    'contents' => $data['colors'][$key]
            ];
            $options['multipart'][] = [
                'name' => 'quantity[]',
                'contents' => $data['quantity'][$key]
              ];
            for( $i = 0 ; $i < count($request->file('images'.$key)); $i++ )
            {
                $options['multipart'][] = [
                    'name' => 'images' .$key. '[]',
                    'contents' => file_get_contents($request->file('images'.$key)[$i]->getRealPath(), 'r'),
                    'filename' => 'temp.jpg',
                    'headers'  => [
                    'Content-Type' => '<Content-type header>'
                    ]
                ];
            }
        }
        return $options;
    }
}
