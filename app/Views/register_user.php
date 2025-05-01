<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #1e272e; /* Dark background */
            color: #f5f6fa; /* Light text */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #2c3e50; /* Darker container background */
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            width: 450px; /* Adjust width as needed */
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #ecf0f1;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #bdc3c7;
            font-size: 0.9em;
        }

        input[type="text"],
        input[type="password"],
        input[type="date"],
        input[type="email"],
        select {
            width: calc(100% - 12px);
            padding: 8px;
            border: 1px solid #34495e;
            border-radius: 4px;
            background-color: #34495e;
            color: #f5f6fa;
            box-sizing: border-box;
        }

        select {
            appearance: none; /* Remove default arrow */
            background-image: url('data:image/svg+xml;utf8,<svg fill="#f5f6fa" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/><path d="M0 0h24v24H0z" fill="none"/></svg>');
            background-repeat: no-repeat;
            background-position-x: 95%;
            background-position-y: 50%;
        }

        .grid-container {
            display: grid;
            grid-template-columns: auto auto auto;
            gap: 10px;
        }

        .grid-item {
            width: 100%;
        }

        .grid-item:nth-child(3n) {
            grid-column: 3 / 3; /* Force to the third column */
        }

        .btn-register {
            background-color: #27ae60;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            width: 100%;
            box-sizing: border-box;
        }

        .btn-register:hover {
            background-color: #219653;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo-container img {
            max-width: 80px; /* Adjust size as needed */
            height: auto;
        }

        .logo-container h2 {
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo-container">
            <img src="your-logo.png" alt="Logo">
            <h2>APPLY</h2>
        </div>
        <form action="register_user.php" method="POST">
            <div class="grid-container">
                <div class="grid-item form-group">
                    <label for="IDNumber">ID Number</label>
                    <input type="text" id="IDNumber" name="IDNumber" required>
                </div>
                <div class="grid-item form-group">
                    <label for="Password">Password</label>
                    <input type="password" id="Password" name="Password" required>
                </div>
                <div class="grid-item form-group">
                    <label for="College">College</label>
                    <select id="College" name="College">
                        <option>College of Engineering and Architecture</option>
                        <option>College of Arts and Sciences</option>
                        <option>College of Business and Management</option>
                        <option>College of Computer Studies</option>
                        <option>College of Business Management </option>
                        <option>College of Technological and Developmental Education </option>
                        <option>College of Health and Sciences</option>
                        </select>
                </div>
                <div class="grid-item form-group">
                    <label for="FirstName">First Name</label>
                    <input type="text" id="FirstName" name="FirstName" required>
                </div>
                <div class="grid-item form-group">
                    <label for="LastName">Last Name</label>
                    <input type="text" id="LastName" name="LastName" required>
                </div>
                <div class="grid-item form-group">
                    <label for="MiddleName">Middle Name</label>
                    <input type="text" id="MiddleName" name="MiddleName">
                </div>
                <div class="grid-item form-group">
                    <label for="Birthdate">Birthdate</label>
                    <input type="date" id="Birthdate" name="Birthdate">
                </div>
                <div class="grid-item form-group">
                    <label for="Birthplace">Birthplace</label>
                    <input type="text" id="Birthplace" name="Birthplace">
                </div>
                <div class="grid-item form-group">
                    <label for="CSPC Email Address">CSPC Email Address</label>
                    <input type="email" id="CSPC Email Address" name="CSPC Email Address" required>
                </div>
                <div class="grid-item form-group">
                    <label for="Mobile No.">Mobile No.</label>
                    <input type="text" id="Mobile No." name="Mobile No.">
                </div>
                <div class="grid-item form-group">
                    <label for="Street/Barangay">Street/Barangay</label>
                    <input type="text" id="Street/Barangay" name="Street/Barangay">
                </div>
                <div class="grid-item form-group">
                    <label for="Municipality">Municipality</label>
                    <input type="text" id="Municipality" name="Municipality">
                </div>
                <div class="grid-item form-group">
                    <label for="Zip Code">Zip Code</label>
                    <input type="text" id="Zip Code" name="Zip Code">
                </div>
                <div class="grid-item form-group">
                    <label for="Type of Admission">Type of Admission</label>
                    <input type="text" id="Type of Admission" name="Type of Admission">
                </div>
                <div class="grid-item">
                    <button type="submit" class="btn-register">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                        Register
                    </button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>