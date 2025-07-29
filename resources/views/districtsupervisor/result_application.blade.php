@extends('districtsupervisor.layout')

<style>
/* Smooth modal pop-in animation */
.modal.fade .modal-dialog {
  transition: transform 0.3s ease-out;
  transform: translateY(-50px);
}
.modal.fade.show .modal-dialog {
  transform: translateY(0);
}

/* Adjust modal positioning */
.modal-dialog-top {
  margin-top: 8vh;
}
</style>

@section('content')
<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-1">

    <!-- Left: Back Button + Heading -->
    <div class="d-flex align-items-center gap-2 flex-wrap">
      <a href="{{ route('position') }}"
          class="btn btn-md text-white d-flex align-items-center justify-content-center"
          style="background-color: #0C2340; border: none; border-radius: 1rem; height: 42px;">
          <i class="fas fa-arrow-left"></i>
      </a>

      <h4 class="mb-0 text-start">
        Applicants for: {{ $vacancy->teacherRank->teacherRank }} - {{ $vacancy->school->Schoolname }}
      </h4>
    </div>

    <!-- Right: Leaderboards + Action Buttons -->
    <div class="d-flex align-items-center gap-2 flex-wrap">
      <button type="button"
              class="btn btn-md text-white"
              style="background-color: #0C2340; border-radius: 1rem;"
              onclick="showLeaderboards()">
        Leaderboards
      </button>

      <button type="button"
              class="btn btn-md text-white"
              style="background-color: #0C2340; border: none; border-radius: 1rem;"
              onclick="confirmStatusChange('In Progress')">
        In Progress
      </button>

      <button type="button"
              class="btn btn-md text-white"
              style="background-color: #0C2340; border: none; border-radius: 1rem;"
              onclick="confirmStatusChange('Approved')">
        Approved
      </button>
    </div>
  </div>

  <div class="card shadow-sm rounded-4">
  <div class="table-responsive">
    <table class="table table-bordered text-center align-middle mb-0">
      <thead class="custom-thead">
        <tr>
          <th><input type="checkbox" id="selectAllCheckbox"></th> <!-- ✅ Select All -->
          <th>No.</th>
          <th>Application Code</th>
          <th>Name</th>
          <th>Address</th>
          <th>Status</th>
          <th>Details</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($applicants as $index => $applicant)
        <tr class="redirect-to-review"
            data-id="{{ $applicant->teacher->id }}"
            data-upload="{{ $applicant->uploadID }}"
            data-teacher="{{ $applicant->teacher->id }}"
            style="cursor: pointer;">
          
          <td onclick="event.stopPropagation();">
            <input type="checkbox" class="form-check-input applicant-checkbox" value="{{ $applicant->teacher->id }}">
          </td>
          
          <td>{{ $index + 1 }}</td>
          <td>{{ $applicant->teacher->applicantID }}</td>
          <td>
            <span class="fw-semibold">
              {{ $applicant->teacher->lastname }}, {{ $applicant->teacher->firstname }}
              {{ $applicant->teacher->middlename ? substr($applicant->teacher->middlename, 0, 1) . '.' : '' }}
            </span>
          </td>
          <td>{{ $applicant->teacher->Address ?? 'N/A' }}</td>
          <td>
            @php
            $Status = strtolower($applicant->Status ?? 'pending');
            $statusMap = [
              'approved' => ['text' => 'Approved', 'class' => 'text-success', 'dot' => 'bg-success'],
              'pending' => ['text' => 'Pending', 'class' => 'text-danger', 'dot' => 'bg-danger'],
              'in progress' => ['text' => 'In Progress', 'class' => 'text-warning', 'dot' => 'bg-warning'],
            ];
            $mapped = $statusMap[$Status] ?? ['text' => 'Pending', 'class' => 'text-secondary', 'dot' => 'bg-secondary'];
            @endphp
            <span class="{{ $mapped['class'] }}">
              <i class="fas fa-circle me-1 {{ $mapped['dot'] }}"></i>{{ $mapped['text'] }}
            </span>
          </td>
          <td onclick="event.stopPropagation();">
            <button class="btn btn-sm btn-outline-dark view-applicant-btn"
                    data-id="{{ $applicant->teacher->id }}"
                    data-upload="{{ $applicant->uploadID }}">
              <i class="fas fa-eye"></i>
            </button>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="7" class="text-muted">No applicants yet.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>


  <div class="container mt-3 text-end">
    <button type="button"
            class="btn text-white px-4"
            style="background-color: #0C2340; border-radius: 1rem;"
            onclick="submitApplicantResults()">
      Submit
    </button>
  </div>
</div>


<!-- View Applicant Modal -->
<div class="modal fade" id="viewApplicantModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content p-4 rounded-4">
      <div class="modal-header border-0">
        <h5 class="modal-title fw-bold">Other Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body row g-3">
        <div class="col-md-6">
          <label class="form-label">Name</label>
          <input type="text" class="form-control" id="applicantName" readonly>
        </div>
        <div class="col-md-6">
          <label class="form-label">Application Code</label>
          <input type="text" class="form-control" id="applicationCode" readonly>
        </div>
        <div class="col-md-6">
          <label class="form-label">Current Rank</label>
          <input type="text" class="form-control" id="currentPosition" readonly>
        </div>
        <div class="col-md-6">
          <label class="form-label">Email</label>
          <input type="text" class="form-control" id="email" readonly>
        </div>
        <div class="col-md-6">
          <label class="form-label">School Name</label>
          <input type="text" class="form-control" id="schoolName" readonly>
        </div>
        <div class="col-md-6">
          <label class="form-label">Contact Number</label>
          <input type="text" class="form-control" id="contactNumber" readonly>
        </div>
        <div class="col-md-12">
          <label class="form-label">School Address</label>
          <input type="text" class="form-control" id="schoolAddress" readonly>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Leaderboards Modal -->
<div class="modal fade" id="leaderboardsModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-top">
    <div class="modal-content p-4 rounded-4">
      <div class="modal-header border-0">
        <h5 class="modal-title fw-bold">Leaderboards</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="custom-thead">
              <tr class="text-center">
                <th>Rank</th>
                <th>Name</th>
                <th>Address</th>
                <th>Points</th>
              </tr>
            </thead>
            <tbody class="text-center">
              <!-- Will be filled dynamically by JS -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="confirmSubmitModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body text-center">
        <p class="mb-3 fw-semibold">Are you sure you want to submit the results?</p>
        <div class="d-flex justify-content-center gap-2">
          <button class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">No</button>
          <button class="btn btn-primary btn-sm" id="confirmSubmitBtn">Yes</button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="submitSuccessModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body text-center">
        <i class="fas fa-check-circle text-success" style="font-size: 2.5rem;"></i>
        <p class="mt-2 mb-0">Results submitted successfully!</p>
      </div>
    </div>
  </div>
</div>

<div id="loadingOverlay" style="position: fixed; top: 0; left: 0; z-index: 9999; width: 100vw; height: 100vh; background: rgba(255, 255, 255, 0.8); display: flex; align-items: center; justify-content: center; visibility: hidden; flex-direction: column;">
  <div style="width: 60%; max-width: 500px;" class="text-center">
    <div class="progress bg-light" style="height: 25px; position: relative;">
      <div id="loadingProgressBar" class="progress-bar progress-bar-striped progress-bar-animated"
           style="width: 0%; background-color: #0C2340;">
        <span id="loadingPercentText" style="position: absolute; left: 50%; transform: translateX(-50%); color: white;">0%</span>
      </div>
    </div>
    <p class="mt-3 text-muted">Submitting results... please wait.</p>
  </div>
</div>


@endsection

@push('scripts')
<script>

  document.addEventListener('DOMContentLoaded', function () {
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    const applicantCheckboxes = document.querySelectorAll('.applicant-checkbox');

    selectAllCheckbox.addEventListener('change', function () {
        applicantCheckboxes.forEach(cb => cb.checked = selectAllCheckbox.checked);
    });
});


document.addEventListener('DOMContentLoaded', function () {
  window.showLeaderboards = function() {
    const uploadID = {{ $vacancy->uploadID }};
    fetch(`/applicant/${uploadID}/leaderboards`)
      .then(res => res.json())
      .then(data => {
        const tbody = document.querySelector('#leaderboardsModal tbody');
        tbody.innerHTML = '';
        data.forEach(item => {
          let medal = '';
          if (item.rank === 1) medal = '<span title="Gold Medal">🥇</span>';
          else if (item.rank === 2) medal = '<span title="Silver Medal">🥈</span>';
          else if (item.rank === 3) medal = '<span title="Bronze Medal">🥉</span>';
          else medal = item.rank;
          tbody.innerHTML += `
            <tr>
              <td class="fs-5 text-center">${medal}</td>
              <td>${item.fullname}</td>
              <td>${item.address}</td>
              <td><span class="fw-bold">${item.points}</span></td>
            </tr>`;
        });
        new bootstrap.Modal(document.getElementById('leaderboardsModal')).show();
      })
      .catch(err => {
        alert('Failed to load leaderboard data');
        console.error(err);
      });
  };

  document.querySelectorAll('.view-applicant-btn').forEach(button => {
    button.addEventListener('click', function () {
      const applicantID = this.getAttribute('data-id');
      fetch(`/applicant/${applicantID}/details`)
        .then(res => res.json())
        .then(data => {
          document.getElementById('applicantName').value = data.fullname;
          document.getElementById('applicationCode').value = data.applicantID;
          document.getElementById('currentPosition').value = data.currentPosition;
          document.getElementById('email').value = data.email;
          document.getElementById('contactNumber').value = data.contactNumber;
          document.getElementById('schoolName').value = data.schoolName;
          document.getElementById('schoolAddress').value = data.schoolAddress;
          new bootstrap.Modal(document.getElementById('viewApplicantModal')).show();
        })
        .catch(err => {
          alert('Failed to load applicant info');
          console.error(err);
        });
    });
  });

  document.querySelectorAll('.redirect-to-review').forEach(row => {
    row.addEventListener('click', function () {
      const uploadID = this.getAttribute('data-upload');
      const teacherID = this.getAttribute('data-teacher');
      const criteriaID = 1;
      window.location.href = `/districtsupervisor/review_documents/${uploadID}/${criteriaID}/${teacherID}`;
    });
  });
});


window.submitApplicantResults = function() {
  const uploadID = {{ $vacancy->uploadID }};
  const teacherIDs = [];

  document.querySelectorAll('tr.redirect-to-review').forEach(row => {
    const teacherID = row.getAttribute('data-teacher');
    if (teacherID) teacherIDs.push(teacherID);
  });

  if (teacherIDs.length === 0) {
    alert("No applicants to submit.");
    return;
  }

  // Ipakita confirmation modal
  const confirmModal = new bootstrap.Modal(document.getElementById('confirmSubmitModal'));
  confirmModal.show();

  document.getElementById('confirmSubmitBtn').onclick = function() {
    confirmModal.hide();
    startLoadingOverlay();

    let percent = 0;
    const progressBar = document.getElementById('loadingProgressBar');
    const percentText = document.getElementById('loadingPercentText');

    const interval = setInterval(() => {
      // Progress until ~90% while waiting for fetch
      if (percent < 90) {
        percent += 1;
        progressBar.style.width = percent + '%';
        percentText.textContent = percent + '%';
      }
    }, 30); // adjust speed as you like

    fetch('/districtsupervisor/submit-results', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: JSON.stringify({
        uploadID: uploadID,
        teacherIDs: teacherIDs
      })
    })
    .then(res => res.json())
    .then(data => {
  clearInterval(interval);

  // Fast-forward progress bar to 100% when done
  percent = 100;
  progressBar.style.width = percent + '%';
  percentText.textContent = percent + '%';

  setTimeout(() => {
    document.getElementById('loadingOverlay').style.visibility = 'hidden';

    if (data.success) {
      const successModalEl = document.getElementById('submitSuccessModal');
      const successModal = new bootstrap.Modal(successModalEl);
      successModal.show();

      // Auto-close success modal after 3 seconds
      setTimeout(() => {
        successModal.hide();
        // Optional redirect after closing modal
        // window.location.href = '/districtsupervisor'; 
      }, 3000);

    } else {
      alert('Failed to submit results.');
      console.error(data);
    }
  }, 300); // slight delay for smooth 100% transition
})

    .catch(err => {
      clearInterval(interval);
      document.getElementById('loadingOverlay').style.visibility = 'hidden';
      alert('Error occurred while submitting.');
      console.error(err);
    });
  };
};

function startLoadingOverlay() {
  document.getElementById('loadingOverlay').style.visibility = 'visible';
  document.getElementById('loadingProgressBar').style.width = '0%';
  document.getElementById('loadingPercentText').textContent = '0%';
}

function confirmStatusChange(newStatus) {
  const uploadID = {{ $vacancy->uploadID }};
  const selectedTeacherIDs = [];

  document.querySelectorAll('.applicant-checkbox:checked').forEach(checkbox => {
    selectedTeacherIDs.push(checkbox.value);
  });

  if (selectedTeacherIDs.length === 0) {
    alert("Please select at least one applicant.");
    return;
  }

  if (!confirm(`Are you sure you want to mark the selected applicants as "${newStatus}"?`)) return;

  fetch('/districtsupervisor/update-status', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    body: JSON.stringify({
      uploadID: uploadID,
      status: newStatus,
      teacherIDs: selectedTeacherIDs
    })
  })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert(`Selected applicants updated to "${newStatus}" successfully.`);
        location.reload();
      } else {
        alert('Failed to update status.');
      }
    })
    .catch(error => {
      console.error('Error updating status:', error);
      alert('Error occurred while updating status.');
    });
}


</script>
@endpush
