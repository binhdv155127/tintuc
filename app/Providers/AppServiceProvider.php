<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\TheLoai;
use App\Slide;

use Illuminate\Support\Facades\Auth;  // đùng để đăng nhập

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


        // cái này chia sẻ cho tất cả
        $theloai = TheLoai::all();
        view()->share('theloai', $theloai); 


        // cái này chia sẻ cho menu mà thui
        // view()->composer('layout.menu',function($view){

        //     $theloai = TheLoai::all();
        //     $view->with('theloai',$theloai);
        // });

        $slide = Slide::all();
        view()->share('slide', $slide); 

        // if(Auth::check()){
        //     view()->share('nguoidung', Auth::user());
        // }
    }
}
