# Web Reel Automated Publishing: it's a W.R.A.P.

![Version 5.5.O-dev](https://badgen.net/badge/Version/5.5.O-dev/blue)
![Stable 3.1.1](https://badgen.net/badge/Stable/3.1.1/green)
![Requires PHP 7.4](https://badgen.net/badge/PHP/5.7/7884bf)
![License AGPLv3](https://badgen.net/badge/License/AGPLv3/552b55)

WARNING: This is a development branch, use latest stable version from 
https://github.com/magicoli/wrap/

## Description

Wrap is a basic CMS, aimed to display mostly galleries of images or videos.
The idea is to allow the website maintainer to push media in subfolders.
The structure of the websites and the menus is detected automatically.

It is not intended to be a full-featured CMS. Instead, it allows to
automatically publish videos and pictures playlists.

It is designed for fast, efficient media transmission. Although it is
possible to make a pretty beautiful website with this system (and I did), it's
not the goal.

It is poorly documented, but it works now with PHP7 (and probably 8).

## Installation

* VERY IMPORTANT: **Put this project outside your web directory**. It contains
  unprotected scripts and tools aimed to alter your disk content
* bin/ tools are not needed for web publishing. They are used to manipulate
  video files. If you only need to publish ready to use files, you can safely
  (and should) remove bin/ folder
* In your apache config, add alias, rules and wrap.php as DirectoryIndex:
  ```
  Alias /wrap/ /opt/wrap/
  DirectoryIndex index.php index.html /wrap/wrap.php

  <Directory /opt/wrap/>
    <IfVersion < 2.3>
      Order allow,deny
      Allow from all
    </IfVersion>
    <IfVersion >= 2.3>
    Require all granted
    </IfVersion>
    AllowOverride All
  </Directory>
  ```
* you can place wrap.css and wrap.html in your web root folder to customize layout
* use themes/bootstrap/page-template.html as base for wrap.html and be sure to
  include all needed shortcodes
* More on this later...
