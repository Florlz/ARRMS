<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login | ARRMS</title>
    <link rel="stylesheet" href="<?= base_url('css/login_css.css') ?>">
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
        <div style="margin-top: 18px; text-align: center;">
            <a href="<?= base_url('register_user') ?>" class="register-link-btn">Register here for ARRMS</a>
        </div>
        <div class="academic-footer">
            &copy; <?php echo date('Y'); ?> ARRMS | For academic use only
        </div>
    </div>
</body>
</html>