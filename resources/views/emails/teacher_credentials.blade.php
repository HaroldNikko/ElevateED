<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Welcome to ElevateEd</title>
  <style>
    body {
      background: #f2f4f8;
      font-family: 'Segoe UI', sans-serif;
      color: #333;
      padding: 10px;
    }

    .email-wrapper {
      max-width: 480px;
      margin: auto;
      background: #fff;
      border-radius: 12px;
      border: 1px solid #dce3ec;
      overflow: hidden;
    }

    .email-logo {
      text-align: center;
      padding: 12px;
      background: #ffffff;
    }

    .email-logo img {
      height: 40px;
    }

    .banner {
      background-color: #0C2340;
      color: white;
      text-align: center;
      padding: 16px;
      font-size: 20px;
      font-weight: bold;
    }

    .email-body {
      padding: 20px;
      font-size: 14px;
    }

    .credentials-box {
      background-color: #f4f8fd;
      border-left: 4px solid #0C2340;
      border-radius: 8px;
      padding: 14px;
      margin: 16px 0;
      font-size: 13px;
    }

    .credentials-box div {
      display: flex;
      margin-bottom: 10px;
    }

    .label {
      width: 90px;
      font-weight: 600;
    }

    .value {
      background: #fff;
      border: 1px solid #ccd6e2;
      padding: 4px 8px;
      border-radius: 5px;
      flex: 1;
      font-family: monospace;
    }

    .reminder-box {
      background: #ffecec;
      color: #b42c2c;
      padding: 12px;
      border-left: 4px solid #d43f3f;
      border-radius: 6px;
      font-size: 12px;
    }

    .cta {
      text-align: center;
      margin: 20px 0;
    }

    .cta a {
      background: #0C2340;
      color: #fff;
      padding: 8px 20px;
      text-decoration: none;
      border-radius: 6px;
      font-size: 14px;
    }

    .footer {
      background: #f4f6f8;
      padding: 12px;
      font-size: 11px;
      text-align: center;
      color: #666;
    }

    .footer a {
      color: #0C2340;
      text-decoration: none;
    }
  </style>
</head>
<body>

  <div class="email-wrapper">
    <div class="email-logo">
      <img src="https://i.postimg.cc/zXwb2Qmv/elevated.png" alt="ElevateEd Logo">
    </div>

    <div class="banner">
      Welcome to ElevateEd!
    </div>

    <div class="email-body">
      <p>Hi {{ $name ?? 'Teacher' }},</p>
      <p>You're now part of the ElevateEd platform. Here are your login credentials:</p>

      <div class="credentials-box">
        <div><span class="label">Username:</span><span class="value">{{ $email }}</span></div>
        <div><span class="label">Password:</span><span class="value">{{ $password }}</span></div>
      </div>

      <div class="reminder-box">
        🔒 Please change your password after first login.
      </div>

      <div class="cta">
        <a href="http://127.0.0.1:8000/login">Go to Login</a>
      </div>
    </div>

    <div class="footer">
      Need help? Email <a href="mailto:support@elevated.edu.ph">support@elevated.edu.ph</a><br>
      &copy; {{ date('Y') }} ElevateEd
    </div>
  </div>

</body>
</html>
