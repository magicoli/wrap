<?php
#ini_set("memory_limit","500M");

function smartReadFile($location, $filename, $mimeType='application/force-download')
{
	if(empty($filename) || $filename == "") {
		header ("HTTP/1.0 404 Not Found");
		echo "HTTP/1.0 404 Not Found<p>";
		echo "Back to <a href='" . getenv(HTTP_REFERER) . "'>previous page</a>";
		return;
	}

	if(!file_exists($location))
	{
		header ("HTTP/1.0 404 Not Found");
		echo "HTTP/1.0 404 Not Found<p>";
		echo "Back to <a href='" . getenv(HTTP_REFERER) . "'>previous page</a>";
		return;
	}

	if(!file_exists($location))
	{
		header ("HTTP/1.0 404 Not Found");
		echo "HTTP/1.0 404 Not Found<p>";
		echo "Back to <a href='" . getenv(HTTP_REFERER) . "'>previous page</a>";
		return;
	}

	$size=filesize($location);
	$time=date('r',filemtime($location));

	$fm=@fopen($location,'rb');
	if(!$fm)
	{
		header ("HTTP/1.0 505 Internal server error");
		echo "HTTP/1.0 505 Internal server error<p>";
		echo "Back to <a href='" . getenv(HTTP_REFERER) . "'>previous page</a>";
		return;
	}

	$begin=0;
	$end=$size;

	if(isset($_SERVER['HTTP_RANGE']))
	{
		if(preg_match('/bytes=\h*(\d+)-(\d*)[\D.*]?/i', $_SERVER['HTTP_RANGE'], $matches))
		{
			$begin=intval($matches[0]);
			if(!empty($matches[1]))
				$end=intval($matches[1]);
		}
	}

	if($begin>0||$end<$size)
		header('HTTP/1.0 206 Partial Content');
	else
		header('HTTP/1.0 200 OK');  

	header("Content-Type: $mimeType"); 
	header('Cache-Control: public, must-revalidate, max-age=0');
	header('Pragma: no-cache');  
	header('Accept-Ranges: bytes');
	header('Content-Length:'.($end-$begin));
	header("Content-Range: bytes $begin-$end/$size");
	header("Content-Disposition: inline; filename=$filename");
	header("Content-Transfer-Encoding: binary\n");
	header("Last-Modified: $time");
	header('Connection: close');  

	$cur=$begin;
	fseek($fm,$begin,0);

	while(!feof($fm)&&$cur<$end&&(connection_status()==0))
	{
		print fread($fm,min(1024*16,$end-$cur));
		$cur+=1024*16;
	}
}


$f=$_REQUEST['f'];
$DOCUMENT_ROOT=getenv('DOCUMENT_ROOT');
$HTTP_HOST=getenv('HTTP_HOST');
$fullpath=$DOCUMENT_ROOT . "$f";
$filename=basename($f);

smartReadFile($fullpath,$filename);

exit;

if(! $f || !is_file($fullpath))
{
	if(!$f)
	{
		$f="(NULL)";
	} else {
		$f=basename($f);
	}
	header("HTTP/1.0 404 Not Found");
	echo "<!DOCTYPE HTML PUBLIC '-//IETF//DTD HTML 2.0//EN'>
	<HTML>
		<HEAD>
		<TITLE>404 Not Found</TITLE>
		</HEAD>
		<BODY>
		<H1>Not Found</H1>
	The requested URL ${
		f} was not found on this server.<P>
			<HR>
			<ADDRESS>" . ereg_replace(" .*", "", getenv('SERVER_SOFTWARE')) . " Server at " . ereg_replace("^www\.", "", getenv('HTTP_HOST')) . " Port " . getenv('SERVER_PORT') . "</ADDRESS>
			</BODY>
			</HTML>";
	} else {
		$filename=basename($f);
		header("Content-type: application/force-download");
		header("Content-Disposition: attachment; filename=$filename");
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: '. filesize($fullpath));
		header('Pragma: no-cache');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Expires: 0');
		readfile("$fullpath");
	}
	?>
