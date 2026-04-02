@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Welcome Section -->
    <div class="row mb-5 align-items-center">
        <div class="col-md-8">
            <h1 class="display-5 fw-bold text-dark">Welcome back, Learner! 👋</h1>
            <p class="lead text-muted">Ready to expand your vocabulary today?</p>
        </div>
        <div class="col-md-4 text-md-end">
            <div class="date-badge p-3 bg-white rounded shadow-sm d-inline-block">
                <i class="far fa-calendar-alt text-primary me-2"></i> {{ date('l, F j, Y') }}
            </div>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row g-4 mb-5">
        <!-- Total Words -->
        <div class="col-md-4">
            <div class="card h-100 border-0 bg-primary text-white overflow-hidden position-relative">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="bg-white bg-opacity-25 rounded-circle p-2">
                            <i class="fas fa-book fa-2x"></i>
                        </div>
                    </div>
                    <h5 class="card-title opacity-75">Total Words Learned</h5>
                    <h2 class="display-4 fw-bold mb-0">{{ $totalWords }}</h2>
                </div>
                <!-- Decor -->
                <i class="fas fa-book position-absolute" style="font-size: 10rem; right: -20px; bottom: -20px; opacity: 0.1;"></i>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="col-md-8">
            <div class="card h-100 border-0">
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold mb-4">Learning Progress</h5>
                    <div style="height: 200px;">
                        <canvas id="learningChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Quick Actions -->
        <div class="col-md-6">
            <div class="card h-100 border-0">
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold mb-4">Quick Actions</h5>
                    <div class="d-grid gap-3">
                        <a href="{{ route('vocabularies.create') }}" class="btn btn-light btn-lg text-start shadow-sm border">
                            <i class="fas fa-plus-circle text-success me-3"></i> Add New Word
                        </a>
                        <a href="{{ route('vocabularies.flashcards') }}" class="btn btn-light btn-lg text-start shadow-sm border">
                            <i class="fas fa-layer-group text-warning me-3"></i> Practice Flashcards
                        </a>
                        <a href="{{ route('vocabularies.quiz') }}" class="btn btn-light btn-lg text-start shadow-sm border">
                            <i class="fas fa-brain text-info me-3"></i> Take a Quiz
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Words -->
        <!-- Recent Words -->
                <div class="card border-0 shadow-sm h-100 rounded-4">
                    <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-dark">Recently Added</h5>
                        <a href="{{ route('vocabularies.index') }}" class="btn btn-link text-decoration-none p-0 fw-bold small">View All</a>
                    </div>
                    <div class="card-body p-0">
                        @if($recentWords->isEmpty())
                            <div class="text-center py-5">
                                <i class="fas fa-inbox fa-3x mb-3 text-muted opacity-25"></i>
                                <p class="text-muted mb-0">No words added yet.</p>
                            </div>
                        @else
                            <div class="list-group list-group-flush rounded-bottom-4">
                                @foreach($recentWords as $word)
                                    <div class="list-group-item px-4 py-2 border-0 hover-bg-light transition-all">
                                        <div class="row align-items-center gx-3">
                                            <!-- Avatar -->
                                            <div class="col-auto">
                                                <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px; font-size: 1rem;">
                                                    {{ strtoupper(substr($word->word, 0, 1)) }}
                                                </div>
                                            </div>
                                            
                                            <!-- Content -->
                                            <div class="col overflow-hidden">
                                                <div class="d-flex justify-content-between align-items-baseline">
                                                    <h6 class="mb-0 fw-bold text-dark text-truncate">{{ $word->word }}</h6>
                                                    <small class="text-muted ms-2" style="font-size: 0.75rem;">{{ $word->created_at->diffForHumans(null, true) }}</small>
                                                </div>
                                                <p class="mb-0 text-muted small text-truncate text-opacity-75" style="font-size: 0.85rem;">
                                                    {{ $word->meaning }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
    </div>
</div>

<script>
    const ctx = document.getElementById('learningChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Today'],
            datasets: [{
                label: 'Words Learned',
                data: [1, 3, 5, 2, 4, {{ $totalWords }}], // Dummy history + current total
                borderColor: '#6c5ce7',
                backgroundColor: 'rgba(108, 92, 231, 0.1)',
                fill: true,
                tension: 0.4,
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        borderDash: [5, 5]
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
</script>
@endsection
