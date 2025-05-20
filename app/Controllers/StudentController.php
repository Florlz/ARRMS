<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class StudentController extends BaseController
{
    public function index()
    {
        // Show the student dashboard view
        return view('student_dashboard');
    }

    public function update()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        $session = session();
        $studentId = $session->get('student_id');
        if (!$studentId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Not logged in']);
        }

        $userModel = new UserModel();

        $data = [
            'first_name'        => $this->request->getPost('first_name'),
            'last_name'         => $this->request->getPost('last_name'),
            'middle_name'       => $this->request->getPost('middle_name'),
            'college'           => $this->request->getPost('college'),
            'birthdate'         => $this->request->getPost('birthdate'),
            'birthplace'        => $this->request->getPost('birthplace'),
            'email_address'     => $this->request->getPost('email_address'),
            'mobile_no'         => $this->request->getPost('mobile_no'),
            'zip_code'          => $this->request->getPost('zip_code'),
            'type_of_admission' => $this->request->getPost('type_of_admission'),
            'street_barangay'   => $this->request->getPost('street_barangay'),
            'region'            => $this->request->getPost('region'),
            'province'          => $this->request->getPost('province'),
            'municipality'      => $this->request->getPost('municipality'),
        ];

        // Update user in DB
        $userModel->where('student_id', $studentId)->set($data)->update();

        // Update session data
        foreach ($data as $key => $value) {
            $session->set($key, $value);
        }

        return $this->response->setJSON(['success' => true]);
    }
}
