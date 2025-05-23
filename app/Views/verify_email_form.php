<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify Your Email - ARRMSApp</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('css/register_css.css') ?>"> <!-- Keep for consistency if needed -->
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f0f2f5; /* Light grey background */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }
        .container {
            background-color: #ffffff; /* White container */
            padding: 40px;
            border-radius: 10px; /* Slightly more rounded corners */
            box-shadow: 0 4px 12px rgba(0,0,0,0.15); /* Softer, more modern shadow */
            width: 100%;
            max-width: 480px; /* Slightly wider for better spacing */
            text-align: center;
        }
        h2 {
            color: #1c2b36; /* Darker, more professional title color */
            margin-bottom: 25px;
            font-size: 24px;
            font-weight: 600;
        }
        p {
            color: #4a5568; /* Softer text color */
            margin-bottom: 20px;
            line-height: 1.6;
            font-size: 16px;
        }
        p.info-text {
            margin-bottom: 30px; /* More space before the form */
        }
        .form-group {
            margin-bottom: 25px;
            text-align: left;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500; /* Medium font weight for labels */
            color: #2d3748;
            font-size: 14px;
        }
        input[type="text"], input[type="number"] {
            width: 100%; /* Full width */
            padding: 12px 15px;
            border: 1px solid #cbd5e0; /* Lighter border */
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 16px;
            transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }
        input[type="text"]:focus, input[type="number"]:focus {
            border-color: #007bff; /* Highlight focus with primary color */
            box-shadow: 0 0 0 3px rgba(0,123,255,0.25);
            outline: none;
        }
        button[type="submit"] {
            background-color: #007bff; /* Primary blue */
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            width: 100%;
            box-sizing: border-box;
            transition: background-color 0.2s ease;
        }
        button[type="submit"]:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
        .alert {
            padding: 15px;
            margin-bottom: 25px;
            border: 1px solid transparent;
            border-radius: 6px;
            text-align: left;
            font-size: 15px;
        }
        .alert-success {
            color: #0f5132;
            background-color: #d1e7dd;
            border-color: #badbcc;
        }
        .alert-danger {
            color: #842029;
            background-color: #f8d7da;
            border-color: #f5c2c7;
        }
        .alert-danger ul {
            margin: 0;
            padding-left: 20px;
        }
        .resend-link a {
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
        }
        .resend-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Verify Your Email Address</h2>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= esc(session()->getFlashdata('success')) ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <p class="info-text">A 6-digit verification code has been sent to the email address you provided. Please enter the code below to complete your registration.</p>
        
        <form action="<?= base_url('register/verify-email') ?>" method="post" autocomplete="off">
            <?= csrf_field() ?>
            <div class="form-group">
                <label for="verification_code">Verification Code</label>
                <input type="text" id="verification_code" name="verification_code" value="<?= old('verification_code') ?>" required maxlength="6" pattern="[0-9]{6}" title="Enter the 6-digit code.">
            </div>
            <button type="submit">Verify Code</button>
        </form>

        <p style="margin-top: 30px; font-size: 14px;" class="resend-link">If you didn't receive the email, please check your spam folder or <a href="<?= base_url('register') ?>">try registering again</a>.</p>
    </div>
</body>
</html>
