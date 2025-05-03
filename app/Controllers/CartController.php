<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MenuModel;
use App\Models\OrderModel;
use CodeIgniter\I18n\Time;

class CartController extends BaseController
{
    // Show cart items
    public function index()
    {
        $cart = session()->get('cart') ?? [];
        return view('cart/index', ['cart' => $cart]); // ✅ Corrected path
    }

    // Add item to cart
    public function addToCart()
    {
        $id = $this->request->getPost('food_id');
        $quantity = max(1, (int) $this->request->getPost('quantity'));


        $menuModel = new MenuModel();
        $item = $menuModel->find($id);

        if ($item) {
            $cart = session()->get('cart') ?? [];

            if (isset($cart[$id])) {
                $cart[$id]['quantity'] += $quantity;
            } else {
                $cart[$id] = [
                    'id' => $id,
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'quantity' => $quantity
                ];
            }

            session()->set('cart', $cart);
            return redirect()->back()->with('success', 'Item added to cart!');
        }

        return redirect()->back()->with('error', 'Item not found!');
    }

    // Remove item from cart
    public function removeFromCart($id)
    {
        $cart = session()->get('cart');
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->set('cart', $cart);
        }
        return redirect()->back()->with('success', 'Item removed from cart');
    }

    // Checkout
    public function checkout()
    {
        $cart = session()->get('cart');
        $customerId = session()->get('user_id');

        if (!$cart || !$customerId) {
            return redirect()->to('/customer/login')->with('error', 'Please login and add items to cart');
        }

        $orderModel = new OrderModel();

        //Generate a unique order group ID
        $orderGroupId = uniqid('order_' . $customerId . '_');

        foreach ($cart as $item) {
            $orderModel->save([
                'order_group_id' => $orderGroupId,
                'customer_id'    => $customerId,
                'food_item'      => $item['name'],
                'quantity'       => $item['quantity'],
                'total_price'    => $item['price'] * $item['quantity'],
                'status'         => 'Pending',
                'created_at'     => Time::now('Asia/Kolkata'),
            ]);
        }

        // Clear the cart after order is placed
        session()->remove('cart');

        return redirect()->to('/customer/orders')->with('success', 'Order placed successfully!');
    }

    // public function update()
    // {
    //     if ($this->request->isAJAX()) {
    //         $data = json_decode($this->request->getBody(), true);
    //         $itemId = $data['itemId'];
    //         $quantity = $data['quantity'];

    //         // Get the current cart from session
    //         $cart = session()->get('cart');

    //         // Check if the item exists in the cart
    //         if (isset($cart[$itemId])) {
    //             // Update the quantity
    //             $cart[$itemId]['quantity'] = $quantity;

    //             // Recalculate the total price for the item and the overall cart
    //             $cart[$itemId]['total'] = $cart[$itemId]['price'] * $quantity;
    //             $grandTotal = 0;

    //             foreach ($cart as $item) {
    //                 $grandTotal += $item['total'];  // Sum up the total price of all items
    //             }

    //             // Update the session with the modified cart
    //             session()->set('cart', $cart);

    //             // Return the updated cart and total back to the frontend
    //             return $this->response->setJSON([
    //                 'success' => true,
    //                 'cart' => $cart,
    //                 'grandTotal' => $grandTotal
    //             ]);
    //         }
    //     }

    //     return $this->response->setJSON(['success' => false]);
    // }
    public function update()
    {
        if ($this->request->isAJAX()) {
            //log_message('debug', 'AJAX request received for update');
            $data = json_decode($this->request->getBody(), true);
            $itemId = $data['itemId'];
            $quantity = $data['quantity'];

            $cart = session()->get('cart');

            if (isset($cart[$itemId])) {
                $cart[$itemId]['quantity'] = $quantity;
                session()->set('cart', $cart);

                // Recalculate grand total
                $grandTotal = 0;
                foreach ($cart as $item) {
                    $grandTotal += $item['price'] * $item['quantity'];
                }

                return $this->response->setJSON(['success' => true, 'grandTotal' => $grandTotal]);
            }
        }

        log_message('error', 'Failed to update cart. Item not found or invalid AJAX request.');
        return $this->response->setJSON(['success' => false]);
    }
}
