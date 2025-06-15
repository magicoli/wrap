# WebUI - Web Interface Components

Web interface components separate from the core engine.

## What goes here:
- ✅ **Controllers** (`controller.php` - request handling)
- ✅ **Templates** (`template.php` - Bootstrap-based template engine)
- ✅ **Asset management** (`asset_manager.php` - CSS/JS handling)
- ✅ **Video player** (`video_player.php` - modern player integration)
- ✅ **Upload handler** (`upload_handler.php` - jQuery File Upload replacement)
- ✅ **Themes** (Bootstrap-based responsive themes)
- ✅ **Frontend assets** (CSS, JavaScript, images)

## What doesn't go here:
- ❌ **Business logic** (use classes from `engine/`)
- ❌ **Data processing** (goes in `engine/data/`)
- ❌ **Authentication logic** (goes in `engine/auth/`)
- ❌ **API endpoints** (go in `engine/api/`)

## Key principles:
- **Separation of concerns** - UI logic separate from business logic
- **Bootstrap-based** - Modern, responsive, mobile-first design
- **Component-based** - Reusable UI components
- **Asset compilation** - Minified CSS/JS, proper dependencies
- **Accessibility** - WCAG compliant interfaces

## Modernization goals:
- **Bootstrap layout** - Replace inline styles with Bootstrap classes
- **Modern video player** - YouTube-like experience, multiple formats
- **Responsive design** - Mobile/tablet compatibility
- **Progressive enhancement** - Works without JavaScript

## Examples:
- `template.php` - Bootstrap template engine, theme support
- `video_player.php` - Modern player (Video.js replacement)
- `asset_manager.php` - CSS/JS bundling, cache busting
- `upload_handler.php` - Drag & drop uploads, progress tracking
