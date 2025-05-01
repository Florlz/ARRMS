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
      flex-wrap: wrap;
      gap: 24px; /* Increased gap between form groups */
      margin-bottom: 24px; /* Increased margin between rows */
    }
    .form-group {
      flex: 1;
      display: flex;
      flex-direction: column;
      min-width: 200px;
    }
    label {
      font-weight: 600;
      margin-bottom: 6px; /* Slightly increased spacing below labels */
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
      margin-top: 24px; /* Increased spacing above the button row */
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
    }
    @media (max-width: 950px) {
      .container {
        width: 99vw;
        padding: 0 2vw 20px 2vw;
      }
      .form-row {
        flex-direction: column;
        gap: 16px; /* Adjusted gap for smaller screens */
      }
    }
  </style>
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