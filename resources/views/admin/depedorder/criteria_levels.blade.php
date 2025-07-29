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
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
        <div class="d-flex align-items-center flex-wrap">
            <a href="{{ route('admin.depedorder.show20', $criteria->depedOrder->DepedID) }}" class="circle-btn">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h2 class="fw-bold mb-0">{{ $criteria->criteriaDetail }} Qualification Levels</h2>
        </div>
    </div>

    <div class="card p-3 rounded-3 shadow-sm">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="custom-thead">
                    <tr>
                        <th>Level</th>
                        <th>From</th>
                        <th>To</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($levels as $level)
                        <tr>
                            <td>{{ $level->Level }}</td>
                            <td>{{ $level->From }}</td>
                            <td>{{ $level->To }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">No qualification levels found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
