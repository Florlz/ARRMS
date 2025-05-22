<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document Request Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #444;
        }
        .header p {
            margin: 5px 0;
            font-size: 14px;
        }
        .receipt-details {
            margin-bottom: 20px;
        }
        .receipt-details table {
            width: 100%;
            border-collapse: collapse;
        }
        .receipt-details th, .receipt-details td {
            padding: 8px 0;
            text-align: left;
            font-size: 14px;
        }
        .receipt-details th {
            width: 40%;
            font-weight: bold;
        }
        .receipt-details .total td {
            font-weight: bold;
            font-size: 16px;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #eee;
            font-size: 12px;
            color: #777;
        }
        .logo {
            max-width: 150px; /* Adjust as needed */
            margin-bottom: 10px;
        }
        .qr-code-section {
            text-align: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .qr-code-section img {
            max-width: 180px; /* Adjust size as needed */
            height: auto;
            border: 1px solid #eee;
            padding: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <!-- Optional: Add a logo if you have one -->
            <!-- <img src="path/to/your/logo.png" alt="Logo" class="logo"> -->
            <h1>Document Request Receipt</h1>
            <p>Alumnus Records Request Management System</p>
        </div>

        <div class="receipt-details">
            <table>
                <tr>
                    <th>Request ID:</th>
                    <td><?= esc($request['request_id'] ?? 'N/A') ?></td>
                </tr>
                <tr>
                    <th>Student Name:</th>
                    <td><?= esc(($request['student_first_name'] ?? '') . ' ' . ($request['student_middle_name'] ?? '') . ' ' . ($request['student_last_name'] ?? '')) ?></td>
                </tr>
                <tr>
                    <th>Student ID:</th>
                    <td><?= esc($request['student_id'] ?? 'N/A') ?></td>
                </tr>
                <tr>
                    <th>Document Name:</th>
                    <td><?= esc($request['document_name'] ?? 'N/A') ?></td>
                </tr>
                <tr>
                    <th>Quantity:</th>
                    <td><?= esc($request['quantity'] ?? 'N/A') ?></td>
                </tr>
                <tr>
                    <th>Purpose:</th>
                    <td><?= esc($request['purpose'] ?? 'N/A') ?></td>
                </tr>
                <tr>
                    <th>Request Date:</th>
                    <td><?= esc(isset($request['request_date']) ? date('F d, Y h:i A', strtotime($request['request_date'])) : 'N/A') ?></td>
                </tr>
                <tr>
                    <th>Processing Type:</th>
                    <td><?= esc(isset($request['is_urgent']) && $request['is_urgent'] ? 'Urgent' : 'Regular') ?></td>
                </tr>
                <?php if (isset($request['is_urgent']) && $request['is_urgent']): ?>
                <tr>
                    <th>Urgent Fee:</th>
                    <td>PHP <?= esc(number_format($request['urgent_fee'] ?? 0, 2)) ?></td>
                </tr>
                <?php endif; ?>
                <tr>
                    <th>Expected Release Date:</th>
                    <td><?= esc(isset($request['expected_release_date']) ? date('F d, Y', strtotime($request['expected_release_date'])) : 'N/A') ?></td>
                </tr>
                <tr class="total">
                    <td>Total Amount Due:</td>
                    <td>PHP <?= esc(number_format($request['total_amount'] ?? 0, 2)) ?></td>
                </tr>
            </table>
        </div>

        <?php if (!empty($qrCodeBase64)): ?>
        <div class="qr-code-section">
            <p>Scan QR Code for Request Verification</p>
            <img src="<?= esc($qrCodeBase64) ?>" alt="Request QR Code">
        </div>
        <?php endif; ?>

        <div class="footer">
            <p>Thank you for using ARRMS. Please keep this receipt for your records.</p>
            <p>Generated on: <?= date('F d, Y h:i A') ?></p>
        </div>
    </div>
</body>
</html>
