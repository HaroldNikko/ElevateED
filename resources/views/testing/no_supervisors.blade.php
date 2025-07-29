@extends('admin.layoutadmin')

@section('content')
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-semibold mb-0">District Supervisors</h4>

    <!-- Right aligned group -->
    <div class="d-flex align-items-center gap-3 ms-auto">
      <!-- Search Input -->
      <div class="input-group" style="max-width: 250px;">
        <input type="text" class="form-control" placeholder="Search" style="border-radius: 10px 0 0 10px;">
        <span class="input-group-text bg-white" style="border-radius: 0 10px 10px 0;">
          <i class="fas fa-search"></i>
        </span>
      </div>

      <!-- Add Supervisor Button -->
      <a href="#" class="btn px-4 py-2 text-white" style="border-radius: 12px; background-color: #0C2340;"
         data-bs-toggle="modal" data-bs-target="#addDistrictModal">
        <i class="fas fa-plus me-2"></i> Add Supervisor
      </a>
    </div>
  </div>

  <div class="text-center p-5 bg-white rounded-4 shadow-sm" style="border: 1px solid #eee;">
    <img src="{{ asset('img/box.png') }}" alt="Empty Box" style="max-height: 300px;" class="mb-1">
    <h5 class="fw-bold">Almost there!</h5>
    <p class="text-muted">No district supervisors found for <strong>{{ $district->Districtname }}</strong>.</p>

    <div class="d-flex justify-content-center gap-3 mt-3">
      <a href="{{ route('admin.import_csv', ['district_id' => $district->districtID]) }}"
        class="btn px-4 py-2 text-white"
        style="border-radius: 12px; background-color: #0C2340;">
        <i class="fas fa-file-csv me-2"></i> Import CSV
        </a>

      <a href="#" class="btn px-4 py-2 text-white" style="border-radius: 12px; background-color: #0C2340;"
         data-bs-toggle="modal" data-bs-target="#addDistrictModal">
        <i class="fas fa-plus me-2"></i> Add Supervisor
      </a>
    </div>
  </div>
</div>
@endsection
