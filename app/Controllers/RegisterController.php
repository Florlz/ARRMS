<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use Config\Email as EmailConfig; // Import Email Config

class RegisterController extends BaseController
{
    public function index()
    {
        return view('register_user');
    }

    public function store()
    {
        helper(['form', 'text']); // Add 'text' helper for random_string
        $session = session();

        $validationRules = [
            'idnum'        => 'required|numeric|exact_length[9]|is_unique[users.student_id]',
            'password'     => 'required|min_length[6]',
            'password_confirm' => 'required|matches[password]',
            'fname'        => 'required|alpha_space',
            'lname'        => 'required|alpha_space',
            'mname'        => 'permit_empty|alpha_space',
            'college'      => 'required',
            'bdate'        => 'required|valid_date',
            'bplace'       => 'required',
            'cspcemail'    => 'required|valid_email|is_unique[users.email_address]',
            'mobile'       => 'required|numeric|min_length[10]|max_length[15]',
            'zipcode'      => 'required|numeric',
            'admission'    => 'required',
            'street'       => 'required',
            'region'       => 'required',
            'province'     => 'required',
            'municipality' => 'required',
            'year_enrolled' => 'required|numeric|exact_length[4]',
            'year_graduated' => 'permit_empty|numeric|exact_length[4]',
        ];

        // Add custom error messages for more user-friendly feedback
        $validationMessages = [
            'idnum' => [
                'required' => 'Student ID is required',
                'numeric' => 'Student ID should contain only numbers',
                'exact_length' => 'Student ID must be exactly 9 digits',
                'is_unique' => 'This Student ID is already registered'
            ],
            'cspcemail' => [
                'valid_email' => 'Please enter a valid email address',
                'is_unique' => 'This email address is already registered'
            ],
            'password' => [
                'min_length' => 'Password must be at least 6 characters long'
            ],
            'password_confirm' => [
                'required' => 'Please confirm your password',
                'matches' => 'Passwords do not match'
            ],
            'year_enrolled' => [
                'required' => 'Year enrolled is required',
                'numeric' => 'Year must be a valid number',
                'exact_length' => 'Year must be exactly 4 digits'
            ],
            'year_graduated' => [
                'numeric' => 'Year must be a valid number',
                'exact_length' => 'Year must be exactly 4 digits'
            ],
            'mobile' => [
                'required' => 'Mobile number is required',
                'numeric' => 'Mobile number must contain only digits',
                'min_length' => 'Mobile number must be at least 10 digits',
                'max_length' => 'Mobile number cannot exceed 15 digits'
            ]
        ];

        if (!$this->validate($validationRules, $validationMessages)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'errors' => $this->validator->getErrors()]);
            }
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Custom validation for year_graduated
        $yearEnrolled = $this->request->getPost('year_enrolled');
        $yearGraduated = $this->request->getPost('year_graduated');
        
        if (!empty($yearGraduated) && $yearGraduated < $yearEnrolled) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Graduation year cannot be earlier than enrollment year.']);
            }
            return redirect()->back()->withInput()->with('error', 'Graduation year cannot be earlier than enrollment year.');
        }

        $userData = [
            'student_id'        => $this->request->getPost('idnum'),
            'password'          => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT), // Hash password
            'first_name'        => $this->request->getPost('fname'),
            'last_name'         => $this->request->getPost('lname'),
            'middle_name'       => $this->request->getPost('mname'),
            'college'           => $this->request->getPost('college'),
            'birthdate'         => $this->request->getPost('bdate'),
            'birthplace'        => $this->request->getPost('bplace'),
            'email_address'     => $this->request->getPost('cspcemail'),
            'mobile_no'         => $this->request->getPost('mobile'),
            'zip_code'          => $this->request->getPost('zipcode'),
            'type_of_admission' => $this->request->getPost('admission'),
            'street_barangay'   => $this->request->getPost('street'),
            'region'            => $this->request->getPost('region'),
            'province'          => $this->request->getPost('province'),
            'municipality'      => $this->request->getPost('municipality'),
            'year_enrolled'     => $this->request->getPost('year_enrolled'),
            'year_graduated'    => $this->request->getPost('year_graduated') ?: null,
        ];

        $verificationCode = random_string('numeric', 6);

        // Store data in session
        $session->set('registration_data', $userData);
        $session->set('verification_code', $verificationCode);
        $session->set('verification_email', $userData['email_address']);

        // Send verification email
        if ($this->_sendVerificationEmail($userData['email_address'], $verificationCode)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'success', 'message' => 'Verification code sent to your email.']);
            }
            return redirect()->to('/verify-email')->with('success', 'Verification code sent to your email.');
        } else {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to send verification email.']);
            }
            return redirect()->back()->withInput()->with('error', 'Failed to send verification email.');
        }
    }

    public function showVerifyForm()
    {
        return view('verify_email_form'); // You need to create this view
    }

    public function verifyEmail()
    {
        helper(['form']);
        $session = session();

        $rules = [
            'verification_code' => 'required|exact_length[6]|numeric'
        ];

        $messages = [
            'verification_code' => [
                'required' => 'Verification code is required.',
                'exact_length' => 'Verification code must be 6 digits.',
                'numeric' => 'Verification code must be numeric.'
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'errors' => $this->validator->getErrors()]);
            }
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $enteredCode = $this->request->getPost('verification_code');
        $storedCode = $session->get('verification_code');
        $registrationData = $session->get('registration_data');
        $verificationEmail = $session->get('verification_email');

        if (!$storedCode || !$registrationData || !$verificationEmail) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Session expired or invalid request. Please try registering again.']);
            }
            return redirect()->to('/register')->with('error', 'Session expired or invalid request. Please try registering again.');
        }

        if ($enteredCode === $storedCode) {
            $userModel = new UserModel();
            if ($userModel->insert($registrationData)) {
                // Clear session data
                $session->remove(['registration_data', 'verification_code', 'verification_email']);
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON(['status' => 'success', 'message' => 'Email verified and registration successful. Please login.']);
                }
                return redirect()->to('/login')->with('success', 'Email verified and registration successful. Please login.');
            } else {
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to save user data. Please try again.']);
                }
                return redirect()->to('/register')->with('error', 'Failed to save user data. Please try again.');
            }
        } else {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid verification code.']);
            }
            return redirect()->back()->withInput()->with('error', 'Invalid verification code.');
        }
    }

    private function _sendVerificationEmail($to, $code)
    {
        $email = \Config\Services::email(); // Corrected line: removed extra backslash
        $emailConfig = new EmailConfig(); // Load the email config

        // Configuration is now primarily handled by app/Config/Email.php
        // The following are examples and might not be needed if Email.php is fully set up.
        /*
        $email->SMTPHost = 'smtp.gmail.com';
        $email->SMTPUser = 'your_email@gmail.com';
        $email->SMTPPass = 'your_gmail_password_or_app_password';
        $email->SMTPPort = 465; // Or 587 for TLS
        $email->SMTPCrypto = 'ssl'; // Or 'tls'
        $email->protocol = 'smtp';
        $email->mailType = 'html';
        $email->charset = 'utf-8';
        $email->newline = "\r\n";
        */

        $email->setTo($to);
        $email->setFrom($emailConfig->fromEmail, $emailConfig->fromName); // Use configured from email and name
        $email->setSubject('Email Verification Code');
        $email->setMessage("Your verification code is: <h1>{$code}</h1>");

        if ($email->send()) {
            return true;
        } else {
            log_message('error', $email->printDebugger(['headers'])); // Log error for debugging
            return false;
        }
    }
}
