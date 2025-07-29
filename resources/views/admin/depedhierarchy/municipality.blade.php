@extends('admin.layoutadmin')

@push('styles')
<style>
    .line-input {
        border: none;
        border-bottom: 1px solid #ccc;
        background: transparent;
        border-radius: 0;
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
    .clickable-row:hover {
        background-color: #f9f9f9;
        cursor: pointer;
    }
    .icon-btn {
         background: none !important; /* removes background */
        border: none;
        color: #0C2340;
        padding: 0;
        font-size: 1rem;
    }
    .icon-btn:hover {
        color: #092035;
    }
</style>
@endpush

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-1">
            <a href="{{ route('admin.province.districts', $district->province_id) }}"
                class="btn btn-sm rounded-circle d-flex align-items-center justify-content-center"
                style="background-color:#0C2340; color:white; width: 36px; height: 36px;">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h4 class="mb-0">Municipalities in: <strong>{{ $district->district_name }}</strong></h4>
        </div>
        <button class="btn btn-sm" style="background-color:#0C2340; color:white;" data-bs-toggle="modal" data-bs-target="#addMunicipalityModal">
            <i class="fas fa-plus me-1"></i> Add Municipality
        </button>
    </div>

    <table class="table table-bordered text-center align-middle">
        <thead class="custom-thead">
            <tr>
                <th>#</th>
                <th>Municipality Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($municipalities as $index => $municipality)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $municipality->municipality_name }}</td>
                    <td>
                        <div class="d-flex justify-content-center gap-2">
                            <button 
                            style="background:none; border:none; color:#0C2340; padding:0; font-size:1.1rem;" 
                            data-bs-toggle="modal" 
                            data-bs-target="#editMunicipalityModal{{ $municipality->municipality_id }}">
                            <i class="fas fa-edit"></i>
                         </button>

                            <button 
                            style="background:none; border:none; color:#0C2340; padding:0; font-size:1.1rem;" 
                            data-bs-toggle="modal" 
                            data-bs-target="#deleteMunicipalityModal{{ $municipality->municipality_id }}">
                            <i class="fas fa-trash-alt"></i>
                        </button>

                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3">No municipalities found under this district.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addMunicipalityModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('admin.municipality.store') }}" class="modal-content">
            @csrf
            <div class="modal-header" style="background-color:#0C2340; color:white;">
                <h5 class="modal-title">Add Municipality</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="district_id" value="{{ $district->district_id }}">
                <input type="hidden" name="province_id" value="{{ $district->province_id }}">
                <div class="mb-3">
                    <label class="form-label">Municipality Name</label>
                    <input type="text" name="municipality_name" class="form-control line-input" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn w-100" style="background-color:#0C2340; color:white;">Save Municipality</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modals -->
@foreach($municipalities as $municipality)
<div class="modal fade" id="editMunicipalityModal{{ $municipality->municipality_id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('admin.municipality.update', $municipality->municipality_id) }}" class="modal-content">
            @csrf
            @method('PUT')
            <div class="modal-header" style="background-color:#0C2340; color:white;">
                <h5 class="modal-title">Edit Municipality</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="province_id" value="{{ $district->province_id }}">
                <input type="hidden" name="district_id" value="{{ $district->district_id }}">
                <div class="mb-3">
                    <label class="form-label">Municipality Name</label>
                    <input type="text" name="municipality_name" class="form-control line-input" value="{{ $municipality->municipality_name }}" required>
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
@foreach($municipalities as $municipality)
<div class="modal fade" id="deleteMunicipalityModal{{ $municipality->municipality_id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('admin.municipality.destroy', $municipality->municipality_id) }}" class="modal-content">
            @csrf
            @method('DELETE')
            <div class="modal-header" style="background-color:#0C2340; color:white;">
                <h5 class="modal-title">Delete Municipality</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                Are you sure you want to delete <strong>{{ $municipality->municipality_name }}</strong>?
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn w-100" style="background-color:#0C2340; color:white;">Yes, Delete</button>
            </div>
        </form>
    </div>
</div>
@endforeach
@endsection
