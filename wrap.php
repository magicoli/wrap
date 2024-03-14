<?php

require 'vendor/autoload.php';

class Wrap {
    private $data_root;
    private $real_path;
    private $nav;
    private $brand = "Wrap by Magiiic";

    public function __construct() {
        define('WRAP_VERSION', '5.0.0-dev');

        $this->init();
        $this->update_cache();
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
                $this->data_root = $path;
                break;
            }
        }
        define('WRAP_DATA', $this->data_root);
        define('WRAP_DIR', dirname(__FILE__)); // Define WRAP_DIR as the actual script directory
        define('WRAP_URL', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST']);
    }

    public function update_cache() {
        // Cache WRAP_DIR/css/style.css into WRAP_DATA/.css/style.css
        $css_file = WRAP_DIR . '/css/style.css';
        $cache_file = WRAP_DATA . '/.css/style.css';

        if (!file_exists($cache_file) || filemtime($css_file) > filemtime($cache_file)) {
            // Create the cache directory if it doesn't exist
            if (!is_dir(dirname($cache_file))) {
                mkdir(dirname($cache_file), 0777, true);
            }

            // Copy the CSS file to the cache directory
            copy($css_file, $cache_file);
        }
    }

    public function build_page() {
        $requested_url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        if (is_dir($this->data_root . $requested_url)) {
            $wrap_folder = new Wrap_Folder($requested_url);
            $this->content = $wrap_folder->get_content();
            $this->nav = $wrap_folder->get_nav();
            $this->breadcrumb = $wrap_folder->get_breadcrumb();
            $this->title = $wrap_folder->folder_name();

            $this->output_html('<p>Folder requested: ' . $requested_url . '</p>', 'Folder', 'Folder requested: ' . $requested_url, 'folder' );
        } elseif (file_exists($this->data_root . $requested_url)) {
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

        // Update the link to the cached CSS file in the HTML output
        $css_link = WRAP_URL . '/.css/style.css';

        $template = '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>{title}</title>
            <meta name="description" content="{description}">
            <meta name="keywords" content="{keywords}">
            <link rel="stylesheet" href="{css_link}">
            <style>
            </style>
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
            '{css_link}' => $css_link,
        ];

        echo strtr($template, $data);
    }

    public static function getVersion() {
        return WRAP_VERSION;
    }

    static function debug($message) {
        echo "$message\n";
        error_log($message);
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

    public function __construct($requested_url) {
        if(empty($requested_url)) {
            $requested_url = $_SERVER['REQUEST_URI'];
        }
        $this->page_url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->path_url = $requested_url;
        $this->path = WRAP_DATA . $requested_url;
        $this->parents = $this->get_parents();
        $this->name = basename($this->path);
        $this->scan_folder();
    }

    /* get_content
     * Get folder content
     * 
     * @return array
     */
    public function scan_folder() {
        $content = [];
        $files = scandir($this->path);
        foreach ($files as $file) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            if (is_dir($this->path . '/' . $file)) {
                $this->childs[] = $file;
            } else {
                $this->files[] = $file;
            }
        }
    }
    
    public function get_content() {
        $content = '<ul>';
        foreach ($this->files as $file) {
            $content .= '<li>' . $file . '</li>';
        }
        $content .= '</ul>';
        return $content;
    }

    public function get_parents() {
        static $parents = null;

        if ($parents !== null) {
            return $parents;
        }

        $currentPath = $this->path;
        $wrapRoot = WRAP_DATA;
        $parentPath = dirname($currentPath);
        $parents = [];
        while ($parentPath != $wrapRoot) {
            $parents[] = str_replace($wrapRoot, '', $parentPath);
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
            $breadcrumb .= '<li><a href="' . Wrap::build_url($parent) . '">' . $this->folder_name($parent) . '</a></li>';
        }
        if($include_current === true) {
            $breadcrumb .= '<li>' . $this->name() . '</li>';
        }
        $breadcrumb .= '</ul>';
        return $breadcrumb;
    }

    public function folder_name( $folder = null) {
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
        foreach ($parents as $path) {
            $path_parts = explode('/', trim($path, '/'));
            $current = &$tree;
            foreach ($path_parts as $part) {
                if (!isset($current[$part])) {
                    $current[$part] = array();
                }
                $current = &$current[$part];
            }
            $parent = new Wrap_Folder($path);
            $parent_childs = $parent->get_childs();
            $current = array_fill_keys($parent_childs, null);
        }
        error_log("tree: " . print_r($tree, true));
        
        // Call the function with the $tree variable
        $nestedList = $this->nav_tree_html($tree);
        
        return $nestedList;
    }

    public function nav_tree_html($tree, $parent=null) {
        $html = '<ul>';
        foreach ($tree as $key => $value) {
            $path = $parent . '/' . $key;
            error_log("\npath " . $path . "\npage" . $this->page_url);
            $classes = ($path === $this->page_url) ? 'active' : null;
            $html .= sprintf(
                '<li class="%s"><a href="%s">%s</a>',
                $classes,
                Wrap::build_url($path),
                $key
            );
            if (!empty($value)) {
                $html .= $this->nav_tree_html($value, $path);
            }
            $html .= '</li>';
        }
        $html .= '</ul>';
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
    }

    /* output
     * Output raw file, without processing
     * 
     * @return void
     */
    public function output() {
        $file = WRAP_DATA . $_SERVER['REQUEST_URI'];
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        $mimes = new \Mimey\MimeTypes;
        $mime_type = $mimes->getMimeType($extension);
    
        header('Content-Type: ' . $mime_type);
        readfile($file);
        die();
    }
}
