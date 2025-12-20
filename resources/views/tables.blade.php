@extends('weViewer::layout')

@section('title', 'Tables - weViewer')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">
        <i class="bi bi-table text-primary me-2"></i>
        Database Tables
    </h1>
    <div>
        <button class="btn btn-outline-primary me-2" onclick="refreshTables()">
            <i class="bi bi-arrow-clockwise me-1"></i>
            Refresh
        </button>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exportModal">
            <i class="bi bi-download me-1"></i>
            Export
        </button>
    </div>
</div>

<!-- Tables Overview -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <h4 class="text-primary">{{ count($tables) }}</h4>
                <small class="text-muted">Total Tables</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <h4 class="text-success">{{ number_format(array_sum(array_column($tables, 'rows'))) }}</h4>
                <small class="text-muted">Total Rows</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <h4 class="text-info">{{ array_sum(array_column($tables, 'columns')) }}</h4>
                <small class="text-muted">Total Columns</small>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" class="form-control" id="tableSearch" placeholder="Search tables...">
                </div>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="sortBy">
                    <option value="name">Sort by Name</option>
                    <option value="rows">Sort by Rows</option>
                    <option value="columns">Sort by Columns</option>
                    <option value="size">Sort by Size</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="sortOrder">
                    <option value="asc">Ascending</option>
                    <option value="desc">Descending</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="per_page" class="form-select" onchange="this.form.submit()">
                    <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15 per page</option>
                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 per page</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 per page</option>
                </select>
            </div>
        </form>
    </div>
</div>

<!-- Tables List -->
<div class="card">
    <div class="card-header bg-white">
        <h5 class="card-title mb-0">
            <i class="bi bi-list-ul me-2"></i>
            Tables List @if(!empty($pagination))({{ $pagination['from'] ?? 0 }}-{{ $pagination['to'] ?? 0 }} of {{ $pagination['total'] ?? 0 }})@endif
        </h5>
    </div>
    <div class="card-body p-0">
        @if(count($tables) > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="tablesTable">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3">
                                <i class="bi bi-table me-1"></i>
                                Table Name
                            </th>
                            <th class="px-4 py-3 text-center">
                                <i class="bi bi-collection me-1"></i>
                                Rows
                            </th>
                            <th class="px-4 py-3 text-center">
                                <i class="bi bi-columns me-1"></i>
                                Columns
                            </th>
                            <th class="px-4 py-3 text-center">
                                <i class="bi bi-hdd me-1"></i>
                                Size
                            </th>
                            <th class="px-4 py-3 text-center">
                                <i class="bi bi-gear me-1"></i>
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tables as $table)
                        <tr class="table-row">
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 rounded p-2 me-3">
                                        <i class="bi bi-table text-primary"></i>
                                    </div>
                                    <div>
                                        <strong class="table-name">{{ $table['name'] }}</strong>
                                        <br>
                                        <small class="text-muted">Database table</small>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">
                                    {{ number_format($table['rows']) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="badge bg-info bg-opacity-10 text-info px-3 py-2">
                                    {{ $table['columns'] }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2">
                                    {{ $table['size'] }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-outline-primary" 
                                            onclick="viewTable('{{ $table['name'] }}')" 
                                            title="View Table">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-info" 
                                            onclick="showTableInfo('{{ $table['name'] }}')" 
                                            title="Table Info">
                                        <i class="bi bi-info-circle"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-success" 
                                            onclick="exportTable('{{ $table['name'] }}')" 
                                            title="Export Table">
                                        <i class="bi bi-download"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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
        @else
            <div class="text-center py-5">
                <i class="bi bi-table text-muted" style="font-size: 3rem;"></i>
                <h5 class="mt-3 text-muted">No Tables Found</h5>
                <p class="text-muted">There are no tables in the current database.</p>
            </div>
        @endif
    </div>
</div>

<!-- Export Modal -->
<div class="modal fade" id="exportModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-download me-2"></i>
                    Export Tables
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Export Format</label>
                    <select class="form-select" id="exportFormat">
                        <option value="sql">SQL</option>
                        <option value="csv">CSV</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Select Tables</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="selectAll">
                        <label class="form-check-label" for="selectAll">
                            Select All Tables
                        </label>
                    </div>
                    <hr>
                    @foreach($tables as $table)
                    <div class="form-check">
                        <input class="form-check-input table-checkbox" type="checkbox" value="{{ $table['name'] }}" id="table_{{ $loop->index }}">
                        <label class="form-check-label" for="table_{{ $loop->index }}">
                            {{ $table['name'] }} ({{ number_format($table['rows']) }} rows)
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="exportSelected()">
                    <i class="bi bi-download me-1"></i>
                    Export Selected
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Search functionality
document.getElementById('tableSearch').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('#tablesTable tbody tr');
    
    rows.forEach(row => {
        const tableName = row.querySelector('.table-name').textContent.toLowerCase();
        if (tableName.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Sort functionality
document.getElementById('sortBy').addEventListener('change', sortTable);
document.getElementById('sortOrder').addEventListener('change', sortTable);

function sortTable() {
    const sortBy = document.getElementById('sortBy').value;
    const sortOrder = document.getElementById('sortOrder').value;
    const tbody = document.querySelector('#tablesTable tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    
    rows.sort((a, b) => {
        let aVal, bVal;
        
        switch(sortBy) {
            case 'name':
                aVal = a.querySelector('.table-name').textContent;
                bVal = b.querySelector('.table-name').textContent;
                break;
            case 'rows':
                aVal = parseInt(a.cells[1].textContent.replace(/,/g, ''));
                bVal = parseInt(b.cells[1].textContent.replace(/,/g, ''));
                break;
            case 'columns':
                aVal = parseInt(a.cells[2].textContent);
                bVal = parseInt(b.cells[2].textContent);
                break;
            case 'size':
                aVal = parseFloat(a.cells[3].textContent);
                bVal = parseFloat(b.cells[3].textContent);
                break;
        }
        
        if (sortOrder === 'asc') {
            return aVal > bVal ? 1 : -1;
        } else {
            return aVal < bVal ? 1 : -1;
        }
    });
    
    rows.forEach(row => tbody.appendChild(row));
}

// Table actions
function viewTable(tableName) {
    window.location.href = '/weviewer/table/' + tableName;
}

function showTableInfo(tableName) {
    alert('Table info: ' + tableName + '\n(This would show detailed table information)');
}

function exportTable(tableName) {
    window.location.href = '/weviewer/table/' + tableName + '/export?format=sql';
}

function refreshTables() {
    const btn = event.target.closest('button');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="bi bi-arrow-clockwise me-1 spin"></i>Refreshing...';
    btn.disabled = true;
    
    setTimeout(() => {
        location.reload();
    }, 1000);
}

// Export modal functionality
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.table-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

// Export selected tables
function exportSelected() {
    const format = document.getElementById('exportFormat').value;
    const selectedTables = Array.from(document.querySelectorAll('.table-checkbox:checked')).map(cb => cb.value);
    
    if (selectedTables.length === 0) {
        alert('Please select at least one table to export.');
        return;
    }
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '/weviewer/export-multiple';
    
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = '{{ csrf_token() }}';
    form.appendChild(csrfToken);
    
    const formatInput = document.createElement('input');
    formatInput.type = 'hidden';
    formatInput.name = 'format';
    formatInput.value = format;
    form.appendChild(formatInput);
    
    selectedTables.forEach(table => {
        const tableInput = document.createElement('input');
        tableInput.type = 'hidden';
        tableInput.name = 'tables[]';
        tableInput.value = table;
        form.appendChild(tableInput);
    });
    
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}

// Add spinning animation
document.head.insertAdjacentHTML('beforeend', `
    <style>
        .spin {
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .table-row:hover {
            background-color: rgba(0,123,255,0.05);
        }
    </style>
`);
</script>
@endsection