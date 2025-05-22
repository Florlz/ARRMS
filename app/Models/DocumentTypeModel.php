<?php

namespace App\Models;

use CodeIgniter\Model;

class DocumentTypeModel extends Model
{
    protected $table = 'document_types';
    protected $primaryKey = 'type_id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        "document_name",
        "description",
        "price",
        "processing_days",
        "is_active"
    ];

    protected bool $allowEmptyInserts = false;
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    // Fetch all active document types
    public function getActiveDocumentTypes()
    {
        return $this->where('is_active', 1)
                    ->findAll();
    }

    // Get a specific document type by ID
    public function getDocumentType($typeId)
    {
        return $this->find($typeId);
    }
}
