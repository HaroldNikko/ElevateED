@extends('admin.layoutadmin')

@section('content')

<div class="container mt-4">
<div class="d-flex justify-content-between align-items-center mb-3">
    <div class="d-flex align-items-center">
        <a href="{{ url()->previous() }}" 
           class="btn rounded-circle me-3" 
           style="background-color: #0C2340; color: white; width: 38px; height: 38px; display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h4 class="mb-0">Provinces under: <strong>{{ $region->region_name }}</strong></h4>
    </div>
</div>


  <table class="table table-bordered text-center align-middle">
    <thead class="custom-thead">
      <tr>
        <th>#</th>
        <th>Province Name</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($provinces as $index => $province)
        <tr onclick="window.location='{{ route('admin.showMunDistrict', $province->province_id) }}'" style="cursor:pointer;">
          <td>{{ $provinces->firstItem() + $index }}</td>
          <td>{{ $province->province_name }}</td>
        </tr>
      @empty
        <tr>
          <td colspan="2" class="text-muted">No provinces found.</td>
        </tr>
      @endforelse
    </tbody>
  </table>

  <div class="d-flex justify-content-between align-items-center mt-3">
    <div>
      Showing {{ $provinces->firstItem() }} to {{ $provinces->lastItem() }} of {{ $provinces->total() }} entries
    </div>
    <div>
      {{ $provinces->links('pagination::bootstrap-5') }}
    </div>
  </div>
</div>

@endsection
