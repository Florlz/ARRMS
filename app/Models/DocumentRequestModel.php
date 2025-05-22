<?php

namespace App\Models;

use CodeIgniter\Model;

class DocumentRequestModel extends Model
{
    protected $table = 'document_requests';
    protected $primaryKey = 'request_id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        "student_id",
        "type_id",
        "purpose",
        "quantity",
        "total_amount",
        "payment_status",
        "request_status",
        "is_urgent",
        "urgent_fee",
        "expected_release_date",
        "actual_release_date",
        "notes"
    ];

    protected bool $allowEmptyInserts = false;
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    // Get all requests for a specific student
    public function getStudentRequests($studentId)
    {
        return $this->where('student_id', $studentId)
                    ->orderBy('request_date', 'DESC')
                    ->findAll();
    }
    
    // Get requests with joined document type information
    public function getRequestsWithDetails($studentId)
    {
        return $this->select('document_requests.*, document_types.document_name, document_types.processing_days')
                    ->join('document_types', 'document_types.type_id = document_requests.type_id')
                    ->where('document_requests.student_id', $studentId)
                    ->orderBy('document_requests.request_date', 'DESC')
                    ->findAll();
    }
    
    // Count requests by status for a student
    public function countRequestsByStatus($studentId, $status)
    {
        return $this->where('student_id', $studentId)
                    ->where('request_status', $status)
                    ->countAllResults();
    }
    
    // Create a new document request
    public function createRequest($data)
    {
        // Calculate expected release date based on processing days and urgency
        if (isset($data['processing_days'])) {
            $processingDays = $data['processing_days'];
            if (isset($data['is_urgent']) && $data['is_urgent']) {
                $processingDays = max(1, floor($processingDays / 2)); // Urgent requests are processed in half the time
            }
            
            $data['expected_release_date'] = date('Y-m-d', strtotime("+$processingDays days"));
            
            // Remove processing_days as it's not in the table
            unset($data['processing_days']);
        }
        
        return $this->insert($data);
    }

    public function getRequestDetailsForReceipt($requestId)
    {
        return $this->select('document_requests.*, document_types.document_name, users.first_name as student_first_name, users.middle_name as student_middle_name, users.last_name as student_last_name')
                    ->join('document_types', 'document_types.type_id = document_requests.type_id')
                    ->join('users', 'users.student_id = document_requests.student_id')
                    ->where('document_requests.request_id', $requestId)
                    ->first();
    }
}
