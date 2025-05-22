<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DocumentTypeSeeder extends Seeder
{
    public function run()
    {
        // First check if there are already document types in the database
        $count = $this->db->table('document_types')->countAllResults();
        
        // Only seed if the table is empty
        if ($count === 0) {            $data = [
                [
                    'document_name' => 'Transcript of Records (TOR)',
                    'description' => 'Official academic transcript showing all courses taken and grades received',
                    'price' => 300.00,
                    'processing_days' => 5,
                    'is_active' => 1
                ],
                [
                    'document_name' => 'Certificate of Graduation',
                    'description' => 'Official document certifying that a student has completed all requirements for graduation',
                    'price' => 200.00,
                    'processing_days' => 3,
                    'is_active' => 1
                ],
                [
                    'document_name' => 'Certificate of Good Moral Character',
                    'description' => 'Document attesting to the good behavior and moral conduct of a student',
                    'price' => 150.00,
                    'processing_days' => 2,
                    'is_active' => 1
                ],
                [
                    'document_name' => 'Diploma',
                    'description' => 'Official document awarded by an educational institution testifying that the recipient has successfully completed a course of study',
                    'price' => 500.00,
                    'processing_days' => 10,
                    'is_active' => 1
                ],
                [
                    'document_name' => 'Certificate of Enrollment',
                    'description' => 'Document verifying that a student is currently enrolled in the institution',
                    'price' => 100.00,
                    'processing_days' => 1,
                    'is_active' => 1
                ]
            ];

            // Insert data into the database
            $this->db->table('document_types')->insertBatch($data);
            
            echo "Document types seeded successfully.\n";
        } else {
            echo "Document types already exist in the database. Skipping seed.\n";
        }
    }
}
