@extends('districtsupervisor.layout')

@section('content')
<div class="container py-5">
  <h2 class="text-center text-success mb-4">My Profile</h2>

  <div class="row justify-content-center align-items-start">
    <!-- Profile Image -->
    <div class="col-md-3 text-center mb-4">
      <div class="position-relative d-inline-block">
        <img src="{{ asset('img/' . session('profile')) }}" alt="Profile Image"
             class="img-fluid rounded-circle border border-3"
             style="width: 160px; height: 160px; object-fit: cover;">
      </div>
    </div>

    <!-- Profile Info -->
    <div class="col-md-8 bg-light p-4 rounded shadow-sm">
      <div class="row mb-3">
        <div class="col-md-6">
          <label class="fw-bold">First Name</label>
          <input type="text" class="form-control" value="{{ session('firstname') }}" disabled>
        </div>
        <div class="col-md-6">
          <label class="fw-bold">Last Name</label>
          <input type="text" class="form-control" value="{{ session('lastname') }}" disabled>
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label class="fw-bold">Middle Name</label>
          <input type="text" class="form-control" value="{{ session('middlename') }}" disabled>
        </div>
        <div class="col-md-6">
          <label class="fw-bold">Applicant ID</label>
          <input type="text" class="form-control" value="{{ session('applicantID') }}" disabled>
        </div>
      </div>

      <div class="mb-3">
        <label class="fw-bold">Email</label>
        <input type="text" class="form-control" value="{{ session('email') }}" disabled>
      </div>

      <div class="mb-3">
        <label class="fw-bold">Phone Number</label>
        <input type="text" class="form-control" value="{{ session('phonenumber') }}" disabled>
      </div>

      <div class="text-center mt-3">
        <button class="btn btn-primary  w-50" style="background-color: #0C2340; border: none;" data-bs-toggle="modal" data-bs-target="#editProfileModal">
            <i class="fas fa-edit me-1"></i> Edit Profile
        </button>
        </div>

    </div>
  </div>
</div>

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="modal-content p-3 rounded-4">
      @csrf
      <div class="modal-header border-0">
        <h5 class="modal-title fw-bold" id="editProfileModalLabel">Edit Profile</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body row justify-content-center">
        <div class="col-md-4 text-center mb-3">
          <div class="position-relative d-inline-block">
            <img id="previewImage" src="{{ asset('img/' . session('profile')) }}" alt="Profile"
                 class="rounded-circle border border-2" style="width: 140px; height: 140px; object-fit: cover;">
            <label for="profile" class="position-absolute bottom-0 end-0 bg-white rounded-circle p-2 shadow"
                   style="cursor: pointer;">
              <i class="fas fa-camera text-primary"></i>
              <input type="file" name="profile" id="profile" class="d-none" onchange="loadPreview(event)">
            </label>
          </div>
        </div>

        <div class="col-md-7">
          <div class="mb-3">
            <label class="form-label fw-semibold">Applicant ID</label>
            <input type="text" class="form-control" value="{{ session('applicantID') }}" disabled>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">First Name</label>
            <input type="text" name="firstname" class="form-control" value="{{ session('firstname') }}" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Middle Name</label>
            <input type="text" name="middlename" class="form-control" value="{{ session('middlename') }}">
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Last Name</label>
            <input type="text" name="lastname" class="form-control" value="{{ session('lastname') }}" required>
          </div>
        </div>
      </div>

      <div class="modal-footer border-0 px-4 justify-content-center">
        <button type="submit" class="btn w-50 text-white" style="background-color: #0C2340; border: none;">
               Save Changes
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  function loadPreview(event) {
    const output = document.getElementById('previewImage');
    output.src = URL.createObjectURL(event.target.files[0]);
  }
</script>
@endsection
