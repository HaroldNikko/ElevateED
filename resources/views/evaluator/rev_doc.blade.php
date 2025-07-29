@extends('evaluator.evaluator_layout')

@section('content')
<div class="container">
    @if ($assignedEvaluators->isNotEmpty())
        <div class="row">
            @foreach ($assignedEvaluators as $assignedEvaluator)
                <div class="col-md-4 mb-4">
                    <a href="{{ route('evaluator.teacher_info', ['uploadID' => $assignedEvaluator->uploadPosition->uploadID]) }}" class="text-decoration-none">
                        <div class="card shadow-sm h-100 card-hover rounded-4">
                            <div class="card-body hover-gray rounded-4">
                                <!-- Evaluator Information -->
                                <h5 class="card-title">{{ $assignedEvaluator->evaluator->FirstName }} {{ $assignedEvaluator->evaluator->LastName }}</h5>
                                <p class="card-text">Position: {{ $assignedEvaluator->evaluator->Position }}</p>

                                <!-- Upload Position Information -->
                                <p class="card-text">Teacher Rank: {{ $assignedEvaluator->uploadPosition->teacherRank->teacherRank }}</p>
                                <p class="card-text">School: {{ $assignedEvaluator->uploadPosition->school->Schoolname }}</p>
                                <p class="card-text">Total Applicants: {{ $assignedEvaluator->totalApplicants }}</p>
                                <p class="card-text">Upload ID: {{ $assignedEvaluator->uploadPosition->uploadID }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @else
        <p>No evaluators found for this position.</p>
    @endif
</div>
@endsection

@section('styles')
<style>
    /* Card hover effect */
    .card-hover {
        transition: background-color 0.3s ease;
    }
    .card-hover:hover {
        cursor: pointer;
    }
    .hover-gray:hover {
        background-color: #f8f9fa;
    }
    .card-hover:active {
        background-color: #e0e0e0;
    }
</style>
@endsection
