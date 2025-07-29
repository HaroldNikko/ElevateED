@extends('evaluator.evaluator_layout')

@section('content')
<div class="container py-4">
     <h2 class="fw-bold mb-4">Welcome {{ session('evaluatorFirstName') }}!!</h2>

  <div class="row g-4">
    {{-- Left Column: Doughnut Chart --}}
    <div class="col-md-4">
      <div class="card shadow-sm rounded-4 h-100 p-3 text-center d-flex justify-content-center align-items-center">
        <div class="d-flex flex-column align-items-center">
          <h5 class="fw-bold mb-3">Evaluation Progress</h5>
          
          <div class="mb-3">
            <div style="width: 230px; height: 230px;">
              <canvas id="evaluationDoughnut" width="230" height="230"></canvas>
            </div>
          </div>

          <div class="d-flex justify-content-center gap-3">
            <div class="d-flex align-items-center gap-1">
              <div class="rounded-circle" style="width:10px; height:10px; background-color:#3b82f6;"></div>
              <small>In Progress</small>
            </div>
            <div class="d-flex align-items-center gap-1">
              <div class="rounded-circle" style="width:10px; height:10px; background-color:#1e40af;"></div>
              <small>For Evaluation</small>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Right Column --}}
    <div class="col-md-8 d-flex flex-column gap-3 h-100">
      
      {{-- Top Row: Total Applications & Notification --}}
      <div class="d-flex gap-3">
        {{-- Total Application Assigned (Pink) --}}
        <div class="card shadow-sm rounded-4 flex-grow-1" style="background-color: #f4c2c2; color: #000;">
          <div class="card-body d-flex align-items-center gap-3">
            <div class="rounded-circle bg-dark d-flex justify-content-center align-items-center" style="width:40px; height:40px;">
              <i class="fas fa-user text-white"></i>
            </div>
            <div>
              <p class="mb-1 fw-bold">Total Application Assigned</p>
              <h3 class="fw-bold mb-0">{{ $totalAssigned }}</h3>
            </div>
          </div>
        </div>

        {{-- Notification (Gray) --}}
        <div class="card shadow-sm rounded-4 flex-grow-1" style="background-color: #c9ccd3; color: #000;">
          <div class="card-body">
            <h5 class="fw-bold mb-2">Notification</h5>
            <ul class="mb-0 ps-3">
              <li>New application assigned to you.</li>
              <li>Applicant Maria Santos updated documents.</li>
            </ul>
          </div>
        </div>
      </div>

      {{-- Bar Chart --}}
      <div class="card shadow-sm rounded-4 p-3 flex-grow-1">
        <h5 class="fw-bold mb-3">Number of Evaluations per Criteria</h5>
        <div>
          <canvas id="barChart" style="max-height: 300px;"></canvas>
        </div>
      </div>

    </div>
  </div>

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Doughnut Chart
  const doughnutCtx = document.getElementById('evaluationDoughnut').getContext('2d');
  new Chart(doughnutCtx, {
    type: 'doughnut',
    data: {
      labels: ['In Progress', 'For Evaluation'],
      datasets: [{
        data: [60, 40],
        backgroundColor: ['#3b82f6', '#1e40af'],
        borderWidth: 1
      }]
    },
    options: {
      cutout: '60%',
      plugins: { legend: { display: false } },
      maintainAspectRatio: false,
      responsive: true
    }
  });

  // Bar Chart
  const barCtx = document.getElementById('barChart').getContext('2d');
  new Chart(barCtx, {
    type: 'bar',
    data: {
      labels: @json($barChartLabels),
      datasets: [{
        label: 'Evaluations',
        data: @json($barChartData),
        backgroundColor: '#3b82f6',
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: { beginAtZero: true }
      },
      plugins: {
        legend: { display: false }
      }
    }
  });
</script>
@endsection
