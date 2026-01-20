# weViewer - Composer Installation Guide

If you're experiencing session issues when installing via Composer, follow these steps:

## 1. Ensure Session Configuration

Make sure your Laravel project has proper session configuration in `config/session.php`:

```php
'driver' => env('SESSION_DRIVER', 'file'),
'lifetime' => env('SESSION_LIFETIME', 120),
'expire_on_close' => false,
'encrypt' => false,
'files' => storage_path('framework/sessions'),
'connection' => env('SESSION_CONNECTION'),
'table' => 'sessions',
'store' => env('SESSION_STORE'),
'lottery' => [2, 100],
'cookie' => env('SESSION_COOKIE', Str::slug(env('APP_NAME', 'laravel'), '_').'_session'),
'path' => '/',
'domain' => env('SESSION_DOMAIN'),
'secure' => env('SESSION_SECURE_COOKIE'),
'http_only' => true,
'same_site' => 'lax',
```

## 2. Environment Variables

Add these to your `.env` file:

```env
WEVIEWER_ENABLED=true
WEVIEWER_SECURITY_KEY=your-secure-password
SESSION_DRIVER=file
SESSION_LIFETIME=120
```

## 3. Clear Cache

After installation, run:

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

## 4. Publish Config (Optional)

```bash
php artisan vendor:publish --provider="Atifrazzaq\WeViewer\Providers\WeViewerServiceProvider" --tag="config"
```

## 5. Verify Session Directory

Ensure the session directory exists and is writable:

```bash
mkdir -p storage/framework/sessions
chmod 755 storage/framework/sessions
```

## Troubleshooting

If sessions still don't work:

1. Check if `storage/framework/sessions` directory exists and is writable
2. Verify your web server has write permissions to the storage directory
3. Try using database sessions instead of file sessions
4. Check Laravel logs for any session-related errors

## Database Sessions (Alternative)

If file sessions don't work, switch to database sessions:

1. Create sessions table:
```bash
php artisan session:table
php artisan migrate
```

2. Update `.env`:
```env
SESSION_DRIVER=database
```

3. Clear config:
```bash
php artisan config:clear
```