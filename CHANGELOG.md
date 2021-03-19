# Changelog

## 3.0.3
* removed useless files from release package
* cleaner changelog and minor cosmetic changes
* fix hardcoded path
* new back-end scripts

## 3.0
* New branch for 3.x development
* PHP7-ready
* Optimize bandwidth, load video only on request
* Optimize video display
* New back-end tools
  (old ones actually, merged from another repo, will be maintained here now)

## 2.x
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
