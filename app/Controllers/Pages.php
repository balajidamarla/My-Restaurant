<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index()
    {
        return view('welcome_message');
    }

    public function view()
    {
        $data['text'] = "Hey Balaji, How was the day...";
        return view('header') . view('greeting', $data) . view('footer');
    }
    
    
}
