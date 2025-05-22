<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="<?= base_url('css/admin_css.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<?php $session = session(); ?>

<div class="container">
    <div class="sidebar">
        <div class="sidebar-header">
            <img src="https://cdn-icons-png.flaticon.com/512/2206/2206368.png" alt="Admin">
            <h3>Administrator</h3>
            <p>Admin ID: <?= esc($session->get('admin_id') ?? 'Admin') ?></p>
            <span class="admin-tag">Administrator</span>
        </div>
          <div class="nav">
            <div class="nav-item active" data-page="dashboard">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </div>
            <div class="nav-item" data-page="users">
                <i class="fas fa-users"></i> Users
            </div>
            <div class="nav-item" data-page="requests">
                <i class="fas fa-file-alt"></i> Document Requests
            </div>
            <div class="nav-item" data-page="cashier">
                <i class="fas fa-cash-register"></i> Cashier Gateway
            </div>
            <div class="nav-item" data-page="settings">
                <i class="fas fa-cog"></i> Settings
            </div>
        </div>
        
        <form method="post" action="/logout">
            <button class="logout-btn"><i class="fas fa-sign-out-alt"></i> Log out</button>
        </form>
    </div>

    <div class="main-content">
        <div class="dashboard-header">
            <h1>Admin Dashboard</h1>
            <div class="date-time"><?= date('F d, Y') ?></div>
        </div>
        
        <div class="dashboard-summary">
            <div class="summary-card">
                <i class="fas fa-clock"></i>
                <h3>Pending Requests</h3>
                <p class="stats"><?= isset($pendingCount) ? $pendingCount : '0' ?></p>
            </div>
            <div class="summary-card">
                <i class="fas fa-cog fa-spin"></i>
                <h3>Processing Requests</h3>
                <p class="stats"><?= isset($processingCount) ? $processingCount : '0' ?></p>
            </div>
            <div class="summary-card">
                <i class="fas fa-check"></i>
                <h3>Ready for Pickup</h3>
                <p class="stats"><?= isset($readyCount) ? $readyCount : '0' ?></p>
            </div>
            <div class="summary-card">
                <i class="fas fa-check-circle"></i>
                <h3>Completed Requests</h3>
                <p class="stats"><?= isset($completedCount) ? $completedCount : '0' ?></p>
            </div>
            <div class="summary-card">
                <i class="fas fa-file-alt"></i>
                <h3>Total Requests</h3>
                <p class="stats"><?= isset($totalCount) ? $totalCount : '0' ?></p>
            </div>
        </div>
        
        <!-- Dashboard Overview Page -->
        <div class="page-content" id="dashboardPage">
            <div class="card">
                <div class="card-header">
                    <h2><i class="fas fa-chart-bar"></i> System Overview</h2>
                </div>
                <div class="card-body">
                    <div class="dashboard-panels">
                        <div class="panel">
                            <h3>Recent Document Requests</h3>
                            <div id="recentRequests" class="panel-content">
                                <div class="loading">Loading recent requests...</div>
                            </div>
                            <div class="panel-footer">
                                <button class="btn btn-secondary" id="viewAllRequestsBtn">View All Requests</button>
                            </div>
                        </div>
                        
                        <div class="panel">
                            <h3>Recent Users</h3>
                            <div id="recentUsers" class="panel-content">
                                <div class="loading">Loading recent users...</div>
                            </div>
                            <div class="panel-footer">
                                <button class="btn btn-secondary" id="viewAllUsersBtn">View All Users</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Users Management Page -->
        <div class="page-content" id="usersPage" style="display:none;">
            <div class="card">
                <div class="card-header">
                    <h2><i class="fas fa-users"></i> User Management</h2>
                    <div class="card-actions">
                        <button id="refreshUsersBtn" class="btn btn-icon"><i class="fas fa-sync-alt"></i> Refresh</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="filter-bar">
                        <div class="filter-group">
                            <label for="userCollege">College:</label>
                            <select id="userCollege" class="filter-select">
                                <option value="">All Colleges</option>
                                <option value="College of Arts and Sciences">College of Arts and Sciences</option>
                                <option value="College of Business Administration">College of Business Administration</option>
                                <option value="College of Engineering">College of Engineering</option>
                                <option value="College of Education">College of Education</option>
                                <option value="College of Nursing">College of Nursing</option>
                                <option value="College of Computing and Information Sciences">College of Computing and Information Sciences</option>
                                <option value="College of Agriculture">College of Agriculture</option>
                                <option value="College of Law">College of Law</option>
                                <option value="College of Medicine">College of Medicine</option>
                                <option value="College of Allied Medical Sciences">College of Allied Medical Sciences</option>
                            </select>
                        </div>
                        <div class="search-bar">
                            <input type="text" id="userSearchInput" placeholder="Search users..." class="search-input">
                            <button id="userSearchBtn" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="data-table" id="usersTable">
                            <thead>
                                <tr>
                                    <th>Student ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>College</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="5" class="text-center">Loading users...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Document Requests Management Page -->
        <div class="page-content" id="requestsPage" style="display:none;">
            <div class="card">
                <div class="card-header">
                    <h2><i class="fas fa-file-alt"></i> Document Request Management</h2>
                    <div class="card-actions">
                        <button id="refreshRequestsBtn" class="btn btn-icon"><i class="fas fa-sync-alt"></i> Refresh</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="filter-bar">
                        <div class="filter-group">
                            <label for="requestStatus">Status:</label>
                            <select id="requestStatus" class="filter-select">
                                <option value="">All Statuses</option>
                                <option value="pending">Pending</option>
                                <option value="processing">Processing</option>
                                <option value="ready">Ready for Pickup</option>
                                <option value="completed">Completed</option>
                                <option value="declined">Declined</option>
                                <option value="canceled">Canceled</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label for="documentType">Document Type:</label>
                            <select id="documentType" class="filter-select">
                                <option value="">All Types</option>
                                <?php foreach ($documentTypes as $type): ?>
                                <option value="<?= $type['type_id'] ?>"><?= $type['document_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label for="urgency">Urgency:</label>
                            <select id="urgency" class="filter-select">
                                <option value="">All</option>
                                <option value="1">Urgent</option>
                                <option value="0">Regular</option>
                            </select>
                        </div>
                        <div class="search-bar">
                            <input type="text" id="requestSearchInput" placeholder="Search requests..." class="search-input">
                            <button id="requestSearchBtn" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="data-table" id="requestsTable">
                            <thead>
                                <tr>
                                    <th>Request ID</th>
                                    <th>Student</th>
                                    <th>Document</th>
                                    <th>Date Requested</th>
                                    <th>Status</th>
                                    <th>Urgency</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="7" class="text-center">Loading requests...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Settings Page -->
        <div class="page-content" id="settingsPage" style="display:none;">
            <div class="card">
                <div class="card-header">
                    <h2><i class="fas fa-cog"></i> System Settings</h2>
                </div>
                <div class="card-body">
                    <form id="settingsForm">
                        <div class="form-section">
                            <h4>Email Settings</h4>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="sysEmail">System Email</label>
                                    <input type="email" id="sysEmail" name="system_email" value="system@example.com">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-section">
                            <h4>Document Processing Settings</h4>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="urgentMultiplier">Urgent Processing Fee</label>
                                    <div class="input-group">
                                        <span class="input-prefix">₱</span>
                                        <input type="number" id="urgentMultiplier" name="urgent_fee" value="100">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="button-row">
                            <button type="submit" class="btn btn-primary">Save Settings</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- User Detail Modal -->
<div class="modal-bg" id="userDetailModal">
    <div class="modal-content large-modal">
        <div class="modal-close-btn">
            <i class="fas fa-times" id="closeUserModalBtn"></i>
        </div>
        <div class="modal-header">
            <h3><i class="fas fa-user-circle"></i> <span id="userDetailName">User Details</span></h3>
        </div>
        <div class="modal-body">
            <div class="tabs">
                <div class="tab-header">
                    <div class="tab-item active" data-tab="profile">Profile</div>
                    <div class="tab-item" data-tab="requests">Document Requests</div>
                </div>
                <div class="tab-content">
                    <div class="tab-pane active" id="profileTab">
                        <div class="user-details">
                            <div class="detail-section">
                                <h4>Personal Information</h4>
                                <div class="detail-grid">
                                    <div class="detail-row"><strong>First Name:</strong> <span id="userFirstName"></span></div>
                                    <div class="detail-row"><strong>Last Name:</strong> <span id="userLastName"></span></div>
                                    <div class="detail-row"><strong>Middle Name:</strong> <span id="userMiddleName"></span></div>
                                    <div class="detail-row"><strong>Birthdate:</strong> <span id="userBirthdate"></span></div>
                                    <div class="detail-row"><strong>Birthplace:</strong> <span id="userBirthplace"></span></div>
                                </div>
                            </div>
                            
                            <div class="detail-section">
                                <h4>Academic Information</h4>
                                <div class="detail-grid">
                                    <div class="detail-row"><strong>ID Number:</strong> <span id="userStudentId"></span></div>
                                    <div class="detail-row"><strong>Type of Admission:</strong> <span id="userAdmissionType"></span></div>
                                    <div class="detail-row"><strong>College:</strong> <span id="userCollege"></span></div>
                                    <div class="detail-row"><strong>Year Enrolled:</strong> <span id="userYearEnrolled"></span></div>
                                    <div class="detail-row"><strong>Year Graduated:</strong> <span id="userYearGraduated"></span></div>
                                </div>
                            </div>
                            
                            <div class="detail-section">
                                <h4>Contact Information</h4>
                                <div class="detail-grid">
                                    <div class="detail-row"><strong>Email Address:</strong> <span id="userEmail"></span></div>
                                    <div class="detail-row"><strong>Mobile No.:</strong> <span id="userMobile"></span></div>
                                </div>
                            </div>
                            
                            <div class="detail-section">
                                <h4>Address Information</h4>
                                <div class="detail-grid">
                                    <div class="detail-row"><strong>Street/Barangay:</strong> <span id="userStreet"></span></div>
                                    <div class="detail-row"><strong>City/Municipality:</strong> <span id="userCity"></span></div>
                                    <div class="detail-row"><strong>Province:</strong> <span id="userProvince"></span></div>
                                    <div class="detail-row"><strong>Region:</strong> <span id="userRegion"></span></div>
                                    <div class="detail-row"><strong>Zip Code:</strong> <span id="userZipCode"></span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tab-pane" id="requestsTab">
                        <div id="userRequestsList">
                            <div class="loading">Loading user's requests...</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Request Detail Modal -->
<div class="modal-bg" id="requestDetailModal">
    <div class="modal-content large-modal">
        <div class="modal-close-btn">
            <i class="fas fa-times" id="closeRequestModalBtn"></i>
        </div>
        <div class="modal-header">
            <h3><i class="fas fa-file-alt"></i> Request Details</h3>
        </div>
        <div class="modal-body">
            <div class="request-details">
                <div class="detail-section">
                    <h4>Request Information</h4>
                    <div class="detail-grid">
                        <div class="detail-row"><strong>Request ID:</strong> <span id="detailRequestId"></span></div>
                        <div class="detail-row"><strong>Document Type:</strong> <span id="detailDocumentName"></span></div>
                        <div class="detail-row"><strong>Request Date:</strong> <span id="detailRequestDate"></span></div>
                        <div class="detail-row"><strong>Expected Release Date:</strong> <span id="detailReleaseDate"></span></div>
                        <div class="detail-row"><strong>Purpose:</strong> <span id="detailPurpose"></span></div>
                        <div class="detail-row"><strong>Quantity:</strong> <span id="detailQuantity"></span></div>
                        <div class="detail-row"><strong>Processing Type:</strong> <span id="detailUrgency"></span></div>
                        <div class="detail-row"><strong>Status:</strong> <span id="detailStatus"></span></div>
                        <div class="detail-row"><strong>Total Amount:</strong> <span id="detailAmount"></span></div>
                        <div class="detail-row"><strong>Payment Status:</strong> <span id="detailPaymentStatus"></span></div>
                    </div>
                </div>
                
                <div class="detail-section">
                    <h4>Student Information</h4>
                    <div class="detail-grid">
                        <div class="detail-row"><strong>Student ID:</strong> <span id="detailStudentId"></span></div>
                        <div class="detail-row"><strong>Name:</strong> <span id="detailStudentName"></span></div>
                        <div class="detail-row"><strong>Email:</strong> <span id="detailStudentEmail"></span></div>
                        <div class="detail-row"><strong>College:</strong> <span id="detailStudentCollege"></span></div>
                    </div>
                </div>
                
                <div class="detail-section">
                    <h4>Additional Notes</h4>
                    <div class="detail-notes" id="detailNotes">No notes provided</div>
                </div>
                
                <hr>
                
                <div class="detail-section">
                    <h4>Update Request Status</h4>
                    <form id="updateStatusForm">
                        <input type="hidden" id="updateRequestId" name="request_id">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="updateStatus">New Status:</label>
                                <select id="updateStatus" name="status" required>
                                    <option value="pending">Pending</option>
                                    <option value="processing">Processing</option>
                                    <option value="ready">Ready for Pickup</option>
                                    <option value="completed">Completed</option>
                                    <option value="declined">Declined</option>
                                    <option value="canceled">Canceled</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="adminNotes">Admin Notes:</label>
                                <textarea id="adminNotes" name="admin_notes" rows="3" placeholder="Add notes about this request or status change..."></textarea>
                            </div>
                        </div>
                        <div class="button-row">
                            <button type="submit" class="btn btn-primary">Update Status</button>
                            <a href="#" id="downloadRequestReceipt" class="btn btn-secondary"><i class="fas fa-download"></i> Download Receipt</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Navigation
    const navItems = document.querySelectorAll('.nav-item');
    const pages = document.querySelectorAll('.page-content');
    
    navItems.forEach(item => {
        item.addEventListener('click', function() {
            const targetPage = this.getAttribute('data-page');
            
            navItems.forEach(navItem => navItem.classList.remove('active'));
            this.classList.add('active');
            
            pages.forEach(page => {
                page.style.display = 'none';
            });
              // Check if it's the cashier page which needs a redirect
            if (targetPage === 'cashier') {
                window.location.href = '<?= base_url('admin/cashier') ?>';
                return;
            }
            
            document.getElementById(targetPage + 'Page').style.display = '';
            
            // Load data based on selected page
            if (targetPage === 'users') {
                loadUsers();
            } else if (targetPage === 'requests') {
                loadRequests();
            } else if (targetPage === 'dashboard') {
                loadDashboard();
            }
        });
    });
    
    // Modals
    const userDetailModal = document.getElementById('userDetailModal');
    const requestDetailModal = document.getElementById('requestDetailModal');
    const closeUserModalBtn = document.getElementById('closeUserModalBtn');
    const closeRequestModalBtn = document.getElementById('closeRequestModalBtn');
    
    if (closeUserModalBtn) {
        closeUserModalBtn.addEventListener('click', function() {
            userDetailModal.style.display = 'none';
        });
    }
    
    if (closeRequestModalBtn) {
        closeRequestModalBtn.addEventListener('click', function() {
            requestDetailModal.style.display = 'none';
        });
    }
    
    window.addEventListener('click', function(event) {
        if (event.target === userDetailModal) {
            userDetailModal.style.display = 'none';
        }
        if (event.target === requestDetailModal) {
            requestDetailModal.style.display = 'none';
        }
    });
    
    // User Detail Tabs
    const tabItems = document.querySelectorAll('.tab-item');
    const tabPanes = document.querySelectorAll('.tab-pane');
    
    tabItems.forEach(item => {
        item.addEventListener('click', function() {
            const targetTab = this.getAttribute('data-tab');
            
            tabItems.forEach(tabItem => tabItem.classList.remove('active'));
            this.classList.add('active');
            
            tabPanes.forEach(pane => pane.classList.remove('active'));
            document.getElementById(targetTab + 'Tab').classList.add('active');
        });
    });
    
    // Load dashboard on initial load
    loadDashboard();
    
    // Setup event listeners for dashboard page
    const viewAllRequestsBtn = document.getElementById('viewAllRequestsBtn');
    const viewAllUsersBtn = document.getElementById('viewAllUsersBtn');
    
    if (viewAllRequestsBtn) {
        viewAllRequestsBtn.addEventListener('click', function() {
            document.querySelector('.nav-item[data-page="requests"]').click();
        });
    }
    
    if (viewAllUsersBtn) {
        viewAllUsersBtn.addEventListener('click', function() {
            document.querySelector('.nav-item[data-page="users"]').click();
        });
    }
    
    // Setup event listeners for users page
    const refreshUsersBtn = document.getElementById('refreshUsersBtn');
    const userSearchBtn = document.getElementById('userSearchBtn');
    const userCollege = document.getElementById('userCollege');
    const userSearchInput = document.getElementById('userSearchInput');
    
    if (refreshUsersBtn) {
        refreshUsersBtn.addEventListener('click', loadUsers);
    }
    
    if (userSearchBtn) {
        userSearchBtn.addEventListener('click', loadUsers);
    }
    
    if (userCollege) {
        userCollege.addEventListener('change', loadUsers);
    }
    
    // Setup event listeners for requests page
    const refreshRequestsBtn = document.getElementById('refreshRequestsBtn');
    const requestSearchBtn = document.getElementById('requestSearchBtn');
    const requestStatus = document.getElementById('requestStatus');
    const documentType = document.getElementById('documentType');
    const urgency = document.getElementById('urgency');
    const requestSearchInput = document.getElementById('requestSearchInput');
    
    if (refreshRequestsBtn) {
        refreshRequestsBtn.addEventListener('click', loadRequests);
    }
    
    if (requestSearchBtn) {
        requestSearchBtn.addEventListener('click', loadRequests);
    }
    
    if (requestStatus) {
        requestStatus.addEventListener('change', loadRequests);
    }
    
    if (documentType) {
        documentType.addEventListener('change', loadRequests);
    }
    
    if (urgency) {
        urgency.addEventListener('change', loadRequests);
    }
    
    // Settings form submission
    const settingsForm = document.getElementById('settingsForm');
    if (settingsForm) {
        settingsForm.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Settings updated successfully!');
        });
    }
    
    // Update Status form submission
    const updateStatusForm = document.getElementById('updateStatusForm');
    if (updateStatusForm) {
        updateStatusForm.addEventListener('submit', function(e) {
            e.preventDefault();
            updateRequestStatus();
        });
    }
});

// Load dashboard data
function loadDashboard() {
    // Update request counts
    updateRequestCounts();
    
    // Load recent requests
    const recentRequests = document.getElementById('recentRequests');
    
    if (recentRequests) {
        recentRequests.innerHTML = '<div class="loading">Loading recent requests...</div>';
        
        fetch('<?= base_url('admin/requests') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: 'limit=5'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (data.requests.length > 0) {
                    let html = '<div class="recent-list">';
                    
                    data.requests.forEach(request => {
                        let statusClass = getStatusClass(request.request_status);
                        
                        html += `
                            <div class="recent-item">
                                <div class="recent-header">
                                    <div class="recent-title">${request.document_name}</div>
                                    <div class="recent-status ${statusClass}">${capitalize(request.request_status)}</div>
                                </div>
                                <div class="recent-body">
                                    <div class="recent-info">
                                        <div><strong>ID:</strong> ${request.request_id}</div>
                                        <div><strong>Student:</strong> ${request.student_name}</div>
                                    </div>
                                    <div class="recent-date">
                                        <div><strong>Requested:</strong> ${request.request_date_formatted}</div>
                                        <div><strong>Expected:</strong> ${request.expected_release_date_formatted}</div>
                                    </div>
                                </div>
                                <div class="recent-footer">
                                    <button class="btn btn-small" onclick="showRequestDetails(${request.request_id})">View Details</button>
                                </div>
                            </div>
                        `;
                    });
                    
                    html += '</div>';
                    recentRequests.innerHTML = html;
                } else {
                    recentRequests.innerHTML = '<div class="empty-state">No recent requests found</div>';
                }
            } else {
                recentRequests.innerHTML = '<div class="error-state">' + (data.message || 'Failed to load requests') + '</div>';
            }
        })
        .catch(error => {
            console.error('Error loading recent requests:', error);
            recentRequests.innerHTML = '<div class="error-state">Error loading requests</div>';
        });
    }
    
    // Load recent users
    const recentUsers = document.getElementById('recentUsers');
    
    if (recentUsers) {
        recentUsers.innerHTML = '<div class="loading">Loading recent users...</div>';
        
        fetch('<?= base_url('admin/users') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: 'limit=5'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (data.users.length > 0) {
                    let html = '<div class="recent-list">';
                    
                    data.users.forEach(user => {
                        html += `
                            <div class="recent-item">
                                <div class="recent-header">
                                    <div class="recent-title">${user.first_name} ${user.last_name}</div>
                                    <div class="recent-status">${user.college}</div>
                                </div>
                                <div class="recent-body">
                                    <div class="recent-info">
                                        <div><strong>ID:</strong> ${user.student_id}</div>
                                        <div><strong>Email:</strong> ${user.email_address}</div>
                                    </div>
                                </div>
                                <div class="recent-footer">
                                    <button class="btn btn-small" onclick="showUserDetails(${user.id})">View Profile</button>
                                </div>
                            </div>
                        `;
                    });
                    
                    html += '</div>';
                    recentUsers.innerHTML = html;
                } else {
                    recentUsers.innerHTML = '<div class="empty-state">No users found</div>';
                }
            } else {
                recentUsers.innerHTML = '<div class="error-state">' + (data.message || 'Failed to load users') + '</div>';
            }
        })
        .catch(error => {
            console.error('Error loading recent users:', error);
            recentUsers.innerHTML = '<div class="error-state">Error loading users</div>';
        });
    }
}

// Load user data for the users table
function loadUsers() {
    const usersTableBody = document.querySelector('#usersTable tbody');
    const college = document.getElementById('userCollege').value;
    const searchTerm = document.getElementById('userSearchInput').value;
    
    usersTableBody.innerHTML = `
        <tr>
            <td colspan="5" class="text-center">
                <div class="loading">Loading users...</div>
            </td>
        </tr>
    `;
    
    let formData = new FormData();
    if (college) formData.append('college', college);
    if (searchTerm) formData.append('search', searchTerm);
    
    fetch('<?= base_url('admin/users') ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (data.users.length > 0) {
                let html = '';
                
                data.users.forEach(user => {
                    html += `
                        <tr>
                            <td>${user.student_id}</td>
                            <td>${user.first_name} ${user.last_name}</td>
                            <td>${user.email_address}</td>
                            <td>${user.college}</td>
                            <td>
                                <button class="btn btn-primary btn-sm" onclick="showUserDetails(${user.id})">
                                    <i class="fas fa-eye"></i> View
                                </button>
                            </td>
                        </tr>
                    `;
                });
                
                usersTableBody.innerHTML = html;
            } else {
                usersTableBody.innerHTML = `
                    <tr>
                        <td colspan="5" class="text-center">No users found</td>
                    </tr>
                `;
            }
        } else {
            usersTableBody.innerHTML = `
                <tr>
                    <td colspan="5" class="text-center">${data.message || 'Failed to load users'}</td>
                </tr>
            `;
        }
    })
    .catch(error => {
        console.error('Error loading users:', error);
        usersTableBody.innerHTML = `
            <tr>
                <td colspan="5" class="text-center">Error loading users</td>
            </tr>
        `;
    });
}

// Load request data for the requests table
function loadRequests() {
    const requestsTableBody = document.querySelector('#requestsTable tbody');
    const status = document.getElementById('requestStatus').value;
    const typeId = document.getElementById('documentType').value;
    const isUrgent = document.getElementById('urgency').value;
    const searchTerm = document.getElementById('requestSearchInput').value;
    
    requestsTableBody.innerHTML = `
        <tr>
            <td colspan="7" class="text-center">
                <div class="loading">Loading requests...</div>
            </td>
        </tr>
    `;
    
    let formData = new FormData();
    if (status) formData.append('status', status);
    if (typeId) formData.append('type_id', typeId);
    if (isUrgent !== '') formData.append('is_urgent', isUrgent);
    if (searchTerm) formData.append('search', searchTerm);
    
    fetch('<?= base_url('admin/requests') ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (data.requests.length > 0) {
                let html = '';
                
                data.requests.forEach(request => {
                    const statusClass = getStatusClass(request.request_status);
                    const urgencyLabel = request.is_urgent == 1 ? 
                        '<span class="badge badge-urgent"><i class="fas fa-bolt"></i> Urgent</span>' : 
                        '<span class="badge badge-regular">Regular</span>';
                    
                    html += `
                        <tr>
                            <td>${request.request_id}</td>
                            <td>${request.student_name}</td>
                            <td>${request.document_name}</td>
                            <td>${request.request_date_formatted}</td>
                            <td><span class="status-badge ${statusClass}">${capitalize(request.request_status)}</span></td>
                            <td>${urgencyLabel}</td>
                            <td>
                                <button class="btn btn-primary btn-sm" onclick="showRequestDetails(${request.request_id})">
                                    <i class="fas fa-eye"></i> View
                                </button>
                            </td>
                        </tr>
                    `;
                });
                
                requestsTableBody.innerHTML = html;
            } else {
                requestsTableBody.innerHTML = `
                    <tr>
                        <td colspan="7" class="text-center">No requests found</td>
                    </tr>
                `;
            }
        } else {
            requestsTableBody.innerHTML = `
                <tr>
                    <td colspan="7" class="text-center">${data.message || 'Failed to load requests'}</td>
                </tr>
            `;
        }
    })
    .catch(error => {
        console.error('Error loading requests:', error);
        requestsTableBody.innerHTML = `
            <tr>
                <td colspan="7" class="text-center">Error loading requests</td>
            </tr>
        `;
    });
}

// Update request counts on dashboard
function updateRequestCounts() {
    fetch('<?= base_url('admin/request-counts') ?>', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const dashboardSummary = document.querySelector('.dashboard-summary');
            if (dashboardSummary) {
                const pendingStat = dashboardSummary.querySelector('.summary-card:nth-child(1) .stats');
                const processingStat = dashboardSummary.querySelector('.summary-card:nth-child(2) .stats');
                const readyStat = dashboardSummary.querySelector('.summary-card:nth-child(3) .stats');
                const completedStat = dashboardSummary.querySelector('.summary-card:nth-child(4) .stats');
                const totalStat = dashboardSummary.querySelector('.summary-card:nth-child(5) .stats');

                if (pendingStat) pendingStat.textContent = data.pendingCount || '0';
                if (processingStat) processingStat.textContent = data.processingCount || '0';
                if (readyStat) readyStat.textContent = data.readyCount || '0';
                if (completedStat) completedStat.textContent = data.completedCount || '0';
                if (totalStat) totalStat.textContent = data.totalCount || '0';
            }
        } else {
            console.error('Failed to update request counts');
        }
    })
    .catch(error => {
        console.error('Error updating request counts:', error);
    });
}

// Show user details in modal
function showUserDetails(userId) {
    const userDetailModal = document.getElementById('userDetailModal');
    const userDetailName = document.getElementById('userDetailName'); // Ensure this ID exists in your modal

    // Clear previous data and show loading state
    if (userDetailName) userDetailName.textContent = 'Loading User Details...';    const fieldsToClear = [
        'userFirstName', 'userLastName', 'userMiddleName', 'userBirthdate', 
        'userBirthplace', 'userStudentId', 'userAdmissionType', 'userCollege',
        'userYearEnrolled', 'userYearGraduated',
        'userEmail', 'userMobile', 'userStreet', 'userCity', 'userProvince', 
        'userRegion', 'userZipCode'
    ];
    fieldsToClear.forEach(id => {
        const el = document.getElementById(id);
        if (el) el.textContent = '';
    });
    const userRequestsListDiv = document.getElementById('userRequestsList');
    if (userRequestsListDiv) userRequestsListDiv.innerHTML = '<div class="loading">Loading user\'s requests...</div>';

    // Show modal
    if (userDetailModal) userDetailModal.style.display = 'flex';

    // Fetch user details
    fetch(`<?= base_url('admin/user') ?>/${userId}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        }
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(errData => {
                throw new Error(errData.message || `HTTP error! Status: ${response.status}`);
            }).catch(() => { // Fallback if response isn't JSON or errData.message is missing
                throw new Error(`HTTP error! Status: ${response.status} ${response.statusText}`);
            });
        }
        return response.json();
    })
    .then(data => {
        if (data.success && data.user) {
            const user = data.user;
            const requests = data.requests;

            if (userDetailName) userDetailName.textContent = `${user.first_name || ''} ${user.last_name || ''} (Details)`;

            const setText = (id, value) => {
                const el = document.getElementById(id);
                if (el) el.textContent = value || 'N/A';
                else console.warn(`Element with ID '${id}' not found in user detail modal.`);
            };            setText('userFirstName', user.first_name);
            setText('userLastName', user.last_name);
            setText('userMiddleName', user.middle_name);
            setText('userBirthdate', user.birthdate_formatted || user.birthdate);
            setText('userBirthplace', user.birthplace);
            setText('userStudentId', user.student_id);
            setText('userAdmissionType', user.type_of_admission);
            setText('userCollege', user.college);
            setText('userYearEnrolled', user.year_enrolled || 'N/A');
            setText('userYearGraduated', user.year_graduated || 'N/A');
            setText('userEmail', user.email_address);
            setText('userMobile', user.mobile_no);
            setText('userStreet', user.street_barangay);
            setText('userCity', user.municipality); // Assuming 'userCity' is the ID for municipality
            setText('userProvince', user.province);
            setText('userRegion', user.region);
            setText('userZipCode', user.zip_code);
            // Example for a potentially missing field, ensure 'userDateGraduated' ID exists if used
            // setText('userDateGraduated', user.date_graduated_formatted);


            if (userRequestsListDiv) {
                userRequestsListDiv.innerHTML = ''; // Clear loading/previous
                if (requests && requests.length > 0) {
                    const ul = document.createElement('ul');
                    ul.className = 'details-list';
                    requests.forEach(req => {
                        const li = document.createElement('li');
                        li.className = 'request-item';
                        li.innerHTML = `
                            <p><strong>Document:</strong> ${req.document_name || 'Unknown'}</p>
                            <p><strong>Request ID:</strong> ${req.request_id}</p>
                            <p><strong>Status:</strong> <span class="status-${getStatusClass(req.request_status || 'unknown')}">${capitalize(req.request_status || 'Unknown')}</span></p>
                            <p><strong>Requested:</strong> ${req.request_date_formatted || 'N/A'}</p>
                            <p><strong>Expected Release:</strong> ${req.expected_release_date_formatted || 'N/A'}</p>
                            ${(req.actual_release_date_formatted && req.actual_release_date_formatted !== 'N/A') ? `<p><strong>Actual Release:</strong> ${req.actual_release_date_formatted}</p>` : ''}
                        `;
                        ul.appendChild(li);
                    });
                    userRequestsListDiv.appendChild(ul);
                } else {
                    userRequestsListDiv.innerHTML = '<p>No document requests found for this user.</p>';
                }
            }
        } else {
            const errorMessage = data.message || 'Could not load user details.';
            console.error('API Error for user details:', errorMessage);
            if (userRequestsListDiv) {
                userRequestsListDiv.innerHTML = `<p class="error-message">Error: ${errorMessage}</p>`;
            } else if (userDetailName) {
                 userDetailName.textContent = 'Error Loading Details';
            }
            alert(`Error: ${errorMessage}`);
        }
    })
    .catch(error => {
        console.error('Fetch/Network Error for user details:', error);
        const errorMessage = error.message || 'An unknown network error occurred.';
        if (userRequestsListDiv) {
            userRequestsListDiv.innerHTML = `<p class="error-message">Network or server error: ${errorMessage}</p>`;
        } else if (userDetailName) {
            userDetailName.textContent = 'Error Loading Details';
        }
        alert(`Network or server error: ${errorMessage}`);
    });
}

// Show request details in modal
function showRequestDetails(requestId) {
    const requestDetailModal = document.getElementById('requestDetailModal');
    
    // Clear previous data and show modal
    document.getElementById('detailRequestId').textContent = '';
    document.getElementById('detailDocumentName').textContent = '';
    document.getElementById('detailRequestDate').textContent = '';
    document.getElementById('detailReleaseDate').textContent = '';
    document.getElementById('detailPurpose').textContent = '';
    document.getElementById('detailQuantity').textContent = '';
    document.getElementById('detailUrgency').textContent = '';
    document.getElementById('detailStatus').textContent = '';
    document.getElementById('detailAmount').textContent = '';
    document.getElementById('detailPaymentStatus').textContent = '';
    document.getElementById('detailStudentId').textContent = '';
    document.getElementById('detailStudentName').textContent = '';
    document.getElementById('detailStudentEmail').textContent = '';
    document.getElementById('detailStudentCollege').textContent = '';
    document.getElementById('detailNotes').textContent = 'No notes provided';
    document.getElementById('updateRequestId').value = '';
    document.getElementById('updateStatus').value = 'pending';
    document.getElementById('adminNotes').value = '';
    
    requestDetailModal.style.display = 'flex';
    
    // Fetch request details from the server
    fetch('<?= base_url('admin/requests') ?>', {
        method: 'POST',
        body: new URLSearchParams({
            'request_id': requestId
        }),
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/x-www-form-urlencoded'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.requests && data.requests.length > 0) {
            const request = data.requests[0];
            
            // Set request details
            document.getElementById('detailRequestId').textContent = request.request_id;
            document.getElementById('detailDocumentName').textContent = request.document_name;
            document.getElementById('detailRequestDate').textContent = request.request_date_formatted;
            document.getElementById('detailReleaseDate').textContent = request.expected_release_date_formatted;
            document.getElementById('detailPurpose').textContent = request.purpose;
            document.getElementById('detailQuantity').textContent = request.quantity;
            document.getElementById('detailUrgency').textContent = request.is_urgent == 1 ? 'Urgent' : 'Regular';
            
            // Status with badge
            const statusClass = getStatusClass(request.request_status);
            document.getElementById('detailStatus').innerHTML = `<span class="status-badge ${statusClass}">${capitalize(request.request_status)}</span>`;
            
            document.getElementById('detailAmount').textContent = `₱${parseFloat(request.total_amount).toFixed(2)}`;
            document.getElementById('detailPaymentStatus').textContent = capitalize(request.payment_status);
            document.getElementById('detailStudentId').textContent = request.student_number;
            document.getElementById('detailStudentName').textContent = request.first_name + ' ' + request.last_name;
            document.getElementById('detailStudentEmail').textContent = request.email_address || '-';
            document.getElementById('detailStudentCollege').textContent = request.college || '-';
            
            // Set notes if available
            if (request.notes && request.notes.trim() !== '') {
                document.getElementById('detailNotes').textContent = request.notes;
            }
            
            // Set admin notes if available
            if (request.admin_notes && request.admin_notes.trim() !== '') {
                document.getElementById('adminNotes').value = request.admin_notes;
            }
            
            // Set up update form values
            document.getElementById('updateRequestId').value = request.request_id;
            document.getElementById('updateStatus').value = request.request_status;
            
            // Set up download receipt button
            document.getElementById('downloadRequestReceipt').href = `<?= base_url('student/download-receipt') ?>/${request.request_id}`;
        } else {
            alert('Failed to load request details.');
        }
    })
    .catch(error => {
        console.error('Error loading request details:', error);
        alert('An error occurred while loading request details.');
    });
}

// Update request status
function updateRequestStatus() {
    const requestId = document.getElementById('updateRequestId').value;
    const status = document.getElementById('updateStatus').value;
    const notes = document.getElementById('adminNotes').value;
    
    fetch('<?= base_url('admin/update-request-status') ?>', {
        method: 'POST',
        body: new URLSearchParams({
            'request_id': requestId,
            'status': status,
            'admin_notes': notes
        }),
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/x-www-form-urlencoded'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Request status updated successfully.');
            
            // Update the displayed status
            const statusClass = getStatusClass(status);
            document.getElementById('detailStatus').innerHTML = `<span class="status-badge ${statusClass}">${capitalize(status)}</span>`;
            
            // Refresh the requests table if it's visible
            if (document.getElementById('requestsPage').style.display !== 'none') {
                loadRequests();
            }
            
            // Refresh dashboard counters
            updateRequestCounts();
        } else {
            alert('Failed to update request status: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error updating request status:', error);
        alert('An error occurred while updating the request status.');
    });
}

// Helper function to get status class
function getStatusClass(status) {
    switch (status) {
        case 'pending': return 'status-pending';
        case 'processing': return 'status-processing';
        case 'ready': return 'status-ready';
        case 'completed': return 'status-completed';
        case 'canceled': return 'status-canceled';
        case 'declined': return 'status-declined';
        default: return 'status-default';
    }
}

// Helper function to capitalize first letter
function capitalize(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}
</script>
</body>
</html>
