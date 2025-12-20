@extends('weViewer::layout')

@section('title', 'Routes - weViewer')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">
        <i class="bi bi-signpost text-primary me-2"></i>
        Application Routes
    </h1>
    <div>
        <button class="btn btn-outline-primary" onclick="location.reload()">
            <i class="bi bi-arrow-clockwise me-1"></i>
            Refresh
        </button>
    </div>
</div>

<!-- Stats -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <h4 class="text-primary">{{ count($routes) }}</h4>
                <small class="text-muted">Total Routes</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <h4 class="text-success">{{ count(array_filter($routes, fn($r) => $r['name'])) }}</h4>
                <small class="text-muted">Named Routes</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <h4 class="text-info">{{ count(array_unique(array_column($routes, 'middleware'))) }}</h4>
                <small class="text-muted">Middleware Groups</small>
            </div>
        </div>
    </div>
</div>

<!-- Search and Controls -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-8">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" class="form-control" id="routeSearch" placeholder="Search routes...">
                </div>
            </div>
            <div class="col-md-4">
                <select name="per_page" class="form-select" onchange="this.form.submit()">
                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 per page</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 per page</option>
                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 per page</option>
                </select>
            </div>
        </form>
    </div>
</div>

<!-- Routes Table -->
<div class="card">
    <div class="card-header bg-white">
        <h5 class="card-title mb-0">
            <i class="bi bi-list-ul me-2"></i>
            Routes List @if(!empty($pagination))({{ $pagination['from'] ?? 0 }}-{{ $pagination['to'] ?? 0 }} of {{ $pagination['total'] ?? 0 }})@endif
        </h5>
    </div>
    <div class="card-body p-0">
        @if(count($routes) > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="routesTable">
                    <thead class="table-light">
                        <tr>
                            <th class="px-3 py-3">Method</th>
                            <th class="px-3 py-3">URI</th>
                            <th class="px-3 py-3">Name</th>
                            <th class="px-3 py-3">Action</th>
                            <th class="px-3 py-3">File</th>
                            <th class="px-3 py-3">Middleware</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($routes as $route)
                        <tr class="route-row">
                            <td class="px-3 py-2">
                                <span class="badge bg-primary">{{ $route['methods'] }}</span>
                            </td>
                            <td class="px-3 py-2">
                                <code class="route-uri">{{ $route['uri'] }}</code>
                            </td>
                            <td class="px-3 py-2">
                                <span class="route-name">{{ $route['name'] ?: '-' }}</span>
                            </td>
                            <td class="px-3 py-2">
                                <small class="text-muted route-action">{{ $route['action'] }}</small>
                            </td>
                            <td class="px-3 py-2">
                                <span class="badge bg-secondary route-file">{{ $route['file'] }}</span>
                            </td>
                            <td class="px-3 py-2">
                                <small class="text-muted route-middleware">{{ $route['middleware'] ?: '-' }}</small>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-signpost text-muted" style="font-size: 3rem;"></i>
                <h5 class="mt-3 text-muted">No Routes Found</h5>
                <p class="text-muted">No routes are available.</p>
            </div>
            
            @if(!empty($pagination) && $pagination['last_page'] > 1)
            <div class="card-footer bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Showing {{ $pagination['from'] }} to {{ $pagination['to'] }} of {{ $pagination['total'] }} results
                    </div>
                    <div>
                        <nav>
                            <ul class="pagination mb-0">
                                @if($pagination['current_page'] > 1)
                                <li class="page-item">
                                    <a class="page-link" href="?page={{ $pagination['current_page'] - 1 }}&per_page={{ $pagination['per_page'] }}">Previous</a>
                                </li>
                                @endif
                                
                                @for($i = max(1, $pagination['current_page'] - 2); $i <= min($pagination['last_page'], $pagination['current_page'] + 2); $i++)
                                <li class="page-item {{ $i == $pagination['current_page'] ? 'active' : '' }}">
                                    <a class="page-link" href="?page={{ $i }}&per_page={{ $pagination['per_page'] }}">{{ $i }}</a>
                                </li>
                                @endfor
                                
                                @if($pagination['current_page'] < $pagination['last_page'])
                                <li class="page-item">
                                    <a class="page-link" href="?page={{ $pagination['current_page'] + 1 }}&per_page={{ $pagination['per_page'] }}">Next</a>
                                </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            @endif
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
// Search functionality
document.getElementById('routeSearch').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('#routesTable tbody tr');
    
    rows.forEach(row => {
        const uri = row.querySelector('.route-uri').textContent.toLowerCase();
        const name = row.querySelector('.route-name').textContent.toLowerCase();
        const action = row.querySelector('.route-action').textContent.toLowerCase();
        
        if (uri.includes(searchTerm) || name.includes(searchTerm) || action.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>
@endsection