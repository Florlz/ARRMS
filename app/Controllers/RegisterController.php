<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class RegisterController extends BaseController
{
    public function index()
    {
        return view('register_user');
    }

    public function store()
    {
        helper(['form']);

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
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Custom validation for year_graduated
        $yearEnrolled = $this->request->getPost('year_enrolled');
        $yearGraduated = $this->request->getPost('year_graduated');
        
        if (!empty($yearGraduated) && $yearGraduated < $yearEnrolled) {
            return redirect()->back()->withInput()->with('error', 'Graduation year cannot be earlier than enrollment year.');
        }

        $userModel = new UserModel();

        $data = [
            'student_id'        => $this->request->getPost('idnum'),
            'password'          => $this->request->getPost('password'),
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
            'year_graduated'    => $this->request->getPost('year_graduated') ?: null, // Store null if empty
        ];

        $userModel->insert($data);

        return redirect()->to('/')->with('success', 'Registration successful. Please login.');
    }
}
