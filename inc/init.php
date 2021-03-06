<?php
if ( ! defined( 'WRAP_INC' ) ) die ;

define('BASE_URI', dirname(getenv('SCRIPT_NAME')) );
define('BASE_PATH', dirname(getenv('SCRIPT_FILENAME')) );
define('BASE_URL', getenv('REQUEST_SCHEME') . '://' . preg_replace(":/*$:", "/", getenv('HTTP_HOST') . BASE_URI ));
define('DEFAULT_THEME', 'flex' );
defined('DEBUG') or define('DEBUG', false);
defined('DOCUMENT_ROOT') or define('DOCUMENT_ROOT', getenv('DOCUMENT_ROOT'));

$hostname=getenv('HTTP_HOST');
$domain = preg_replace("(^preview\.|^wrap\.|^dev\.|^www\.)", "", $hostname);
// $webroot=getenv('DOCUMENT_ROOT');
$scriptroot=dirname(getenv('SCRIPT_FILENAME'));
$scriptfilename=basename(getenv('SCRIPT_FILENAME'));
$theme = DEFAULT_THEME;

// ini_set("error_reporting",  E_ALL & ~E_NOTICE & ~E_DEPRECATED);
// Turn off all error reporting
error_reporting(0);

$protocol=preg_replace("/:.*/", "", getenv("SCRIPT_URI"));
if(preg_match("/^dev\.|^local\.|^preview\./", getenv("HTTP_HOST"))) {
	ini_set("display_errors", true);
	$localserver=true;
}

$timebegin=time();

$libdir=dirname(__FILE__);
$libdirurl=dirname($_SERVER['SCRIPT_NAME']);
$scriptname="wrap";
