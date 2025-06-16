# CLI - Command Line Tools

Command line utilities using the engine processing layer.

## Architecture:
- **Independent**: Has its own `composer.json` and `vendor/` directory
- **Engine integration**: Loads engine via `../engine/autoload.php`
- **Future repository**: Ready to be split into separate git repository
- **Symfony Console**: Professional CLI framework

## Installation:
```bash
cd cli/
composer install
chmod +x wrap-cli.php
```

## Usage:

Single executable: `wrap command [options]`

Example implementations:
```bash
./cli/wrap-cli.php list
./cli/wrap-cli.php media:convert video.mov --format=mp4
./cli/wrap-cli.php cache:clear --type=thumbnails
```

## What goes here:
- ✅ **Media processing** (`Command/MediaConvertCommand.php` - batch operations)
- ✅ **Cache management** (`Command/CacheClearCommand.php` - cache cleanup)
- ✅ **User management** (`Command/UserInviteCommand.php` - admin utilities)
- ✅ **Maintenance tools** (`Command/MaintenanceCommand.php` - system cleanup)

## What doesn't go here:
- ❌ **Web interfaces** (go in `webui/`)
- ❌ **Business logic** (use classes from `engine/`)
- ❌ **Legacy shell scripts** (convert to PHP or eliminate)

## Migration from bin/:
Most current shell scripts will disappear. Everything related to server-side processing must be converted to PHP replacements and included in the web workflow. Only essential tasks remain as CLI commands.

## Command structure:
- **Namespace**: `Wrap\Cli\Command\`
- **File naming**: `{Feature}Command.php`
- **Class naming**: `{Feature}Command extends Command`
