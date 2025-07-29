@extends('admin.layoutadmin')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<style>
.icon-upload-card {
  border: 2px dashed #ccc;
  border-radius: 20px;
  text-align: center;
  padding: 40px 20px;
  transition: all 0.3s ease;
  cursor: pointer;
}

.icon-upload-card:hover {
  border-color: #0C2340;
  background-color: #f9f9f9;
}

.icon-upload-card i {
  font-size: 60px;
  color: #0C2340;
}

.icon-upload-card .plus-circle {
  font-size: 24px;
  background: white;
  border-radius: 50%;
  padding: 4px;
  color: #0C2340;
  border: 2px solid #0C2340;
  margin-top: 10px;
}

.order-card {
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  text-align: center;
  border: 2px solid #dee2e6;
  border-radius: 20px;
  padding: 40px 30px;
  background-color: #fff;
  transition: 0.3s;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}

.order-card:hover {
  background-color: #f1f5f9;
  transform: translateY(-4px);
  box-shadow: 0 6px 14px rgba(0, 0, 0, 0.08);
}

.order-card i.fas.fa-file-pdf {
  font-size: 45px;
  color: #c82333;
}

.order-card h6 {
  margin-top: 15px;
  font-weight: 600;
}

.order-card small {
  color: #666;
}
</style>

<div class="container mt-2">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">DepEd Orders</h2>
  </div>

  <div class="card p-4 rounded-4 shadow-sm">
    <div class="row">
      @foreach ($orders as $order)
        @php
          $customRoute = match($order->DepedID) {
            1 => route('admin.depedorder.show20', $order->DepedID),
            5 => route('admin.depedorder.show19', $order->DepedID),
            default => route('admin.depedorder.show', $order->DepedID)
          };
        @endphp

        <div class="col-md-4 mb-4">
          <div class="order-card p-5 position-relative">
            <!-- Only inner content is clickable -->
            <a href="{{ $customRoute }}" class="text-decoration-none text-dark">
              <i class="fas fa-file-pdf fa-4x mb-3 text-danger"></i>
              <h5 class="fw-bold">{{ $order->filename }}</h5>
              <p class="text-muted">Year: {{ $order->year }}</p>
            </a>

            <!-- Action buttons inside the card -->
            <div class="d-flex justify-content-center gap-2 mt-3">
              <button class="btn btn-outline-warning btn-sm px-2 py-1" title="Edit"
                      data-id="{{ $order->DepedID }}"
                      data-name="{{ $order->filename }}"
                      data-year="{{ $order->year }}"
                      onclick="openEditModal(this)">
                <i class="fas fa-pen"></i>
              </button>
              <button class="btn btn-outline-danger btn-sm px-2 py-1" title="Delete"
                      onclick="confirmDelete({{ $order->DepedID }})">
                <i class="fas fa-trash-alt"></i>
              </button>
            </div>
          </div>
        </div>
      @endforeach

      <!-- Add Order Card -->
      <div class="col-md-4 mb-4">
        <div class="order-card p-5 d-flex flex-column justify-content-center align-items-center"
             data-bs-toggle="modal" data-bs-target="#addOrderModal"
             style="cursor: pointer;">
          <i class="fas fa-plus-circle fa-3x mb-2" style="color: #0C2340;"></i>
          <p class="fw-semibold mb-0" style="color: #0C2340;">Add DepEd Order</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- 📄 Add Order Modal -->
<div class="modal fade" id="addOrderModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form method="POST" action="{{ route('admin.depedorder.store') }}" class="modal-content p-4 rounded-4">
      @csrf
      <div class="modal-header border-0">
        <h5 class="modal-title"><i class="fas fa-plus-circle text-primary me-2"></i> Add DepEd Order</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">File Name</label>
          <input type="text" name="filename" class="form-control" placeholder="e.g. DepEd Order No. 20" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Year</label>
          <input type="number" name="year" class="form-control" placeholder="e.g. 2024" required>
        </div>
      </div>

      <div class="modal-footer border-0">
        <button type="submit" class="btn btn-primary w-100 rounded-pill">Add Order</button>
      </div>
    </form>
  </div>
</div>

<!-- ✏️ Edit Modal -->
<div class="modal fade" id="editOrderModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form method="POST" action="{{ route('admin.depedorder.update') }}" class="modal-content p-4 rounded-4">
      @csrf
      <input type="hidden" name="id" id="editOrderID">
      <div class="modal-header border-0">
        <h5 class="modal-title"><i class="fas fa-edit text-warning me-2"></i> Edit DepEd Order</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">File Name</label>
          <input type="text" name="filename" id="editFileName" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Year</label>
          <input type="number" name="year" id="editYear" class="form-control" required>
        </div>
      </div>

      <div class="modal-footer border-0">
        <button type="submit" class="btn btn-warning w-100 rounded-pill">Update</button>
      </div>
    </form>
  </div>
</div>

<!-- ❌ Delete Modal -->
<div class="modal fade" id="deleteOrderModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form method="POST" action="{{ route('admin.depedorder.delete') }}" class="modal-content p-4 rounded-4">
      @csrf
      <input type="hidden" name="id" id="deleteOrderID">
      <div class="modal-header border-0">
        <h5 class="modal-title text-danger"><i class="fas fa-trash-alt me-2"></i> Confirm Delete</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this DepEd Order?
      </div>
      <div class="modal-footer border-0">
        <button type="submit" class="btn btn-danger w-100 rounded-pill">Delete</button>
      </div>
    </form>
  </div>
</div>

<script>
function openEditModal(button) {
  const id = button.dataset.id;
  const name = button.dataset.name;
  const year = button.dataset.year;

  document.getElementById('editOrderID').value = id;
  document.getElementById('editFileName').value = name;
  document.getElementById('editYear').value = year;

  new bootstrap.Modal(document.getElementById('editOrderModal')).show();
}

function confirmDelete(id) {
  document.getElementById('deleteOrderID').value = id;
  new bootstrap.Modal(document.getElementById('deleteOrderModal')).show();
}
</script>

@endsection
