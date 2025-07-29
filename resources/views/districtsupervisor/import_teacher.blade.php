{{-- @extends('districtsupervisor.layout')

@section('content')

<style>
  input[type="file"]::file-selector-button {
    display: none;
  }
</style>

<div class="container py-4 d-flex flex-column justify-content-between" style="min-height: 90vh;">
  <div class="bg-white rounded-4 p-4 shadow-sm flex-grow-1">

    <!-- Info Message -->
    <div class="alert d-flex align-items-center mb-4" role="alert"
         style="background-color: #d9f6fc; border-radius: 12px; color: #0C2340; font-size: 15px;">
      <i class="fas fa-info-circle me-2"></i>
      <div>
        <strong>Almost there!</strong> Ensure your CSV file has these columns:
        <strong>TEACHERID, NAME, EMAIL, and PHONENO</strong>.
        Use <span style="color: crimson;">,</span> or <span style="color: crimson;">;</span> to separate values.
      </div>
    </div>

    <!-- Upload Form -->
    <form action="" method="POST" enctype="multipart/form-data" id="csvUploadForm">
      @csrf

      <!-- Upload Box -->
      <label for="csv_file"
        class="d-flex align-items-center gap-3 px-4 py-4"
        style="border: 2px dashed #0C2340; border-radius: 20px; cursor: pointer; color: #0C2340;">
        <i class="fas fa-file-alt" style="font-size: 72px;"></i>
        <div>
          <span class="fw-semibold" style="border-bottom: 2px solid #0C2340; padding-bottom: 4px; font-size: 17px; line-height: 1.4;">
            Upload your .csv file
          </span>
        </div>
        <input type="file" id="csv_file" name="csv_file" accept=".csv" class="d-none" required>
      </label>

      <!-- Download Template Link -->
      <div class="d-flex justify-content-end mt-2">
        <a href="#" class="text-decoration-none fw-semibold" style="color: #0C2340;">
          <i class="fas fa-download me-1"></i> Download CSV Template
        </a>
      </div>
    </form>
  </div>

  <!-- Footer Buttons -->
  <div class="d-flex justify-content-between mt-4">
    <a href="{{ url()->previous() }}" class="btn btn-outline-primary">Cancel</a>
    <button type="submit" form="csvUploadForm" class="btn text-white px-4 fw-semibold"
            style="background-color: #0C2340; border-radius: 12px;">
      IMPORT
    </button>
  </div>
</div>

@endsection --}}
