<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use App\Models\Contact;
use App\Models\CatalogBlog;
use App\Helper\Cart;
use Carbon\Carbon;

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
        view()->composer('*',function($view){
            $view->with([
                'categories' => Category::where('status',1)->get(),
                'catalogBlogs' => CatalogBlog::where('status',1)->get(),
                'mytime' => Carbon::now()->subDays(30),
                'contacts' => Contact::get(),
                'today1' => strtotime(Carbon::now()),
                'today' => strtotime(Carbon::now()),
                'cart' => new Cart()
            ]);
        });
    }
}
