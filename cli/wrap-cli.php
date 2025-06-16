#!/usr/bin/env php
<?php
/**
 * WRAP CLI Application
 * 
 * Single CLI executable for WRAP commands.
 * 
 * Usage:
 *   ./cli/wrap-cli.php media:convert video.mov --format=mp4
 *   ./cli/wrap-cli.php cache:clear --type=thumbnails
 *   ./cli/wrap-cli.php user:invite john@example.com --project=demo
 */

// Load CLI dependencies
require_once __DIR__ . '/vendor/autoload.php';

// Load engine
$enginePaths = [
    // PHAR context - try different possible paths
    // 'phar://' . \Phar::running(false) . '/engine/engine.php',
    // 'phar://' . \Phar::running(false) . '/../engine/engine.php',

    // Production context - engine is in the same directory
    __DIR__ . '/engine/engine.php',
    // Development context - engine is outside CLI directory
    dirname(__DIR__) . '/engine/engine.php'
];

foreach ($enginePaths as $enginePath) {
    if (file_exists($enginePath)) {
        require_once $enginePath;
        break;
    }
}

// Check if engine loaded properly
if (!defined('WRAP_ENGINE')) {
    echo "Error: WRAP Engine not found or misconfigured.\n";
    foreach ($enginePaths as $path) {
        echo " - $path\n";
    }
    echo "Make sure engine/engine.php exists and composer install was run in engine/ folder.\n";
    exit(1);
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
