# weViewer Laravel Package

A comprehensive Laravel package for database management, log monitoring, and application insights with a beautiful Bootstrap 5 interface.

## Features

- 📊 **Dashboard** - Database statistics and system information
- 🗃️ **Tables Management** - View, search, and export database tables
- 📝 **Log Viewer** - Monitor application logs with live tail functionality
- 🛣️ **Routes Inspector** - View all application routes
- 🔒 **Security** - Password-protected access
- 📱 **Responsive Design** - Bootstrap 5 with modern UI

## Installation

### Method 1: Local Package (Development)

1. Add the package to your Laravel project's `composer.json`:

```json
{
    "repositories": [
        {
            "type": "path",
            "url": "./packages/atifrazzaq/weViewer"
        }
    ],
    "require": {
        "atifrazzaq/weviewer": "dev-main"
    }
}
```

2. Run composer install:
```bash
composer install
```

### Method 2: Composer Package (Production)

```bash
composer require atifrazzaq/weviewer
```

## Configuration

1. **Publish the config file (optional):**
```bash
php artisan vendor:publish --provider="Atifrazzaq\WeViewer\Providers\WeViewerServiceProvider" --tag="config"
```

2. **Set environment variables in `.env`:**
```env
WEVIEWER_ENABLED=true
WEVIEWER_SECURITY_KEY=your-secure-password
```

3. **Clear config cache:**
```bash
php artisan config:clear
```

## Usage

1. Visit `/weviewer` in your Laravel application
2. Enter your security key when prompted
3. Explore your database and logs!

## Configuration Options

The package uses the following configuration options in `config/weViewer.php`:

- `enabled` - Enable/disable the package (default: `true`)
- `security_key` - Password for accessing weViewer (default: `weviewer123`)
- `theme` - UI theme (default: `light`)

## Environment Variables

```env
# Enable/disable weViewer
WEVIEWER_ENABLED=true

# Set your security password
WEVIEWER_SECURITY_KEY=your-secure-password
```

## Features Overview

### Dashboard (`/weviewer`)
- Database statistics (tables, records, size)
- System information (PHP, Laravel, OS)
- Quick action buttons
- Database engine information

### Tables (`/weviewer/tables`)
- List all database tables
- Search and sort functionality
- Export tables as SQL/CSV
- Pagination support
- View table records with search

### Logs (`/weviewer/logs`)
- View all log files from `storage/logs`
- Live log monitoring (tail -f functionality)
- Download and delete log files
- Adjustable line count display

### Routes (`/weviewer/routes`)
- View all application routes
- Search and filter routes
- Pagination support
- Route file information

## Security

- Password-protected access
- Session-based authentication
- CSRF protection
- Environment-based configuration

## Requirements

- PHP 8.2+
- Laravel 12.0+
- MySQL/PostgreSQL/SQLite database

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)

## Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## License

MIT License

## Support

For support, email atifrazzaqdashti@gmail.com or create an issue on GitHub.

## Changelog

### v1.0.0
- Initial release
- Dashboard with database statistics
- Tables management with export
- Log viewer with live tail
- Routes inspector
- Security authentication