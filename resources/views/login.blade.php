<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>ElevateEd Login - Bootstrap</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

  <style>
    body {
      background-color: #f8f9fa;
    }

    .icon-left {
      position: absolute;
      left: 10px;
      top: 75%;
      transform: translateY(-50%);
      color: #143154;
      font-size: 16px;
    }

    .eye-icon {
      position: absolute;
      right: 10px;
      top: 75%;
      transform: translateY(-50%);
      color: #143154;
      cursor: pointer;
    }

    .input-icon {
      padding-left: 35px;
    }

    .logo {
      width: 160px;
      position: absolute;
      top: 20px;
    }

    @media (max-width: 768px) {
      .row.w-75 {
        width: 100% !important;
        border-radius: 0 !important;
      }
    }

      .form-check-input:checked {
    background-color: #143154;
    border-color: #143154;
  }

  .form-check-input {
    border: 2px solid #143154;
  }
  </style>
</head>
<body>

  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="row w-75 shadow-lg rounded bg-white overflow-hidden">
      <!-- Left Image Section -->
      <div class="col-md-6 d-none d-md-flex flex-column align-items-center justify-content-center position-relative p-0">
        <img src="{{ asset('img/elevated.png') }}" class="logo mx-auto" alt="ElevateEd Logo">
        <img src="{{ asset('img/blank.png') }}" class="img-fluid mt-5 px-4" alt="Illustration">
      </div>

      <!-- Right Login Section -->
      <div class="col-md-6 p-5">
        <h2 class="fw-bold mb-4 text-dark">Welcome Back!</h2>

        @if(session('error'))
          <div class="alert alert-danger text-center">
            {{ session('error') }}
          </div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}">
          @csrf

          <!-- Email -->
          <div class="mb-4 position-relative">
            <label for="username" class="form-label fw-semibold">Username</label>
            <i class="fas fa-user icon-left"></i>
            <input type="text" name="username" value="{{ old('username') }}"
              class="form-control input-icon border-bottom rounded-0 border-top-0 border-start-0 border-end-0"
              id="username" placeholder="Enter your username" required>
          </div>


          <!-- Password -->
          <div class="mb-4 position-relative">
            <label for="password" class="form-label fw-semibold">Password</label>
            <i class="fas fa-lock icon-left"></i>
            <input type="password" name="password"
              class="form-control input-icon border-bottom rounded-0 border-top-0 border-start-0 border-end-0"
              id="password" placeholder="Enter your password" required>
            <i class="fas fa-eye eye-icon" id="togglePassword"></i>
          </div>

          <!-- Terms & Conditions Checkbox -->
<!-- Forgot Password & Terms Section -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
          <!-- Forgot Password -->

          <!-- Terms & Conditions -->
        <div class="form-check" style="color: #143154;">
          <input class="form-check-input me-1" type="checkbox" value="1" id="agreeTerms" required>
          <label class="form-check-label small" for="agreeTerms">
            I agree to the
            <a href="{{ route('consent') }}"
              class="text-decoration-underline fw-bold"
              style="color: #143154;"
              target="_blank">
              Terms and Conditions
            </a>
          </label>
        </div>

        <div>
            <a href="#" class="text-decoration-none small" style="color: #143154;">Forgot Password?</a>
        </div>
      </div>


          <!-- Login Button -->
          <div class="d-flex justify-content-center mt-4">
            <button type="submit"
              class="btn btn-primary w-75 rounded-pill"
              style="background-color: #143154; border: none;">Login</button>
          </div>

        </form>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Toggle password visibility -->
  <script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    togglePassword.addEventListener('click', () => {
      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);
      togglePassword.classList.toggle('fa-eye');
      togglePassword.classList.toggle('fa-eye-slash');
    });
    
   if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
  }
  </script>

</body>
</html>
