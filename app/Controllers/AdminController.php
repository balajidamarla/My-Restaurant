<?php

namespace App\Controllers;

use App\Models\UserModel;

class AdminController extends BaseController
{
    public function dashboard()
    {
        return view('admin/dashboard');
    }
    
    public function users()
    {
        if (!session()->get('isLoggedIn') || !session()->get('isAdmin')) {
            return redirect()->to('/login');
        }

        $userModel = new UserModel();
        $data['users'] = $userModel->findAll();
        return view('admin_users', $data);
    }
}
