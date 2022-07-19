<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CategoriesExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Category::select('name')->latest()->get();
    }

    public function headings(): array
    {
        return [
            'NAME',
        ];
    }
}
