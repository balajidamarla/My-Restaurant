<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use App\Models\OrderModel;
use App\Models\NotificationModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\I18n\Time;
use Config\Services;

class CustomerController extends BaseController
{
    protected $customerModel;
    protected $session;
    protected $email;
    public function __construct()
    {
        $this->customerModel = new CustomerModel();
        $this->session = session();
        $this->email = Services::email();
        helper(['url', 'form']);
    }

    // Register method for customer
    public function register()
    {
        return view('customer/register');
    }

    // Store the customer data after validation
    public function store()
    {
        $validation = \Config\Services::validation();

        // Define validation rules
        $rules = [
            'name'     => 'required|min_length[3]',
            'email'    => 'required|valid_email|is_unique[customers.email]',
            'password' => 'required|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode('<br>', $validation->getErrors()));
        }

        $model = new \App\Models\CustomerModel();
        $email = $this->request->getPost('email');

        // Check if email already exists
        $existingCustomer = $model->where('email', $email)->first();

        if ($existingCustomer) {
            return redirect()->back()
                ->withInput()
                ->with('error', '❗ You already have an account. Please log in.');
        }

        // Save new customer
        $model->save([
            'name'     => $this->request->getPost('name'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        ]);

        return redirect()->to('/customer/login')->with('success', '🎉 Registered successfully! Please log in.');
    }

    // Login form for customer
    public function login()
    {
        return view('customer/login');
    }

    // Authenticate customer login
    public function authenticate()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $model = new \App\Models\CustomerModel();
        $customer = $model->where('email', $email)->first();

        // If the customer exists and password is correct
        if ($customer && password_verify($password, $customer['password'])) {
            // Set session for logged-in customer
            session()->set([
                'isLoggedIn' => true,
                'isAdmin' => false,
                'user_id' => $customer['id'],
                'user_name' => $customer['name']
            ]);

            return redirect()->to('/menu')->with('success', 'Welcome back, ' . $customer['name'] . '!');
        } else {
            return redirect()->back()->with('error', 'Invalid email or password.');
        }
    }

    // Logout customer
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/customer/login')->with('success', 'You have logged out.');
    }

    // Customer dashboard (check if logged in)
    public function dashboard()
    {
        if (!session()->get('isLoggedIn') || session()->get('isAdmin')) {
            return redirect()->to('/customer/login')->with('error', 'Please login as customer to access the dashboard.');
        }

        return view('customer/customer_dashboard');
    }

    // View customer orders (check if logged in)
    public function orders()
    {
        if (!session()->get('isLoggedIn') || session()->get('isAdmin')) {
            return redirect()->to('/customer/login')->with('error', 'Please login as customer to view orders.');
        }
        // Get the customer_id from session
        $customerId = session()->get('user_id');

        // Load the model
        $model = new OrderModel();

        // Fetch orders based on customer_id
        $orders = $model->where('customer_id', $customerId)
            ->orderBy('created_at', 'desc')
            ->findAll();
        // Check if orders are found
        if (empty($orders)) {
            return redirect()->to('/customer/dashboard')->with('error', 'No invoices found.');
        }
        return view('customer/orders', ['orders' => $orders]);
    }


    public function forgot_password()
    {

        // Get the email from the query parameter (if any)
        $email = $this->request->getGet('email');
        return view('customer/forgot_password', ['email' => $email]);
    }

    public function send()
    {
        $customerModel = new \App\Models\CustomerModel(); // Load the model
        if ($this->request->getMethod() == 'POST') {
            $email = $this->request->getPost('email');

            $customer = $customerModel->where('email', $email)->first();
            var_dump($customer['id']);
            if ($customer) {
                // Generate token
                $token = bin2hex(random_bytes(50));
                $customerModel->update($customer['id'], ['reset_token' => $token]);

                // Create reset link
                $reset_link = base_url('customer/reset_password?token=' . $token);

                // Send email
                $this->send_reset_password_email($email, $reset_link);

                return redirect()->to('customer/forgot_password')->with('message', 'Check your email for password reset link.');
            } else {
                return redirect()->to('customer/forgot_password')->with('error', 'Email not found.');
            }
        } else {
            return redirect()->to('customer/forgot_password')->with('error', 'Invalid');
        }
    }
    private function send_reset_password_email($email, $reset_link)
    {
        $emailService = \Config\Services::email();

        $emailService->setFrom('hrmanager@acewebacademy.com', 'My Restaurant');
        $emailService->setTo($email);
        $emailService->setSubject('Password Reset Request');

        $message = "Click the link below to reset your password:\n\n";
        $message .= $reset_link;

        $emailService->setMessage($message);

        if (!$emailService->send()) {
            log_message('error', 'Failed to send password reset email.');
        }
    }

    // Show reset password form (GET)
    public function showResetPasswordForm()
    {
        $token = $this->request->getGet('token');
        $customerModel = new \App\Models\CustomerModel();

        $customer = $customerModel->where('reset_token', $token)->first();

        if (!$customer) {
            return view('customer/reset_password', ['error' => 'Invalid or expired token']);
        }

        return view('customer/reset_password', ['token' => $token]);
    }

    // Handle reset password form submission (POST)
    public function handleResetPassword()
    {
        helper(['form', 'url']);
        $customerModel = new \App\Models\CustomerModel();

        $password = $this->request->getPost('password');
        $confirm_password = $this->request->getPost('confirm_password');
        $token = $this->request->getPost('token');

        $customer = $customerModel->where('reset_token', $token)->first();

        if (!$customer) {
            return view('customer/reset_password', ['error' => 'Invalid or expired token']);
        }

        if ($password === $confirm_password) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $customerModel->update($customer['id'], [
                'password' => $hashedPassword,
                'reset_token' => null
            ]);

            session()->set([
                'isLoggedIn' => true,
                'isAdmin' => false,
                'user_id' => $customer['id'],
                'user_name' => $customer['name']
            ]);

            return redirect()->to('/customer/customer_dashboard')->with('message', 'Password updated successfully. You are now logged in.');
        } else {
            return view('customer/reset_password', [
                'error' => 'Passwords do not match',
                'token' => $token
            ]);
        }
    }



    // public function resetPassword()
    // {
    //     $email = $this->request->getPost('email');
    //     $newPassword = $this->request->getPost('password');

    //     $model = new \App\Models\CustomerModel();
    //     $customer = $model->where('email', $email)->first();

    //     if (!$customer) {
    //         return redirect()->back()->with('error', '❌ Email not found!');
    //     }

    //     $model->update($customer['id'], [
    //         'password' => password_hash($newPassword, PASSWORD_DEFAULT),
    //     ]);

    //     return redirect()->to('/login')->with('success', 'Password updated! You can now log in.');
    // }

    //notifications
    public function fetchNotifications()
    {
        $session = session();
        $customerId = $session->get('user_id');  // Get customer ID from session

        if (!$customerId) {
            return $this->response->setJSON([
                'notifications' => [],
                'unread' => 0
            ]);
        }

        $notificationModel = new \App\Models\NotificationModel();
        $notifications = $notificationModel
            ->where('customer_id', $customerId)
            ->orderBy('created_at', 'desc')
            ->findAll(5);

        $unreadCount = $notificationModel
            ->where('customer_id', $customerId)
            ->where('is_read', 0)
            ->countAllResults();

        return $this->response->setJSON([
            'notifications' => $notifications,
            'unread' => $unreadCount
        ]);
    }


    public function markNotificationRead()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['error' => 'Invalid request.']);
        }

        $notificationId = $this->request->getPost('id');

        $notificationModel = new \App\Models\NotificationModel();
        $notificationModel->update($notificationId, ['is_read' => 1]);

        return $this->response->setJSON(['success' => true]);
    }
}
