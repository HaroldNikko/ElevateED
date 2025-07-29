@extends('districtsupervisor.layout')

@section('content')
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <div class="input-group w-auto">
      <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
        Filter
      </button>
      <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="#">All</a></li>
        <li><a class="dropdown-item" href="#">Approved</a></li>
        <li><a class="dropdown-item" href="#">Pending</a></li>
        <li><a class="dropdown-item" href="#">In Progress</a></li>
      </ul>
    </div>

    <div class="input-group w-25">
      <input type="text" class="form-control" placeholder="Search">
      <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered text-center align-middle">
      <thead style="background-color: #0C2340; color: white;">
        <tr>
          <th>No.</th>
          <th>Application Code</th>
          <th>Name</th>
          <th>Position</th>
          <th>Status</th>
          <th>Details</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>1101</td>
          <td><strong>Villajuan, Vincent C.</strong></td>
          <td>Teacher III</td>
          <td>
            <span class="badge rounded-pill text-bg-warning">In Progress</span>
            <i class="fas fa-caret-down ms-1 text-dark"></i>
          </td>
          <td><i class="fas fa-eye text-dark" style="cursor: pointer;"></i></td>
        </tr>
        <tr>
          <td>2</td>
          <td>1102</td>
          <td><strong>Salanguit, Harold Nikko G.</strong></td>
          <td>Teacher III</td>
          <td>
            <span class="badge rounded-pill text-bg-success">Approved</span>
            <i class="fas fa-caret-down ms-1 text-dark"></i>
          </td>
          <td><i class="fas fa-eye text-dark" style="cursor: pointer;"></i></td>
        </tr>
        <tr>
          <td>3</td>
          <td>1103</td>
          <td><strong>Gomez, Erish M.</strong></td>
          <td>Teacher III</td>
          <td>
            <span class="badge rounded-pill text-bg-danger">Pending</span>
            <i class="fas fa-caret-down ms-1 text-dark"></i>
          </td>
          <td><i class="fas fa-eye text-dark" style="cursor: pointer;"></i></td>
        </tr>
        <tr>
          <td>4</td>
          <td>1104</td>
          <td><strong>Matalog, Raymond</strong></td>
          <td>Teacher II</td>
          <td>
            <span class="badge rounded-pill text-bg-danger">Pending</span>
            <i class="fas fa-caret-down ms-1 text-dark"></i>
          </td>
          <td><i class="fas fa-eye text-dark" style="cursor: pointer;"></i></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
@endsection
