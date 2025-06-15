# Developemnt rules

Version 5.5 is a complete rewrite to get rid of years of patches
made without a clear global picture, make the code more robust and
future improvements easier.

## Goals

- Smart use of classes and autoload
- Smart use of composer packages, only code parts that are specific
  to this project, use well-known libraries when available.
- Maintain a clear separation between
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

## Conding rules

- Make it short, clear and concise
- If a variable, constant or function is only used once, it is probably not necessary
- If the same routine is used twice or more, it probably requires a function or method
- If the same value is used twice or more, it probably requires a variable or property
- Never include inline scripts or css when generating html. Scripts and styles are
  saved in separated files, main files for general use, or specific files for parts 
  needed only in specific situations
- Never include direct links to css and js in generated code, use generic fuctions
  add_script($id, $src...) and add_style($id, $src...) to register them, and the template
  would include them with gets_scripts() and get_styles(), to make sure each include 
  happens only once and only when needed.
