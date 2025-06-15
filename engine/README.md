# Engine - Core Processing Library

This folder contains the standalone WRAP engine that can be used by third-party projects.

## What goes here:
- ✅ **Core classes** - Application bootstrap, config, dependency injection
- ✅ **Data models** - File, directory, media processing classes  
- ✅ **Authentication** - User management, email auth, WordPress integration
- ✅ **API endpoints** - RESTful API for external integrations
- ✅ **Processing logic** - Video/image processing, thumbnail generation
- ✅ **File operations** - Pattern matching, variant handling, zip generation

## What doesn't go here:
- ❌ **Web UI components** (go in `webui/`)
- ❌ **CLI tools** (go in `cli/`)
- ❌ **Legacy code** (stays in `legacy/`)
- ❌ **Templates/themes** (go in `webui/`)
- ❌ **Frontend assets** (CSS/JS go in `webui/`)
- ❌ **Actual data files** (uploaded files, cache, generated content)

## Key principles:
- **Framework agnostic** - Can work without web interface
- **Third-party ready** - Clean API for external usage  
- **PSR-4 autoloading** - Namespace: `Wrap\`
- **Standalone** - No dependencies on webui/ or cli/
- **Modern PHP** - 7.4+ features, typed properties, strict types

## Structure:
```
engine/
├── core/        # Application, config, container, cache
├── data/        # File, directory, media, playlist models
├── auth/        # User management and authentication
└── api/         # RESTful API endpoints
```
