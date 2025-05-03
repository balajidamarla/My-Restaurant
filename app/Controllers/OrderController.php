<?php

namespace App\Controllers;

require_once APPPATH . 'ThirdParty/vendor/autoload.php';

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\MenuModel;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\CustomerModel;
use App\Models\NotificationModel;

class OrderController extends BaseController
{
    // Show all orders (Admin view)
    // public function index()
    // {
    //     $model = new OrderModel();
    //     $orders = $model->findAll();

    //     return view('order_list', ['orders' => $orders]);
    // }

    protected $orderModel;
    protected $notificationModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->notificationModel = new NotificationModel();
    }

    public function index()
    {
        $model = new OrderModel();

        // Pagination configuration
        $perPage = 10; // Number of items per page
        $totalOrders = $model->countAllResults(); // Total number of orders

        // Initialize pagination library
        $pager = \Config\Services::pager();

        // Fetch orders with pagination
        $orders = $model->orderBy('created_at', 'desc')
            ->paginate($perPage, 'default', $this->request->getVar('page') ?? 1); // 'default' is the group name for pagination

        // Return the view with orders and pager data
        return view('order_list', [
            'orders' => $orders,
            'pager' => $pager,
            'totalOrders' => $totalOrders
        ]);
    }



    // Update order status (Admin use)
    // public function updateStatus($id)
    // {
    //     $model = new OrderModel();
    //     $status = $this->request->getPost('status');

    //     $model->update($id, ['status' => $status]);

    //     return redirect()->to('/orders')->with('success', 'Order status updated successfully!');
    // }

    // public function updateStatus($id)
    // {
    //     $model = new OrderModel();
    //     $status = $this->request->getPost('status');

    //     $model->update($id, ['status' => $status]);

    //     return redirect()->to('/orders')->with('success', 'Order status updated successfully!');
    // }



    // Show the order form for a specific menu item (Customer)
    public function create($menuItemId)
    {
        // Check if customer is logged in
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'customer') {
            return redirect()->to('/login')->with('error', '⚠️ Please login to place an order.');
        }

        // Get the menu item details
        $model = new MenuModel();
        $item = $model->find($menuItemId);

        if (!$item) {
            return redirect()->to('/menu')->with('error', 'Menu item not found.');
        }

        return view('order', [
            'menuItem'   => $item,
            'food_item'  => $item['name'],
            'price'      => $item['price']
        ]);
    }

    // Store the order and redirect to invoice
    public function store()
    {
        $model = new OrderModel();

        // Retrieve session values
        $customerId = session()->get('user_id');  // Ensure this session key is consistent
        $foodItem = $this->request->getPost('food_item');
        $quantity = $this->request->getPost('quantity');
        $totalPrice = $this->request->getPost('total_price');
        $status = 'pending'; // Default status for new orders

        $data = [
            'customer_id' => $customerId,
            'food_item'   => $foodItem,
            'quantity'    => $quantity,
            'total_price' => $totalPrice,
            'status'      => $status
        ];
        $model->insert($data);
        $orderId = $model->insertID();

        return redirect()->to('/order/invoice/' . $orderId);
    }

    // Method to display order invoice
    public function viewOrder($orderId)
    {
        // Load the Order model
        $orderModel = new OrderModel();

        // Fetch the order data from the database
        $order = $orderModel->find($orderId);

        // Check if the order exists
        if ($order) {
            // Pass the order data to the view
            return view('customer/invoices', ['order' => $order]);
        } else {
            // If no order found, throw an error or redirect
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Order not found');
        }
    }

    public function invoices($order_group_id)
    {
        // Ensure the customer is logged in and not an admin
        if (!session()->get('isLoggedIn') || session()->get('isAdmin')) {
            return redirect()->to('/customer/login')->with('error', 'Please login as a customer to view invoices.');
        }

        $customerId = session()->get('user_id'); // Get customer ID from session
        $model = new OrderModel();

        // Fetch orders with the provided order_group_id and ensure it's the correct customer
        $orders = $model->where('order_group_id', $order_group_id)
            ->where('customer_id', $customerId)
            ->findAll();

        // If no orders are found, show an error and redirect
        if (empty($orders)) {
            return redirect()->to('/customer/orders')->with('error', 'Invoice not found.');
        }

        // Pass the orders and group ID to the view
        return view('customer/invoices', [
            'orders' => $orders,
            'orderGroupId' => $order_group_id
        ]);
    }



    public function download_invoice($order_group_id)
    {
        $customerId = session()->get('user_id');

        $orderModel = new OrderModel();
        $customerModel = new CustomerModel();

        // Fetch orders based on the order_group_id and customer_id
        $orders = $orderModel->where('order_group_id', $order_group_id)
            ->where('customer_id', $customerId)
            ->findAll();

        if (empty($orders)) {
            return redirect()->to('/customer/orders')->with('error', 'Invoice not found.');
        }

        // Fetch customer name
        $customer = $customerModel->find($customerId);
        $customer_name = $customer['name'] ?? 'Customer';

        // Render the HTML view into a string
        $html = view('customer/download_invoice', [
            'orders' => $orders,
            'order_group_id' => $order_group_id,
            'customer_name' => $customer_name
        ]);

        // Initialize Dompdf
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Stream the PDF
        return $dompdf->stream("invoice_" . $order_group_id . ".pdf", ["Attachment" => true]);
    }


    public function updateStatus($id)
    {
        $model = new \App\Models\OrderModel();
        $status = $this->request->getPost('status');

        // Update the order status
        $model->update($id, ['status' => $status]);

        // Fetch order to get customer_id
        $order = $model->find($id);

        if ($order && isset($order['customer_id'])) {
            // Insert notification
            $notificationModel = new \App\Models\NotificationModel();
            $notificationModel->insert([
                'order_id'    => $id,
                'customer_id' => $order['customer_id'],
                'message'     => 'Your ' . $order['food_item'] . ' is now ' . strtolower($status),
                'is_read'     => 0,
                'created_at'  => date('Y-m-d H:i:s')
            ]);
        }

        return redirect()->to('/orders')->with('success', 'Order status updated and notification created!');
    }
}
