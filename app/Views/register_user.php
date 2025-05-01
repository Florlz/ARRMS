<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>APPLY - Registration Form</title>
  <meta name="viewport" content="width=900">
  <style>
    body {
      background: #120b24;
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Arial, sans-serif;
      color: #fff;
    }
    .container {
      width: 900px;
      margin: 30px auto 0 auto;
      padding: 0 0 20px 0;
      background: none;
    }
    .header {
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-bottom: 18px;
    }
    .header-icon {
      width: 65px;
      height: 52px;
      background: #fff;
      border-radius: 6px;
      border: 2px solid #bdbdbd;
      margin-bottom: 2px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 34px;
      color: #120b24;
      position: relative;
      box-sizing: border-box;
    }
    /* Simulate the small lock icon on the window */
    .header-icon::before {
      content: '';
      position: absolute;
      left: 8px;
      top: 8px;
      width: 10px;
      height: 14px;
      background: #ffe082;
      border-radius: 2px;
      border: 1.5px solid #bdbdbd;
    }
    .header-icon::after {
      content: '';
      position: absolute;
      left: 11px;
      top: 17px;
      width: 4px;
      height: 4px;
      background: #ffb300;
      border-radius: 50%;
    }
    .header-title {
      font-size: 2em;
      font-weight: bold;
      margin-top: 6px;
      letter-spacing: 1px;
    }
    form {
      margin-top: 10px;
    }
    .form-row {
      display: flex;
      flex-direction: row;
      gap: 18px;
      margin-bottom: 18px;
    }
    .form-group {
      flex: 1;
      display: flex;
      flex-direction: column;
    }
    label {
      font-weight: 600;
      margin-bottom: 4px;
      font-size: 1em;
      color: #fff;
    }
    input[type="text"],
    input[type="password"],
    input[type="email"],
    input[type="date"],
    select {
      padding: 7px 8px;
      border: none;
      border-radius: 2px;
      font-size: 1em;
      background: #120b24;
      color: #fff;
      outline: 1.5px solid #fff;
      transition: outline 0.2s;
      box-sizing: border-box;
    }
    input[type="text"]:focus,
    input[type="password"]:focus,
    input[type="email"]:focus,
    input[type="date"]:focus,
    select:focus {
      outline: 2px solid #bdbdbd;
    }
    .register-btn-row {
      display: flex;
      justify-content: flex-end;
      margin-top: 16px;
    }
    .register-btn {
      background: #120b24;
      color: #fff;
      border: 2px solid #fff;
      border-radius: 4px;
      padding: 7px 24px 7px 14px;
      font-size: 1.1em;
      font-weight: bold;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 8px;
      transition: background 0.2s, border 0.2s;
    }
    .register-btn:hover {
      background: #fff;
      color: #120b24;
      border-color: #bdbdbd;
    }
    .register-icon {
      font-size: 1.2em;
      margin-right: 2px;
    }
    @media (max-width: 950px) {
      .container {
        width: 99vw;
        padding: 0 2vw 20px 2vw;
      }
      .form-row {
        flex-direction: column;
        gap: 0;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <div class="header-icon">
        <!-- Simulated window icon, you may replace with an actual image if you want -->
        <span style="font-size: 28px; margin-left: 18px; margin-top: 8px;">🗔</span>
      </div>
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
          <option>College of Business Management </option>
          <option>College of Technological and Developmental Education </option>
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
          <label for="municipality">Municipality</label>
          <input type="text" id="municipality" name="municipality">
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label for="zipcode">Zip Code</label>
          <input type="text" id="zipcode" name="zipcode">
        </div>
        <div class="form-group">
          <label for="admission">Type of Admission</label>
          <input type="text" id="admission" name="admission">
        </div>
        <div class="form-group"></div>
      </div>
      <div class="register-btn-row">
        <button type="submit" class="register-btn">
          <span class="register-icon">&#x21B5;</span> Register
        </button>
      </div>
    </form>
  </div>
</body>
</html>
