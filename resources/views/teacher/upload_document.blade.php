@extends('teacher.layout_teacher')

@section('content')
@include('teacher.modal')


@if(session('teacherID'))
  <script>console.log("✅ teacherID in session: {{ session('teacherID') }}");</script>
@else
  <script>console.warn("❌ teacherID not found in session!");</script>
@endif

<style>


.nav-tabs .nav-link.active {
    background-color: #e0e0e0;
    font-weight: bold;
  }

  .tab-content {
    background: white;
    border: 1px solid #dee2e6;
    border-top: none;
    padding: 20px;
    border-radius: 0 0 10px 10px;
  }

  thead.custom-thead tr th {
    background-color: #0d2c53 !important;
    color: white !important;
    text-align: center;
  }

  .score-box {
    font-weight: bold;
  }

  @media (max-width: 576px) {
    .responsive-action {
      flex-direction: column !important;
      gap: 10px;
      text-align: center;
    }

    .responsive-action > * {
      width: 100%;
    }

    .table th, .table td {
      font-size: 12px;
    }
  }



.stepper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
    margin-bottom: 40px;
    max-width: 600px;
    margin-inline: auto;
}
.stepper::before {
    content: '';
    position: absolute;
    top: 18px;
    left: 14%;
    right: 14%;
    height: 2px;
    background-color: #e0e0e0;
    z-index: 0;
}
.step {
    position: relative;
    text-align: center;
    flex: 1;
    z-index: 1;
}
.circle {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background-color: #ccc;
    color: white;
    font-weight: bold;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: auto;
    position: relative;
    z-index: 1;
}
.circle.active {
    background-color: #0d2c53;
}
.step-title {
    font-size: 13px;
    margin-top: 6px;
    font-weight: 600;
    color: #333;
}
.form-control.rounded-pill {
    background-color: #ffffff; /* ✅ Set to white */
    transition: background-color 0.3s;
    border: 1px solid #ced4da;
}

.form-control.rounded-pill:not(:placeholder-shown),
.form-control.rounded-pill:focus {
    background-color: #ffffff;
    border: 1px solid #0d2c53;
    box-shadow: none;
}
</style>

<div class="container my-4">

    <!-- Stepper: OUTSIDE the Card -->
    <div class="stepper mb-4">
        <div class="step">
            <div class="circle step-circle" data-step="1">1</div>
            <div class="step-title fw-semibold">Basic Details</div>
        </div>
        <div class="step">
            <div class="circle step-circle" data-step="2">2</div>
            <div class="step-title fw-semibold">Document Submission</div>
        </div>
        <div class="step">
            <div class="circle step-circle" data-step="3">3</div>
            <div class="step-title fw-semibold">Verification</div>
        </div>
    </div>

    <!-- Card Wrapper containing Steps Content -->
    <div class="bg-white px-4 px-md-5 py-4 shadow rounded-4">

        <!-- Step 1 -->
        <div id="step1">
    <form id="basicForm" method="POST" action="{{ route('save.basic.details') }}">
        @csrf
        <h5 class="fw-bold mb-4">Basic Details</h5>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Applicant Code</label>
                <input type="text" name="applicant_code" class="form-control rounded-pill" required
                    value="{{ old('applicant_code', session('step1.applicant_code', $teacherInfo->applicantID ?? '')) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Full Name</label>
                <input type="text" name="full_name" class="form-control rounded-pill" required
                    value="{{ old('full_name', session('step1.full_name', ($teacherInfo->firstname ?? '') . ' ' . ($teacherInfo->middlename ?? '') . ' ' . ($teacherInfo->lastname ?? ''))) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control rounded-pill" required
                    value="{{ old('email', session('step1.email', $teacherInfo->email ?? '')) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Contact Number</label>
                <input type="text" name="contact_number" class="form-control rounded-pill" required
                    value="{{ old('contact_number', session('step1.contact_number', $teacherInfo->phonenumber ?? '')) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Current Position</label>
                <input type="text" name="current_position" class="form-control rounded-pill" required
                    value="{{ old('current_position', session('step1.current_position')) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">School Name</label>
                <input type="text" name="school_name" class="form-control rounded-pill" required
                    value="{{ old('school_name', session('step1.school_name', $teacherInfo->school->Schoolname ?? '')) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">School Address</label>
                <input type="text" name="school_address" class="form-control rounded-pill" required
                    value="{{ old('school_address', session('step1.school_address', $teacherInfo->school->schooladdress ?? '')) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Address</label>
                <input type="text" name="address" class="form-control rounded-pill" required
                    value="{{ old('address', session('step1.address', $teacherInfo->Address ?? '')) }}">
            </div>
        </div>

        <!-- Navigation Button -->
        <div class="d-flex justify-content-end mt-4">
            <button type="button" id="step1NextBtn" class="btn btn-primary rounded-circle px-3 py-2" style="background-color: #0d2c53;">
                <i class="fas fa-arrow-right"></i>
            </button>
        </div>
    </form>
</div>



   <!-- STEP 2 Document Submission -->
<div id="step2" style="display: none;">
    <!-- Guidelines Button -->
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
        <h5 class="fw-bold mb-0">Document Submission</h5>
        <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#educationGuidelinesModal">
            <i class="fas fa-info-circle"></i> Guidelines
        </button>
    </div>

    <!-- Criteria Tabs -->
    <ul class="nav nav-tabs flex-wrap" id="criteriaTabs" role="tablist">
        @foreach($criteria as $index => $item)
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $item->criteriaID == $activeCriteriaID ? 'active' : '' }} text-truncate"
                        id="tab-{{ $item->criteriaID }}"
                        data-bs-toggle="tab"
                        data-bs-target="#content-{{ $item->criteriaID }}"
                        type="button"
                        role="tab"
                        aria-controls="content-{{ $item->criteriaID }}"
                        aria-selected="{{ $index === 0 ? 'true' : 'false' }}"
                        style="max-width: 150px;">
                    {{ $item->criteriaDetail }}
                </button>
            </li>
        @endforeach
    </ul>

    <div class="tab-content" id="criteriaTabsContent">
        @foreach($criteria as $index => $item)
            <div class="tab-pane fade {{ $item->criteriaID == $activeCriteriaID ? 'show active' : '' }}" id="content-{{ $item->criteriaID }}">
                @if(isset($qualityStandards[$item->criteriaID]))
                    <div class="text-muted my-2 text-center" style="font-size: 0.9rem;">
                        {{ $qualityStandards[$item->criteriaID]->map(fn($qs) => $qs->QualityStandard . ' (Level ' . $qs->level . ')')->implode(' | ') }}
                    </div>
                @endif

                <h5 class="mb-3 text-center fw-bold">
                    CRITERION - {{ $item->criteriaDetail }} (MAX = {{ $item->maxpoint }} POINTS)
                </h5>

                <div class="table-responsive">
              <table class="table table-bordered align-middle draft-table">
                <thead class="custom-thead">
                  <tr>
                    <th>NO.</th>
                    <th>Title</th>
                    <th>Date Presented</th>
                    <th>Faculty Score</th>
                    <th>Filename</th>
                    <th>Level</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody class="draft-body">
                  @php
                    $docs = $documents[$item->criteriaID] ?? collect();
                    $draftDocs = $drafts[$item->criteriaID] ?? collect();
                  @endphp
                  @foreach($draftDocs as $j => $draft)
                  <tr>
                    <td>{{ $docs->count() + $j + 1 }}</td>
                    <td>{{ $draft['title'] }}</td>
                    <td>{{ \Carbon\Carbon::parse($draft['date_presented'])->format('F d, Y') ?? '-' }}</td>
                    <td class="text-center">{{ $draft['faculty_score'] ?? 'N/A' }}</td>
                    <td>{{ $draft['original_name'] ?? $draft['upload_file'] }}</td>
                    <td>{{ $draft['qualification_level'] ?? '-' }}</td>
                    <td class="text-center">
                      <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#viewDetailModal{{ $j }}">
                        <i class="fas fa-eye"></i>
                      </button>
                      <button class="btn btn-sm btn-outline-danger" onclick="deleteDraft('{{ $draft['upload_file'] }}', this)">
                        <i class="fas fa-trash"></i>
                      </button>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
              <button class="btn btn-primary px-4 open-add-modal"
                      style="background-color: #0C2340; border-radius: 10px;"
                      data-bs-toggle="modal"
                      data-bs-target="#addDocumentModal"
                      data-criteria-id="{{ $item->criteriaID }}">
                Add
              </button>
              <div class="fw-bold mt-2">
                Total: <span class="total-score" data-max="{{ $item->maxpoint }}">
                  {{ collect($drafts[$item->criteriaID] ?? [])->sum('faculty_score') }}
                </span>
              </div>
            </div>

            @foreach($draftDocs as $j => $draft)
            <!-- Modal -->
            <div class="modal fade" id="viewDetailModal{{ $j }}" tabindex="-1" aria-labelledby="detailLabel{{ $j }}" aria-hidden="true">
              <div class="modal-dialog modal-md">
                <div class="modal-content">
                  <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="detailLabel{{ $j }}">Document Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <p><strong>From:</strong> {{ $draft['level_from'] ?? '-' }}</p>
                    <p><strong>To:</strong> {{ $draft['level_to'] ?? '-' }}</p>
                    <p><strong>Description:</strong> {{ $draft['description'] ?? '-' }}</p>
                  </div>
                </div>
              </div>
            </div>
            @endforeach

          </div>
        @endforeach
      </div>

      <!-- Step 2 Navigation -->
      <div class="d-flex justify-content-between mt-4">
        <button type="button" class="btn btn-primary rounded-circle px-3 py-2" style="background-color: #0d2c53;" onclick="goToStep(1)">
          <i class="fas fa-arrow-left"></i>
        </button>
        <button type="button" class="btn btn-primary rounded-circle px-3 py-2" style="background-color: #0d2c53;" onclick="goToStep(3)">
          <i class="fas fa-arrow-right"></i>
        </button>
      </div>
    </div>





      
 <!-- Step 3 -->
@php
    use App\Models\TotalPoint;

    $teacherID = session('teacherID');
    $uploadID = session('uploadID');
    $alreadySubmitted = TotalPoint::where('teacherID', $teacherID)
                        ->where('uploadID', $uploadID)
                        ->exists();
@endphp

<div id="step3" style="display: none;">
    <form method="POST" action="{{ route('submit.application') }}">
        @csrf

        <h5 class="fw-bold mb-3 text-dark" style="color: #0d2c53 !important;">Verification</h5>
        <p class="text-muted" style="font-size: 0.9rem;">
            <strong>Note:</strong> Please review all the information you have provided before final submission.
            Make sure everything is accurate and complete. Once submitted, your application will be forwarded for evaluation and can no longer be edited.
        </p>

        <div class="row g-4">
            <!-- Left: Basic Info -->
        <div class="col-md-6">
            <div class="bg-light rounded p-4 border shadow-sm">
                <h6 class="fw-bold mb-4 text-center" style="color: #0d2c53;">Application Form</h6>

                <p><strong style="color:#0d2c53;">Applicant Code:</strong> {{ session('step1.applicant_code') }}</p>
                <p><strong style="color:#0d2c53;">Full Name:</strong> {{ session('step1.full_name') }}</p>
                <p><strong style="color:#0d2c53;">Email Address:</strong> {{ session('step1.email') }}</p>
                <p><strong style="color:#0d2c53;">Contact Number:</strong> {{ session('step1.contact_number') }}</p>
                <p><strong style="color:#0d2c53;">Current Position:</strong> {{ session('step1.current_position') }}</p>
                <p><strong style="color:#0d2c53;">School Name:</strong> {{ session('step1.school_name') }}</p>
                <p><strong style="color:#0d2c53;">School Address:</strong> {{ session('step1.school_address') }}</p>
                <p class="mb-0"><strong style="color:#0d2c53;">Address:</strong> {{ session('step1.address') }}</p> <!-- ✅ Added -->
            </div>
        </div>


            <!-- Right: Submitted Criteria -->
            <div class="col-md-6">
                <div class="bg-light rounded p-4 border shadow-sm">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="fw-bold mb-1" style="color: #0d2c53;">Documents Submitted:</h6>
                        <div class="small">
                            <span class="me-3 text-success"><i class="fas fa-check-circle"></i> Submitted</span>
                            <span class="text-danger"><i class="fas fa-times-circle"></i> Not Submitted</span>
                        </div>
                    </div>

                    <ul class="list-group">
                        <li class="list-group-item fw-semibold d-flex justify-content-between" style="background-color: #0d2c53; color: white;">
                            <span>Criteria</span>
                            <span>Status</span>
                        </li>

                        @foreach($criteria as $crit)
                            @php
                                $finalDocs = collect($documents[$crit->criteriaID] ?? [])
                                    ->merge($drafts[$crit->criteriaID] ?? []);
                                $hasDocuments = $finalDocs->isNotEmpty();
                            @endphp

                            <li class="list-group-item d-flex justify-content-between align-items-center"
                                data-criteria-id="{{ $crit->criteriaID }}">
                                <span style="color: #0d2c53;">{{ $crit->criteriaDetail }}</span>
                                <span class="{{ $hasDocuments ? 'text-success' : 'text-danger' }} fw-bold">
                                    <i class="fas fa-{{ $hasDocuments ? 'check' : 'times' }}-circle"></i>
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        @if (!$alreadySubmitted)
            <div class="form-check mt-4 mb-4">
                <input class="form-check-input" type="checkbox" id="confirmSubmit" required onchange="document.getElementById('finalSubmitBtn').disabled = !this.checked;">
                <label class="form-check-label" for="confirmSubmit" style="color: #0d2c53;">
                    I confirm that all details I entered are correct and I’m ready to submit my application for evaluation.
                </label>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center">
            <button type="button" class="btn px-3 py-2 text-white" style="background-color: #0d2c53; border-radius: 50%;" onclick="goToStep(2)">
                <i class="fas fa-arrow-left"></i>
            </button>

            @if ($alreadySubmitted)
                <div class="alert alert-success mb-0 ms-2">
                    <i class="fas fa-check-circle me-2"></i> You have already submitted this application.
                </div>
            @else
                <button type="submit" class="btn px-4 d-flex align-items-center gap-2 text-white"
                    style="border-radius: 10px; background-color: #0d2c53;" id="finalSubmitBtn" disabled>
                    <i class="fas fa-cloud-upload-alt"></i> SUBMIT
                </button>
            @endif
        </div>
    </form>
</div>



</div>


    </div>
</div>




<div class="modal fade" id="addDocumentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg"> <!-- Made wider using modal-xl -->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Upload Document</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="draftForm">
          <!-- Title and Qualification Level in one row -->
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="title" class="form-label">Title of the Document</label>
              <input type="text" class="form-control" id="title" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="qualification_level" class="form-label">Qualification Level</label>
             <select class="form-select" id="qualification_level" required onchange="toggleLevelFields()">
                <option value="">-- Select Level --</option>
            </select>



            </div>
          </div>

          <!-- Level From and To -->
          <div class="row" id="levelFields" style="display: none;">
            <div class="col-md-6 mb-3">
              <label for="level_from" class="form-label">From</label>
              <input type="text" class="form-control" id="level_from" placeholder="e.g., 2022">
            </div>
            <div class="col-md-6 mb-3">
              <label for="level_to" class="form-label">To</label>
              <input type="text" class="form-control" id="level_to" placeholder="e.g., 2023">
            </div>
          </div>

          <!-- Description -->
          <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" rows="3"></textarea>
          </div>
 <div class="mb-3">
  <label for="faculty_score" class="form-label">Faculty Score</label>
  <input type="number" step="0.01" class="form-control" id="faculty_score" required placeholder="Enter faculty score">
</div>


          <!-- Upload Document and Date Presented in one row -->
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="upload_file" class="form-label">Upload Document (.pdf)</label>
              <input class="form-control" type="file" id="upload_file" accept=".pdf" required>
              <div class="form-text">Only PDF files are allowed.</div>
            </div>
            <div class="col-md-6 mb-3">
              <label for="date_presented" class="form-label">Date Presented <small class="text-muted">(optional)</small></label>
              <input type="date" class="form-control" id="date_presented">
            </div>
          </div>
        </form>

        <hr>
        <div class="text-end">
          <button class="btn btn-primary" onclick="addDraftRow()">Add</button>
        </div>
      </div>
    </div>
  </div>
</div>




<!-- PDF View Modal -->
<div class="modal fade" id="viewPdfModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">View PDF</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <iframe id="pdfViewer" src="" style="width:100%; height:80vh; border:none;"></iframe>
      </div>
    </div>
  </div>
</div>


<script>
function goToStep(step) {
    document.querySelectorAll('#step1, #step2, #step3').forEach(div => div.style.display = 'none');
    document.getElementById(`step${step}`).style.display = 'block';

    const stepCircles = document.querySelectorAll('.step-circle');
    stepCircles.forEach(el => el.classList.remove('active'));
    for (let i = 1; i <= step; i++) {
        document.querySelector(`.step-circle[data-step="${i}"]`).classList.add('active');
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const step = Number("{{ session('step') ?? 1 }}") || 1;
    goToStep(step);

    // Step 1: Next button
    document.getElementById('step1NextBtn')?.addEventListener('click', function () {
        const form = document.getElementById('basicForm');
        if (form.checkValidity()) form.submit();
        else form.reportValidity();
    });

    // Final Submit checkbox logic
    const confirmCheckbox = document.getElementById('confirmSubmit');
    const submitBtn = document.getElementById('finalSubmitBtn');
    if (confirmCheckbox && submitBtn) {
        confirmCheckbox.addEventListener('change', function () {
            submitBtn.disabled = !this.checked;
        });
    }

    // Final Submit spinner
    const finalForm = document.querySelector('form[action="{{ route('submit.application') }}"]');
    if (finalForm && submitBtn) {
        finalForm.addEventListener('submit', function () {
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Submitting...
            `;
        });
    }

    // ✅ Qualification Level Dynamic Dropdown per Criteria Tab
    const qualificationData = @json($qualificationLevels);
    const qualityLevels = @json($qualityStandards); // Pass quality standard levels

    document.querySelectorAll('.open-add-modal').forEach(button => {
        button.addEventListener('click', () => {
            const criteriaID = button.getAttribute('data-criteria-id');
            window.currentCriteriaID = criteriaID;

            const dropdown = document.getElementById('qualification_level');
            dropdown.innerHTML = '<option value="">-- Select Level --</option>';
            if (qualificationData[criteriaID]) {
                qualificationData[criteriaID].forEach(q => {
                    dropdown.innerHTML += `<option value="${q.Level}">Level ${q.Level}</option>`;
                });
            }

            document.getElementById('level_from').value = '';
            document.getElementById('level_to').value = '';
            document.getElementById('faculty_score').value = '';
            document.getElementById('levelFields').style.display = 'none';
        });
    });
});

function toggleLevelFields() {
    const level = document.getElementById('qualification_level').value;
    const levelFields = document.getElementById('levelFields');
    const criteriaID = window.currentCriteriaID;

    if (level !== "") {
        fetch(`/teacher/qualification-level/${criteriaID}/${level}`)
            .then(response => response.json())
            .then(data => {
                levelFields.style.display = 'flex';
                document.getElementById('level_from').value = data.from ?? '';
                document.getElementById('level_to').value = data.to ?? '';
            })
            .catch(() => {
                levelFields.style.display = 'none';
                document.getElementById('level_from').value = '';
                document.getElementById('level_to').value = '';
            });

        // ✅ Auto-compute Faculty Score
        const qualityLevels = @json($qualityStandards);
        const selectedLevel = parseInt(level);
        const maxQualityLevel = Math.max(...(qualityLevels[criteriaID]?.map(q => parseInt(q.level)) ?? [0]));
        const diff = selectedLevel - maxQualityLevel;

        let score = 0;
        if (diff >= 10) score = 10;
        else if (diff >= 8) score = 8;
        else if (diff >= 6) score = 6;
        else if (diff >= 4) score = 4;
        else if (diff >= 2) score = 2;
        else score = 0;


        document.getElementById('faculty_score').value = score;
    } else {
        levelFields.style.display = 'none';
        document.getElementById('level_from').value = '';
        document.getElementById('level_to').value = '';
        document.getElementById('faculty_score').value = '';
    }
}

function addDraftRow() {
    const title = document.getElementById('title').value;
    const qualification = document.getElementById('qualification_level').value;
    const levelFrom = document.getElementById('level_from').value;
    const levelTo = document.getElementById('level_to').value;
    const description = document.getElementById('description').value;
    const datePresented = document.getElementById('date_presented').value;
    const facultyScore = document.getElementById('faculty_score').value;
    const uploadFile = document.getElementById('upload_file').files[0];
    const criteriaID = window.currentCriteriaID;
    const uploadID = '{{ $position->uploadID }}';
    const csrf = '{{ csrf_token() }}';

    if (!title || !facultyScore || !uploadFile) {
        alert('Please fill out required fields and select a PDF file.');
        return;
    }

    const formData = new FormData();
    formData.append('title', title);
    formData.append('qualification_level', qualification);
    formData.append('level_from', levelFrom);
    formData.append('level_to', levelTo);
    formData.append('description', description);
    formData.append('date_presented', datePresented);
    formData.append('faculty_score', facultyScore);
    formData.append('upload_file', uploadFile);
    formData.append('criteriaID', criteriaID);
    formData.append('uploadID', uploadID);
    formData.append('_token', csrf);

    fetch('{{ route("store.draft") }}', {
        method: 'POST',
        body: formData
    })
    .then(async res => {
        const text = await res.text();
        try {
            const data = JSON.parse(text);
            if (data.success) {
                const modal = bootstrap.Modal.getInstance(document.getElementById('addDocumentModal'));
                modal.hide();
                location.reload();
            } else {
                console.warn('⚠️ Validation failed:', data.errors || 'Unknown error');
                alert('Validation failed. Please check your input.');
            }
        } catch (err) {
            console.error('❌ Unexpected non-JSON response:', text);
            alert('Unexpected error occurred. Please try again.');
        }
    })
    .catch(err => {
        console.error('❌ Request failed:', err);
        alert('Network/server error.');
    });
}

function deleteDraft(filename, buttonElement) {
    if (!confirm('Are you sure you want to delete this draft?')) return;

    fetch('{{ route("delete.draft") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            filename: filename,
            uploadID: '{{ $position->uploadID }}'
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            const row = buttonElement.closest('tr');
            row.remove();
        } else {
            alert('Failed to delete draft.');
        }
    });
}
</script>


@endsection
