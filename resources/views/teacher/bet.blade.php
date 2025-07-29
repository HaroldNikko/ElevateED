@extends('teacher.layout_teacher')

@section('content')
<style>
  .stat-card {
    background: linear-gradient(135deg, #ffffff, #f9f9f9);
    border: 1px solid #dee2e6;
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
    transition: 0.3s ease;
    height: 100%;
  }
  .stat-card:hover {
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
  }
  .stat-label {
    font-size: 14px;
    font-weight: 500;
    color: #333;
  }
  .progress {
    height: 30px;
    background-color: #f1f1f1;
    border-radius: 20px;
    overflow: hidden;
  }
  .progress-bar {
    font-weight: 600;
    font-size: 14px;
    border-radius: 20px;
  }
  .card-title-icon {
    font-size: 1.3rem;
    margin-right: 8px;
    color: #0C2340;
  }
</style>

<div class="container mt-3">
  <div class="text-end">
    <a href="https://www.statmuse.com/nba" target="_blank" class="text-decoration-none statmuse-link">
      <div class="text-center mt-4 mb-2 shadow-sm rounded p-3 statmuse-card">
        <h3 class="fw-bold text-primary mb-1">🏀 Player Performance Tracker</h3>
        <p class="text-muted mb-0">Check stats as they are completed to update progress.</p>
      </div>
    </a>
  </div>

  <!-- Progress Bar -->
  <div class="mb-5">
    <label class="fw-semibold mb-2">📈 Overall Progress</label>
    <div class="progress">
      <div id="progressBar" class="progress-bar bg-success" role="progressbar" style="width: 0%;">0%</div>
    </div>
  </div>

  @php
    $pointsStats = [
      "T.J. McConnell 8+ Points",
      "Andrew Nembhard 5+ Points",
      "P. Siakam 15+ Points",
      "Jalen Williams 18+ Points",
      "Shai Gilgeous-Alexander 25+ Points"
    ];
    $reboundStats = [
      "O. Toppin 4+ Rebounds",
      "Chet Holmgren 5+ Rebounds",
      "P. Siakam 5+ Rebounds",
      "Jalen Williams 5+ Rebounds"
    ];

    $groupedStats = [
      ['title' => 'Points', 'icon' => 'fa-solid fa-basketball', 'data' => $pointsStats],
      ['title' => 'Rebounds', 'icon' => 'fa-solid fa-arrow-up-9-1', 'data' => $reboundStats],
    ];

    $allStats = array_merge($pointsStats, $reboundStats);
  @endphp

  <div class="row g-4">
    @foreach($groupedStats as $card)
      <div class="col-md-6">
        <div class="stat-card h-100">
          <h5 class="fw-bold text-secondary mb-3 d-flex align-items-center">
            <i class="{{ $card['icon'] }} card-title-icon"></i> {{ $card['title'] }}
          </h5>
          <div class="list-group list-group-flush">
            @foreach($card['data'] as $stat)
              @php $index = array_search($stat, $allStats); @endphp
              <label class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                <div class="d-flex align-items-center">
                  <input class="form-check-input me-2 stat-check" type="checkbox" value="{{ $stat }}" data-index="{{ $index }}">
                  <span class="stat-label">{{ $stat }}</span>
                </div>
                <span class="loading-indicator badge bg-warning text-dark d-none" id="loading-{{ $index }}">Loading...</span>
              </label>
            @endforeach
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>

<style>
  .statmuse-card {
    transition: all 0.3s ease;
    background-color: #ffffff;
    border-radius: 12px;
  }

  .statmuse-link:hover .statmuse-card {
    transform: translateY(-2px) scale(1.02);
    box-shadow: 0 0 12px rgba(0, 123, 255, 0.5), 0 0 20px rgba(255, 193, 7, 0.5);
    background: linear-gradient(90deg, #e3f2fd, #fffde7);
  }

  .statmuse-link {
    cursor: pointer;
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.stat-check');
    const progressBar = document.getElementById('progressBar');
    const totalStats = checkboxes.length;

    function updateProgressBar() {
      const checked = document.querySelectorAll('.stat-check:checked').length;
      const percent = Math.round((checked / totalStats) * 100);
      progressBar.style.width = percent + '%';
      progressBar.textContent = percent + '%';
    }

    checkboxes.forEach(box => {
      box.addEventListener('change', function () {
        const index = this.getAttribute('data-index');
        const loader = document.getElementById(`loading-${index}`);

        if (this.checked) {
          loader.classList.remove('d-none');
          setTimeout(() => {
            loader.classList.add('d-none');
            updateProgressBar();
          }, 800);
        } else {
          updateProgressBar();
        }
      });
    });
  });
</script>
@endsection
