@extends('teacher.layout_teacher')

<style>
    .pagination .page-link {
        color: #0C2340;
        border-color: #0C2340;
    }

    .pagination .page-item.active .page-link {
        background-color: #0C2340;
        border-color: #0C2340;
        color: white;
    }

    .pagination .page-link:hover {
        background-color: #0C2340;
        color: white;
        border-color: #0C2340;
    }

    .card-body-hover:hover,
    .position-card.selected {
        background-color: #eaf4fb !important;
        border: 2px solid #0C2340;
        transform: scale(1.08);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .card-body-hover {
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .card-body-hover,
    .position-card {
        cursor: pointer;
    }

.neumorphic-search {
  padding: 6px;
  border-radius: 50px;
  background: #ffffff;
  box-shadow: 6px 6px 12px rgba(0, 0, 0, 0.1),
              -6px -6px 12px rgba(255, 255, 255, 0.8);
}

.search-inner {
  display: flex;
  align-items: center;
  border-radius: 50px;
  overflow: hidden;
  background: #ffffff;
}

.search-icon {
  background-color: #f0f0f0;
  width: 36px;
  height: 36px;
  border-radius: 50%;
  margin-right: 10px;
  margin-left: 6px;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: inset -2px -2px 4px rgba(255,255,255,0.5),
              inset 2px 2px 4px rgba(0,0,0,0.05);
  color: #888;
  font-size: 14px;
}

.search-input {
  flex: 1;
  border: none;
  outline: none;
  padding: 8px 16px; /* 🔽 Reduced padding */
  font-size: 15px;
  background: transparent;
  color: #333;
}



</style>

@section('content')
<div class="container py-4">
  <!-- Card Wrapper -->
<!-- Card Wrapper -->
<div class="card border-0 shadow rounded-4 p-5 mx-auto d-flex flex-column justify-content-between"
     style="background-color: white; max-width: 1200px; min-height: 600px;"> <!-- ⬅️ fixed height -->

  <!-- Search Bar -->
  <div class="d-flex justify-content-end mb-4">
    <form method="GET" action="{{ route('positions.paginate') }}" class="w-100 d-flex justify-content-start">
      <div class="neumorphic-search" style="max-width: 500px; width: 100%;">
        <div class="search-inner">
          <div class="search-icon">
            <i class="fas fa-search"></i>
          </div>
          <input type="text" name="search" class="search-input" placeholder="Search..." />
        </div>
      </div>
    </form>
  </div>

  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4 justify-content-start">
  @foreach($positions as $position)
    <div class="col">
      <div class="p-3 border shadow-sm d-flex flex-column justify-content-between card-body-hover position-card"
           data-uploadid="{{ $position->uploadID }}"
           style="border-radius: 30px; font-size: 14px; height: 100%;">
        <p class="mb-1"><strong>Position Code:</strong> {{ $position->track_code }}</p>
        <p class="mb-1"><strong>Position:</strong> {{ $position->teacherRank->teacherRank }}</p>
        <p class="mb-1"><strong>School Name:</strong> {{ $position->school->Schoolname }}</p>
        <p class="mb-1"><strong>District:</strong> {{ $position->school->district->Districtname ?? 'N/A' }}</p>
        <p class="mb-0"><strong>Deadline:</strong> {{ \Carbon\Carbon::parse($position->end_date)->format('m/d/y') }}</p>
      </div>
    </div>
  @endforeach
</div>


  <!-- Fixed Bottom Section -->
  <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap">
    <div class="text-start">
      {{ $positions->links('pagination::bootstrap-5') }}
    </div>
    <div class="text-end">
      <button id="applyNowBtn" class="btn text-white px-4 py-2" style="background-color: #0C2340; border-radius: 10px;">
        APPLY NOW
      </button>
    </div>
  </div>

</div>


  </div>
</div>
@endsection

@push('scripts')
<script>
  let selectedUploadID = null;

  document.querySelectorAll('.position-card').forEach(card => {
    card.addEventListener('click', () => {
      document.querySelectorAll('.position-card').forEach(c => c.classList.remove('selected'));
      card.classList.add('selected');
      selectedUploadID = card.getAttribute('data-uploadid');

      // Add animated effect
      card.style.transform = 'scale(1.1)';
      setTimeout(() => {
        card.style.transform = 'scale(1.08)';
      }, 100);
    });
  });

  document.getElementById('applyNowBtn').addEventListener('click', () => {
    if (selectedUploadID) {
      window.location.href = `/upload-document/${selectedUploadID}`;
    } else {
      alert('Please select a position card first.');
    }
  });
</script>
@endpush
