@extends('admin.layoutadmin')

@section('content')
<div class="container py-4">
  <h2 class="mb-4 fw-bold">Admin Dashboard</h2>

  {{-- Updated Summary Cards --}}
  <div class="row g-4">
    <div class="col-md-4">
      <div class="card h-100 rounded-4 shadow-sm" style="background-color: #f4c2c2;"> {{-- light pink --}}
        <div class="card-body d-flex align-items-center gap-3">
          <div class="icon-box rounded-circle d-flex justify-content-center align-items-center" style="width:60px; height:60px; background-color:#f0aeb2;">
            <i class="fas fa-user fa-lg text-black"></i>
          </div>
          <div>
            <h6 class="fw-bold mb-1 text-black">Total Teachers</h6>
            <p class="card-text fs-4 fw-bold mb-0 text-black">{{ $teacherCount }}</p>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card h-100 rounded-4 shadow-sm" style="background-color: #c9ccd3;"> {{-- light gray/blue --}}
        <div class="card-body d-flex align-items-center gap-3">
          <div class="icon-box rounded-circle d-flex justify-content-center align-items-center" style="width:60px; height:60px; background-color:#aeb4c2;">
            <i class="fas fa-user-tie fa-lg text-black"></i>
          </div>
          <div>
            <h6 class="fw-bold mb-1 text-black">Total Evaluators</h6>
            <p class="card-text fs-4 fw-bold mb-0 text-black">{{ $evaluatorCount }}</p>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card h-100 rounded-4 shadow-sm" style="background-color: #f4c2c2;"> {{-- light pink --}}
        <div class="card-body d-flex align-items-center gap-3">
          <div class="icon-box rounded-circle d-flex justify-content-center align-items-center" style="width:60px; height:60px; background-color:#f0aeb2;">
            <i class="fas fa-briefcase fa-lg text-black"></i>
          </div>
          <div>
            <h6 class="fw-bold mb-1 text-black">Available Positions</h6>
            <p class="card-text fs-4 fw-bold mb-0 text-black">{{ $positionCount }}</p>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card h-100 rounded-4 shadow-sm" style="background-color: #f4c2c2;"> {{-- light pink --}}
        <div class="card-body d-flex align-items-center gap-3">
          <div class="icon-box rounded-circle d-flex justify-content-center align-items-center" style="width:60px; height:60px; background-color:#f0aeb2;">
            <i class="fas fa-file-alt fa-lg text-black"></i>
          </div>
          <div>
            <h6 class="fw-bold mb-1 text-black">Applications</h6>
            <p class="card-text fs-4 fw-bold mb-0 text-black">{{ $applicationCount }}</p>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card h-100 rounded-4 shadow-sm" style="background-color: #c9ccd3;"> {{-- light gray/blue --}}
        <div class="card-body d-flex align-items-center gap-3">
          <div class="icon-box rounded-circle d-flex justify-content-center align-items-center" style="width:60px; height:60px; background-color:#aeb4c2;">
            <i class="fas fa-check-circle fa-lg text-black"></i>
          </div>
          <div>
            <h6 class="fw-bold mb-1 text-black">Approved Applications</h6>
            <p class="card-text fs-4 fw-bold mb-0 text-black">{{ $approvedCount }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Charts Section --}}
  <div class="row mt-5 g-4">
    <div class="col-lg-6">
      <div class="card shadow-sm rounded-4">
        <div class="card-body">
          <h5 class="card-title fw-bold mb-3">Applications Over Last 30 Days</h5>
          <canvas id="appsOverTime"></canvas>
        </div>
      </div>
    </div>

    <div class="col-lg-6">
      <div class="card shadow-sm rounded-4">
        <div class="card-body">
          <h5 class="card-title fw-bold mb-3">Applications by Status</h5>
          <canvas id="appsByStatus"></canvas>
        </div>
      </div>
    </div>

    <div class="col-lg-6">
      <div class="card shadow-sm rounded-4">
        <div class="card-body">
          <h5 class="card-title fw-bold mb-3">Applications by Teacher Rank</h5>
          <canvas id="appsByRank"></canvas>
        </div>
      </div>
    </div>

    <div class="col-lg-6">
      <div class="card shadow-sm rounded-4">
        <div class="card-body">
          <h5 class="card-title fw-bold mb-3">Evaluator Workload</h5>
          <canvas id="workload"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
function createGradient(ctx, color1, color2) {
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, color1);
    gradient.addColorStop(1, color2);
    return gradient;
}

// Applications over time (3D-like)
const ctx1 = document.getElementById('appsOverTime').getContext('2d');
new Chart(ctx1, {
    type: 'line',
    data: {
        labels: {!! json_encode($appsOverTime->pluck('date')) !!},
        datasets: [{
            data: {!! json_encode($appsOverTime->pluck('count')) !!},
            borderColor: 'rgba(54, 162, 235, 1)',
            backgroundColor: createGradient(ctx1, 'rgba(54,162,235,0.6)', 'rgba(54,162,235,0.1)'),
            borderWidth: 4,
            pointRadius: 6,
            pointBackgroundColor: 'white',
            pointBorderColor: 'rgba(54, 162, 235, 1)',
            pointBorderWidth: 2,
            fill: true,
            tension: 0.4,
        }]
    },
    options: { plugins: { legend: { display: false }}, scales: { y: { beginAtZero: true }}}
});

// Applications by status (3D-like)
const ctx2 = document.getElementById('appsByStatus').getContext('2d');
new Chart(ctx2, {
    type: 'bar',
    data: {
        labels: {!! json_encode($appsByStatus->keys()) !!},
        datasets: [{
            data: {!! json_encode($appsByStatus->values()) !!},
            backgroundColor: createGradient(ctx2, 'rgba(255,99,132,0.7)', 'rgba(255,99,132,0.2)'),
        }]
    },
    options: { plugins: { legend: { display: false }}, scales: { y: { beginAtZero: true }}}
});

// Applications by teacher rank (3D-like)
const ctx3 = document.getElementById('appsByRank').getContext('2d');
new Chart(ctx3, {
    type: 'bar',
    data: {
        labels: {!! json_encode($appsByRank->keys()) !!},
        datasets: [{
            data: {!! json_encode($appsByRank->values()) !!},
            backgroundColor: createGradient(ctx3, 'rgba(75,192,192,0.7)', 'rgba(75,192,192,0.2)'),
        }]
    },
    options: { plugins: { legend: { display: false }}, scales: { y: { beginAtZero: true }}}
});

// Evaluator workload (3D-like)
const ctx4 = document.getElementById('workload').getContext('2d');
new Chart(ctx4, {
    type: 'bar',
    data: {
        labels: {!! json_encode($workload->keys()) !!},
        datasets: [{
            data: {!! json_encode($workload->values()) !!},
            backgroundColor: createGradient(ctx4, 'rgba(153,102,255,0.7)', 'rgba(153,102,255,0.2)'),
        }]
    },
    options: { plugins: { legend: { display: false }}, scales: { y: { beginAtZero: true }}}
});
</script>
@endsection
