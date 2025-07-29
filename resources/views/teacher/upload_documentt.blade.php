@extends('teacher.layout_teacher')

@section('content')


@php
  $step = request()->get('step', 1); // Default to step 1 if not provided
@endphp

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

  .back-btn-circle {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background-color: #0d2c53;
    color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
  }

  .back-btn-circle:hover {
    background-color: #0C2340;
    color: #fff;
  }

  .step-circle {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    background-color: #e0e0e0;
    color: #000;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
  }

  .step-circle.active {
    background-color: #0d2c53;
    color: #fff;
  }

  .progress-line {
    width: 60px;
    height: 2px;
    background-color: #ccc;
  }

  .next-arrow-btn {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background-color: #0d2c53;
    color: white;
    border: none;
    font-size: 1.2rem;
  }

  .form-section {
    background-color: #f8f9fa;
    padding: 40px;
    border-radius: 15px;
  }

  label {
    font-weight: 600;
  }
</style>

<div class="container mt-4">
  <div class="d-flex justify-content-center align-items-center gap-4 mb-5">
    <a href="{{ route('teacher.applicant') }}" class="back-btn-circle me-5">
      <i class="fas fa-arrow-left"></i>
    </a>

    <!-- Step 1 -->
    <div class="text-center">
      <div class="step-circle active">1</div>
      <small class="fw-bold d-block mt-1">Basic Details</small>
    </div>

    <div class="progress-line"></div>

    <!-- Step 2 -->
    <div class="text-center">
      <div class="step-circle">2</div>
      <small class="text-muted d-block mt-1">Document Submission</small>
    </div>

    <div class="progress-line"></div>

    <!-- Step 3 -->
    <div class="text-center">
      <div class="step-circle">3</div>
      <small class="text-muted d-block mt-1">Verification</small>
    </div>
  </div>

  <!-- Step 1 Form -->
  <div class="form-section">
    <h5 class="fw-bold mb-4">Basic Details</h5>
    <form method="GET" action="">
      @csrf
      <input type="hidden" name="uploadID" value="{{ request()->get('uploadID') }}">

      <div class="row g-3">
        <div class="col-md-6">
          <label>Applicant Code</label>
          <input type="text" name="applicantID" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label>Full Name</label>
          <input type="text" name="fullname" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label>Email</label>
          <input type="email" name="email" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label>Contact Number</label>
          <input type="text" name="contactnumber" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label>Current Position</label>
          <input type="text" name="CurrentPosition" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label>School Name</label>
          <input type="text" name="schoolname" class="form-control" required>
        </div>
        <div class="col-md-12">
          <label>School Address</label>
          <input type="text" name="schooladdress" class="form-control" required>
        </div>
      </div>

      <div class="mt-5 d-flex justify-content-end">
        <a href="?step=2&uploadID={{ request()->get('uploadID') }}" class="next-arrow-btn">
          <i class="fas fa-arrow-right"></i>
        </a>
      </div>
    </form>
  </div>




@php use Illuminate\Support\Str; @endphp

@if($step == 2)

  <ul class="nav nav-tabs flex-wrap" id="criteriaTabs" role="tablist">
    @foreach($criteria as $index => $item)
      <li class="nav-item" role="presentation">
        <a href="{{ route('upload.document', ['uploadID' => $position->uploadID, 'criteriaID' => $item->criteriaID]) }}?step=2"
           class="nav-link {{ $activeCriteriaID == $item->criteriaID || (!$activeCriteriaID && $index == 0) ? 'active' : '' }} text-truncate"
           id="tab-{{ $item->criteriaID }}"
           style="max-width: 150px;"
           role="tab">
          {{ $item->criteriaDetail }}
        </a>
      </li>
    @endforeach
  </ul>

  <div class="tab-content" id="criteriaTabsContent">
    @foreach($criteria as $index => $item)
      @if($activeCriteriaID == $item->criteriaID || (!$activeCriteriaID && $index == 0))
        <div class="tab-pane fade show active" id="content-{{ $item->criteriaID }}" role="tabpanel">
          <h5 class="mb-3 text-center fw-bold">
            CRITERION - {{ $item->criteriaDetail }} (MAX = {{ $item->maxpoint }} POINTS)
          </h5>

          <div class="table-responsive">
            <table class="table table-bordered align-middle draft-table">
              <thead class="custom-thead">
                <tr>
                  <th>NO.</th>
                  <th>Title of Paper</th>
                  <th>Date Presented</th>
                  <th>Achievement Categories</th>
                  <th>Faculty Score</th>
                  <th>Filename</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody class="draft-body">
                @php
                  $docs = $documents[$item->criteriaID] ?? collect();
                @endphp
                @foreach($docs as $i => $doc)
                  <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $doc->title }}</td>
                    <td>{{ \Carbon\Carbon::parse($doc->date_presented)->format('F d, Y') }}</td>
                    <td>{{ $doc->achievement_cat }}</td>
                    <td class="text-center">{{ $doc->faculty_score }}</td>
                    <td>{{ $doc->upload_file }}</td>
                    <td class="text-center">
                      <button class="btn btn-sm btn-outline-primary" onclick="viewPDF('{{ asset('storage/uploads/' . $doc->upload_file) }}')">
                        <i class="fas fa-eye"></i>
                      </button>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap responsive-action">
            <button class="btn btn-primary px-4" style="background-color: #0C2340; border-radius: 10px;" data-bs-toggle="modal" data-bs-target="#addDocumentModal">
              Add
            </button>
            
            <div class="d-flex align-items-center gap-3 mt-2 mt-md-0">
              <div class="fw-bold">
                Total: 
                <span class="total-score"
                      data-max="{{ $item->maxpoint }}"
                      style="color: #0C2340; font-weight: bold; font-size: 1rem;">
                  {{ min($docs->sum('faculty_score'), $item->maxpoint) }}
                </span>
              </div>

              <button class="btn btn-dark px-4" style="background-color: #0C2340; border-radius: 10px;" onclick="submitTotalPoints()">
                Submit
              </button>
            </div>
          </div>
        </div>
      @endif
    @endforeach
  </div>

@endif

</div>


<!-- Add Document Modal -->
<div class="modal fade" id="addDocumentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Upload Document</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="draftForm">
          <div class="mb-3">
            <label for="title" class="form-label">Title of the Paper</label>
            <input type="text" class="form-control" id="title" required>
          </div>
          <div class="mb-3">
            <label for="date_presented" class="form-label">Date Presented</label>
            <input type="date" class="form-control" id="date_presented" required>
          </div>
          <div class="mb-3">
            <label for="achievement_cat" class="form-label">Achievement Categories</label>
            <select class="form-select" id="achievement_cat" required>
              <option value="Local">Local</option>
              <option value="National">National</option>
              <option value="International">International</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="upload_file" class="form-label">Upload Document (.pdf)</label>
            <input class="form-control" type="file" id="upload_file" accept=".pdf" required>
            <div class="form-text">Only PDF files are allowed.</div>
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
<!-- Successfully Added Modal -->
<div class="modal fade" id="successAddModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content text-center p-3">
      <i class="fas fa-check-circle text-success mb-3" style="font-size: 2.5rem;"></i>
      <p class="mb-0">Document successfully added!</p>
    </div>
  </div>
</div>

<script>
function addDraftRow() {
  const title = document.getElementById('title').value;
  const date = document.getElementById('date_presented').value;
  const category = document.getElementById('achievement_cat').value;
  const fileInput = document.getElementById('upload_file');
  const file = fileInput.files[0];

  const activePane = document.querySelector('.tab-pane.show.active');
  const criteriaID = activePane ? activePane.id.replace('content-', '') : null;

  if (!criteriaID) return alert("Unable to identify current tab.");
  if (!file) return alert('Please upload a PDF file.');

  const formData = new FormData();
  formData.append('uploadID', "{{ $position->uploadID }}");
  formData.append('teacherID', "{{ session('Login_id') }}");
  formData.append('criteriaID', criteriaID);
  formData.append('title', title);
  formData.append('achievement_cat', category);
  formData.append('date_presented', date);
  formData.append('upload_file', file);

  fetch("{{ route('document-evaluation.store') }}", {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      const doc = data.data;

      const totalScoreCell = document.querySelector(`#content-${criteriaID} .total-score`);
      const currentScore = parseInt(totalScoreCell.textContent) || 0;
      const maxPoint = parseInt(totalScoreCell.getAttribute('data-max'));
      const newScore = parseInt(doc.score);

      const exceeded = currentScore + newScore > maxPoint;

      // Create new row regardless of exceeded
      const row = `
        <tr>
          <td>-</td>
          <td>${doc.title}</td>
          <td>${doc.date}</td>
          <td>${doc.category}</td>
          <td class="text-center">${doc.score}</td>
          <td>${doc.filename}</td>
          <td class="text-center">
            <button class="btn btn-sm btn-outline-primary" onclick="viewPDF('${doc.file_url}')">
              <i class="fas fa-eye"></i>
            </button>
          </td>
        </tr>
      `;
      document.querySelector(`#content-${criteriaID} .draft-body`).insertAdjacentHTML('beforeend', row);

      // Update total score capped at maxPoint
      totalScoreCell.textContent = Math.min(currentScore + newScore, maxPoint);

      // Show exceeded warning
      const noteContainer = document.querySelector(`#content-${criteriaID} .exceeded-note`);
      if (exceeded && noteContainer) {
        noteContainer.innerHTML = `<div class="text-danger fw-bold">Note: You've reached the maximum allowed score of ${maxPoint} for this criterion.</div>`;
      }

      // Close modal and show success
      bootstrap.Modal.getInstance(document.getElementById('addDocumentModal')).hide();
      document.getElementById('draftForm').reset();
      const successModal = new bootstrap.Modal(document.getElementById('successAddModal'));
      successModal.show();

      // Auto-close after 2 seconds
      setTimeout(() => {
        successModal.hide();
      }, 2000);
    } else {
      alert('Something went wrong while saving.');
    }
  })
  .catch(err => {
    console.error('Error uploading:', err);
    alert('Upload failed. Please try again.');
  });
}

function submitTotalPoints() {
  const totalScoreElements = document.querySelectorAll('.total-score');
  let grandTotal = 0;

  totalScoreElements.forEach(span => {
    const score = parseInt(span.textContent) || 0;
    grandTotal += score;
  });

  const uploadID = "{{ $position->uploadID }}";
  const teacherID = "{{ session('teacherID') }}";

  const formData = new FormData();
  formData.append('uploadID', uploadID);
  formData.append('teacherID', teacherID);
  formData.append('total_points', grandTotal);

  console.log('Submitting total points...');
  console.log('uploadID:', uploadID);
  console.log('teacherID:', teacherID);
  console.log('total_points:', grandTotal);

  fetch("{{ route('totalpoints.store') }}", {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: formData
  })
  .then(res => res.text()) // <- change to .text() to see HTML error
  .then(data => {
    console.log('Raw response:', data); // helpful for debugging 500 errors
    try {
      const json = JSON.parse(data);
      if (json.success) {
        alert(`Total points submitted: ${grandTotal}`);
      } else {
        alert("Failed to submit total points.");
      }
    } catch (err) {
      console.error("Response is not valid JSON:", err);
      alert("Server returned unexpected content.");
    }
  })
  .catch(err => {
    console.error('Error:', err);
    alert("Submission error.");
  });
}


function viewPDF(url) {
  document.getElementById('pdfViewer').src = url;
  new bootstrap.Modal(document.getElementById('viewPdfModal')).show();
}
</script>



@endsection
