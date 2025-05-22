<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | ARRMS</title>
    <link rel="stylesheet" href="<?= base_url('css/login_css.css') ?>">
</head>
<body><div class="login-container">
        <div class="academic-header">
            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135755.png" alt="Academic Logo" class="academic-logo">
            <div class="academic-title">Alumnus Records & Registration</div>
            <div class="academic-subtitle">Login Portal</div>
        </div>
        
        <div class="login-tabs">
            <div class="tab-item active" data-tab="student">Student</div>
            <div class="tab-item" data-tab="admin">Administrator</div>
        </div>
        
        <div id="studentLoginForm" class="tab-content active">
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
                <a href="<?= base_url('register') ?>" class="register-link-btn">Register here for ARRMS</a>
            </div>
        </div>
        
        <div id="adminLoginForm" class="tab-content">
            <form action="/login/authenticate" method="post">
                <div class="form-group">
                    <label for="admin_id">Admin ID</label>
                    <input type="text" id="admin_id" name="student_id" value="admin" readonly>
                </div>
                <div class="form-group">
                    <label for="admin_password">Password</label>
                    <input type="password" id="admin_password" name="password" placeholder="Enter admin password" required>
                </div>
                <div>
                    <input type="submit" value="Login as Administrator">
                </div>
            </form>
        </div>
        
        <div class="academic-footer">
            &copy; <?php echo date('Y'); ?> ARRMS | For academic use only
        </div>    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.tab-item');
            const tabContents = document.querySelectorAll('.tab-content');
            
            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const targetTab = this.getAttribute('data-tab');
                    
                    // Update active tab
                    tabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Show correct content
                    tabContents.forEach(content => {
                        content.classList.remove('active');
                    });
                    document.getElementById(targetTab + 'LoginForm').classList.add('active');
                });
            });
        });
    </script>
</body>
</html>