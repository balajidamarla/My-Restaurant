<?php

namespace App\Controllers;

use App\Models\UserModel;

class RegisterController extends BaseController
{
    public function index()
    {
        return view('customer/register');
    }

    public function submit()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'name'     => 'required|min_length[3]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]'
        ];

        if (!$this->validate($rules)) {
            return view('register', [
                'validation' => $this->validator
            ]);
        }

        $model = new UserModel();
        $model->save([
            'name'     => $this->request->getPost('name'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)
        ]);

        session()->setFlashdata('success', 'Registration successful!');
        return redirect()->to('customer/register');
    }
}
