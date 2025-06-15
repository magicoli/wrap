    # API - RESTful Endpoints

RESTful API endpoints for external integrations and modern web features.

## What goes here:
- ✅ **Authentication API** (`class-auth-api.php` - login, tokens, sessions)
- ✅ **Upload API** (`class-upload-api.php` - file uploads with authentication)
- ✅ **Directory API** (`class-directory-api.php` - listing, management)
- ✅ **Media API** (`class-media-api.php` - processing status, metadata)
- ✅ **Invitation API** (`class-invite-api.php` - user invitation endpoints)
- ✅ **Notification API** (`class-notification-api.php` - email notifications)

## File naming convention:
**Option A - API provides endpoints for features:**
- **Class files**: `class-api-{feature}.php`
- **Class names**: `Wrap\Api\Api{Feature}`
- **Examples**: 
  - `class-api-auth.php` → `Wrap\Api\ApiAuth`
  - `class-api-upload.php` → `Wrap\Api\ApiUpload`
  - `class-api-media.php` → `Wrap\Api\ApiMedia`

**Option B - Features provide API endpoints:**
- **Class files**: `class-{feature}-api.php`
- **Class names**: `Wrap\Api\{Feature}Api`
- **Examples**: 
  - `class-auth-api.php` → `Wrap\Api\AuthApi`
  - `class-upload-api.php` → `Wrap\Api\UploadApi`
  - `class-media-api.php` → `Wrap\Api\MediaApi`

## What doesn't go here:
- ❌ **Business logic** (use classes from `../models/`, `../auth/`)
- ❌ **Web pages** (go in `webui/`)
- ❌ **Authentication logic** (go in `../auth/`)
- ❌ **Data models** (go in `../models/`)

## Key principles:
- **RESTful design** - Standard HTTP methods and status codes
- **JSON responses** - Consistent API response format
- **Authentication required** - Secure endpoints with proper auth
- **CORS support** - Cross-domain requests for WordPress plugin
- **Rate limiting** - Prevent abuse

## Integration targets:
- **WordPress plugin** (wrap-wp) - Existing authentication system
- **Mobile apps** - Future mobile client development  
- **Third-party tools** - External media management tools
- **JavaScript frontend** - Modern SPA development

## Examples:
- `auth.php` - POST /api/auth/login, GET /api/auth/user
- `upload.php` - POST /api/upload, GET /api/upload/progress
- `directory.php` - GET /api/directory/list, POST /api/directory/create
- `media.php` - GET /api/media/status, POST /api/media/process
