# Models - Data Models and Business Logic

Data models and file/media processing classes.

## What goes here:
- ✅ **File handling** (`class-file.php` - variants, metadata, MIME types)
- ✅ **Directory operations** (`class-directory.php` - scanning, pattern matching)
- ✅ **Media processing** (`class-media.php`, `class-video.php`, `class-image.php`)
- ✅ **Playlist management** (`class-playlist.php` - collections, selections)
- ✅ **Client management** (`class-client.php` - project managers)
- ✅ **Project data** (`class-project.php` - user lists, permissions)

## What doesn't go here:
- ❌ **Web controllers** (go in `webui/`)
- ❌ **API endpoints** (go in `../api/`)
- ❌ **Authentication logic** (go in `../auth/`)
- ❌ **UI templates** (go in `webui/`)
- ❌ **Actual data files** (uploaded content, cache, generated files)

## File naming convention:
- **Class files**: `class-{classname}.php` (e.g., `class-file.php`)
- **Class names**: PascalCase (e.g., `Wrap\Models\File`)
- **PSR-4 autoloading**: `Wrap\Models\File` → `engine/models/class-file.php`

## Key responsibilities:
- **File operations** - Variant detection, metadata extraction
- **Media processing** - Thumbnail generation, video conversion
- **Directory scanning** - Pattern matching, file filtering
- **Data persistence** - File-based storage, future DB support

## Examples:
- `class-file.php` - `Wrap\Models\File` - Generic file handling with variant support
- `class-video.php` - `Wrap\Models\Video` - Video processing, thumbnail generation, parseAtom()
- `class-image.php` - `Wrap\Models\Image` - Image processing, thumbnail generation
- `class-directory.php` - `Wrap\Models\Directory` - Directory scanning with pattern matching
- `class-playlist.php` - `Wrap\Models\Playlist` - File collections and video playlists
