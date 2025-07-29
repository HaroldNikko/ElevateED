@extends('admin.layoutadmin')

@section('content')
<div class="container py-4">

  <!-- Top bar -->
<div class="d-flex justify-content-between align-items-center mb-4">
  <h4 class="fw-semibold mb-0">District</h4>

  <div class="d-flex align-items-center gap-3">
    <!-- Search Input -->
    <div class="input-group" style="max-width: 250px;">
      <input type="text" class="form-control" placeholder="Search" style="border-radius: 10px 0 0 10px;">
      <span class="input-group-text bg-white" style="border-radius: 0 10px 10px 0;">
        <i class="fas fa-search"></i>
      </span>
    </div>

    <!-- Add District Button -->
    <a href="#" class="btn px-4 py-2 text-white" style="border-radius: 12px; background-color: #0C2340;"
       data-bs-toggle="modal" data-bs-target="#addDistrictModal">
      <i class="fas fa-plus me-2"></i> Add district
    </a>
  </div>
</div>


  @if($districts->isEmpty())
    <!-- Empty State -->
    <div class="text-center p-5 bg-white rounded-4 shadow-sm" style="border: 1px solid #eee;">
      <img src="{{ asset('img/box.png') }}" alt="Empty Box" style="max-height: 300px;" class="mb-1">
      <h5 class="fw-bold">Almost there!</h5>
      <p class="text-muted">Add a district to get started.</p>

      <div class="d-flex justify-content-center gap-3 mt-3">
        <a href="{{ route('admin.import_csv') }}" class="btn px-4 py-2 text-white" style="border-radius: 12px; background-color: #0C2340;">
          <i class="fas fa-file-csv me-2"></i> Import csv
        </a>
        <a href="#" class="btn px-4 py-2 text-white" style="border-radius: 12px; background-color: #0C2340;"
           data-bs-toggle="modal" data-bs-target="#addDistrictModal">
          <i class="fas fa-plus me-2"></i> Add district
        </a>
      </div>
    </div>
 @else
<!-- Table View -->
<div class="card shadow-sm rounded-4 p-3" style="min-height: 60vh;">
  <table class="table table-bordered align-middle text-center">
    <thead class="table-light">
      <tr>
        <th><input type="checkbox" /></th>
        <th>District Name</th>
        <th>No. of District Supervisor</th>
      </tr>
    </thead>
    <tbody>
      @foreach($districts as $district)
      <tr onclick="window.location='{{ route('district.supervisors', ['id' => $district->districtID]) }}'" style="cursor: pointer;">
        <td><input type="checkbox" /></td>
        <td>{{ $district->Districtname }}</td>
        <td>{{ $district->supervisors->count() }}</td>
      </tr>
    @endforeach

    </tbody>
  </table>

  
</div>
  <div class="d-flex justify-content-end gap-2 mt-3">
    <a href="{{ route('admin.import_csv') }}" class="btn text-white px-4 py-2" style="background-color: #0C2340; border-radius: 10px;">
      <i class="fas fa-file-import me-2"></i> Import
    </a>
  </div>
@endif


</div>

<!-- Add District Modal -->
<div class="modal fade" id="addDistrictModal" tabindex="-1" aria-labelledby="addDistrictLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 p-3">
      <div class="modal-header border-0">
        <h5 class="modal-title fw-bold" id="addDistrictLabel">
          <i class="fas fa-plus-circle me-2"></i> Add district
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('district.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <small class="text-muted">Enter district name to register a new district supervisor.</small>
          <div class="mt-3">
            <input type="text" name="district_name" class="form-control" placeholder="District name" required>
          </div>
        </div>
        <div class="modal-footer border-0">
          <button type="submit" class="btn text-white w-100" style="background-color: #0C2340; border-radius: 10px;">
            Add
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
