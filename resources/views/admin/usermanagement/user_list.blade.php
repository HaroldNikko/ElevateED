@extends('admin.layoutadmin')

@section('content')
@push('styles')
<style>
    .action-icon {
        color: #0C2340;
        text-decoration: none !important;
        background: none !important;
        display: inline-block;
        line-height: 1;
    }

    .action-icon:hover {
        opacity: 0.7;
    }
</style>


<div class="container py-4">
    {{-- Header + Add User Button --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">User List</h4>
        <button class="btn btn-primary rounded-4" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="fas fa-user-plus me-1"></i> Add User
        </button>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- User Table --}}
    <div class="card p-4 rounded-4 shadow-sm">
        <table class="table table-bordered table-hover align-middle">
            <thead style="background-color: #0C2340; color: white;">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
               @foreach ($teachers as $user)
                <tr data-userid="{{ $user->id }}">
                    <td>{{ $user->firstname }} {{ $user->middlename }} {{ $user->lastname }}</td>
                    <td>{{ $user->email }}</td>
                    <td class="text-center">
                        <a href="#" class="action-icon me-2" title="Edit"><i class="fas fa-edit"></i></a>
                        <a href="#" class="action-icon me-2" title="Designation"><i class="fas fa-user-tag"></i></a>
                        <a href="#" class="action-icon me-2" title="Change Password"><i class="fas fa-key"></i></a>
                        <a href="#" class="action-icon" title="Delete"><i class="fas fa-trash-alt"></i></a>
                    </td>
                </tr>
                @endforeach</tbody>
        </table>
    </div>
</div>

{{-- Add User Modal --}}
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header bg-primary text-white rounded-top-4">
                <h5 class="modal-title" id="addUserModalLabel">
                    <i class="fas fa-user-plus me-2"></i> Add New User
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="firstname" class="form-label">Firstname</label>
                            <input type="text" class="form-control" name="firstname" id="firstname" required>
                        </div>
                        <div class="col-md-6">
                            <label for="middlename" class="form-label">Middlename</label>
                            <input type="text" class="form-control" name="middlename" id="middlename">
                        </div>
                        <div class="col-md-6">
                            <label for="lastname" class="form-label">Lastname</label>
                            <input type="text" class="form-control" name="lastname" id="lastname" required>
                        </div>
                        <div class="col-md-6">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-select" name="gender" id="gender" required>
                                <option value="" disabled selected>Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="phonenumber" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" name="phonenumber" id="phonenumber" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-3">
                    <button type="button" class="btn btn-secondary rounded-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-4">Save User</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Designation Modal -->
<div class="modal fade" id="designationModal" tabindex="-1" aria-labelledby="designationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="designationModalLabel"><i class="fas fa-user-tag me-2"></i> Assign Designation</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.users.assignDesignation') }}">
                @csrf
                <input type="hidden" name="user_id" id="designationUserId"> <!-- dynamically filled -->
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Designation</label>
                            <select class="form-select" name="designationID" id="designationSelect" required>
                                <option value="" disabled selected>Select Designation</option>
                                @foreach($designations as $designation)
                                    <option value="{{ $designation->designationID }}">{{ $designation->designation_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Region</label>
                            <select class="form-select" name="region_id" required>
                                @foreach($regions as $region)
                                    <option value="{{ $region->region_id }}">{{ $region->region_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Province</label>
                            <select class="form-select" name="province_id" required></select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">District</label>
                            <select class="form-select" name="district_id" required></select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Municipality</label>
                            <select class="form-select" name="municipality_id" required></select>
                        </div>
                        <div class="col-md-6 school-container">
                            <label class="form-label">School</label>
                            <select class="form-select" name="schoolID" id="schoolDropdown"></select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-3">
                    <button type="button" class="btn btn-secondary rounded-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-4">Assign</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteConfirmationModalLabel"><i class="fas fa-trash-alt me-2"></i> Confirm Deletion</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <p>Are you sure you want to delete this user?</p>
            </div>
            <div class="modal-footer border-0 p-3">
                <button type="button" class="btn btn-secondary rounded-4" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteUserForm" method="POST" action="" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger rounded-4">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="deleteSuccessModal" tabindex="-1" aria-labelledby="deleteSuccessModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="deleteSuccessModalLabel"><i class="fas fa-check me-2"></i> Success</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <p>User deleted successfully!</p>
            </div>
            <div class="modal-footer border-0 p-3">
                <button type="button" class="btn btn-success rounded-4" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
<!-- Change Password Modal -->
<!-- Change Password Modal -->
<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="changePasswordModalLabel"><i class="fas fa-key me-2"></i> Change Password</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.users.updatePassword') }}">
                @csrf
                <input type="hidden" name="user_id" id="changePasswordUserId"> <!-- dynamically filled -->
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="changePasswordEmail" readonly>
                        </div>
                        <!-- Current password will not be shown for security -->
                        <div class="col-md-6">
                            <label for="newPassword" class="form-label">New Password</label>
                            <input type="password" class="form-control" name="newPassword" id="newPassword" required>
                        </div>
                        <div class="col-md-6">
                            <label for="confirmPassword" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-3">
                    <button type="button" class="btn btn-secondary rounded-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-4">Save Password</button>
                </div>
            </form>
        </div>
    </div>
</div>





@endsection
@endpush
@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Handle Delete Button Click
    document.querySelectorAll('.action-icon[title="Delete"]').forEach(el => {
        el.addEventListener('click', function () {
            const userId = this.closest('tr').getAttribute('data-userid');
            const deleteForm = document.getElementById('deleteUserForm');
            deleteForm.setAttribute('action', `/admin/users/delete/${userId}`); // Set the correct delete route URL
            const modal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
            modal.show();
        });
    });

    // Handle Deletion Confirmation
    document.getElementById('confirmDeleteButton')?.addEventListener('click', function () {
        const deleteForm = document.getElementById('deleteUserForm');
        deleteForm.submit(); // Submit the form for deletion
    });

    // Handle Change Password Button Click
    document.querySelectorAll('.action-icon[title="Change Password"]').forEach(el => {
        el.addEventListener('click', function () {
            const userId = this.closest('tr').getAttribute('data-userid');
            const userEmail = this.closest('tr').querySelector('td:nth-child(2)').textContent.trim(); // Get user email
            
            // Fill the modal with the user's email
            document.getElementById('changePasswordUserId').value = userId;
            document.getElementById('changePasswordEmail').value = userEmail;

            // Optionally, you could fetch the current password using AJAX, but this is generally not recommended for security reasons.
            // Assuming we don't display the current password for security, only allow users to update the password.

            const modal = new bootstrap.Modal(document.getElementById('changePasswordModal'));
            modal.show();
        });
    });

    // Handle Designation Button Click
    document.querySelectorAll('.action-icon[title="Designation"]').forEach(el => {
        el.addEventListener('click', function () {
            const userId = this.closest('tr').getAttribute('data-userid');
            document.getElementById('designationUserId').value = userId;
            const modal = new bootstrap.Modal(document.getElementById('designationModal'));
            modal.show();
        });
    });

    // Toggle School Visibility on Designation Change
    const designationSelect = document.getElementById('designationSelect');
    if (designationSelect) {
        designationSelect.addEventListener('change', function () {
            const selected = this.options[this.selectedIndex].text;
            const schoolContainer = document.querySelector('.school-container');
            schoolContainer.style.display = (selected === 'District Supervisor') ? 'none' : 'block';
        });
    }

    // Region > Province Fetch
    const regionSelect = document.querySelector('[name="region_id"]');
    const provinceSelect = document.querySelector('[name="province_id"]');
    const districtSelect = document.querySelector('[name="district_id"]');
    const municipalitySelect = document.querySelector('[name="municipality_id"]');

    if (regionSelect) {
        regionSelect.addEventListener('change', function () {
            const regionId = this.value;
            fetch(`/admin/fetch-provinces/${regionId}`)
                .then(res => res.json())
                .then(data => {
                    provinceSelect.innerHTML = `<option value="">Select Province</option>`;
                    data.forEach(p => {
                        provinceSelect.innerHTML += `<option value="${p.province_id}">${p.province_name}</option>`;
                    });
                    districtSelect.innerHTML = `<option value="">Select District</option>`;
                    municipalitySelect.innerHTML = `<option value="">Select Municipality</option>`;
                });
        });
    }

    // Province > District and Municipality Fetch
    if (provinceSelect) {
        provinceSelect.addEventListener('change', function () {
            const provinceId = this.value;

            fetch(`/admin/fetch-districts/${provinceId}`)
                .then(res => res.json())
                .then(data => {
                    districtSelect.innerHTML = `<option value="">Select District</option>`;
                    data.forEach(d => {
                        districtSelect.innerHTML += `<option value="${d.district_id}">${d.district_name}</option>`;
                    });
                });

            fetch(`/admin/fetch-municipalities/${provinceId}`)
                .then(res => res.json())
                .then(data => {
                    municipalitySelect.innerHTML = `<option value="">Select Municipality</option>`;
                    data.forEach(m => {
                        municipalitySelect.innerHTML += `<option value="${m.municipality_id}">${m.municipality_name}</option>`;
                    });
                });
        });
    }
});
</script>
@endpush
