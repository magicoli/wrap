# Core - Foundation Classes

Core application infrastructure and utilities.

## What goes here:
- ✅ **Application bootstrap** (`application.php`)
- ✅ **Configuration management** (`config.php`)
- ✅ **Dependency injection** (`container.php`) 
- ✅ **Caching system** (`cache.php`)
- ✅ **File system utilities** (`file_system.php`)
- ✅ **URL routing** (`router.php` - for modern features)
- ✅ **Zip generation** (`zip_generator.php`)

## What doesn't go here:
- ❌ **Data models** (go in `../data/`)
- ❌ **Authentication logic** (go in `../auth/`)
- ❌ **API endpoints** (go in `../api/`)
- ❌ **Media processing** (go in `../data/`)

## Examples:
- `application.php` - Main application bootstrap
- `config.php` - Configuration management with environment support
- `container.php` - Simple dependency injection container
- `cache.php` - Smart cache invalidation for updated files
- `file_system.php` - File operations, path handling, directory utilities
