


<!-- ✅ Add Success Modal ccriteria -->
<div class="modal fade" id="addSuccessModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body text-center">
        <i class="fas fa-check-circle text-success" style="font-size: 2.5rem;"></i>
        <p class="mt-2 mb-0">Criteria added successfully!</p>
      </div>
    </div>
  </div>
</div>
<!-- ✅ Add Confirmation Modal (for Add Criteria) -->
<div class="modal fade" id="confirmAddModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body text-center">
        <p class="mb-3 fw-semibold">Are you sure you want to add this criteria?</p>
        <div class="d-flex justify-content-center gap-2">
          <button class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">No</button>
          <button class="btn btn-primary btn-sm" id="confirmAddBtn">Yes</button>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- ✅ Update Success Modal -->
<div class="modal fade" id="updateSuccessModall" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body text-center">
        <i class="fas fa-check-circle text-primary" style="font-size: 2.5rem;"></i>
        <p class="mt-2 mb-0">Criteria updated successfully!</p>
      </div>
    </div>
  </div>
</div>

<!-- ✅ Delete Success Modal -->
<div class="modal fade" id="deleteSuccessModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body text-center">
        <i class="fas fa-check-circle text-danger" style="font-size: 2.5rem;"></i>
        <p class="mt-2 mb-0">Criteria deleted successfully!</p>
      </div>
    </div>
  </div>
</div>

<!-- ✅ Delete Confirmation Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body text-center">
        <p class="mb-3 fw-semibold">Are you sure you want to delete this criteria?</p>
        <div class="d-flex justify-content-center gap-2">
          <button class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">No</button>
          <button class="btn btn-danger btn-sm" id="confirmDeleteBtn">Yes</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ✅ Update Confirmation Modal -->
<div class="modal fade" id="confirmUpdateModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body text-center">
        <p class="mb-3 fw-semibold">Save changes to this criteria?</p>
        <div class="d-flex justify-content-center gap-2">
          <button class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">No</button>
          <button class="btn btn-primary btn-sm" id="confirmUpdateBtn">Yes</button>
        </div>
      </div>
    </div>
  </div>
</div>



<!-- Modal for Adding Criteria -->
<div class="modal fade" id="addCriteriaModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4 rounded-4">
      <div class="modal-header border-0">
        <h5 class="modal-title d-flex align-items-center">
          <i class="fas fa-plus-circle me-2 text-primary"></i> Add Criteria
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body pt-0">
        <form id="addCriteriaForm">
          <input type="text" name="criteriaDetail" class="form-control rounded-3 mb-3" placeholder="Criteria Name" required>
          <input type="number" name="maxpoint" class="form-control rounded-3 mb-3" placeholder="Max Point" required>
          <input type="date" name="date" class="form-control rounded-3 mb-3" required>
        </form>
        <div class="text-end">
          <button type="button" id="submitCriteriaBtn" class="btn btn-primary px-4 rounded-pill">Add</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Edit Criteria Modal -->
<div class="modal fade" id="editCriteriaModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4 rounded-4">
      <div class="modal-header border-0">
        <h5 class="modal-title">Edit Criteria</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body pt-0">
        <form id="editCriteriaForm">
          <input type="hidden" name="id" id="editCriteriaId">
          <input type="text" name="criteriaDetail" id="editCriteriaDetail" class="form-control mb-3" placeholder="Criteria Name" required>
          <input type="number" name="maxpoint" id="editCriteriaPoint" class="form-control mb-3" placeholder="Max Point" required>
          <input type="date" name="date" id="editCriteriaDate" class="form-control mb-3" required>
        </form>
        <div class="text-end">
          <button type="button" id="updateCriteriaBtn" class="btn btn-primary rounded-pill px-4">Update</button>
        </div>
      </div>
    </div>
  </div>
</div>




<!-- ✅ Success Modal  systemsetup -->
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-body text-center">
        <i class="fas fa-check-circle" style="font-size: 2.5rem; color: #28a745;"></i>
        <p class="mt-2 mb-0">Added Successfully!</p>
      </div>
    </div>
  </div>
</div>

<!-- ✅ Confirm Add School -->
<div class="modal fade" id="confirmAddSchoolModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body text-center">
        <p class="mb-3 fw-semibold">Are you sure you want to add this school?</p>
        <div class="d-flex justify-content-center gap-2">
          <button class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">No</button>
          <button class="btn btn-primary btn-sm" id="confirmAddSchoolBtn">Yes</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ✅ Confirm Add Teacher Rank -->
<div class="modal fade" id="confirmAddRankModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body text-center">
        <p class="mb-3 fw-semibold">Are you sure you want to add this teacher rank?</p>
        <div class="d-flex justify-content-center gap-2">
          <button class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">No</button>
          <button class="btn btn-primary btn-sm" id="confirmAddRankBtn">Yes</button>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="deleteSlotModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-body text-center">
        <p class="mb-3 fw-semibold">Are you sure you want to delete this?</p>
        <div class="d-flex justify-content-center gap-2">
          <button class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">No</button>
          <button class="btn btn-danger btn-sm" id="confirmDeleteSlotBtn">Yes</button>
        </div>
      </div>
    </div>
  </div>
</div> <div class="modal fade" id="slotDeleteSuccessModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body text-center">
        <i class="fas fa-check-circle text-danger" style="font-size: 2.5rem;"></i>
        <p class="mt-2 mb-0">deleted successfully!</p>
      </div>
    </div>
  </div>
</div>
<!-- Confirm Edit Modal -->
<div class="modal fade" id="confirmEditModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body text-center">
        <p class="mb-3 fw-semibold">Are you sure you want to save changes?</p>
        <div class="d-flex justify-content-center gap-2">
          <button class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">No</button>
          <button class="btn btn-primary btn-sm" id="confirmEditBtn">Yes</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Update Success Modal -->
<div class="modal fade" id="updateSuccessModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body text-center">
        <i class="fas fa-check-circle text-success" style="font-size: 2.5rem;"></i>
        <p class="mt-2 mb-0">Updated Successfully!</p>
      </div>
    </div>
  </div>
</div>




<!-- Add Teacher Rank Modal -->
<div class="modal fade" id="addRankModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4 rounded-4" style="border: 1px solid #ccc;">
      <div class="modal-header border-0">
        <h5 class="modal-title d-flex align-items-center">
          <i class="fas fa-plus-circle me-2 text-primary"></i> Add Teacher Rank
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body pt-0">
        <p class="text-muted">Enter the teacher rank and salary grade</p>

        <!-- ✅ Single clean form with both inputs -->
        <form id="addRankForm">
          <input type="text" name="teacherRank" class="form-control rounded-3 mb-3" placeholder="Rank name" required>

          <input type="text" name="Salary_grade" class="form-control rounded-3 mb-3" placeholder="Salary Grade (e.g., 18)" required>
        </form>

        <div class="text-end">
          <button type="button" id="submitRankBtn" class="btn btn-primary px-4 rounded-pill">Add</button>
        </div>
      </div>
    </div>
  </div>
</div>





<!-- Edit Rank Modal -->
<div class="modal fade" id="editRankModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4 rounded-4">
      <div class="modal-header border-0">
        <h5 class="modal-title">
          <i class="fas fa-pen me-2 text-primary"></i>Edit Teacher Rank
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body pt-0">
        <form id="editRankForm">
          <input type="hidden" name="teacherrank_id" id="editRankID">

          <!-- Teacher Rank -->
          <input type="text" name="teacherRank" id="editRankName" class="form-control mb-3" placeholder="Rank Name" required>

          <!-- Salary Grade -->
          <input type="text" name="Salary_grade" id="editSalaryGrade" class="form-control mb-3" placeholder="Salary Grade" required>
        </form>

        <div class="text-end">
          <button type="button" id="updateRankBtn" class="btn btn-primary rounded-pill px-4">Update</button>
        </div>
      </div>
    </div>
  </div>
</div>


 <div class="modal fade" id="logoutConfirmModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content text-center p-3">
      <div class="modal-body">
        <!-- 🔵 Dark blue icon -->
        <i class="fas fa-sign-out-alt fa-2x mb-3" style="color: #0C2340;"></i>
        <p class="fw-bold mb-2">Are you sure you want to logout?</p>
        <div class="d-flex justify-content-center gap-2">
          <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
          
          <!-- 🔵 Dark blue logout button -->
          <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-sm text-white" style="background-color: #0C2340;">
              Logout
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Loading Overlay -->
<div id="loadingOverlay" style="position: fixed; top: 0; left: 0; z-index: 9999; width: 100vw; height: 100vh; background: rgba(255, 255, 255, 0.8); display: flex; align-items: center; justify-content: center; visibility: hidden; flex-direction: column;">
  <div style="width: 60%; max-width: 500px;" class="text-center">
    <div class="progress bg-light" style="height: 25px; position: relative;">
      <div id="loadingProgressBar" class="progress-bar progress-bar-striped progress-bar-animated"
           style="width: 0%; background-color: #0C2340;">
        <span id="loadingPercentText" style="position: absolute; left: 50%; transform: translateX(-50%); color: white;">0%</span>
      </div>
    </div>
    <p class="mt-3 text-muted">Importing data... please wait.</p>
  </div>
</div>

<!-- Confirm Import Modal -->
<div class="modal fade" id="confirmImportModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body text-center">
        <p class="fw-semibold mb-3">Are you sure you want to import this CSV file?</p>
        <div class="d-flex justify-content-center gap-2">
          <button class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">No</button>
          <button class="btn btn-primary btn-sm" id="confirmImportBtn">Yes</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="ImportsuccessModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content text-center p-3">
      <i class="fas fa-check-circle text-success mb-3" style="font-size: 2.5rem;"></i>
      <p class="mb-0">Teachers imported successfully!</p>
    </div>
  </div>
</div>
