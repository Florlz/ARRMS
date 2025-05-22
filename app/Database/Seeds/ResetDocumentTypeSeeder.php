<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ResetDocumentTypeSeeder extends Seeder
{
    public function run()
    {
        // Delete all document types
        $this->db->table('document_types')->emptyTable();
        
        echo "Document types table emptied successfully.\n";
        
        // Now run the document type seeder to add fresh data
        $seeder = \Config\Services::seeder();
        $seeder->call('DocumentTypeSeeder');
    }
}
