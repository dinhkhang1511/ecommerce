<?php

namespace App\Providers;

use App\Models\Product;
use App\Models\SubCategory;
use App\Models\SystemSetting;
use Illuminate\Support\Facades\Cookie;
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
        $systemSetting = GetData()->getDataFromType('systemSettings')->settings;
        if ($this->app->environment() == 'production') {
            URL::forceScheme('https');
        }

        view()->composer('layouts.frontend.app', function ($view) {
            $cart = session('cart', []);
            $products = cart()->getProductsInCart(array_keys($cart));
            $amount = 0;
            foreach ($products as $item) {
                foreach (session('cart.'.$item->id) as $key=>$value) {
                    $amount += $cart[$item->id][$key]['quantity'];
                }
            }
            $view->with('cart_amount', $amount);
            $categories = GetData()->getDataWithParam('categories',['limit' => '3'])->categories;
            $view->with('sub_categories_footer', $categories);
        });

        view()->composer('layouts.*', function ($view) use($systemSetting) {
            if (session()->has('success')) {
                $view->with('success', session('success'));
                session()->forget('success');
            }

            if (session()->has('error')) {
                $view->with('error', session('error'));
                session()->forget('error');
            }
            $view->with('setting', $systemSetting);
        });

        view()->composer('auth.*', function ($view) use($systemSetting){
            $view->with('setting', $systemSetting);
        });

        view()->composer('*', function($view){
            if(session()->has('user'))
                $view->with('user',session('user'));
            $view->with('api_asset_url',config('app.api_asset_url'));
            $view->with('api_url',config('app.api_url'));

        });

        view()->composer('backend.setting.*', function ($view) {
            $settings = getData()->getDataFromType('systemSettings')->settings;

            $view->with('setting', $settings);
        });

        view()->composer('layouts.backend.app', function ($view) {
            $user = getData()->getDataWithParam('getUser',['fields' => 'unreadNotifications'], ['access_token' => Cookie::get('access_token','')]);
            $view->with('current_user', $user);
        });
    }
}
