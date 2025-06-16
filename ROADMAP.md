# Roadmap

## 1. Legacy Preservation & Foundation

Move all current code to legacy/ (FIRST TASK). At the end of this task,
the application must remain fully functional, with all legacy features.

  - [x] Move legacy-wrap.php, bin/, contrib/, css/, doc/, download.php, images/, inc/, js/, modules/, themes/ to `legacy/` folder
  - [x] Keep exact same file structure in legacy/ (no reorganization, no renaming)
  - [x] Update main entry point `wrap.php` to include legacy code from new location
  - [x] Update only minimal necessary file paths in legacy code
  - [x] Test thoroughly: ensure all current functionality works exactly as before

Create folder structure for standalone engine

  - [x] `engine/` - Main engine folder (standalone, third-party ready)
  - [x] `engine/core/` - Core classes (application, config, container)
  - [x] `engine/models/` - Data models and file operations  
  - [x] `engine/auth/` - User management and authentication
  - [x] `engine/api/` - RESTful API for external integrations (WordPress plugin, etc.)
  - [x] `webui/` - Web interface components (separate from engine)
  - [x] `cli/` - Command line tools (separate from engine)

Setup autoloading with Composer

  - [ ] Create `engine/composer.json` for engine-specific dependencies
  - [ ] Update main `composer.json` with PSR-4 autoloading for `Wrap\` namespace
  - [x] Add namespace mapping: `"Wrap\\": "engine/"`
  - [ ] Create autoloader bootstrap in `engine/autoload.php`

## 2. Legacy features fixes (Deployable Individually)

First take care of the parts of the code that currently need fixes, optimisation
or enhancements.

### Bootstrap Layout Migration (HIGH PRIORITY)
Modernize responsive layout system
  - [ ] Extract current layout generation from legacy code
  - [ ] Create `webui/template.php` - Bootstrap-based template engine
  - [ ] Create `webui/asset_manager.php` - Handle CSS/JS dependencies
  - [ ] Replace inline styles with Bootstrap classes
  - [ ] Implement proper responsive grid system
  - [ ] Test mobile/tablet compatibility
  - [ ] Deploy independently - improves user experience immediately

### Modern Video Player (HIGH PRIORITY)
Replace hand-made player with robust solution

New features:
  - [ ] A user experience closer to websites like YouTube (true page-wide 
        or full screen, seamless previous/next navigation, ...)
  - [ ] Like/Favorite/List button, as a tool for team work: a user can choose
        to share their favorites or lists, which other members of the project
        could watch.
  - [ ] Multiple video formats (mp4, webm, ogg) configurable site-wide
  - [ ] Multiple video resolutions
  - [ ] Video download button (light or large)
  - [ ] Thumnail update button (editors/admin): replace current thumbnail with 
        the current frame
General:
  - [ ] Evaluate alternative to current video player library
  - [ ] Create `webui/video_player.php` - Player management
  - [ ] Extract video metadata handling to `engine/data/video.php`
  - [ ] Implement proper video format support
  - [ ] Add subtitle support (replace current buggy implementation)
  - [ ] Add playlist functionality
  - [ ] Test cross-browser compatibility
  - [ ] Deploy independently - fixes current player issues

### Cache Protection System (HIGH PRIORITY)
Implement smart cache invalidation for updated files
  - [ ] Create `engine/core/cache.php` - Cache management system
  - [ ] Implement file modification detection
  - [ ] Add cache busting for generated files
  - [ ] Create cache cleanup mechanisms
  - [ ] Deploy independently - fixes cache issues immediately

### Universal Zip Generation (MEDIUM PRIORITY)
Make zip generation available on any page
  - [ ] Create `engine/core/zip_generator.php` - Cross-platform zip creation
  - [ ] Replace command-line dependency with PHP ZipArchive
  - [ ] Implement on-demand zip creation for any selection
  - [ ] Add progress tracking for large archives
  - [ ] Deploy independently - removes server dependency

## 3. Legacy features migration (following needs)

Eventually, all features currently provided by legacy code must be adapted
to use the new environment. This could be made progressively, following the 
needs of tasks being processed. No fundamental change must be done inside
legacy/ folder. If a feature is modified, fixed or enhanced, it has to be
moved to the new environment at the same time.

  - [ ] directory structure scan
  - [ ] page rendering
  - [ ] client video uploads (currently external library)
  - [ ] global, per client and per project preferences (currently config files)
  - [ ] pages and sidebar contents (currently pseudo markdown text files)
  - [ ] playlist editing (currently manual, text file)
  - [ ] tags and categories (currently pseudo sub directories)
  - [ ] video editing (currentaly manuel, text files and CLI scripts)
  - [ ] zip file generation for downloads (currently manual)
  ... (list to be completed)

## 4. New features

### Enhanced Folder System (MEDIUM PRIORITY)
Improve folder-based navigation and presentation
  - [ ] Create `engine/models/directory.php` - Enhanced directory handling
  - [ ] Add folder metadata support (descriptions, custom ordering)
  - [ ] Implement smart folder filtering (by date, type, size)
  - [ ] Add folder presentation options (grid, list, timeline views)
  - [ ] Deploy independently - enhances folder-based organization

### Upload System Modernization (HIGH PRIORITY)
Replace hardcoded jQuery File Upload with composer package
  - [ ] Replace current custom upload library with `blueimp/jquery-file-upload` composer package
  - [ ] Create `webui/upload_handler.php` - Modern upload handling (replaces per-client implementations)
  - [ ] Create `engine/api/upload.php` - API endpoint for uploads with authentication
  - [ ] Implement proper progress tracking and error handling
  - [ ] Add support for drag & drop and multiple file selection
  - [ ] Support upload on any page with proper user authentication
  - [ ] Integrate with WordPress authentication via API (existing wrap-wp plugin)
  - [ ] Optional authentication: no login required for viewing, login required for upload
  - [ ] Deploy independently - removes per-client jQuery File Upload copies, fixes upload issues

### Remove remote scripts and files dependency (HIGH PRIORITY)

Implement playlists and video editing server-side, to remove the need
for manual rules files editing and synchronizing.

  - [ ] Extract video conversion, merge, thumbnails and naming logic from shell script
  - [ ] Visual video merge and naming
  - [ ] Visual playlist tool (display order, sections...)
  - [ ] Background video conversion (optional use of an external service)
  - [ ] Implement proper error handling and logging
  - [ ] Add progress tracking for large directory operations
  - [ ] Deploy independently - fixes current sync issues

### Thumbnail Generation Reliability (HIGH PRIORITY)
Fix unreliable thumbnail generation
  - [ ] Extract thumbnail logic from scattered locations
  - [ ] Create `engine/models/image.php` and `engine/models/video.php` with thumbnail methods
  - [ ] Implement proper error handling for missing dependencies
  - [ ] Add fallback mechanisms for different environments
  - [ ] Deploy independently - fixes thumbnail issues

### File Variant Management (MEDIUM PRIORITY)
Improve file variant detection and handling
  - [ ] Extract `stripVariantSuffix()`, `findVariants()` from functions.php
  - [ ] Create `engine/models/file.php` with variant handling methods
  - [ ] Implement consistent variant naming conventions
  - [ ] Add support for new variant types
  - [ ] Deploy independently - improves file organization

### Pattern Matching System (MEDIUM PRIORITY)
Centralize file and directory pattern matching
  - [ ] Extract `matchesPattern()`, `matchesIgnorePattern()` from functions.php  
  - [ ] Create `engine/models/directory.php` with pattern matching methods
  - [ ] Add support for regex patterns and exclusions
  - [ ] Implement performance optimizations for large directories
  - [ ] Deploy independently - improves directory scanning

### API Development for External Integration (HIGH PRIORITY)
Build RESTful API for WordPress plugin and other external integrations
  - [ ] Create `engine/api/auth.php` - Authentication endpoints for external apps
  - [ ] Create `engine/api/upload.php` - Upload endpoints with authentication
  - [ ] Create `engine/api/directory.php` - Directory listing and management
  - [ ] Create `engine/api/media.php` - Media processing status and metadata
  - [ ] Create `engine/api/invite.php` - User invitation API endpoints
  - [ ] Create `engine/api/notification.php` - Notification management API
  - [ ] Implement proper API authentication (tokens, sessions)
  - [ ] Add CORS support for cross-domain requests
  - [ ] Create API documentation for external developers
  - [ ] Test integration with existing wrap-wp WordPress plugin
  - [ ] Deploy independently - enables better external integrations

### Email-Based Authentication & User Management
Perfect for temporary project collaborations - no forced registration, delegated management by clients.

**Email Authentication System:**
- [ ] `engine/auth/email_auth.php` - Email verification code system
- [ ] Send verification codes to email addresses (no passwords required)
- [ ] Temporary authentication tokens with configurable expiration
- [ ] No user accounts created unless explicitly needed
- [ ] Support for one-time authentication or session-based access

**Delegated User Management:**
- [ ] `engine/models/client.php` - Client (project manager) management
- [ ] `engine/models/project.php` - Project-specific user lists and permissions
- [ ] `engine/api/invite.php` - User invitation API endpoints
- [ ] Admin creates clients, clients invite users to their projects
- [ ] Project-specific permissions: read-only, upload, favorites/selections, admin
- [ ] Option for client-wide access (user gets access to all client's projects)

**User Permission Levels:**
1. **Read-only**: View content, no upload or modification rights
2. **Upload**: Can upload files to assigned projects/folders
3. **Favorites/Selections**: Can create and share favorite lists/selections
4. **Admin**: Full project management rights (invite users, modify settings)

**Project Notification System:**
- [ ] `engine/notification/email_notifier.php` - Email notification system
- [ ] Per-project email lists managed by clients
- [ ] Automated notifications when daily sessions are complete
- [ ] Client-configurable notification preferences:
  - Immediate notifications on new uploads
  - Daily digest when processing is complete
  - Weekly project summaries
  - Custom notification triggers (e.g., when specific folders are updated)

**Invite System Workflow:**
1. Client adds email address to project invitation list
2. User receives invitation email with verification code
3. User enters code to gain access to specific project
4. Access is granted based on assigned permission level
5. No permanent account created - access tied to email verification

**Integration with WordPress Authentication:**
- [ ] Maintain compatibility with existing wrap-wp plugin
- [ ] Allow WordPress users to also use email verification for projects they're not WordPress members of
- [ ] Single sign-on when both WordPress and WRAP authentication are present

## 5. Infrastructure 

### Core Foundation (Support Classes)

- [ ] Create essential core classes (only when needed by priority tasks)
  - [ ] `engine/core/application.php` - Main application bootstrap
  - [ ] `engine/core/config.php` - Configuration management
  - [ ] `engine/core/container.php` - Simple dependency injection
  - [ ] `engine/core/router.php` - URL routing for modern features
- [ ] Create data model classes (only when needed)
  - [ ] `engine/models/client.php` - Client/project management
  - [ ] `engine/models/directory.php` - Directory scanning and management
  - [ ] `engine/models/file.php` - Generic file handling with metadata
  - [ ] `engine/models/playlist.php` - File collections and selections

### Processing Layer (Standalone)

- [ ] Media processing classes (can work without WebUI)
  - [ ] `engine/models/media.php` - Parent class for video, images, audio etc.
  - [ ] `engine/models/video.php` - Video processing including conversion and thumbnails
  - [ ] `engine/models/image.php` - Image processing including thumbnails
  - [ ] `engine/core/file_system.php` - File system operations and utilities
  - [ ] `engine/models/directory.php` - Directory scanning and pattern matching
- [ ] Extract processing logic from current code
  - [ ] Create PHP replacements for `bin/` scripts (batchloop, mediawatch, makeplaylist, etc.)
  - [ ] Extract thumbnail generation logic
  - [ ] Move metadata parsing from `inc/functions.php` (parseAtom, etc.)
  - [ ] Extract file variant detection logic (stripVariantSuffix, findVariants)
  - [ ] Move MIME type handling from global arrays
  - [ ] Extract file pattern matching logic (matchesPattern, matchesIgnorePattern)

### Authentication & User Management (When Needed)

- [ ] User management system
  - [ ] `engine/auth/user.php` - User representation and session handling
  - [ ] `engine/auth/email.php` - Email-based authentication with verification codes
  - [ ] `engine/auth/facebook.php` - Facebook authentication
  - [ ] `engine/auth/wordpress.php` - WordPress authentication integration
  - [ ] `engine/auth/access_control.php` - Permissions and rights management
  - [ ] `engine/api/auth.php` - Authentication API endpoints
- [ ] Email-based authentication model
  - [ ] No registration required - authentication via email verification codes
  - [ ] Temporary access tokens for project-specific access
  - [ ] No permanent user accounts unless explicitly created
- [ ] Delegated user management
  - [ ] Admin creates clients (project managers)
  - [ ] Clients can invite users to their projects via email
  - [ ] Granular permissions: read-only, upload, favorites/selections, admin
  - [ ] Project-specific or client-wide access control
- [ ] Project notification system
  - [ ] Per-project notification lists (email addresses)
  - [ ] Automated notifications when daily sessions are complete
  - [ ] Client-managed notification preferences
- [ ] Optional authentication model
  - [ ] No login required for viewing content (public access)
  - [ ] Login required only for upload functionality
  - [ ] Integration with existing wrap-wp WordPress plugin
- [ ] Extract from current `modules/fbauth/`
  - [ ] Modernize Facebook integration
  - [ ] Add support for other auth providers

### Modern Features & Improvements
- [ ] Enhanced functionality
  - [ ] RESTful API for external integrations
  - [ ] WebSocket support for real-time updates
  - [ ] Modern video player integration
  - [ ] Mobile-first responsive design
  - [ ] Progressive Web App features
- [ ] Performance optimizations  
  - [ ] Implement proper caching strategies
  - [ ] Optimize media processing pipeline
  - [ ] Add CDN support

## 6. Interfaces

### Web Interface Layer (When Needed)

- [ ] Web UI components (separate from processing)
  - [ ] `webui/controller.php` - Request handlers
  - [ ] `webui/template.php` - Template rendering
  - [ ] `webui/theme.php` - Theme handling
  - [ ] `webui/asset_manager.php` - CSS/JS asset management
- [ ] Template system
  - [ ] Extract only content logic from current mixed PHP/HTML, discard current layout
  - [ ] Implement proper separation of concerns
  - [ ] Implement basic, clean and responsive bootstrap theme, mobile-first

### Command Line Tools (When Needed)
- [ ] CLI utilities (using processing layer)
  - [ ] `engine/cli/media_processor.php` - Batch media processing
  - [ ] `engine/cli/directory_sync.php` - Directory synchronization
  - [ ] `engine/cli/cache_manager.php` - Cache management
- [ ] Modernize `bin/` scripts
  - [ ] Convert bash scripts to PHP CLI commands
  - [ ] Use Symfony Console component

### Legacy Bridge (Temporary)
- [ ] Compatibility bridge
  - [ ] `engine/legacy/bridge.php` - Interface between old and new code
  - [ ] `engine/legacy/function_mapper.php` - Map old functions to new classes
        (try to avoid, use the new methods in legacy as much as possible)
- [ ] Gradual migration path
  - [ ] Support both old and new APIs during transition
  - [ ] Replace legacy functions one by one
- [ ] Delete legacy code (once the new structure is completely implemented)

## 7. Testing & Documentation
- [ ] Quality assurance
  - [ ] Unit tests for all new classes
  - [ ] Integration tests for workflows
  - [ ] End-to-end testing for web interface
- [ ] Documentation
  - [ ] API documentation
  - [ ] Developer guide
  - [ ] Migration guide
  - [ ] User manual

## Key Technical Decisions
- Use PSR-4 autoloading and PSR standards
- Single `engine/` folder containing everything needed by third-party projects
- Lowercase file names throughout the codebase
- Dependency injection for loose coupling
- Interface-based design for extensibility  
- Separate processing layer that can work standalone
- Event-driven architecture for extensibility
- Modern PHP 7.4+ features (typed properties, arrow functions, etc.)
- Composer for dependency management
- Keep existing file structure compatibility during migration
- No intermediate storage - generate final HTML pages and content directly
- Minimal legacy changes - preserve exact structure when moving to legacy/

# Detailed Implementation Plan

## Critical Code Analysis & Migration Tasks

### 1. Global Variables Elimination
**From `wrap.php` (230+ global variables):**
- [ ] Move all configuration variables to `Wrap\Core\Config`
- [ ] Extract UI settings ($popup, $slideshow, $kioskmode, etc.)
- [ ] Centralize media settings ($width, $height, $thumbwidth, etc.)
- [ ] Move Facebook integration settings to dedicated auth config
- [ ] Convert arrays ($playable, $mimetypes, $allowedvariants) to proper data structures
- [ ] Extract localization arrays to proper i18n system

### 2. Functions Refactoring (`inc/functions.php`)
**Core Functions to Extract:**
- [ ] `parseAtom()` → `engine/models/video.php::parseAtomData()`
- [ ] `generateFileName()`, `generateFolderName()` → `engine/models/file.php::generateName()`
- [ ] `matchesPattern()`, `matchesIgnorePattern()` → `engine/models/directory.php::matchesPattern()`
- [ ] `stripVariantSuffix()`, `findVariants()` → `engine/models/file.php::handleVariants()`
- [ ] `is_playable()`, `is_downloadable()` → `engine/models/file.php::getFileType()`
- [ ] `getPageSettings()` → `engine/core/config.php::getPageSettings()`
- [ ] `cleanpath()`, `firstWritableFolder()` → `engine/core/file_system.php::cleanPath()`
- [ ] `add_css()`, `add_js()` → `webui/asset_manager.php::addAsset()`
- [ ] `localise()` → `engine/core/config.php::localise()`

### 3. Legacy Shell Scripts Migration (`bin/`)

Most current CLI tools will need to be converted in PHP, to be used 
by admin or by automated task directly via the web app.

The final remaining CLI is likely to become one single executable file
`wrap` with arguments, e.g. `wrap merge output.mp4 video1.mp4 video2.mp4` 
would call the corresponding process in engine/.

A lot of current CLI scripts will not be needed at all in the finalized
app and will eventually simply disappear. E.g. the script `batchsync`
currently only exists because the functionalty is not available in the 
web app, so the current workflow relies on editing some files locally 
and syncing them for remote processing.

**Example CLI functinalties:**
- [ ] watch uploads: check regularly and notify user when a file transfer started
- [ ] watch complete: notifyy user when all available files have been processed
- ... (others tbd)

### 4. Module System Modernization (`modules/`)

Current modules will probably disappear (fbauth, modernizr, videosub) and in any case the current available alternatives must be evaluated (video-js, aloha).

`modules/` will be left for external developers to add optional functionalty.
So, video-js or its new alternative must not be in modules but in composer 
packages.

**Current Modules:**
- [ ] `modules/fbauth/` → `engine/auth/facebook.php`
- [ ] `modules/aloha.php` → `webui/editor.php`
- [ ] `modules/videosub.php` → `webui/video_player.php` (subtitle support)
- [ ] `modules/video-js/` → `webui/video_player.php` (Video.js integration)
- [ ] `modules/modernizr/` → `webui/asset_manager.php` (Modernizr integration)

### 5. Asset Management System
**Current Issues to Fix:**
- [ ] Scattered CSS/JS in multiple directories
- [ ] Inline styles and scripts in generated HTML
- [ ] No dependency management for frontend assets
- [ ] Mixed legacy JavaScript libraries

**New Implementation:**
- [ ] `webui/asset_manager.php` - Central asset registration and compilation
- [ ] Move all assets to proper structure under `assets/`
- [ ] Implement minification and bundling
- [ ] Handle asset dependencies properly

### 6. Configuration Management
**Current State:**
- [ ] Hardcoded values throughout legacy code
- [ ] No environment-specific configuration
- [ ] Mixed UI and processing configuration

**New Implementation:**
- [ ] `engine/core/config.php` - Central configuration management
- [ ] Environment-specific settings support
- [ ] Clear separation between UI and processing config

### 7. Error Handling & Logging
**Current Issues:**
- [ ] Inconsistent error handling
- [ ] `debug()` function mixed throughout code
- [ ] No proper logging system

**New Implementation:**
- [ ] PSR-3 compliant logging with Monolog
- [ ] `Wrap\Core\Exception\*` - Custom exception hierarchy
- [ ] `Wrap\Core\Logger\*` - Logging infrastructure
- [ ] Proper error pages and API error responses

### 8. Security Improvements
**Current Vulnerabilities:**
- [ ] Direct file access without protection
- [ ] Inconsistent input validation
- [ ] Mixed authentication/authorization logic

**Security Hardening:**
- [ ] `Wrap\Core\Security\InputValidator`
- [ ] `Wrap\Core\Security\AccessControl`
- [ ] `Wrap\Core\Security\CsrfProtection`
- [ ] Proper sanitization for all user inputs
- [ ] Rate limiting for API endpoints

### 9. Database Integration (Future)
**Current State:** File-based storage only
**Future Implementation:**
- [ ] `Wrap\Data\Database\*` - Database abstraction layer
- [ ] `Wrap\Data\Migration\*` - Database migration system
- [ ] Optional database backend for metadata and configuration
- [ ] Maintain file-based compatibility

### 10. API Development
**RESTful API Structure:**
- [ ] `Wrap\API\Controller\*` - API controllers
- [ ] `Wrap\API\Middleware\*` - API middleware
- [ ] `Wrap\API\Serializer\*` - Data serialization
- [ ] `Wrap\API\Response\*` - Standardized API responses
- [ ] OpenAPI/Swagger documentation

### Current Integration Analysis

#### WordPress Plugin Integration (wrap-wp)
Based on your existing implementation:
- [ ] Analyze current `tmp/example-wp-plugin/` WordPress plugin structure
- [ ] Maintain compatibility with existing authentication flow
- [ ] Improve authentication token handling between WP and WRAP
- [ ] Create standardized API endpoints for seamless integration

#### jQuery File Upload Migration
Current issues with per-client implementation:
- [ ] Each client folder contains full jQuery File Upload project copy
- [ ] Manual copy/paste of upload functionality per project
- [ ] Inconsistent authentication implementation across clients
- [ ] No centralized upload handling

**Migration approach:**
- [ ] Move to single composer-managed `blueimp/jquery-file-upload` package
- [ ] Create universal upload interface available on any page
- [ ] Implement consistent WordPress authentication across all pages
- [ ] Allow uploads with proper authentication, even if media requires editor processing

#### Optional Authentication Model
- [ ] **Public viewing**: No authentication required for browsing content
- [ ] **Authenticated uploads**: Login required only when attempting to upload
- [ ] **Page-level access control**: Respect existing page/folder access permissions
- [ ] **Seamless WordPress integration**: Single sign-on from WordPress sites

## Implementation Priority

## Immediate Tasks (Phase 1a)
1. Setup composer autoloading
2. Create basic folder structure
3. Move legacy code
4. Create bootstrap files

## Core Foundation (Phase 1b)
1. Implement `Wrap\Core\Application`
2. Basic configuration management
3. Simple dependency injection
4. Asset management foundation

## Processing Layer (Phase 2)
1. Extract media processing functions
2. Create standalone processing classes
3. Convert shell scripts to PHP CLI

## Web Interface (Phase 3)
1. Create controller structure
2. Template system
3. Theme management
4. Asset compilation

## Testing & Quality (Ongoing)
1. Unit tests for each new class
2. Integration tests for workflows
3. Code quality tools (PHPStan, PHP CS Fixer)
4. Performance monitoring
