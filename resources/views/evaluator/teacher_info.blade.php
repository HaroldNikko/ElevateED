@extends('evaluator.evaluator_layout')

<style>
thead.custom-thead tr th {
    background-color: #0d2c53 !important;
    color: white !important;
}
.btn-outline-action:hover {
    background-color: #0d2c53;
    color: white;
}
.btn-outline-action {
    display: inline-block;
    color: #0d2c53;
    border: 2px solid #0d2c53;
    font-weight: 600;
    padding: 6px 18px;
    background-color: transparent;
    border-radius: 5px;
    transition: all 0.3s ease;
    font-size: 14px;
}
.btn-outline-action:hover {
    background-color: #0d2c53;
    color: white;
}
.table tbody tr {
    cursor: pointer;
    transition: background-color 0.2s ease;
}
.table tbody tr:hover {
    background-color: #f0f4ff;
}
</style>

@section('content')
<div class="container mt-4">
    <form id="statusUpdateForm" method="POST">
        @csrf

        <div class="d-flex justify-content-between mb-3">
            <!-- Left: Back Button -->
            <div class="d-flex gap-2">
                <a href="{{ route('evaluator.rev_doc') }}"
                    class="btn btn-md text-white d-flex align-items-center justify-content-center"
                    style="background-color: #0C2340; border: none; border-radius: 1rem;">
                    <i class="fas fa-arrow-left"></i>
                </a>
            </div>

            <!-- Right: Action Buttons -->
            <div class="d-flex gap-2">
                <button type="button"
                    class="btn btn-md text-white"
                    style="background-color: #0C2340; border: none; border-radius: 1rem;"
                    onclick="confirmStatusChange('In Progress')">
                    In Progress
                </button>
            </div>
        </div>

        <!-- Table -->
        <table class="table table-bordered text-center align-middle">
            <thead class="custom-thead">
                <tr>
                    <th><input type="checkbox" id="selectAll"></th>
                    <th>Rank</th>
                    <th>Applicant<br>Code</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Date<br>Submitted</th>
                    <th>Score<br>Assigned</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @php
                $sortedApplicants = $applicants->sortByDesc('score')->values();
            @endphp
            @forelse ($sortedApplicants as $index => $applicant)
                <tr onclick="confirmReview('{{ route('evaluator.final_review_doc', [$applicant->teacherID, $uploadPosition->uploadID]) }}')">
                    <td onclick="event.stopPropagation()">
                        <input type="checkbox" name="selected_applicants[]" value="{{ $applicant->teacherID }}">
                    </td>
                    <td class="text-center align-middle">
                        @if($index === 0)
                            <span style="font-size: 1.5rem;">&#129351;</span>
                        @elseif($index === 1)
                            <span style="font-size: 1.5rem;">&#129352;</span>
                        @elseif($index === 2)
                            <span style="font-size: 1.5rem;">&#129353;</span>
                        @else
                            <span class="fw-bold">{{ $index + 1 }}</span>
                        @endif
                    </td>
                    <td>{{ $applicant->ApplicantID }}</td>
                    <td>{{ $applicant->LastName }}, {{ $applicant->Firstname }} {{ $applicant->MiddleName }}</td>
                    <td>{{ $applicant->CurrentPosition }}</td>
                    <td>{{ \Carbon\Carbon::parse($applicant->submitDate)->format('m-d-Y') }}</td>
                    <td>{{ $applicant->score }}</td>
                    <td class="fw-semibold text-center align-middle">
                        @php
                            $status = strtolower($applicant->Status);
                            $color = match($status) {
                                'in progress' => '#FFA500',
                                'pending' => '#D32F2F',
                                'approved' => '#28A745',
                                default => '#6c757d',
                            };
                        @endphp
                        <div class="d-inline-flex align-items-center justify-content-center gap-2">
                            <span style="width:10px; height:10px; border-radius:50%; background-color: {{ $color }};"></span>
                            <span style="color: {{ $color }}; text-transform: capitalize;">{{ $applicant->Status }}</span>
                        </div>
                    </td>
                    <td class="text-center">
                        <i class="fas fa-eye text-dark"></i>
                    </td>
                </tr>
            @empty
                <tr><td colspan="9">No applicants found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </form>
</div>

<!-- Review Confirmation Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content text-center p-4 rounded-4">
      <div class="modal-body">
        <i class="fas fa-user-check fa-2x mb-3" style="color: #0C2340;"></i>
        <p class="fw-bold mb-3">Are you sure you want to review this applicant?</p>
        <div class="d-flex justify-content-center">
          <button type="button" class="btn btn-md btn-danger me-2" data-bs-dismiss="modal">No</button>
          <button type="button" class="btn btn-md text-white" style="background-color: #0C2340;" id="confirmYesBtn">Yes</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Status Confirmation Modal -->
<div class="modal fade" id="statusConfirmModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content text-center p-4 rounded-4">
      <div class="modal-body">
        <i class="fas fa-exclamation-circle fa-2x mb-3" style="color: #0C2340;"></i>
        <p class="fw-bold mb-3" id="statusConfirmText"></p>
        <div class="d-flex justify-content-center">
          <button type="button" class="btn btn-md btn-danger me-2" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-md text-white" style="background-color: #0C2340;" id="statusConfirmYesBtn">Confirm</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.getElementById('selectAll')?.addEventListener('click', function () {
    const checkboxes = document.querySelectorAll('input[name="selected_applicants[]"]');
    checkboxes.forEach(cb => cb.checked = this.checked);
});

let confirmUrl = '';

function confirmReview(url) {
    confirmUrl = url;
    const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
    modal.show();
}

document.getElementById('confirmYesBtn').addEventListener('click', function () {
    window.location.href = confirmUrl;
});

// AJAX status update
function confirmStatusChange(status) {
    const checkboxes = document.querySelectorAll('input[name="selected_applicants[]"]:checked');
    const count = checkboxes.length;
    const confirmText = document.getElementById('statusConfirmText');

    if (count > 1) {
        confirmText.textContent = `Update ${count} applicants to ${status}?`;
    } else if (count === 1) {
        confirmText.textContent = `Update this applicant to ${status}?`;
    } else {
        confirmText.textContent = `No applicants selected.`;
        const modal = new bootstrap.Modal(document.getElementById('statusConfirmModal'));
        modal.show();
        return;
    }

    document.getElementById('statusConfirmYesBtn').dataset.status = status;

    const modal = new bootstrap.Modal(document.getElementById('statusConfirmModal'));
    modal.show();
}

document.getElementById('statusConfirmYesBtn').addEventListener('click', async function () {
    const status = this.dataset.status;
    const checkboxes = Array.from(document.querySelectorAll('input[name="selected_applicants[]"]:checked'));
    const selectedApplicants = checkboxes.map(cb => cb.value);

    console.log('Sending AJAX request with:', {selectedApplicants, status});

    const csrfToken = document.querySelector('input[name="_token"]').value;

    try {
        const response = await fetch("{{ route('evaluator.updateStatus') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken
            },
            body: JSON.stringify({
                selected_applicants: selectedApplicants,
                status: status
            })
        });

        if (response.ok) {
            const result = await response.json();
            console.log('Server responded with:', result);
            location.reload(); // Refresh page to see updates
        } else if (response.status === 419) {
            alert('Session expired. Please log in again.');
            location.reload();
        } else {
            const errorText = await response.text();
            console.error('Error response:', errorText);
            alert('Error updating status. Check console for details.');
        }
    } catch (error) {
        console.error('AJAX request failed:', error);
        alert('AJAX request failed. Check console for details.');
    }
});
</script>

@endsection
