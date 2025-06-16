<?php
/**
 * WRAP Engine Autoloader Bootstrap
 * 
 * This file bootstraps the WRAP engine for standalone usage.
 * It can be included by third-party projects to use WRAP functionality.
 * 
 * Usage:
 *   require_once 'path/to/wrap-engine/autoload.php';
 *   $app = new Wrap\Core\Application();
 */

// Check if we're in a standalone engine installation
require_once __DIR__ . '/vendor/autoload.php';

// Define engine constants
if (!defined('WRAP_ENGINE_PATH')) {
    define('WRAP_ENGINE_PATH', __DIR__);
}

if (!defined('WRAP_ENGINE_VERSION')) {
    define('WRAP_ENGINE_VERSION', '5.5.0-dev');
}

// Bootstrap basic configuration if needed
if (!class_exists('Wrap\Core\Application')) {
    throw new RuntimeException('WRAP Engine classes not found. Check autoloader configuration.');
}
