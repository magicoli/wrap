# Changelog

## 3.1.0
* front-end:
  - updated playable formats
  - new flex/grid-based default theme
  - smooth scroll to clicked thumb
  - stay on clicked thumb position after playing video
  - don't hide playlist in background
  - use versioning to launch css and js, to avoid cache issues
* fix file not found when filename contains spaces or special characters
* new mediadeduplicate script
* batchff: quote file names
* medialoop: show countdown between instances
* casting-server: include folder in when launching atom
* batchloop: show still unprocessed videos
* makemp4 added allblur preference, whatever it is
* castingchecktime: ignore <5 sec as default, read .casting conf in client/job or casting for custom thresold and other custom vars
* casting-client launch mediawatch in 4th window
* casting-client/server prefer atom editor if present
* batchloop show missing videos (still in queue)
* added icons
* fix #1 don't try to play audio files (download only)
* removed -threads auto from ffmpeg args
* added vsync to moviemerge

## 3.0.3
* removed useless files from release package
* cleaner changelog and minor cosmetic changes
* fix hardcoded path
* new back-end scripts

## 3.0
This is a major upgrade. However, there is no specific upgrade path for the web
content, it is backward compatible with 2.x as the actual major change is the
inclusion of new back-end scripts.
* PHP7-ready
* Optimize bandwidth, load video only on request
* Optimize video display
* New back-end tools
  (old ones actually, merged from another repo, will be maintained here now)

## 2.4.8
* new: bootstrap layout, becomes default
* fix: protect wrap own directory
* added: support for Canon .MXF files
* added: list printing
* updated: php7-ready (well that's the most important)
* updated: optimize bandwidth, load video only on request
* udpated: clean html5 video code
* enhanced: Cleaner display
* added reference code to write name on large thumbnail (not active)
* deprecated: old libraries (motools, jQuery-File-Upload, jd.gallery)
* deprecated: former browser.* naming (still compatible though)
* fix: only try to detect mobile if Mobile_Detect class is present

## 1.11
* new: SSL support
* new: theming (work in progress)
* new: handle remote pages
* new: html5 video subtitles support
* added theora ogg & ogv support
* added modules videosub, video-js and modernizr
* added [video:] tag
* fixes: html cleaning, remove empty tags
* fixed: efficient nofollow and noindex for non indexable pages
* enhanced: ignore list (tilde, hashes, DS_Store...)
* enhanced: automatic pageid
* enhanced: multiple body classes
* handle .tar, .gz and .tar extensions as downloadable
* wrap.php: allow one simple text line in links.txt, not converted as link
* added info from comment additions in playlist

## 1.8
* First stable release as W.R.A.P.
* Renamed browser* files to wrap
* split main code, functions and facebook auth
* fixes and cosmetic changes
* Initial fork of "browser" project, renamed W.R.A.P.
* A php app with huge bunch of files, tools, libraries, codes,
  developed between 2000 and 2013 under the too generic name "browser"
