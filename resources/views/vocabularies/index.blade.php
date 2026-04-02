@extends('layouts.app')

@section('content')
<div class="container-fluid py-5" style="min-height: 100vh; background-color: #f8f9fa;">
    <div class="row mb-4 align-items-center px-4">
        <div class="col-md-6">
            <h2 class="fw-bold text-dark mb-0">My Vocabulary</h2>
            <p class="text-muted small">Manage and review your collection of words.</p>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="{{ route('vocabularies.create') }}" class="btn btn-primary btn-lg shadow-sm">
                <i class="fas fa-plus me-2"></i> Add New Word
            </a>
        </div>
    </div>

    <!-- Stats & Search -->
    <div class="row g-4 mb-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4">
                    <form action="{{ route('vocabularies.index') }}" method="GET" class="row g-3 align-items-center">
                        <div class="col-md-10">
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-light border-0"><i class="fas fa-search text-muted"></i></span>
                                <input type="text" name="search" class="form-control bg-light border-0" placeholder="Search words or meanings..." value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-2 d-grid">
                            @if(request('search'))
                                <a href="{{ route('vocabularies.index') }}" class="btn btn-outline-secondary btn-lg">Clear</a>
                            @else
                                <button type="submit" class="btn btn-dark btn-lg">Search</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Vocabulary Table -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-uppercase text-muted small fw-bold" style="width: 25%;">Word</th>
                        <th class="py-3 text-uppercase text-muted small fw-bold" style="width: 35%;">Meaning</th>
                        <th class="py-3 text-uppercase text-muted small fw-bold" style="width: 25%;">Example</th>
                        <th class="pe-4 py-3 text-uppercase text-muted small fw-bold text-end" style="width: 15%;">Actions</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($vocabularies as $vocabulary)
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center fw-bold me-3" style="width: 40px; height: 40px;">
                                        {{ strtoupper(substr($vocabulary->word, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $vocabulary->word }}</div>
                                        <small class="text-muted text-xs">Added {{ $vocabulary->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3">
                                <p class="mb-0 text-secondary text-truncate-2">{{ Str::limit($vocabulary->meaning, 80) }}</p>
                            </td>
                            <td class="py-3">
                                <p class="mb-0 text-muted fst-italic text-truncate-2 small">"{{ Str::limit($vocabulary->usage_example, 60) }}"</p>
                            </td>
                            <td class="pe-4 py-3 text-end">
                                <a href="{{ route('vocabularies.edit', $vocabulary->id) }}" class="btn btn-icon btn-light text-warning me-1" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('vocabularies.destroy', $vocabulary->id) }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-icon btn-light text-danger" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="py-4">
                                    <i class="fas fa-book-open fa-3x text-muted opacity-25 mb-3"></i>
                                    <h5 class="text-muted fw-normal">No vocabulary found</h5>
                                    <p class="text-muted small mb-3">Start building your collection today!</p>
                                    <a href="{{ route('vocabularies.create') }}" class="btn btn-sm btn-outline-primary">Add First Word</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .btn-icon {
        width: 35px;
        height: 35px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: all 0.2s;
    }
    .btn-icon:hover {
        transform: translateY(-2px);
        background-color: #e9ecef;
    }
    .text-truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteForms = document.querySelectorAll('.delete-form');
        
        deleteForms.forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                
                // Target the specific div that contains the full word (ignoring the avatar)
                const word = this.closest('tr').querySelector('.fw-bold.text-dark').textContent.trim();

                Swal.fire({
                    title: 'Delete "' + word + '"?',
                    text: "You won't be able to recover this word!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ff6b6b', // Soft Red
                    cancelButtonColor: '#6c5ce7', // Primary Purple
                    confirmButtonText: 'Yes, delete it!',
                    background: '#fff',
                    iconColor: '#ff6b6b',
                    customClass: {
                        popup: 'rounded-4 shadow-lg border-0'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });
    });
</script>
