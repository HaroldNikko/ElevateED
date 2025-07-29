@extends('admin.layoutadmin')

@section('content')

<style>
.pagination .page-link {
  color: #0C2340;
  border-radius: 8px;
}
.pagination .page-item.active .page-link {
  background-color: #0C2340;
  border-color: #0C2340;
  color: #fff;
}
.pagination .page-link:hover {
  background-color: #0a1d33;
  color: #fff;
}
</style>

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">System Setup</h4>
  </div>

  <div class="card shadow-sm rounded-4 p-4">
    <ul class="nav nav-tabs mb-3" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link system-tab active" data-bs-toggle="tab" data-bs-target="#rankTab" type="button" role="tab">
          Teacher Rank
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link system-tab" data-bs-toggle="tab" data-bs-target="#regionTab" type="button" role="tab">
          School
        </button>
      </li>
    </ul>

    <div class="tab-content">
      <!-- 🟦 Teacher Rank Tab -->
      <div class="tab-pane fade show active" id="rankTab" role="tabpanel">
        <table class="table table-bordered text-center align-middle">
          <thead class="custom-thead">
            <tr>
              <th>No.</th>
              <th>Teacher Rank</th>
              <th>Salary Grade</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($ranks as $index => $rank)
              <tr>
                <td>{{ $ranks->firstItem() + $index }}</td>
                <td>{{ $rank->teacherRank }}</td>
                <td>{{ $rank->Salary_grade }}</td>
                <td>
                  <button class="btn btn-warning btn-sm edit-rank"
                          data-id="{{ $rank->teacherrank_id }}"
                          data-name="{{ $rank->teacherRank }}"
                          data-grade="{{ $rank->Salary_grade }}">
                    <i class="fas fa-pen"></i>
                  </button>
                  <button class="btn btn-danger btn-sm delete-rank"
                          data-id="{{ $rank->teacherrank_id }}">
                    <i class="fas fa-trash"></i>
                  </button>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="text-muted">No ranks found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center mt-3">
          <div>
            Showing {{ $ranks->firstItem() }} to {{ $ranks->lastItem() }} of {{ $ranks->total() }} entries
          </div>
          <div>
            {{ $ranks->links('pagination::bootstrap-5') }}
          </div>
        </div>

        <div class="text-end mt-3">
          <button class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addRankModal">
            <i class="fas fa-plus me-1"></i> Add Ranking
          </button>
        </div>
      </div>

      <!-- 🟥 Region Tab -->
      <div class="tab-pane fade" id="regionTab" role="tabpanel">
                <h4>Select region to add school</h4>
        <table class="table table-bordered text-center align-middle">
          <thead class="custom-thead">
            <tr>
              <th>#</th>
              <th>Region Name</th>
              <th>Region Description</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($regions as $index => $region)
              <tr onclick="window.location='{{ route('admin.show_division', $region->region_id) }}'" style="cursor: pointer;">
                <td>{{ $regions->firstItem() + $index }}</td>
                <td>{{ $region->region_name }}</td>
                <td>{{ $region->region_description }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="3" class="text-muted">No regions found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center mt-3">
          <div>
            Showing {{ $regions->firstItem() }} to {{ $regions->lastItem() }} of {{ $regions->total() }} entries
          </div>
          <div>
            {{ $regions->links('pagination::bootstrap-5') }}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const activeTab = localStorage.getItem('activeTab');
  if (activeTab) {
    const tabTrigger = document.querySelector(`.system-tab[data-bs-target="${activeTab}"]`);
    if (tabTrigger) new bootstrap.Tab(tabTrigger).show();
  }

  document.querySelectorAll('.system-tab').forEach(tab => {
    tab.addEventListener('shown.bs.tab', function (e) {
      localStorage.setItem('activeTab', e.target.getAttribute('data-bs-target'));
    });
  });

  document.querySelectorAll('.edit-rank').forEach(button => {
    button.addEventListener('click', function () {
      document.getElementById('editRankID').value = this.dataset.id;
      document.getElementById('editRankName').value = this.dataset.name;
      document.getElementById('editSalaryGrade').value = this.dataset.grade;
      new bootstrap.Modal(document.getElementById('editRankModal')).show();
    });
  });

  document.querySelectorAll('.delete-rank').forEach(btn => {
    btn.addEventListener('click', function () {
      deleteId = this.dataset.id;
      new bootstrap.Modal(document.getElementById('deleteSlotModal')).show();
    });
  });
});
</script>

@endsection
