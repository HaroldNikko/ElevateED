@extends('admin.layoutadmin')

@section('content')

<style>
.custom-thead {
    background-color: #0C2340;
    text-align: center;
    color: white;
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
.table td, .table th {
    text-align: center;
    vertical-align: middle;
}
</style>

<div class="container mt-4">
    <!-- Header Row -->
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
        <div class="d-flex align-items-center flex-wrap">
            <a href="{{ route('admin.depedorder') }}" class="circle-btn">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h2 class="fw-bold mb-0">{{ $order->filename }} ({{ $order->year }})</h2>
        </div>
    </div>

    <!-- Criteria Table -->
    <div class="card p-3 rounded-3 shadow-sm">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead class="custom-thead">
                    <tr>
                        <th>#</th>
                        <th>Criteria</th>
                        <th>Max Points</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($criteriaList as $index => $criteria)
                        <tr style="cursor: pointer;" onclick="window.location.href='{{ route('admin.criteria.levels', $criteria->criteriaID) }}'">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $criteria->criteriaDetail }}</td>
                            <td>{{ $criteria->maxpoint }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
