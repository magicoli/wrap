# Changelog

## 3.0
- New branch for 3.x development
- New back-end tools
  (old ones actually, merged from another repo, will be maintained here now)
- Long due changelog update
- Added GNU Affero license

## 2.x
Changes between Feb, 2016 and March, 2021 were only documented in git history.
Here is a recap of most important changes
- php7-ready (well that's the most important)
- Optimize bandwidth, load video only on request
- Clean html5 video code
- Cleaner display
- New bootstrap layout, becomes default
- renamed old default folder to "classic" to avoid confusion with the actual default, "bootstrap"
- Don't accept calls from inside wrap directory
- rationalize css handling
- use more constants instead of global variables
- handle Canon .MXF files
- added reference code to write name on large thumbnail (not active)
- css adapted for listing prints

### Deprecated
- external includes in contrib/ folder (motools, jQuery-File-Upload, jd.gallery)
  Some will be deprecated in the future.
- moved mootools and jd.gallery in contrib/ folder
- move aloha functions from main php to modules/aloha.php
- only try to detect mobile if Mobile_Detect class is present
- deprecated former browser.* naming
- fix missing (obsolete) VideoSub

## 1.11
- CHANGELOG & README files
- handle .tar, .gz and .tar extensions as downloadable
- added [video:] tag
- wrap.php: allow one simple text line in links.txt, not converted as link
- added info from comment additions in playlist

## 1.10
New features:
- SSL support
- theming (work in progress)
Enhancements:
- enhanced ignore list (tilde, hashes, DS_Store...)
- automatic pageid
- multiple body classes
Several fixes and cosmetic changes
- html cleaning, remove empty tags

## 1.9
- efficient nofollow and noindex for non indexable pages
- handle remote pages
- modules videosub, video-js and modernizr
- html5 video subtitles support
- theora ogg & ogv support
- fixes and cosmetic changes

## 1.8
- First stable release as W.R.A.P.
- Renamed browser* files to wrap
- clean filenames
- split main code, functions and facebook auth
- fixes and cosmetic changes

## 1.7
- Initial fork of "browser" project, renamed W.R.A.P.
- A php app with huge bunch of files, tools, libraries, codes,
  developed between 2000 and 2013 under the too generic name "browser"
