@extends('admin.layoutadmin')

@section('content')
<style>
    .custom-thead {
        background-color: #0C2340;
        color: white;
        text-align: center;
    }
    .table th,
    .table td {
        vertical-align: middle;
        text-align: center;
    }
    tr.clickable-row {
        cursor: pointer;
    }
</style>

<div class="container py-4">
    <div class="card shadow-sm rounded-4 p-4 border-0">
        <h4 class="fw-bold mb-3">Accounts</h4>

        {{-- If coming from a filtered view, show context --}}
        @if(isset($schools[0]) && $schools[0]->municipality && $schools[0]->district)
            <p class="text-muted mb-3">
                Schools under: 
                <strong>{{ $schools[0]->district->district_name }}</strong> /
                <strong>{{ $schools[0]->municipality->municipality_name }}</strong>
            </p>
        @endif

        <!-- Tabs -->
        <ul class="nav nav-tabs mb-3" id="accountTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="teacher-tab" data-bs-toggle="tab" data-bs-target="#teacher" type="button" role="tab">Teacher Account</button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="accountTabsContent">
            <!-- Teacher Account Tab -->
            <div class="tab-pane fade show active" id="teacher" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle mb-0">
                        <thead class="custom-thead">
                            <tr>
                                <th style="width: 40px;"><input type="checkbox"></th>
                                <th>School Name</th>
                                <th>No. of Teachers</th>
                                <th>State</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($schools as $school)
                                <tr class="clickable-row" 
                                    data-href="{{ $school->teacher_count > 0 
                                        ? route('admin.school.show', $school->schoolID) 
                                        : route('admin.school.no_teacher', $school->schoolID) }}">
                                    <td><input type="checkbox"></td>
                                    <td>{{ $school->Schoolname }}</td>
                                    <td>{{ $school->teacher_count }}</td>
                                    <td>
                                        <span class="badge bg-success bg-opacity-10 text-success d-inline-flex align-items-center gap-1 px-3 py-2 rounded-pill">
                                            <i class="fas fa-check-circle"></i> Synced
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-muted text-center">No schools found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }

    document.addEventListener('DOMContentLoaded', function () {
        const rows = document.querySelectorAll('.clickable-row');
        rows.forEach(row => {
            row.addEventListener('click', function () {
                window.location.href = this.dataset.href;
            });
        });
    });
</script>
@endpush
@endsection
