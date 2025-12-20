@extends('weViewer::layout')

@section('title', 'Dashboard - weViewer')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">
        <i class="bi bi-speedometer2 text-primary me-2"></i>
        Dashboard
    </h1>
    <div class="text-muted">
        <i class="bi bi-clock me-1"></i>
        {{ now()->format('M d, Y - H:i') }}
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 small">Total Tables</div>
                        <div class="h4 mb-0 text-white">{{ $stats['total_tables'] }}</div>
                    </div>
                    <div class="text-white-50">
                        <i class="bi bi-table fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 small">Total Records</div>
                        <div class="h4 mb-0 text-white">{{ number_format($stats['total_records']) }}</div>
                    </div>
                    <div class="text-white-50">
                        <i class="bi bi-collection fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 small">Database Size</div>
                        <div class="h4 mb-0 text-white">{{ $stats['database_size'] }}</div>
                    </div>
                    <div class="text-white-50">
                        <i class="bi bi-hdd fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 small">Active Connections</div>
                        <div class="h4 mb-0 text-white">{{ $stats['active_connections'] }}</div>
                    </div>
                    <div class="text-white-50">
                        <i class="bi bi-plug fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-lightning text-warning me-2"></i>
                    Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('weviewer.tables') }}" class="btn btn-outline-primary w-100">
                            <i class="bi bi-table me-2"></i>
                            View Tables
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <button class="btn btn-outline-success w-100" onclick="refreshStats()">
                            <i class="bi bi-arrow-clockwise me-2"></i>
                            Refresh Stats
                        </button>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('weviewer.export.database') }}" class="btn btn-outline-info w-100">
                            <i class="bi bi-download me-2"></i>
                            Export Data
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('weviewer.logs') }}" class="btn btn-outline-warning w-100">
                            <i class="bi bi-file-text me-2"></i>
                            View Logs
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-activity text-success me-2"></i>
                    System Overview
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-4 mb-3">
                        <div class="border-end">
                            <h4 class="text-primary">{{ $stats['total_tables'] }}</h4>
                            <small class="text-muted">Database Tables</small>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="border-end">
                            <h4 class="text-success">{{ number_format($stats['total_records']) }}</h4>
                            <small class="text-muted">Total Records</small>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <h4 class="text-info">{{ $stats['database_size'] }}</h4>
                        <small class="text-muted">Storage Used</small>
                    </div>
                </div>
                
                <hr>
                
                <div class="alert alert-info mb-0">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Welcome to weViewer!</strong> 
                    Your database management dashboard is ready. Use the navigation to explore tables and manage your data.
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-info-square text-info me-2"></i>
                    System Info
                </h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <strong>PHP Version:</strong> {{ PHP_VERSION }}
                    </li>
                    <li class="mb-2">
                        <strong>Laravel Version:</strong> {{ app()->version() }}
                    </li>
                    <li class="mb-2">
                        <strong>Database:</strong> {{ config('database.default') }}
                    </li>
                    <li class="mb-2">
                        <strong>Database Engine:</strong> {{ $stats['database_engine'] }}
                    </li>
                    <li class="mb-2">
                        <strong>Environment:</strong> 
                        <span class="badge bg-{{ app()->environment() === 'production' ? 'success' : 'warning' }}">
                            {{ ucfirst(app()->environment()) }}
                        </span>
                    </li>
                    <li class="mb-2">
                        <strong>Operating System:</strong> {{ PHP_OS }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function refreshStats() {
    // Show loading state
    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="bi bi-arrow-clockwise me-2 spin"></i>Refreshing...';
    btn.disabled = true;
    
    // Simulate refresh (in real implementation, you'd make an AJAX call)
    setTimeout(() => {
        location.reload();
    }, 1000);
}

// Add spinning animation for refresh button
document.head.insertAdjacentHTML('beforeend', `
    <style>
        .spin {
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
    </style>
`);
</script>
@endsection