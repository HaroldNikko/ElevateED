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
    .action-icon {
        color: #0C2340;
        cursor: pointer;
    }
    .action-icon:hover {
        opacity: 0.7;
    }
</style>

<div class="container py-4">
    <div class="card shadow-sm rounded-4 border-0 p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold mb-0">Designation Management</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDesignationModal">
                <i class="fas fa-plus me-1"></i> Add Designation
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="custom-thead">
                    <tr>
                        <th>#</th>
                        <th>Designation</th>
                        <th>Access</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($designations as $index => $designation)
                        <tr>
                            <td>{{ $designations->firstItem() + $index }}</td>
                            <td>{{ $designation->designation_name }}</td>
                            <td>{{ $designation->access }}</td>
                            <td>
                                <i class="fas fa-edit me-2 action-icon" title="Edit"></i>
                                <i class="fas fa-trash-alt action-icon" title="Delete"></i>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-muted text-center">No designations found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Info + Controls -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="text-muted small">
                Showing {{ $designations->firstItem() }} to {{ $designations->lastItem() }} of {{ $designations->total() }} results
            </div>
            <div>
                {{ $designations->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Add Designation Modal -->
<div class="modal fade" id="addDesignationModal" tabindex="-1" aria-labelledby="addDesignationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.designation.store') }}" method="POST">
            @csrf
            <div class="modal-content rounded-4">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addDesignationModalLabel">Add Designation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="designation_name" class="form-label">Designation Name</label>
                        <input type="text" class="form-control" id="designation_name" name="designation_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="access" class="form-label">Access Level</label>
                        <select class="form-select" id="access" name="access" required>
                            <option selected disabled>Select access level</option>
                            <option value="Division">Division</option>
                            <option value="District">District</option>
                            <option value="School">School</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Designation</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
