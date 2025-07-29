@extends('districtsupervisor.layout')
@include('districtsupervisor.modal')

@section('content')
<div class="container mx-auto mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <!-- Filter + Search -->
    <div class="d-flex align-items-center gap-2 flex-grow-1">
      <select class="form-select w-auto shadow-sm" style="border-radius: 8px;">
        <option>Filter</option>
        <option>District 1</option>
        <option>District 2</option>
      </select>

      <div class="input-group shadow-sm" style="border-radius: 8px; max-width: 300px;">
        <input type="text" class="form-control border-0" placeholder="Search">
        <span class="input-group-text bg-white border-0">
          <i class="fas fa-search"></i>
        </span>
      </div>
    </div>

    <!-- Upload Button aligned with filter and search -->
    <div>
      <button class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#uploadModal" style="background-color: #0C2340;">
        <i class="fas fa-upload me-1"></i> Upload
      </button>
    </div>

  </div>
</div>

  <div class="card shadow-sm border-0 rounded-4 p-3">
    <div class="table-responsive">
      <table class="table table-bordered align-middle text-center mb-0">
        <thead class="custom-thead">
          <tr>
            <th>Tracking Code</th>
            <th>Position</th>
            <th>School</th>
            <th>Upload Date</th>
            <th>Deadline</th>
            <th>Status</th>
            <th>Total Applicants</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
   @foreach ($vacancies as $vacancy)
    @php
        $today = \Carbon\Carbon::now();
        $startDate = \Carbon\Carbon::parse($vacancy->start_date);
        $deadline = \Carbon\Carbon::parse($vacancy->end_date);
        $daysLeft = floor($today->diffInDays($deadline, false));  // Ensuring it’s a whole number (integer)
        $status = '';
        $statusClass = '';

        if ($today->gt($deadline)) {
            $status = 'Closed';
            $statusClass = 'text-danger';
        } elseif ($daysLeft <= 2) {
            $status = 'Closing Soon (' . $daysLeft . ' days left)';
            $statusClass = 'text-warning';
        } else {
            $status = 'Open (' . $daysLeft . ' days left)';
            $statusClass = 'text-success';
        }
    @endphp
    <tr onclick="window.location='{{ route('result.application', $vacancy->uploadID) }}'" style="cursor: pointer;">
        <td>{{ $vacancy->track_code ?? 'N/A' }}</td>
        <td>{{ $vacancy->teacherRank->teacherRank ?? 'N/A' }}</td>
        <td>{{ $vacancy->school->Schoolname ?? 'N/A' }}</td>
        <td>{{ \Carbon\Carbon::parse($vacancy->start_date)->format('F d, Y') }}</td>
        <td>{{ \Carbon\Carbon::parse($vacancy->end_date)->format('F d, Y') }}</td>
        <td>
            <span class="{{ $statusClass }}">
                <i class="fas fa-circle me-1"></i>{{ $status }}
            </span>
        </td>
        <td>{{ $vacancy->total_applicants }}</td>
        <td>
            <a href="#" class="text-decoration-none text-dark">
                <i class="fas fa-pen me-1"></i>Edit
            </a>
        </td>
    </tr>
@endforeach


        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  // Set start date to today
  const today = new Date().toISOString().split('T')[0];
  const startDateField = document.getElementById('startDateField');
  if (startDateField) {
    startDateField.value = today;
  }

  const form = document.getElementById('uploadForm');
  form.addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(form);

    fetch("{{ route('upload.store') }}", {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: formData
    })
    .then(async response => {
      const contentType = response.headers.get('content-type');

      if (!response.ok) {
        if (contentType && contentType.includes('text/html')) {
          const htmlError = await response.text();
          console.error('❌ HTML Error Returned:', htmlError);
        } else {
          const jsonError = await response.json();
          console.error('❌ JSON Error Returned:', jsonError);
        }
        throw new Error('Request failed');
      }

      return response.json();
    })
    .then(data => {
      alert(data.message || 'Upload successful!');
      location.reload();
    })
    .catch(error => {
      console.error('🚨 Error caught:', error);
      alert('Something went wrong. Check console and Laravel logs.');
    });
  });
});
</script>
@endsection
