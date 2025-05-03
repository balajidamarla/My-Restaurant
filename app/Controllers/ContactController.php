<?php

namespace App\Controllers;

use App\Models\ContactModel;
use CodeIgniter\Controller;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact_form');
    }

    public function submit()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'name'    => 'required|min_length[3]',
            'email'   => 'required|valid_email|is_unique[contacts.email]',
            'phone'   => 'required|numeric|min_length[10]|is_unique[contacts.phone]',
            'message' => 'required|min_length[5]'
        ];

        if (!$this->validate($rules)) {
            return view('contact_form', [
                'validation' => $this->validator
            ]);
        }

        $model = new ContactModel();
        $model->save([
            'name'    => $this->request->getPost('name'),
            'email'   => $this->request->getPost('email'),
            'phone'   => $this->request->getPost('phone'),
            'message' => $this->request->getPost('message')
        ]);

        return redirect()->to('/contact')->with('success', 'Form submitted successfully!');
    }
    public function view()
    {
        $model = new ContactModel();
        $data['contacts'] = $model->findAll();

        return view('contact_view', $data);
    }
}
