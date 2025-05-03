<?php

namespace App\Controllers;

use App\Models\CustomerModel;

class AuthController extends BaseController
{
    public function loginForm()
    {
        return view('login');
    }

    public function login()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $role = $this->request->getPost('role'); // 'admin' or 'customer'

        if ($role === 'admin') {
            // Only allow admin login with hardcoded credentials
            if ($email === 'admin' && $password === 'admin123') {
                session()->set([
                    'isLoggedIn' => true,
                    'isAdmin'    => true,              // This allows admin navbar to work
                    'role'       => 'admin',
                    'user_name'  => 'Admin'
                ]);
                return redirect()->to('/admin/dashboard'); // Admin panel
            } else {
                return redirect()->back()->with('error', 'Invalid admin credentials');
            }
        }

        // Handle customer login
        if ($role === 'customer') {
            $customerModel = new \App\Models\CustomerModel();
            $customer = $customerModel->where('email', $email)->first();

            if ($customer && password_verify($password, $customer['password'])) {
                session()->set([
                    'isLoggedIn' => true,
                    'isAdmin'    => false,              //So customer doesn't see admin navbar
                    'role'       => 'customer',
                    'user_id'    => $customer['id'],
                    'user_name'  => $customer['name']
                ]);
                return redirect()->to('/menu'); // Customer menu page
            } else {
                return redirect()->back()->with('error', 'Invalid customer credentials');
            }
        }

        return redirect()->back()->with('error', 'Invalid login role selected');
    }


    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'You have been logged out');
    }
}
