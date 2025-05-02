<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel; // Ensure this matches the namespace of the UserModel class

class LoginController extends BaseController
{
    public function authenticate()
    {
        $studentId = $this->request->getPost('student_id');
        $password = $this->request->getPost('password');

        // Load the User model
        $userModel = new UserModel();

        // Check if the user exists
        $user = $userModel->where('student_id', $studentId)->first();
        if (!$user) {
            // User not found
            return redirect()->back()->with('error', 'Invalid student ID or password');
        }
        
        if ($password === $user['password']) {
            // Authentication successful
            return redirect()->to('/student')->with('success', 'Login successful');
        } else {
            // Authentication failed
            return redirect()->back()->with('error', 'Invalid student ID or password');
        }
    }
}
