# CLI - Command Line Tools

Command line utilities using the engine processing layer.

## What goes here:
- ✅ **Media processing** (`wrap-cli [makemp4|makethumb|merge|...] <args>` - batch operations)
- ✅ **Cache management** (`wrap-cli cache <command>` - cache cleanup)
- ✅ **User management** (`wrap-cli user <command> <args>` - admin utilities)
- ✅ **Maintenance tools** (`wrap-cli clean <args>` - system cleanup)

## What doesn't go here:
- ❌ **Web interfaces** (go in `webui/`)
- ❌ **Business logic** (use classes from `engine/`)
- ❌ **Legacy shell scripts** (convert to PHP or eliminate)

## Key principles:
- **Symfony Console** - Modern CLI framework
- **Engine integration** - Uses `engine/` classes for processing
- **Cross-platform** - PHP-based, works on Windows/Linux/macOS
- **Batch processing** - Handles large operations efficiently
- **Progress tracking** - User feedback for long operations

## Migration from bin/:
Most current shell scripts will disappear.

- Everything related to server-side processing must be converted to 
PHP replacements and included in the web workflow.
- Everything related to client-server sync will become obsolete as
the web workflow is effective.

Some usefull web functionalties will be available in command-line 
through a single CLI executable, with the task and parameters 
as argument, e.g. current makemp4 script would become a method
in PHP, but also be available via  `wrap-cli makemp4 <files...>`

## Target architecture:
Single executable: `wrap command [options]`
```bash
wrap media:process --directory=/path/to/videos
wrap cache:clear
wrap sync:directory --source=/local --target=/remote
```

## Examples:

See above.
