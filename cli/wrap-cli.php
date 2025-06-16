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
foreach ([__DIR__, dirname(__DIR__)] as $path) {
    // Temporary workaround during development. In production, the
    // engine path will be __DIR__ . '/engine' or similar, not outside
    // the cli directory.
    if(file_exists($path . '/engine/engine.php')) {
        require_once $path . '/engine/engine.php';
        break;
    }
}

// Check if engine loaded properly
if (!defined('WRAP_ENGINE')) {
    echo "Error: WRAP Engine not found or misconfigured.\n";
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
