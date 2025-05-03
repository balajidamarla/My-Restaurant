<?php

namespace App\Controllers;

//class HomeController extends BaseController
// {
//     public function index()
//     {
//         return view('home');
        
//     }

//     // public function menu()
//     // {
//     //     return view('menu');
//     // }

//     public function about()
//     {
//         return view('about');
//     }

//     public function contactR()
//     {

//         return view('contactR');
//     }
// }

use App\Models\MenuModel;

class HomeController extends BaseController
{
    public function index()
    {  $cart = session()->get('cart');
        var_dump($cart); die;
        $model = new MenuModel();
        $data['menuItems'] = $model->findAll();
        return view('menu', $data);
    }
    public function menu(){
        return view('home');
    }
    public function about()
    {
        return view('about');
    }

    public function contactR()
    {

        return view('contactR');
    }
}
