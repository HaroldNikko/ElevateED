@extends('admin.layoutadmin')

@section('content')
<style>
  .custom-thead {
    background-color: #0C2340;
    color: white;
    text-align: center;
  }
  .table th, .table td {
    vertical-align: middle;
    text-align: center;
  }
  tr.clickable-row {
    cursor: pointer;
  }
</style>

<div class="container mt-4">
  <!-- Title and Back Button -->
  <div class="d-flex align-items-center mb-3">
    <a href="{{ url()->previous() }}" 
       class="d-flex justify-content-center align-items-center me-3"
       style="width: 40px; height: 40px; background-color: #0C2340; border-radius: 50%;">
      <i class="fas fa-arrow-left" style="color: white;"></i>
    </a>
    <h4 class="mb-0">School Distribution by District and Municipality</h4>
  </div>

  <!-- Table -->
  <table class="table table-bordered text-center align-middle">
    <thead class="custom-thead">
      <tr>
        <th>Legislative District</th>
        <th>Municipality</th>
        <th>School Count</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($paginated as $item)
        <tr class="clickable-row" onclick="window.location='{{ url('/admin/systemsetup/addschool') }}?region={{ $regionName }}&province={{ $provinceName }}&district={{ $item['district_name'] }}&municipality={{ $item['municipality_name'] }}'">
          <td>{{ $item['district_name'] }}</td>
          <td>{{ $item['municipality_name'] }}</td>
          <td>
            {{
                \App\Models\SchoolDetail::whereHas('region', fn($q) => $q->where('region_name', $regionName))
                ->whereHas('province', fn($q) => $q->where('province_name', $provinceName))
                ->whereHas('district', fn($q) => $q->where('district_name', $item['district_name']))
                ->whereHas('municipality', fn($q) => $q->where('municipality_name', $item['municipality_name']))
                ->count()
            }}
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="3" class="text-muted">No municipalities found.</td>
        </tr>
      @endforelse
    </tbody>
  </table>

  <!-- Pagination Footer -->
  <div class="d-flex justify-content-between align-items-center mt-3">
    <div>
      Showing {{ $paginated->firstItem() }} to {{ $paginated->lastItem() }} of {{ $paginated->total() }} results
    </div>
    <div>
      {{ $paginated->links('pagination::bootstrap-5') }}
    </div>
  </div>
</div>
@endsection
