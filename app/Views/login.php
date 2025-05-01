<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login | ARRMS</title>
    <style>
        body {
            font-family: 'Segoe UI', 'Roboto', Arial, sans-serif;
            background: linear-gradient(120deg, #e0e7ff 0%, #f4f4f4 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: #fff;
            padding: 40px 32px 32px 32px;
            border-radius: 12px;
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.08);
            width: 340px;
            border-top: 6px solid #2e4a7d;
        }
        .academic-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 24px;
        }
        .academic-logo {
            width: 60px;
            height: 60px;
            margin-bottom: 10px;
        }
        .academic-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #2e4a7d;
            margin-bottom: 2px;
        }
        .academic-subtitle {
            font-size: 0.98rem;
            color: #555;
            margin-bottom: 8px;
        }
        h2 {
            text-align: center;
            margin-bottom: 18px;
            color: #2e4a7d;
            font-size: 1.2rem;
            letter-spacing: 1px;
        }
        label {
            display: block;
            margin-bottom: 6px;
            color: #2e4a7d;
            font-weight: 500;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 11px;
            margin-bottom: 18px;
            border: 1px solid #bfc8e6;
            border-radius: 5px;
            box-sizing: border-box;
            background: #f7faff;
            font-size: 1rem;
            transition: border 0.2s;
        }
        input[type="text"]:focus,
        input[type="password"]:focus {
            border: 1.5px solid #2e4a7d;
            outline: none;
            background: #eef3fb;
        }
        input[type="submit"] {
            width: 100%;
            padding: 11px;
            background-color: #2e4a7d;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.08rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: background 0.2s;
        }
        input[type="submit"]:hover {
            background-color: #1a2d4d;
        }
        .form-group {
            margin-bottom: 18px;
        }
        .academic-footer {
            text-align: center;
            margin-top: 18px;
            font-size: 0.92rem;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="academic-header">
            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135755.png" alt="Academic Logo" class="academic-logo">
            <div class="academic-title">Academic Records & Registration</div>
            <div class="academic-subtitle">Student Portal Login</div>
        </div>
        <form action="/login/authenticate" method="post">
            <div class="form-group">
                <label for="student_id">Student ID</label>
                <input type="text" id="student_id" name="student_id" placeholder="Enter your student ID" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <div>
                <input type="submit" value="Login">
            </div>
        </form>
        <div class="academic-footer">
            &copy; <?php echo date('Y'); ?> ARRMS | For academic use only
        </div>
    </div>
</body>
</html>