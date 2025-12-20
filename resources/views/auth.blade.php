<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>weViewer - Access Required</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow">
                    <div class="card-body text-center p-5">
                        <div class="mb-4">
                            <i class="bi bi-shield-lock text-primary" style="font-size: 3rem;"></i>
                        </div>
                        <h4 class="mb-3">weViewer Access</h4>
                        <p class="text-muted mb-4">Enter the security key to access weViewer</p>
                        
                        @if(isset($error) && $error)
                        <div class="alert alert-danger" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            {{ $error }}
                        </div>
                        @endif
                        
                        <form method="GET" action="{{ route('weviewer.auth') }}">
                            <input type="hidden" name="redirect_url" value="{{ $redirectUrl ?? '' }}">
                            <div class="mb-3">
                                <input type="password" class="form-control" name="key" placeholder="Security Key" required autofocus>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-unlock me-2"></i>
                                Access weViewer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>