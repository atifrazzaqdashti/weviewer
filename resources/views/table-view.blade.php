@extends('weViewer::layout')

@section('title', 'Table: ' . $tableName . ' - weViewer')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ route('weviewer.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('weviewer.tables') }}">Tables</a></li>
                <li class="breadcrumb-item active">{{ $tableName }}</li>
            </ol>
        </nav>
        <h1 class="h3 mb-0">
            <i class="bi bi-table text-primary me-2"></i>
            {{ $tableName }}
        </h1>
    </div>
    <div>
        <a href="{{ route('weviewer.table.export', $tableName) }}?format=csv" class="btn btn-outline-success me-2">
            <i class="bi bi-download me-1"></i>
            Export CSV
        </a>
        <a href="{{ route('weviewer.tables') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Back
        </a>
    </div>
</div>

<!-- Stats -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <h4 class="text-primary">{{ $records->total() }}</h4>
                <small class="text-muted">Total Records</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <h4 class="text-success">{{ count($columns) }}</h4>
                <small class="text-muted">Columns</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <h4 class="text-info">{{ $records->currentPage() }}/{{ $records->lastPage() }}</h4>
                <small class="text-muted">Current Page</small>
            </div>
        </div>
    </div>
</div>

<!-- Search and Controls -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" class="form-control" name="search" 
                           value="{{ request('search') }}" placeholder="Search records...">
                </div>
            </div>
            <div class="col-md-3">
                <select name="per_page" class="form-select">
                    <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15 per page</option>
                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 per page</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 per page</option>
                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 per page</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search me-1"></i>
                    Search
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Records Table -->
<div class="card">
    <div class="card-header bg-white">
        <h5 class="card-title mb-0">
            <i class="bi bi-list-ul me-2"></i>
            Records ({{ $records->firstItem() ?? 0 }}-{{ $records->lastItem() ?? 0 }} of {{ $records->total() }})
        </h5>
    </div>
    <div class="card-body p-0">
        @if($records->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            @foreach($columns as $column)
                            <th class="px-3 py-3">{{ $column }}</th>
                            @endforeach
                            <th class="px-3 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($records as $record)
                        <tr>
                            @foreach($columns as $column)
                            <td class="px-3 py-2">
                                @php
                                    $value = $record->$column ?? '';
                                    if (is_string($value) && strlen($value) > 50) {
                                        $value = substr($value, 0, 50) . '...';
                                    }
                                @endphp
                                <span title="{{ $record->$column ?? '' }}">{{ $value }}</span>
                            </td>
                            @endforeach
                            <td class="px-3 py-2 text-center">
                                <a href="{{ route('weviewer.table.export-row', [$tableName, $record->{$columns[0]}]) }}" 
                                   class="btn btn-sm btn-outline-primary download-sql" 
                                   title="Download SQL for this row"
                                   target="_blank">
                                    <i class="bi bi-download"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                <h5 class="mt-3 text-muted">No Records Found</h5>
                <p class="text-muted">
                    @if(request('search'))
                        No records match your search criteria.
                        <a href="{{ route('weviewer.table.view', $tableName) }}" class="btn btn-sm btn-outline-primary ms-2">Clear Search</a>
                    @else
                        This table is empty.
                    @endif
                </p>
            </div>
        @endif
    </div>
    
    @if($records->hasPages())
    <div class="card-footer bg-white">
        <div class="d-flex justify-content-between align-items-center">
            <div class="text-muted small">
                Showing {{ $records->firstItem() ?? 0 }} to {{ $records->lastItem() ?? 0 }} of {{ $records->total() }} results
            </div>
            <div>
                {{ $records->links() }}
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
// Auto-submit form when per_page changes
document.querySelector('select[name="per_page"]').addEventListener('change', function() {
    this.form.submit();
});

// Clear search
function clearSearch() {
    window.location.href = '{{ route("weviewer.table.view", $tableName) }}';
}
</script>
@endsection