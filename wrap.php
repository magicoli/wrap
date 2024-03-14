<?php
require 'vendor/autoload.php';

class Wrap {
    private $wrap_data;
    private $real_path;
    private $nav;
    private $brand = "Wrap by Magiiic";
    private static $scripts = [];
    private static $styles = [];
    private $breadcrumb = '';
    private $content = '';
    private $title = '';

    public function __construct() {
        define('WRAP_VERSION', '5.0.0-dev');
        
        $this->init();
        // $this->update_cache();
        $this->build_page();
    }

    public function init() {
        // Initialize the application
        // Set data root, a 'data' folder in the same parent as document root if exists, fallback to document root

        // try dirname($_SERVER['DOCUMENT_ROOT']) . '/data', $_SERVER['DOCUMENT_ROOT'] . '/data', fallback to dirname($_SERVER['DOCUMENT_ROOT']);
        $document_root = $_SERVER['DOCUMENT_ROOT'];
        $try = [
            $document_root . '/data',
            dirname($document_root) . '/data',
            dirname($document_root)
        ];
        foreach ($try as $path) {
            if (file_exists($path)) {
                $wrap_data = $path;
                break;
            }
        }
        if(empty($wrap_data)) {
            die("No data folder found");
        }
        define('WRAP_DATA', $wrap_data);
        define('WRAP_DIR', dirname(__FILE__)); // Define WRAP_DIR as the actual script directory
        define('WRAP_URL', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST']);
    }

    public function update_cache( $file ) {
        // do not cache external urls
        if (filter_var($file, FILTER_VALIDATE_URL)) {
            return $file;
        }


        // Cache WRAP_DIR/css/style.css into WRAP_DATA/.css/style.css
        $source_file = WRAP_DIR . $file;
        if (!file_exists($source_file)) {
            return false;
        }
        $cache_file = WRAP_DATA . '/.cache/' . ltrim($file, '/');
        $cache_url = WRAP_URL . '/.cache/' . ltrim($file, '/');

        if (!file_exists($cache_file) || filemtime($source_file) != filemtime($cache_file)) {
            // Create the cache directory if it doesn't exist
            if (!is_dir(dirname($cache_file))) {
                mkdir(dirname($cache_file), 0777, true);
            }

            // Copy the CSS file to the cache directory
            copy($source_file, $cache_file);
        }
        return $cache_url;
    }

    public function build_page() {
        $requested_url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        if (is_dir(WRAP_DATA . $requested_url)) {
            $wrap_folder = new Wrap_Folder($requested_url);

            $this->content = $wrap_folder->get_content();
            $this->nav = $wrap_folder->get_nav();
            $this->breadcrumb = $wrap_folder->get_breadcrumb();
            $this->title = $wrap_folder->get_name();

            $this->output_html('<p>Folder requested: ' . $requested_url . '</p>', 'Folder', 'Folder requested: ' . $requested_url, 'folder' );
        } elseif (file_exists(WRAP_DATA . $requested_url)) {
            $wrap_file = new Wrap_File($requested_url);
            $wrap_file->output();
        } else {
            $this->error_404();
        }
    }
    
    public function error_404() {
        error_log('Error 404: File not found - ' . $_SERVER['REQUEST_URI']);

        $content = "<h1>Not Found</h1>
        <p>The requested URL was not found on this server.</p>
        <hr>{$_SERVER['SERVER_SIGNATURE']}"; // Display Apache server signature in the error message
        $this->output_html($content, '404 Not Found', 'The requested URL was not found on this server.', '404, Not Found', 404);
        
        die();
    }

    public static function build_url($path) {
        $path = '/' . ltrim($path, '/');
        return WRAP_URL . $path;
    }

    public static function icons() {
        static $icons = null;
        if ($icons !== null) {
            return $icons;
        }
        $fa = [
            'csv' => 'fa-file-csv',
            'doc' => 'fa-file-word',
            'docx' => 'fa-file-word',
            'gif' => 'fa-file-image',
            'gz' => 'fa-file-archive',
            'jpeg' => 'fa-file-image',
            'jpg' => 'fa-file-image',
            'mov' => 'fa-file-video',
            'mp3' => 'fa-file-audio',
            'mp4' => 'fa-file-video',
            'pdf' => 'fa-file-pdf',
            'png' => 'fa-file-image',
            'ppt' => 'fa-file-powerpoint',
            'pptx' => 'fa-file-powerpoint',
            'rar' => 'fa-file-archive',
            'tar' => 'fa-file-archive',
            'wav' => 'fa-file-audio',
            'xls' => 'fa-file-excel',
            'xlsx' => 'fa-file-excel',
            'zip' => 'fa-file-archive',
        ];
        // <i class="fas ' . $icon . '"></i>
        $icons = array_map(function($icon) {
            return '<i class="icon fas ' . $icon . '"></i>';
        }, $fa);
        
        return $icons;
    }

    public static function queue_script($name, $src) {
        self::$scripts[$name] = $src;
    }

    public static function queue_style($name, $src) {
        self::$styles[$name] = $src;
    }

    /* output_html
     * Output HTML content
     * 
     * @param string $content       HTML content
     * @param string $title         HTML meta title
     * @param string $description   HTML meta description
     * @param string $keywords      HTML meta keywords
     * @param int $http_code        HTTP status code
     * 
     * @return void
     */
    public function output_html($content = '', $title = '', $description = '', $keywords = '', $http_code = 200) {
        http_response_code($http_code);

        $content = empty($content) ? $this->content : $content;
        $title = empty($title) ? $this->title : $title;

        $description = empty($description) ? $this->description : $description;
        $keywords = empty($keywords) ? $this->keywords : $keywords;

        // escape $content $title $description $keywords
        $title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
        $description = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');
        $keywords = htmlspecialchars($keywords, ENT_QUOTES, 'UTF-8');

        self::queue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css');
        self::queue_style('style-main', '/dist/main.css');

        $queued_meta = '';
        foreach (self::$scripts as $key => $src) {
            $script_url = $this->update_cache($src);
            $queued_meta .= '<script id="js-' . $key . '" src="' . $script_url . '"></script>' . PHP_EOL;
        }
        foreach (self::$styles as $key => $src) {
            $css_url =  $this->update_cache($src);
            $queued_meta .= '<link id="css-' . $key . '" href="' . $css_url . '" rel="stylesheet">' . PHP_EOL;
        }

        $template = '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>{title}</title>
            <meta name="description" content="{description}">
            <meta name="keywords" content="{keywords}">
            
            <meta name="apple-mobile-web-app-capable" content="yes">
            <meta name="apple-mobile-web-app-status-bar-style" content="black">
            {queued_meta}
        </head>
        <body>
        <div class="container">
            <header id="header">
                <nav class="breadcrumb">
                    {breadcrumb}
                </nav>
                <h1>{title}</h1>
                <div id=branding>
                    {brand}
            </header>
            <main id="main">
                <nav id=nav>
                    {nav}
                </nav>
                <div id="content">
                    {content}
                </div>
            </main>
            <footer id="footer">
                {footer}
            </footer>
        </div>
        </body>
        </html>';

        $data = [
            '{title}' => $this->title,
            '{description}' => $description,
            '{keywords}' => $keywords,
            '{content}' => $this->content,
            '{footer}' => "Wrap " . WRAP_VERSION,
            '{brand}' => $this->brand,
            '{breadcrumb}' => $this->breadcrumb,
            '{nav}' => $this->nav,
            '{queued_meta}' => $queued_meta,
        ];

        echo strtr($template, $data);
    }

    public static function getVersion() {
        return WRAP_VERSION;
    }

    static function debug($message) {
        echo "$message<br>";
        error_log($message);
    }

    public static function filename2name($string) {
        $string = pathinfo($string, PATHINFO_FILENAME);
        $string = str_replace('_', ' ', $string);
        $string = ucfirst($string);
        $string = preg_replace('/(?<=[a-zA-Z])\d+/', ' $0', $string); // Ajoute un espace avant le nombre si précédé par une lettre
        $string = preg_replace('/\d+(?=[a-zA-Z])/', '$0 ', $string); // Ajoute un espace après le nombre si suivi par une lettre
        $string = trim($string);
        return $string;
    }

}

$wrap = new Wrap();

class Wrap_Folder {
    private $path;
    private $path_url;
    private $childs = [];
    private $files = [];
    private $parents = [];
    private $name;
    private $page_url;
    private $params = [];
    private $stop_navigation = false;

    public function __construct($requested_url) {
        
        if(empty($requested_url)) {
            $requested_url = $_SERVER['REQUEST_URI'];
        }
        $this->page_url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->path_url = $requested_url;
        $this->path = WRAP_DATA . $requested_url;
        if(!file_exists($this->path)) {
            return false;
        }
        $this->parents = $this->get_parents();
        $this->name = Wrap::filename2name(basename($this->path));
        $this->load_params();
        $this->scan_folder();
    }

    private function load_params() {
        $folder_params = $this->path . '/.wrap.json';
        if (file_exists($folder_params)) {
            $json = file_get_contents($folder_params);
            $this->params = json_decode($json, true);
            if(isset($this->params['name'])) {
                $this->name = $this->params['name'];
            }
            if(isset($this->params['stop_navigation'])) {
                $this->stop_navigation = $this->params['stop_navigation'];
            }

        }
    }

    public function stop_navigation() {
        return $this->stop_navigation;
    }

    public function get_params() {
        return $this->params;
    }

    /* get_content
     * Get folder content
     * 
     * @return array
     */
    public function scan_folder() {
        $content = [];
        $files = scandir($this->path);
        $ignore_files = array("playlist.php", "browser.prefs");
        if(is_array($files)) {
            foreach ($files as $file) {
                if ($file[0] == '.' || $file[0] == '_'  || $file[0] == '#' || substr($file, -1) == '~' ) {
                    continue;
                }
                if (in_array($file, $ignore_files)) {
                    continue;
                }
                if (is_dir($this->path . '/' . $file)) {
                    $this->childs[] = $file;
                } else {
                    $this->files[] = $file;
                }
            }
        }
    }
        
    public function get_content() {
        $icons = Wrap::icons();
        $content = '<ul class="files">';
        $playlist = [];
        foreach ($this->files as $filename) {
            $file = new Wrap_File($this->path_url . '/' . $filename);
            $name = $file->name;

            $extension = $file->extension;
            $thumb = $file->get_thumb();
            $icon = isset($icons[$extension]) ? $icons[$extension] : null;
            if(empty($thumb)) {
                $thumb = $icon;
            }
            $content .= sprintf( 
                '<li class="file" data-file="%s"><span class=thumbnail>%s</span> <span class=name>%s</span></li>',
                $this->path_url . '/' . $filename,
                $thumb,
                $name,
            );

            if (in_array($extension, ['mp3', 'wav', 'ogg', 'mp4', 'webm'])) {
                $playlist[] = array(
                    'sources' => array(
                        'src' => Wrap::build_url ($this->path_url . '/' . $filename),
                        'type' => $file->mime_type,
                    ),
                    // 'name' => $file->name,
                    'poster' => $file->get_thumb(false),
                );
            }
        }
        $content .= '</ul>';
        if(!empty($playlist)) {
            // Wrap::queue_script('videojs', 'https://vjs.zencdn.net/7.8.4/video.js');
            // Wrap::queue_style('videojs-style', 'https://vjs.zencdn.net/7.8.4/video-js.css');
            // Wrap::queue_script('videojs-playlist', 'https://cdn.jsdelivr.net/npm/videojs-playlist@4.3.0/dist/videojs-playlist.js');
            
            Wrap::queue_script('videojs', '/dist/videojs.js');
            Wrap::queue_style('videojs', '/dist/videojs.css');

            $playlist_script .= "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var player = videojs('player');
                player.playlist(" . json_encode($playlist) . ");
                player.playlist.autoadvance(0);
                player.playlistUi();

                var prevButton = document.createElement('button');
                prevButton.innerHTML = '&#9664;';
                prevButton.addEventListener('click', function() {
                    player.playlist.previous();
                });

                var nextButton = document.createElement('button');
                nextButton.innerHTML = '&#9654;';
                nextButton.addEventListener('click', function() {
                    player.playlist.next();
                });

                var controlBar = document.getElementsByClassName('vjs-control-bar')[0];
                var playToggle = document.getElementsByClassName('vjs-play-control')[0];

                controlBar.insertBefore(prevButton, playToggle);

                if (playToggle.nextSibling) {
                    controlBar.insertBefore(nextButton, playToggle.nextSibling);
                } else {
                    controlBar.appendChild(nextButton);
                }
            });
            </script>";
            error_log($playlist_script);

            $content = $playlist_script . '<video id="player" class="video-js vjs-default-skin" controls preload="auto" width="640" height="264" data-setup="{}"></video>' . '<p/>' . $content;
        }

        if(!empty($playlist)) {
            // error_log("Playlist: " . print_r($playlist, true));
        }

        return $content;
    }
    public function get_parents() {
        static $parents = null;
        
        if ($parents !== null) {
            return $parents;
        }
        
        $currentPath = $this->path;
        $parentPath = dirname($currentPath);
        $parents = [];

        while ($parentPath != WRAP_DATA && strpos($parentPath, WRAP_DATA) !== false && $parentPath != "/") {
            $parent_url = str_replace(WRAP_DATA, '', $parentPath);
            $folder = new Wrap_Folder($parent_url);
            if($folder->stop_navigation() ) {
                break;
            }
            $parents[] = $parent_url;
            $parentPath = dirname($parentPath);
        }
        $parents = array_reverse($parents);
        $this->parents = $parents;
        return $parents;
    }
    
    public function get_childs() {
        return $this->childs;
    }
    
    public function get_breadcrumb( $include_current = false ) {
        $parents = $this->get_parents();
        
        $breadcrumb = '<ul>';
        foreach ($this->parents as $parent) {
            $folder = new Wrap_Folder($parent);
            $breadcrumb .= '<li><a href="' . Wrap::build_url($parent) . '">' . $folder->get_name() . '</a></li>';
        }
        if($include_current === true) {
            $breadcrumb .= '<li>' . $this->get_name() . '</li>';
        }
        $breadcrumb .= '</ul>';
        return $breadcrumb;
    }

    public function get_name( $folder = null) {
        $folder = $folder ?? $this->name;
        return basename($folder);
    }

    /* get_nav_tree
        * Build full navigation tree, including parent and each up level siblings
        * Instanciate Wrap_folder for each parent to get their childs
        * 
        * @return string
        */
    public function get_nav_tree() {
        $parents = $this->get_parents();
        $parents[] = $this->path_url;
        $tree = array();
        $is_root= true;
        foreach ($parents as $path) {
            $parent = new Wrap_Folder($path);
            if($parent->stop_navigation() ) {
                continue;
            }
            $path_parts = explode('/', trim($path, '/'));
            $current = &$tree;
            foreach ($path_parts as $part) {
                if (!isset($current[$part])) {
                    $current[$part] = array();
                }
                $current = &$current[$part];
            }
            $parent_childs = $parent->get_childs();
            $current = array_fill_keys($parent_childs, null);
        }

        // Call the function with the $tree variable
        $nestedList = $this->nav_tree_html($tree);
        return $nestedList;
    }
    
    public function nav_tree_html($tree, $parent=null) {
        $html = '';
        foreach ($tree as $key => $value) {
            $path = $parent . '/' . $key;
            $folder = new Wrap_Folder($path);
            $parentFolder = new Wrap_Folder($parent);
            $classes = ($path === $this->page_url) ? 'active' : null;
            $child_html = '';
            if (!empty($value)) {
                $child_html = $this->nav_tree_html($value, $path);
            }
            if($parentFolder->stop_navigation() || $folder->stop_navigation() ) {
                $html .= $child_html;
            } else {
                if (!empty($child_html)) {
                    $child_html = '<ul>' . $child_html . '</ul>';
                }
                $html .= sprintf(
                    '<li class="%s"><a href="%s">%s</a>%s</li>',
                    $classes,
                    Wrap::build_url($path),
                    $folder->get_name(),
                    $child_html,
                );
            }
        }
        return $html;
    }

    /* get_nav
     * Get folder navigation
     * 
     * @return string
     */
    public function get_nav() {

        // $content = '<ul>';
        // foreach ($this->childs as $child) {
        //     $content .= '<li><a href="' . $this->path_url . '/' . $child . '">' . $child . '</a></li>';
        // }
        // $content .= '</ul>';
        // $content .= "tree";
        $content = $this->get_nav_tree();
        return $content;
    }
}

class Wrap_File {
    public function __construct($requested_url) {
        $this->path = WRAP_DATA . $requested_url;
        $this->path_url = $requested_url;
        $this->name = Wrap::filename2name($this->path);
        $this->extension = pathinfo($this->path, PATHINFO_EXTENSION);
        $this->mime_type = $this->getMimeType($this->extension);
    }

    private function getMimeType($extension) {
        static $mimes = null;
        if ($mimes === null) {
            $mimes = new \Mimey\MimeTypes;
        }
        return $mimes->getMimeType($extension);
    }
    /**
     * get_thumb
     * 
     * If file is a video, generate a thumbnail if none exist or if the video file is newer than the thumbnail
     */
    public function get_thumb( $output_html = true ) {
        $thumbnail = '/.thumbs/' . $this->path_url . '.jpg';
        $thumbfile = WRAP_DATA . $thumbnail;
        $thumburl = Wrap::build_url($thumbnail);

        if (strpos($this->mime_type, 'video') !== false) {
            if (!file_exists($thumbfile) || filemtime($this->path) > filemtime($thumbfile)) {
                // Create the cache directory if it doesn't exist
                if (!is_dir(dirname($thumbfile))) {
                    mkdir(dirname($thumbfile), 0777, true);
                }

                // Generate a thumbnail from the video file
                $ffmpeg = FFMpeg\FFMpeg::create();
                $video = $ffmpeg->open($this->path);
                $frame = $video->frame(FFMpeg\Coordinate\TimeCode::fromSeconds(0));
                $frame->save($thumbfile);
            }
        }

        if (file_exists($thumbfile) && filesize($thumbfile) > 0) {
            if($output_html) {
                return '<img class="thumbnail" src="' . $thumburl . '" alt="' . $this->name . '">';
            } else {
                return $thumburl;
            }
        }
    }

    /**
     * Raw file output
     */
    public function output() {
        $file = WRAP_DATA . $_SERVER['REQUEST_URI'];
        $size = filesize($file);
        $start = 0;
        $end = $size - 1;

        header('Content-Type: ' . $this->mime_type);
        header("Accept-Ranges: bytes");
        if (isset($_SERVER['HTTP_RANGE'])) {
            $range = $_SERVER['HTTP_RANGE'];
            list($param, $range) = explode('=', $range);
            if (strtolower(trim($param)) != 'bytes') {
                header('HTTP/1.1 400 Invalid Request');
                exit;
            }
            list($from, $to) = explode('-', $range);
            if ($from) {
                $start = intval($from);
            }
            if ($to) {
                $end = intval($to);
            }
            $length = $end - $start + 1;
            header('HTTP/1.1 206 Partial Content');
            header("Content-Length: $length");
            header("Content-Range: bytes $start-$end/$size");
        } else {
            header("Content-Length: $size");
        }

        $fp = fopen($file, 'rb');
        fseek($fp, $start);
        while ($start <= $end) {
            set_time_limit(0);
            print fread($fp, min(1024, $end - $start + 1));
            $start += 1024;
        }
        fclose($fp);
        die();
    }
}
