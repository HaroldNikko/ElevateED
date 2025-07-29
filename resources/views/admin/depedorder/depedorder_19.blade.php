@extends('admin.layoutadmin')

@section('content')

<style>
.custom-thead {
    background-color: #0C2340;
    text-align: center;
    color: white;
}
.table th,
.table td {
    text-align: center;
    vertical-align: middle;
}
.table th.padded-th {
    padding-top: 16px;
    padding-bottom: 16px;
    padding-left: 20px;
    padding-right: 20px;
}
.table td.justify-text {
    text-align: justify;
}
.circle-btn {
    background-color: #0C2340;
    color: white;
    border: none;
    border-radius: 50%;
    width: 38px;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    margin-right: 10px;
}
.circle-btn:hover {
    background-color: #092035;
    color: white;
}
</style>

<div class="container mt-4">
    <!-- Header Row -->
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
        <!-- Left: Back + Title -->
        <div class="d-flex align-items-center flex-wrap">
            <a href="{{ route('admin.depedorder') }}" class="circle-btn">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h2 class="fw-bold mb-0">{{ $order->filename }} ({{ $order->year }})</h2>
        </div>

        <!-- Right: Add Button -->
        <a href="#" class="btn btn-primary rounded-pill mt-2 mt-md-0">
            <i class="fas fa-plus me-2"></i>Add Quality Standard
        </a>
    </div>

    <!-- Quality Standards Table -->
    <div class="card p-3 rounded-3 shadow-sm">
        <div class="table-responsive mt-3">
            <table class="table table-bordered">
                <thead class="custom-thead">
                    <tr>
                        <th class="padded-th">Teacher Rank</th>
                        <th class="padded-th">Level</th>
                        <th class="padded-th">Criteria</th>
                        <th class="padded-th">Quality Standard</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($qualityStandards as $qs)
                        <tr>
                            <td>{{ $qs->teacherRank->teacherRank ?? 'N/A' }}</td>
                            <td>{{ $qs->level }}</td>
                            <td>{{ $qs->criteria->criteriaDetail ?? 'N/A' }}</td>
                            <td class="justify-text">{{ $qs->QualityStandard }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
