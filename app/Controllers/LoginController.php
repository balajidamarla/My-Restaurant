<?php

namespace App\Controllers;

use App\Models\CustomerModel;

class LoginController extends BaseController
{
    // Show the login form
    public function index()
    {
        return view('login');
    }

    // Handle login form submission
    public function submit()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required',
            'role' => 'required|in_list[admin,customer]'
        ];

        if (!$this->validate($rules)) {
            return view('login', [
                'validation' => $this->validator
            ]);
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $role = $this->request->getPost('role');

        // Admin login (hardcoded)
        if ($role === 'admin') {
            if ($email === 'admin' && $password === 'admin123') {
                session()->set([
                    'isLoggedIn' => true,
                    'isAdmin' => true,
                    'user_name' => 'Admin'
                ]);
                return redirect()->to('/admin/dashboard');
            } else {
                return redirect()->back()->with('error', 'Invalid admin credentials');
            }
        }

        // Customer login
        if ($role === 'customer') {
            $customerModel = new CustomerModel();
            $customer = $customerModel->where('email', $email)->first();

            // Save entered email in session for verification view
            session()->set('entered_email', $email);

            if ($customer && password_verify($password, $customer['password'])) {
                session()->set([
                    'isLoggedIn' => true,
                    'isAdmin' => false,
                    'user_id' => $customer['id'],
                    'user_name' => $customer['name']
                ]);

                return redirect()->to('/customer/customer_dashboard');
            } else {
                // Redirect to email verification with the entered email
                return redirect()->to('/customer/verify-email')->with('error', 'Invalid login. Please verify your email.');
            }
        }

        return redirect()->back()->with('error', 'Invalid role selected');
    }


    // Logout
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Logged out successfully');
    }
}
