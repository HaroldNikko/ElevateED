@extends('admin.layoutadmin')

@section('content')

<style>
    .custom-thead {
        background-color: #0C2340;
        color: white;
        text-align: center;
    }
    .table th, .table td {
        vertical-align: middle;
        text-align: center;
    }
    .btn-custom {
        background-color: #0C2340;
        color: white;
        border-radius: 8px;
    }
    .btn-custom:hover {
        background-color: #092035;
        color: white;
    }
    .modal-header {
        background-color: #0C2340;
        color: white;
    }
    .modal-content {
        border-radius: 12px;
        overflow: hidden;
    }
    .btn-close-white {
        filter: invert(1);
    }
    .clickable-row {
        cursor: pointer;
    }
    .clickable-row:hover {
        background-color: #f1f1f1;
    }
    .icon-btn {
        background: none;
        border: none;
        color: #0C2340;
    }
    .icon-btn:hover {
        color: #092035;
    }
</style>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            <a href="{{ route('admin.deped.hierarchy') }}" 
               class="btn btn-sm rounded-circle d-flex align-items-center justify-content-center me-3"
               style="background-color:#0C2340; color:white; width: 36px; height: 36px;">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h4 class="mb-0">Provinces under: <strong>{{ $region->region_name }}</strong></h4>
        </div>
        <button class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#addProvinceModal">
            <i class="fas fa-plus me-1"></i> Add Province
        </button>
    </div>

    <table class="table table-bordered">
        <thead class="custom-thead">
            <tr>
                <th>#</th>
                <th>Province Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($provinces as $index => $province)
                <tr class="clickable-row" data-href="{{ route('admin.province.districts', $province->province_id) }}" title="Click row to view District">
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $province->province_name }}</td>
                    <td>
                        <button class="icon-btn me-2" title="Edit" data-bs-toggle="modal" data-bs-target="#editProvinceModal{{ $province->province_id }}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="icon-btn" title="Delete" data-bs-toggle="modal" data-bs-target="#deleteProvinceModal{{ $province->province_id }}">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3">No provinces found in this region.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Add Province Modal -->
<div class="modal fade" id="addProvinceModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('admin.province.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Add Province</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="region_id" value="{{ $region->region_id }}">
                <div class="mb-3">
                    <label for="province_name" class="form-label">Province Name</label>
                    <input type="text" class="form-control" name="province_name" placeholder="Enter province name..." required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-custom w-100">Save Province</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Province Modals -->
@foreach($provinces as $province)
    <div class="modal fade" id="editProvinceModal{{ $province->province_id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('admin.province.update', $province->province_id) }}" method="POST" class="modal-content">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Province</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="region_id" value="{{ $region->region_id }}">
                    <div class="mb-3">
                        <label for="province_name" class="form-label">Province Name</label>
                        <input type="text" class="form-control" name="province_name" value="{{ $province->province_name }}" placeholder="Enter province name..." required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-custom w-100">Update Province</button>
                </div>
            </form>
        </div>
    </div>
@endforeach

<!-- Delete Province Modals -->
@foreach($provinces as $province)
    <div class="modal fade" id="deleteProvinceModal{{ $province->province_id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('admin.province.destroy', $province->province_id) }}" method="POST" class="modal-content">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title">Delete Province</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete <strong>{{ $province->province_name }}</strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger w-100">Yes, Delete</button>
                </div>
            </form>
        </div>
    </div>
@endforeach

<script>
    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll(".clickable-row").forEach(row => {
            row.addEventListener("click", (e) => {
                if (!e.target.closest('button') && !e.target.closest('form')) {
                    window.location.href = row.getAttribute("data-href");
                }
            });
        });
    });
</script>

@endsection
