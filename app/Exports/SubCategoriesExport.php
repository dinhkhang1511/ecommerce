<?php

namespace App\Exports;

use App\Models\SubCategory;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SubCategoriesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return SubCategory::select('name', 'category_id')->latest()->get();
    }

    public function map($item) : array
    {
        return [
            $item->name,
            $item->category->name,
        ] ;
    }

    public function headings(): array
    {
        return [
            'NAME',
            'CATEGORY'
        ];
    }
}
