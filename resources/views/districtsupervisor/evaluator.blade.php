@extends('districtsupervisor.layout')

@section('content')

<div class="container py-4">
    <h3 class="text-center mb-4">Assigned Evaluators</h3>

    <!-- Card Container: Display evaluators' details dynamically -->
    <div class="row" id="cardContainer">
        
        <!-- Static Evaluator Card -->
        <div class="col-md-4 mb-4"> <!-- Changed to col-md-4 for smaller column width -->
            <div class="card shadow rounded-4 p-3">
                <!-- Evaluator's Full Name -->
                <div class="card-body">
                    <h5 class="card-title">
                        Cammel Garcia Salanguit
                    </h5>
                    
                    <!-- Track Code, Teacher Rank, School Name -->
                    <p><strong>Track Code:</strong> TRK-55D89E405C12</p>
                    <p><strong>Teacher Rank:</strong> Teacher II</p>
                    <p><strong>School:</strong> Nasugbu West Central School</p>
                    <p><strong>Start Date:</strong> 2025-07-13</p>
                    <p><strong>End Date:</strong> 2025-07-14</p>
                </div>
            </div>
        </div>

        <!-- Card with Plus Button (Add Evaluator) -->
        <div class="col-md-4 mb-4"> <!-- Also set to col-md-4 for consistency -->
            <div class="card shadow rounded-4 d-flex align-items-center justify-content-center" style="height: 300px;">
                <button class="btn btn-outline-primary rounded-circle" style="width: 60px; height: 60px; font-size: 30px; border: 2px solid #007bff;" data-bs-toggle="modal" data-bs-target="#addEvaluatorModal">
                    +
                </button>
            </div>
        </div>
    </div>

</div>

<!-- Modal for adding Evaluator -->
<div class="modal fade" id="addEvaluatorModal" tabindex="-1" aria-labelledby="addEvaluatorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEvaluatorModalLabel">Add Evaluator</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="GET" action="{{ route('evaluator') }}">
                    <div class="mb-3">
                        <label for="trackCode" class="form-label">Track Code</label>
                        <select class="form-select" id="trackCode" name="trackCode">
                            <option value="" disabled selected>Select Track Code</option>
                            @foreach($trackCodes as $track)
                                <option value="{{ $track->track_code }}" @if($track->track_code == request('trackCode')) selected @endif>
                                    {{ $track->track_code }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="evaluator" class="form-label">Evaluator</label>
                        <select class="form-select" id="evaluator">
                            <option value="" disabled selected>Select Evaluator</option>
                            @foreach($evaluators as $evaluator)
                                <option value="{{ $evaluator->Login_id }}">
                                    {{ $evaluator->firstname }} {{ $evaluator->middlename }} {{ $evaluator->lastname }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="school" class="form-label">School</label>
                        <input type="text" class="form-control" id="school" value="{{ $schoolName }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="teacherPosition" class="form-label">Teacher Position</label>
                        <input type="text" class="form-control" id="teacherPosition" value="{{ $teacherRank }}" readonly>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Trigger AJAX request when track code is selected
        $('#trackCode').change(function() {
            var trackCode = $(this).val();

            if (trackCode) {
                $.ajax({
                    url: '{{ route("fetch.school.teacher") }}',
                    method: 'GET',
                    data: {
                        trackCode: trackCode
                    },
                    success: function(response) {
                        // Update school name and teacher rank based on response
                        $('#school').val(response.school);
                        $('#teacherPosition').val(response.teacherRank);
                    }
                });
            }
        });
    });
</script>
@endpush
