<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="<?= base_url('css/student_css.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<?php $session = session(); ?>

<div class="container">
    <div class="sidebar">
        <div class="sidebar-header">
            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="User">
            <h3><?= esc($session->get('first_name') . ' ' . $session->get('last_name')) ?></h3>
            <p>Student ID: <?= esc($session->get('student_id')) ?></p>
            <span class="college-tag"><?= esc($session->get('college')) ?></span>
        </div>
        
        <div class="nav">
            <div class="nav-item active" data-page="profile">
                <i class="fas fa-user"></i> Profile
            </div>
            <div class="nav-item" data-page="request">
                <i class="fas fa-file-export"></i> Request Documents
            </div>
            <div class="nav-item" data-page="status">
                <i class="fas fa-clipboard-list"></i> Request Status
            </div>
        </div>
        
        <form method="post" action="/logout">
            <button class="logout-btn"><i class="fas fa-sign-out-alt"></i> Log out</button>
        </form>
    </div>

    <div class="main-content">
        <div class="dashboard-header">
            <h1>Student Dashboard</h1>
            <div id="pickupNotificationContainer" style="position: absolute; top: 20px; right: 20px; z-index: 1000;"></div>
            <div class="date-time"><?= date('F d, Y') ?></div>
        </div>
          <div class="dashboard-summary">
            <div class="summary-card">
                <i class="fas fa-check-circle"></i>
                <h3>Completed Requests</h3>
                <p class="stats"><?= isset($completedCount) ? $completedCount : '0' ?></p>
            </div>
            <div class="summary-card">
                <i class="fas fa-clock"></i>
                <h3>Pending Requests</h3>
                <p class="stats"><?= isset($pendingCount) ? $pendingCount : '0' ?></p>
            </div>
            <div class="summary-card">
                <i class="fas fa-cog"></i>
                <h3>Processing Requests</h3>
                <p class="stats"><?= isset($processingCount) ? $processingCount : '0' ?></p>
            </div>
        </div>

        <div class="page-content" id="profilePage">
            <div class="card">
                <div class="card-header">
                    <h2><i class="fas fa-user-circle"></i> Profile Information</h2>
                    <button type="button" id="editBtn" class="btn btn-icon"><i class="fas fa-edit"></i> Edit</button>
                </div>
                
                <div class="card-body">
                    <div id="profileDisplay">
                        <div class="profile-section">
                            <h4>Personal Information</h4>
                            <div class="profile-grid">
                                <div class="profile-row"><strong>First Name:</strong> <?= esc($session->get('first_name')) ?></div>
                                <div class="profile-row"><strong>Last Name:</strong> <?= esc($session->get('last_name')) ?></div>
                                <div class="profile-row"><strong>Middle Name:</strong> <?= esc($session->get('middle_name')) ?></div>
                                <div class="profile-row"><strong>Birthdate:</strong> <?= esc($session->get('birthdate')) ?></div>
                                <div class="profile-row"><strong>Birthplace:</strong> <?= esc($session->get('birthplace')) ?></div>
                            </div>
                        </div>
                        
                        <div class="profile-section">
                            <h4>Academic Information</h4>
                            <div class="profile-grid">
                                <div class="profile-row"><strong>ID Number:</strong> <?= esc($session->get('student_id')) ?></div>
                                <div class="profile-row"><strong>Type of Admission:</strong> <?= esc($session->get('type_of_admission')) ?></div>
                                <div class="profile-row"><strong>College:</strong> <?= esc($session->get('college')) ?></div>
                                <div class="profile-row"><strong>Year Enrolled:</strong> <?= esc($session->get('year_enrolled')) ?></div>
                                <div class="profile-row"><strong>Year Graduated:</strong> <?= esc($session->get('year_graduated') ?: 'N/A') ?></div>
                            </div>
                        </div>
                        
                        <div class="profile-section">
                            <h4>Contact Information</h4>
                            <div class="profile-grid">
                                <div class="profile-row"><strong>Email Address:</strong> <?= esc($session->get('email_address')) ?></div>
                                <div class="profile-row"><strong>Mobile No.:</strong> <?= esc($session->get('mobile_no')) ?></div>
                            </div>
                        </div>
                        
                        <div class="profile-section">
                            <h4>Address Information</h4>
                            <div class="profile-grid">
                                <div class="profile-row"><strong>Street/Barangay:</strong> <?= esc($session->get('street_barangay')) ?></div>
                                <div class="profile-row"><strong>City/Municipality:</strong> <?= esc($session->get('municipality')) ?></div>
                                <div class="profile-row"><strong>Province:</strong> <?= esc($session->get('province')) ?></div>
                                <div class="profile-row"><strong>Region:</strong> <?= esc($session->get('region')) ?></div>
                                <div class="profile-row"><strong>Zip Code:</strong> <?= esc($session->get('zip_code')) ?></div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit form, hidden by default -->
                    <form id="editProfileForm" style="display:none;">
                        <!-- Personal Information -->
                        <div class="form-section">
                            <h4>Personal Information</h4>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" name="first_name" value="<?= esc($session->get('first_name')) ?>">
                                </div>
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" name="last_name" value="<?= esc($session->get('last_name')) ?>">
                                </div>
                                <div class="form-group">
                                    <label>Middle Name</label>
                                    <input type="text" name="middle_name" value="<?= esc($session->get('middle_name')) ?>">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Birthdate</label>
                                    <input type="date" name="birthdate" value="<?= esc($session->get('birthdate')) ?>">
                                </div>
                                <div class="form-group">
                                    <label>Birthplace</label>
                                    <input type="text" name="birthplace" value="<?= esc($session->get('birthplace')) ?>">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Academic Information -->
                        <div class="form-section">
                            <h4>Academic Information</h4>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>ID Number</label>
                                    <input type="text" name="student_id" value="<?= esc($session->get('student_id')) ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Type of Admission</label>
                                    <input type="text" name="type_of_admission" value="<?= esc($session->get('type_of_admission')) ?>">
                                </div>
                                <div class="form-group">
                                    <label>College</label>
                                    <input type="text" name="college" value="<?= esc($session->get('college')) ?>">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Year Enrolled</label>
                                    <input type="number" name="year_enrolled" value="<?= esc($session->get('year_enrolled')) ?>" placeholder="YYYY">
                                </div>
                                <div class="form-group">
                                    <label>Year Graduated</label>
                                    <input type="number" name="year_graduated" value="<?= esc($session->get('year_graduated')) ?>" placeholder="YYYY (if applicable)">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Contact Information -->
                        <div class="form-section">
                            <h4>Contact Information</h4>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input type="email" name="email_address" value="<?= esc($session->get('email_address')) ?>">
                                </div>
                                <div class="form-group">
                                    <label>Mobile No.</label>
                                    <input type="text" name="mobile_no" value="<?= esc($session->get('mobile_no')) ?>">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Address Information -->
                        <div class="form-section">
                            <h4>Address Information</h4>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Street/Barangay</label>
                                    <input type="text" name="street_barangay" value="<?= esc($session->get('street_barangay')) ?>">
                                </div>
                                <div class="form-group">
                                    <label>City/Municipality</label>
                                    <input type="text" name="municipality" value="<?= esc($session->get('municipality')) ?>">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Province</label>
                                    <input type="text" name="province" value="<?= esc($session->get('province')) ?>">
                                </div>
                                <div class="form-group">
                                    <label>Region</label>
                                    <input type="text" name="region" value="<?= esc($session->get('region')) ?>">
                                </div>
                                <div class="form-group">
                                    <label>Zip Code</label>
                                    <input type="text" name="zip_code" value="<?= esc($session->get('zip_code')) ?>">
                                </div>
                            </div>
                        </div>
                        
                        <div class="button-row">
                            <button type="button" id="cancelEditBtn" class="btn btn-discard"><i class="fas fa-times"></i> Cancel</button>
                            <button type="submit" class="btn btn-save"><i class="fas fa-check"></i> Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Other pages (hidden by default) -->        
        <div class="page-content" id="requestPage" style="display:none;">
            <div class="card">
                <div class="card-header">
                    <h2><i class="fas fa-file-export"></i> Request Documents</h2>
                </div>
                <div class="card-body">
                    <form id="documentRequestForm" style="width: 100%;">
                        <div class="form-section document-form-container">
                            <div class="document-form-left">
                                <h4><i class="fas fa-file-alt"></i> Document Information</h4>
                                <div class="form-group styled-select">
                                    <label for="document_type">Document Type <span class="required">*</span></label>
                                    <div class="select-wrapper">
                                        <select name="type_id" id="document_type" required>
                                            <option value="">-- Select Document Type --</option>
                                        </select>
                                        <i class="fas fa-chevron-down select-arrow"></i>
                                    </div>
                                </div>
                                <div class="document-details" id="documentDetails"></div>
                                <div class="form-group styled-select">
                                    <label for="document_purpose">Purpose of Request <span class="required">*</span></label>
                                    <div class="select-wrapper">
                                        <select name="purpose" id="document_purpose" required>
                                            <option value="">-- Select Purpose --</option>
                                            <option value="Employment">Employment</option>
                                            <option value="Further Studies">Further Studies</option>
                                            <option value="Scholarship Application">Scholarship Application</option>
                                            <option value="Transfer to Another School">Transfer to Another School</option>
                                            <option value="Board Exam Application">Board Exam Application</option>
                                            <option value="Other">Other</option>
                                        </select>
                                        <i class="fas fa-chevron-down select-arrow"></i>
                                    </div>
                                </div>
                                <div class="form-group" id="otherPurposeGroup" style="display: none;">
                                    <label for="other_purpose">Specify Other Purpose <span class="required">*</span></label>
                                    <input type="text" name="other_purpose" id="other_purpose" class="styled-input">
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="document_quantity">Quantity <span class="required">*</span></label>
                                        <div class="quantity-control">
                                            <button type="button" class="quantity-btn" id="decrementQuantity">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <input type="number" name="quantity" id="document_quantity" min="1" value="1" required>
                                            <button type="button" class="quantity-btn" id="incrementQuantity">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="fancy-checkbox">
                                        <input type="checkbox" name="is_urgent" id="urgent_request" value="1">
                                        <label for="urgent_request">
                                            <span class="checkbox-icon"><i class="fas fa-bolt"></i></span>
                                            Rush Processing (+₱100.00)
                                            <span class="badge-rush">Express</span>
                                        </label>
                                    </div>
                                    <small class="form-hint"><i class="fas fa-info-circle"></i> Selecting this option will reduce processing time by half.</small>
                                </div>
                                <div class="form-group">
                                    <label for="request_notes">Additional Notes (Optional)</label>
                                    <textarea name="notes" id="request_notes" rows="3" class="styled-textarea" placeholder="Any specific details about your request..."></textarea>
                                </div>
                            </div>
                            <div class="document-form-right">
                                <div class="payment-card">
                                    <div class="payment-header">
                                        <h4><i class="fas fa-receipt"></i> Payment Summary</h4>
                                    </div>
                                    <div class="payment-body">
                                        <div class="payment-row">
                                            <span>Document Fee:</span>
                                            <span id="documentFee">₱0.00</span>
                                        </div>
                                        <div class="payment-row">
                                            <span>Quantity:</span>
                                            <span id="quantityDisplay">1</span>
                                        </div>
                                        <div class="payment-row">
                                            <span>Rush Processing Fee:</span>
                                            <span id="urgentFee">₱0.00</span>
                                        </div>
                                        <div class="payment-divider"></div>
                                        <div class="payment-row total">
                                            <span>Total Amount:</span>
                                            <span id="totalAmount">₱0.00</span>
                                        </div>
                                    </div>
                                    <div class="payment-footer">
                                        <div class="form-notice">
                                            <p><i class="fas fa-shield-alt"></i> By submitting this request, you agree to pay the corresponding fees.</p>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-block">
                                            <i class="fas fa-paper-plane"></i> Submit Request
                                        </button>
                                    </div>
                                </div>
                                <div class="payment-methods">
                                    <h5>Accepted Payment Methods</h5>
                                    <div class="payment-icons">
                                        <i class="fab fa-cc-visa"></i>
                                        <i class="fab fa-cc-mastercard"></i>
                                        <i class="fab fa-paypal"></i>
                                        <i class="fas fa-money-bill-wave"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="page-content" id="statusPage" style="display:none;">
            <div class="card">
                <div class="card-header">
                    <h2><i class="fas fa-clipboard-list"></i> Request Status</h2>
                    <button type="button" id="refreshStatusBtn" class="btn btn-icon"><i class="fas fa-sync-alt"></i> Refresh</button>
                </div>
                <div class="card-body">                    <div class="status-filter">
                        <button class="status-filter-btn active" data-status="all">All</button>
                        <button class="status-filter-btn" data-status="pending">Pending</button>
                        <button class="status-filter-btn" data-status="processing">Processing</button>
                        <button class="status-filter-btn" data-status="ready">Ready for Pickup</button>
                        <button class="status-filter-btn" data-status="completed">Completed</button>
                        <button class="status-filter-btn" data-status="declined">Declined</button>
                        <button class="status-filter-btn" data-status="canceled">Canceled</button>
                    </div>
                    
                    <div id="requestStatusList" class="request-list">
                        <div class="empty-state">
                            <i class="fas fa-search"></i>
                            <p>No requests found</p>
                            <small>Start by requesting a document</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal-bg" id="editModal">
    <div class="modal-content">
        <h3><i class="fas fa-edit"></i> Edit Mode</h3>
        <p>You can now edit your details. Click "Save Changes" to update or "Cancel" to discard changes.</p>
        <button id="closeModalBtn">OK</button>
    </div>
</div>

<!-- Cancellation Modal -->
<div class="modal-bg" id="cancellationModal">
    <div class="modal-content">
        <div class="modal-close-btn">
            <i class="fas fa-times" id="closeCancelModalBtn"></i>
        </div>
        <div class="modal-header">
            <h3><i class="fas fa-times-circle"></i> Cancel Document Request</h3>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to cancel this document request?</p>
            <p>Please provide a reason for cancellation:</p>
            <form id="cancellationForm">
                <input type="hidden" id="cancelRequestId" name="request_id">
                <div class="form-group">
                    <textarea id="cancellationReason" name="reason" class="styled-textarea" rows="3" required placeholder="Enter your reason for cancellation..."></textarea>
                </div>
                <div class="button-row">
                    <button type="button" id="cancelCancellationBtn" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Go Back</button>
                    <button type="submit" class="btn btn-cancel"><i class="fas fa-times-circle"></i> Confirm Cancellation</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Payment Confirmation Modal -->
<div class="modal-bg" id="paymentConfirmationModal">
    <div class="modal-content payment-confirmation-modal">
        <div class="modal-close-btn">
            <i class="fas fa-times" id="closePaymentModalBtn"></i>
        </div>
        <div class="payment-success-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <h3>Payment Confirmation</h3>
        <p>Your document request has been successfully submitted!</p>
        
        <div class="payment-receipt">
            <div class="receipt-header">
                <h4>Receipt Details</h4>
                <div class="receipt-date" id="receiptDate"></div>
            </div>
            
            <div class="receipt-body">
                <div class="receipt-row">
                    <span>Request ID:</span>
                    <span id="receiptRequestId"></span>
                </div>
                <div class="receipt-row">
                    <span>Document:</span>
                    <span id="receiptDocumentName"></span>
                </div>
                <div class="receipt-row">
                    <span>Quantity:</span>
                    <span id="receiptQuantity"></span>
                </div>
                <div class="receipt-row">
                    <span>Processing:</span>
                    <span id="receiptProcessingType"></span>
                </div>
                <div class="receipt-row">
                    <span>Expected Release:</span>
                    <span id="receiptReleaseDate"></span>
                </div>
                <div class="receipt-divider"></div>
                <div class="receipt-row total">
                    <span>Total Amount:</span>
                    <span id="receiptTotalAmount"></span>
                </div>
            </div>
        </div>
        
        <div class="qr-code-container">
            <div id="qrCode"></div>
            <p class="qr-help-text">Scan this QR code for your payment reference</p>
        </div>
        
        <div class="receipt-actions">
            <button id="downloadReceiptBtn" class="btn btn-secondary">
                <i class="fas fa-download"></i> Download Receipt
            </button>
            <button id="closeReceiptBtn" class="btn btn-primary">
                <i class="fas fa-check"></i> Done
            </button>
        </div>
    </div>
</div>

<script>
const editBtn = document.getElementById('editBtn');
const profileDisplay = document.getElementById('profileDisplay');
const editProfileForm = document.getElementById('editProfileForm');
const editModal = document.getElementById('editModal');
const closeModalBtn = document.getElementById('closeModalBtn');
const cancelEditBtn = document.getElementById('cancelEditBtn');
const navItems = document.querySelectorAll('.nav-item');
const pages = document.querySelectorAll('.page-content');

// Navigation between pages
navItems.forEach(item => {
    item.addEventListener('click', function() {
        const targetPage = this.getAttribute('data-page');
        
        navItems.forEach(navItem => navItem.classList.remove('active'));
        this.classList.add('active');
        
        pages.forEach(page => {
            page.style.display = 'none';
        });
        
        document.getElementById(targetPage + 'Page').style.display = '';
    });
});

// Show modal and switch to edit mode
editBtn.addEventListener('click', function() {
    editModal.style.display = 'flex';
});

// Close modal and show edit form
closeModalBtn.addEventListener('click', function() {
    editModal.style.display = 'none';
    profileDisplay.style.display = 'none';
    editProfileForm.style.display = '';
});

// Cancel edit
cancelEditBtn.addEventListener('click', function() {
    editProfileForm.style.display = 'none';
    profileDisplay.style.display = '';
});

// AJAX submit for edit form
editProfileForm.addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(editProfileForm);

    fetch('<?= base_url('student/update') ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())    .then(data => {
        if(data.success){
            alert('Profile updated successfully!');
            window.location.reload();
        } else {
            alert('Update failed. Please check your input.');
        }
    })
    .catch(() => alert('An error occurred while updating.'));
});

// Document Request Functionality
const documentTypeSelect = document.getElementById('document_type');
const documentDetails = document.getElementById('documentDetails');
const documentPurpose = document.getElementById('document_purpose');
const otherPurposeGroup = document.getElementById('otherPurposeGroup');
const otherPurpose = document.getElementById('other_purpose');
const documentQuantity = document.getElementById('document_quantity');
const urgentRequest = document.getElementById('urgent_request');
const documentFee = document.getElementById('documentFee');
const quantityDisplay = document.getElementById('quantityDisplay');
const urgentFee = document.getElementById('urgentFee');
const totalAmount = document.getElementById('totalAmount');
const documentRequestForm = document.getElementById('documentRequestForm');
const refreshStatusBtn = document.getElementById('refreshStatusBtn');
const requestStatusList = document.getElementById('requestStatusList');
const statusFilterBtns = document.querySelectorAll('.status-filter-btn');

// Load document types and update counts on page load
document.addEventListener('DOMContentLoaded', function() {
    loadDocumentTypes();
    updateRequestStatusCounts();
    
    // Load request status data when clicking on status tab
    document.querySelector('.nav-item[data-page="status"]').addEventListener('click', loadRequestStatus);

    // Set up payment confirmation modal event listeners
    const closePaymentModalBtn = document.getElementById('closePaymentModalBtn');
    const closeReceiptBtn = document.getElementById('closeReceiptBtn');
    const downloadReceiptBtn = document.getElementById('downloadReceiptBtn');
    const paymentConfirmationModal = document.getElementById('paymentConfirmationModal');

    if (closePaymentModalBtn) {
        closePaymentModalBtn.addEventListener('click', function() {
            paymentConfirmationModal.style.display = 'none';
            // After closing modal, go to request status tab
            document.querySelector('.nav-item[data-page="status"]').click();
            loadRequestStatus();
        });
    }

    if (closeReceiptBtn) {
        closeReceiptBtn.addEventListener('click', function() {
            paymentConfirmationModal.style.display = 'none';
            // After closing modal, go to request status tab
            document.querySelector('.nav-item[data-page="status"]').click();
            loadRequestStatus();
        });
    }

    if (downloadReceiptBtn) {
        downloadReceiptBtn.addEventListener('click', function() {
            downloadReceipt();
        });
    }
});

// Load document types from server
function loadDocumentTypes() {
    fetch('<?= base_url('student/document-types') ?>', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Populate document type dropdown
            documentTypeSelect.innerHTML = '<option value="">-- Select Document Type --</option>';
            data.documentTypes.forEach(type => {
                documentTypeSelect.innerHTML += `<option value="${type.type_id}" 
                    data-price="${type.price}" 
                    data-processing="${type.processing_days}" 
                    data-description="${type.description}">${type.document_name}</option>`;
            });
        } else {
            console.error('Failed to load document types');
        }
    })
    .catch(error => {
        console.error('Error loading document types:', error);
    });
}

// Show document details when document type is selected
documentTypeSelect.addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    if (this.value) {
        const price = selectedOption.dataset.price;
        const processingDays = selectedOption.dataset.processing;
        const description = selectedOption.dataset.description;
        
        documentDetails.innerHTML = `
            <div class="detail-item">
                <span class="detail-label">Description:</span>
                <span class="detail-value">${description}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Price:</span>
                <span class="detail-value">₱${parseFloat(price).toFixed(2)}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Processing Time:</span>
                <span class="detail-value">${processingDays} working days</span>
            </div>
        `;
        
        documentDetails.style.display = 'block';
        updatePaymentSummary();
    } else {
        documentDetails.innerHTML = '';
        documentDetails.style.display = 'none';
        updatePaymentSummary();
    }
});

// Toggle "Other" purpose field
documentPurpose.addEventListener('change', function() {
    if (this.value === 'Other') {
        otherPurposeGroup.style.display = 'block';
        otherPurpose.required = true;
    } else {
        otherPurposeGroup.style.display = 'none';
        otherPurpose.required = false;
    }
});

// Update payment summary when quantity or urgent option changes
documentQuantity.addEventListener('input', updatePaymentSummary);
urgentRequest.addEventListener('change', updatePaymentSummary);

// Quantity increment/decrement buttons
const decrementQuantity = document.getElementById('decrementQuantity');
const incrementQuantity = document.getElementById('incrementQuantity');
if (decrementQuantity && incrementQuantity && documentQuantity) {
    decrementQuantity.addEventListener('click', function(e) {
        e.preventDefault();
        let val = parseInt(documentQuantity.value) || 1;
        if (val > 1) documentQuantity.value = val - 1;
        documentQuantity.dispatchEvent(new Event('input'));
    });
    incrementQuantity.addEventListener('click', function(e) {
        e.preventDefault();
        let val = parseInt(documentQuantity.value) || 1;
        documentQuantity.value = val + 1;
        documentQuantity.dispatchEvent(new Event('input'));
    });
}

// Calculate and update payment summary
function updatePaymentSummary() {
    const selectedOption = documentTypeSelect.options[documentTypeSelect.selectedIndex];
    let docFee = 0;
    if (documentTypeSelect.value) {
        docFee = parseFloat(selectedOption.dataset.price);
    }
    
    const quantity = parseInt(documentQuantity.value) || 1;
    const isUrgent = urgentRequest.checked;
    const rushFee = isUrgent ? 100.00 : 0.00;
    
    documentFee.textContent = `₱${docFee.toFixed(2)}`;
    quantityDisplay.textContent = quantity;
    urgentFee.textContent = `₱${rushFee.toFixed(2)}`;
    
    const total = (docFee * quantity) + rushFee;
    totalAmount.textContent = `₱${total.toFixed(2)}`;
}

// Handle document request form submission
documentRequestForm.addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Validate purpose
    if (documentPurpose.value === 'Other' && otherPurpose.value.trim() === '') {
        alert('Please specify the purpose of your request');
        return;
    }
    
    // Create form data for submission
    const formData = new FormData(this);
    
    // If purpose is 'Other', use the specified other purpose
    if (documentPurpose.value === 'Other') {
        formData.set('purpose', otherPurpose.value.trim());
    }
    
    // Get selected document name for receipt
    const selectedDocumentName = documentTypeSelect.options[documentTypeSelect.selectedIndex].text;
    const isUrgent = urgentRequest.checked;
    
    // Submit the request
    fetch('<?= base_url('student/submit-request') ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show payment confirmation modal instead of alert
            showPaymentConfirmation(data.requestId, selectedDocumentName, data);
            
            // Reset form
            documentRequestForm.reset();
            documentDetails.innerHTML = '';
            documentDetails.style.display = 'none';
            otherPurposeGroup.style.display = 'none';
            updatePaymentSummary();
            
            // Refresh request count
            updateRequestStatusCounts();
        } else {
            if (data.errors) {
                const errorMessages = Object.values(data.errors).join('\n');
                alert(`Request failed:\n${errorMessages}`);
            } else {
                alert(`Request failed: ${data.message || 'An error occurred.'}`);
            }
        }
    })
    .catch(error => {
        console.error('Error submitting request:', error);
        alert('An error occurred while submitting your request.');
    });
});

// Load request status data
function loadRequestStatus() {
    requestStatusList.innerHTML = `
        <div class="loading-spinner">
            <i class="fas fa-spinner fa-spin"></i>
            <p>Loading requests...</p>
        </div>
    `;
    
    fetch('<?= base_url('student/request-status') ?>', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (data.requests.length > 0) {
                renderRequestList(data.requests);
            } else {
                requestStatusList.innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-search"></i>
                        <p>No requests found</p>
                        <small>Start by requesting a document</small>
                    </div>
                `;
            }
        } else {
            requestStatusList.innerHTML = `
                <div class="error-state">
                    <i class="fas fa-exclamation-triangle"></i>
                    <p>Failed to load requests</p>
                    <small>${data.message || 'An error occurred'}</small>
                </div>
            `;
        }
    })
    .catch(error => {
        console.error('Error loading requests:', error);
        requestStatusList.innerHTML = `
            <div class="error-state">
                <i class="fas fa-exclamation-triangle"></i>
                <p>Failed to load requests</p>
                <small>Please try again later</small>
            </div>
        `;
    });
}

// Refresh button click event
refreshStatusBtn.addEventListener('click', loadRequestStatus);

// Filter requests by status
statusFilterBtns.forEach(btn => {
    btn.addEventListener('click', function() {
        const status = this.dataset.status;
        
        // Update active button
        statusFilterBtns.forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        
        // Apply filter
        const requestItems = document.querySelectorAll('.request-item');
        if (status === 'all') {
            requestItems.forEach(item => item.style.display = 'block');
        } else {
            requestItems.forEach(item => {
                if (item.dataset.status === status) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }
    });
});

// Render request list with data
function renderRequestList(requests) {
    let html = '';
    
    requests.forEach(request => {
        let statusClass = '';
        let statusIcon = '';
        
        switch (request.request_status) {
            case 'pending':
                statusClass = 'status-pending';
                statusIcon = 'fa-clock';
                break;
            case 'processing':
                statusClass = 'status-processing';
                statusIcon = 'fa-spinner';
                break;
            case 'ready':
                statusClass = 'status-ready';
                statusIcon = 'fa-check';
                break;
            case 'completed':
                statusClass = 'status-completed';
                statusIcon = 'fa-check-circle';
                break;
            case 'canceled':
                statusClass = 'status-canceled';
                statusIcon = 'fa-times-circle';
                break;
            case 'declined':
                statusClass = 'status-declined';
                statusIcon = 'fa-ban';
                break;
        }
        
        html += `
            <div class="request-item" data-status="${request.request_status}">
                <div class="request-header">
                    <div class="document-name">${request.document_name}</div>
                    <div class="request-status ${statusClass}">
                        <i class="fas ${statusIcon}"></i> ${request.request_status.charAt(0).toUpperCase() + request.request_status.slice(1)}
                    </div>
                </div>
                <div class="request-details">
                    <div class="detail-column">
                        <div class="detail-row">
                            <div class="detail-label">Request ID:</div>
                            <div class="detail-value">${request.request_id}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Date Requested:</div>
                            <div class="detail-value">${request.request_date_formatted}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Quantity:</div>
                            <div class="detail-value">${request.quantity}</div>
                        </div>
                    </div>
                    <div class="detail-column">
                        <div class="detail-row">
                            <div class="detail-label">Purpose:</div>
                            <div class="detail-value">${request.purpose}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Expected Release:</div>
                            <div class="detail-value">${request.expected_release_date_formatted}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Payment Status:</div>
                            <div class="detail-value payment-${request.payment_status}">${request.payment_status.charAt(0).toUpperCase() + request.payment_status.slice(1)}</div>
                        </div>
                    </div>
                </div>                <div class="request-footer">
                    <div class="request-amount">Total: ₱${parseFloat(request.total_amount).toFixed(2)}</div>
                    ${request.is_urgent == 1 ? '<div class="urgent-tag"><i class="fas fa-bolt"></i> Rush</div>' : ''}
                    ${request.request_status === 'pending' ? 
                        `<button class="btn btn-cancel cancel-request-btn" data-request-id="${request.request_id}">
                            <i class="fas fa-times-circle"></i> Cancel Request
                        </button>` : ''}
                    ${request.request_status === 'canceled' && request.notes ? 
                        `<div class="cancellation-reason">
                            <strong>Cancellation Reason:</strong> ${request.notes.replace('Canceled by student. Reason: ', '')}
                        </div>` : ''}
                </div>
            </div>
        `;
    });
    
    requestStatusList.innerHTML = html;
}

// Update request status counts in the dashboard summary
function updateRequestStatusCounts() {
    fetch('<?= base_url('student/request-counts') ?>', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Corrected selectors to target summary cards within .dashboard-summary
            const dashboardSummary = document.querySelector('.dashboard-summary');
            if (dashboardSummary) {
                const completedStat = dashboardSummary.querySelector('.summary-card:nth-child(1) .stats');
                const pendingStat = dashboardSummary.querySelector('.summary-card:nth-child(2) .stats');
                const processingStat = dashboardSummary.querySelector('.summary-card:nth-child(3) .stats');

                if (completedStat) completedStat.textContent = data.completedCount || '0';
                if (pendingStat) pendingStat.textContent = data.pendingCount || '0';
                if (processingStat) processingStat.textContent = data.processingCount || '0';
            } else {
                // Fallback or error if .dashboard-summary is not found, though it should exist
                // These selectors were targeting #profilePage, which was incorrect for the main dashboard counters.
                // The PHP variables are $completedCount, $pendingCount, $processingCount.
                // The JS data properties are data.completedCount, data.pendingCount, data.processingCount.
                // The order in HTML is: Completed, Pending, Processing.
                // The JS update order was: Completed (child 1), Pending (child 2), Processing (child 3).
                // This order seems consistent.
                document.querySelector('.dashboard-summary .summary-card:nth-child(1) .stats').textContent = data.completedCount || '0';
                document.querySelector('.dashboard-summary .summary-card:nth-child(2) .stats').textContent = data.pendingCount || '0';
                document.querySelector('.dashboard-summary .summary-card:nth-child(3) .stats').textContent = data.processingCount || '0';
            }
        } else {
            console.error('Failed to update request counts');
        }
    })
    .catch(error => {
        console.error('Error updating request counts:', error);
    });
}

// Show payment confirmation modal with QR code
function showPaymentConfirmation(requestId, documentName, data) {
    const paymentConfirmationModal = document.getElementById('paymentConfirmationModal');
    document.getElementById('receiptRequestId').textContent = requestId;
    document.getElementById('receiptDocumentName').textContent = documentName;
    document.getElementById('receiptQuantity').textContent = data.quantity;
    document.getElementById('receiptProcessingType').textContent = data.isUrgent ? 'Urgent' : 'Regular';
    document.getElementById('receiptReleaseDate').textContent = data.expectedReleaseDate;
    document.getElementById('receiptTotalAmount').textContent = `₱${parseFloat(data.totalAmount).toFixed(2)}`;
    document.getElementById('receiptDate').textContent = new Date().toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });

    // Generate QR Code
    const qrCodeDiv = document.getElementById('qrCode');
    qrCodeDiv.innerHTML = ''; // Clear previous QR code
    const qrCodeImg = document.createElement('img');
    // Correctly construct the URL for the QR code
    qrCodeImg.src = `<?= base_url('student/generate-qr-code/') ?>${requestId}`;
    qrCodeImg.alt = 'Payment QR Code';
    qrCodeImg.style.maxWidth = '150px'; // Adjust size as needed
    qrCodeDiv.appendChild(qrCodeImg);

    // Set up download button
    const downloadBtn = document.getElementById('downloadReceiptBtn');
    downloadBtn.onclick = function() {
        window.location.href = `<?= base_url('student/download-receipt/') ?>${requestId}`;
    };

    paymentConfirmationModal.style.display = 'flex';
}

// Initial call to set up payment summary and load document types
updatePaymentSummary();
loadDocumentTypes();
updateRequestStatusCounts(); // Also update counts on initial load

// Cancellation modal functionality
document.addEventListener('click', function(e) {
    if (e.target && e.target.closest('.cancel-request-btn')) {
        const button = e.target.closest('.cancel-request-btn');
        const requestId = button.dataset.requestId;
        document.getElementById('cancelRequestId').value = requestId;
        document.getElementById('cancellationModal').style.display = 'flex';
    }
});

// Close cancellation modal when clicking the X button
document.getElementById('closeCancelModalBtn').addEventListener('click', function() {
    document.getElementById('cancellationModal').style.display = 'none';
});

// Close cancellation modal when clicking the "Go Back" button
document.getElementById('cancelCancellationBtn').addEventListener('click', function() {
    document.getElementById('cancellationModal').style.display = 'none';
});

// Handle cancellation form submission
document.getElementById('cancellationForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const requestId = document.getElementById('cancelRequestId').value;
    const reason = document.getElementById('cancellationReason').value;
    
    if (!reason.trim()) {
        alert('Please provide a reason for cancellation');
        return;
    }
    
    fetch('<?= base_url('student/cancel-request') ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('cancellationModal').style.display = 'none';
            alert('Your request has been cancelled successfully');
            loadRequestStatus(); // Refresh the request list
            updateRequestStatusCounts(); // Update the dashboard counters
        } else {
            alert('Failed to cancel request: ' + (data.message || 'An error occurred'));
        }
    })
    .catch(error => {
        console.error('Error cancelling request:', error);
        alert('An error occurred while processing your cancellation');
    });
});

// Fetch and display ready for pickup notifications
function fetchReadyForPickupNotifications() {
    fetch('/student/ready-for-pickup-count', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        const notificationContainer = document.getElementById('pickupNotificationContainer');
        if (data.success && data.readyForPickupCount > 0) {
            let message = `You have ${data.readyForPickupCount} document(s) ready for pickup.`;
            notificationContainer.innerHTML = `
                <button class="btn btn-icon notification-btn" id="pickupNotificationBtn" title="${message}">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge">${data.readyForPickupCount}</span>
                </button>
            `;
            // Optionally, make the button clickable to navigate to the status page
            document.getElementById('pickupNotificationBtn').addEventListener('click', () => {
                // Navigate to status page and filter by 'ready for pickup'
                document.querySelector('.nav-item[data-page="status"]').click();
                // Add a small delay to ensure the page content is loaded before filtering
                setTimeout(() => {
                    const readyFilterBtn = document.querySelector('.status-filter-btn[data-status="ready"]');
                    if (readyFilterBtn) {
                        readyFilterBtn.click();
                    }
                }, 100);
            });
        } else {
            notificationContainer.innerHTML = ''; // Clear notification if count is 0 or error
        }
    })
    .catch(error => {
        console.error('Error fetching pickup notifications:', error);
        document.getElementById('pickupNotificationContainer').innerHTML = '';
    });
}

// Call on page load and periodically
document.addEventListener('DOMContentLoaded', () => {
    fetchReadyForPickupNotifications();
    setInterval(fetchReadyForPickupNotifications, 60000); // Refresh every 60 seconds
});

</script>
</body>
</html>