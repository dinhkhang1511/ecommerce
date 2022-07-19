<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ProductsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::select(
            'name',
            'price',
            'quantity',
            'discount',
            'sub_category_id'
        )->latest()->get();
    }

    public function map($item) : array
    {
        return [
            $item->name,
            $item->price,
            $item->quantity,
            $item->discount,
            $item->subCategory->name,
        ] ;
    }

    public function headings(): array
    {
        return [
            'NAME', 'PRICE', 'QUANTITY', 'DISCOUNT', 'SUB CATEGORY'
        ];
    }
}
