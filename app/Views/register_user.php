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
      <span class="header-title">APPLY</span>
    </div>
    <form autocomplete="off">
      <div class="form-row">
        <div class="form-group">
          <label for="idnum">ID Number</label>
          <input type="text" id="idnum" name="idnum">
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password">
        </div>
        <div class="form-group">
          <label for="college">College</label>
          <select id="college" name="college">
            <option>College of Engineering and Architecture</option>
            <option>College of Arts and Sciences</option>
            <option>College of Business and Management</option>
            <option>College of Computer Studies</option>
            <option>College of Business Management</option>
            <option>College of Technological and Developmental Education</option>
            <option>College of Health and Sciences</option>
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
          <label for="street">Street/Barangay</label>
          <input type="text" id="street" name="street">
        </div>
        <div class="form-group">
          <label for="zipcode">Zip Code</label>
          <input type="text" id="zipcode" name="zipcode">
        </div>
      </div>
      <div class="register-btn-row">
        <button type="submit" class="register-btn">
          <span class="register-icon">&#x27A1;</span> Register
        </button>
      </div>
    </form>
  </div>
</body>
</html>