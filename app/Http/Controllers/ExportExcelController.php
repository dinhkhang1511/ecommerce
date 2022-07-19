<?php

namespace App\Http\Controllers;

use App\Exports\OrdersExport;
use App\Exports\ProductsExport;
use App\Exports\CategoriesExport;
use App\Exports\SubCategoriesExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportExcelController extends Controller
{
    private $time;

    public function __construct()
    {
        $this->time = time();
    }

    public function categories()
    {
        return Excel::download(new CategoriesExport, "categories_$this->time.xlsx");
    }

    public function subCategories()
    {
        return Excel::download(new SubCategoriesExport, "sub-categories_$this->time.xlsx");
    }

    public function products()
    {
        return Excel::download(new ProductsExport, "products_$this->time.xlsx");
    }

    public function orders()
    {
        return Excel::download(new OrdersExport, "orders_$this->time.xlsx");
    }
}
