@extends('weViewer::layout')

@section('title', 'Logs - weViewer')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">
        <i class="bi bi-file-text text-primary me-2"></i>
        Application Logs
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
                <h4 class="text-primary">{{ count($logFiles) }}</h4>
                <small class="text-muted">Log Files</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <h4 class="text-success">{{ number_format(array_sum(array_column($logFiles, 'size')) / 1024, 1) }} KB</h4>
                <small class="text-muted">Total Size</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <h4 class="text-info">{{ storage_path('logs') }}</h4>
                <small class="text-muted">Logs Directory</small>
            </div>
        </div>
    </div>
</div>

<!-- Log Files -->
<div class="card">
    <div class="card-header bg-white">
        <h5 class="card-title mb-0">
            <i class="bi bi-list-ul me-2"></i>
            Log Files
        </h5>
    </div>
    <div class="card-body p-0">
        @if(count($logFiles) > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3">
                                <i class="bi bi-file-text me-1"></i>
                                File Name
                            </th>
                            <th class="px-4 py-3 text-center">
                                <i class="bi bi-hdd me-1"></i>
                                Size
                            </th>
                            <th class="px-4 py-3 text-center">
                                <i class="bi bi-clock me-1"></i>
                                Last Modified
                            </th>
                            <th class="px-4 py-3 text-center">
                                <i class="bi bi-gear me-1"></i>
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logFiles as $logFile)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-warning bg-opacity-10 rounded p-2 me-3">
                                        <i class="bi bi-file-text text-warning"></i>
                                    </div>
                                    <div>
                                        <strong>{{ $logFile['name'] }}</strong>
                                        <br>
                                        <small class="text-muted">Log file</small>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="badge bg-info bg-opacity-10 text-info px-3 py-2">
                                    {{ number_format($logFile['size'] / 1024, 1) }} KB
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">
                                    {{ date('M d, Y H:i', $logFile['modified']) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-outline-primary" 
                                            onclick="viewLog('{{ $logFile['name'] }}')" 
                                            title="View Log">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-success" 
                                            onclick="downloadLog('{{ $logFile['name'] }}')" 
                                            title="Download Log">
                                        <i class="bi bi-download"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                            onclick="deleteLog('{{ $logFile['name'] }}')" 
                                            title="Delete Log">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-file-text text-muted" style="font-size: 3rem;"></i>
                <h5 class="mt-3 text-muted">No Log Files Found</h5>
                <p class="text-muted">No log files are available in the storage/logs directory.</p>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
function viewLog(filename) {
    window.location.href = '/weviewer/logs/view/' + filename;
}

function downloadLog(filename) {
    window.location.href = '/weviewer/logs/download/' + filename;
}

function deleteLog(filename) {
    if (confirm('Are you sure you want to delete ' + filename + '?\n\nThis action cannot be undone.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/weviewer/logs/delete/' + filename;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);
        
        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    }
}
</script>
@endsection