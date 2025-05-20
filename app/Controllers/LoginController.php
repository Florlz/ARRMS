<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel; 

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
            // Set all user details in session
            $session = session();
            $session->set([
                'student_id'        => $user['student_id'],
                'first_name'        => $user['first_name'],
                'last_name'         => $user['last_name'],
                'middle_name'       => $user['middle_name'],
                'college'           => $user['college'],
                'date_graduated'    => $user['date_graduated'] ?? null,
                'birthdate'         => $user['birthdate'],
                'birthplace'        => $user['birthplace'],
                'email_address'     => $user['email_address'],
                'mobile_no'         => $user['mobile_no'],
                'zip_code'          => $user['zip_code'],
                'type_of_admission' => $user['type_of_admission'],
                'street_barangay'   => $user['street_barangay'],
                'municipality'      => $user['municipality'],
                'province'          => $user['province'] ?? null,
                'region'            => $user['region'] ?? null,
                'isLoggedIn'        => true
            ]);
            // Authentication successful
            return redirect()->to('/student')->with('success', 'Login successful');
        } else {
            // Authentication failed
            return redirect()->back()->with('error', 'Invalid student ID or password');
        }
    }
}
