@extends('admin.layoutadmin')

@section('content')
<style>
    .province-card {
        transition: background-color 0.3s ease;
        border-radius: 1rem;
    }
    .province-card:hover {
        background-color: #e6f3ff !important;
    }
</style>

<div class="container py-4">
    <div class="card shadow-sm rounded-4 p-4 border-0">
        <h4 class="fw-bold mb-4">Divisions under {{ $region->region_name }}</h4>

        <!-- Division Cards -->
        <div class="row">
            @forelse($provinces as $province)
                <div class="col-md-6 col-lg-4 mb-4">
                    <a href="{{ route('admin.province.municipalities-csv', $province->province_id) }}" class="text-decoration-none">
                        <div class="card province-card shadow-sm h-100 border-0">
                            <div class="card-body py-4 px-4">
                                <h5 class="card-title fw-semibold text-dark mb-0">{{ $province->province_name }}</h5>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12 text-center text-muted">
                    No divisions found under this region.
                </div>
            @endforelse
        </div>

        <!-- Pagination Info + Controls -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="text-muted small">
                Showing {{ $provinces->firstItem() }} to {{ $provinces->lastItem() }} of {{ $provinces->total() }} results
            </div>
            <div>
                {{ $provinces->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
