@extends('districtsupervisor.layout')

<style>
.custom-criterion-tabs {
  border-bottom: 2px solid #ccc;
  gap: 8px;
}
.custom-criterion-tabs .nav-link {
  border: none;
  background-color: transparent;
  color: #333;
  font-weight: 500;
  padding: 8px 16px;
  border-radius: 4px 4px 0 0;
  transition: background-color 0.2s;
}
.custom-criterion-tabs .nav-link:hover {
  background-color: #f1f1f1;
}
.custom-criterion-tabs .nav-link.active {
  background-color: #e0e0e0;
  color: #000;
  font-weight: bold;
  box-shadow: inset 0 -2px 0 #888;
}
.custom-eval-table thead th {
  background-color: #0c2340;
  color: white;
  font-weight: bold;
  vertical-align: middle;
}
.custom-eval-table td,
.custom-eval-table th {
  vertical-align: middle;
  padding: 12px 8px;
  font-size: 14px;
}
.custom-eval-table td.text-start {
  text-align: left !important;
}
.badge-dot {
  color: #f97316;
  font-size: 18px;
  line-height: 0;
  vertical-align: middle;
  margin-right: 4px;
}
</style>

@section('content')
<div class="container mt-4">

 <div class="d-flex align-items-center gap-2 flex-wrap mb-3">
    <a href=""
        class="btn btn-md text-white d-flex align-items-center justify-content-center"
        style="background-color: #0C2340; border: none; border-radius: 1rem; height: 42px;">
        <i class="fas fa-arrow-left"></i>
    </a>

    <h4 class="mb-0 text-start">
        Evaluation Documents - {{ $position->teacherRank->teacherRank }} | {{ $position->school->Schoolname }}
    </h4>
</div>

<ul class="nav custom-criterion-tabs" id="criteriaTab" role="tablist">
    @foreach ($criteria as $index => $crit)
      <li class="nav-item" role="presentation">
        <button class="nav-link {{ $index === 0 ? 'active' : '' }}"
                id="tab-{{ $crit->criteriaID }}"
                data-bs-toggle="tab"
                data-bs-target="#content-{{ $crit->criteriaID }}"
                type="button"
                role="tab">
          {{ $crit->criteriaDetail }}
        </button>
      </li>
    @endforeach
  </ul>

  <div class="tab-content" id="criteriaTabContent">
    @foreach ($criteria as $index => $crit)
      @php $docs = $documents[$crit->criteriaID] ?? collect(); @endphp
      <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}"
           id="content-{{ $crit->criteriaID }}"
           role="tabpanel">
        <div class="card">
          <div class="card-header bg-light fw-bold text-center">
            Criterion {{ chr(64 + $crit->criteriaID) }} - {{ $crit->criteriaDetail }} (MAX = {{ $crit->maxpoint }} POINTS)
          </div>
          <div class="card-body">
            @if ($docs->isEmpty())
              <p class="text-muted fst-italic">No documents submitted under this criterion.</p>
            @else
              <div class="table-responsive">
                <table class="table table-bordered text-center align-middle custom-eval-table mb-0">
                  <thead>
                    <tr>
                      <th>NO.</th>
                      <th>Title of Paper</th>
                      <th>Date Presented</th>
                      <th>Level</th>
                      <th>Faculty Score</th>
                      <th>Document</th>
                      <th>Status & Comment</th>
                      <th>Other Details</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($docs as $i => $doc)
                      <tr>
                        <td>{{ $i + 1 }}</td>
                        <td class="text-start px-3">{{ $doc->title }}</td>
                        <td>{{ \Carbon\Carbon::parse($doc->date_presented)->format('m/d/y') }}</td>
                        <td><span class="badge-dot"></span> {{ $doc->qualificationLevel->Level ?? '—' }}</td>
                        <td>{{ $doc->faculty_score ?? 0 }}</td>
                        <td>
                          @if ($doc->upload_file)
                            <button type="button" class="btn btn-sm btn-darkblue mb-1"
                              onclick="viewFile('{{ asset('storage/uploads/' . $doc->upload_file) }}')">
                              <i class="fas fa-eye"></i>
                            </button>
                          @else
                            <span class="text-muted">No file</span>
                          @endif
                        </td>
                        <td class="text-center">
                          <div class="d-flex flex-column align-items-center gap-1">
                            <span class="fw-semibold">{{ $doc->StatusOfDocument ?? 'Pending' }}</span>
                            <button class="btn btn-sm btn-darkblue"
                              onclick="viewComment(`{{ addslashes($doc->Comment ?? '') }}`)"
                              title="View Comment">
                              <i class="bi bi-envelope-fill"></i>
                            </button>
                          </div>
                        </td>
                        <td>
                          <button type="button" class="btn btn-sm btn-outline-secondary"
                            data-bs-toggle="modal" data-bs-target="#detailsModal{{ $crit->criteriaID }}{{ $i }}">
                            <i class="fas fa-eye"></i>
                          </button>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            @endif
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>

<!-- Modals for document details -->
@foreach ($criteria as $index => $crit)
  @php $docs = $documents[$crit->criteriaID] ?? collect(); @endphp
  @foreach ($docs as $i => $doc)
    <div class="modal fade" id="detailsModal{{ $crit->criteriaID }}{{ $i }}" tabindex="-1" aria-labelledby="detailsLabel{{ $crit->criteriaID }}{{ $i }}" aria-hidden="true">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="detailsLabel{{ $crit->criteriaID }}{{ $i }}">Other Document Details</h5>
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
  @endforeach
@endforeach

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

<!-- Modal for comment viewer -->
<div class="modal fade" id="commentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content p-3">
      <div class="modal-header">
        <h5 class="modal-title">Evaluator's Comment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p id="commentContent" class="fst-italic text-muted"></p>
      </div>
    </div>
  </div>
</div>

<script>
function viewFile(fileUrl) {
  document.getElementById('filePreviewIframe').src = fileUrl;
  new bootstrap.Modal(document.getElementById('filePreviewModal')).show();
}

function viewComment(comment) {
  const contentEl = document.getElementById('commentContent');
  contentEl.textContent = comment.trim() ? comment : "No comment provided.";
  new bootstrap.Modal(document.getElementById('commentModal')).show();
}
</script>
@endsection