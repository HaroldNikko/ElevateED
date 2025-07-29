@extends('admin.layoutadmin')

@section('content')
<style>
    .region-card {
        transition: background-color 0.3s ease;
        border-radius: 1rem; /* rounded-4 */
    }
    .region-card:hover {
        background-color: #e6f3ff !important; /* light blue */
    }
</style>

<div class="container py-4">
    <div class="card shadow-sm rounded-4 p-4 border-0">
        <h4 class="fw-bold mb-4">Select Region to Import CSV</h4>

        <!-- Region Cards -->
        <div class="row">
            @forelse($regions as $region)
                <div class="col-md-6 col-lg-4 mb-4">
                    <a href="{{ route('admin.region.divisions.csv', $region->region_id) }}" class="text-decoration-none">
                        <div class="card region-card shadow-sm h-100 border-0">
                            <div class="card-body py-4 px-4">
                                <h5 class="card-title fw-semibold text-dark">{{ $region->region_name }}</h5>
                                <p class="card-text text-muted">{{ $region->region_description }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12 text-center text-muted">
                    No regions found.
                </div>
            @endforelse
        </div>

        <!-- Pagination Info + Controls -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="text-muted small">
                Showing {{ $regions->firstItem() }} to {{ $regions->lastItem() }} of {{ $regions->total() }} results
            </div>
            <div>
                {{ $regions->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
