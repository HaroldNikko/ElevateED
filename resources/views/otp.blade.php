<!DOCTYPE html>
<html lang="en">
<head>
  <title>Enter OTP</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center min-vh-100">

  <div class="card shadow p-4" style="width: 400px;">
    <h4 class="mb-3 text-primary">OTP Verification</h4>
    <form action="{{ route('verify.otp') }}" method="POST">
      @csrf
      <label for="otp">Enter 6-digit code sent to your email:</label>
      <input type="text" name="otp" id="otp" class="form-control mb-3" maxlength="6" required>
      <button class="btn btn-primary w-100">Verify</button>
    </form>
    @if(session('error'))
      <div class="alert alert-danger mt-3">{{ session('error') }}</div>
    @endif
  </div>

</body>
</html>
