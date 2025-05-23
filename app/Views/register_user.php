<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>APPLY - Registration Form</title>
  <meta name="viewport" content="width=900">
  <link rel="stylesheet" href="<?= base_url('css/register_css.css') ?>">
  <!--nilipat ko norman sa public/css folder -->
  <style>
    /* Basic styling for the modal */
    .modal {
      display: none;
      /* Hidden by default */
      position: fixed;
      /* Stay in place */
      z-index: 1000;
      /* Sit on top */
      left: 0;
      top: 0;
      width: 100%;
      /* Full width */
      height: 100%;
      /* Full height */
      overflow: auto;
      /* Enable scroll if needed */
      background-color: rgb(0, 0, 0);
      /* Fallback color */
      background-color: rgba(0, 0, 0, 0.4);
      /* Black w/ opacity */
      padding-top: 60px;
    }

    .modal-content {
      background-color: #fefefe;
      margin: 5% auto;
      /* 15% from the top and centered */
      padding: 20px;
      border: 1px solid #888;
      width: 80%;
      /* Could be more or less, depending on screen size */
      max-width: 400px;
      border-radius: 8px;
      text-align: center;
    }

    .modal-content h2 {
      margin-top: 0;
    }

    .modal-content input[type="text"] {
      width: calc(100% - 22px);
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .modal-content button {
      background-color: #4caf50;
      color: white;
      padding: 10px 15px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .modal-content button:hover {
      background-color: #45a049;
    }

    #verification-message {
      margin-top: 15px;
      font-size: 0.9em;
    }

    .error-message {
      color: red;
    }

    .success-message {
      color: green;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="header">
      <div class="header-icon">🗔</div>
      <span class="header-title">REGISTER</span>
    </div>

    <?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
      <?= session()->getFlashdata('error') ?>
    </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
      <ul>
      <?php foreach(session()->getFlashdata('errors') as $error): ?>
        <li><?= $error ?></li>
      <?php endforeach; ?>
      </ul>
    </div>
    <?php endif; ?>

    <form id="registrationForm" action="<?= base_url('register/store') ?>" method="post" autocomplete="off">
      <div class="form-row">        <div class="form-group">
          <label for="idnum">ID Number</label>
          <input type="text" id="idnum" name="idnum" value="<?= old('idnum') ?>">
          <button type="button" class="generate-id-btn" onclick="generateTempID()">Generate Temporary Student
            ID</button>
        </div>        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" onkeyup="checkPasswordStrength()">          <div id="password-strength-meter" class="password-strength-meter"></div>
          <div id="password-strength-text" class="password-strength-text"></div>
          <p class="password-requirements">
            Password should be at least 6 characters long and include uppercase, lowercase, numbers, and special characters for better security.
          </p>
        </div>
        <div class="form-group">
          <label for="password_confirm">Confirm Password</label>
          <input type="password" id="password_confirm" name="password_confirm">
        </div>
        <div class="form-group">
          <label for="college">College</label>
          <select id="college" name="college">
            <option>College of Engineering and Architecture</option>
            <option>College of Computer Studies</option>
            <option>College of Health Sciences</option>
            <option>College of Tourism, Hospitality and Business Management</option>
            <option>College of Technological and Development Education</option>
            <option>College of Arts and Sciences</option>
          </select>
        </div>        <div class="form-group">
          <label for="year_enrolled">Year Enrolled</label>
          <input type="number" id="year_enrolled" name="year_enrolled" min="1900" max="2099" placeholder="YYYY" value="<?= old('year_enrolled') ?>">
        </div>
        <div class="form-group">
          <label for="year_graduated">Year Graduated (if applicable)</label>
          <input type="number" id="year_graduated" name="year_graduated" min="1900" max="2099" placeholder="YYYY" value="<?= old('year_graduated') ?>">
        </div>
      </div>
      <div class="form-row">        <div class="form-group">
          <label for="fname">First Name</label>
          <input type="text" id="fname" name="fname" value="<?= old('fname') ?>">
        </div>
        <div class="form-group">
          <label for="lname">Last Name</label>
          <input type="text" id="lname" name="lname" value="<?= old('lname') ?>">
        </div>
        <div class="form-group">
          <label for="mname">Middle Name</label>
          <input type="text" id="mname" name="mname" value="<?= old('mname') ?>">
        </div>
      </div>
      <div class="form-row">        <div class="form-group">
          <label for="bdate">Birthdate</label>
          <input type="date" id="bdate" name="bdate" value="<?= old('bdate') ?>">
        </div>
        <div class="form-group">
          <label for="bplace">Birthplace</label>
          <input type="text" id="bplace" name="bplace" value="<?= old('bplace') ?>">
        </div>
        <div class="form-group">
          <label for="cspcemail">Email Address</label>
          <input type="email" id="cspcemail" name="cspcemail" value="<?= old('cspcemail') ?>">
        </div>
      </div>
      <div class="form-row">        <div class="form-group">
          <label for="mobile">Mobile No.</label>
          <input type="text" id="mobile" name="mobile" value="<?= old('mobile') ?>">
        </div>
        <div class="form-group">
          <label for="zipcode">Zip Code</label>
          <input type="text" id="zipcode" name="zipcode" value="<?= old('zipcode') ?>">
        </div>
        <div class="form-group">
          <label for="admission">Type of Admission</label>
          <select id="admission" name="admission">
            <option>Freshman</option>
            <option>Transferee</option>
            <option>Second Degree</option>
            <option>Cross-Enrollee</option>
          </select>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label for="region">Region</label>
          <select id="region" name="region" required>
            <option value="">Select Region</option>
          </select>
        </div>
        <div class="form-group">
          <label for="province">Province</label>
          <select id="province" name="province" required disabled>
            <option value="">Select Province</option>
          </select>
        </div>
        <div class="form-group">
          <label for="municipality">City/Municipality</label>
          <select id="municipality" name="municipality" required disabled>
            <option value="">Select City/Municipality</option>
          </select>
        </div>
      </div>
      <div class="form-row">        <div class="form-group">
          <label for="street">Street/Barangay</label>
          <input type="text" id="street" name="street" value="<?= old('street') ?>">
        </div>
      </div>      <div class="register-btn-row">
        <div class="login-link">
          <a href="<?= base_url('/') ?>">Already have an account? Login here</a>
        </div>
        <button type="submit" class="register-btn">
          <span class="register-icon">&#x27A1;</span> Register
        </button>
      </div>
    </form>

    <!-- Verification Modal -->
    <div id="verificationModal" class="modal">
      <div class="modal-content">
        <h2>Verify Your Email</h2>
        <p>A verification code has been sent to your email address. Please enter it below.</p>
        <input type="text" id="verification_code" name="verification_code" placeholder="Enter verification code" required>
        <button type="button" id="verifyCodeButton">Verify</button>
        <div id="verification-message"></div>
      </div>
    </div>

  </div>
  <script>
    function generateTempID() {
      // Generate a 9-digit numeric ID
      let tempId = '';
      for (let i = 0; i < 9; i++) {
        tempId += Math.floor(Math.random() * 10);
      }
      document.getElementById('idnum').value = tempId;
    }
    
    // Function to check password strength
    function checkPasswordStrength() {
      const password = document.getElementById('password').value;
      const meter = document.getElementById('password-strength-meter');
      const text = document.getElementById('password-strength-text');
      
      // Clear if password is empty
      if (password === '') {
        meter.style.width = '0';
        meter.className = 'password-strength-meter';
        text.innerHTML = '';
        return;
      }
      
      // Calculate password strength
      let strength = 0;
      // If password is 6 characters or more, add 1 point
      if (password.length >= 6) strength += 1;
      // If password has both lowercase and uppercase characters, add 1 point
      if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength += 1;
      // If password has at least one number, add 1 point
      if (password.match(/\d/)) strength += 1;
      // If password has at least one special character, add 1 point
      if (password.match(/[^a-zA-Z\d]/)) strength += 1;
      
      // Update the meter and text based on strength
      meter.className = 'password-strength-meter';
      
      switch (strength) {
        case 0:
        case 1:
          meter.classList.add('weak');
          meter.style.width = '25%';
          text.innerHTML = 'Weak';
          text.style.color = '#dc3545';
          break;
        case 2:
          meter.classList.add('medium');
          meter.style.width = '50%';
          text.innerHTML = 'Medium';
          text.style.color = '#ffc107';
          break;
        case 3:
          meter.classList.add('strong');
          meter.style.width = '75%';
          text.innerHTML = 'Strong';
          text.style.color = '#28a745';
          break;
        case 4:
          meter.classList.add('very-strong');
          meter.style.width = '100%';
          text.innerHTML = 'Very Strong';
          text.style.color = '#28a745';
          break;
      }
    }

    // Function to validate year inputs
    function validateYearInputs() {
      const yearEnrolled = document.getElementById('year_enrolled');
      const yearGraduated = document.getElementById('year_graduated');
      const currentYear = new Date().getFullYear();
      
      // Set max year to current year
      yearEnrolled.max = currentYear;
      yearGraduated.max = currentYear;
      
      // Add event listeners to validate years
      yearEnrolled.addEventListener('change', function() {
        if (this.value > currentYear) {
          alert('Year enrolled cannot be in the future.');
          this.value = currentYear;
        }
      });
      
      yearGraduated.addEventListener('change', function() {
        if (this.value > currentYear) {
          alert('Year graduated cannot be in the future.');
          this.value = currentYear;
        }
        
        if (yearEnrolled.value && this.value < yearEnrolled.value) {
          alert('Year graduated cannot be earlier than year enrolled.');
          this.value = yearEnrolled.value;
        }
      });
    }    document.addEventListener('DOMContentLoaded', function () {
      // Initialize year validation
      validateYearInputs();
      
      const registrationForm = document.getElementById('registrationForm');
      const verificationModal = document.getElementById('verificationModal');
      const verifyCodeButton = document.getElementById('verifyCodeButton');
      const verificationMessage = document.getElementById('verification-message');
      const verificationCodeInput = document.getElementById('verification_code');

      registrationForm.addEventListener('submit', async function(e) {
        e.preventDefault(); // Prevent default form submission

        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('password_confirm').value;
        
        if (password !== confirmPassword) {
          alert('Passwords do not match. Please check and try again.');
          return;
        }

        // Clear previous messages
        const existingAlerts = registrationForm.querySelectorAll('.alert.alert-danger, .alert.alert-success');
        existingAlerts.forEach(alert => alert.remove());
        verificationMessage.innerHTML = '';


        const formData = new FormData(registrationForm);
        const submitButton = registrationForm.querySelector('button[type="submit"]');
        submitButton.disabled = true;
        submitButton.innerHTML = '<span class="register-icon">Processing...</span>';

        try {
          const response = await fetch('<?= base_url('register/store') ?>', {
            method: 'POST',
            body: formData,
            headers: {
              'X-Requested-With': 'XMLHttpRequest' // Important for CodeIgniter to detect AJAX
            }
          });

          const result = await response.json();

          if (result.status === 'success') {
            // Show verification modal
            verificationModal.style.display = 'block';
            verificationMessage.textContent = result.message;
            verificationMessage.className = 'success-message';
          } else if (result.status === 'validation_error') {
            let errorHtml = '<div class="alert alert-danger"><ul>';
            for (const field in result.errors) {
              errorHtml += `<li>${result.errors[field]}</li>`;
            }
            errorHtml += '</ul></div>';
            registrationForm.insertAdjacentHTML('afterbegin', errorHtml);
          } else {
            // General error
            let errorHtml = `<div class="alert alert-danger">${result.message || 'An unexpected error occurred.'}</div>`;
            registrationForm.insertAdjacentHTML('afterbegin', errorHtml);
          }
        } catch (error) {
          console.error('Error submitting registration form:', error);
          let errorHtml = `<div class="alert alert-danger">An error occurred while submitting the form. Please try again.</div>`;
          registrationForm.insertAdjacentHTML('afterbegin', errorHtml);
        } finally {
            submitButton.disabled = false;
            submitButton.innerHTML = '<span class="register-icon">&#x27A1;</span> Register';
        }
      });

      verifyCodeButton.addEventListener('click', async function() {
        const code = verificationCodeInput.value;
        if (!code) {
          verificationMessage.textContent = 'Please enter the verification code.';
          verificationMessage.className = 'error-message';
          return;
        }

        verificationMessage.textContent = 'Verifying...';
        verificationMessage.className = '';
        verifyCodeButton.disabled = true;

        const formData = new FormData();
        formData.append('verification_code', code);
        // We might need to send the email if your controller needs it, 
        // but it should be in the session on the server-side.
        // formData.append('email', document.getElementById('cspcemail').value);


        try {
          const response = await fetch('<?= base_url('register/verify-email') ?>', {
            method: 'POST',
            body: formData,
            headers: {
              'X-Requested-With': 'XMLHttpRequest'
            }
          });

          const result = await response.json();

          if (result.status === 'success') {
            verificationMessage.textContent = result.message;
            verificationMessage.className = 'success-message';
            // Optionally, close modal and redirect or update UI
            setTimeout(() => {
              verificationModal.style.display = 'none';
              // Redirect to login or a success page
              window.location.href = '<?= base_url('/') ?>?verified=true'; // Adjust as needed
            }, 2000); // Wait 2 seconds before redirecting
          } else {
            verificationMessage.textContent = result.message || 'An error occurred during verification.';
            verificationMessage.className = 'error-message';
          }
        } catch (error) {
          console.error('Error verifying code:', error);
          verificationMessage.textContent = 'An error occurred. Please try again.';
          verificationMessage.className = 'error-message';
        } finally {
            verifyCodeButton.disabled = false;
        }
      });
      
      // Load regions
      fetch('<?= base_url('phjson/regions.json') ?>')
        .then(res => res.json())
        .then(regions => {
          const regionSelect = document.getElementById('region');
          regions.forEach(region => {
            let opt = document.createElement('option');
            opt.value = region.key;
            opt.textContent = region.long;
            regionSelect.appendChild(opt);
          });
        });

      // When region changes, load provinces
      document.getElementById('region').addEventListener('change', function () {
        const regionKey = this.value;
        const provinceSelect = document.getElementById('province');
        const municipalitySelect = document.getElementById('municipality');
        provinceSelect.innerHTML = '<option value="">Select Province</option>';
        municipalitySelect.innerHTML = '<option value="">Select City/Municipality</option>';
        provinceSelect.disabled = true;
        municipalitySelect.disabled = true;

        if (!regionKey) return;

        fetch('<?= base_url('phjson/provinces.json') ?>')
          .then(res => res.json())
          .then(provinces => {
            provinces.filter(p => p.region === regionKey)
              .forEach(province => {
                let opt = document.createElement('option');
                opt.value = province.key;
                opt.textContent = province.name;
                provinceSelect.appendChild(opt);
              });
            provinceSelect.disabled = false;
          });
      });

      // When province changes, load cities/municipalities
      document.getElementById('province').addEventListener('change', function () {
        const provinceKey = this.value;
        const municipalitySelect = document.getElementById('municipality');
        municipalitySelect.innerHTML = '<option value="">Select City/Municipality</option>';
        municipalitySelect.disabled = true;

        if (!provinceKey) return;

        fetch('<?= base_url('phjson/cities.json') ?>')
          .then(res => res.json())
          .then(cities => {
            cities.filter(c => c.province === provinceKey)
              .forEach(city => {
                let opt = document.createElement('option');
                opt.value = city.name;
                opt.textContent = city.name;
                municipalitySelect.appendChild(opt);
              });
            municipalitySelect.disabled = false;
          });
      });
    });
  </script>
</body>

</html>