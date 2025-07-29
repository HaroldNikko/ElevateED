@extends('admin.layoutadmin')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4 d-flex justify-content-between align-items-center">
        DepEd Hierarchy – Region List
        <button class="btn" style="background-color:#0C2340; color:white; border-radius: 50px;" data-bs-toggle="modal" data-bs-target="#addRegionModal">
            <i class="fas fa-plus me-1"></i> Add Region
        </button>
    </h4>

    <!-- Region Table -->
    <div id="regionTableContainer">
        <table class="table table-bordered text-center align-middle">
            <thead style="background-color:#0C2340; color:white;">
                <tr>
                    <th>#</th>
                    <th>Region Name</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($regions as $index => $region)
                    <tr onclick="window.location='{{ route('admin.region.provinces', $region->region_id) }}'" title="Click to view divisions" style="cursor:pointer;">
                        <td>{{ $regions->firstItem() + $index }}</td>
                        <td>{{ $region->region_name }}</td>
                        <td>{{ $region->region_description }}</td>
                        <td>
                            <button onclick="event.stopPropagation()" class="border-0 bg-transparent"
                                    style="color:#0C2340;"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editRegionModal{{ $region->region_id }}"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="event.stopPropagation()" class="border-0 bg-transparent"
                                    style="color:#0C2340;"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteRegionModal{{ $region->region_id }}"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editRegionModal{{ $region->region_id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered modal-md">
                            <form class="editRegionForm" data-id="{{ $region->region_id }}">
                                @csrf
                                @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header" style="background-color:#0C2340; color:white;">
                                        <h5 class="modal-title"><i class="fas fa-edit me-1"></i> Edit Region</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="text" name="region_name" value="{{ $region->region_name }}" class="form-control mb-3" required>
                                        <input type="text" name="region_description" value="{{ $region->region_description }}" class="form-control" required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn w-100" style="background-color:#0C2340; color:white;">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteRegionModal{{ $region->region_id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered modal-md">
                            <form class="deleteRegionForm" data-id="{{ $region->region_id }}">
                                @csrf
                                @method('DELETE')
                                <div class="modal-content">
                                    <div class="modal-header" style="background-color:#0C2340; color:white;">
                                        <h5 class="modal-title"><i class="fas fa-trash me-1"></i> Delete Region</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        Are you sure you want to delete <strong>{{ $region->region_name }}</strong>?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-danger w-100">Yes, Delete</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="4">No regions found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="text-muted">
                Showing {{ $regions->firstItem() }} to {{ $regions->lastItem() }} of {{ $regions->total() }} result{{ $regions->total() > 1 ? 's' : '' }}
            </div>
            <div>
                {{ $regions->onEachSide(1)->links('vendor.pagination.custom-blue') }}
            </div>
        </div>
    </div>
</div>

<!-- Add Region Modal -->
<div class="modal fade" id="addRegionModal" tabindex="-1" aria-labelledby="addRegionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <form id="addRegionForm">
                @csrf
                <div class="modal-header" style="background-color:#0C2340; color:white;">
                    <h5 class="modal-title" id="addRegionModalLabel"><i class="fas fa-plus me-1"></i> Add Region</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="region_name" class="form-control mb-3" placeholder="Region Name" required>
                    <input type="text" name="region_description" class="form-control" placeholder="Description" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn w-100" style="background-color:#0C2340; color:white;">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<style>
.tooltip-inner {
    background-color: transparent !important;
    color: #0C2340 !important;
    font-weight: 500;
    box-shadow: none;
}
.tooltip.bs-tooltip-top .arrow::before {
    border-top-color: transparent !important;
}
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    $('[data-bs-toggle="tooltip"]').tooltip();

    // ADD REGION
    $('#addRegionForm').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('admin.region.store') }}",
            method: 'POST',
            data: $(this).serialize(),
            success: function () {
                $('#addRegionModal').modal('hide');
                $('#addRegionForm')[0].reset();
                refreshRegionTable();
            },
            error: function () {
                alert('Failed to add region.');
            }
        });
    });

    // EDIT REGION
    $(document).on('submit', '.editRegionForm', function (e) {
        e.preventDefault();
        const form = $(this);
        const id = form.data('id');
        $.ajax({
            url: `/admin/region/${id}/update`,
            method: 'POST',
            data: form.serialize() + '&_method=PUT',
            success: function () {
                $('#editRegionModal' + id).modal('hide');
                refreshRegionTable();
            },
            error: function () {
                alert('Failed to update region.');
            }
        });
    });

    // DELETE REGION
    $(document).on('submit', '.deleteRegionForm', function (e) {
        e.preventDefault();
        const form = $(this);
        const id = form.data('id');
        $.ajax({
            url: `/admin/region/${id}/delete`,
            method: 'POST',
            data: form.serialize() + '&_method=DELETE',
            success: function () {
                $('#deleteRegionModal' + id).modal('hide');
                refreshRegionTable();
            },
            error: function () {
                alert('Failed to delete region.');
            }
        });
    });

    // Refresh region table
    function refreshRegionTable() {
        $.get("{{ route('admin.deped.hierarchy') }}", function (data) {
            const html = $(data).find('#regionTableContainer').html();
            $('#regionTableContainer').html(html);
            $('[data-bs-toggle="tooltip"]').tooltip();
        });
    }
});
</script>
@endpush
