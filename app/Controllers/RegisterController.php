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
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
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
        ];

        $userModel->insert($data);

        return redirect()->to('/')->with('success', 'Registration successful. Please login.');
    }
}
