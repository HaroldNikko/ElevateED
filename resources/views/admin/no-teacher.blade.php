@extends('admin.layoutadmin')

@section('content')
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-semibold mb-0">Teacher</h4>
  </div>

  <div class="row justify-content-center">
    <div class="col-12 col-md-10 col-lg-12">
      <div class="text-center p-5 bg-white rounded-4 shadow-sm" style="border: 1px solid #eee;">
        <img src="{{ asset('img/box.png') }}" alt="Empty Box" class="mb-3 img-fluid" style="max-height: 300px;">
        <h5 class="fw-bold">Almost there!</h5>
        <p class="text-muted">No evaluator found for <strong>{{ $school->Schoolname }}</strong>.</p>

        <div class="d-flex justify-content-center gap-3 mt-3">
            <a href="{{ route('admin.csv.import', $school->schoolID) }}"
                class="btn px-4 py-2 text-white"
                style="border-radius: 12px; background-color: #0C2340;">
            <i class="fas fa-file-csv me-2"></i> Import CSV
            </a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
