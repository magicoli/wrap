<?php

##############
## Functions () definition

function localise($string) {
	global $localisation;
	if (isset($localisation["$string"])) {
		return processtags($localisation, $localisation["$string"]);
	} else {
		return $string;
	};
};

function HumanReadableFilesize($size) {

    // Adapted from: http://www.php.net/manual/en/function.filesize.php

    $mod = 1024;

    $units = explode(' ','B KB MB GB TB PB');
    for ($i = 0; $size > $mod; $i++) {
        $size /= $mod;
    }

    return round($size, 2) . ' ' . $units[$i];
}

function decode_unicode_url($str)
{
  $res = '';

  $i = 0;
  $max = strlen($str) - 6;
  while ($i <= $max)
  {
    $character = $str[$i];
    if ($character == '%' && $str[$i + 1] == 'u')
    {
      $value = hexdec(substr($str, $i + 2, 4));
      $i += 6;

      if ($value < 0x0080) // 1 byte: 0xxxxxxx
        $character = chr($value);
      else if ($value < 0x0800) // 2 bytes: 110xxxxx 10xxxxxx
        $character =
            chr((($value & 0x07c0) >> 6) | 0xc0)
          . chr(($value & 0x3f) | 0x80);
      else // 3 bytes: 1110xxxx 10xxxxxx 10xxxxxx
        $character =
            chr((($value & 0xf000) >> 12) | 0xe0)
          . chr((($value & 0x0fc0) >> 6) | 0x80)
          . chr(($value & 0x3f) | 0x80);
    }
    else
      $i++;

    $res .= $character;
  }

  return $res . substr($str, $i);
}

function parseFBEevents ($args) {
	$monthsfr=array(
		" janvier", " février", " mars", " avril", " mai", " juin", " juillet", " août", " septembre", " octobre", " novembre", " décembre");
	$monthsnr=array("-01", "-02", "-03", "-04", "-05", "-06", "-07", "-08", "-09", "-10", "-11", "-12");

	$args=func_get_args();
	eval("\$args=array(" . preg_replace("#\[fbevents:|\]$#", "", $args[0][0]) . ");");
	$eventsurl=$args[0];
	$eventsurl="${eventsurl}?v=app_2344061033";
	$eventscount=$args[1];
	$eventstitle=$args[2];
	$contextopts = array(
		'http'=> array(
			'method'=>   "GET",
			'header'=>"Accept-language: fr",
			'user_agent'=> $_SERVER['HTTP_USER_AGENT']
		)
	);
	$context = stream_context_create( $contextopts );
	$content=file_get_contents($eventsurl, false, $context);
#	$content=utf8_encode($content);
#	$eventsencoding=mb_detect_encoding($content);
#	$content=mb_convert_encoding(
#		$content, 'UTF-8',
#	    mb_detect_encoding($content)
#	);

	$content=decode_unicode_url(str_replace("\u", "%u", $content));

	$content=preg_replace("#.*<div id=\\\\\"future_events\\\\\">#", "", $content);
	$content=preg_replace("#<div id=\\\\\"events_show_past_link\\\\\".*#", "", $content);
	$content=preg_replace("#\\\\/#", "/", $content);
	$content=preg_replace("#\\\\#", "", $content);
	$content=preg_replace("#>#", ">\n", $content);
	$content=preg_replace("#<#", "\n<", $content);
	$content=preg_replace("#\n\n#", "\n", $content);
	$content=preg_replace("#^\n#", "", $content);

	$lines=preg_split("#\n#", $content);
	foreach ($lines as $line) {
		$line=preg_replace("#&nbsp[;]*#", " ", $line);
		if(preg_match("# class=#", $line))
		{
			$class=preg_replace("#.* class=\\\"([a-zA-Z0-9_]*)\\\".*#", "\\1", $line);
			if($class=="partyrow") {
				$eventid=preg_replace("#.* id=\\\"eventrow_([a-zA-Z0-9_]*)\\\".*#", "\\1", $line);
			}
		} else if(! preg_match("#^<#", $line)) {
			if($line=="Où :") {
				$class="place";
			} else if(preg_match("#Quand.*:#", $line)) {
				$class="datelong";
			} else if($line!="") {
				if($eventid) {
					$events[$eventid][$class]=$line;
					if($class="datelong") {
						$date=preg_replace("# de [0-9]*:[0-9]*.*#", "", $line);
						$date=str_replace($monthsfr, $monthsnr, $date);
						$events[$eventid]['date']=$date;
						$events[$eventid]['time']=preg_replace("#.* de ([0-9]*:[0-9]*) .*#", "\\1", $line);
					}
				}
			}
		}
	}
#	echo "$content";
#	exit;

#	if(!empty($items))
#	{
	if(count($events))
	{
		$string="
			<div class='rss'>
				<div class='channelname'>$eventstitle</div>
					<div class='channeldescription'>
					</div>
					<div class='items'>";
		while (list($id, $event)=each($events)) {
			$string.="$îd
						<p class=item>
							<div class=\"itemtitle\">
								<a href=\"http://www.facebook.com/event.php?eid=${id}\" target=_blank>
									$event[etitle]
								</a>
							</div>
							<div class=itemdescription>
								$event[place]<br>
								$event[date] $event[time]
						</p>";
		}
		$string.="
					</div>
				</div>
			</div>";
#	}
}
	return $string;
}

function parseItunes ($args) {
	global $br, $config, $session, $debug, $debugmode, $debuginfo;
	// $monthsnr=array("-01", "-02", "-03", "-04", "-05", "-06", "-07", "-08", "-09", "-10", "-11", "-12");
	$args=func_get_args();
	$url=preg_replace("#\[itunes:|\]$#", "", $args[0][0]);
	$itunescountry="be";
	$url=preg_replace("#/[a-z]*/album/#", "/album/", $url);
	$url=preg_replace("#album/#", "$itunescountry/album/", $url);
	$url=preg_replace("#\?.*#", "", $url);
	// $albumid=preg_replace("#.*/album/#", "", $url);
	//
	// echo "album id: $albumid<br>";

	$contextopts = array(
		'http'=> array(
			'method'=>   "GET",
			'header'=>"Accept-language: fr",
			'user_agent'=> $_SERVER['HTTP_USER_AGENT']
		)
	);
	$context = stream_context_create( $contextopts );
	$content=file_get_contents("$url?l=fr", false, $context);
	$content=decode_unicode_url(str_replace("\u", "%u", $content));

	if(! preg_match("#<div class=\"padder\">#", $content)) {
		return;
	}

	$content=preg_replace("#.*<div class=\"padder\">#", "", $content);
	$title=preg_replace("#</h1>.*#", "", preg_replace("#.*<h1>#", "", $content));
	$artist=preg_replace("#</h2>.*#", "", preg_replace("#.*<h2>#", "", $content));
	$artistlink=preg_replace("#/us/#", "/", preg_replace("#\".*#", "", preg_replace("#.*href=\"#", "", $artist)));
	$artist=preg_replace("#<[^>]*>#", "", $artist);
	$artwork=preg_replace("#</div>.*#", "", preg_replace("#.*<div class=\"artwork\">#", "", $content));
	$albumlink=preg_replace("#\".*#", "", preg_replace("#.*\"http://itunes.apple.com/[a-z]*/album/#", "http://itunes.apple.com/$itunescountry/album/", $content));
	$infos=preg_replace("#<a #", "<a target=itunes_store ", preg_replace("#</ul>.*#", "", preg_replace("#.*<ul class=\"list\">#", "", $content)));
	// $albumlink=preg_replace("#\".*#", "", preg_replace("#<ul role=#"presentation" class="list"><li><a href=\"", "", $content));

	$html="
		<h1>$title</h1>
		<h2><a href=\"$artistlink\" target=_blank>$artist</a></h2>
		<div class=artwork><a href=\"$albumlink\" target=\"itunes_store\">$artwork</a></div>
		<a class=button href=\"$albumlink\" target=\"itunes_store\"><img src=\"http://ax.phobos.apple.com.edgesuite.net/images/web/linkmaker/badge_itunes-sm.gif\" alt=\"" . htmlsafe($title) . "\"/></a>
		$ituneslink
		$infos
		";

	if($html) {
		$html="<div class=itunes>$html</div>";
	}
	return "$html";

	$content=preg_replace("#<div id=\\\\\"events_show_past_link\\\\\".*#", "", $content);
	$content=preg_replace("#\\\\/#", "/", $content);
	$content=preg_replace("#\\\\#", "", $content);
	$content=preg_replace("#>#", ">\n", $content);
	$content=preg_replace("#<#", "\n<", $content);
	$content=preg_replace("#\n\n#", "\n", $content);
	$content=preg_replace("#^\n#", "", $content);

	$lines=preg_split("#\n#", $content);
	foreach ($lines as $line) {
		$line=preg_replace("#&nbsp[;]*#", " ", $line);
		if(preg_match("# class=#", $line))
		{
			$class=preg_replace("#.* class=\\\"([a-zA-Z0-9_]*)\\\".*#", "\\1", $line);
			if($class=="partyrow") {
				$eventid=preg_replace("#.* id=\\\"eventrow_([a-zA-Z0-9_]*)\\\".*#", "\\1", $line);
			}
		} else if(! preg_match("#^<#", $line)) {
			if($line=="Où :") {
				$class="place";
			} else if(preg_match("#Quand.*:#", $line)) {
				$class="datelong";
			} else if($line!="") {
				if($eventid) {
					$events[$eventid][$class]=$line;
					if($class="datelong") {
						$date=preg_replace("# de [0-9]*:[0-9]*.*#", "", $line);
						$date=str_replace($monthsfr, $monthsnr, $date);
						$events[$eventid]['date']=$date;
						$events[$eventid]['time']=preg_replace("#.* de ([0-9]*:[0-9]*) .*#", "\\1", $line);
					}
				}
			}
		}
	}
#	echo "$content";
#	exit;

#	if(!empty($items))
#	{
	if(count($events))
	{
		$string="
			<div class='rss'>
				<div class='channelname'>$eventstitle</div>
					<div class='channeldescription'>
					</div>
					<div class='items'>";
		while (list($id, $event)=each($events)) {
			$string.="$îd
						<p class=item>
							<div class=\"itemtitle\">
								<a href=\"http://www.facebook.com/event.php?eid=${id}\" target=_blank>
									$event[etitle]
								</a>
							</div>
							<div class=itemdescription>
								$event[place]<br>
								$event[date] $event[time]
						</p>";
		}
		$string.="
					</div>
				</div>
			</div>";
#	}
}
	return $string;
}

function parseFromTag ($args) {
	$values=func_get_args();
	$string=$values[0][0];
	$string=preg_replace("#\[rss:(.*)\]#i", "\\1", $string);
	$string=preg_replace('#"#', '', $string);
	$string=preg_replace('#,[ ]*#', ',', $string);
	$args=preg_split('#,#', $string);
	$result=parseRDFtoVar($args[0],$args[1],$args[2],$args[3], $args[4]);
	if ($result)
	{
		return "
		<div class='rss'>$result
		</div>";
	}
}

function parsePlaylists($args) {
	global $sections;
	if(!is_array($args)) {
		return;
	}
	$params=preg_split("#,#",$args[1]);
	$section=$params[0];
	if($section=="*") $section="untitled";
	if(isset($sections[$section])) {
		$html=$sections[$section];
		$html=preg_replace("#<h2 .*</h2>#", "", $html);
		unset($sections[$section]);
		if(isset($params[1])) {
			$html=preg_replace("#<div class=[']*section[']* #", "<div class='section' style='$params[1]'", $html);
		}
	}
#	echo $sections[$section];

	return $html;
}

function parseWeather ($args) {
	$values=func_get_args();
	$string=$values[0][0];
	$string=preg_replace("#\[weather:(.*)\]#i", "\\1", $string);
	$string=preg_replace('#"#', '', $string);
	$string=preg_replace('#,[ ]*#', ',', $string);
	$args=preg_split('#,#', $string);
	#http://weather.yahooapis.com/forecastrss?w=80897&u=c

	# yahoo						80897		615702
	# weather.com				GPXX7711:1	FRXX0076:1
	# World Weather Online		880019		803267
	while (list($key, $WOEID) = each($args)) {
		$result=parseRDFtoVar("http://weather.yahooapis.com/forecastrss?w=80897&u=c");
		if ($result)
		{
			$city=preg_replace("#.*Conditions for ([^,]*),.*#", "\\1", $result);
			$current=preg_replace("#.*Current Conditions[^0-9]*([0-9]*).*#", "\\1", $result);
			$max=preg_replace("#.*High: ([-0-9]*).*#", "\\1", $result);
			$min=preg_replace("#.*Low: ([-0-9]*).*#", "\\1", $result);
			$html.="
				<div class=values>
					<div class=city>$city</div>
					<div class=min>${min}°</div>
					<div class=max>${max}°</div>
				</div>";
			$no="<div class=current>${current}°</div>";
		}
	}
	return "
			<div class=weather>
				<div class=titles>
					<div class=city></div>
					<div class=min>Nuit</div>
					<div class=max>Jour</div>
				</div>
				$html
			</div>";
			$no="<div class=current>Actuel</div>";
/*
	 Current Conditions:
	Light Rain, 26 C
	 Forecast:
	Mon - Showers. High: 29 Low: 25
	Tue - Scattered Thunderstorms. High: 29 Low: 24

	 Full Forecast at Yahoo! Weather
	(provided by The Weather (...)</div>
	*/
}
function reformatFile($file) {
	$lines = file("$file");
	if(count($lines) > 0) {
		$formattedText=implode("<br>", $lines);
		$formattedText=trim($formattedText);
		$formattedText=preg_replace("#\r\n#", "\n", $formattedText);
		$formattedText=preg_replace("#\n\<br\>\n\<br\>#i", "</p>\n<p>", $formattedText);
		$formattedText=preg_replace("#(\<div[^\<\>]*\>)\n\<br\>#i", "\\1\n", $formattedText);
		$formattedText=preg_replace("#(\<br[^\<\>]*\>)<div#i", "<div", $formattedText);
		$formattedText=preg_replace("#(\<[/]*[ph][0-9]*[^\<\>]*\>)\n\<br\>#i", "\\1\n", $formattedText);
		$formattedText=preg_replace("#\<br\>(\<[/]*div)#i", "\\1", $formattedText);
		$formattedText=preg_replace("#\<br\>(\<[/]*[ph])#i", "\\1", $formattedText);
		$formattedText=preg_replace("#(\<[/]*ul[^\<\>]*\>)\n\<br\>#i", "\\1\n", $formattedText);
		$formattedText=preg_replace("#\<br\>(\<[/]*ul)#i", "\\1", $formattedText);
		$formattedText=preg_replace("#(\<[/]*ol[^\<\>]*\>)\n\<br\>#i", "\\1\n", $formattedText);
		$formattedText=preg_replace("#\<br\>(\<[/]*ol)#i", "\\1", $formattedText);
		$formattedText=preg_replace("#(\<[/]*li[^\<\>]*\>)[\n\t ]*\<br\>#i", "\\1\n", $formattedText);
		$formattedText=preg_replace("#\<br\>[ \t]*(\<[/]*li)#i", "\\1", $formattedText);
		$formattedText=preg_replace("#(\<[/]*t[rdh][^\<\>]*\>)[\n\t ]*\<br\>#i", "\\1\n", $formattedText);
		$formattedText=preg_replace("#\<br\>[ \t]*(\<[/]*t[rdh])#i", "\\1", $formattedText);
		$formattedText=preg_replace("#<p>[\n]*(\<h[0-9][^\<\>]*\>)#i", "\\1", $formattedText);
		$formattedText=preg_replace("#(\</h[0-9][^\<\>]*\>)[\n]*</p>#i", "\\1", $formattedText);
		$formattedText=preg_replace("#<p>\n\n*#i", "<p>", $formattedText);
		$formattedText=preg_replace("#\n\n*</p>#i", "</p>", $formattedText);
		$formattedText=preg_replace("#<div>#i", "<div>\n", $formattedText);
		$formattedText=preg_replace("#\n*</div>#i", "</div>", $formattedText);
	}
	$lines=preg_split("#\n#", $formattedText);
	$lastline=count($lines) - 1;
	if(!preg_match("#^<p[ >]|^<div[ >]|^<h[0-9]*[ >]#", $lines[0])) {
		$lines[0]="<p>" . $lines[0];
	}
	if(preg_match("#^<p>#", $lines[$lastline]) &! preg_match("#</p>$#", $lastline)) {
		$lines[$lastline].="</p>";
	}
#	 . "</p>Voilà";
#	}
	$result=join("\n", $lines);
	if(substr_count($result, "<p") > substr_count($result, "</p")) {
		$result.="</p>";
	}

	if($result=="<p></p>") {
		return;
	} else {
		$result=str_replace("<p>", "<p>\n", $result);
		$result=str_replace("</p>", "\n</p>", $result);
		$result=str_replace("\n\n", "\n", $result);
		return $result;
	}
}

function debug($string, $style="new") {
	global $br, $config, $session, $debug, $debugmode, $debuginfo;
	#	$session[debug][]=$string;
	if ($session['notloaded'] || $config['debug'] || $debug || $_REQUEST['debug']==true) {
		if($debugmode=="store") {
			if($style=="new" || empty($debuginfo)) {
				$debuginfo.="</p><p class=debug>";
			} else if($style=="line") {
				$debuginfo.="<br>";
			} else {
				$debuginfo.=" ";
			}
			$debuginfo.=$string;
		} else {
			echo "<p class=debug>debug: $string</p>";
		}
	};
};

function is_external($file)
{
	if (preg_match('#^[a-z]*://#', $file))
	{
		return true;
	}
	return false;
}

function is_playable($file)
{
	global $playable;
	if(!is_array($playable))
	{
		return true;
	}
	reset($playable);
	while(list($key, $extention)=each($playable))
	{
		if(preg_match("#$extention$#", $file))
		{
			return true;
		}
	}
	return false;
}

function is_downloadable($file)
{
	global $downloadable;
	if(!is_array($downloadable))
	{
		return false;
	}
	reset($downloadable);
	while(list($key, $extention)=each($downloadable))
	{
		if(preg_match("#$extention$#", $file))
		{
			return true;
		}
	}
	return false;
}

function rewritelink()
{
	$request = cleanpath(preg_replace('#\?.*#', '', getenv('REQUEST_URI')));
	return $request;
}

function rewritelinkid($id)
{
	return rewritelink() . "?id=$id";
}

function urlsafe($string)
{
	return preg_replace("#%2F#", "/", rawurlencode(preg_replace('#//#', '/', $string)));
}

function quotesafe($string)
{
	return preg_replace('#"#', '&quot;', $string);
}

function htmlsafe($string)
{
	// return htmlentities(utf8_decode($string));
	$string=preg_replace("#&#", "&amp;", $string);
	return $string;
}

function xmlsafe($string)
{
	// return htmlentities(utf8_decode($string));
#	$string=preg_replace("#<?*>#", " ", $htmlsafe($string));
	$string=preg_replace('#<br>#', '<br/>', $string);
	$string=preg_replace('#<br/>#', ' <br/>', $string);
#	$string=htmlentities(utf8_decode($string));
#	$string=htmlentities(utf8_decode($string));
#	$string=preg_replace("#\\\'#", "",trim($string));
#	$string=preg_replace("#\'#", "",trim($string));
#	$string=preg_replace("#<br>#", " ",trim($string));
#	$string=htmlsafe($string);
	return $string;
}

function processtags($type, $data)
{
#	global $format;

	$html=$data;
	if(is_array($type))
	{
		$html=$data;
		while(list($key, $value)=each($type))
		{
			if(!is_string($value)) continue;
			$html=preg_replace("#\[$key\]#", $value, $html);
		}
	}
	else if($format[$type])
	{
		if (is_string($data) && $data != "")
		{
			if (preg_match("#\[$type\]#", $format[$type]))
			{
				$html=preg_replace("#\[$type\]#", $data, $format[$type]);
			}
		}
	}
	return $html;
}

function removeChordPro($string) {
	$string=preg_replace("#{sot}#", "", $string);
	$string=preg_replace("#{eot}#", "", $string);
	$string=preg_replace("#[\n ]*{t:[^}]*}[\n ]*<br>#", "", $string);
	$string=preg_replace("#[\n ]*{c:([^}]*)}[\n ]*#", "<p class=author>\\1</p>", $string);
	$string=preg_replace("#[\n ]*{key:([^}]*)}[\n ]*#", "", $string);
	$string=preg_replace("#\[([A-G][a-z0-9#]*)\]#", "", $string);
	$string=preg_replace("#[\n ]*{t:[^}]*}[\n ]*<br>#", "", $string);
	$string=preg_replace("#[\n ]*{[rR]}[\n ]*#", "<p class=chorus>", $string);
	$string=preg_replace("#[\n ]*{[^}]*}[\n ]*#", "", $string);
	$string=preg_replace("#<p><p(>| [^>]*)>#", "<p\\1>", $string);
	$string=preg_replace("#<p(>| [^>]*)><br>#", "<p\\1>", $string);
	$string=preg_replace("#<br></p>#", "</p>", $string);
	$string=preg_replace("#</p><br><p(>| [^>]*)>#", "<p\\1>", $string);
	return $string;
}

function processChordPro($string) {
	$string=preg_replace("#{sot}#", "<pre>", $string);
	$string=preg_replace("#{eot}#", "</pre>", $string);
	$string=preg_replace("#[\n ]*{t:[^}]*}[\n ]*<br>#", "", $string);
	$string=preg_replace("#[\n ]*{c:([^}]*)}[\n ]*#", "<p class=author>\\1</p>", $string);
	$string=preg_replace("#[\n ]*{key:([^}]*)}[\n ]*#", "<p class=key>" . localise("Key") . ": \\1</p>", $string);
	// $string=preg_replace("#{t:[^}]*}\n*</p>\n*#", "", $string);
	// $string=preg_replace("#{t:[^}]*}\n*#", "", $string);
	// bemol 9837
	// becare 9838
	// diese #9839;
	$string=preg_replace("#\[([A-G])#([a-z0-9]*)\]#", "<span class=chord>\\1&#9839;\\2</span>", $string);
	$string=preg_replace("#\[([A-G])b([a-z0-9]*)\]#", "<span class=chord>\\1&#9837;\\2</span>", $string);
	$string=preg_replace("#\[([A-G][a-z0-9]*)\]#", "<span class=chord>\\1</span>", $string);
	$string=preg_replace("#[\n ]*{t:[^}]*}[\n ]*<br>#", "", $string);
	$string=preg_replace("#</p><br><p#", "<p", $string);
	return $string;
}

function getPageSettings($thisdirectory, $store=false)
{
	global $webroot, $rootdir, $pagesettings, $directory, $subdirscan, $stripnumber, $headstyle, $ogstyle, $checktemplate, $wrap_editable_parts, $cacheroot;
	// $thisdirectory=urldecode($thisdirectory);
	$traces=debug_backtrace();
	$callline=$traces[0]['line'];
	$thisdirectory=preg_replace("#[\?\$].*#", "", $thisdirectory);
	$thisdirectory=cleanpath($thisdirectory);
	$thisdirectory=preg_replace("#^/*#", "", $thisdirectory);
	$thisdirectory=preg_replace("#/*$#", "", $thisdirectory);
	$parent=dirname($thisdirectory);
	if($parent==".") $parent="";
	if($parent!=$thisdirectory && $pagesettings[$parent]['stopnavigation']) {
		$isroot=true;
	}

	if($pagesettings[$thisdirectory]) {
		return $pagesettings[$thisdirectory];
	}

	$playlist=firstValidFile(
		"$webroot/$thisdirectory/_page.conf.plist",
		"$webroot/$thisdirectory/playlist.php"
		);

	$saved_ogstyle=$ogstyle;
	$saved_headstyle=$headstyle;

	if(is_file($playlist))
	{
		$playlisttype=preg_replace("#.*\.#", "", "$playlist");
		switch ($playlisttype) {
			case "php":
			include_once($playlist);
			break;
			case "plist":
			$plist = new CFPropertyList( "$playlist" );
			$plistarray = $plist->toArray();
			foreach($plistarray as $key => $value) {
				eval(" \$$key=\$plistarray[$key];");
			}
			break;
		}
		unset ($key, $value, $plist, $plistarray, $playlisttype);
	}

	$hash_path=base64_encode(cleanpath("$webroot/$directory", true));
	$pagecache="$cacheroot/wrap_$hash_path";

	$part="pagetitle";
	$part_file="$webroot/$thisdirectory/_${part}.txt";

	eval("
	if(file_exists(\"$part_file\")) {
		\$$part=reformatFile(\"$part_file\");
		if(empty(\$$part)) {
			\$$part=\"\";
		}
	}
	");
	eval("
	if(file_exists(\"$pagecache.$part\")) {
		\$$part=reformatFile(\"$pagecache.$part\");
		if(empty(\$$part)) {
			\$$part=\"\";
		}
	}
	");

	if(isset($pagetitle)) {
		if(empty($pagetitle)) {
			$pagetitle="&nbsp;";
		}
		$pagetitle=preg_replace("#</*p[^>]*>#", "", $pagetitle);
		$pagetitle=preg_replace("#^\n*#", "", $pagetitle);
		$pagetitle=preg_replace("#\n*$#", "", $pagetitle);
	}

	if(!preg_match("#^$rootdir/#", "$thisdirectory/")) {
		if($isroot && preg_match("#$thisdirectory#",$directory) &! $rootdir) {
			$store=true;
		} else if(! $root) {
			$store=true;
		} else {
			$store=false;
		}
	}
	if(is_file("$webroot/$thisdirectory/browser.html"))
	{
		$template=cleanpath("$webroot/$thisdirectory/browser.html");
		if(preg_match("#^$thisdirectory#", "$directory")) {
			$checktemplate["./"]=$template;
		}
	}

	if($stopnavigation && preg_match(cleanpath("^/$thisdirectory/"), "/$directory/")
	&& $thisdirectory != $directory) {
		$isroot=true;
	}
	if($isroot) {
		if (preg_match(cleanpath("^/$thisdirectory/"), "/$directory/")) {
			$rootdir=$thisdirectory;
			$pagesettings=array();
		} else {
			return;
		}
	}
	if(preg_match("#\|#", $thisdirectory)) {
		$handleastitle=true;
	}
	if($handleastitle) {
		$menutitle=firstValidValue($menutitle, $pagetitle, " ");
		$pagetitle=$menutitle . "[" . preg_replace("#\|#", "", $thisdirectory). "]";
		// $menutitle=firstValidValue($menutitle, "sep[" . preg_replace("#\|#", "", $thisdirectory). "]");
		$store=true;
	}
	$pagetitle=firstValidValue($pagetitle, generateFolderName($thisdirectory));
	$headtitle=firstValidValue($headtitle, $headstyle, $pagetitle, $menutitle);
	$facetitle=firstValidValue($facetitle, $ogstyle, $headtitle, $headstyle, $pagetitle, $menutitle);
	$menutitle=firstValidValue($menutitle, $pagetitle, $headtitle);

	$ogstyle=$saved_ogstyle;
	$headstyle=$saved_headstyle;


	$level=substr_count(preg_replace("#^$rootdir/#", "", $thisdirectory), "/") + 1;
	if($thisdirectory==$rootdir) {
		$level=1;
	}

	if(!isset($noindex) && preg_match("#^_#", basename($thisdirectory))) {
		$noindex=true;
	}

	$ignoreAdd=$ignore;

	if($hidden) {
		if (preg_match(cleanpath("^/$thisdirectory/"), "/$directory/")) {
			unset($hidden);
		}
	}

	if(preg_match("#^\.#", "$thisdirectory")) $store=false;
	if($store) {
		unset($ignore);

		$pagesettings[$thisdirectory]=get_defined_vars();

		unset($pagesettings[$thisdirectory]['pagesettings']);
		unset($pagesettings[$thisdirectory]['store']);
		if(preg_match("#^$thisdirectory/#", "$directory/")) { $scanbelow=true; }
		if(preg_match("#^$directory/#", "$thisdirectory/")) { $scanbelow=true; }
		if(preg_match("#^$directory/.*/#", "$thisdirectory/")) { $scanbelow=false; }
		if("$thisdirectory/"=="$rootdir/") { $scanbelow=true; }
		if($directory==$rootdir && $thisdirectory != $rootdir) $scanbelow=false;
		if($stopnavigation) {
			$scanbelow=false;
		}
		if($handleastitle) $scanbelow=false;
		if($scanbelow)
		{
			if($customfolders) {
				foreach($customfolders as $subkey => $subvalue) {
					$sister="$thisdirectory/$subkey";
					if(file_exists("$webroot/$sister")) {
						$sisters[$sister]=$sister;
					}
				}
			}
			if(!$hideotherfolders) {
				$d = dir("$webroot/$thisdirectory");
				if($d)
				{
					while($entry=$d->read())
					{
						$sister=urldecode("$thisdirectory/$entry");
						if(is_dir("$webroot/$sister") &! matchesIgnorePattern("$entry/"))
						{
							$sisters[$sister]=$sister;
						}
					}
				}
			}
			if(is_array($sisters)) {
				foreach($sisters as $sister) {
					getPageSettings($sister, true);
				}
			}
		}
	}
	return $pagesettings[$thisdirectory];
}

function titelize($string)
{
	global $capitalizetitle, $stripnumber;

	$string=preg_replace('#([a-z])([A-Z0-9])#', '\\1 \\2', $string);
	$string=preg_replace('#([0-9])([a-zA-Z])#', '\\1 \\2', $string);
	$string=preg_replace('#_#', ' ', $string);
	$string=trim(preg_replace('#  #', ' ', $string));
	$string=preg_replace('#^0*#', '', $string);
	if($stripnumber)
	{
		$string=preg_replace('#^[0-9]*[-\. ]#', '', $string);
	}
	if(!isset($capitalizetitle) || $capitalizetitle) {
		$string=ucfirst($string);
	}
	return $string;
}

function matchesIgnorePattern($entry)
{
	global $ignore;
	return matchesPattern($entry, $ignore);

	if(is_array($ignore))
	{
		reset($ignore);
		while(list($key, $pattern)=each($ignore))
		{
			if(preg_match("#^$pattern$#", $entry))
			{
				return true;
			}
		}
	}
	return false;
}

function matchesPattern($entry, $patterns)
{
	if(!empty($entry) && is_array($patterns))
	{
		reset($patterns);
		while(list($key, $pattern)=each($patterns))
		{
			if(preg_match("#^$pattern$#", $entry))
			{
				return true;
			}
		}
	}
	return false;
}

function generateFileName($file)
{
	global $stripnumber, $allowedvariants, $mimetypes;
	$extension=strtolower(preg_replace('#^.*\.#', '', $file));
	$filetype=preg_replace("#/.*#", "", $mimetypes[$extension]);

	$file=stripVariantSuffix($file);
	// if($allowedvariants[$filetype]) {
	// 	foreach($allowedvariants[$filetype] as $variant) {
	// 		$file=preg_replace("#-$variant\.$extension$#", ".$extension", $file);
	// 	}
	// }

	$name=titelize(preg_replace('#\.[a-zA_Z0-9]*$#', '', urldecode(basename($file))));
	// if($stripnumber)
	// {
	// 	$name=preg_replace('#^[0-9]*[-\. ]#', '', $name);
	// }
	return $name;
}

function generateFolderName($folder)
{
	global $hostname, $sitetitle, $stripnumber;
	$foldername=basename($folder);

	if(!$foldername)
	{
		if($sitetitle != "")
		{
			return "$sitetitle";
		}
		$foldername=$hostname;
		$foldername=preg_replace('#\.[a-zA-Z]*$#', '', $foldername);
		$foldername=preg_replace('#^www\.#', '', $foldername);
		$foldername=preg_replace('#\.#', ' ', $foldername);
	}

	if(!$foldername)
	{
		$foldername="root";
	}
	if($stripnumber)
	{
		$foldername=preg_replace('#^[0-9]*[-\. ]#', '', $foldername);
	}

	$pagetitle=titelize($foldername);

	return $pagetitle;
}

function fileToSimpleArray($file)
{
	//	$fd = fopen($file,"r");
	$content = file($file);

	foreach($content as $line)
	{
		$split=explode('	', $line);
		$id=array_shift($split);
		$array[$id]=implode('	', $split);;
	}
	return $array;
}

function parseAtom($file)
{
	exec("/usr/local/bin/AtomicParsley '$file' -t", $output, $execReturn);
	if($execReturn ==0)
	{
		//	echo "$execReturn: /usr/local/bin/AtomicParsley '$file' -t<br>";
		while(list($key, $line)=each($output))
		{
			if(preg_match("#Atom.*contains:#", $line))
			{
				//		$lineparts=preg_split('#:#', $outputlines);
				$split=preg_split('#"#', $line);
				$arg=$split[1];
				$value=preg_replace('#.*contains:#', '', $line);
				$return[$arg]=$value;
				$lastarg=$arg;
			}
			else
			{
				$return[$lastarg].="\n$line";
			}
		}
		return $return;
	}
	unset($output);
	exec("/usr/local/bin/mp4info '$file' | grep '^ .*:'", $output, $execReturn);
	/*	$this->description=firstValidValue($atoms["desc"], $atoms["@cmt"]);
	$this->longdesc=firstValidValue($atoms["©lyr"], $this->description);
	$this->author=firstValidValue($atoms["©wrt"], $atoms["cprt"]);
	$this->artist=firstValidValue($atoms["©ART"], $atoms["aART"]);
	$this->name=firstValidValue($atoms["©nam"], $this->name);
	*/
	if($execReturn ==0)
	{
		//	echo "$execReturn: /usr/local/bin/AtomicParsley '$file' -t<br>";
		while(list($key, $line)=each($output))
		{
			//		$lineparts=preg_split('#:#', $outputlines);
			$split=preg_split('#:#', trim($line));
			$arg=strtolower(array_shift($split));
			$value=join(":", $split);
			$return[$arg]=$value;
		}
		return $return;
	}
}

function firstValidValue()
{
	$values=func_get_args();
	if(is_array($values))
	{
		while(list($key, $value)=each($values))
		{
			if($value && $value!="")
			{
				return $value;
			}
		}
	}
	return null;
}

function firstWritableFolder() {
	global $webroot, $aliasroot, $debug, $debuginfo;
	$values=func_get_args();
	if(is_array($values[0])) {
		$folders=$values[0];
	} else if(is_array($values)) {
		$folders=$values;
	} else {
		return null;
	}
	foreach($folders as $folder) {
		$checkfile="$folder/.wrapcheck";
		if (is_dir("$folder")) {
			if(touch("$checkfile")) return $folder;
		}
	}
	return null;
}

function firstValidFile()
{
	global $webroot, $aliasroot, $libdir, $debug, $debuginfo;
	$values=func_get_args();
	if(is_array($values[0])) {
		$files=$values[0];
	} else if(is_array($values)) {
		$files=$values;
	} else {
		return null;
	}
	foreach($files as $file) {
		$file=cleanpath($file);
		$libfile="$libdir/" . preg_replace(":^/lib/:", "", $file);
		// debug("file: $libfile");
		if (is_file("$webroot/$file") || is_file($libfile) || file_exists("$file"))
		{
			// debug("found", " ");
			## || file_exists("$aliasroot/$file")  disabled because of log bombing
			return $file;
		}
	}
	return null;
}

function macRomanToIso($string)
{
	return strtr($string,
		"\x80\x81\x82\x83\x84\x85\x86\x87\x88\x89\x8a\x8b
		\x8c\x8d\x8e\x8f\x90\x91\x92\x93\x94\x95\x96\x97
		\x98\x99\x9a\x9b\x9c\x9d\x9e\x9f\xa1\xa4\xa6\xa7
		\xa8\xab\xac\xae\xaf\xb4\xbb\xbc\xbe\xbf\xc0\xc1
		\xc2\xc7\xc8\xca\xcb\xcc\xd6\xd8\xdb\xe1\xe5\xe6
		\xe7\xe8\xe9\xea\xeb\xec\xed\xee\xef\xf1\xf2\xf3
		\xf4\xf8\xfc\xd2\xd3\xd4\xd5",
		"\xc4\xc5\xc7\xc9\xd1\xd6\xdc\xe1\xe0\xe2\xe4\xe3
		\xe5\xe7\xe9\xe8\xea\xeb\xed\xec\xee\xef\xf1\xf3
		\xf2\xf4\xf6\xf5\xfa\xf9\xfb\xfc\xb0\xa7\xb6\xdf
		\xae\xb4\xa8\xc6\xd8\xa5\xaa\xba\xe6\xf8\xbf\xa1
		\xac\xab\xbb\xa0\xc0\xc3\xf7\xff\xa4\xb7\xc2\xca
		\xc1\xcb\xc8\xcd\xce\xcf\xcc\xd3\xd4\xd2\xda\xdb
		\xd9\xaf\xb8\x22\x22\x27\x27"
	);
}

function mac_roman_to_iso($string)
{
	return strtr(
		$string,
		"\x80\x81\x82\x83\x84\x85\x86\x87\x88\x89\x8a\x8b\x8c\x8d\x8e\x8f\x90\x91\x92\x93\x94\x95\x96\x97\x98\x99\x9a\x9b\x9c\x9d\x9e\x9f\xa1\xa4\xa6\xa7\xa8\xab\xac\xae\xaf\xb4\xbb\xbc\xbe\xbf\xc0\xc1\xc2\xc7\xc8\xca\xcb\xcc\xd6\xd8\xdb\xe1\xe5\xe6\xe7\xe8\xe9\xea\xeb\xec\xed\xee\xef\xf1\xf2\xf3\xf4\xf8\xfc\xd2\xd3\xd4\xd5Ð",
		"\xc4\xc5\xc7\xc9\xd1\xd6\xdc\xe1\xe0\xe2\xe4\xe3\xe5\xe7\xe9\xe8\xea\xeb\xed\xec\xee\xef\xf1\xf3\xf2\xf4\xf6\xf5\xfa\xf9\xfb\xfc\xb0\xa7\xb6\xdf\xae\xb4\xa8\xc6\xd8\xa5\xaa\xba\xe6\xf8\xbf\xa1\xac\xab\xbb\xa0\xc0\xc3\xf7\xff\xa4\xb7\xc2\xca\xc1\xcb\xc8\xcd\xce\xcf\xcc\xd3\xd4\xd2\xda\xdb\xd9\xaf\xb8\x22\x22\x27\x27-"
	);
}

//Function to seperate multiple tags one line
function fix_newlines_for_clean_html($fixthistext)
{
	$fixthistext_array = explode("\n", $fixthistext);
	foreach ($fixthistext_array as $unfixedtextkey => $unfixedtextvalue)
	{
		//Makes sure empty lines are ignores
		if (!preg_match("/^(\s)*$/", $unfixedtextvalue))
		{
			$fixedtextvalue = preg_replace("/>(\s|\t)*</U", ">\n<", $unfixedtextvalue);
			$fixedtextvalue = preg_replace("/<(p|span)>\n<(strong|b|a[^>]*)>/U", "<\\1><\\2>", $fixedtextvalue);
			$fixedtextvalue = preg_replace("/<\/(strong|b|a)>\n<\/(p|span)>/U", "</\\1></\\2>", $fixedtextvalue);
			$fixedtext_array[$unfixedtextkey] = $fixedtextvalue;
		}
	}
	return implode("\n", $fixedtext_array);
}

function cleanpath($string, $removetrailing=false) {
	$string=preg_replace("#//*#", "/", $string);
	if($removetrailing) {
		$string=preg_replace("#/$#", "", $string);
	}
	return $string;
}
function htmltotext($string) {
	$string=preg_replace("#\n#", " ", $string);
	$string=preg_replace("#  *#", " ", $string);
	// $string=preg_replace("#> #", ">", $string);
	// $string=preg_replace("# <#", "<", $string);
	$string=preg_replace("#> *<#", "><", $string);
	$string=preg_replace("#^ #", "", $string);
	$string=preg_replace("#<p></p>#", "", $string);
	$string=preg_replace("#</p><p>#", "\n\n", $string);
	$string=preg_replace("#<p>#", "\n\n", $string);
	$string=preg_replace("#</p>#", "\n\n", $string);
	$string=preg_replace("#<br>#", "\n", $string);
	$string=preg_replace("#(<h[0-9]>)#", "\n\\1", $string);
	$string=preg_replace("#(</h[0-9]>)#", "\\1\n\n", $string);
	$string=preg_replace("#</li><li>#", "</li>\n<li>", $string);
	$string=preg_replace("#</li></ul>#", "</li></ul>\n\n", $string);
	$string=preg_replace("#<ul><li>#", "\n\n<ul><li>", $string);
	$string=preg_replace("#<div>#", "\n\n<div>", $string);
	$string=preg_replace("#</div>#", "</div>\n\n", $string);
	$string=preg_replace("# *\n#", "\n", $string);
	$string=preg_replace("#\n *#", "\n", $string);
	$string=preg_replace("#\n\n\n\n*#", "\n\n", $string);
	$string=preg_replace("#^\n*#", "", $string);
	$string=preg_replace("#\n*$#", "", $string);
	return $string;
}
function clean_html_code($uncleanhtml)
{
	//Set wanted indentation
	$indent = "    ";


	//Uses previous function to seperate tags
	$fixed_uncleanhtml = fix_newlines_for_clean_html($uncleanhtml);
	$uncleanhtml_array = explode("\n", $fixed_uncleanhtml);
	//Sets no indentation
	$indentlevel = 0;
	foreach ($uncleanhtml_array as $uncleanhtml_key => $currentuncleanhtml)
	{
		//Removes all indentation
		$currentuncleanhtml = preg_replace("/\t+/", "", $currentuncleanhtml);
		$currentuncleanhtml = preg_replace("/^\s+/", "", $currentuncleanhtml);

		$replaceindent = "";

		//Sets the indentation from current indentlevel
		for ($o = 0; $o < $indentlevel; $o++)
		{
			$replaceindent .= $indent;
		}

		//If self-closing tag, simply apply indent
		if (preg_match("/<(.+)\/>/", $currentuncleanhtml))
		{
			$cleanhtml_array[$uncleanhtml_key] = $replaceindent.$currentuncleanhtml;
		}
		//If doctype declaration, simply apply indent
		else if (preg_match("/<!(.*)>/", $currentuncleanhtml))
		{
			$cleanhtml_array[$uncleanhtml_key] = $replaceindent.$currentuncleanhtml;
		}
		//If opening AND closing tag on same line, simply apply indent
		else if (preg_match("/<[^\/](.*)>/", $currentuncleanhtml) && preg_match("/<\/(.*)>/", $currentuncleanhtml))
		{
			$cleanhtml_array[$uncleanhtml_key] = $replaceindent.$currentuncleanhtml;
		}
		//If closing HTML tag or closing JavaScript clams, decrease indentation and then apply the new level
		else if (preg_match("/<\/(.*)>/", $currentuncleanhtml) || preg_match("/^(\s|\t)*\}{1}(\s|\t)*$/", $currentuncleanhtml))
		{
		    $indentlevel--;
		    $replaceindent = "";
		    for ($o = 0; $o < $indentlevel; $o++)
		    {
		        $replaceindent .= $indent;
		    }

		    // fix for textarea whitespace and in my opinion nicer looking script tags
		    if($currentuncleanhtml == '</textarea>' || $currentuncleanhtml == '</script>')
		    {
		        $cleanhtml_array[$uncleanhtml_key] = $cleanhtml_array[($uncleanhtml_key - 1)] . $currentuncleanhtml;
		        unset($cleanhtml_array[($uncleanhtml_key - 1)]);
		    }
		    else
		    {
		        $cleanhtml_array[$uncleanhtml_key] = $replaceindent.$currentuncleanhtml;
		    }
		}

		//If opening HTML tag AND not a stand-alone tag, or opening JavaScript clams, increase indentation and then apply new level
		else if ((preg_match("/<[^\/](.*)>/", $currentuncleanhtml) && !preg_match("/<(link|meta|base|br|img|hr)(.*)>/", $currentuncleanhtml)) || preg_match("/^(\s|\t)*\{{1}(\s|\t)*$/", $currentuncleanhtml))
		{
			$cleanhtml_array[$uncleanhtml_key] = $replaceindent.$currentuncleanhtml;

			$indentlevel++;
			$replaceindent = "";
			for ($o = 0; $o < $indentlevel; $o++)
			{
				$replaceindent .= $indent;
			}
		}
		else
		//Else, only apply indentation
		{$cleanhtml_array[$uncleanhtml_key] = $replaceindent.$currentuncleanhtml;}
	}
	//Return single string seperated by newline
	return implode("\n", $cleanhtml_array);
}

/**
    * checks for user agent whether this is firefox or not
    * @param void
    * @return bool
    * @author svetoslavm##gmail.com
    * @link http://devquickref.com/
*/
function user_agent() {
	$agent = '';
	// old php user agent can be found here
	if (!empty($HTTP_USER_AGENT))
		$agent = $HTTP_USER_AGENT;
	// newer versions of php do have useragent here.
	if (empty($agent) && !empty($_SERVER["HTTP_USER_AGENT"]))
		$agent = $_SERVER["HTTP_USER_AGENT"];
	if (empty($agent)) {
		return false;
	}
	if(preg_match("/firefox/si", $agent))
		return 'firefox';
	if(preg_match("/opera/si", $agent))
		return 'opera';
	if(preg_match("/safari/si", $agent))
		return 'safari';
	if(preg_match("/webkit/si", $agent))
		return 'webkit';
	return;
}

function stripVariantSuffix($file) {
	global $mimetypes, $allowedvariants;
	$extension=strtolower(preg_replace('#^.*\.#', '', $file));
	$filetype=preg_replace("#/.*#", "", $mimetypes[$extension]);

	if(is_array($allowedvariants[$filetype])) {
		reset($allowedvariants[$filetype]);

		foreach($allowedvariants[$filetype] as $variant) {
			$file=preg_replace("#-$variant\.$extension$#", ".$extension", $file);
		}
	}
	return $file;
}

function findVariants($file) {
	global $webroot, $aliasroot, $mimetypes, $allowedvariants, $files;
	$extension=strtolower(preg_replace('#^.*\.#', '', $file));
	$filetype=preg_replace("#/.*#", "", $mimetypes[$extension]);

	$file=stripVariantSuffix($file);

	if($files[$file]['variants']) {
		return $files[$file]['variants'];
	}

	if(is_array($allowedvariants[$filetype])) {
		reset($allowedvariants[$filetype]);
		foreach($allowedvariants[$filetype] as $variant) {
			$foundvariants[$variant]=firstValidFile(
				preg_replace("#\.$extension$#", "-$variant.$extension", $file),
				preg_replace("#\.$extension$#", "-$variant.mov", $file),
				preg_replace("#\.$extension$#", "-$variant.mp4", $file),
				preg_replace("#\.$extension$#", "-$variant.m4v", $file)
			);
			if($foundvariants[$variant]=="") {
				unset($foundvariants[$variant]);
			}
		}
		if(is_array($foundvariants)) {
			if(!array_search($file, $foundvariants) && firstValidFile($file) ) {
				if(!$foundvariants[$extension]) {
					$foundvariants=array($extension => $file) + $foundvariants;
				} else if(!$foundvariants['original']) {
					$foundvariants=array("original" => $file) + $foundvariants;
				} else {
					$foundvariants=array($file) + $foundvariants;
				}
			}
			$files[$file]['variants']=$foundvariants;
			return $foundvariants;
		}
	} else {
		$foundvariants[]=firstValidFile($file);
		return $foundvariants;
	}
}

#################
## Classes definitions







?>
