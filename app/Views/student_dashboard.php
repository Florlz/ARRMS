<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="<?= base_url('css/student_css.css') ?>">
</head>
<body>

<?php $session = session(); ?>

<div class="container">
    <div class="sidebar">
        <div>
            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="User">
            <h3><?= esc($session->get('first_name') . ' ' . $session->get('last_name')) ?></h3>
            <p>Welcome <?= esc($session->get('first_name')) ?></p>
            <div class="nav">
                <div class="nav-item active"><i>📄</i>Profile</div>
                <div class="nav-item"><i>📤</i>Request Documents</div>
                <div class="nav-item"><i>📋</i>View Request Status</div>
            </div>
        </div>
        <form method="post" action="/logout">
            <button class="logout-btn">Log out</button>
        </form>
    </div>

    <div class="main-content">
        <div class="card">
            <h2>Profile Information</h2>
            <div id="profileDisplay">
                <div class="profile-row"><strong>ID Number:</strong> <?= esc($session->get('student_id')) ?></div>
                <div class="profile-row"><strong>Type of Admission:</strong> <?= esc($session->get('type_of_admission')) ?></div>
                <div class="profile-row"><strong>First Name:</strong> <?= esc($session->get('first_name')) ?></div>
                <div class="profile-row"><strong>Last Name:</strong> <?= esc($session->get('last_name')) ?></div>
                <div class="profile-row"><strong>Middle Name:</strong> <?= esc($session->get('middle_name')) ?></div>
                <div class="profile-row"><strong>College:</strong> <?= esc($session->get('college')) ?></div>
                <div class="profile-row"><strong>Birthdate:</strong> <?= esc($session->get('birthdate')) ?></div>
                <div class="profile-row"><strong>Birthplace:</strong> <?= esc($session->get('birthplace')) ?></div>
                <div class="profile-row"><strong>Email Address:</strong> <?= esc($session->get('email_address')) ?></div>
                <div class="profile-row"><strong>Mobile No.:</strong> <?= esc($session->get('mobile_no')) ?></div>
                <div class="profile-row"><strong>Zip Code:</strong> <?= esc($session->get('zip_code')) ?></div>
                <div class="profile-row"><strong>Street/Barangay:</strong> <?= esc($session->get('street_barangay')) ?></div>
                <div class="profile-row"><strong>Region:</strong> <?= esc($session->get('region')) ?></div>
                <div class="profile-row"><strong>Province:</strong> <?= esc($session->get('province')) ?></div>
                <div class="profile-row"><strong>City/Municipality:</strong> <?= esc($session->get('municipality')) ?></div>
            </div>
            <div class="button-row">
                <button type="button" id="editBtn" class="btn btn-save">Edit Details</button>
            </div>

            <!-- Edit form, hidden by default -->
            <form id="editProfileForm" style="display:none;">
                <div class="form-row">
                    <div class="form-group">
                        <label>ID Number</label>
                        <input type="text" name="student_id" value="<?= esc($session->get('student_id')) ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label>Type of Admission</label>
                        <input type="text" name="type_of_admission" value="<?= esc($session->get('type_of_admission')) ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" name="first_name" value="<?= esc($session->get('first_name')) ?>">
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" name="last_name" value="<?= esc($session->get('last_name')) ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Middle Name</label>
                        <input type="text" name="middle_name" value="<?= esc($session->get('middle_name')) ?>">
                    </div>
                    <div class="form-group">
                        <label>College</label>
                        <input type="text" name="college" value="<?= esc($session->get('college')) ?>">
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
                <div class="form-row">
                    <div class="form-group">
                        <label>Zip Code</label>
                        <input type="text" name="zip_code" value="<?= esc($session->get('zip_code')) ?>">
                    </div>
                    <div class="form-group">
                        <label>Street/Barangay</label>
                        <input type="text" name="street_barangay" value="<?= esc($session->get('street_barangay')) ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Region</label>
                        <input type="text" name="region" value="<?= esc($session->get('region')) ?>">
                    </div>
                    <div class="form-group">
                        <label>Province</label>
                        <input type="text" name="province" value="<?= esc($session->get('province')) ?>">
                    </div>
                    <div class="form-group">
                        <label>City/Municipality</label>
                        <input type="text" name="municipality" value="<?= esc($session->get('municipality')) ?>">
                    </div>
                </div>
                <div class="button-row">
                    <button type="button" id="cancelEditBtn" class="btn btn-discard">Cancel</button>
                    <button type="submit" class="btn btn-save">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal-bg" id="editModal">
    <div class="modal-content">
        <h3>Edit Mode</h3>
        <p>You can now edit your details. Click "Save" to update or "Cancel" to discard changes.</p>
        <button id="closeModalBtn">OK</button>
    </div>
</div>

<script>
const editBtn = document.getElementById('editBtn');
const profileDisplay = document.getElementById('profileDisplay');
const editProfileForm = document.getElementById('editProfileForm');
const editModal = document.getElementById('editModal');
const closeModalBtn = document.getElementById('closeModalBtn');
const cancelEditBtn = document.getElementById('cancelEditBtn');

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
    .then(response => response.json())
    .then(data => {
        if(data.success){
            alert('Profile updated successfully!');
            window.location.reload();
        } else {
            alert('Update failed. Please check your input.');
        }
    })
    .catch(() => alert('An error occurred while updating.'));
});
</script>

</body>
</html>