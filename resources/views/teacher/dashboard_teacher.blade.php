@extends('teacher.layout_teacher')

@section('content')
<div class="container py-4">
  <h2 class="fw-bold mb-4">Welcome {{ session('firstname') }}!!</h2>


  {{-- Metrics Cards --}}
  <div class="row g-4 mb-4">
    <div class="col-md-4">
      <div class="card h-100 rounded-4 shadow-sm" style="background-color: #f4c2c2;">
        <div class="card-body d-flex align-items-center gap-3">
          <div class="icon-box responsive-icon-box rounded-circle d-flex justify-content-center align-items-center bg-total">
            <i class="fas fa-folder-open text-black responsive-icon"></i>
          </div>
          <div>
            <h6 class="fw-bold mb-1 text-black">Total Applications</h6>
            <p class="card-text fs-4 fw-bold mb-0 text-black">{{ $totalApplications }}</p>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card h-100 rounded-4 shadow-sm" style="background-color: #c9ccd3;">
        <div class="card-body d-flex align-items-center gap-3">
          <div class="icon-box responsive-icon-box rounded-circle d-flex justify-content-center align-items-center bg-approved">
            <i class="fas fa-check text-black responsive-icon"></i>
          </div>
          <div>
            <h6 class="fw-bold mb-1 text-black">Approved Applications</h6>
            <p class="card-text fs-4 fw-bold mb-0 text-black">{{ $approvedApplications }}</p>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card h-100 rounded-4 shadow-sm" style="background-color: #f4c2c2;">
        <div class="card-body d-flex align-items-center gap-3">
          <div class="icon-box responsive-icon-box rounded-circle d-flex justify-content-center align-items-center bg-pending">
            <i class="fas fa-hourglass-half text-black responsive-icon"></i>
          </div>
          <div>
            <h6 class="fw-bold mb-1 text-black">Pending Applications</h6>
            <p class="card-text fs-4 fw-bold mb-0 text-black">{{ $pendingApplications }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Charts Section --}}
  <div class="row g-4">
    <div class="col-lg-6">
      <div class="card shadow-sm rounded-4">
        <div class="card-body" style="height: 400px;">
          <h5 class="card-title fw-bold mb-3">Application Timeline</h5>
          <canvas id="applicationTimeline"></canvas>
        </div>
      </div>
    </div>

    <div class="col-lg-6">
  <div class="card shadow-sm rounded-4 h-100">
    <div class="card-body" style="background-color: white; height: 400px;">
      
      <!-- Title on top -->
      <h5 class="card-title fw-bold text-black mb-4">Notifications Overview</h5>

      <!-- Row with Chart and Legend -->
      <div class="row g-0 align-items-center h-100">

        <!-- Doughnut Chart column -->
        <div class="col-md-8 d-flex justify-content-center align-items-center" style="margin-top: -80px;">
        <canvas id="notificationsPie" style="width: 200px; height: 200px;"></canvas>
        </div>


        <!-- Legend column -->
        <div class="col-md-4 d-flex flex-column justify-content-center align-self-start">
        <div class="d-flex flex-column gap-2">
            <div class="d-flex align-items-center gap-2">
            <div style="width: 20px; height: 20px; border-radius: 50%; border: 3px solid #00008B; background-color: transparent;"></div>
            <span class="fw-bold text-black">Unread</span>
            </div>
            <div class="d-flex align-items-center gap-2">
            <div style="width: 20px; height: 20px; border-radius: 50%; border: 3px solid #B41F28; background-color: transparent;"></div>
            <span class="fw-bold text-black">Read</span>
            </div>
        </div>
        </div>


      </div>
    </div>
  </div>
</div>





    <div class="col-lg-12">
      <div class="card shadow-sm rounded-4">
        <div class="card-body" style="height: 400px;">
          <h5 class="card-title fw-bold mb-3">Evaluation Progress</h5>
          <canvas id="evaluationProgress"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
#notificationsPie {

  object-fit: contain;
  display: block;
}
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
.bg-total { background-color: #f0aeb2; }
.bg-approved { background-color: #aeb4c2; }
.bg-pending { background-color: #f0aeb2; }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
function createGradient(ctx, color1, color2) {
  const gradient = ctx.createLinearGradient(0, 0, 0, 400);
  gradient.addColorStop(0, color1);
  gradient.addColorStop(1, color2);
  return gradient;
}

document.addEventListener("DOMContentLoaded", function() {
  // 🔴 Plugin para kulayan ang background ng chart area
  const chartAreaBackground = {
    id: 'custom_canvas_background_color',
    beforeDraw: (chart) => {
      const ctx = chart.ctx;
      ctx.save();
      ctx.globalCompositeOperation = 'destination-over';
      ctx.fillStyle = '#ffe6e6'; // 🔴 light red background sa loob ng axes
      ctx.fillRect(
        chart.chartArea.left,
        chart.chartArea.top,
        chart.chartArea.right - chart.chartArea.left,
        chart.chartArea.bottom - chart.chartArea.top
      );
      ctx.restore();
    }
  };

  // 🟢 Application Timeline Chart
  const timelineCtx = document.getElementById('applicationTimeline').getContext('2d');
  new Chart(timelineCtx, {
    type: 'line',
    data: {!! json_encode($timelineChart) !!},
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: true }},
      scales: { y: { beginAtZero: true }},
      elements: {
  line: {
    tension: 0.4,
    borderWidth: 3,
    borderColor: '#B41F28', // solid red line
    backgroundColor: 'rgba(180,31,40,0.4)', // red fill under the line
    fill: 'origin' // important: fills only under the line
  },
  point: {
    radius: 5,
    borderWidth: 2,
    borderColor: '#B41F28',
    backgroundColor: '#B41F28'
  }
}
    }
  });


  const notifCtx = document.getElementById('notificationsPie').getContext('2d');
  new Chart(notifCtx, {
    type: 'doughnut',
    data: {
      labels: ['Unread', 'Read'],
      datasets: [{
        data: [{{ $unread }}, {{ $read }}],
        backgroundColor: ['#00008B', '#B41F28'],
        borderColor: '#fff',
        borderWidth: 5,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: false }},
      cutout: '60%',
    }
  });

  const evalCtx = document.getElementById('evaluationProgress').getContext('2d');
  new Chart(evalCtx, {
    type: 'bar',
    data: {!! json_encode($evaluationChart) !!},
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: false }},
      scales: { y: { beginAtZero: true }},
      elements: {
        bar: {
          backgroundColor: createGradient(evalCtx, 'rgba(180,31,40,0.7)', 'rgba(180,31,40,0.2)')
        }
      }
    }
  });
});
</script>
@endsection
