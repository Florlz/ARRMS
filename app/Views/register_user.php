<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>APPLY - Registration Form</title>
  <meta name="viewport" content="width=900">
  <link rel="stylesheet" href="<?= base_url('css/register_css.css') ?>">
  <!--nilipat ko norman sa public/css folder -->
</head>

<body>  <div class="container">
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
    
    <form action="<?= base_url('register/store') ?>" method="post" autocomplete="off">
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
  </div>  <script>
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
      
      // Add password confirmation validation
      document.querySelector('form').addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('password_confirm').value;
        
        if (password !== confirmPassword) {
          e.preventDefault();
          alert('Passwords do not match. Please check and try again.');
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