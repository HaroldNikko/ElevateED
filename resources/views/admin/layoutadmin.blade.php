<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Panel - ElevateEd</title>

<!-- ✅ Bootstrap 5.3 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- ✅ FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
<!-- ✅ jQuery (required for AJAX) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JS (already included above) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')


  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
  @include('admin.modals')
  

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

  {{-- User Info --}}
  <div class="user-info">
    <strong>{{ session('firstname') }} {{ session('lastname') }}</strong>
    <div class="user-role">({{ session('role') }})</div>
  </div>
</header>





<aside id="sidebar" class="sidebar">
  <div>
    <ul class="nav flex-column">
      <li class="nav-item">
        <a href="{{ route('admin.deped.hierarchy') }}" class="nav-link {{ Route::is('admin.deped.hierarchy') ? 'active' : '' }}">
          <i class="fas fa-network-wired me-2"></i> <span>DepEd Hierarchy</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.systemsetup') }}" class="nav-link {{ Route::is('admin.systemsetup') ? 'active' : '' }}">
          <i class="fas fa-sliders-h me-2"></i> <span>System Setup</span>
        </a>
      </li>
       {{-- ✅ User Management --}}
      <li class="nav-item">
        <a href="{{ route('admin.user.management') }}" class="nav-link {{ Route::is('admin.user.management') ? 'active' : '' }}">
          <i class="fas fa-users me-2"></i> <span>User Management</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.designation.index') }}" class="nav-link {{ Route::is('admin.designation.index') ? 'active' : '' }}">
          <i class="fas fa-user-tag me-2"></i> <span>Designation</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.select.region') }}" class="nav-link {{ Route::is('admin.select.region') ? 'active' : '' }}">
          <i class="fas fa-file-import me-2"></i> <span>Import CSV</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.depedorder') }}" class="nav-link {{ Route::is('admin.depedorder') ? 'active' : '' }}">
          <i class="fas fa-file-alt me-2"></i> <span>DepEd Orders</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.system_log') }}" class="nav-link {{ Route::is('admin.system_log') ? 'active' : '' }}">
          <i class="fas fa-history me-2"></i> <span>System Logs</span>
        </a>
      </li>
    </ul>
  </div>

  <div class="sidebar-footer">
    <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#logoutConfirmModal">
      <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
    </a>
  </div>
</aside>



<main id="mainContent" class="main-content">
  @yield('content')
</main>



<script src="{{ asset('js/dashboard.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')

</body>
</html>
