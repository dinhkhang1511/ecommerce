<?php

namespace App\Providers;

use App\Models\Product;
use App\Models\SubCategory;
use App\Models\SystemSetting;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->environment() == 'production') {
            URL::forceScheme('https');
        }

        view()->composer('layouts.frontend.app', function ($view) {
            $cart = session('cart', []);
            $products = Product::find(array_keys($cart));
            $amount = 0;
            foreach ($products as $item) {
                foreach (session('cart.'.$item->id) as $key=>$value) {
                    $amount += $cart[$item->id][$key]['quantity'];
                }
            }
            $view->with('cart_amount', $amount);
            $subCategories = SubCategory::inRandomOrder()->limit(3)->get();
            $view->with('sub_categories_footer', $subCategories);
        });

        view()->composer('layouts.*', function ($view) {
            if (session()->has('success')) {
                $view->with('success', session('success'));
                session()->forget('success');
            }

            if (session()->has('error')) {
                $view->with('error', session('error'));
                session()->forget('error');
            }

            $view->with('setting', SystemSetting::all()->first());
        });

        view()->composer('auth.*', function ($view) {
            $view->with('setting', SystemSetting::all()->first());
        });

        view()->composer('*', function($view){
            if(session()->has('user'))
                $view->with('user',session('user'));
            $view->with('api_url',config('app.api_asset_url'));
        });

        // view()->composer('layouts.backend.app', function ($view) {
        //     $view->with('current_user', auth()->user()->load('unreadNotifications'));
        // });
    }
}
