@extends('weViewer::layout')

@section('title', 'Log: ' . $filename . ' - weViewer')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ route('weviewer.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('weviewer.logs') }}">Logs</a></li>
                <li class="breadcrumb-item active">{{ $filename }}</li>
            </ol>
        </nav>
        <h1 class="h3 mb-0">
            <i class="bi bi-file-text text-primary me-2"></i>
            {{ $filename }}
        </h1>
    </div>
    <div>
        <a href="{{ route('weviewer.logs') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Back to Logs
        </a>
    </div>
</div>

<!-- Controls -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Number of lines to show (from end)</label>
                <input type="number" class="form-control" name="lines" value="{{ $lines }}" min="1" max="10000">
            </div>
            <div class="col-md-6 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="bi bi-arrow-clockwise me-1"></i>
                    Refresh
                </button>
                <button type="button" class="btn btn-success" id="liveToggle" onclick="toggleLive()">
                    <i class="bi bi-play me-1"></i>
                    Start Live
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Log Content -->
<div class="card">
    <div class="card-header bg-white">
        <h5 class="card-title mb-0">
            <i class="bi bi-terminal me-2"></i>
            Log Content (Last {{ count($logLines) }} lines)
            <span id="liveStatus" class="badge bg-secondary ms-2" style="display: none;">Live</span>
        </h5>
    </div>
    <div class="card-body p-0">
        @if(count($logLines) > 0)
            <div id="logContainer" style="background: #1e1e1e; color: #d4d4d4; font-family: 'Courier New', monospace; font-size: 12px; max-height: 600px; overflow-y: auto;">
                <pre class="p-3 mb-0" id="logContent">@foreach($logLines as $index => $line){{ trim($line) }}
@endforeach</pre>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-file-text text-muted" style="font-size: 3rem;"></i>
                <h5 class="mt-3 text-muted">Log File is Empty</h5>
                <p class="text-muted">This log file contains no content.</p>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
let liveInterval = null;
let isLive = false;

// Auto-scroll to bottom of log content
function scrollToBottom() {
    const logContainer = document.getElementById('logContainer');
    if (logContainer) {
        logContainer.scrollTop = logContainer.scrollHeight;
    }
}

// Toggle live log viewing
function toggleLive() {
    const button = document.getElementById('liveToggle');
    const status = document.getElementById('liveStatus');
    
    if (isLive) {
        // Stop live
        clearInterval(liveInterval);
        isLive = false;
        button.innerHTML = '<i class="bi bi-play me-1"></i>Start Live';
        button.className = 'btn btn-success';
        status.style.display = 'none';
    } else {
        // Start live
        isLive = true;
        button.innerHTML = '<i class="bi bi-stop me-1"></i>Stop Live';
        button.className = 'btn btn-danger';
        status.style.display = 'inline';
        
        liveInterval = setInterval(function() {
            const lines = document.querySelector('input[name="lines"]').value || 50;
            fetch('/weviewer/logs/tail/{{ $filename }}?lines=' + lines)
                .then(response => response.json())
                .then(data => {
                    if (data.lines) {
                        document.getElementById('logContent').textContent = data.lines.join('\n');
                        scrollToBottom();
                    }
                })
                .catch(error => console.error('Error fetching logs:', error));
        }, 2000); // Update every 2 seconds
    }
}

document.addEventListener('DOMContentLoaded', function() {
    scrollToBottom();
});
</script>
@endsection