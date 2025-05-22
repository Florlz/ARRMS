<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\DocumentTypeModel;
use App\Models\DocumentRequestModel;
use CodeIgniter\HTTP\ResponseInterface;
// Remove Endroid QR Code related imports
// use Endroid\QrCode\QrCode;
// use Endroid\QrCode\Writer\PngWriter;
// use Endroid\QrCode\Encoding\Encoding;
// use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;

// Add chillerlan/php-qrcode imports
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Dompdf\Dompdf;
use Dompdf\Options;

class StudentController extends BaseController
{
    public function index()
    {
        // Get document request stats
        $session = session();
        $studentId = $session->get('student_id');
        
        $requestModel = new DocumentRequestModel();
        $pendingCount = $requestModel->countRequestsByStatus($studentId, 'pending');
        $processingCount = $requestModel->countRequestsByStatus($studentId, 'processing');
        $completedCount = $requestModel->countRequestsByStatus($studentId, 'completed');
        
        $data = [
            'pendingCount' => $pendingCount,
            'processingCount' => $processingCount,
            'completedCount' => $completedCount
        ];
        
        // Show the student dashboard view with request counts
        return view('student_dashboard', $data);
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

        // Validate year_enrolled and year_graduated if provided
        $yearEnrolled = $this->request->getPost('year_enrolled');
        $yearGraduated = $this->request->getPost('year_graduated');

        // Basic validation rules for years
        $currentYear = date('Y');
        if (!empty($yearEnrolled)) {
            if (!is_numeric($yearEnrolled) || strlen($yearEnrolled) !== 4 || $yearEnrolled > $currentYear) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Invalid year enrolled. Must be a valid year not in the future.'
                ]);
            }
        }

        if (!empty($yearGraduated)) {
            if (!is_numeric($yearGraduated) || strlen($yearGraduated) !== 4 || $yearGraduated > $currentYear) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Invalid year graduated. Must be a valid year not in the future.'
                ]);
            }

            // Check if graduation year is after enrollment year
            if (!empty($yearEnrolled) && $yearGraduated < $yearEnrolled) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Year graduated cannot be earlier than year enrolled.'
                ]);
            }
        }

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
            'year_enrolled'     => $yearEnrolled,
            'year_graduated'    => $yearGraduated ?: null, // Store as null if empty
        ];

        // Update user in DB
        $userModel->where('student_id', $studentId)->set($data)->update();

        // Update session data
        foreach ($data as $key => $value) {
            $session->set($key, $value);
        }

        return $this->response->setJSON(['success' => true]);
    }
    
    public function getDocumentTypes()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }
        
        $documentTypeModel = new DocumentTypeModel();
        $documentTypes = $documentTypeModel->getActiveDocumentTypes();
        
        return $this->response->setJSON([
            'success' => true,
            'documentTypes' => $documentTypes
        ]);
    }
    
    public function submitRequest()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }
        
        $session = session();
        $studentId = $session->get('student_id');
        if (!$studentId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Not logged in']);
        }
        
        $rules = [
            'type_id' => 'required|numeric',
            'purpose' => 'required',
            'quantity' => 'required|numeric|greater_than[0]',
        ];
        
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }
        
        $documentTypeModel = new DocumentTypeModel();
        $documentRequestModel = new DocumentRequestModel();
        
        $typeId = $this->request->getPost('type_id');
        $documentType = $documentTypeModel->getDocumentType($typeId);
        
        if (!$documentType) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid document type selected'
            ]);
        }
        
        $quantity = $this->request->getPost('quantity');
        $isUrgent = $this->request->getPost('is_urgent') ? 1 : 0;
        $urgentFee = $isUrgent ? 100.00 : 0.00;
        $totalAmount = ($documentType['price'] * $quantity) + $urgentFee;
        
        $requestData = [
            'student_id' => $studentId,
            'type_id' => $typeId,
            'purpose' => $this->request->getPost('purpose'),
            'quantity' => $quantity,
            'total_amount' => $totalAmount,
            'payment_status' => 'pending', // Initial status
            'request_status' => 'pending', // Initial status
            'is_urgent' => $isUrgent,
            'urgent_fee' => $urgentFee,
            'processing_days' => $documentType['processing_days'],
            'notes' => $this->request->getPost('notes') ?? ''
        ];
        
        $requestId = $documentRequestModel->createRequest($requestData);
        
        if ($requestId) {
            // Calculate expected release date
            $processingDays = $documentType['processing_days'];
            if ($isUrgent) {
                $processingDays = max(1, floor($processingDays / 2)); // Half time if urgent, min 1 day
            }
            $expectedReleaseDate = date('Y-m-d', strtotime("+$processingDays days"));
            
            // Update the request with the calculated release date
            $documentRequestModel->update($requestId, ['expected_release_date' => $expectedReleaseDate]);

            // Send notification (e.g., email)
            $this->sendPaymentNotification($studentId, $requestId, $totalAmount);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Document request submitted successfully',
                'requestId' => $requestId,
                'documentName' => $documentType['document_name'],
                'quantity' => $quantity,
                'totalAmount' => $totalAmount,
                'isUrgent' => $isUrgent,
                'expectedReleaseDate' => date('F d, Y', strtotime($expectedReleaseDate)) // Format for display
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to submit document request'
            ]);
        }
    }
    
    public function getRequestStatus()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }
        
        $session = session();
        $studentId = $session->get('student_id');
        if (!$studentId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Not logged in']);
        }
        
        $requestModel = new DocumentRequestModel();
        $requests = $requestModel->getRequestsWithDetails($studentId);
        
        // Format the dates for display
        foreach ($requests as &$request) {
            $request['request_date_formatted'] = date('M d, Y', strtotime($request['request_date']));
            if (!empty($request['expected_release_date'])) {
                $request['expected_release_date_formatted'] = date('M d, Y', strtotime($request['expected_release_date']));
            } else {
                $request['expected_release_date_formatted'] = 'Not set';
            }
        }
        
        return $this->response->setJSON([
            'success' => true,
            'requests' => $requests
        ]);
    }

    public function getRequestCounts()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }
        
        $session = session();
        $studentId = $session->get('student_id');
        if (!$studentId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Not logged in']);
        }
        
        $requestModel = new DocumentRequestModel();
        $pendingCount = $requestModel->countRequestsByStatus($studentId, 'pending');
        $processingCount = $requestModel->countRequestsByStatus($studentId, 'processing');
        $completedCount = $requestModel->countRequestsByStatus($studentId, 'completed');
        
        return $this->response->setJSON([
            'success' => true,
            'pendingCount' => $pendingCount,
            'processingCount' => $processingCount,
            'completedCount' => $completedCount
        ]);
    }

    public function getReadyForPickupCount()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request.']);
        }

        $session = session();
        $studentId = $session->get('student_id');

        if (!$studentId) {
            return $this->response->setJSON(['success' => false, 'message' => 'User not logged in.']);
        }

        $requestModel = new DocumentRequestModel();
        $readyForPickupCount = $requestModel->countRequestsByStatus($studentId, 'ready'); // Ensure 'ready for pickup' matches the status string in your DB

        return $this->response->setJSON([
            'success' => true,
            'readyForPickupCount' => $readyForPickupCount
        ]);
    }
    
    public function cancelRequest()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }
        
        $session = session();
        $studentId = $session->get('student_id');
        if (!$studentId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Not logged in']);
        }
        
        $requestId = $this->request->getPost('request_id');
        $reason = $this->request->getPost('reason');
        
        if (empty($requestId) || empty($reason)) {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Request ID and cancellation reason are required'
            ]);
        }
        
        $requestModel = new DocumentRequestModel();
        $request = $requestModel->find($requestId);
        
        // Check if request exists and belongs to the student
        if (!$request || $request['student_id'] !== $studentId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Request not found or access denied'
            ]);
        }
        
        // Check if request is in a state that can be canceled
        // Usually only 'pending' requests should be allowed to be canceled
        if ($request['request_status'] !== 'pending') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Only pending requests can be canceled'
            ]);
        }
        
        // Start a database transaction
        $db = \Config\Database::connect();
        $db->transBegin();
        
        try {
            // Update the request status
            $requestModel->update($requestId, [
                'request_status' => 'canceled',
                'notes' => 'Canceled by student. Reason: ' . $reason
            ]);
            
            // Add entry to request_status_history
            // Check if RequestStatusHistoryModel exists, if not, require it
            if (!class_exists('\App\Models\RequestStatusHistoryModel')) {
                require_once APPPATH . 'Models/RequestStatusHistoryModel.php';
            }
            $historyModel = new \App\Models\RequestStatusHistoryModel();
            
            $historyModel->addStatusHistory(
                $requestId,
                'canceled',
                'Canceled by student. Reason: ' . $reason,
                $studentId
            );
            
            $db->transCommit();
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Request successfully canceled'
            ]);
        } catch (\Exception $e) {
            $db->transRollback();
            
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to cancel request: ' . $e->getMessage()
            ]);
        }
    }

    // Method to generate QR Code (adapted for chillerlan/php-qrcode)
    public function generateQRCode($requestId)
    {
        try {
            $documentRequestModel = new DocumentRequestModel();
            $requestDetails = $documentRequestModel->find($requestId);

            if (!$requestDetails) {
                log_message('error', "QR Code Generation: Request ID {$requestId} not found.");
                return $this->response->setStatusCode(404)->setBody('Request not found');
            }

            $qrData = "RequestID:{$requestId}\nStudentID:{$requestDetails['student_id']}\nStatus:{$requestDetails['payment_status']}";

            // Configure options for chillerlan/php-qrcode
            $options = new QROptions([
                'version'    => 5, // QR Code version
                'outputType' => QRCode::OUTPUT_IMAGE_PNG,
                'eccLevel'   => QRCode::ECC_L, // Error correction level: L, M, Q, H
                'scale'      => 10, // Size of the QR code
                'imageBase64' => false, // Output as raw image data
            ]);

            // Create QR code instance and render
            $qrcode = new QRCode($options);
            $imageData = $qrcode->render($qrData);

            return $this->response
                ->setHeader('Content-Type', 'image/png')
                ->setBody($imageData);

        } catch (\Throwable $e) {
            log_message('error', 'QR Code Generation Error: ' . $e->getMessage() . ' at ' . $e->getFile() . ' line ' . $e->getLine());
            return $this->response->setStatusCode(500)->setBody('Error generating QR code: ' . $e->getMessage());
        }
    }

    // Private helper method to generate PDF data
    private function _generateReceiptPdfData($requestId)
    {
        $requestModel = new DocumentRequestModel();
        $requestDetails = $requestModel->getRequestDetailsForReceipt($requestId);

        // Log the fetched details for debugging
        log_message('debug', 'Request details for PDF receipt: ' . print_r($requestDetails, true));

        if (!$requestDetails) {
            log_message('error', "PDF Generation: Receipt details not found for request ID {$requestId}.");
            return null;
        }

        $qrCodeBase64 = '';
        try {
            $qrData = "RequestID:{$requestId}\nStudentID:{$requestDetails['student_id']}\nStatus:{$requestDetails['payment_status']}";
            $options = new QROptions([
                'version'    => 5,
                'outputType' => QRCode::OUTPUT_IMAGE_PNG,
                'eccLevel'   => QRCode::ECC_L,
                'scale'      => 10, // Increased scale for larger QR code
                'imageBase64' => true,
            ]);
            $qrcode = new QRCode($options);
            $qrCodeBase64 = $qrcode->render($qrData);
        } catch (\Throwable $e) {
            log_message('error', 'Receipt QR Code Generation Error for PDF: ' . $e->getMessage() . ' at ' . $e->getFile() . ' line ' . $e->getLine());
            // Continue without QR code if generation fails
        }

        try {
            $html = view('receipt_template', [
                'request' => $requestDetails,
                'qrCodeBase64' => $qrCodeBase64
            ]);

            $dompdfOptions = new Options();
            $dompdfOptions->set('isHtml5ParserEnabled', true);
            $dompdfOptions->set('isRemoteEnabled', true); // For external resources, if any
            // $dompdfOptions->set('isPhpEnabled', true); // Usually not needed for base64 images and can be a security risk.
            $dompdfOptions->set('tempDir', WRITEPATH . 'cache'); // Ensure this directory is writable
            $dompdfOptions->set('chroot', FCPATH); // Set chroot to allow access to public assets if needed, ensure it's configured correctly for your assets.

            $dompdf = new Dompdf($dompdfOptions);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            
            return $dompdf->output(); // Return PDF data as string
        } catch (\Throwable $e) {
            log_message('error', 'PDF Generation Error (Dompdf): ' . $e->getMessage() . ' at ' . $e->getFile() . ' line ' . $e->getLine());
            return null;
        }
    }

    // Method to download PDF receipt
    public function downloadReceipt($requestId)
    {
        $pdfData = $this->_generateReceiptPdfData($requestId);

        if (!$pdfData) {
            session()->setFlashdata('error', 'Could not generate receipt PDF. Please check server logs for details.');
            return redirect()->back();
        }
        
        // Output the generated PDF to Browser for download
        // The download method handles setting Content-Type and Content-Disposition headers.
        return $this->response->download("receipt_" . $requestId . ".pdf", $pdfData);
    }

    // Placeholder for sending payment notification (e.g., email)
    protected function sendPaymentNotification($studentId, $requestId, $amount)
    {
        $email = \Config\Services::email();
        $userModel = new UserModel();
        $student = $userModel->where('student_id', $studentId)->first();

        if ($student && isset($student['email_address']) && !empty(trim($student['email_address']))) {
            $email->setTo(trim($student['email_address']));
            $email->setSubject('Document Request Submitted - ID: ' . $requestId);
            $email->setMessage(
                "Dear " . ($student['first_name'] ?? 'Student') . ",<br><br>"
                . "Your document request (ID: <strong>{$requestId}</strong>) has been successfully submitted.<br>"
                . "Total Amount Due: <strong>PHP " . number_format($amount, 2) . "</strong><br><br>"
                . "Please find your receipt attached.<br><br>"
                . "Please proceed with the payment to start the processing of your request.<br><br>"
                . "Thank you,<br>ARRMS"
            );

            // Generate PDF data for attachment
            $pdfData = $this->_generateReceiptPdfData($requestId);
            if ($pdfData) {
                $email->attach($pdfData, 'attachment', "receipt_" . $requestId . ".pdf", 'application/pdf');
            } else {
                log_message('error', "Could not generate PDF for email attachment for request ID {$requestId}.");
            }

            if (!$email->send()) {
                 log_message('error', "Email sending failed for request ID {$requestId} to student {$studentId} ({$student['email_address']}): " . $email->printDebugger(['headers', 'subject', 'body']));
            } else {
                 log_message('info', "Payment notification sent successfully with PDF attachment for request ID {$requestId} to student {$studentId} ({$student['email_address']}).");
            }
        } else {
            if (!$student) {
                log_message('warning', "Could not send payment notification for request ID {$requestId}. Student with ID '{$studentId}' not found.");
            } else if (!isset($student['email_address']) || empty(trim($student['email_address']))) {
                log_message('warning', "Could not send payment notification for request ID {$requestId}. Student ID '{$studentId}' found, but email address is missing or empty.");
            }
        }
    }
}
