<?php
/**
 * WRAP Engine Main Entry Point
 * 
 * This is the main entry point for the WRAP engine.
 * It loads the autoloader and defines engine constants.
 * 
 * Usage:
 *   require_once 'path/to/wrap-engine/engine.php';
 */

// Load engine's own dependencies
require_once __DIR__ . '/vendor/autoload.php';

// Define engine constants
if (!defined('WRAP_ENGINE')) {
    define('WRAP_ENGINE', true);
}

if (!defined('WRAP_ENGINE_PATH')) {
    define('WRAP_ENGINE_PATH', __DIR__);
}

if (!defined('WRAP_ENGINE_VERSION')) {
    define('WRAP_ENGINE_VERSION', '5.5.0-dev');
}

// Engine is now ready for use
