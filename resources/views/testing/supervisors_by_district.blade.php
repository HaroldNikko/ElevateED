{{-- @extends('admin.layoutadmin')

@section('content')
<div class="container py-4">
  <a href="{{ url()->previous() }}" class="btn btn-light rounded-circle shadow-sm mb-3">
    <i class="fas fa-arrow-left"></i>
  </a>

  <h4 class="fw-bold">{{ $district->Districtname }}</h4>

  <div class="card mt-3 shadow-sm p-4 rounded-4">
    <h5 class="mb-3">District Supervisors</h5>

    <table class="table table-bordered text-center align-middle">
      <thead class="table-light">
        <tr>
          <th>First Name</th>
          <th>Middle Name</th>
          <th>Last Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Gender</th>
          <th>Province</th>
          <th>Municipality</th>
        </tr>
      </thead>
      <tbody>
        @forelse($supervisors as $sup)
        <tr>
          <td>{{ $sup->firstname }}</td>
          <td>{{ $sup->middlename }}</td>
          <td>{{ $sup->lastname }}</td>
          <td>{{ $sup->email }}</td>
          <td>{{ $sup->phone_number }}</td>
          <td>{{ $sup->gender }}</td>
          <td>{{ $sup->province }}</td>
          <td>{{ $sup->municipality }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="7" class="text-muted">No supervisors found for this district.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection --}}
