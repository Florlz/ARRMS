<?php

namespace App\Models;

use CodeIgniter\Model;

class RequestStatusHistoryModel extends Model
{
    protected $table = 'request_status_history';
    protected $primaryKey = 'history_id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'request_id',
        'status',
        'remarks',
        'changed_by',
        'changed_at'
    ];

    protected bool $allowEmptyInserts = false;
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    
    // Add a new status history entry
    public function addStatusHistory($requestId, $status, $remarks, $changedBy)
    {
        return $this->insert([
            'request_id' => $requestId,
            'status' => $status,
            'remarks' => $remarks,
            'changed_by' => $changedBy,
            'changed_at' => date('Y-m-d H:i:s')
        ]);
    }
    
    // Get status history for a specific request
    public function getRequestHistory($requestId)
    {
        return $this->where('request_id', $requestId)
                   ->orderBy('changed_at', 'DESC')
                   ->findAll();
    }
}
