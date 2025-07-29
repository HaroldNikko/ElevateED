@extends('evaluator.evaluator_layout')

@section('content')

<style>
    .nav-tabs { border-bottom: none; }
    .nav-tabs .nav-link { color: #000; font-weight: normal; border: none; position: relative; background: transparent; }
    .nav-tabs .nav-link.active { background-color: #e0e0e0; font-weight: bold; border-radius: 6px 6px 0 0; border: none; }
    .nav-tabs .nav-link.active::after { content: ""; position: absolute; bottom: -2px; left: 0; width: 100%; height: 3px; background-color: #888; border-radius: 10px; }
    .custom-thead th { background-color: #0d2c53 !important; color: white !important; text-align: center; }
    .badge-dot { color: #f97316; font-size: 18px; line-height: 0; vertical-align: middle; margin-right: 4px; }

    .btn-darkblue { background-color: #0C2340; color: white; }
    .btn-darkblue:hover { background-color: #08172a; color: white; }
    .btn-outline-darkblue { border: 2px solid #0C2340; color: #0C2340; }
    .btn-outline-darkblue:hover { background-color: #0C2340; color: white; }
</style>

<div class="container mt-4">

    <div class="d-flex justify-content-start mb-3 gap-2">
        <a href="{{ route('evaluator.teacher_info', [$uploadID]) }}"
            class="btn btn-md text-white d-flex align-items-center justify-content-center btn-darkblue"
            style="border-radius: 1rem; height: 38px;">
            <i class="fas fa-arrow-left"></i>
        </a>
    </div>

    <ul class="nav nav-tabs mb-3">
        @foreach($criteriaList as $criterion)
        <li class="nav-item">
            <a class="nav-link {{ $criterion->criteriaID == $activeCriteria->criteriaID ? 'active' : '' }}"
               href="{{ route('evaluator.final_review_doc', [$teacherID, $uploadID]) }}?criteriaID={{ $criterion->criteriaID }}">
                {{ strtoupper($criterion->criteriaDetail) }}
            </a>
        </li>
        @endforeach
    </ul>

    <h5 class="mb-3 text-center fw-bold" style="color: #0d2c53;">
        Criterion {{ chr(64 + $activeCriteria->criteriaID) }} - {{ strtoupper($activeCriteria->criteriaDetail) }}
        (MAX = {{ $activeCriteria->maxpoint }} POINTS)
    </h5>

    <table class="table table-bordered text-center align-middle">
        <thead class="custom-thead">
            <tr>
                <th>NO.</th>
                <th>Title of Paper</th>
                <th>Date Presented</th>
                <th>Level</th>
                <th>Faculty Score</th>
                <th>Document</th>
                <th>Status</th>
                <th>Other Details</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($documents as $index => $doc)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $doc->title }}</td>
                <td>{{ \Carbon\Carbon::parse($doc->date_presented)->format('m/d/y') }}</td>
                <td><span class="badge-dot"></span> {{ $doc->qualificationLevel->Level ?? '—' }}</td>
                <td>{{ $doc->faculty_score ?? '—' }}</td>

                <td class="text-nowrap">
                    @if ($doc->upload_file)
                        <button type="button" class="btn btn-sm btn-darkblue mb-1"
                            onclick="viewFile('{{ asset('storage/uploads/' . $doc->upload_file) }}')">
                            <i class="fas fa-eye"></i>
                        </button>
                        <div class="dropdown d-inline">
                            <button class="btn btn-outline-darkblue btn-sm" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-h"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item text-success" href="#"
                                        onclick="confirmApprove('{{ $doc->documentID }}')">
                                        <i class="fas fa-check-circle me-2"></i> Approve
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger" href="#"
                                        onclick="confirmReject('{{ $doc->documentID }}')">
                                        <i class="fas fa-times-circle me-2"></i> Reject
                                    </a>
                                </li>
                            </ul>
                        </div>
                    @else
                        <span class="text-muted">No file</span>
                    @endif
                </td>

                <td>
                    <div class="d-flex flex-column align-items-center gap-1">
                        <span class="fw-semibold">{{ $doc->StatusOfDocument ?? 'Pending' }}</span>
                    </div>
                </td>

                <td>
                    <button type="button" class="btn btn-sm btn-outline-secondary"
                        data-bs-toggle="modal" data-bs-target="#otherDetailsModal{{ $index }}">
                        <i class="fas fa-eye"></i>
                    </button>
                </td>
            </tr>

            <!-- Modal for Other Details -->
            <div class="modal fade" id="otherDetailsModal{{ $index }}" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Other Document Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <p><strong>From:</strong> {{ $doc->qualificationLevel->From ?? '-' }}</p>
                    <p><strong>To:</strong> {{ $doc->qualificationLevel->To ?? '-' }}</p>
                    <p><strong>Description:</strong> {{ $doc->description ?? '-' }}</p>
                  </div>
                </div>
              </div>
            </div>

            @empty
            <tr>
                <td colspan="8">No documents submitted for this criterion.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modal for file viewer -->
<div class="modal fade" id="filePreviewModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Document Preview</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0" style="height: 80vh;">
        <iframe id="filePreviewIframe" src="" frameborder="0" style="width:100%; height:100%;"></iframe>
      </div>
    </div>
  </div>
</div>

<!-- Modal Approve -->
<div class="modal fade" id="statusApproveModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content text-center p-4 rounded-4">
      <div class="modal-body">
        <i class="fas fa-check-circle fa-2x mb-3 text-success"></i>
        <p class="fw-bold mb-3" id="statusApproveText"></p>
        <div class="d-flex justify-content-center">
          <button type="button" class="btn btn-md btn-danger me-2" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-md btn-darkblue" id="approveYesBtn">Confirm</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Reject -->
<div class="modal fade" id="statusRejectModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content text-center p-4 rounded-4">
      <div class="modal-body">
        <i class="fas fa-times-circle fa-2x mb-3 text-danger"></i>
        <p class="fw-bold mb-3">Please provide a reason for rejection:</p>
        <textarea id="rejectComment" class="form-control mb-3" rows="3" placeholder="Enter comment..."></textarea>
        <div class="d-flex justify-content-center">
          <button type="button" class="btn btn-md btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-md btn-darkblue" id="rejectYesBtn">Reject</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function viewFile(fileUrl) {
    document.getElementById('filePreviewIframe').src = fileUrl;
    new bootstrap.Modal(document.getElementById('filePreviewModal')).show();
}

let selectedDocID;

function confirmApprove(documentID) {
    selectedDocID = documentID;
    document.getElementById('statusApproveText').textContent = 'Are you sure you want to approve this document?';
    new bootstrap.Modal(document.getElementById('statusApproveModal')).show();
}

document.getElementById('approveYesBtn').addEventListener('click', function () {
    sendUpdate(selectedDocID, 'Approved', null);
});

function confirmReject(documentID) {
    selectedDocID = documentID;
    document.getElementById('rejectComment').value = '';
    new bootstrap.Modal(document.getElementById('statusRejectModal')).show();
}

document.getElementById('rejectYesBtn').addEventListener('click', function () {
    const comment = document.getElementById('rejectComment').value.trim();
    sendUpdate(selectedDocID, 'Rejected', comment);
});

function sendUpdate(docID, status, comment) {
    fetch(`{{ route('evaluator.document.updateStatus') }}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ documentID: docID, status: status, comment: comment })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Failed to update status.');
            location.reload();
        }
    })
    .catch(() => {
        alert('An error occurred while updating status.');
        location.reload();
    });
}
</script>


@endsection
