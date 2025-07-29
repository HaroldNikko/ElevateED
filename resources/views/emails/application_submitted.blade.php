<!DOCTYPE html>
<html>
<head>
  <style>
    body {
      font-family: "Segoe UI", Roboto, Arial, sans-serif;
      color: #333;
      background-color: #f9f9f9;
      margin: 0;
      padding: 40px 20px;
    }
    .email-container {
      max-width: 600px;
      margin: auto;
      background: #ffffff;
      padding: 30px 40px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .email-header {
      font-size: 24px;
      font-weight: bold;
      color: #0C2340;
      margin-bottom: 20px;
    }
    .email-body p {
      font-size: 16px;
      line-height: 1.6;
      margin: 10px 0;
    }
    .applicant-id {
      display: inline-block;
      font-family: monospace;
      background-color: #f0f0f0;
      padding: 6px 10px;
      border-radius: 4px;
      font-size: 16px;
      margin-top: 4px;
    }
    .cta-container {
      text-align: center;
      margin-top: 20px;
    }
    .cta-button {
      display: inline-block;
      background-color: #0C2340;
      color: white !important;
      padding: 12px 20px;
      text-decoration: none;
      border-radius: 5px;
      font-size: 16px;
    }
    .cta-button:hover {
      color: white !important;
      text-decoration: none;
      opacity: 0.9; /* subtle hover feedback */
    }
    .email-footer {
      font-size: 14px;
      color: #888;
      margin-top: 30px;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="email-container">
    <div class="email-header">
      Application Submitted Successfully
    </div>

    <div class="email-body">
      <p>Dear <strong>{{ $fullname }}</strong>,</p>

      <p>Your application has been successfully submitted. Thank you for applying!</p>

      <p><strong>Your Applicant ID:</strong></p>
      <div class="applicant-id">{{ $applicantID }}</div>

      <p>To view your evaluation results, click the button below:</p>

      <div class="cta-container">
        <a href="{{ url('/results?applicantID=' . urlencode($applicantID)) }}" class="cta-button">
          View My Evaluation Results
        </a>
      </div>

      <p class="email-footer">
        Best regards,<br>ElevateEd Team
      </p>
    </div>
  </div>
</body>
</html>
