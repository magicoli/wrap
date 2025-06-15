# Developemnt rules

Version 5.5 is a complete rewrite to get rid of years of patches
made without a clear global picture, make the code more robust and
future improvements easier.

## Goals

- Smart use of classes and autoload
- Smart use of composer packages, only code parts that are specific
  to this project, use well-known libraries when available.
- Dependencies must be included as composer packages, not submodules or manual copies.
- Maintain a clear separation between
    - user management (clients with full client access, guests with read access, guests with upload access...)
    - data
        - permanent data (generated data, needed to display the generated pages)
        - temporary data (uploaded files, cache, ffmpeg temporary files, reporting, etc.)
    - data processing (directory scan, video conversion, thumbnails generation, ...)
    - web interface (generating pages will rely on data processing)
    - layout (themes and templates, used to generate pages and allow per site/per project customization)
    - command-line tools (will rely on data processing)
    - compatibility layer (everything needed only to maintain backswards compatibility
      for methods and functionalties replaced in the new version)

Old code is in legacy/ folder. New code is organized in folders based on their respective
layer.

HTML generated with bootstrap classes, with as less css or javascript as possible, to allow 
easy theming. The project itselfs makes no fancy HTML, it only makes sure generated 
pages are omptimized for responsive layout and theme customization.

This transition will take time, so it is critical to maintain backwards compatibility,
to allow progressive updates, benefiting of new features while still relying on old 
ones and fix potential bugs in the old code.

## Coding rules

- Make it short, clear and concise
- If a variable, constant or function is only used once, it is probably not necessary
- If the same routine is used twice or more, it probably requires a function or method
- If the same value is used twice or more, it probably requires a variable or property
- Never include inline scripts or css when generating html. Scripts and styles are
  saved in separated files, main files for general use, or specific files for parts 
  needed only in specific situations
- Never include direct links to css and js in generated code, use generic functions
  add_script($id, $src...) and add_style($id, $src...) to register them, and the template
  would include them with get_scripts() and get_styles(), to make sure each include 
  happens only once and only when needed.

## Modern PHP Standards

- Use PSR-4 autoloading and follow PSR-12 coding standards
- Implement proper dependency injection using containers
- Use typed properties and return types (PHP 7.4+)
- Leverage modern PHP features: null coalescing, arrow functions, match expressions
- Follow SOLID principles for class design
- Use interfaces for all service contracts
- Implement proper exception handling with custom exception classes

## Architecture Principles

- **Separation of Concerns**: Each class should have a single responsibility
- **Dependency Inversion**: Depend on abstractions, not concretions
- **Open/Closed Principle**: Classes should be open for extension, closed for modification
- **Interface Segregation**: Many client-specific interfaces are better than one general-purpose interface
- **Single Responsibility**: A class should have only one reason to change

## File Organization

```
src/
├── Core/           # Application core (config, routing, DI container)
├── Processing/     # Media processing (standalone, no web dependencies)
├── Data/           # Data models and repositories
├── WebUI/          # Web interface (controllers, templates, assets)
├── Auth/           # Authentication and authorization
├── CLI/            # Command line interfaces
└── API/            # RESTful API endpoints

legacy/             # Current code for backwards compatibility
tests/              # Unit and integration tests
config/             # Configuration files
assets/             # Frontend assets (CSS, JS, images)
```

## Naming Conventions

- **Classes**: PascalCase (`MediaProcessor`, `VideoConverter`)
- **Methods**: camelCase (`processVideo()`, `generateThumbnail()`)
- **Properties**: camelCase (`$mediaFile`, `$thumbnailPath`)
- **Constants**: UPPER_SNAKE_CASE (`DEFAULT_QUALITY`, `MAX_FILE_SIZE`)
- **Interfaces**: Suffix with "Interface" (`ProcessorInterface`)
- **Abstract classes**: Prefix with "Abstract" (`AbstractProcessor`)
- **Exceptions**: Suffix with "Exception" (`ProcessingException`)

## Testing Strategy

- Unit tests for all business logic
- Integration tests for workflows
- Mock external dependencies
- Test both success and failure scenarios
- Maintain minimum 80% code coverage
