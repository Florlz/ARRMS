<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .sidebar {
            width: 200px;
            background-color: #0c1c52;
            color: white;
            height: 100vh;
            float: left;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .sidebar .menu {
            padding: 20px;
        }
        .sidebar img {
            width: 100px;
            margin: 20px auto;
            display: block;
        }
        .sidebar .menu-item {
            margin: 10px 0;
            cursor: pointer;
        }
        .menu-item:hover {
            text-decoration: underline;
        }
        .logout {
            background-color: red;
            border: none;
            padding: 10px;
            color: white;
            cursor: pointer;
            margin: 20px;
        }
        .content {
            margin-left: 200px;
            padding: 20px;
        }
        .header {
            background-color: #001845;
            color: white;
            padding: 10px;
            font-size: 20px;
        }
        .card {
            margin-top: 20px;
            background-color: white;
            border: 1px solid #ccc;
            padding: 20px;
        }
        .tabs {
            display: flex;
            margin-bottom: 10px;
        }
        .tab {
            padding: 10px 20px;
            border: 1px solid #ccc;
            background: #f4f4f4;
            margin-right: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        .form-row {
            display: flex;
            margin-bottom: 10px;
        }
        .form-group {
            flex: 1;
            margin-right: 10px;
        }
        .form-group label {
            display: block;
            margin-bottom: 4px;
        }
        .form-group input {
            width: 100%;
            padding: 6px;
            border: 1px solid #ccc;
        }
        .btn-edit {
            background-color: darkblue;
            color: white;
            padding: 8px 16px;
            border: none;
            cursor: pointer;
            float: right;
        }
        .footer {
            padding: 10px;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="menu">
        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="User Icon">
        <p>Welcome &lt;Name&gt;</p>
        <div class="menu-item">📄 View Profile</div>
        <div class="menu-item">📤 Request Documents</div>
        <div class="menu-item">📋 View Request Status</div>
    </div>
    <form method="post" action="/logout">
        <button class="logout">Log out</button>
    </form>
</div>

<div class="content">
    <div class="header">USER DASHBOARD</div>

    <div class="card">
        <h2>Profile</h2>
        <div class="tabs">
            <div class="tab">Profile</div>
            <div class="tab">Address Details</div>
        </div>
        <form>
            <div class="form-row">
                <div class="form-group">
                    <label>ID Number:</label>
                    <input type="text" name="id_number">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>First Name:</label>
                    <input type="text" name="first_name">
                </div>
                <div class="form-group">
                    <label>Last Name:</label>
                    <input type="text" name="last_name">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Middle Name:</label>
                    <input type="text" name="middle_name">
                </div>
                <div class="form-group">
                    <label>College:</label>
                    <input type="text" name="college">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Birthdate:</label>
                    <input type="date" name="birthdate">
                </div>
                <div class="form-group">
                    <label>Birthplace:</label>
                    <input type="text" name="birthplace">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Type of Admission:</label>
                    <input type="text" name="admission_type">
                </div>
                <div class="form-group">
                    <label>Email Address:</label>
                    <input type="email" name="email">
                </div>
            </div>
            <button type="submit" class="btn-edit">Edit Details</button>
        </form>
    </div>
</div>

</body>
</html>
