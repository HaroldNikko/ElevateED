@extends('admin.layoutadmin')

@section('content')
<div class="container py-4">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('admin.school.show', $school->schoolID) }}" class="btn btn-light rounded-circle shadow-sm" title="Back to list">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h4 class="fw-bold mb-0">{{ $school->Schoolname }}</h4>
        </div>
        <button type="button" class="btn px-4 py-1 rounded-4 text-white fw-semibold" style="background-color: #0C2340; font-size: 15px;" id="triggerImportBtn">
            <i class="fas fa-file-import me-1"></i> IMPORT
        </button>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 p-5 mb-4" style="min-height: 70vh;">
        <!-- Search + Filename aligned row -->
        <div id="selectedFileNameWrapper" class="d-flex justify-content-between align-items-center flex-wrap mb-3" style="font-size: 14px; color: #0C2340; display: none;">
            <div>
                <strong>Selected File:</strong> <span id="selectedFileName" class="fst-italic">None</span>
            </div>
            <div id="datatableSearchContainer" class="mt-2 mt-sm-0"></div>
        </div>

        <form id="ajaxImportForm" method="POST" enctype="multipart/form-data" class="d-flex flex-column h-100 mt-4">
            @csrf
            <input type="file" name="csv_file" id="csvFileInput" accept=".csv" required style="visibility: hidden; height: 0; width: 0; position: absolute;">

            <!-- Upload -->
            <div id="uploadSection">
                <div class="alert d-flex align-items-center mb-4" role="alert"
                     style="background-color: #d9f6fc; border-radius: 12px; color: #0C2340; font-size: 15px;">
                    <i class="fas fa-info-circle me-2"></i>
                    <div>
                        <strong>Almost there!</strong> Ensure your CSV file has these columns:
                        <strong>APPLICANTID, FIRSTNAME, MIDDLENAME, LASTNAME, EMAIL, PHONENUMBER</strong>.
                    </div>
                </div>

                <label for="csvFileInput" class="d-flex align-items-center gap-3 px-4 py-4"
                       style="border: 2px dashed #0C2340; border-radius: 20px; cursor: pointer; color: #0C2340;">
                    <i class="fas fa-file-alt" style="font-size: 72px;"></i>
                    <div><h6 style="border-bottom: 2px solid #0C2340;">Upload your .csv file</h6></div>
                </label>

                <div class="d-flex justify-content-between align-items-center flex-wrap mt-4">
                    <a href="{{ asset('sample-template.csv') }}" download="teacher_template.csv" class="text-decoration-none" style="color: #0C2340;">
                        <i class="fas fa-download me-2"></i>Download CSV Template
                    </a>
                </div>
            </div>

            <!-- Preview -->
            <div id="csvPreviewSection" style="display: none;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold text-dark mb-0">Preview Data</h6>
                    <div class="d-flex gap-3">
                        <span id="insertCount" class="badge text-bg-success px-3 py-2">Will Insert: 0</span>
                        <span id="updateCount" class="badge text-bg-warning px-3 py-2">Will Update: 0</span>
                    </div>
                </div>

                <div class="table-responsive" style="max-height: 300px;">
                    <table id="csvTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ApplicantID</th>
                                <th>Firstname</th>
                                <th>Middlename</th>
                                <th>Lastname</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="csvPreviewBody"></tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="button" class="btn text-white fw-semibold px-4 py-2" id="changeFileBtn"
                            style="background-color: #0C2340; font-size: 15px;">
                        Change CSV File
                    </button>
                </div>
            </div>

            <button type="submit" id="hiddenSubmitBtn" style="display: none;"></button>
        </form>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="confirmImportModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirm Import</h5>
            </div>
            <div class="modal-body">Are you sure you want to import this CSV file?</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded-4" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary rounded-4" id="confirmImportBtn">Yes, Import</button>
            </div>
        </div>
    </div>
</div>

<!-- Toast -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
    <div id="csvToast" class="toast align-items-center text-white bg-danger border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body" id="csvToastMsg"></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div id="loadingOverlay" style="visibility: hidden; display: none; position: fixed; top: 0; left: 0; z-index: 9999; width: 100vw; height: 100vh; background-color: rgba(0,0,0,0.5); align-items: center; justify-content: center;">
    <div class="text-center">
        <div class="progress mb-3" style="height: 20px; width: 300px;">
            <div id="loadingProgressBar" class="progress-bar progress-bar-striped progress-bar-animated" style="width: 0%">0%</div>
        </div>
        <span class="text-white" id="loadingPercentText">0%</span>
    </div>
</div>


@endsection

@push('scripts')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const fileInput = document.getElementById('csvFileInput');
    const triggerBtn = document.getElementById('triggerImportBtn');
    const confirmBtn = document.getElementById('confirmImportBtn');

    const previewSection = document.getElementById('csvPreviewSection');
    const previewBody = document.getElementById('csvPreviewBody');
    const insertCountLabel = document.getElementById('insertCount');
    const updateCountLabel = document.getElementById('updateCount');

    const bar = document.getElementById('loadingProgressBar');
    const percentText = document.getElementById('loadingPercentText');
    const overlay = document.getElementById('loadingOverlay');

    const uploadSection = document.getElementById('uploadSection');
    const changeFileBtn = document.getElementById('changeFileBtn');

    const selectedFileNameWrapper = document.getElementById('selectedFileNameWrapper');
    const selectedFileName = document.getElementById('selectedFileName');

    function showToast(message) {
        document.getElementById('csvToastMsg').textContent = message;
        new bootstrap.Toast(document.getElementById('csvToast')).show();
    }

    function showSuccessModal() {
        const modal = new bootstrap.Modal(document.getElementById('successImportModal'));
        modal.show();
    }

    let loadingInterval = null;

    function startLoadingBar() {
        overlay.style.visibility = 'visible';
        overlay.style.display = 'flex';
        let progress = 0;
        bar.style.width = '0%';
        percentText.innerText = '0%';

        loadingInterval = setInterval(() => {
            if (progress < 90) {
                progress += Math.floor(Math.random() * 3) + 1;
                if (progress > 90) progress = 90;
                bar.style.width = progress + '%';
                percentText.innerText = progress + '%';
            }
        }, 100);
    }

    function finishLoadingBar() {
        clearInterval(loadingInterval);
        bar.style.width = '100%';
        percentText.innerText = '100%';
        setTimeout(() => {
            overlay.style.visibility = 'hidden';
            overlay.style.display = 'none';
        }, 700);
    }

    fileInput.addEventListener('change', async function () {
        const file = this.files[0];
        if (!file) return;

        selectedFileName.textContent = file.name;
        selectedFileNameWrapper.style.display = 'flex';

        const reader = new FileReader();
        reader.onload = async function (e) {
            const csv = e.target.result;
            const lines = csv.split('\n').filter(l => l.trim() !== '');
            const header = lines[0].split(',').map(h => h.trim().toLowerCase());
            const emailIndex = header.indexOf('email');

            if (emailIndex === -1) {
                showToast('Missing "email" column.');
                return;
            }

            const emails = lines.slice(1).map(row => row.split(',')[emailIndex]?.trim());
            const response = await fetch('{{ route("check.emails") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ emails })
            });
            const existingEmails = await response.json();

            previewBody.innerHTML = '';
            let insertCount = 0, updateCount = 0;

            lines.slice(1).forEach(row => {
                const cols = row.split(',');
                if (cols.length < 6) return;

                const email = cols[emailIndex]?.trim();
                const status = existingEmails.includes(email) ? 'Update' : 'Insert';
                if (status === 'Update') updateCount++;
                else insertCount++;

                previewBody.innerHTML += `
                    <tr>
                        <td>${cols[0]}</td>
                        <td>${cols[1]}</td>
                        <td>${cols[2]}</td>
                        <td>${cols[3]}</td>
                        <td>${cols[4]}</td>
                        <td>${cols[5]}</td>
                        <td><span class="badge ${status === 'Insert' ? 'bg-success' : 'bg-warning'}">${status}</span></td>
                    </tr>`;
            });

            insertCountLabel.textContent = `Will Insert: ${insertCount}`;
            updateCountLabel.textContent = `Will Update: ${updateCount}`;

            if ($.fn.DataTable.isDataTable('#csvTable')) {
                $('#csvTable').DataTable().destroy();
            }

            $('#csvTable').DataTable({
                pageLength: 5,
                lengthChange: false,
                ordering: false,
                language: {
                    paginate: {
                        previous: '<i class="fas fa-angle-left"></i>',
                        next: '<i class="fas fa-angle-right"></i>'
                    }
                },
                initComplete: function () {
                    $('#csvTable_filter').appendTo('#datatableSearchContainer');
                }
            });

            previewSection.style.display = 'block';
            uploadSection.style.display = 'none';
        };
        reader.readAsText(file);
    });

    triggerBtn.addEventListener('click', function () {
        if (!fileInput.files[0]) {
            showToast('Please upload a CSV file first.');
            return;
        }

        const modal = new bootstrap.Modal(document.getElementById('confirmImportModal'));
        modal.show();

        confirmBtn.onclick = () => {
            modal.hide();
            startLoadingBar();

            const formData = new FormData();
            formData.append('csv_file', fileInput.files[0]);
            formData.append('_token', '{{ csrf_token() }}');

            fetch("{{ route('ajax.import.teachers', $school->schoolID) }}", {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
           .then(data => {
                finishLoadingBar();
                window.location.href = data.redirect;
            })


            .catch(err => {
                finishLoadingBar();
                showToast('Import failed. Please try again.');
                console.error(err);
            });
        };
    });

    changeFileBtn.addEventListener('click', function () {
        fileInput.value = '';
        previewSection.style.display = 'none';
        uploadSection.style.display = 'block';
        previewBody.innerHTML = '';
        selectedFileNameWrapper.style.display = 'none';
        insertCountLabel.textContent = 'Will Insert: 0';
        updateCountLabel.textContent = 'Will Update: 0';
    });
});
</script>
@endpush
