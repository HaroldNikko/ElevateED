@extends('admin.layoutadmin')

@push('styles')
<style>
.line-input {
    border: none;
    border-bottom: 1px solid #ccc;
    border-radius: 0;
    background: transparent;
    padding-left: 0;
    padding-right: 0;
}
.line-input:focus {
    border-bottom: 2px solid #0C2340;
    box-shadow: none;
    outline: none;
}
.custom-thead {
    background-color: #0C2340;
    color: white;
}
.table th, .table td {
    text-align: center;
    vertical-align: middle;
}
</style>
@endpush

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-1">
           <a href="{{ route('admin.region.provinces', ['id' => $province->region_id]) }}"
            class="btn btn-sm rounded-circle d-flex align-items-center justify-content-center"
            style="background-color:#0C2340; color:white; width: 36px; height: 36px;">
                <i class="fas fa-arrow-left"></i>
            </a>

            <h4 class="mb-0">Legislative Districts in: <strong>{{ $province->province_name }}</strong></h4>
        </div>
        <button class="btn btn-sm" style="background-color:#0C2340; color:white;" data-bs-toggle="modal" data-bs-target="#addDistrictModal">
            <i class="fas fa-plus me-1"></i> Add District
        </button>
    </div>
    <table class="table table-bordered text-center align-middle mt-3">
        <thead class="custom-thead">
            <tr>
                <th>#</th>
                <th>District Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($districts as $index => $district)
                <tr onclick="window.location='{{ route('admin.district.municipalities', $district->district_id) }}'" style="cursor: pointer;">
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $district->district_name }}</td>
                    <td>
                        <div class="d-flex justify-content-center gap-2">
                            <button class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#editDistrictModal{{ $district->district_id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#deleteDistrictModal{{ $district->district_id }}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No districts found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addDistrictModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('admin.district.store') }}" class="modal-content">
            @csrf
            <div class="modal-header" style="background-color:#0C2340; color:white;">
                <h5 class="modal-title">Add Legislative District</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="province_id" value="{{ $province->province_id }}">
                <div class="mb-3">
                    <label class="form-label">District Name</label>
                    <input type="text" name="district_name" class="form-control line-input" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn w-100" style="background-color:#0C2340; color:white;">Save District</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modals -->
@foreach($districts as $district)
<div class="modal fade" id="editDistrictModal{{ $district->district_id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('admin.district.update', $district->district_id) }}" class="modal-content">
            @csrf
            @method('PUT')
            <div class="modal-header" style="background-color:#0C2340; color:white;">
                <h5 class="modal-title">Edit Legislative District</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">District Name</label>
                    <input type="text" name="district_name" class="form-control line-input" value="{{ $district->district_name }}" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn w-100" style="background-color:#0C2340; color:white;">Update</button>
            </div>
        </form>
    </div>
</div>
@endforeach

<!-- Delete Modals -->
@foreach($districts as $district)
<div class="modal fade" id="deleteDistrictModal{{ $district->district_id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('admin.district.destroy', $district->district_id) }}" class="modal-content">
            @csrf
            @method('DELETE')
            <div class="modal-header" style="background-color:#0C2340; color:white;">
                <h5 class="modal-title">Delete District</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                Are you sure you want to delete <strong>{{ $district->district_name }}</strong>?
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn w-100" style="background-color:#0C2340; color:white;">Yes, Delete</button>
            </div>
        </form>
    </div>
</div>
@endforeach

@endsection
