<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>APPLY - Registration Form</title>
  <meta name="viewport" content="width=900">
  <link rel="stylesheet" href="<?= base_url('css/register_css.css') ?>">
  <!--nilipat ko norman sa public/css folder -->
</head>

<body>
  <div class="container">
    <div class="header">
      <div class="header-icon">🗔</div>
      <span class="header-title">REGISTER</span>
    </div>
    <form action="<?= base_url('register/store') ?>" method="post" autocomplete="off">
      <div class="form-row">
        <div class="form-group">
          <label for="idnum">ID Number</label>
          <input type="text" id="idnum" name="idnum">
          <button type="button" class="generate-id-btn" onclick="generateTempID()">Generate Temporary Student
            ID</button>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password">
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
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label for="fname">First Name</label>
          <input type="text" id="fname" name="fname">
        </div>
        <div class="form-group">
          <label for="lname">Last Name</label>
          <input type="text" id="lname" name="lname">
        </div>
        <div class="form-group">
          <label for="mname">Middle Name</label>
          <input type="text" id="mname" name="mname">
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label for="bdate">Birthdate</label>
          <input type="date" id="bdate" name="bdate">
        </div>
        <div class="form-group">
          <label for="bplace">Birthplace</label>
          <input type="text" id="bplace" name="bplace">
        </div>
        <div class="form-group">
          <label for="cspcemail">CSPC Email Address</label>
          <input type="email" id="cspcemail" name="cspcemail">
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label for="mobile">Mobile No.</label>
          <input type="text" id="mobile" name="mobile">
        </div>
        <div class="form-group">
          <label for="zipcode">Zip Code</label>
          <input type="text" id="zipcode" name="zipcode">
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
      <div class="form-row">
        <div class="form-group">
          <label for="street">Street/Barangay</label>
          <input type="text" id="street" name="street">
        </div>
      </div>
      <div class="register-btn-row">
        <button type="submit" class="register-btn">
          <span class="register-icon">&#x27A1;</span> Register
        </button>
      </div>
    </form>
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

    document.addEventListener('DOMContentLoaded', function () {
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