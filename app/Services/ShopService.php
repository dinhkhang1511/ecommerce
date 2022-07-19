<?php

namespace App\Services;

use App\Models\SubCategory;
use App\Models\ProductAttribute;

class ShopService
{
    private $products;

    public function __construct($products)
    {
        $this->products = $products;
    }

    public function filter()
    {
        $this->filterByCategory();
        $this->filterBySubCategory();
        $this->filterByPrice();
        $this->filterBySize();
        $this->filterByColor();
        $this->filterByName();
        $this->filterBySale();

        return $this->products->orderBy('price', request('sortby', 'asc'))
                ->offset(request('offset', 0))
                ->limit(request('limit', 5))
                ->get();
    }

    public function filterByCategory()
    {
        if (request('category')) {
            $subcategories = SubCategory::whereIn('category_id', explode(',', request('category')))->get()->modelKeys();
            $this->products->whereIn('sub_category_id', $subcategories);
        }
    }

    public function filterBySubCategory()
    {
        if (request('subcategory')) {
            $this->products->whereIn('sub_category_id', explode(',', request('subcategory')));
        }
    }

    public function filterByPrice()
    {
        $priceRange = [
            '0' => ['min' => 0, 'max' => 200],
            '1' => ['min' => 200, 'max' => 299],
            '2' => ['min' => 300, 'max' => 399],
            '3' => ['min' => 400, 'max' => 499],
            '4' => ['min' => 500, 'max' => 99999999999],
        ];

        if (request('price')) {
            $price = explode(',', request('price'));
            unset($price[count($price) - 1]);
            foreach ($price as $index=>$value) {
                $min = $priceRange[$value]['min'];
                $max = $priceRange[$value]['max'];
                if ($index > 0) {
                    $this->products->orWhereBetween('price', [$min, $max]);
                    continue;
                }
                $this->products->whereBetween('price', [$min, $max]);
            }
        }
    }

    public function filterBySize()
    {
        if (request('size')) {
            $productIds = ProductAttribute::whereIn('size_id', explode(',', request('size')))->pluck('product_id');
            $this->products->whereIn('id', $productIds);
        }
    }

    public function filterByColor()
    {
        if (request('color')) {
            $productIds = ProductAttribute::whereIn('color_id', explode(',', request('color')))->pluck('product_id');
            $this->products->whereIn('id', $productIds);
        }
    }

    public function filterByName()
    {
        if (request('name')) {
            $this->products->where('name', 'LIKE', '%'.request('name').'%');
        }
    }

    public function filterBySale()
    {
        if (request('sale') == 'yes') {
            $this->products->where('discount', '>', 0);
        }
    }
}
