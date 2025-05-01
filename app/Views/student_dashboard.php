<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f7f7f7;
            color: #333;
        }

        .container {
            display: flex;
        }

        .sidebar {
            width: 230px;
            background-color: #ffffff;
            box-shadow: 2px 0 5px rgba(0,0,0,0.05);
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border-top-right-radius: 16px;
            border-bottom-right-radius: 16px;
            height: 100vh;
        }

        .sidebar img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin: 0 auto 10px auto;
            object-fit: cover;
        }

        .sidebar h3 {
            text-align: center;
            margin: 5px 0;
        }

        .sidebar p {
            text-align: center;
            color: gray;
            font-size: 14px;
        }

        .sidebar .nav {
            margin-top: 30px;
        }

        .sidebar .nav-item {
            margin: 10px 0;
            padding: 10px;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            transition: background-color 0.2s ease;
        }

        .sidebar .nav-item:hover,
        .sidebar .nav-item.active {
            background-color: #ffe6cc;
        }

        .sidebar .nav-item i {
            margin-right: 10px;
        }

        .sidebar .logout-btn {
            padding: 10px;
            background-color: #ff4d4d;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 30px;
        }

        .main-content {
            flex: 1;
            padding: 30px;
        }

        .card {
            background-color: #ffffff;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            max-width: 900px;
            margin: auto;
        }

        .card h2 {
            margin-bottom: 20px;
        }

        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            flex: 1;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 14px;
            background-color: #f9f9f9;
        }

        .button-row {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-weight: 500;
        }

        .btn-discard {
            background-color: transparent;
            border: 1px solid #ffa64d;
            color: #ffa64d;
        }

        .btn-save {
            background-color: #ffa64d;
            color: white;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="sidebar">
        <div>
            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="User">
            <h3>&lt;Name&gt;</h3>
            <p>Student</p>
            <div class="nav">
                <div class="nav-item active"><i>📄</i>View Profile</div>
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
            <form>
                <div class="form-row">
                    <div class="form-group">
                        <label>ID Number</label>
                        <input type="text" name="id_number">
                    </div>
                    <div class="form-group">
                        <label>Type of Admission</label>
                        <input type="text" name="admission_type">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" name="first_name">
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" name="last_name">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Middle Name</label>
                        <input type="text" name="middle_name">
                    </div>
                    <div class="form-group">
                        <label>College</label>
                        <input type="text" name="college">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Birthdate</label>
                        <input type="date" name="birthdate">
                    </div>
                    <div class="form-group">
                        <label>Birthplace</label>
                        <input type="text" name="birthplace">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email">
                    </div>
                </div>

                <div class="button-row">
                    <button type="reset" class="btn btn-discard">Discard Changes</button>
                    <button type="submit" class="btn btn-save">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
