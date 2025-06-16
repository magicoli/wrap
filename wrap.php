<?php
/**
 * W.R.A.P. (Web Responsive Application Platform) 
 * 
 * This is the main entry point for the W.R.A.P.
 * It contains no logic, it defines the version and the main files to load.
 *
 * @author Magiiic https://magiiic.com/
 * @var [type]
 */

define('WRAP_VERSION', '5.5.0-dev');

// Load the engine
require_once __DIR__ . '/engine/engine.php';

require_once __DIR__ . '/legacy/legacy-wrap.php';
