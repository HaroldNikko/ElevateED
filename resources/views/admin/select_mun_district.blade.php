@extends('admin.layoutadmin')

@section('content')
<style>
    .mun-card {
        transition: background-color 0.3s ease;
        border-radius: 1rem;
    }
    .mun-card:hover {
        background-color: #e6f3ff !important;
    }
</style>

<div class="container py-4">
    <div class="card shadow-sm rounded-4 p-4 border-0">
        <h4 class="fw-bold mb-4">Districts & Municipalities under {{ $province->province_name }}</h4>

        <div class="row">
            @forelse($municipalityData as $item)
                <div class="col-md-6 col-lg-4 mb-4">
                   <a href="{{ route('admin.schools.filtered', ['municipality_id' => $item['municipality_id'], 'district_id' => $item['district_id']]) }}" class="text-decoration-none">
                        <div class="card mun-card shadow-sm h-100 border-0">
                            <div class="card-body py-4 px-4">
                                <h6 class="fw-semibold text-dark mb-1">{{ $item['district_name'] }}</h6>
                                <p class="text-dark mb-0">{{ $item['municipality_name'] }}</p>
                            </div>
                        </div>
                    </a>

                                    </div>
            @empty
                <div class="col-12 text-center text-muted">
                    No municipalities or districts found under this province.
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="text-muted small">
                Showing {{ $municipalityData->firstItem() }} to {{ $municipalityData->lastItem() }} of {{ $municipalityData->total() }} results
            </div>
            <div>
                {{ $municipalityData->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
