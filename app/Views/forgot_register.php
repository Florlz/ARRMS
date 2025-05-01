<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forgot ID Number Registration</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      background: #18102A;
      font-family: 'Segoe UI', Arial, sans-serif;
      margin: 0;
      padding: 0;
      color: #fff;
    }
    .container {
      width: 700px;
      margin: 40px auto;
      background: transparent;
      border-radius: 12px;
      padding: 36px 40px 30px 40px;
      box-sizing: border-box;
      box-shadow: 0 0 8px 0 rgba(0,0,0,0.3);
    }
    .header {
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 24px;
    }
    .header-icon {
      width: 48px;
      height: 48px;
      background: #fff;
      border-radius: 8px;
      margin-right: 16px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 28px;
      color: #18102A;
      border: 2px solid #bdbdbd;
    }
    .header-title {
      font-size: 1.7em;
      font-weight: bold;
      letter-spacing: 0.5px;
    }
    form {
      width: 100%;
    }
    .form-row {
      display: flex;
      flex-wrap: wrap;
      gap: 18px;
      margin-bottom: 18px;
    }
    .form-group {
      flex: 1;
      display: flex;
      flex-direction: column;
      min-width: 200px;
    }
    label {
      font-weight: 600;
      margin-bottom: 6px;
      font-size: 1em;
      color: #fff;
    }
    input[type="text"],
    input[type="password"],
    input[type="email"],
    input[type="date"],
    select {
      padding: 8px 10px;
      border: none;
      border-radius: 5px;
      font-size: 1em;
      background: #231A38;
      color: #fff;
      outline: 2px solid #312453;
      transition: outline 0.2s;
    }
    input[type="text"]:focus,
    input[type="password"]:focus,
    input[type="email"]:focus,
    input[type="date"]:focus,
    select:focus {
      outline: 2px solid #7c4dff;
    }
    .register-btn-row {
      display: flex;
      justify-content: flex-end;
      margin-top: 22px;
    }
    .register-btn {
      background: #231A38;
      color: #fff;
      border: 2px solid #7c4dff;
      border-radius: 7px;
      padding: 9px 30px 9px 18px;
      font-size: 1.1em;
      font-weight: bold;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 7px;
      transition: background 0.2s, border 0.2s;
    }
    .register-btn:hover {
      background: #7c4dff;
      border-color: #fff;
      color: #18102A;
    }
    .register-icon {
      font-size: 1.3em;
    }
    @media (max-width: 900px) {
      .container {
        width: 97vw;
        padding: 18px 6vw;
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
      <div class="header-icon">🔑</div>
      <span class="header-title">Forgot ID Number</span>
    </div>
    <form autocomplete="off">
      <div class="form-row">
        <div class="form-group">
          <label for="email">Email Address</label>
          <input type="email" id="email" name="email">
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
          <input type="date" id="bdate" name="bdate" value="2004-05-13">
        </div>
        <div class="form-group">
          <label for="bplace">Birthplace</label>
          <input type="text" id="bplace" name="bplace">
        </div>
        <div class="form-group">
          <label for="municipality">Municipality</label>
          <input type="text" id="municipality" name="municipality">
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