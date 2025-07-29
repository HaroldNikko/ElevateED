<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Data Privacy Consent</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background: url('{{ asset('img/background.png') }}') no-repeat center center fixed;
      background-size: cover;
      backdrop-filter: blur(8px);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
    }

    .card {
      width: 90%;
      max-width: 600px;
      background-color: rgba(255, 255, 255, 0.6); /* semi-transparent white */
      border-radius: 1rem;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
      backdrop-filter: blur(15px); /* smooth glass effect */
      animation: fadeIn 0.4s ease-in-out;
    }

    .card-body {
      padding: 2rem;
      background-color: rgba(255, 255, 255, 0.5); /* subtle body transparency */
      border-radius: 1rem;
      color: #1a1a1a;
    }

    .btn-primary {
      background-color: #0C2340;
      border-color: #0C2340;
      font-weight: 600;
      letter-spacing: 0.5px;
    }

    .btn-primary:hover {
      background-color: #0a1c33;
      border-color: #0a1c33;
    }

    .btn-outline-secondary {
      border-color: #6c757d;
      color: #6c757d;
    }

    .btn-outline-secondary:hover {
      background-color: #6c757d;
      color: #fff;
    }

    .highlight {
      background-color: #f2f4f8;
      padding: 16px 20px;
      border-left: 4px solid #0C2340;
      border-radius: 8px;
      font-size: 15px;
      margin-bottom: 1.5rem;
      box-shadow: inset 0 0 4px rgba(0,0,0,0.03);
    }

    .form-check-label {
      font-size: 14.5px;
      letter-spacing: 0.3px;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: scale(0.95); }
      to { opacity: 1; transform: scale(1); }
    }

    @media (max-width: 480px) {
      .card-body {
        padding: 1.5rem;
      }

      .btn {
        width: 100%;
        margin-bottom: 10px;
      }

      .d-flex.justify-content-between {
        flex-direction: column;
      }
    }
  </style>
</head>
<body>

  <div class="card shadow-lg">
    <div class="card-body">
      <h4 class="card-title text-primary mb-3">🔐 Data Privacy Consent</h4>
      <div class="highlight">
        Your <strong>name</strong>, <strong>email address</strong>, and <strong>login history</strong> will be collected and securely stored for account management and security purposes in line with our data protection policies.
      </div>
    </div>
  </div>

</body>
</html>
