<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;


class Home extends BaseController
{
    // public function index(): string
    // {
    //     return view('welcome_message');
    // }

    // public function view1()
    // {
    //     return view('page');
    // }
    // public function view()
    // {
    //     $data['text'] = "Hey Balaji, How was the day...";
    //     return view('header') . view('greeting', $data) . view('footer');
    // }

   

    public function all()
    {
        $data['text'] = "Hey Balaji, How was the day...";

        return view('welcome_message')
            . view('page')
            . view('header')
            . view('greeting', $data)
            . view('footer');
    }
}
