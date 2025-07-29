@extends('admin.layoutadmin')

<style>
.no-hover-outline {
    color: #0C2340 !important;
    border: 1px solid #0C2340 !important;
    background-color: transparent !important;
}

.no-hover-outline:hover {
    background-color: transparent !important;
    color: #0C2340 !important;
}
</style>

@section('content')
<div class="container py-4">

    {{-- Back button and school name --}}
    <div class="d-flex align-items-center justify-content-between flex-wrap mb-3">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('admin.school') }}" class="btn btn-light rounded-circle shadow-sm" title="Back to list">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h4 class="fw-bold mb-0">{{ $school->Schoolname }}</h4>
        </div>

        <div class="d-flex gap-2">
            <a href="javascript:void(0);" class="btn px-4 py-1 rounded-4 fw-semibold no-hover-outline" id="exportBtn">
                <i class="fas fa-file-export me-1"></i> Export
            </a>

            <a href="{{ route('admin.csv.import', $school->schoolID) }}" class="btn px-4 py-1 rounded-4 text-white fw-semibold" style="background-color: #0C2340; font-size: 17px;">
                <i class="fas fa-file-import me-1"></i> Import
            </a>
        </div>
    </div>

    {{-- Teacher Table Section --}}
    {{-- Teacher Table Section --}}
@if ($teachers->count())
<div id="teacherSection" class="card shadow-sm rounded-4 p-4">
    <h5 class="mb-3">Teachers</h5>

    <div class="table-responsive">
        <table id="teacherTable" class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Applicant ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Current Rank</th>
                    <th>School Year</th>
                </tr>
            </thead>
            <tbody>
                @foreach($teachers as $teacher)
                    @if($teacher->login->role === 'teacher')
                        @php
                            $info = $teacher;
                            $tinfo = $teacher->teacherInfo; // from hasOne relationship
                            $title = $tinfo->TitleName ?? '';
                            $rank = $tinfo->currentrank ?? '-';
                            $sy = isset($tinfo->currentyear, $tinfo->endyear) 
                                ? $tinfo->currentyear . '–' . $tinfo->endyear 
                                : '-';
                        @endphp
                        <tr>
                            <td>{{ $tinfo->applicantID ?? '-' }}</td>
                            <td>{{ $title }} {{ $info->firstname }} {{ $info->middlename }} {{ $info->lastname }}</td>
                            <td>{{ $info->email }}</td>
                            <td>{{ $info->phonenumber }}</td>
                            <td>{{ $rank }}</td>
                            <td>{{ $sy }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
</div>

<!-- Success Modal -->
<div class="modal fade" id="successImportModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content text-center p-4">
      <i class="fas fa-check-circle text-success mb-3" style="font-size: 3rem;"></i>
      <h5 class="mb-2">Import Successful!</h5>
      <p class="mb-0" style="font-size: 1rem;">{{ session('success') }}</p>
    </div>
  </div>
</div>


@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Export to CSV functionality
    const exportBtn = document.getElementById('exportBtn');
    if (exportBtn) {
        exportBtn.addEventListener('click', function () {
            const table = document.getElementById('teacherTable');
            if (!table) return;

            let csv = [];
            const rows = table.querySelectorAll('tr');

            for (let row of rows) {
                let cols = row.querySelectorAll('th, td');
                let rowData = [];
                cols.forEach(col => {
                    let data = col.innerText.replace(/"/g, '""');
                    rowData.push(`"${data}"`);
                });
                csv.push(rowData.join(','));
            }

            const csvFile = new Blob([csv.join('\n')], { type: 'text/csv' });
            const url = URL.createObjectURL(csvFile);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'teacher_list.csv';
            a.click();
            URL.revokeObjectURL(url);
        });
    }

    // Show success modal if there's a success message
    @if(session('success'))
        const successModal = new bootstrap.Modal(document.getElementById('successImportModal'));
        successModal.show();
        setTimeout(() => {
            successModal.hide();
        }, 3000); // close after 3 seconds
    @endif
});


</script>
@endpush
