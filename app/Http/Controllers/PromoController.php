<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Support\Str;

class PromoController extends Controller
{
    public function index()
    {
        $promos = Promo::latest()->paginate(10);
        return view('backend.promo.index', compact('promos'));
    }

    public function create()
    {
        return view('backend.promo.create');
    }

    public function store()
    {
        $promo = Promo::create(request()->all());
        $promo->update(['code' => str_pad($promo->id, 10, Str::random(100))]);
        return success('promos.index');
    }

    public function edit(Promo $promo)
    {
        return view('backend.promo.edit', compact('promo'));
    }

    public function update(Promo $promo)
    {
        $promo->update(request()->all());
        return success('promos.index');
    }

    public function destroy(Promo $promo)
    {
        $promo->delete();
        return success('promos.index');
    }
}
