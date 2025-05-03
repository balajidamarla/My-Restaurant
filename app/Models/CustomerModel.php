<?php

namespace App\Models;
use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table = 'customers';  // The table name in your database
    protected $primaryKey = 'id';    // The primary key of the table
    
    protected $allowedFields = ['name', 'email', 'password', 'reset_token', 'token_expiry']; // Add 'reset_token' and 'token_expiry' to allowed fields
    protected $useTimestamps = true; // Set to true if you want timestamps for created_at and updated_at columns
    
    // Method to get a customer by email
    public function get_customer_by_email($email) {
        return $this->where('email', $email)->first();
    }

    // Method to save the reset token
    public function save_password_reset_token($email, $token) {
        $data = [
            'reset_token' => $token,
            'token_expiry' => date('Y-m-d H:i:s', strtotime('+30 minutes'))  // Token expires after 30 minutes
        ];
        return $this->update($email, $data);
    }

    // Method to get a customer by token
    public function get_customer_by_token($token) {
        return $this->where('reset_token', $token)->first();
    }

    // Method to update the password
    public function update_password($email, $hashed_password) {
        return $this->update($email, ['password' => $hashed_password, 'reset_token' => null, 'token_expiry' => null]);
    }

    // Method to invalidate the token after password reset
    public function invalidate_token($email) {
        return $this->update($email, ['reset_token' => null, 'token_expiry' => null]);
    }
}
