<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ElevateEd Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script src="{{ asset('js/dashboard.js') }}"></script>


  <style>
     .dropdown-menu-center {
    left: 50% !important;
    transform: translateX(-50%) !important;
    right: auto !important;
  }
  .dropdown-item {
  background-color: #f9f9f9;
  border-radius: 8px;
  margin-bottom: 6px;
}

  </style>
 
</head>
<body>

 <header class="fixed-header">
  <div class="brand-container d-flex align-items-center" style="gap: 0.4rem;">
    
    {{-- Elevate text --}}
    <div class="brand-text" id="brandText" style="font-size: 2rem; font-weight: 800;">
      <span style="color: #0C2340;">Elevate</span>
    </div>

    

{{-- Ed logo combo --}}
<div class="d-flex align-items-end logo-ed-combo" style="height: 42px;margin-left: -12px;margin-top: 7px;">
  <img src="{{ asset('img/logo_ele.png') }}" alt="E Logo" 
       style="width: 40px; height: 40px; object-fit: cover;">
  <span id="brandLetterD" class="logo-d" style="color: #e4002b; font-size: 2rem; font-weight: 800; margin-left: -3px;">d</span>
</div>


    {{-- Sidebar toggle --}}
    <div class="menu-toggle ms-1" onclick="toggleSidebar()">
      <i class="fas fa-bars" id="menuIcon"></i>
    </div>
  </div>

<div class="d-flex align-items-center gap-4">
  {{-- Notification Bell --}}
  <div class="dropdown position-relative">
    <a href="#" class="text-dark" data-bs-toggle="dropdown" aria-expanded="false" onclick="markNotificationsAsRead()">
      <i class="fas fa-bell fs-5"></i>
      @if($unreadCount > 0)
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 10px;">
          {{ $unreadCount }}
        </span>
      @endif
    </a>

    <ul class="dropdown-menu dropdown-menu-center mt-4 py-2 px-2 shadow-sm"
        style="min-width: 220px; border-radius: 10px; font-size: 13px; padding: 0.5rem 0.75rem;">

      <li>
        <span class="dropdown-item-text small text-muted text-center">
          You have {{ $unreadCount }} new notifications
        </span>
      </li>

      <li><hr class="dropdown-divider my-2"></li>

      @foreach($notifications as $note)
        <li>
          <a class="dropdown-item py-2 px-2 text-wrap"
             href="{{ route('teacher.applicant', ['notification' => $note->id]) }}"
             style="font-size: 13px; white-space: normal; text-align: justify; line-height: 1.5;">

            <div>
              {{-- Notification message --}}
              <div>{{ $note->message }}</div>

              {{-- Timestamp below message --}}
              <div class="text-end mt-1">
                <small class="text-muted" style="font-size: 11px;">
                  {{ \Carbon\Carbon::parse($note->created_at)->diffForHumans([
                      'parts' => 1,
                      'short' => false,
                      'syntax' => \Carbon\CarbonInterface::DIFF_RELATIVE_TO_NOW
                  ]) }}
                </small>
              </div>
            </div>

          </a>
        </li>
      @endforeach

    </ul>
  </div>





    {{-- Profile Dropdown --}}
    <div class="dropdown">
      <div class="dropdown-toggle d-flex align-items-center"
           data-bs-toggle="dropdown" role="button" aria-expanded="false"
           style="cursor: pointer;">
        <img src="{{ asset('img/' . (session('profile') ?? 'user_prof.png')) }}"
             alt="Profile"
             class="rounded-circle"
             style="width: 38px; height: 38px; object-fit: cover; border: 1px solid #ccc;">
        <div class="ms-2 d-flex flex-column">
          <strong class="text-dark" style="font-size: 15px;">{{ session('firstname') }} {{ session('lastname') }}</strong>
          <span class="text-muted" style="font-size: 13px;">({{ session('role') }})</span>
        </div>
      </div>
      <ul class="dropdown-menu dropdown-menu-end mt-2 py-2 px-2 shadow-sm" style="min-width: 200px; border-radius: 10px;">
        <li>
          <a class="dropdown-item text-center rounded" href="{{ route('profile_teacher') }}" style="font-size: 14px;">
            <i class="fas fa-user me-2"></i> View Account
          </a>
        </li>
        <li>
          <a class="dropdown-item text-center rounded" href="#" data-bs-toggle="modal" data-bs-target="#changePasswordModal" style="font-size: 14px;">
            <i class="fas fa-key me-2 text-secondary"></i> Change Password
          </a>
        </li>
      </ul>
    </div>
  </div>
</header>



  <!-- Sidebar -->
  <aside id="sidebar" class="sidebar">
    <div>
      <ul class="nav flex-column">
        <li class="nav-item">
          <a href="{{ route('teacher.dashboard') }}" class="nav-link {{ Route::is('teacher.dashboard') ? 'active' : '' }}">
            <i class="fas fa-home me-2"></i> <span>Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('teacher.applicant') }}" class="nav-link {{ Route::is('teacher.applicant') ? 'active' : '' }}">
            <i class="fas fa-home me-2"></i> <span>Applicant</span>
          </a>
        </li>
      </ul>
    </div>

    <!-- Footer Logout -->
    <div class="sidebar-footer">
      <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#logoutConfirmModal">
        <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
      </a>
    </div>

  </aside>

 <!-- Logout Confirmation Modal -->
<div class="modal fade" id="logoutConfirmModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content text-center p-4 rounded-4">
      <div class="modal-body">

        <!-- Icon -->
        <i class="fas fa-sign-out-alt fa-2x mb-3" style="color: #0C2340;"></i>

        <!-- Confirmation Text -->
        <p class="fw-bold mb-3">Are you sure you want to logout?</p>

        <!-- Buttons with spacing -->
        <div class="d-flex justify-content-center">
          <!-- Cancel Button -->
          <button type="button" class="btn btn-outline-secondary btn-sm me-2" data-bs-dismiss="modal">
            Cancel
          </button>

          <!-- Logout Button -->
          <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-sm text-white" style="background-color: #0C2340;">
              Logout
            </button>
          </form>
        </div>

      </div>
    </div>
  </div>
</div>

<!-- 🔐 Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 shadow-sm">
      <div class="modal-header border-0">
        <h5 class="modal-title fw-bold" id="changePasswordLabel">Change Password</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form method="POST" action="{{ route('change.password.submit') }}">
        @csrf
        <div class="modal-body px-4">
          <div class="mb-3">
            <label class="form-label">Current Password</label>
            <input type="password" name="current_password" id="current_password" class="form-control" required>
            <small id="currentPassFeedback" class="text-danger d-none">You entered a wrong password.</small>
          </div>

          <div class="mb-3">
            <label class="form-label">New Password</label>
            <input type="password" name="new_password" id="new_password" class="form-control" required>
            <small id="lengthFeedback" class="text-danger d-none">Password must be at least 6 characters.</small>
          </div>

          <!-- Confirm Password -->
          <div class="mb-3">
            <label class="form-label">Confirm New Password</label>
            <input type="password" name="new_password_confirmation" id="confirm_password" class="form-control" required>
            <small id="matchFeedback" class="text-danger d-none">Passwords do not match.</small>
          </div>
        </div>
        <div class="modal-footer border-0 px-4 pb-4">
          <button type="submit" id="updatePasswordBtn" class="btn btn-primary w-100" disabled>Update Password</button>
        </div>
      </form>
    </div>
  </div>
</div>


@if(session('success'))
<div class="position-fixed bottom-0 end-0 p-4" style="z-index: 1055;">
  <div class="toast align-items-center text-bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body">
        {{ session('success') }}
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>
@endif



  <!-- Main Content -->
  <main id="mainContent" class="main-content">
    @yield('content')
     @yield('scripts') 
  </main>
<script>
document.addEventListener("DOMContentLoaded", function () {
  const currentPass = document.getElementById('current_password');
  const newPass = document.getElementById('new_password');
  const confirmPass = document.getElementById('confirm_password');
  const feedback = document.getElementById('currentPassFeedback');
  const lengthFeedback = document.getElementById('lengthFeedback');
  const matchFeedback = document.getElementById('matchFeedback');
  const submitBtn = document.getElementById('updatePasswordBtn');

  function validateForm() {
    const current = currentPass.value.trim();
    const newPwd = newPass.value.trim();
    const confirmPwd = confirmPass.value.trim();

    let isValid = true;

    // Length check
    if (newPwd.length < 6) {
      lengthFeedback.classList.remove('d-none');
      isValid = false;
    } else {
      lengthFeedback.classList.add('d-none');
    }

    // Match check
    if (newPwd !== confirmPwd && confirmPwd !== '') {
      matchFeedback.classList.remove('d-none');
      isValid = false;
    } else {
      matchFeedback.classList.add('d-none');
    }

    // Enable button only if all conditions met
    submitBtn.disabled = !(current && newPwd.length >= 6 && newPwd === confirmPwd);
  }

  // Real-time password check
  currentPass?.addEventListener('input', function () {
    const value = this.value;
    validateForm();

    if (value.length > 0) {
      fetch("{{ route('check.current.password') }}", {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
        },
        body: JSON.stringify({ current_password: value })
      })
      .then(res => res.json())
      .then(data => {
        if (data.valid) {
          feedback.classList.add('d-none');
        } else {
          feedback.classList.remove('d-none');
        }
      })
      .catch(err => console.error("Fetch error:", err));
    } else {
      feedback.classList.add('d-none');
    }
  });

  newPass?.addEventListener('input', validateForm);
  confirmPass?.addEventListener('input', validateForm);
});

document.getElementById('viewAccountBtn')?.addEventListener('click', function () {
  // Fill modal fields using Laravel session data
  document.getElementById('view_applicantID').value = `{{ session('applicantID') ?? '' }}`;
  document.getElementById('view_firstname').value = `{{ session('firstname') ?? '' }}`;
  document.getElementById('view_middlename').value = `{{ session('middlename') ?? '' }}`;
  document.getElementById('view_lastname').value = `{{ session('lastname') ?? '' }}`;
  document.getElementById('view_email').value = `{{ session('email') ?? '' }}`;
  document.getElementById('view_phonenumber').value = `{{ session('phonenumber') ?? '' }}`;

  // Profile picture
  const profile = `{{ session('profile') ?? 'user_prof.png' }}`;
  document.getElementById('profileImage').src = `/img/${profile}`;
});

function markNotificationsAsRead() {
  fetch("{{ route('notifications.read') }}", {
    method: "POST",
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
      'Accept': 'application/json',
    },
  }).then(response => {
    if (response.ok) {
      console.log('🔔 Notifications marked as read');
    }
  });
}

</script>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  @stack('scripts')



 

</body>
</html>
