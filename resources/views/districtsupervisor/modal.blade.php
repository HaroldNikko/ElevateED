<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-4 p-3">
      <div class="modal-header border-0">
        <h5 class="modal-title fw-bold" id="uploadModalLabel">Upload Vacancy</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form id="uploadForm">
          <!-- Position Dropdown -->
          <div class="mb-3">
            <label class="form-label fw-bold">Position:</label>
            <select class="form-select" name="position" required>
              <option selected disabled hidden>Select Position</option>
              @foreach ($ranks as $rank)
                <option value="{{ $rank->teacher_rankID }}">{{ $rank->teacherRank }}</option>
              @endforeach
            </select>
          </div>

          <!-- School Name Dropdown -->
          <div class="mb-3">
            <label class="form-label fw-bold">School Name:</label>
            <select class="form-select" id="schoolSelect" name="schoolname" required>
              <option selected disabled hidden>Select School</option>
              @foreach ($schools as $school)
                <option value="{{ $school->Schoolname }}" data-district-name="{{ $school->district->Districtname }}">
                  {{ $school->Schoolname }}
                </option>
              @endforeach
            </select>
          </div>

          <!-- Start Date (readonly) -->
          <div class="mb-3">
            <label class="form-label fw-bold">Start Date:</label>
            <input type="text" class="form-control" name="start_date" id="startDateField" readonly>
          </div>

          <!-- Deadline -->
          <div class="mb-3">
            <label class="form-label fw-bold">Deadline:</label>
            <input type="date" class="form-control" name="deadline" required>
          </div>

          <div class="text-end">
            <button type="submit" class="btn text-white" style="background-color: #0C2340;">
              UPLOAD
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
