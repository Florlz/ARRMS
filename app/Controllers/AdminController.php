<?php

namespace App\Controllers;

use App\Models\DocumentRequestModel;
use App\Models\DocumentTypeModel;
use App\Models\UserModel;
use App\Models\RequestStatusHistoryModel;

class AdminController extends BaseController
{
    protected $session;
    protected $db;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->db = \Config\Database::connect();
    }

    // Helper method for admin check for non-AJAX requests
    private function _checkAdminAndRedirect() {
        if (!$this->session->has('isAdmin') || !$this->session->get('isAdmin')) {
            return redirect()->to('/');
        }
        return null;
    }

    // Helper method for admin check for AJAX requests
    private function _checkAdminAndRespondJson() {
        if (!$this->session->has('isAdmin') || !$this->session->get('isAdmin')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unauthorized access'
            ])->setStatusCode(401);
        }
        return null;
    }

    public function index()
    {
        if ($redirect = $this->_checkAdminAndRedirect()) {
            return $redirect;
        }
        
        return $this->dashboard();
    }
    
    public function dashboard()
    {
        if ($redirect = $this->_checkAdminAndRedirect()) {
            return $redirect;
        }

        $documentTypeModel = new DocumentTypeModel();
        $documentTypes = $documentTypeModel->findAll();

        $data = [
            'documentTypes' => $documentTypes
        ];

        // Get request counts for dashboard summary
        $requestModel = new DocumentRequestModel();
        $data['pendingCount'] = $requestModel->where('request_status', 'pending')->countAllResults();
        $data['processingCount'] = $requestModel->where('request_status', 'processing')->countAllResults();
        $data['readyCount'] = $requestModel->where('request_status', 'ready')->countAllResults();
        $data['completedCount'] = $requestModel->where('request_status', 'completed')->countAllResults();
        $data['totalCount'] = $requestModel->countAllResults();
        
        // Get payment statistics
        $data['paidCount'] = $requestModel->where('payment_status', 'paid')->countAllResults();
        $data['unpaidCount'] = $requestModel->where('payment_status', 'pending')->countAllResults();
        
        // Get urgent requests count
        $data['urgentCount'] = $requestModel->where('is_urgent', 1)->countAllResults();
        
        // Get user statistics
        $userModel = new UserModel();
        $data['totalUsers'] = $userModel->countAllResults();
        
        // Get colleges for filters
        $collegesResult = $this->db->table('users')
                          ->select('college')
                          ->distinct()
                          ->get()
                          ->getResultArray();
        $data['colleges'] = array_column($collegesResult, 'college');
        
        // Get recent requests for dashboard
        $recentRequests = $this->db->table('document_requests')
                            ->select('document_requests.*, users.first_name, users.last_name, document_types.document_name')
                            ->join('users', 'users.student_id = document_requests.student_id')
                            ->join('document_types', 'document_types.type_id = document_requests.type_id')
                            ->orderBy('request_date', 'DESC')
                            ->limit(5)
                            ->get()
                            ->getResultArray();
        
        foreach ($recentRequests as &$request) {
            if (isset($request['request_date'])) {
                $request['request_date_formatted'] = date('F d, Y', strtotime($request['request_date']));
            }
            $request['student_name'] = $request['first_name'] . ' ' . $request['last_name'];
        }
        
        $data['recentRequests'] = $recentRequests;

        return view('admin_dashboard', $data);
    }

    public function getUsers()
    {
        if ($response = $this->_checkAdminAndRespondJson()) {
            return $response;
        }

        // Using UserModel instead of StudentModel to match your database structure
        $userModel = new UserModel();
        
        // Get filters from request
        $college = $this->request->getPost('college');
        $searchTerm = $this->request->getPost('search');
        $limit = $this->request->getPost('limit') ? (int)$this->request->getPost('limit') : null;
        
        $builder = $userModel->builder();
        
        // Apply filters
        if (!empty($college)) {
            $builder->where('college', $college);
        }
        
        if (!empty($searchTerm)) {
            $builder->groupStart()
                ->like('first_name', $searchTerm)
                ->orLike('last_name', $searchTerm)
                ->orLike('student_id', $searchTerm)
                ->orLike('email_address', $searchTerm)
                ->groupEnd();
        }
        
        // Order by most recently registered users first (assuming id is auto-incrementing)
        $builder->orderBy('id', 'DESC');
        
        // Apply limit if specified
        if ($limit) {
            $builder->limit($limit);
        }
        
        $users = $builder->get()->getResultArray();
        
        // Remove sensitive data like passwords
        foreach ($users as &$user) {
            if (isset($user['password'])) {
                unset($user['password']);
            }
            
            // Format date fields to be more readable
            if (isset($user['date_graduated']) && $user['date_graduated'] != '0000-00-00') {
                $user['date_graduated_formatted'] = date('F d, Y', strtotime($user['date_graduated']));
            } else {
                $user['date_graduated_formatted'] = 'Not graduated yet';
            }
            
            if (isset($user['birthdate'])) {
                $user['birthdate_formatted'] = date('F d, Y', strtotime($user['birthdate']));
            }
        }
        
        return $this->response->setJSON([
            'success' => true,
            'users' => $users
        ]);
    }
    
    public function getUserDetails($id)
    {
        if ($response = $this->_checkAdminAndRespondJson()) {
            return $response;
        }

        $userModel = new UserModel();
        $user = $userModel->find($id);
        
        if (!$user) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'User not found'
            ]);
        }
        
        // Remove sensitive data
        if (isset($user['password'])) {
            unset($user['password']);
        }
        
        // Get user's document requests
        $requestModel = new DocumentRequestModel();
        $requests = $requestModel->where('student_id', $user['student_id'])->findAll();
        
        $documentTypeModel = new DocumentTypeModel();
        // Format document requests
        foreach ($requests as &$request) {
            // Format dates
            if (isset($request['request_date'])) {
                $request['request_date_formatted'] = date('F d, Y', strtotime($request['request_date']));
            }
            
            if (isset($request['expected_release_date'])) {
                $request['expected_release_date_formatted'] = date('F d, Y', strtotime($request['expected_release_date']));
            }
            
            if (isset($request['actual_release_date']) && $request['actual_release_date']) {
                $request['actual_release_date_formatted'] = date('F d, Y', strtotime($request['actual_release_date']));
            }
            
            // Get document name
            $documentType = $documentTypeModel->find($request['type_id']);
            $request['document_name'] = $documentType ? $documentType['document_name'] : 'Unknown';
            
            // Get payment information if available
            $paymentInfo = $this->db->table('payments')
                                  ->where('request_id', $request['request_id'])
                                  ->get()
                                  ->getRowArray();
            
            if ($paymentInfo) {
                $request['payment_info'] = $paymentInfo;
                
                if (isset($paymentInfo['payment_date'])) {
                    $request['payment_info']['payment_date_formatted'] = date('F d, Y', strtotime($paymentInfo['payment_date']));
                }
            }
        }
        
        return $this->response->setJSON([
            'success' => true,
            'user' => $user,
            'requests' => $requests
        ]);
    }
    
    public function getRequests()
    {
        if ($response = $this->_checkAdminAndRespondJson()) {
            return $response;
        }
        
        // Get filters from request
        $status = $this->request->getPost('status');
        $typeId = $this->request->getPost('type_id');
        $isUrgent = $this->request->getPost('is_urgent');
        $paymentStatus = $this->request->getPost('payment_status');
        $searchTerm = $this->request->getPost('search');
        $college = $this->request->getPost('college');
        
        $requestModel = new DocumentRequestModel();
        $builder = $requestModel->builder();
        
        // Join with users table to get user info
        $builder->select('document_requests.*, users.first_name, users.last_name, users.student_id as student_number, users.college,users.email_address, document_types.document_name, document_types.processing_days')
                ->join('users', 'users.student_id = document_requests.student_id')
                ->join('document_types', 'document_types.type_id = document_requests.type_id');
        
        // Apply filters
        if (!empty($status)) {
            $builder->where('document_requests.request_status', $status);
        }
        
        if (!empty($typeId)) {
            $builder->where('document_requests.type_id', $typeId);
        }
        
        if ($isUrgent !== null && $isUrgent !== '') {
            $builder->where('document_requests.is_urgent', $isUrgent);
        }
        
        if (!empty($paymentStatus)) {
            $builder->where('document_requests.payment_status', $paymentStatus);
        }
        
        if (!empty($college)) {
            $builder->where('users.college', $college);
        }
        
        if (!empty($searchTerm)) {
            $builder->groupStart()
                ->like('users.first_name', $searchTerm)
                ->orLike('users.last_name', $searchTerm)
                ->orLike('users.student_id', $searchTerm)
                ->orLike('document_types.document_name', $searchTerm)
                ->orLike('document_requests.request_id', $searchTerm)
                ->groupEnd();
        }
        
        // Order by most recent
        $builder->orderBy('document_requests.request_date', 'DESC');
        
        $requests = $builder->get()->getResultArray();
        
        // Format data for display
        foreach ($requests as &$request) {
            // Format dates
            if (isset($request['request_date'])) {
                $request['request_date_formatted'] = date('F d, Y', strtotime($request['request_date']));
            }
            
            if (isset($request['expected_release_date'])) {
                $request['expected_release_date_formatted'] = date('F d, Y', strtotime($request['expected_release_date']));
            }
            
            if (isset($request['actual_release_date']) && $request['actual_release_date']) {
                $request['actual_release_date_formatted'] = date('F d, Y', strtotime($request['actual_release_date']));
            }
            
            // Format student name
            $request['student_name'] = $request['first_name'] . ' ' . $request['last_name'];
            
            // Get payment information
            $paymentInfo = $this->db->table('payments')
                                  ->where('request_id', $request['request_id'])
                                  ->get()
                                  ->getRowArray();
            
            if ($paymentInfo) {
                $request['payment_info'] = $paymentInfo;
                
                if (isset($paymentInfo['payment_date'])) {
                    $request['payment_info']['payment_date_formatted'] = date('F d, Y', strtotime($paymentInfo['payment_date']));
                }
            }
        }
        
        return $this->response->setJSON([
            'success' => true,
            'requests' => $requests
        ]);
    }

    public function getRequestCounts()
    {
        if ($response = $this->_checkAdminAndRespondJson()) {
            return $response;
        }
        
        $requestModel = new DocumentRequestModel();
        
        $data = [
            'success' => true,
            'pendingCount' => $requestModel->where('request_status', 'pending')->countAllResults(),
            'processingCount' => $requestModel->where('request_status', 'processing')->countAllResults(),
            'readyCount' => $requestModel->where('request_status', 'ready')->countAllResults(),
            'completedCount' => $requestModel->where('request_status', 'completed')->countAllResults(),
            'totalCount' => $requestModel->countAllResults()
        ];
        
        return $this->response->setJSON($data);
    }
    
    public function updateRequestStatus()
    {
        if ($response = $this->_checkAdminAndRespondJson()) {
            return $response;
        }
        
        $requestId = $this->request->getPost('request_id');
        $status = $this->request->getPost('status');
        $notes = $this->request->getPost('admin_notes');
        $paymentStatus = $this->request->getPost('payment_status');
        
        // Validate input
        if (empty($requestId) || empty($status)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Missing required fields'
            ]);
        }
        
        // Check if status is valid
        $validStatuses = ['pending', 'processing', 'ready', 'completed', 'declined', 'canceled'];
        if (!in_array($status, $validStatuses)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid status'
            ]);
        }
        
        $requestModel = new DocumentRequestModel();
        $request = $requestModel->find($requestId);
        
        if (!$request) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Request not found'
            ]);
        }
        
        // Start a transaction
        $this->db->transBegin();
        
        try {
            // Update status and admin notes
            $data = [
                'request_status' => $status,
                'notes' => $notes
            ];
            
            // Update payment status if provided
            if (!empty($paymentStatus) && in_array($paymentStatus, ['pending', 'paid', 'refunded'])) {
                $data['payment_status'] = $paymentStatus;
            }
            
            if ($status === 'completed') {
                $data['actual_release_date'] = date('Y-m-d');
            }
            
            $requestModel->update($requestId, $data);
            
            // Add entry to request_status_history
            $historyModel = new RequestStatusHistoryModel();
            
            $adminId = $this->session->get('admin_id') ?? 'admin';
            $historyModel->addStatusHistory(
                $requestId, 
                $status, 
                $notes, 
                $adminId
            );
            
            // If payment status is being updated to 'paid', update or create a payment record
            if (!empty($paymentStatus) && $paymentStatus === 'paid') {
                $paymentMethod = $this->request->getPost('payment_method');
                $referenceNumber = $this->request->getPost('reference_number');
                
                // Check if payment record exists
                $existingPayment = $this->db->table('payments')
                                         ->where('request_id', $requestId)
                                         ->get()
                                         ->getRowArray();
                
                if ($existingPayment) {
                    // Update existing payment
                    $this->db->table('payments')
                         ->where('payment_id', $existingPayment['payment_id'])
                         ->update([
                            'amount' => $request['total_amount'],
                            'payment_method' => $paymentMethod ?? $existingPayment['payment_method'],
                            'reference_number' => $referenceNumber ?? $existingPayment['reference_number'],
                            'payment_date' => date('Y-m-d H:i:s'),
                            'received_by' => $adminId
                         ]);
                } else {
                    // Create new payment record
                    $this->db->table('payments')->insert([
                        'request_id' => $requestId,
                        'amount' => $request['total_amount'],
                        'payment_method' => $paymentMethod ?? 'cash',
                        'reference_number' => $referenceNumber ?? null,
                        'payment_date' => date('Y-m-d H:i:s'),
                        'received_by' => $adminId
                    ]);
                }
            }
            
            // Commit the transaction
            $this->db->transCommit();
            
            // Get updated request with history
            $updatedRequest = $requestModel->find($requestId);
            $requestHistory = $historyModel->getRequestHistory($requestId);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Request status updated successfully',
                'request' => $updatedRequest,
                'history' => $requestHistory
            ]);
            
        } catch (\Exception $e) {
            // Rollback transaction on error
            $this->db->transRollback();
            
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error updating request status: ' . $e->getMessage()
            ]);
        }
    }
    
    public function getRequestHistory($requestId = null)
    {
        if ($response = $this->_checkAdminAndRespondJson()) {
            return $response;
        }
        
        if (!$requestId) {
            $requestId = $this->request->getGet('request_id');
        }
        
        if (!$requestId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Request ID is required'
            ]);
        }
        
        // Load the history model
        $historyModel = new RequestStatusHistoryModel();
        $history = $historyModel->getRequestHistory($requestId);
        
        // Format the data for display
        foreach ($history as &$entry) {
            if (isset($entry['changed_at'])) {
                $entry['changed_at_formatted'] = date('F d, Y h:i A', strtotime($entry['changed_at']));
            }
        }
        
        return $this->response->setJSON([
            'success' => true,
            'history' => $history
        ]);
    }
    
    public function getDocumentTypes()
    {
        if ($response = $this->_checkAdminAndRespondJson()) {
            return $response;
        }
        
        $documentTypeModel = new DocumentTypeModel();
        $documentTypes = $documentTypeModel->findAll();
        
        return $this->response->setJSON([
            'success' => true,
            'documentTypes' => $documentTypes
        ]);
    }
    
    public function getColleges()
    {
        if ($response = $this->_checkAdminAndRespondJson()) {
            return $response;
        }
        
        // Get unique colleges from the users table
        $colleges = $this->db->table('users')
                          ->select('college')
                          ->distinct()
                          ->get()
                          ->getResultArray();
        
        // Format the colleges as a simple array
        $collegeList = array_column($colleges, 'college');
        
        return $this->response->setJSON([
            'success' => true,
            'colleges' => $collegeList
        ]);
    }
    
    public function getDashboardSummary() 
    {
        if ($response = $this->_checkAdminAndRespondJson()) {
            return $response;
        }
        
        $requestModel = new DocumentRequestModel();
        $userModel = new UserModel();
        
        // Request statistics
        $requestStats = [
            'pending' => $requestModel->where('request_status', 'pending')->countAllResults(),
            'processing' => $requestModel->where('request_status', 'processing')->countAllResults(),
            'ready' => $requestModel->where('request_status', 'ready')->countAllResults(),
            'completed' => $requestModel->where('request_status', 'completed')->countAllResults(),
            'total' => $requestModel->countAllResults()
        ];
        
        // Payment statistics
        $paymentStats = [
            'paid' => $requestModel->where('payment_status', 'paid')->countAllResults(),
            'pending' => $requestModel->where('payment_status', 'pending')->countAllResults(),
            'refunded' => $requestModel->where('payment_status', 'refunded')->countAllResults()
        ];
        
        // Urgency statistics
        $urgencyStats = [
            'urgent' => $requestModel->where('is_urgent', 1)->countAllResults(),
            'regular' => $requestModel->where('is_urgent', 0)->countAllResults()
        ];
        
        // Get total amount of payments received
        $totalPayments = $this->db->table('payments')
                               ->selectSum('amount')
                               ->get()
                               ->getRowArray();
        
        // Get user statistics
        $userStats = [
            'total' => $userModel->countAllResults()
        ];
        
        // College breakdown
        $collegeBreakdown = $this->db->table('users')
                                  ->select('college, COUNT(*) as count')
                                  ->groupBy('college')
                                  ->get()
                                  ->getResultArray();
        
        // Document type breakdown
        $documentTypeBreakdown = $this->db->table('document_requests')
                                      ->select('document_types.document_name, COUNT(*) as count')
                                      ->join('document_types', 'document_types.type_id = document_requests.type_id')
                                      ->groupBy('document_requests.type_id')
                                      ->get()
                                      ->getResultArray();
                                      
        // Recent activity - last 5 status changes
        $recentActivity = $this->db->table('request_status_history')
                                 ->select('request_status_history.*, document_requests.student_id, users.first_name, users.last_name')
                                 ->join('document_requests', 'document_requests.request_id = request_status_history.request_id')
                                 ->join('users', 'users.student_id = document_requests.student_id')
                                 ->orderBy('changed_at', 'DESC')
                                 ->limit(5)
                                 ->get()
                                 ->getResultArray();
                                 
        foreach ($recentActivity as &$activity) {
            $activity['student_name'] = $activity['first_name'] . ' ' . $activity['last_name'];
            $activity['changed_at_formatted'] = date('F d, Y h:i A', strtotime($activity['changed_at']));
        }
        
        return $this->response->setJSON([
            'success' => true,
            'requestStats' => $requestStats,
            'paymentStats'   => $paymentStats,
            'urgencyStats' => $urgencyStats,
            'totalPayments' => $totalPayments['amount'] ?? 0,
            'userStats' => $userStats,
            'collegeBreakdown' => $collegeBreakdown,
            'documentTypeBreakdown' => $documentTypeBreakdown,
            'recentActivity' => $recentActivity
        ]);
    }

    public function cashierGateway()
    {
        if ($redirect = $this->_checkAdminAndRedirect()) {
            return $redirect;
        }
        
        return view('cashier_gateway');
    }

    public function getRequestDetailsById($requestId)
    {
        if ($response = $this->_checkAdminAndRespondJson()) {
            return $response;
        }
        
        $requestModel = new DocumentRequestModel();
        
        // Join with users table to get user info and document types
        $request = $this->db->table('document_requests')
                ->select('document_requests.*, users.first_name, users.last_name, users.student_id as student_number, document_types.document_name, document_types.processing_days')
                ->join('users', 'users.student_id = document_requests.student_id')
                ->join('document_types', 'document_types.type_id = document_requests.type_id')
                ->where('document_requests.request_id', $requestId)
                ->get()
                ->getRowArray();
                
        if (!$request) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Request not found'
            ]);
        }
        
        // Format dates for display
        if (isset($request['request_date'])) {
            $request['request_date_formatted'] = date('F d, Y', strtotime($request['request_date']));
        }
        
        if (isset($request['expected_release_date'])) {
            $request['expected_release_date_formatted'] = date('F d, Y', strtotime($request['expected_release_date']));
        }
        
        // Format student name
        $request['student_name'] = $request['first_name'] . ' ' . $request['last_name'];
        
        return $this->response->setJSON([
            'success' => true,
            'request' => $request
        ]);
    }

    public function processPayment()
    {
        if ($response = $this->_checkAdminAndRespondJson()) {
            return $response;
        }
        
        $requestId = $this->request->getPost('request_id');
        $status = $this->request->getPost('status');
        $paymentStatus = $this->request->getPost('payment_status');
        $paymentMethod = $this->request->getPost('payment_method');
        $referenceNumber = $this->request->getPost('reference_number');
        $adminNotes = $this->request->getPost('admin_notes');
        
        // Validate input
        if (empty($requestId)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Request ID is required'
            ]);
        }
        
        if (empty($paymentStatus) || $paymentStatus !== 'paid') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid payment status'
            ]);
        }
        
        $requestModel = new DocumentRequestModel();
        $request = $requestModel->find($requestId);
        
        if (!$request) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Request not found'
            ]);
        }
        
        // Check if payment is already marked as paid
        if ($request['payment_status'] === 'paid') {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'This request has already been paid'
            ]);
        }
        
        // Start a transaction
        $this->db->transBegin();
        
        try {
            // Update payment status and request status if provided
            $data = [
                'payment_status' => 'paid'
            ];
            
            // Update status if provided and valid
            if (!empty($status) && in_array($status, ['pending', 'processing', 'ready', 'completed'])) {
                $data['request_status'] = $status;
            }
            
            // Add admin notes if provided
            if (!empty($adminNotes)) {
                $data['notes'] = $adminNotes;
            }
            
            $requestModel->update($requestId, $data);
            
            // Add entry to request_status_history for both payment and status change
            $historyModel = new RequestStatusHistoryModel();
            
            $adminId = $this->session->get('admin_id') ?? 'admin';
            
            // Add payment status change history
            $historyModel->addStatusHistory(
                $requestId,
                'payment_received',
                'Payment received via ' . $paymentMethod . ($referenceNumber ? ' (Ref: ' . $referenceNumber . ')' : ''),
                $adminId
            );
            
            // Add request status change history if status was updated
            if (isset($data['request_status'])) {
                $historyModel->addStatusHistory(
                    $requestId,
                    $data['request_status'],
                    $adminNotes ?? ('Status updated to ' . $data['request_status'] . ' by cashier.'),
                    $adminId
                );
            }
            
            // Create payment record
            $this->db->table('payments')->insert([
                'request_id' => $requestId,
                'amount' => $request['total_amount'],
                'payment_method' => $paymentMethod ?? 'cash',
                'reference_number' => $referenceNumber ?? null,
                'payment_date' => date('Y-m-d H:i:s'),
                'received_by' => $adminId
            ]);
            
            // Commit the transaction
            $this->db->transCommit();
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Payment processed successfully.',
                'request_id' => $requestId
            ]);
            
        } catch (\Exception $e) {
            // Rollback transaction on error
            $this->db->transRollback();
            
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error processing payment: ' . $e->getMessage()
            ]);
        }
    }
}
