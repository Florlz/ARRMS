<!DOCTYPE html>
<html>
<head>    <title>Cashier Gateway - ARRMS</title>
    <link rel="stylesheet" href="<?= base_url('css/admin_css.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/cashier_css.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <div class="sidebar-header">
                <img src="https://cdn-icons-png.flaticon.com/512/2206/2206368.png" alt="Admin">
                <h3>Administrator</h3>
                <p>Admin ID: <?= esc(session()->get('admin_id') ?? 'Admin') ?></p>
                <span class="admin-tag">Administrator</span>
            </div>
            
            <div class="nav">
                <div class="nav-item" onclick="window.location.href='<?= base_url('admin/dashboard') ?>'">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </div>
                <div class="nav-item" onclick="window.location.href='<?= base_url('admin/dashboard') ?>'">
                    <i class="fas fa-users"></i> Users
                </div>
                <div class="nav-item" onclick="window.location.href='<?= base_url('admin/dashboard') ?>'">
                    <i class="fas fa-file-alt"></i> Document Requests
                </div>
                <div class="nav-item active">
                    <i class="fas fa-cash-register"></i> Cashier Gateway
                </div>
                <div class="nav-item" onclick="window.location.href='<?= base_url('admin/dashboard') ?>'">
                    <i class="fas fa-cog"></i> Settings
                </div>
            </div>
            
            <form method="post" action="/logout">
                <button class="logout-btn"><i class="fas fa-sign-out-alt"></i> Log out</button>
            </form>
        </div>
        
        <div class="main-content">
            <div class="page-header">
                <h1><i class="fas fa-cash-register"></i> Cashier Gateway</h1>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h2>QR Code Scanner</h2>
                </div>
                <div class="card-body">
                    <p class="card-description">Scan the QR code from a student's payment receipt to process payment.</p>
                    
                    <div class="scanner-container">
                        <div id="scanner-preview"></div>
                        <div class="scanner-controls">
                            <button id="startScannerBtn" class="btn btn-primary">
                                <i class="fas fa-camera"></i> Start Scanner
                            </button>
                            <button id="stopScannerBtn" class="btn btn-secondary" disabled>
                                <i class="fas fa-stop"></i> Stop Scanner
                            </button>
                        </div>
                        
                        <div class="scanner-info">
                            <p><i class="fas fa-info-circle"></i> Please position the QR code clearly in front of the camera.</p>
                        </div>
                    </div>
                    
                    <div id="paymentDetails" class="payment-details">
                        <h3><i class="fas fa-receipt"></i> Payment Details</h3>
                        <div id="requestNotFound" style="display: none;">
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle"></i> Request not found or invalid QR code.
                            </div>
                        </div>
                        
                        <div id="requestInfo">
                            <div class="payment-row">
                                <span>Request ID:</span>
                                <span id="requestId"></span>
                            </div>
                            <div class="payment-row">
                                <span>Student:</span>
                                <span id="studentName"></span>
                            </div>
                            <div class="payment-row">
                                <span>Student ID:</span>
                                <span id="studentId"></span>
                            </div>
                            <div class="payment-row">
                                <span>Document:</span>
                                <span id="documentName"></span>
                            </div>
                            <div class="payment-row">
                                <span>Quantity:</span>
                                <span id="quantity"></span>
                            </div>
                            <div class="payment-row">
                                <span>Processing:</span>
                                <span id="processingType"></span>
                            </div>
                            <div class="payment-row">
                                <span>Date Requested:</span>
                                <span id="requestDate"></span>
                            </div>
                            <div class="payment-row">
                                <span>Payment Status:</span>
                                <span id="paymentStatus"></span>
                            </div>
                            <div class="payment-total">
                                <span>Total Amount:</span>
                                <span id="totalAmount"></span>
                            </div>
                        </div>
                        
                        <div id="paymentForm">
                            <h4>Process Payment</h4>
                            <form id="processPaymentForm">
                                <input type="hidden" id="payment_request_id" name="request_id" value="">
                                
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Payment Method:</label>
                                        <div class="payment-method-options">
                                            <div class="payment-method-option">
                                                <input type="radio" name="payment_method" id="payment_cash" value="cash" checked>
                                                <label for="payment_cash">Cash</label>
                                            </div>
                                            <div class="payment-method-option">
                                                <input type="radio" name="payment_method" id="payment_online" value="online">
                                                <label for="payment_online">Online Payment</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-row" id="referenceNumberRow" style="display: none;">
                                    <div class="form-group">
                                        <label for="reference_number">Reference Number:</label>
                                        <input type="text" id="reference_number" name="reference_number" class="form-control">
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="admin_notes">Notes (Optional):</label>
                                        <textarea id="admin_notes" name="admin_notes" class="form-control" rows="3"></textarea>
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <button type="submit" id="confirmPaymentBtn" class="btn btn-primary">
                                        <i class="fas fa-check-circle"></i> Confirm Payment
                                    </button>
                                    <button type="button" id="cancelPaymentBtn" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <div id="successMessage" class="success-message">
                        <div class="success-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h3>Payment Successful!</h3>
                        <p>The payment has been recorded and the request status has been updated.</p>
                        <button id="scanNewBtn" class="btn btn-primary">
                            <i class="fas fa-camera"></i> Scan New Payment
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const html5QrCode = new Html5Qrcode("scanner-preview");
            const startScannerBtn = document.getElementById('startScannerBtn');
            const stopScannerBtn = document.getElementById('stopScannerBtn');
            const paymentDetails = document.getElementById('paymentDetails');
            const requestNotFound = document.getElementById('requestNotFound');
            const requestInfo = document.getElementById('requestInfo');
            const paymentForm = document.getElementById('paymentForm');
            const successMessage = document.getElementById('successMessage');
            const scanNewBtn = document.getElementById('scanNewBtn');
            const processPaymentForm = document.getElementById('processPaymentForm');
            const paymentMethodCash = document.getElementById('payment_cash');
            const paymentMethodOnline = document.getElementById('payment_online');
            const referenceNumberRow = document.getElementById('referenceNumberRow');
            const cancelPaymentBtn = document.getElementById('cancelPaymentBtn');
            
            let scanning = false;
            
            // Handle payment method change
            paymentMethodCash.addEventListener('change', function() {
                referenceNumberRow.style.display = 'none';
            });
            
            paymentMethodOnline.addEventListener('change', function() {
                referenceNumberRow.style.display = 'block';
            });
            
            // Start the scanner
            startScannerBtn.addEventListener('click', function() {
                startScanner();
            });
            
            // Stop the scanner
            stopScannerBtn.addEventListener('click', function() {
                stopScanner();
            });
            
            // Cancel payment button
            cancelPaymentBtn.addEventListener('click', function() {
                resetUI();
            });
            
            // Start scan again after success
            scanNewBtn.addEventListener('click', function() {
                successMessage.style.display = 'none';
                startScanner();
            });
            
            // Process the payment form
            processPaymentForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const requestId = document.getElementById('payment_request_id').value;
                const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
                const referenceNumber = document.getElementById('reference_number').value;
                const adminNotes = document.getElementById('admin_notes').value;
                
                // Validate form if online payment selected
                if (paymentMethod === 'online' && !referenceNumber.trim()) {
                    alert('Please enter a reference number for online payments.');
                    return;
                }
                
                // Show loading state
                const submitBtn = document.getElementById('confirmPaymentBtn');
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                submitBtn.disabled = true;
                
                // Send payment data to server
                fetch('<?= base_url('admin/process-payment') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: new URLSearchParams({
                        'request_id': requestId,
                        'status': 'processing', // Update status to processing after payment
                        'payment_status': 'paid',
                        'payment_method': paymentMethod,
                        'reference_number': referenceNumber,
                        'admin_notes': adminNotes
                    })
                })
                .then(response => response.json())
                .then(data => {
                    submitBtn.innerHTML = '<i class="fas fa-check-circle"></i> Confirm Payment';
                    submitBtn.disabled = false;
                    
                    if (data.success) {
                        paymentDetails.classList.remove('active');
                        successMessage.style.display = 'block';
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    submitBtn.innerHTML = '<i class="fas fa-check-circle"></i> Confirm Payment';
                    submitBtn.disabled = false;
                    alert('An error occurred while processing the payment.');
                });
            });
            
            function startScanner() {
                if (scanning) return;
                
                resetUI();
                
                const qrConfig = { fps: 10, qrbox: { width: 250, height: 250 } };
                html5QrCode.start(
                    { facingMode: "environment" },
                    qrConfig,
                    onScanSuccess,
                    onScanError
                )
                .then(() => {
                    scanning = true;
                    startScannerBtn.disabled = true;
                    stopScannerBtn.disabled = false;
                })
                .catch(err => {
                    console.error('Error starting scanner:', err);
                    alert('Error starting scanner: ' + err);
                });
            }
            
            function stopScanner() {
                if (!scanning) return;
                
                html5QrCode.stop()
                    .then(() => {
                        scanning = false;
                        startScannerBtn.disabled = false;
                        stopScannerBtn.disabled = true;
                    })
                    .catch(err => {
                        console.error('Error stopping scanner:', err);
                    });
            }
            
            function onScanSuccess(decodedText, decodedResult) {
                // Stop scanning after successful scan
                stopScanner();
                
                // Extract request ID from QR code
                // Expected format: "RequestID:123\nStudentID:ABC123\nStatus:pending"
                let requestId = null;
                try {
                    const qrData = decodedText.split('\n');
                    for (let line of qrData) {
                        if (line.startsWith('RequestID:')) {
                            requestId = line.replace('RequestID:', '').trim();
                            break;
                        }
                    }
                } catch (e) {
                    console.error('Error parsing QR code:', e);
                }
                
                if (!requestId) {
                    requestNotFound.style.display = 'block';
                    requestInfo.style.display = 'none';
                    paymentForm.style.display = 'none';
                    paymentDetails.classList.add('active');
                    return;
                }
                
                // Fetch request details
                fetch(`<?= base_url('admin/get-request-details') ?>/${requestId}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.success || !data.request) {
                        requestNotFound.style.display = 'block';
                        requestInfo.style.display = 'none';
                        paymentForm.style.display = 'none';
                    } else {
                        const request = data.request;
                        
                        // Update payment details UI
                        document.getElementById('requestId').textContent = request.request_id;
                        document.getElementById('studentName').textContent = request.student_name || `${request.first_name} ${request.last_name}`;
                        document.getElementById('studentId').textContent = request.student_id || request.student_number;
                        document.getElementById('documentName').textContent = request.document_name;
                        document.getElementById('quantity').textContent = request.quantity;
                        document.getElementById('processingType').textContent = request.is_urgent == 1 ? 'Rush' : 'Regular';
                        document.getElementById('requestDate').textContent = request.request_date_formatted;
                        
                        // Set payment status with badge
                        const paymentStatusEl = document.getElementById('paymentStatus');
                        paymentStatusEl.textContent = request.payment_status.charAt(0).toUpperCase() + request.payment_status.slice(1);
                        paymentStatusEl.className = '';
                        paymentStatusEl.classList.add('status-badge', `status-${request.payment_status}`);
                        
                        // Set total amount
                        document.getElementById('totalAmount').textContent = `₱${parseFloat(request.total_amount).toFixed(2)}`;
                        
                        // Set hidden field for form submission
                        document.getElementById('payment_request_id').value = request.request_id;
                        
                        // Show/hide appropriate elements
                        requestNotFound.style.display = 'none';
                        requestInfo.style.display = 'block';
                        
                        // Only show payment form if payment status is pending
                        paymentForm.style.display = request.payment_status === 'pending' ? 'block' : 'none';
                        
                        if (request.payment_status === 'paid') {
                            alert('This request has already been paid.');
                        }
                    }
                    
                    // Show payment details container
                    paymentDetails.classList.add('active');
                })
                .catch(error => {
                    console.error('Error:', error);
                    requestNotFound.style.display = 'block';
                    requestInfo.style.display = 'none';
                    paymentForm.style.display = 'none';
                    paymentDetails.classList.add('active');
                });
            }
            
            function onScanError(error) {
                // Handle scan errors if needed
                console.warn('QR scan error:', error);
            }
            
            function resetUI() {
                paymentDetails.classList.remove('active');
                requestNotFound.style.display = 'none';
                successMessage.style.display = 'none';
                processPaymentForm.reset();
                referenceNumberRow.style.display = 'none';
            }
        });
    </script>
</body>
</html>
