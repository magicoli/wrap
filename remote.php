<?php
// phpinfo();

$baseurl="/remote";
$basepath="Users/magic/castings/";
$path=preg_replace("|/*$|", "", $_SERVER['QUERY_STRING']);

$hosts=array(
	"natch" => array(
		'host' => "natch.van-helden.net",
		'user' => 'magic',
		'password' => 'natm00d',
		'pubkeyfile' => '/Users/magic/.ssh/id_rsa',
		'privkeyfile' => '/Users/magic/.ssh/id_rsa.pub',
	),
);

function cleanurl($path) {
	$path=preg_replace("|//*|", "/", $path);
	return $path;
}

function spliturl($path) {
	global $baseurl;
	$path=cleanurl($path);
	$path=preg_replace("|^/|", "", $path);
	$path=preg_replace("|/$|", "", $path);
	$array=explode("/", $path);
	$newpath="";
	$html="";
	while (list($key, $value) = each($array)) {
		$newpath[]="$value";
		$html.="/<a href='$baseurl/" . implode("/", $newpath) . "'>$value</a>";
	}
	return $html;
}

function getdir($connection, $path) {
	$handle = opendir("ssh2.sftp://$sftp/$basepath$path");

}

if (ob_get_level() == 0) ob_start();

$output=array(
	'headers' => NULL,
	'menu' => NULL,
	'body' => NULL,
);
$menu="";

if($path) {
	$host=preg_replace("|^([^/]*)/.*|", "$1", cleanurl($path));
	if(empty($hosts[$host])) {
		ob_end_clean();
		header('HTTP/1.0 404 Not Found');
		echo "<h1>Error 404 Not Found</h1>";
		echo "The host $host is unknown.";
		exit;
	}
	$ssh=$hosts[$host];
	$path=preg_replace("|^$host$|", "", $path);
	$path=preg_replace("|^$host/|", "", $path);
	$pagetitle="<h1>" . spliturl("$host/$path") . "</h1>";

	echo "$pagetitle";

	ob_flush();
	flush();

	$connection = ssh2_connect($ssh['host'], 22);
	(ssh2_auth_password($connection, $ssh['user'], $ssh['password'])) ?: exit;
	// $result=ssh2_auth_hostbased_file($connection, $ssh['user'], $ssh['host'], $ssh['pubkeyfile'], $ssh['privkeyfile']);
	// if(!$result) exit;
	$sftp = ssh2_sftp($connection);
	($handle = opendir("ssh2.sftp://$sftp/$basepath$path")) ?: exit;
	
	
	while ($entry = readdir($handle)) {
		if (preg_match("/^\./", $entry)) continue;
		$link=cleanurl("$baseurl/$host/$path/$entry");
		$output['menu'].="<li><a href='$link'>$entry</a></li>";
		$menus[$entry]=$link;
		$filepath="/$basepath$path/$entry";
		$stats['entry']=ssh2_sftp_stat($sftp, $filepath);
		echo "<p>" . json_encode($filepath);
		echo "<pre>";
		print_r($stats['entry']);
		echo "</pre>";
	ob_flush();
	flush();
	}
	if (isset($menus['sources']) && $menus['web'] && $menus['mp4']) {
		$handle = opendir("ssh2.sftp://$sftp/$basepath$path/sources/.browsercache");
		$output['body']="we're done";
		$output['menu']=NULL;
	}
} else {
	$pagetitle="<h1>Choose remote host</h1>";
	echo "$pagetitle";
	while(list($key, $value) = each($hosts)) {
		$output['menu'].="<li><a href='$key'>$key</a></li>";
	}
}

ob_end_flush();

if ($output['menu']) {
		$output['menu']="<ul>" . $output['menu'] . "</ul>";	
}
echo $output['menu'];
echo "<p>$output[body]</p>";
?>