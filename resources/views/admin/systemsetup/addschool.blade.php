@extends('admin.layoutadmin')

@section('content')

<style>
  .modal.show .modal-body {
    overflow-y: auto;
    max-height: 75vh;
  }
  .custom-thead {
    background-color: #0C2340;
    color: white;
    text-align: center;
  }
  .table th, .table td {
    vertical-align: middle;
    text-align: center;
  }
  .icon-btn {
    color: #0C2340;
    background: transparent;
    border: none;
    padding: 0 5px;
    font-size: 1rem;
  }
  .icon-btn:hover {
    color: #092035;
  }

</style>

<div class="container mt-4">
  <div class="d-flex align-items-center justify-content-between mb-3">
    <!-- Left Icon + Title -->
    <div class="d-flex align-items-center" style="gap: 10px;">
      <!-- Circle Back Button -->
      <a href="{{ url()->previous() }}" class="d-flex justify-content-center align-items-center"
         style="width: 38px; height: 38px; background-color: #0C2340; border-radius: 50%; text-decoration: none;">
        <i class="fas fa-arrow-left text-white"></i>
      </a>
      <!-- Title -->
      <h4 class="mb-0">Manage Schools</h4>
    </div>

    <!-- Add Button -->
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSchoolModal">
      <i class="fas fa-plus me-1"></i> Add School
    </button>
  </div>
</div>




<!-- ✅ Add School Modal -->
<div class="modal fade" id="addSchoolModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form id="addSchoolForm">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Add School</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label>School Name</label>
              <input type="text" name="schoolname" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
              <label>Education Level</label>
              <select name="Basic_education" class="form-select" required>
                <option value="">-- Select --</option>
                <option value="Primary">Primary</option>
                <option value="Secondary">Secondary</option>
                <option value="Senior High School (SHS)">Senior High School (SHS)</option>
              </select>
            </div>

            <div class="col-md-4 mb-3">
              <label>Region</label>
              <input type="text" name="region" value="{{ $region ?? '' }}" class="form-control" readonly>
            </div>

            <div class="col-md-4 mb-3">
              <label>Province</label>
              <input type="text" name="province" value="{{ $province ?? '' }}" class="form-control" readonly>
            </div>

            <div class="col-md-4 mb-3">
              <label>District</label>
              <input type="text" name="district" value="{{ $district ?? '' }}" class="form-control" readonly>
            </div>

            <div class="col-md-6 mb-3">
              <label>Municipality</label>
              <input type="text" name="municipality" value="{{ $municipality ?? '' }}" class="form-control" readonly>
            </div>

            <div class="col-md-6 mb-3">
              <label>Barangay</label>
              <select name="barangay" id="barangayAdd" class="form-select" required>
                <option value="">-- Select Barangay --</option>
              </select>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- ✅ Edit Modal -->
<div class="modal fade" id="editSchoolModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form id="editSchoolForm">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Edit School</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" id="editSchoolID">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label>School Name</label>
              <input type="text" name="schoolname" id="editSchoolName" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
              <label>Education Level</label>
              <select name="Basic_education" id="editEducation" class="form-select" required>
                <option value="Primary">Primary</option>
                <option value="Secondary">Secondary</option>
                <option value="Senior High School (SHS)">Senior High School (SHS)</option>
              </select>
            </div>

            <div class="col-md-4 mb-3">
              <label>Region</label>
              <input type="text" name="region" id="editRegion" class="form-control" readonly>
            </div>

            <div class="col-md-4 mb-3">
              <label>Province</label>
              <input type="text" name="province" id="editProvince" class="form-control" readonly>
            </div>

            <div class="col-md-4 mb-3">
              <label>District</label>
              <input type="text" name="district" id="editDistrict" class="form-control" readonly>
            </div>

            <div class="col-md-6 mb-3">
              <label>Municipality</label>
              <input type="text" name="municipality" id="editMunicipality" class="form-control" readonly>
            </div>

            <div class="col-md-6 mb-3">
              <label>Barangay</label>
              <select name="barangay" id="editBarangay" class="form-select" required></select>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="container mt-4">
  <table class="table table-bordered text-center">
    <thead class="custom-thead">
      <tr>
        <th>#</th>
        <th>School Name</th>
        <th>Basic Education Level</th>
        <th>Region</th>
        <th>District</th>
        <th>School Address</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach($schools as $i => $school)
      <tr>
        <td>{{ $i + 1 }}</td>
        <td>{{ $school->Schoolname }}</td>
        <td>{{ $school->Basic_education }}</td>
        <td>{{ $school->region->region_name ?? '' }}</td>
        <td>{{ $school->district->district_name ?? '' }}</td>
        <td>
          {{ $school->barangay->barangay_name ?? '' }},
          {{ $school->municipality->municipality_name ?? '' }},
          {{ $school->province->province_name ?? '' }}
        </td>
        <td>
          <button class="icon-btn edit-btn" data-id="{{ $school->schoolID }}">
            <i class="fas fa-edit"></i>
          </button>
          <form action="{{ route('school.delete', $school->schoolID) }}" method="POST" style="display:inline;">
            @csrf @method('DELETE')
            <button type="submit" class="icon-btn" onclick="return confirm('Delete this school?')">
              <i class="fas fa-trash-alt"></i>
            </button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>


<!-- ✅ JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function () {
  const municipality = '{{ $municipality ?? '' }}';
  if (municipality) {
    fetch(`/api/get-municipality-id?name=${encodeURIComponent(municipality)}`)
      .then(res => res.json())
      .then(data => {
        if (data.id) {
          fetch(`/admin/barangays/${data.id}`)
            .then(res => res.json())
            .then(barangays => {
              const select = document.getElementById('barangayAdd');
              select.innerHTML = '<option value="">-- Select --</option>';
              barangays.forEach(b => {
                let opt = document.createElement('option');
                opt.value = b.barangay_name;
                opt.textContent = b.barangay_name;
                select.appendChild(opt);
              });
            });
        }
      });
  }

  // Edit
  document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const id = btn.dataset.id;
      fetch(`/admin/get-school/${id}`)
        .then(res => res.json())
        .then(data => {
          document.getElementById('editSchoolID').value = id;
          document.getElementById('editSchoolName').value = data.Schoolname;
          document.getElementById('editEducation').value = data.Basic_education;
          document.getElementById('editRegion').value = data.region?.region_name || '';
          document.getElementById('editProvince').value = data.province?.province_name || '';
          document.getElementById('editDistrict').value = data.district?.district_name || '';
          document.getElementById('editMunicipality').value = data.municipality?.municipality_name || '';

          fetch(`/admin/barangays/${data.municipality_id}`)
            .then(res => res.json())
            .then(barangays => {
              const select = document.getElementById('editBarangay');
              select.innerHTML = '';
              barangays.forEach(b => {
                let opt = document.createElement('option');
                opt.value = b.barangay_name;
                opt.text = b.barangay_name;
                if (b.barangay_name === data.barangay?.barangay_name) opt.selected = true;
                select.appendChild(opt);
              });
            });

          new bootstrap.Modal(document.getElementById('editSchoolModal')).show();
        });
    });
  });

  // Save new school
  document.getElementById('addSchoolForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const form = new FormData(this);
    fetch(`{{ route('admin.save.school') }}`, {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
      body: form
    }).then(res => res.json()).then(data => {
      if (data.success) window.location.reload();
    });
  });

  // Update existing school
  document.getElementById('editSchoolForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const id = document.getElementById('editSchoolID').value;
    const form = new FormData(this);
    fetch(`/admin/update-school/${id}`, {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
      body: form
    }).then(res => res.json()).then(data => {
      if (data.success) window.location.reload();
    });
  });
});
</script>

@endsection
