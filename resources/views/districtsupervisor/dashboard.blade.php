@extends('districtsupervisor.layout')

<style>
.responsive-icon-box {
  width: 12vw;
  height: 12vw;
  max-width: 60px;
  max-height: 60px;
  min-width: 40px;
  min-height: 40px;
}
.responsive-icon {
  font-size: 6vw;
}
@media (min-width: 768px) {
  .responsive-icon { font-size: 28px; }
}
@media (max-width: 576px) {
  .responsive-icon-box {
    width: 14vw;
    height: 14vw;
  }
  .responsive-icon { font-size: 6vw; }
  .row.g-4 > [class*='col-'] {
    margin-bottom: 1rem;
  }
}

/* Circle icon backgrounds */
.bg-icon-applications { background-color: #f0aeb2; }
.bg-icon-promoted { background-color: #aeb4c2; }
.bg-icon-evaluator { background-color: #f0aeb2; }
</style>

@section('content')
<div class="container py-2">

  {{-- Welcome Header --}}
  <h4 class="fw-bold mb-4">WELCOME JAYMEE!</h4>

  {{-- Metrics Cards --}}
  <div class="row row-cols-1 row-cols-md-3 g-4 mb-4">
    <div class="col">
      <div class="card h-100 rounded-4 shadow-sm" style="background-color: #f4c2c2;">
        <div class="card-body d-flex align-items-center gap-3">
          <div class="icon-box responsive-icon-box rounded-circle d-flex justify-content-center align-items-center bg-icon-applications">
            <i class="fas fa-file-alt text-black responsive-icon"></i>
          </div>
          <div>
            <h6 class="fw-bold mb-1 text-black">Total Applications</h6>
            <p class="card-text fs-4 fw-bold mb-0 text-black">{{ $totalApplications }}</p>
          </div>
        </div>
      </div>
    </div>

    <div class="col">
      <div class="card h-100 rounded-4 shadow-sm" style="background-color: #c9ccd3;">
        <div class="card-body d-flex align-items-center gap-3">
          <div class="icon-box responsive-icon-box rounded-circle d-flex justify-content-center align-items-center bg-icon-promoted">
            <i class="fas fa-arrow-up text-black responsive-icon"></i>
          </div>
          <div>
            <h6 class="fw-bold mb-1 text-black">Promoted this Month</h6>
            <p class="card-text fs-4 fw-bold mb-0 text-black">{{ $promotedThisMonth }}</p>
          </div>
        </div>
      </div>
    </div>

    <div class="col">
      <div class="card h-100 rounded-4 shadow-sm" style="background-color: #f4c2c2;">
        <div class="card-body d-flex align-items-center gap-3">
          <div class="icon-box responsive-icon-box rounded-circle d-flex justify-content-center align-items-center bg-icon-evaluator">
            <i class="fas fa-user-tie text-black responsive-icon"></i>
          </div>
          <div>
            <h6 class="fw-bold mb-1 text-black">Total Evaluator</h6>
            <p class="card-text fs-4 fw-bold mb-0 text-black">{{ $totalEvaluators }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Charts & New Applicant Row --}}
  <div class="row g-4">
    <div class="col-12 col-lg-8 d-flex flex-column gap-4">
      {{-- Line Chart --}}
      <div class="card rounded-4 shadow-sm p-3">
        <canvas id="lineChart" height="250"></canvas>
      </div>

      {{-- New Applicant --}}
      <div class="card rounded-4 shadow-sm p-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="fw-bold mb-0">New Applicant</h5>
          <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
        </div>
        <div class="d-flex flex-wrap justify-content-center justify-content-md-start gap-3">
          <div class="d-flex align-items-center gap-2">
            <img src="https://via.placeholder.com/40" class="rounded-circle" alt="">
            <div>
              <strong>Lindsay Angcao</strong> <span class="text-primary small fw-bold">NEW</span>
              <div class="small">12:09 PM | 02-17-2025</div>
            </div>
          </div>

          <div class="d-flex align-items-center gap-2">
            <img src="https://via.placeholder.com/40" class="rounded-circle" alt="">
            <div>
              <strong>Sheila Gomez</strong> <span class="text-primary small fw-bold">NEW</span>
              <div class="small">11:23 AM | 02-17-2025</div>
            </div>
          </div>

          <div class="d-flex align-items-center gap-2">
            <img src="https://via.placeholder.com/40" class="rounded-circle" alt="">
            <div>
              <strong>Jhosua Villaluna</strong> <span class="text-primary small fw-bold">NEW</span>
              <div class="small">09:15 AM | 02-16-2025</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Doughnut Chart --}}
    <div class="col-12 col-lg-4">
      <div class="card rounded-4 shadow-sm p-3 text-center" style="background-color: #e9ecef;">
        <h5 class="fw-bold mb-3">Evaluation Progress</h5>
        <canvas id="evaluationDoughnut" height="250"></canvas>
      </div>
    </div>

  </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Line Chart
  new Chart(document.getElementById('lineChart'), {
    type: 'line',
    data: {
      labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
      datasets: [
        {
          label: 'Approved',
          data: [12, 19, 15, 22, 30, 18, 14, 20, 22, 28, 35, 40],
          borderColor: '#0ea5e9',
          fill: false,
          tension: 0.4
        },
        {
          label: 'Rejected',
          data: [5, 12, 10, 25, 50, 32, 20, 10, 15, 12, 25, 35],
          borderColor: '#ef4444',
          fill: false,
          tension: 0.4
        }
      ]
    },
    options: {
      plugins: { legend: { position: 'top' } },
      scales: { y: { beginAtZero: true } }
    }
  });

  // Doughnut Chart
  new Chart(document.getElementById('evaluationDoughnut'), {
    type: 'doughnut',
    data: {
      labels: ['Approved', 'In Progress', 'Rejected'],
      datasets: [{
        data: [65, 25, 10],
        backgroundColor: [
          '#0a2a53',
          '#345e8b',
          '#5e87b9'
        ],
        hoverOffset: 4
      }]
    },
    options: {
      plugins: { legend: { position: 'top' } }
    }
  });
</script>
@endpush
