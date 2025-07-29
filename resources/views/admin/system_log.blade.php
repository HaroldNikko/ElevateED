@extends('admin.layoutadmin')

@section('content')

<div class="container py-4">
  <h4 class="mb-4 fw-bold">System Activity Logs</h4>

  <form method="GET" class="mb-3">
    <div class="input-group" style="max-width: 400px;">
      <input type="text" name="search" class="form-control" placeholder="Search by username or email..." value="{{ request('search') }}">
      <button class="btn btn-dark" type="submit">Search</button>
    </div>
  </form>

  <div class="card shadow-sm rounded-4">
    <div class="table-responsive">
      <table class="table table-bordered align-middle text-center mb-0">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>User</th>
            <th>Action</th>
            <th>Section</th>
            <th>IP</th>
            <th>Timestamp</th>
          </tr>
        </thead>
        <tbody>
          @forelse($logs as $index => $log)
            <tr>
              <td>{{ $index + 1 }}</td>
              <td>
                @if($log->login)
                  {{ $log->login->username }}<br>
                  <small>{{ $log->login->email }}</small>
                @else
                  <em>Guest</em>
                @endif
              </td>
              <td>{{ $log->action }}</td>
              <td>{{ $log->section ?? '—' }}</td>
              <td>{{ $log->ip }}</td>
              <td>{{ $log->created_at->format('Y-m-d h:i A') }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-muted">No logs found.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection
