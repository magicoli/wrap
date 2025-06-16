#!/usr/bin/env php
<?php
/**
 * WRAP CLI Application
 * 
 * Single CLI executable for WRAP commands.
 * 
 * Usage:
 *   ./wrap media:convert video.mov --format=mp4
 *   ./wrap cache:clear --type=thumbnails
 *   ./wrap user:invite john@example.com --project=demo
 */

define('WRAP_CLI_PATH', __DIR__);
require_once WRAP_CLI_PATH . '/vendor/autoload.php';

if(!defined('WRAP_ENGINE_PATH')) {
    // Leave the option to define WRAP_ENGINE_PATH externally for other 
    // flexibility on other projects integrations
    define('WRAP_ENGINE_PATH', dirname(__DIR__) . '/engine');
}

use Symfony\Component\Console\Application;

$app = new Application('WRAP CLI', '5.5.0-dev');

// Register commands here as they're developed
// $app->add(new \Wrap\Cli\Command\MediaConvertCommand());
// $app->add(new \Wrap\Cli\Command\CacheClearCommand());
// $app->add(new \Wrap\Cli\Command\UserInviteCommand());

// For now, show available commands structure
$app->setDefaultCommand('list');

try {
    $app->run();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
