<?php
ini_set("error_reporting",  E_ALL & ~E_NOTICE & ~E_DEPRECATED);
$protocol=preg_replace("/:.*/", "", getenv("SCRIPT_URI"));

if(preg_match("/^dev\.|^local\.|^preview\./", getenv("HTTP_HOST"))) {
	ini_set("display_errors", true);
	$localserver=true;
}

$timebegin=time();

$libdir=dirname(__FILE__);
$libdirurl=dirname($_SERVER['SCRIPT_NAME']);
$scriptname="wrap";

$requires=array(
	"functions.php",
);
foreach ($requires as $require) {
	if (is_file($require)) {
		require_once($require);
	}
}

$includes=array(
	"$libdir/rssfeed.php",
	"$libdir/cfpropertylist/CFPropertyList.php",
	"$libdir/Mobile_Detect.php",
	"$libdir/../Mobile_Detect.php",
);

foreach ($includes as $include) {
	if (is_file($include)) {
		include_once($include);
	}
}

$largelinktype="next";
$debugmode="store";
$popup=true;
$popupnav=true;
$popupnavtitle=true;
$popupnavfirst=false;
$popupnavautohide=true;
$popupcenterheight=true;
$popuphide=array("social", "about", "playlists");
// $popuphide=array("playlists");
#onClick='windowHide("playlists"); popOn("0");'>
#onClick='windowHide("pagetitle");windowHide("about");windowHide("playlists"); popOn("0");'>

$buttonprevious="&lt;";
$buttonnext="&gt;";
$buttonbegin="&lt;&lt;";
$buttonfirst="|&lt;";
$buttonlast="&gt;|";
$buttonpause="||";
$buttonplay="&#9658;";
$buttonclose="<b>X</b>";

$levelisetitles=true;

$popupinblanket=true;
// $videofallback='jwplayer';
// $videofallback='mediaelement';
// $videofallback='videojs';

$slideshow=false;
$downloadOnly=false;
if(preg_match("/^dev\.|^local\.|^preview\./", getenv("HTTP_HOST"))) {
	$noindex=true;
} else {
	$noindex=false;
}
$downloadAllowed=false;
$playListIntro = "/media/in.mov";
$movieOut = "/media/out.mov";
$menusisters=false;
$menuchilds=false;
$hidechilds=false;
$menutop=false;
$menumain=true;
$menutopincluderoot=false;
$tree_minlevel=1;
$tree_maxlevel=999;
$kioskmode=false;
$titleinnav=true;
$capitalizetitle=true;
$stripnumber=false;
$flashplaylist=false;
$flashplaylistlength=4;
$maxchilds=5;
$includemainstyle=true;
$includeparentstyle=true;
$width=640;
$height=360;
$thumbwidth=160;
$thumbheight=120;
$largewidth=800;
$largeheight=600;
$facebooklinks=true;
$facebooklinksitems=false;
$facebooklinksend=false;
$facebookcommentspages=false;
$facebookcommentsitems=false;
$fb_comments_width="auto";
$facebooktags=true;
$default_fb_app_id="217300954968904";
$fbadmins="582749884";
$defaultposter=NULL;

$logo="
<div class=logo>
	<a href='$protocol://www.magiiic.com/' target=magiiic>
		<img alt='WRAP by Magiic' src='$protocol://www.magiiic.com/images/magiiic-wrap-black.png'>
	</a>
</div>";
$footerlogo=$logo;


$cloudmax=10;

$controller='true';
$autoplay='true';
$cache='true';
$scale='aspect';
$columns=4;
$playerbgcolor='';
$filter=".mov";
$multifilter=array(
	".bin",
	".mov",
	".mpeg",
	".mpg",
	".m4v",
	".mp4",
	".m4p",
	".avi",
	".flv",
	".mp3",
	".wav",
	".aif",
	".doc",
	".pdf",
	".jpg",
	".jpeg",
	".png",
	".JPG",
	".zip",
	".tgz",
	".tar",
	".gz",
	".ZIP"
);
$cachedir='.browsercache';
$showdirectories=true;
$showotherdircontent=true;
// $showotherfolders=true; unused, replaced by $hideotherfolders
$hideotherfolders=false;

$showplayallbutton=true;
$playallonsingleline=false;
$podcast=false;

$aliasroot="/usr/local/www";

$allowedvariants["video"]=array(
	"original",
	"flv",
	"screen",
	"standard",
	"iPhone",
	"large",
	"dv",
	"sd",
	"hd",
	"hd576",
	"hd720",
	"hd1080",
	"full"
	);

$ignore=array (
	".*_files/",
	"_.*",
	".*.plist",
	"playlist.php",
	"browser.html",
	"$scripname.html",
	"home.html",
	"links.txt",
	"text.txt",
	"about.txt",
	"right.txt",
	"left.txt",
	"index.[a-zA-Z0-9]*",
	"css/",
	"scripts/",
	"cgi-bin/",
	"disabled/",
	"webstat.*/",
	"images/",
	"img/",
	"php-residence/",
	"preview/",
	"google.*.html",
	".*-old/",
	".*-dv.*",
	".*-large.*",
	".*_fichiers/",
	".*-thumb.*",
	".*-poster.*",
	".*-poster.*",
	".*~",
	"\..*"
);
$forbidden=array(
	"^/lib[/$]",
);
$htmlfiles=array(
	".*.htm",
	".*.html",
	".*.php"
	);

$playable=array (
	".mov",
	".mpeg",
	".mpg",
	".wmv",
	".flv",
	".mp4",
	".m4p",
	".m4v",
	".mp3"
);
$html5_playable=array(
	"mp4",
	"m4v",
	"ogv",
	"ogg",
	"webm"
);

$downloadable=array (
	".toast",
	".dmg",
	".doc",
	".xls",
	".pdf",
	".zip",
	".bin",
	".tgz",
	".tar",
	".gz",
);

$popable=array(
	"image" => true,
	"video" => true,
);

$mimetypes=array(
	"toast" => "application/octet-stream",
	"bin" => "application/octet-stream",
	"dmg" => "application/octet-stream",
	"mov" => 'video/quicktime',
	"mp4" => 'video/mp4',
	"m4v" => 'video/mp4',
	"m4p" => 'video/mp4',
	"mp3" => 'audio/mpeg',
	"wmv" => 'video/wmv',
	"ogv" => 'video/ogg',
	"ogg" => 'video/ogg',
	"webm" => 'video/webm',
	"pdf" => 'application/pdf',
	"jpg" => 'image/jpeg',
	"jpeg" => 'image/jpeg',
	"png" => 'image/png',
	"gif" => 'image/gif',
);

$wrap_rights['fb_582749884']['/']=true;

$wrap_editable_parts=array(
	"about",
	"pagetitle",
	"left",
	"right",
);

$localisations['fr']=array(
	"activate" => "activer",
	"deactivate" => "désactiver",
	"show" => "afficher",
	"hide" => "masquer",
	"connect" => "connecter",
	"disconnect" => "déconnecter",
	"normal view" => "vue normale",
	"edition" => "édition",
	"Connected as" => "Connecté[e] en tant que",
	"connected" => "connecté[e]",
	"Key" => "Clef",
);
$localisation=array();

$addons['fbauth']=true;
$addons['aloha']=true;

$charset="utf-8";
setlocale(LC_ALL, "fr_BE.UTF-8");

if(preg_match('/iPad/', getenv('HTTP_USER_AGENT'))) {
	$output='iPad';
} else {
	if(preg_match('/iPhone|iPad|iPod/', getenv('HTTP_USER_AGENT')) || $_REQUEST['force']=="iPhone") {
		$output='iPhone';
		$onload.='window.scrollTo(0, 1);';
		$bodyclasses['smartphone']="smartphone";
		$bodyclasses['iphone']="iPhone";
	}
}
$detect = new Mobile_Detect();
// isAndroid(), isBlackberry(), isOpera(), isPalm(), isWindows(), isGeneric().
if ($detect->isMobile()) {
	$bodyclasses['smartphone']="smartphone";
} else {
  $bodyclasses['not-smartphone']="not-smartphone";
}

// if(ereg('iPhone|iPod', getenv('HTTP_USER_AGENT')) || $_REQUEST['force']=="iPhone")
// {
// }

#$output='iPhone';
#$onload='onload="window.scrollTo(0, 1)"';

##############
## Variables definitions

session_start();

$cloud=array();

$session['notloaded']=true;

#################
## Fetch session variables

$hostname=getenv('HTTP_HOST');
$domain = preg_replace("(^preview\.|^wrap\.|^dev\.|^www\.)", "", $hostname);
$webroot=getenv('DOCUMENT_ROOT');
$useragent=user_agent();
$scriptroot=dirname(getenv('SCRIPT_FILENAME'));
$scriptfilename=basename(getenv('SCRIPT_FILENAME'));

if(!isset($_SESSION['source_referer']))
{
    $_SESSION['source_referer'] = $_SERVER['HTTP_REFERER'];
}
$referer=$_SESSION['source_referer'];
// open_basedir
$cacheroot=firstWritableFolder(
	dirname($webroot) . "/tmp",
	"$scriptroot/wrap/cache",
	dirname($scriptroot) . "/cache/wrap",
	"$webroot/wrap/cache",
	dirname($scriptroot) . "/tmp",
	"$webroot/cache",
	"/tmp/wrap",
	"/tmp"
);

// echo "cacheroot: $scriptroot";

$siteurl="$protocol://$hostname";
$requesturi=getenv('REQUEST_URI');
$uri=ereg_replace("[\?\$].*", "", $requesturi);
$requesturl="$siteurl$requesturi";

$url="$siteurl$uri";
// $strippedurl=ereg_replace("\?.*", "", $url); (removed: same as $url)

$cleanurl=ereg_replace("\?$", "",
			eregi_replace("debug=[^&]*[&]*", "",
			eregi_replace("interaction=like[&]*", "",
			$url)));
$encodedurl=urlencode($cleanurl);

$directory=ereg_replace('^/*', '', urldecode(dirname($uri . "remove.php")));
// $directoryclean="/$directory/";
// $directoryclean=ereg_replace('^[/]*', '/', $directoryclean);
// $directoryclean=ereg_replace('//*$', '/', $directoryclean);
$directoryclean=cleanpath("/$directory/");

$hash_path=base64_encode(cleanpath("$webroot/$directory", true));
$pagecache="$cacheroot/wrap_$hash_path";

foreach ($forbidden as $pattern) {
	if (ereg($pattern, $directoryclean)) {
		header('HTTP/1.1 403 Forbidden');
		header('Location: /');
		exit;
	}
}
$foldername=basename($directory);

##########
## Facebook API
## Disabled because hash_hmac sucks, replaced by a mini-api


$facebookapi=true;

if(!is_file("$libdir/facebook-php-sdk/facebook.php")) {
	$facebookapi=false;
}
if (!function_exists('curl_init')) {
	$facebookapi=false;
}
if (!function_exists('json_decode')) {
	$facebookapi=false;
}

if (!function_exists('hash_hmac')) {
	function hash_hmac($algo, $data, $key, $raw_output = false)
	{
	    $algo = strtolower($algo);
	    $pack = 'H'.strlen($algo('test'));
	    $size = 64;
	    $opad = str_repeat(chr(0x5C), $size);
	    $ipad = str_repeat(chr(0x36), $size);

	    if (strlen($key) > $size) {
	        $key = str_pad(pack($pack, $algo($key)), $size, chr(0x00));
	    } else {
	        $key = str_pad($key, $size, chr(0x00));
	    }

	    for ($i = 0; $i < strlen($key) - 1; $i++) {
	        $opad[$i] = $opad[$i] ^ $key[$i];
	        $ipad[$i] = $ipad[$i] ^ $key[$i];
	    }

	    $output = $algo($opad.pack($pack, $algo($ipad.$data)));

	    return ($raw_output) ? pack($pack, $output) : $output;
	}
}

if($facebookapi) {
	include_once("$libdir/facebook-php-sdk/facebook.php");
}

if(!function_exists("base64urldecode")) {
	function base64UrlDecode($input) {
    	return base64_decode(strtr($input, '-_', '+/'));
  	}
}

if($_POST['signed_request'] || $_REQUEST['force']=="facebook") {

	// debug(print_r($_POST), true);

	$signed_request=$_POST['signed_request'];

    list($encoded_sig, $payload) = explode('.', $signed_request, 2);
	    // decode the data
    $sig = base64UrlDecode($encoded_sig);
	if(function_exists('json_decode')) $session['fb_data'] = json_decode(base64UrlDecode($payload), true);

	if($session['fb_data']['page']['id'] || $_REQUEST['force']=="facebook") {
		$facebooked=true;
		$head.="<base target=_top/>";
	} else if ($session['fb_data']['user_id']) {
		$facebookapp=true;
		$head.="<base target=_top/>";
	}
	if($session['fb_data']['page']['liked']) {
		$liked=true;
		$additionalmessage="Moi aussi, je vous aime";
	}
}

#################
## Fetch preferences

$path=split('/', ereg_replace('/$', '', $uri));

if(is_file("$libdir/css/browser.css")) {
	$combinedcss.="
		<link href='$libdirurl/css/browser.css' rel='stylesheet' media='all'>";
	$inpagecss.=file_get_contents("$libdir/css/browser.css");
}
// if(is_file("$libdir/css/$scriptname.css")) {
// 	$combinedcss.="
// 		<link href='$libdirurl/css/$scriptname.css' rel='stylesheet' media='all'>";
// 	$inpagecss.=file_get_contents("$libdir/css/$scriptname.css");
// }

if(is_array($path))
{
	$prefsfolders=array($scriptroot, "$webroot/lib");
	$prefsfolder=$webroot;
	if($includeparentstyle) {
		while(list($key, $value)=each($path))
		{
			$prefsfolder .= "/$value";
			$prefsfolders[]=$prefsfolder;
		}
	}

	while(list($key, $value)=each($prefsfolders))
	{
		if(is_file("$value/_section.conf.plist")) {
			$plist = new CFPropertyList("$value/_section.conf.plist");
			$sectionconf=$plist->toArray();
			foreach($sectionconf as $pagevar => $pagevalue) {
				if($pagevar != 'playlist') {
					debug("lost $pagevar", "line");
					eval("\$$pagevar=\$sectionconf['$pagevar'];");
				}
			}

		} else if(is_file("$value/browser.prefs")) {
			include("$value/browser.prefs");
		}
		// if(is_file("$value/browser.html")) {
			// $checktemplate[]=cleanpath("$value/browser.html");
		// };
	}

	if($private) {
		$noindex=true;
		$facebooktags=false;
		$facebooklinks=false;
		$facebooklinksitems=false;
		$facebooklinksend=false;
		$facebookcommentspages=false;
		$facebookcommentsitems=false;
	}

	reset($path);

	while(list($key, $value)=each($path))
	{
		$prefsfolder .= "/$value";
		$currenturl.=urldecode("/$value");
		$currenturl=ereg_replace('^/*', '', $currenturl);
		$currenturl=cleanpath($currenturl);

		$prefsfolders[]=$prefsfolder;

		#			echo "browsing $currenturl<br>";
		#			echo "now '$currenturl'<br>";

		getPageSettings("$currenturl", true);

		if($pagesettings[$currenturl]['isroot']) {
			if(!$includeparentstyle) {
				unset($combinedcss);
			}
		}

		if(is_file("$webroot/$currenturl/browser.css")) {
#			$browsercss=$siteurl . ereg_replace("//", "/", "/${currenturl}/browser.css");
			$browsercss=ereg_replace("//", "/", "/${currenturl}/browser.css");
			$combinedcss.="
				<link href='$browsercss' rel='stylesheet' media='all'>";
			$inpagecss.=file_get_contents("$webroot/$currenturl/browser.css");
		}
		if(is_file("$webroot/$currenturl/browser-mobile.css")) {
			$browsermobile=ereg_replace("//", "/", "/${currenturl}/browser-mobile.css");
			$combinedmobilecss.="
				<link href='$combinedmobilecss' rel='stylesheet' media='all'>";
		}
	}
}
else
{
	$pagetitle="blob";
	$page['title']="blob";
}

#$pagetitle=generateFolderName($directory);
$pagetitle=$pagesettings[$directory]['pagetitle'];

$playerheight=$height + 16;

if ($kioskmode && strtolower($kioskmode) != "false" && strtolower($kioskmode) != "0")
{
	$kioskmode='true';
}
else
{
	$kioskmode="false";
}

// $devip="charbon.van-helden.net";
// if(gethostbyname($devip)==getenv('REMOTE_ADDR')) {
// 	$debug=true;
// }

if(!$debug) {
	unset($debuginfo);
}
unset($session['notloaded']);

if($fbappid) {
	## tweak to unify fb var names
	$fb_app_id=$fbappid;
}
if($fb_app_id) {
	$fb_param_appid=$fb_app_id;
} else {
	$fb_param_appid=$default_fb_app_id;
}
$fb_init="<div style=\"margin-top: 0px\" id=\"fb-root\"></div><script src=\"$protocol://connect.facebook.net/fr_FR/all.js#appId=$fb_param_appid&amp;xfbml=1\"></script>";

if($facebooked || $facebookapp) {
	$bodyclasses[]="simplified";
	$fbtweak="
	<div id=\"fb-root\"></div>
	<script>
	window.fbAsyncInit = function() {
		FB.init({appId: '$fb_param_appid', status: true, cookie: true, xfbml: true});
	};
	(function() {
		var e = document.createElement('script'); e.async = true;
		e.src = document.location.protocol +
		'//connect.facebook.net/fr_FR/all.js';
		document.getElementById('fb-root').appendChild(e);
	}());
	window.fbAsyncInit = function() {
		FB.Canvas.setAutoResize();
	}
	</script>";
}


if(is_array($localisations[$language])) {
	if(is_array($localisation)) {
		$localisation=array_merge($localisations[$language], $localisation);
	} else {
		$localisation=$localisations[$language];
	}
}
########################
## Add additional addons

$wrap_editable=false;
$hassomerights=false;
$wrapmode="view";
unset($auth_name);

## update maintainers cache

if(is_array($wrap_rights)) {
	reset($wrap_rights);
	foreach($wrap_rights as $cacheduser => $rights) {
		$usercache="$cacheroot/wrap_info_$cacheduser.info";
		$fb_user=ereg_replace("^fb_", "", $cacheduser);
## causes big lag, disabled for now, don't remember the purpose anyway
#		if(!file_exists($usercache) &! $localserver) {
#			$graph=file_get_contents("https://graph.facebook.com/$fb_user");
#			if($graph) file_put_contents($usercache, $graph);
#		}
		if(file_exists($usercache) && function_exists('json_decode')) {
			$users[$cacheduser] = json_decode(file_get_contents($usercache));
		}
	}
}

## Facebook authentication
require_once("modules/fbauth/fbauth.php");
require_once("modules/videosub.php");
// require_once("modules/video-js/video-js.php");

unset($_SESSION['debug']);

if(($auth_id && ereg("magiiic.com$", $hostname) || $localserver)) {
	if($_GET['auth']) {
		$_SESSION['request']=$_REQUEST;
		$_SESSION['request']['referer']=getenv("HTTP_REFERER");
		if(!$_SESSION['request']['referer'] && $localserver) {
			$_SESSION['request']['referer']="$protocol://dev.van-helden.net/wrap/?wrap=connect";
		}
	}
	if($_SESSION['request']['auth']) {
		// if(is_array($_SESSION['request'])) {
		// 	$authinfo[]="<p>Request</p>";
		// 	foreach($_SESSION['request'] as $key => $value) {
		// 		$authinfo[]="$key: $value";
		// 	}
		// }

		if (validateAuthRequest()) {
		};

		if($_SESSION['auth']['format']=="inside") {
			header("Content-Type: text/text; charset=$charset");
			echo json_encode($_SESSION['auth']);
			exit;
		} else {
			$wrap_info.="<div class=notification>";
			if(is_array($_SESSION['auth'])) {
				$authinfo[]="<p>Auth</p>";
				foreach($_SESSION['auth'] as $key => $value) {
					$authinfo[]="$key: $value";
				}
			}
			if(is_array($authinfo)) {
				$wrap_info.=join("<br>", $authinfo);
			} else {
				$wrap_info.=localise("can not fetch auth result");
			}
			$wrap_info.="</div>";
		}
	}
}

if($_SESSION['wrap']['connected']) {
	$wrap_connect_buttons.="<a class=button href=\"?wrap=disconnect\">" . localise("disconnect") . "</a>";
} else if($user->id || $localserver) {
	$wrap_connect_buttons.="<a class=button href=\"?wrap=connect\">" . localise("connect") . "</a>";
}

if($localserver &! $_SESSION['wrap']['disconnected']) {
	$wrap_editable=true;
	$hassomerights=true;
	if(!empty($wrapdirs)) {
		$wrapdirs="<div class=wrapdirs>Editable sections<ul class=wrapdirs>$wrapdirs</ul></div>";
	}
	if (!$auth_name) {
		$auth_name="Local server";
	}
}

if($_SESSION['wrap']['connected']) {
	if($auth_name) {
		switch($_REQUEST['toolbox']) {
			case "enable":
			$_SESSION['wrap']['toolbox']=true;
			$_SESSION['wrap']['edit']=true;
			$redirect=$url;
			break;
			case "disable":
			$_SESSION['wrap']['toolbox']=false;
			$redirect=$url;
			break;
		}
		// if($_SESSION['wrap']['toolbox']) {
		// 	// $wrap_buttons.="<a class=button href=\"?wrap=disable\">" . localise("hide") . "</a>";
		// } else {
		// 	// $wrap_buttons.="<a class=button href=\"?wrap=enable\">" . localise("show") . "</a>";
		// 	// unset($wrap_editable);
		// 	// unset($hassomerights);
		// 	unset($editmode);
		// }
	}

	if(($hassomerights || $wrap_editable)) {

		// $jasonfolder=base64_encode(json_encode("$editedpage"));

		// getPageSettings("/wrap", true);
		if($wrap_editable) {
			switch($_REQUEST['edit']) {
				case "false":
				case "disable":
				$_SESSION['wrap']['edit']=false;
				$redirect=$url;
				break;
				case "true":
				case "enable":
				$_SESSION['wrap']['edit']=true;
				$redirect=$url;
			}

			if($_SESSION['wrap']['edit']) {
				$wrapmode="edit";
				$editmode=true;
				$keeptags=true;
				$editbuttons="<a class=button href=?edit=false>" . localise("normal view") . "</a>"
							."<a class=button id=active href=?edit=true>" . localise("edition") . "</a>";
			} else {
				$wrapmode="view";
				$editbuttons="<a class=button id=active href=?edit=false>" . localise("normal view") . "</a>"
							."<a class=button href=?edit=true>" . localise("edition") . "</a>";
			}
			$wrap_buttons.=$editbuttons;
		}
		$wrapbox.=$wrap_buttons;
		if(!$cacheroot) {
			$wrapbox.="<div class=error>no valid cache dir, changes will not be saved</div>";
		// } else {
		// 	$wrapbox.="$cacheroot";
		}
		if($localserver) {
			$wrap_info.="<span class=warning>FB login disabled</span>";
		}
	}
	if($_SESSION['wrap']['toolbox']) {
		if($wrapbox) {
			$wrapbox="<div class=wrapbox>"
			. "<div class=name>WRAP</div>"
			. "<a class=button href=\"?toolbox=disable\">" . localise("hide") . "</a>"
			. "$wrapbox$wrap_connect_buttons</div>";
		}
	} else if($_SESSION['wrap']['connected']) {
		$wrapbox="
			<div class=wrapbox>
				<a class=button href=\"?toolbox=enable\">W</a>
			</div>";
	}
}
// if($wrap_buttons || $wrap_connect_buttons) $wrap_buttons="<div class=wrap_buttons>$wrap_buttons$wrap_connect_buttons</div>";
if($wrap_connect_buttons) $wrap_buttons="<div class=wrap_buttons>$wrap_connect_buttons</div>";
if($wrap_info) $wrap_info="<div class=wrapinfo>$wrap_info</div>";

if(isset($redirect)) {
	echo "<html>
	<head>
 		<meta http-equiv='refresh' content='0;URL={$redirect}'>
	</head>
	<frameset border=\"0\" framespacing=\"0\">
		<frame src={$redirect}>
		</frame>
		<noframes>
			<body>
				<p>You will be redirected to the actual page.<br>
				If redirect does not work, please click <a href={$redirect}>this link</a>.</p>
			</body>
		</noframes>
	</frameset>
</html>";
	exit;
}

## JQuery
if($addons['jquery']) {
$head.='  <link rel="stylesheet" href="'  . $protocol . '://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
  <script src="'  . $protocol . '://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="'  . $protocol . '://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css" />
  <script>
  $(function() {
    $( "#from" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 3,
      onClose: function( selectedDate ) {
        $( "#to" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#to" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 3,
      onClose: function( selectedDate ) {
        $( "#from" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
  });
  </script>';
}

## Aloha integration
if($addons['aloha'] && $wrap_editable && $editmode) {
	$disabledplugins='
		<script type="text/javascript" src="/lib/aloha/plugins/com.gentics.aloha.plugins.Abbr/plugin.js"></script>
		<script type="text/javascript" src="/lib/aloha/plugins/com.gentics.aloha.plugins.HighlightEditables/plugin.js"></script>
	';
	$head.='<script type="text/javascript" src="/lib/aloha/aloha.js"></script>
	<script type="text/javascript" src="/lib/aloha/plugins/uk.co.magiiic.AutoSave/plugin.js"></script>
	<script type="text/javascript" src="/lib/aloha/plugins/com.gentics.aloha.plugins.Format/plugin.js"></script>
	<script type="text/javascript" src="/lib/aloha/plugins/com.gentics.aloha.plugins.Link/LinkList.js"></script>
	<script type="text/javascript" src="/lib/aloha/plugins/com.gentics.aloha.plugins.Link/delicious.js"></script>
	<script type="text/javascript" src="/lib/aloha/plugins/com.gentics.aloha.plugins.Link/plugin.js"></script>
	<script type="text/javascript" src="/lib/aloha/plugins/com.gentics.aloha.plugins.LinkChecker/plugin.js"></script>
	<script type="text/javascript" src="/lib/aloha/plugins/com.gentics.aloha.plugins.List/plugin.js"></script>
	<script type="text/javascript" src="/lib/aloha/plugins/com.gentics.aloha.plugins.Paste/plugin.js"></script>
	<script type="text/javascript" src="/lib/aloha/plugins/com.gentics.aloha.plugins.Paste/wordpastehandler.js"></script>
	<script type="text/javascript" src="/lib/aloha/plugins/com.gentics.aloha.plugins.TOC/plugin.js"></script>
	<script type="text/javascript" src="/lib/aloha/plugins/com.gentics.aloha.plugins.Table/plugin.js"></script>
	';
	$head.="<script type=\"text/javascript\">
	$(document).ready(function() {";

	reset($wrap_editable_parts);
	foreach($wrap_editable_parts as $part) {
		$head.="
	  	$('#$part').aloha();";
	}
	$head.="
	});
	GENTICS.Aloha.EventRegistry.subscribe(GENTICS.Aloha, \"editableDeactivated\", MAGIIIC.AutoSave.saveEditable);
	</script>
	";


	/**
	* Will store the posted content into currently active session.
	*/
	function storePost() {
		global $webroot, $directory, $pagecache;

		file_put_contents ("$pagecache.${_POST['id']}", htmltotext($_POST['content']));

		// $_SESSION[$_POST['id']]=$_POST['content'];
		exit;
	}

	/**
	* Initializes the session with default values.
	*/
	function initSession() {
		global $wrap_editable_parts;
		reset($wrap_editable_parts);
		foreach($wrap_editable_parts as $part) {
		  if(! isSet( $_SESSION[$part])) {
			eval("\$_SESSION['$part']=\$$part;");
		}
	    // $_SESSION["content1"]='Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.';
	  }
	}

	/**
	* Transforms session values into a set of div's
	*/
	function showContents() {
	  foreach ($_SESSION as $key => $value) {
	    if(preg_match("/content.*/i",$key)) {
			echo '<div id="'. $key .'">' . $value . '</div><br/>';
	    }
	  }
	}

	/**
	* Handle commands
	*/
	if ( $_GET['cmd']=='save' ) {
		storePost();
	}
	initSession();

	// showContents();
}

##########
##  Build parents navigation


$pathparams=$pagesettings[$directory];

if(is_array($pathparams['customfolders']))
{
	while (list($key, $value)=each($pathparams['customfolders']))
	{
		$thisurl=ereg_replace("^/", "", "$parentdir/$key");
		$thisurl=cleanpath($thisurl);
		$customdirs["$thisurl/"]=$value;
	}
}

if(!empty($pathparams['pagetitle']) && empty($pagetitle)) {
	$pagetitle=$pathparams['pagetitle'];
}
if ($pathparams['isroot']) {
	$rootdir=$uri;
	$sitetitle=firstValidValue($pathparams['sitetitle'], $pathparams['pagetitle']);
	$menutitle=firstValidValue($pathparams['menutitle'], $pathparams['pagetitle']);
} else if($uri != "/")
{
	$page['title']=$pagetitle;
	$checkpath=urldecode(dirname(ereg_replace("\?.*", "", $uri)));
	$stopon="";
	while (true)
	{
		$pathparams=getPageSettings($checkpath);
		if ($pathparams['isroot']) {
			$sitetitle=firstValidValue($pathparams['sitetitle'], $pathparams['pagetitle'], $sitetitle);
		}
		if(is_array($pathparams['multifilter']))
		{
			#		echo "found";
			$multifilter=array_merge($multifilter, $pathparams['multifilter']);
		}
		if(!$pathparams['pagetitle'])
		{
			#			echo "no title for $checkpath";
		}
		if($pathparams['stopnavigation'])
		{
			break;
		}
		if($navigation) {
			$navigation="<span class=interleave></span>$navigation";
		}
		$navigation = "<a href='" . urlsafe("$checkpath/") . "'>"
		. $pathparams['pagetitle']
		. "</a>$navigation";
		$globaltitle=trim("$pathparams[pagetitle] - $globaltitle");
		if($checkpath=="/")
		{
			break;
		}
		if ($pathparams['isroot']) {
			$rootdir=$checkpath;
			break;
		}
		$lastcheckedpath=$checkpath;
		$checkpath=dirname($checkpath);
		if($checkpath==$stopon || $checkpath=="")
		{
			## at the end of the while to include /, at beginning to avoid it.
			break;
		}
	}
	if(!$sitetitle)
	{
		if($pathparams['sitetitle']) {
			$sitetitle=$pathparams['sitetitle'];
		} else {
			$sitetitle=$pathparams['pagetitle'];
		}
	}
}

$rootdir=ereg_replace("/$|^/", "", $rootdir);
if ($menutop && $rootdir==$directory) {
	$showdirectories=false;
}

// if(is_file("$webroot/$directory/playlist.php"))
// {
// 	include("$webroot/$directory/playlist.php");
// }
if(is_array($pagesettings[$directory])) {
	foreach($pagesettings[$directory] as $pagevar => $pagevalue) {
		if($pagevar != 'playlist') {
			eval("\$$pagevar=\$pagesettings[\$directory]['$pagevar'];");
		}
	}
}

$playerheight=$height + 16;

if(isset($redirect)) {
	echo "<html>
	<head>
 		<meta http-equiv='refresh' content='0;URL={$redirect}'>
	</head>
	<frameset border=\"0\" framespacing=\"0\">
		<frame src={$redirect}>
		</frame>
		<noframes>
			<body>
				<p>You will be redirected to the actual page.<br>
				If redirect does not work, please click <a href={$redirect}>this link</a>.</p>
			</body>
		</noframes>
	</frameset>
</html>";
	exit;
}

##########
##  Build sisters navigation

if ($navigation)
{
	$sisterdirs=array();
	if($menutop)
	{
		$parentdir=$rootdir;
	} else {
		$parentdir=dirname($directory);
	}

	$d = dir("$webroot/$parentdir");


	if ($d)
	{
		$parent=$pagesettings[$parentdir];
		if($menutop && $menutopincluderoot) {
			$root=$pagesettings[$rootdir];
			$thisurl=ereg_replace("^/+", "", "$parentdir/$key/");
			$thisurl=cleanpath($thisurl);
			$sisterdirs["$thisurl"]=$root['menutitle'];
		}
		if(is_array($parent['customfolders']))
		{
			while (list($key, $value)=each($parent['customfolders']))
			{
				$thisurl=ereg_replace("^/", "", "$parentdir/$key");
				$thisurl=cleanpath($thisurl);
				$sisterdirs["$thisurl"]=$value;
			}
		}

		reset($ignore);
		while($entry=$d->read())
		{
			$sister=ereg_replace("^[\.]*/", "", "$parentdir/$entry");
			if(is_dir("$webroot/$sister") &! matchesIgnorePattern("$entry/"))
			{
				// $pathparams=getPageSettings("$sister");
				// echo "sister $sister: " . $pagesettings[$sister]['pagetitle'] . "<br>";
				if($pagesettings[$sister]['hidden']) {
					unset($unsorteddir[$sister]);
				} else if ($pagesettings[$sister]['pagetitle']) {
					$unsorteddir[$sister]=$pagesettings[$sister]['pagetitle'];
				}
				if($pagesettings[$sister]['handleastitle']) {
					$handleastitle[$sister]=true;
				}
			}
		}
	}

	if(is_array($unsorteddir) &! empty($unsorteddir))
	{
		$flip=array_flip($unsorteddir);
		natcasesort($flip);
		$unsorteddir=array_flip($flip);
		while(list($sister, $name)=each($unsorteddir))
		{
			$sister=ereg_replace('^/*', '', $sister);
			// getPageSettings($sister);
			$sisterdirs[$sister]=firstValidValue(
					$pagesettings[$sister]['menutitle'],
					$pagesettings[$sister]['pagetitle'],
					$name
					);

			// if($pagesettings[$sister]['menutitle']) {
			// 	$sisterdirs[$sister]=$pagesettings[$sister]['menutitle'];
			// } else if($pagesettings[$sister]['pagetitle']) {
			// 	$sisterdirs[$sister]=$pagesettings[$sister]['pagetitle'];
			// } else {
			// 	$sisterdirs[$sister]=$name;
			// }
		}
		//		natcasesort($subdirs);

		while(list($sister, $name)=each($sisterdirs))
		{
			$sisterclean=cleanpath("/$sister/");
			// $sisterclean=ereg_replace('^[/]*', '/', $sisterclean);
			// $sisterclean=ereg_replace('//*$', '/', $sisterclean);
			$rootdirclean=cleanpath("/$rootdir/");
			// $rootdirclean=ereg_replace('^[/]*', '/', $rootdirclean);
			// $rootdirclean=ereg_replace('//*$', '/', $rootdirclean);

			if($sisters) {
				$sisters.="<span class=interleaves></span>";
			}
			if($handleastitle[$sister] || ereg("\|", "$sister"))
			{
				$sisters.="\n\t\t\t<span class=sistertitle>" . htmlsafe($name) . "</span>";
			}
			elseif ("$sisterclean" == "$directoryclean")
			{
				$sisters.="\n\t\t\t<span class=sisteractive>" . htmlsafe($name) . "</span>";
			}
			else if (ereg("^$sisterclean", $directoryclean) && $sisterclean != "$rootdirclean")
			{
#				echo "$sisterclean > $rootdirclean<br>";
				$sisters.="\n\t\t\t<a class='sisteractive' href='${sisterclean}'>" . htmlsafe($name) . "</a>";
			}
			else
			{
				$sisters.="\n\t\t\t<a class='sister' href='${sisterclean}'>" . htmlsafe($name) . "</a>";
				#
			}
		}
	}
	else
	{
		$sisters.="\n\t\t\t<b><span class=sisteractive>$menutitle</span></b>";
	}
}
else
{
	$sisters.="\n\t\t\t<b><span class=sisteractive>$menutitle</span></b>";
}

if($titleinnav)
{
	if($navigation) {
		$navigation="$navigation<span class=interleave></span>";
	}
	$navigation.="<span class=navtitle>$pagetitle</span>";
}

$navigation="<div class=parent>" . trim($navigation) . "</div>";

if($sisters)
{
	$sisters="\n\t\t<div class=sisters>{$sisters}\n\t\t</div>";
	##		$sisters.="$sisters";
}

if($autoplay) {
	$autoplay='true';
} else {
	$autoplay='false';
}

#if($output=="iPhone" || isset($bodyclasses['smartphone'])) {
if($output=="iPhone") {
	$facebooklinks=false;
	$facebooklinksitems=false;
	$facebooklinksend=false;
	$facebookcommentspages=false;
	$facebookcommentsitems=false;
}

##############
## Fetching content


$d = dir("$webroot/$directory");
// echo "$webroot/$directory";
if ($d)
{

	########
	## Scan directory content

	while($entry=$d->read())
	{
		$includethisfile=false;

		$file=ereg_replace('^/', '', "$directory/$entry");

		if(is_dir("$webroot/$file"))
		{
			if(!$hideotherfolders) {
				$includethisfile=false;
				if ($showdirectories)
				{
					if(!matchesIgnorePattern("$entry/") &! matchesIgnorePattern("/$file/") &! $hidechilds)
					{
						$dirinfo=getPageSettings("$file");
						if(!$dirinfo['hidden']) {
							$subdirs["$entry/"]=$dirinfo['pagetitle'];
							if($dirinfo['handleastitle'])
							{
								$handleastitle["$entry/"]=true;
							}
						}
						continue;
					}
				}
			}
			continue;
		}

		if(matchesPattern($entry,$htmlfiles) &! matchesIgnorePattern("$entry"))
		{
			$includethisfile=false;
#			$dirinfo=getPageSettings("$file");
			$subdirs["$entry"]=titelize(ereg_replace("\.[a-zA-Z0-9]*$", "", $entry));
			continue;
		}

#		if($htmlfiles)

		switch ($entry)
		{
			case "_links.txt":
			case "links.txt":
			$fileArray=fileToSimpleArray("$webroot/$directory/$entry");
			if (is_array($fileArray))
			{
				while(list($thisurl, $site)=each($fileArray))
				{
					#				echo "found $thisurl: $site<br>";
					if (! "$site" || trim($site) == "") {
						$links.="<div class=title>" . htmlsafe($thisurl) . "</div>";
						continue;
					}
					if(ereg('://', $thisurl))
					{
						$target='_blank';
					}
					else
					{
						$target='_self';
					}

					if(empty($thisurl)) {
						$links.="<p>$site</p>";
					} else {
						$links.="<div class=link><a href='$thisurl' target='$target'>$site</a></div>";
					}
				}
			}
			$links=ereg_replace('"<div class=title></div>"', '', $links);
			break;

			case "_right.txt":
			case "right.txt":
				$right.=reformatFile("${webroot}/${directory}/${entry}");
				break;
			case "_left.txt":
			case "left.txt":
				$left.=reformatFile("${webroot}/${directory}/${entry}");
				break;
			case "_popup.txt":
				$popup=reformatFile("${webroot}/${directory}/${entry}");
				if($popup && $popup != '') {
					$popup="<div class='popup' id='popup' onMouseOut='windowHide(\"popup\");' onMouseOver='windowShow(\"popup\");'>$popup</div>";
				}
				break;
			case "_about.txt":
			case "about.txt":
			case "_text.txt":
			case "text.txt":
				$about.="<div id='about' class='about'>"
				 	. reformatFile("${webroot}/${directory}/${entry}")
					. "\n</div>";
				break;
			case "_about.html":
			case "about.html":
				$fileArray = file("$webroot/$directory/$entry");
				if(count($fileArray) > 0)
				{
					$about=implode("\n", $fileArray);
					if(eregi('charset=macintosh', $about))
					{
						$about=utf8_encode(macRomanToIso($about));
					}
					$about=eregi_replace(".*<body[^>]*>", "", "$about");
					$about=eregi_replace("</body[^>]*>.*", "", "$about");
					$about="
						<div id=about class='about'>
							$about
						</div>";
				}
				break;

				case "_trombi.csv":
				case "_details.csv":
				$detailsFile = file("$webroot/$directory/$entry");
				foreach($detailsFile as $detailsString) {
					$detailsRow=array_filter(str_getcsv($detailsString));
					$detailsId=$detailsRow[0];
					$details[$detailsId]=$detailsRow;
					array_shift($details[$detailsId]);
				}
				break;

		}

		if($showotherdircontent)
		{
			$extension=strtolower(ereg_replace('^.*\.', '', $entry));
			if(array_search(".$extension", $multifilter) || array_search(".$extension", $downloadable))
			{
				$includethisfile=true;
			}

			if(eregi("$filter\$", $entry))
			{
				$includethisfile=true;
			}

			if(is_array($ignore))
			{
				reset($ignore);
				while(list($key, $pattern)=each($ignore))
				{
					if(ereg("^$pattern$", $entry))
					{
						$includethisfile=false;
						continue;
					}
				}
			}

			if($includethisfile)
			{
				$items[] = "$directory/$entry";
			}
		}
	}
	$d->close();


	########
	## Scan playlist content

	if(is_array($customnames))
	{
		while(list($checkfile, $name)=each($customnames))
		{
			unset($file);
			unset($subdir);

			if(ereg('(^title|^\[.*\]$|^s:)', $checkfile))
			{
				$section=ereg_replace("\[(.*)\]", "\\1", "$checkfile");
				if(empty($checkfile)) {
					$checkfile="section" . count($sections);
				}
				$names[$checkfile]=$name;
				$if=count($index);
//				debug("section $if: $section");
				$indexsections[$if]=$section;
				$index[]="FALSE"; //$file;
			} else {
				$extension=strtolower(ereg_replace('^.*\.', '', $checkfile));
				$filetype=ereg_replace("/.*", "", $mimetypes[$extension]);
				if (is_external($checkfile))
				{
					//				echo "external mms, assuming it exists";
					$file=$checkfile;
					$names[$file]=$customnames[$checkfile];
					if(!($popup && $popable[$filetype]) &! $inpage)
					{
						$list[$file]=$customnames[$checkfile];
						if(is_playable($file) &! $downloadOnly)
						{
							$foundsomethingtoplay=true;
						}
					}
					$if=count($index);
					$index[]=$file;
					$playlistindex[]=$file;
					continue;
				}
				else if (is_dir("$webroot/$directory/$checkfile")) {
					$subdir="$directory/$checkfile";
				}
				else if(is_dir("$webroot/$checkfile")) {
					$subdir=$checkfile;
				}
				else {
					$possiblevariants=findVariants("$directory/$checkfile");
					if($possiblevariants) {
						$file=current($possiblevariants);
					} else
					if (is_file("$webroot/$directory/$checkfile"))
					{
						$file="$directory/$checkfile";
						// $checkfile=ereg_replace("//", "/", "$directory/$checkfile");
					}
					else if(is_file("$webroot/$checkfile"))
					{
						$file=$checkfile;
					}
				}
			}
			if($file)
			{
				$file=ereg_replace("//", "/", $file);
				$names[$file]=$name;
				if(!($popup && $popable[$filetype]) &! $inpage)
				{
					$list[$file]=$name;
					if(is_playable($file) &! $downloadOnly)
					{
						$foundsomethingtoplay=true;
					}
				}
				// $if=count($index);
				$index[]=$file;
				$playlistindex[]=$file;
				// echo "$if: $index[$if]<br>";
			}
			else if($subdir)
			{
				$subdir=ereg_replace("//", "/", $subdir);
				if (!$name)
				{
					$dirinfo=getPageSettings("$subdir");
					$name=$dirinfo['pagetitle'];
				}
				$subdirs["$subdir/"]=$name;
			}

		}
		reset($customnames);
	}


	########
	## Process subdirectories

	if(is_array($subdirs))
	{
		$flip=array_flip($subdirs);
		natcasesort($flip);
		$sorteddir=array_flip($flip);
		$subdirs=$customdirs;
		reset($sorteddir);
		while(list($key, $value)=each($sorteddir)) {
			$indexkey=ereg_replace("^/|/$", "", cleanpath("$directory/$key"));
			if($pagesettings[$indexkey]['menutitle']) {
				$subdirs[$key]=$pagesettings[$indexkey]['menutitle'];
			} else if (!$subdirs[$indexkey]) {
				$subdirs[$key]=$value;
			}
		}

		//		natcasesort($subdirs);
		while(list($dir, $name)=each($subdirs))
		{
			if($handleastitle["$dir"])
			{
				$safename=htmlsafe($name);
				if($name=="|")
				{
					$safename="&nbsp;";
				}
				$subdirectories.="\n\t\t\t<span class='subdirtitle'>$safename</span>";
				$childs.="\n\t\t\t$safename";
			} else {
				$subdirectories.="\n\t\t\t<a class='subdir' href='" . urlsafe($dir) . "'>" . $name . "</a>";
				$childs.="\n\t\t\t<a class='child' href='/$directory/$dir'>" . htmlsafe($name) . "</a>";
			}
		}
		$subdirectories=processtags("subdirectories", $subdirectories);
		if($childs)
		{
			$childs="\t\t<div class=\"childs\">$childs\n\t\t</div>\n";
		}
		$subdirectories="\n\t\t<div class=subdirs>$subdirectories\n\t\t</div>";
	}

	if($links != "")
	{
		$links="<div class=links>$links</div>";
	}

	########
	## Process files

	if(is_array($items))
	{
		natsort($items);
		while(list($key, $file)=each($items))
		{
			$extension=strtolower(ereg_replace('^.*\.', '', $file));
			$filetype=ereg_replace("/.*", "", $mimetypes[$extension]);
			if(!$names[$file])
			{
				$names[$file]=generateFileName($file);
				$playlistindex[]=$file;
				$if=count($index);
				$index[]=$file;
			}
			if(!($popup && $popable[$filetype]) &! $inpage)
			{
				$list[$file]=$names[$file];
				if(is_playable($file) &! $downloadOnly)
				{
					$foundsomethingtoplay=true;
				}
			}
		}
		reset($items);
	}

	## Add intro movie if defined and exists
	if(is_file("$webroot/$playListIntro"))
	{
		$items[]="$playListIntro";
	}
	else
	{
		unset($playListIntro);
	};

	########
	## Scan passed values

	$REQUEST=$_REQUEST;

	if($REQUEST['action']=="popup")
	{
	$onload.="self.moveTo(0,0);self.resizeTo(screen.availWidth,screen.availHeight);self.titlebar=0;";
	}
/*
if($REQUEST[id])
{
	$showfile=$index[$REQUEST[id]];
	//			echo "$REQUEST[id]: $showfile<p>";
}
	if(!$showfile)
	{
		if($playListIntro)
		{
			$showfile=$playListIntro;
		}
		else
		{
			$showfile = $playlistindex[0];
		}
		$makeplaylist=true;
	}
*/
	## $parentname and $parenturl are used to bypass the folder hierarchy

	if($parentname != "")
	{

		if($parenturl != "")
		{
			$parentlink="
							<div class=navparents>
								/ <a href='$parenturl'>$parentname</a> /
							</div>";
		} else 	{
			$parentlink="
							<div class=navparents>
								/ <a href='../'>$parentname</a> /
							</div>";
		}
	}
	else if($parenturl != "")
	{
		$parentlink="<a href='$parenturl'>Parent page</a>";
	}
}
else
{
	// error reading dir

	// $mediaplayer="<embed class=player src='' "
	// . "controller='$controller' autoplay='$autoplay' name=player1 cache='$cache' scale='$scale' "
	// . "saveembedtags='true' type='video/quicktime' "
	// . "pluginspage='http://www.apple.com/quicktime/download/' bgcolor='#ffffff'>";
	// $playlist="error reading dir";
}

reset($wrap_editable_parts);
foreach($wrap_editable_parts as $part) {
	eval("if(file_exists(\"$pagecache.$part\")) \$$part=reformatFile(\"$pagecache.$part\");");
	// eval("if(empty(\$$part)) \$$part=\"\";");
	switch($part) {
		case "pagetitle":
		eval("if(empty(\$$part)) \$$part=\"&nbsp;\";");
		$pagetitle=ereg_replace("</*p[^>]*>", "", $pagetitle);
		// eval("if(!ereg(\" id='*$part'* \", \$$part)) \$$part=\"<h1 id='$part' class='$part'>\$$part</h1>\";");
		break;
		default:
		eval("if(!ereg(\" id='*$part'* \", \$$part)) \$$part=\"<div id='$part' class='$part'>\$$part</div>\";");
	}
	// switch($part) {
	// 	// case "pagetitle":
	// 	// break;
	// 	default:
	// 	eval("\$$part=\"<div id='$part' class='$part'>\$$part</div>\";");
	// }
	// eval("\$$part=ereg_replace('\[', '&#91;', \$$part);");
}

if(is_array($subdirs) && count($subdirs) > $maxchilds)
{
	$menuchilds=false;
}
if($parentlink)
{
	$navigation="$parentlink";
}

if(isset($pagetemplate)) {
	if(ereg("^/", $pagetemplate)) {
		$checktemplate[]=cleanpath("$webroot/$rootdir/$pagetemplate");
		if($includeparentstyle &! empty($rooddir)) {
			$checktemplate[]=cleanpath("$webroot/$pagetemplate");
		}
	} else {
		$checktemplate[]=cleanpath("$webroot/$directory/$pagetemplate");
	}
}

if($includeparentstyle) {
	if($rootdir != "") {
		$checktemplate[]=cleanpath("$webroot/$rootdir/browser.html");
	}
	$checktemplate[]="$webroot/browser.html";
}

$checktemplate[]="browser.html";
$checktemplate[]=ereg_replace("\.php$", ".html", $scriptfilename);

$pagetemplate=firstValidFile($checktemplate);

// if(!$pagetemplate)
// {
// 	$checkfile=dirname(getenv('PATH_TRANSLATED')). "/browser.html";
// 	if(is_file($checkfile))
// 	{
// 		$pagetemplate=$checkfile;
// 	}
// }

###################
## Stop here if underconstuction

if ($underconstruction) {
	include("$libdir/underconstruction.php");
	exit;
}



###################
## Build menu tree


if(!$menutopincluderoot) {
	unset($pagesettings[$rootdir]);
}
$tree="<div class=tree>\n";

foreach($pagesettings as $thisurl => $settings) {
	// $level=substr_count(ereg_replace("^$rootdir/", "", $thisurl), "/") + 1;

	if(! empty($rootdir) &! ereg("^$rootdir/", "$thisurl/")) {
		continue;
	}

	$level=$settings['level'];
	if($settings['hidechilds'] && (! $maxlevel || $level < $maxlevel)) {
		$maxlevel=$level;
	}
	if($maxlevel && $level > $maxlevel) {
		continue;
	}
	if($settings['hidden']) {
		continue;
	}
	if ($level > $lastlevel) {
		$tree.="<div class=branch id=branch$level>\n";
	} else {
		if ($level < $lastlevel) {
			$tree.=str_repeat("</div>", $lastlevel - $level);
		}
		$branch.="<span class=interleaves>\n</span>";
	}
	if($settings['handleastitle']) {
		$class="subdirtitle";
	} else {
		if(ereg("^$thisurl/", "$directory/")) {
			if($thisurl==$rootdir) {
				if ($directory==$rootdir) {
					$class="leafactive";
				} else {
					$class="leaf";
				}
			} else {
				$class="leafactive";
			}
		} else {
			$class="leaf";
		}
	}
	$thisurl=urlsafe("/$thisurl/");

	$branch.="<div class=$class>";
	$branch.="<a class=name href='$thisurl'>$settings[menutitle]</a>";
	if($settings['thumb']) {
		$branch.="
		<a class=thumbframe href='$thisurl'>
			<img class=thumb src='$settings[thumb]'>
		</a>";
	}
	$branch.="\n</div>";
	if($level==1 && $menumain) {
		$mainmenu.=$branch;
	}
	if(!$tree_minlevel || $level >= $tree_minlevel) {
		$tree.=$branch;
	}
	$lastlevel=$level;
	unset($branch);
}
unset($level);
$tree.="</div>";
$tree.=str_repeat("</div>", $lastlevel);
$tree=ereg_replace("<div class=branch id=branch[0-9]>\n*</div>", "", $tree);
$tree=ereg_replace("<div class=tree>\n*</div>", "", $tree);
if($menumain && $mainmenu) {
	$mainmenu=ereg_replace("<(/*)div", "<\\1span", $mainmenu);
	$mainmenu="<div class=tree>\n<div class=branch id=main>$mainmenu</div></div>";
}

// $tree=clean_html_code(ereg_replace("</span>", "\n</span>", $tree));
// header("Content-Type: text/text; charset=$charset");
// echo "$tree";
// exit;


###################
## Sort alternate versions

if (is_array($names))
{
	reset($names);
	while(list($file, $name)=each($names))
	{
		$extension=strtolower(ereg_replace('^.*\.', '', $file));
		$filetype=ereg_replace("/.*", "", $mimetypes[$extension]);

		$groupfile=stripVariantSuffix($file);

		$foundvariants=findVariants($file);

		if(! is_array($allowedvariants[$filetype])) {
			// reset($allowedvariants[$filetype]);
			//
			// $groupfile=$file;
			// foreach($allowedvariants[$filetype] as $variant) {
			// 	$groupfile=ereg_replace("-$variant\.$extension$", ".$extension", $groupfile);
			// }
			//
			// reset($allowedvariants[$filetype]);
			// foreach($allowedvariants[$filetype] as $variant) {
			//
			// 	$foundvariants[$variant]=firstValidFile(
			// 		ereg_replace("\.$extension$", "-$variant.$extension", $groupfile),
			// 		ereg_replace("\.$extension$", "-$variant.mov", $groupfile),
			// 		ereg_replace("\.$extension$", "-$variant.mp4", $groupfile),
			// 		ereg_replace("\.$extension$", "-$variant.m4v", $groupfile)
			// 	);
			// 	if($foundvariants[$variant]=="") {
			// 		unset($foundvariants[$variant]);
			// 	}
			// }
		// } else {
			$large=firstValidFile(
				ereg_replace("\.$extension$", "-large.$extension", $file)
				);
		}

		if($groupfile!=$file) {
			// $indexid=array_search($file, $index);
			// $index[$indexid]=$groupfile;
			// if(!$names[$groupfile]) {
			// 	$replacement=array($groupfile => $names[$file]);
			// 	// debug("replacing $file with $groupfile");
			// 	// debug("array_splice($names, $indexid, 1, $replacement);");
			// 	// $names=array_splice($names, $indexid, 0, $replacement);
			// 	$names[$groupfile]=$names[$file];
			// }
			// unset($names[$file]);
		}

		if(!$newnames[$groupfile]) {
			$newnames[$groupfile]=$name;
		}
		$file=$groupfile;

		$files[$file]['name']=$names[$file];
		$files[$file]['type']=$filetype;
		if($foundvariants) {
			$files[$file]['variants']=$foundvariants;
		}

		if($downloadAllowed == true)
		{
			$downloadFiles[$file][$extension]["file"]="$filesafe";
			$downloadFiles[$file][$extension]["link"]="/lib/download.php?f=" . $downloadFiles[$file][$extension]["file"];
			if(is_array($allowedvariants[$filetype]))
			{
				reset($allowedvariants[$filetype]);
				while(list($key, $type)=each($allowedvariants[$filetype]))
				{
					if ($foundvariants[$type] && $foundvariants[$type] != "$file")
					{
						$downloadFiles[$file][$type][file]="/" . urlsafe($foundvariants[$type]);
						$downloadFiles[$file][$type][link]="/lib/download.php?f=" . $downloadFiles[$file][$type][file];
					}
				}
			}
		}
	}
	$names=$newnames;
	$index=array_keys($names);
}

####################
## remove duplicates

if(is_array($downloadFiles))
{
	reset($downloadFiles);
	while(list($file, $movie)=each($downloadFiles)) {
		$extension=strtolower(ereg_replace('^.*\.', '', $file));
		$filetype=ereg_replace("/.*", "", $mimetypes[$extension]);
		if(is_array($allowedvariants[$filetype])) {
			reset($allowedvariants[$filetype]);
			while(list($key, $type)=each($allowedvariants[$filetype]))
			{
				if($movie[$type]["file"]) {
					$duplicate=urldecode(ereg_replace("^/", "", $movie[$type]["file"]));
					if ($duplicate==$file) { continue; }
					if (!in_array($duplicate, $index)) { continue; }
					$indexid=array_search($duplicate, $index);
					$playlistindexid=array_search($duplicate, $playlistindex);
					$itemsid=array_search($duplicate, $items);
					unset($names[$duplicate]);
					unset($items[$duplicate]);
					unset($list[$duplicate]);
					unset($index[$indexid]);
					unset($playlistindex[$playlistindexid]);
				}
			}
		}
	}
}

if(is_array($playlistindex)) {
	$playlistindex=array_values($playlistindex);
}

if(isset($REQUEST['id']))
{
	$showid=$REQUEST['id'];
	$showfile=$playlistindex[$showid];
}

if(!$showfile)
{
	if($playListIntro)
	{
		$showfile=$playListIntro;
	}
	else
	{
		$showfile = $playlistindex[0];
	}
	$makeplaylist=true;
}

###################
## Build media player
if($foundsomethingtoplay &! $downloadOnly )
{
	if (!is_external($showfile))
	{
		$showfile=urlsafe("/$showfile");
	}

	$extension=ereg_replace('^.*\.', '', $showfile);
	$shownObject=new item($showfile);

	switch ($extension)
	{
		case "$mp3":
		$playerheight=16;
		$height=0;
		break;

		case "flv":
		$playerheight=$height+19;
		if($flashplaylist)
		{
			$playerheight=$playerheight + $flashplaylistlength * 16;
			$showfile="/{$directory}/%3Foutput%3Dflv";
#			$mediaplayer="<embed src=/lib/mediaplayer.swf "
		}

		#		$mediaplayer="<embed src=/mediatest/player.swf "

			$mediaplayer="<embed class=player src=/lib/mediaplayer.swf "
		. "file='$showfile' "
		. "allowscriptaccess='always' "
		. "allowfullscreen='true' "
		. "flashvars='file=$showfile&autostart=true&stretching=uniform&logo=/watermark.png'"
		. ">";

#	flashvars:"file=playlist.php&displayheight=240&lightcolor=0x557722&backcolor=0x000000&frontcolor=0xCCCCCC&fsreturnpage=flvplayer.html" };
		if($makeplaylist && count($list) > 0)
		{
			if(is_array($list)) {
				reset($list);
				if($playListIntro)
				{
					$i=0;
				}
				else
				{
					$i = -1;
				}
				while (list($file, $name)=each($list))
				{
					$i++;
					// $thisurlfile=ereg_replace("'", urlencode("'"), $file);
					$thisurlfile=urlsafe("/$file");
#					$mediaplayer .= "\n	<param name='qtnext$i' value='<$thisurlfile>T<myself>'>";
#					$embed .= "\n qtnext$i='<$thisurlfile>T<myself>' ";
					$flvplaylist .= "		<track>\n"
						. "			<title>" . ereg_replace('<.*>', ' ', $name) . "</title>\n"
						. "			<location>$thisurlfile</location>\n"
						. "		</track>\n";
						#  . ereg_replace('<.*>', ' ', $name) .
				}
			}
		}

		$flvplaylist = "<playlist version='1' xmlns='http://xspf.org/ns/0/'>\n"
			.  "	<title>$pagetitle</title>\n"
/*		 	.  "		<info>http://www.jeroenwijering.com/</info>\n"*/
			.  "	<trackList>\n"
			. $flvplaylist
			.  "	</trackList>\n"
			.  "</playlist>\n";
		break;

		default:
		if ($kioskmode == '') {
			$kioskmode = 'false';
		}

		$playerheight=$height + 16;
		$mediaplayer = "
			<object class=player id=player1 codebase='http://www.apple.com/qtactivex/qtplugin.cab'>
				<param name='src' value='" . urlsafe($showfile) . "'/>
				<param name='controller' value='$controller'/>
				<param name='autoplay' value='$autoplay'/>
				<param name='cache' value='$cache'/>
				<param name='scale' value='$scale'/>
				<param name='kioskmode' value='$kioskmode'/>
				<param name='saveembedtags' value='true'/>";
		$embed = "
				<embed class='player' src='" . urlsafe($showfile) . "' controller='$controller' autoplay='$autoplay' name=player1 cache='$cache' scale='$scale' kioskmode='$kioskmode'";

		if($makeplaylist && count($list) > 1)
		{
			if(is_array($list)) {
				reset($list);
				if($playListIntro)
				{
					$i=0;
				}
				else
				{
					$i = -1;
				}
				while (list($file, $name)=each($list))
				{
					$i++;
					// $thisurlfile=ereg_replace("'", urlencode("'"), $file);
					$thisurlfile=urlsafe("/$file");
					$mediaplayer .= "\n\t\t\t\t<param name='qtnext$i' value='<$thisurlfile>T<myself>'>";
					$embed .= "\n\t\t\t\t\tqtnext$i='<$thisurlfile>T<myself>' ";
				}
			}
		}
		$embed .= "\n\t\t\t\t\tsaveembedtags='true' type='video/quicktime' pluginspage='http://www.apple.com/quicktime/download/' bgcolor='$playerbgcolor'>";
		$mediaplayer .= "$embed\n\t\t\t</object>";
#		$mediaplayer = "\n\t\t<div class=media>$mediaplayer\n\t\t</div>";
	}

	$controls['playall']="<a href='" . rewritelink() . "'>Play all</a>";
}
else
{
	$j=-1;
}

##############
## Build playlist

if($facebooklinksend) {
	$fbsend="true";
} else {
	$fbsend="false";
}

//		reset($items);
$i=0;
$title="notitle";
$namescount=count($names);
$sections=array();
$section="untitled";
if(is_array($names))
{
	reset($names);
	while (list($file, $name)=each($names))
	{
		$onMouseOver='';
		$onMouseOut='';
		$key=$i;
		$playlistid=array_search($file, $playlistindex);
		$j++;
		if(isset($names[$index[$i]])) {
			$next=($namecount + $i + 1) % ($namescount);
			if(empty($names[$index[$next]]) || $indexsections[$next]) {
				$next=($namecount + $next + 1) % ($namescount);
			}
			$previous=($namescount + $i - 1) % ($namescount);
			if(empty($names[$index[$previous]]) || $indexsections[$previous]) {
				$previous=($namescount + $previous -1 ) % ($namescount);
			}
		}
		if($next > $i) {
			$autonext=$next;
		} else {
			unset($autonext);
		}
		if($files[$file]['variants']) {
			// debug("$file");
			// debug("found " . count($files[$file]['variants']) . " variants", "line");
			$playablefile=firstValidFile($files[$file]['variants']);
			// debug("playablefile: $playablefile", "line");
			$filesafe=ereg_replace("//", "/", "/" . urlsafe($playablefile));
		} else {
			$filesafe=ereg_replace("//", "/", "/" . urlsafe($file));
		}

		$namesafe=quotesafe($name);
		$extension=ereg_replace('^.*\.', '', $file);
		$thumbname=ereg_replace("\.$extension$", "-thumb", basename($file));
		$largethumbname=ereg_replace("\.$extension$", "-large", basename($file));
		$postername=ereg_replace("\.$extension$", "-poster", basename($file));
		$thumbpng=ereg_replace("\.$extension$", "-thumb.png", basename($file));
		$filename=ereg_replace("\.$extension$", "", basename($file));
		if(file_exists("$webroot/$file")) {
			$filetime=date ("D, d M Y H:i:s O", filemtime("$webroot/$file"));
			$filetimeshort=date ("d-m-Y H:i", filemtime("$webroot/$file"));
			$filesize=filesize("$webroot/$file");
			$filesizeh=HumanReadableFilesize($filesize);
		}
		$filetype=ereg_replace("/.*", "", $mimetypes[$extension]);

		if($filetype=="image") {
			$img=$file;
		} else if ($filetype=="video") {
			unset($video_sources);
 			foreach ($html5_playable as $ext) {
				$altfile=preg_replace("/\.$extension$/", ".$ext", $file);
				if(is_file("$webroot/$altfile")) {
					$safealtfile=ereg_replace("//", "/", "/" . urlsafe($altfile));
					$video_sources.="<source src='" . ereg_replace("//", "/", "/" . urlsafe($altfile))
						. "' type='" . $mimetypes[$ext] . "' />\n";
				}
			}

			unset($video_tracks);
			$vtt=preg_replace("/\.$extension$/", ".vtt", $file);
			if(is_file("$webroot/$vtt")) {
				$video_tracks.="<track kind='subtitles' src='" . ereg_replace("//", "/", "/" . urlsafe($vtt))					. "' default></track>";
				// srclang='en' label='English'
			}
 		} else {
			$img=ereg_replace("\.$extension$", ".jpg", $file);
		}
		if(is_external($file))
		{
			$itemurl=$file;
			$itemsublinks[]="<a href='" . $file . "'>play</a>";
		}
		else if(is_playable($file) &! $movieslideshow)
		{
			$itemurl=rewritelinkid($playlistid);
			$itemsublinks[]="<a href='" . rewritelinkid($playlistid) . "'>play</a>";
		}

		if($popup && $popable[$filetype]) {
			if($popupanchor) {
				$anchor=$i;
			}
			$windowshow="";
			$windowhide="";
			if(is_array($popuphide)) {
				foreach($popuphide as $togglestyle) {
					$windowhide.="windowHide(\"$togglestyle\");" ;
					$windowshow.="windowShow(\"$togglestyle\");" ;
				}
			} else {
				$windowhide.="windowHide(\"playlists\");" ;
				$windowshow.="windowShow(\"playlists\");" ;
			}

			if(!$inpage) {
				$itemlink="<a href='javascript:'"
					. " class=itemlink"
					. " title='$namesafe'"
					. " alt='$namesafe'"
					. " onClick='$windowhide popOn(\"$i\");'"
					. ">";
				$itemlinkout="</a>";
				if($filetype!='video') {

					switch($largelinktype) {
						case "close":
						$largelink="<a href='javascript:' "
							. " class=large"
							. " title='$namesafe'"
							. " onClick='$windowshow popOff(\"$i\");'"
							. ">";
						$largelinkout="</a>";
						break;
						case "next":
						$largelink="<a href='javascript:' "
							. " class=large"
							. " title='$namesafe'"
							. " onClick='popOff(\"$i\");popOn(\"$next\");'"
							. ">";
						$largelinkout="</a>";
						break;
					}
				}
			}
			# onMouseOver='window.status=\'zoom\'' onMouseOut='window.status=\'\''
		} else if ($itemurl) {
			// $item.="popup: $popup; filetype: '$filetype'; popable: '${popable[$filetype]}'";
			// reset($popable);
			$itemlink="<a href=\"$itemurl\">";
		}
		if($itemurl) {
			$itemlinkout="</a>";
		}

		if (is_array($downloadFiles[$file]) && count($downloadFiles[$file]) > 1) {
			$buttonlinks = "
				<div class='links'>";
			reset($downloadFiles[$file]);
			while(list($downloadtype, $download)=each($downloadFiles[$file]))
			{
				$buttonlinks .= "
					<a class='link' href='${download[link]}'>${downloadtype}</a>";
			}
			$buttonlinks .= "
				</div>
				";

		} else if ($downloadAllowed == true && $itemlink) {
			$downloadfile="$filesafe";
			$buttonlinks =  "
				<div class='links'>
				<a class='link' href='/lib/download.php?f=$downloadfile'>$extension</a>
				</div>
				";
		}

		unset($variants);
		if($files[$file]['variants'] && count($files[$file]['variants']) > 1) {
			reset($files[$file]['variants']);
			foreach($files[$file]['variants'] as $varianttype => $variant) {
				$variants.="<a class=variant href='javascript:' onClick='switchSrc(\"$i\", \"/$variant\");'>$varianttype</a>";
			}
			$variants = "<div class='variants' id='variants_$i'>$variants</div>";
		}

		if ($popupnav || $popupnavtitle) {
			$popupnavhtml = "
				$variants
				<div class='nav' id='nav_$i'>";
			if ($popupnav) {
				$popupnavhtml .= "
					<a class=previous id='prev_$i' href='javascript:' onClick='popOff(\"$i\"); popOn(\"$previous\");'>$buttonprevious</a>";
				if($filetype=='video' && $controls=='false') {
					$popupnavhtml .= "
						<a class=begin id='begin_$i' href='javascript:' onClick='videoRewind(\"$i\");'>$buttonbegin</a>
						<a class=pause id='pause_$i' href='javascript:' onClick='videoPause(\"$i\");'>$buttonpause</a>
						<a class=play id='play_$i' href='javascript:' onClick='videoPlay(\"$i\");'>$buttonplay</a>";
				}
				$popupnavhtml .= "
					<a class=close id='close_$i' href='javascript:' onClick='popOff(\"$i\");$windowshow;'>$buttonclose</a>";
//				if(!ereg("^s:", $index[$next])) {
					$popupnavhtml .= "
							<a class=next id='next_$i' href='javascript:' onClick='popOff(\"$i\"); popOn(\"$next\");'>$buttonnext</a>";
//				}
				$popupnavhtml .= $buttonlinks;
			}
#			buttonfullscreen: webkitEnterFullScreen();

			// if($popupnavtitle) {
			// 	$popupnavhtml .= "
			// 		<div class=largename>
			// 			" . htmlsafe($name) . "
			// 		</div>";
			// }
			$popupnavhtml .= "
				</div>";
			if ($popupnavautohide) {
				$onMouseOver.="showNav(\"$i\");";
				$onMouseOut.="hideNav(\"$i\");";
				// $largelink=ereg_replace(">", " onMouseOver='$onMouseOver' onMouseOut='$onMouseOut'>", $largelink);
			}
		} else {
			$popupnavhtml = "";
		}

#		echo "$name filetype: $filetype<br>";
#		echo "$directory/$thumbpng<br>";
#		echo "$name $extension<br>";

# echo "$directory/$cachedir/$thumbname.gif<br>";
		$actualdirectory=ereg_replace('^/', '', dirname($file));
		while (ereg('[^/]*/\.\./', $actualdirectory)) {
			$newdirectory=ereg_replace('[^/]*/\.\./', '', $actualdirectory);
			if ($newdirectory==$directory) {
				break;
			} else {
				$actualdirectory=$newdirectory;
			}
		}
		$thumb=firstValidFile(
			"$directory/$thumbname.jpg",
			"$directory/.$thumbname.jpg",
			"$directory/$cachedir/$thumbname.jpg",
			"$directory/$thumbname.png",
			"$directory/$cachedir/$thumbname.png",
			"$directory/$thumbname.gif",
			"$directory/$cachedir/$thumbname.gif",
			"$actualdirectory/$thumbname.jpg",
			"$actualdirectory/.$thumbname.jpg",
			"$actualdirectory/$cachedir/$thumbname.jpg",
			"$actualdirectory/$thumbname.png",
			"$actualdirectory/$cachedir/$thumbname.png",
			"$actualdirectory/$thumbname.gif",
			"$actualdirectory/$cachedir/$thumbname.gif",
			"images/icons/$extension.png",
			"images/icon-$extension.png",
			"images/icon-$extension.jpg",
			"images/icon-$extension.gif",
			"$img",
			"images/icon-generic.png",
			"images/icon-generic.jpg"
			);
		$thumbsafe=ereg_replace("//", "/", "/" . urlsafe($thumb));
		if($thumb) {
			$files[$file]['thumb']=$thumbsafe;
			$ogthumbs[]="$siteurl$thumbsafe";
			// debug("ogimage: $thumb $siteurl$thumbsafe");
		}

		$poster=firstValidFile(
			"$directory/$postername.jpg",
			"$directory/.$postername.jpg",
			"$directory/$cachedir/$postername.jpg",
			"$directory/$postername.png",
			"$directory/$cachedir/$postername.png",
			"$directory/$postername.gif",
			"$directory/$cachedir/$postername.gif",
			"$actualdirectory/$postername.jpg",
			"$actualdirectory/.$postername.jpg",
			"$actualdirectory/$cachedir/$postername.jpg",
			"$actualdirectory/$postername.png",
			"$actualdirectory/$cachedir/$postername.png",
			"$actualdirectory/$postername.gif",
			"$actualdirectory/$cachedir/$postername.gif",
			"$directory/$postername.jpg",
			"$directory/.$postername.jpg",
			"$directory/$cachedir/$postername.jpg",
			"$directory/$postername.png",
			"$directory/$cachedir/$postername.png",
			"$directory/$postername.gif",
			"$directory/$cachedir/$postername.gif",
			"$actualdirectory/$postername.jpg",
			"$actualdirectory/.$postername.jpg",
			"$actualdirectory/$cachedir/$postername.jpg",
			"$actualdirectory/$postername.png",
			"$actualdirectory/$cachedir/$postername.png",
			"$actualdirectory/$postername.gif",
			"$actualdirectory/$cachedir/$postername.gif",
			$defaultposter
		);
		$postersafe=urlsafe($poster);
		#		echo "$thumb<br>";
		if(isset($thumb)) {
			$thumbcode="<img class='thumb' src='$thumbsafe' alt=\"$namesafe\" border='0'>";
			$preloadcode.="preloadImage('$thumbsafe');";
		} else {
			$thumbcode="";
		}
		if(file_exists("$webroot/$file")) {
			// $hash=sha1_file("$webroot/$file");
			$hash=sha1("$webroot/$file");
			$hashindex[$hash]=$i;
		}

		unset($fb_item);
		if($facebooklinksitems) {
			$fb_item.="<div class=fb_item_like><fb:like xid=\"$hash\" href=\"$cleanurl?ih=$hash\" send=\"$fbsend\" layout=\"button_count\" width=\"auto\" show_faces=\"true\" colorscheme=\"$fbstyle\" font=\"lucida grande\"></fb:like></div>";
			# "<fb:share-button type=\"button\" href=\"$url?ih=$hash\" font=\"lucida grande\" colorscheme=\"$fbstyle\"></fb:share-button>
		}
		if($facebookcommentsitems) {
			$fb_item.="<div class=fb_item_comments><fb:comments xid=\"$hash\" href=\"$cleanurl?ih=$hash\" num_posts=\"5\" width=\"$fb_comments_width\" colorscheme=\"$fbstyle\"></fb:comments></div>";
			// $fb_item_comments="$encodedurl?ih=$hash";
		}

		if($fb_item) {
			$fb_item="$fb_init$fb_item";
		}

		$descfile=firstValidFile(
			"$directory/$filename-desc.txt",
			"$directory/$filename.txt"
		);
		if($descfile) {
			$descitem = reformatFile("${webroot}/${descfile}");
		} else {
			unset($descitem);
		}

		$files[$file]['description']=$descitem;

		// if(!$short && $descitem) {
			$short=$descitem;
		// }

		if(!is_external(urlencode($file)) && is_file($file)) {
			$fileurl="$protocol//$hostname/" . urlsafe("$file");
		}
		else
		{
			$fileurl=urlsafe("$file");
		}

		if(ereg('^(title|^\[.*\]$)', $file))
		{
			if(!empty($sections[$section])) {
				$sections[$section] .= "
						</div>
					</div>
				</section>";
			}
			$section=ereg_replace("\[(.*)\]", "\\1", "$file");
			$sections[$section] .= "
				<section>
			 		<div class=section id='$section'>
						<h2 class=playlisttitle>$name</h2>
						<div class=playlist>";
			$j = -1;
		} else {
			if (empty($sections[$section])) {
					$sections[$section] .= "
					<section>
						<div class=section id='$section'>
							<div class=playlist>";
			}
			$podcastxml .= "<item>"
			. "<title>" . xmlsafe($name). "</title>"
			. "<link>$protocol//$hostname". rewritelinkid($key) . "</link>"
			. "<guid>". rewritelinkid($key) . "</guid>";
			#				echo "$file<br>";
			if (is_downloadable($file) || $downloadOnly)
			{
				//				$img=ereg_replace("\.pdf\$", ".jpg", $file);
				$item .= "
						<a class=itemlink href='/lib/download.php?f=$filesafe'>
							<div class=download>
								<div class=thumbframe>
									$thumbcode
								</div>";
				$otherinfo="
								<div class=description>
									<div class='file'>" . basename ($file) . "</div>
									<div class='short'>" . htmlsafe($short) . "</div>
									<div class='date'>$filetimeshort</div>
									<div class='size'>$filesizeh</div>
								</div>
							</div>
						</a>";
			}
			else if (ereg('doc$', $file))
			{
				$item .= "
						<a href='$filesafe'>
							<img class='thumb' src='/images/icon-doc.jpg' alt=\"$namesafe\" border='0'>
							<div class='name'>$name</div>
						</a>
						<div class='short'>" . htmlsafe($short) . "</div>
						<a href='$filesafe'>
							<div class='links'>download doc</div>
						</a>";
			}
			else if (eregi('\.jpg$', $file) && $slideshow)
			{
				$gallery.="
						<div class='imageElement'>
							<h3>$name</h3>
							<p>" . htmlsafe($short) . "</p>
							<a href='" . urlsafe("/$file") . "' title='open image' class='open'></a>
							<img src='" . urlsafe("/$file") . "' class='full' />
							$thumbcode
						</div>";
			}
			else if (ereg('\.wav$', $file))
			{
				//				$img=ereg_replace("\.wav\$", ".jpg", $file);
				$item .= "
						<a href='/lib/download.php?f=$filesafe'>
							$thumbcode
							<div class='name'>$name</div>
						</a>
						<div class='short'>" . htmlsafe($short) . "</div>
						<a href='/lib/download.php?f=$filesafe'>
							<div class='links'>download</div>
						</a>";
			}
			else if (ereg('\.pdf$', $file))
			{
				//				$img=ereg_replace("\.pdf\$", ".jpg", $file);
				$item .= "
						<a href='$filesafe' target=_blank>
							$thumbcode
							<div class='name'>$name</div>
						</a>
						<div class='short'>" . htmlsafe($short) . "</div>
						<a href='$filesafe' target=_blank>
							<div class='links'>download</div>
						</a>";
			}
			else
			{
				//				echo "checking $file<br>";
			 	// if (eregi('\.jpg$', $file))
				if ($filetype=="image")
				{
					$large="$file";
				}

				else if (is_file("$webroot/$large"))
				{
					$itemurl=urlsafe("/$large");
					# . "' target='_blank";
#					$itemurl="javascript:setVisible('floatpicture',true);";
				}
				else
				{
					$itemurl="#";
				}

				if ($thumb==null || $thumb=="")
				{
					$item.="
					<div class=nothumb></div>";
				}

				if(!$inpage) {
					$item .= "
							<div class=thumbframe>
								<div class=thumb>
									$thumbcode
								</div>
							</div>";
				}

				if($popup && $popable[$filetype] || $inpage) {
					// $original=getimagesize("$webroot/$file");
					if($original)
					{
						$original['width']=$original[0];
						$original['height']=$original[1];
					} else {
						$original['width']=$width;
						$original['height']=$height;
					}
					$original['width']=max($original['width'], 180);
					$original['height']=max($original['height'], 180);
					$original['prop']=$original['width'] / $original['height'];
					if($largeheight && $largeheight > 0) {
						$shown['prop']=$largewidth / $largeheight;
					} else {
						$shown['prop']=4/3;
					}
					if($original['prop'] >= $shown['prop']) {
						$ratio=$largewidth / $original['width'];
					} else {
						$ratio=$largeheight / $original['height'];
					}
					$shown['width'] = round($original['width'] * $ratio);
					$shown['height'] = round($original['height'] * $ratio);
					$shown['margin'] = round($largeheight / 2 - $shown['height'] / 2);
					if($inpage) {
						// $constraint="style='width: ${shown[width]}px; height: ${shown[height]}px'";
						$popuphtml .= "
							<div class=inpage id=$i style='$display; z-index: 9002;'>
								<div class='nav' id='nav_$i'>
									<div class=info>
										<div class=largename>
										" . htmlsafe($name) . "
										</div>
									</div>
								</div>";
							$inpageout="</div>";
					} else {
						$inpageout="";
						if($popupcenterheight) {
							$constraint="style='position: relative; top: ${shown['margin']}px; width: ${shown['width']}px; height: ${shown['height']}px'";
						}
						$popuphtml.="
							<div class=large id=$i style='display: none; z-index: 9002;'>";
						if($popupnavtitle || $fb_item) {
							$popupnavhtml .= "
								<div class=info>
									<div class=largename>
									" . htmlsafe($name) . "
									</div>
								</div>";
						}
						$popupnavhtml.=$fb_item;

						// if ($popupnavfirst) {
						// 	$popuphtml .= $popupnavhtml;
						// }
					}

					switch($filetype) {
						case "image":
						$popuphtml.="
							$largelink
							<img class='large' id='img_$i' lowsrc='". urlsafe("/$thumb") . "' src='". urlsafe("/$large") . "' alt=\"$namesafe\" >
							$largelinkout";
						break;
						case "video":
						if($inpage) {
							$controls="true";
							$autoplay="false";
						} else {
							$controls="false";
						}
						$controls="true";

						switch($videofallback) {
							case "jwplayer":
							$video_object="
								<div id='jw_$i'>$namesafe</div>
								<script type='text/javascript'>
								  jwplayer('jw_$i').setup({
								    flashplayer: '/lib/jwplayer/player.swf',
								    file: '$filesafe',
								    image: '/$poster',
								    title: '$namesafe',
								    backcolor: '000000',
								    frontcolor: 'CCCCCC',
								    lightcolor: 'FFFFFF',
								    controlbar: 'over',
								    width: '100%',
								    height: '100%',
									bufferlength: 1,
									plugins: ''
								  });
								</script>
								";
								break;
							case "mediaelement":
								break;
							case "videojs":
								$video_object="
									<object id='videojs_$i' class=\"vjs-flash-fallback\" type=\"application/x-shockwave-flash\"
									  data=\"http://releases.flowplayer.org/swf/flowplayer-3.2.1.swf\">
									  <param name=\"movie\" value=\"http://releases.flowplayer.org/swf/flowplayer-3.2.1.swf\" />
									  <param name=\"allowfullscreen\" value=\"true\" />
									  <param name=\"flashvars\" value='config={\"playlist\":[\"/$postersafe\", {\"url\": \"$protocol//$hostname/$filesafe\",\"autoPlay\":false,\"autoBuffering\":true}]}' />
									  <img src=\"/$postersafe\" alt=\"$namesafe\"
									    title=\"No video playback capabilities.\" />
									</object>
								";
								break;
							default:
							$video_object="
								<object class=player id='video_$i' codebase='http://www.apple.com/qtactivex/qtplugin.cab'>
									<param name='src' value='$filesafe'/>
									<param name='controller' value='$controls'/>
									<param name='autoplay' value='true'/>
									<param name='cache' value='$cache'/>
									<param name='scale' value='$scale'/>
									<param name='kioskmode' value='$kioskmode'/>
									<param name='saveembedtags' value='true'/>
									<param name='enablejs' value='true'/>
									<param name='allowscriptaccess' value='true'/>
									<embed class='player'
										id='embed_$i'
										name='video_$i'
										id='embed_$i'
										src='$filesafe'
										controller='$constrols'
										autoplay='true'
										name=video_$i
										cache='$cache'
										scale='$scale'
										kioskmode='$kioskmode'
										saveembedtags='true'
										enablejs='true'
										allowscriptaccess='true'
										type='$mimetypes[$extension]'
										pluginspage='http://www.apple.com/quicktime/download/'
									/>
								</object>
								";
						}

						// if($useragent!="firefox" && $useragent!='opera') {
							$video_html5="
								$largelink
								<video controls class='large $classes[video]' id='video_$i' alt='$namesafe'";
							$video_html5.=" preload=\"none\" ";
							// $video_html5.=" preload ";
							$preloadvideo="preloadVideos();";
							if($poster) {
								$video_html5.=" poster='/$postersafe' ";
							}
							if($controls != 'false' || $html5controller=='true') {
								$video_html5.=" controls ";
							}
							if($autonext) {
								$video_html5.=" onEnded='popOff(\"$i\"); popOn(\"$next\")' ";
							}
							$video_html5.=">\n";
							// $video_html5.="<source src='$filesafe' type='video/mp4' ";
							// 							if($mimetypes[$extension]) {
							// 	$video_html5.=" type='$mimetypes[$extension]' ";
							// }
							$video_html5.=$video_sources;
							$video_html5.=$video_tracks;
							$video_html5.=$video_object;
							$video_html5.="</video>";
							$video_html5.=$largelinkout;
						// }
						// if($inpage || $useragent=='firefox' || $useragent=='opera') {
						if($inpage || $videofallback=='videojs') {
							$popuphtml.=$video_object;
						} else {
							$popuphtml.=$video_html5;
						}
						// $popuphtml.=$object;
						break;
					}
					// if (!$popupnavfirst) {
						$popuphtml .= $popupnavhtml;
					// }
					// $popuphtml .= "
					// 	<div class='name'>" . htmlsafe($name) . "</div>";
					// if($short && $short != "") {
					// 	$popuphtml .= "
					// 		<div class='short'>" . htmlsafe($short) . "</div>";
					// }
					if($descitem) {
						$popuphtml.="
							<div class=description>
							" . htmlsafe($descitem) . "
							</div>";
					}
					$popuphtml.="
						</div>";
					if($popupinblanket) {
						$blanket.=$popuphtml;
					} else {
						$item.=$popuphtml;
					}
					unset($popuphtml);
				} else {
				}
				if(isset($thumb)) {
					$podcastxml .= "<description>"
						. "&lt;a href=" . rewritelinkid($playlistid) . "&gt;"
						. "&lt;img src='$protocol//$hostname/". urlsafe($thumb) . "' border=0&gt;"
					. "&lt;/a&gt;";
				}
				else
				{
					$podcastxml .= "<description>" . xmlsafe($name)." from $pagetitle";
				}
				$podcastxml .= " ($filetime, $filesize)</description>";
				if($inpage) {
					$itemlink="";
					$itemlinkout="";
				}

				}
				### Add detsils from trombinoscope
				$otherinfo="";
				if(!preg_match("/,/", $name)) {
					$detailsId=preg_replace("/-.*/", "", $name);
					if($details[$detailsId]) {
						$otherinfo="<div class='details'>" . htmlsafe(implode("<br/>", $details[$detailsId])) . "</div>";
					}
				}
				$item .= "
					<div class='name'>" . htmlsafe($name) . "</div>";
				$item .= $otherinfo;
				if($short && $short != "") {
					$item .= "
						<div class='short'>" . htmlsafe($short) . "</div>";
				}
				$item = "
						<div class=item>
							$itemlink
							${item}
							${itemlinkout}
						</div>";

			$podcastxml .= "<enclosure url=\"$fileurl\" length=\"$filesize\" type=\"video/quicktime\"/>"
			. "<category>$filekind</category>"
			. "<pubDate>$filetime</pubDate>"
			. "<itunes:author>" . xmlsafe($pagetitle) ."</itunes:author>"
			. "<itunes:explicit>No</itunes:explicit>"
			. "<itunes:subtitle>movie ". xmlsafe($name)." from $pagetitle</itunes:subtitle>"
			. "<itunes:summary>" . xmlsafe($name)." from $pagetitle</itunes:summary>"
			. "<itunes:keywords>" . ereg_replace(' ', ',', xmlsafe(ereg_replace('<.*>', ' ', "$pagetitle $name showreel"))) . "</itunes:keywords>"
			. "</item>";
			#			. "<itunes:duration>00:24:30</itunes:duration>"
		}
		if ($j >= $columns) 	{
			$sections[$section] .= processtags('row', $row);
			$j = 0;
//			$row="";
		}
//		$row .= processtags('item', $item);
		$sections[$section].=$item;
		$item = "";
		$i++;
	}
}

if(!empty($sections[$section])) {
	$sections[$section] .= "$playlistfooter
							</div>
						</div>
					</section>";
}

//$playlist .= processtags('row', $row);
//$playlist = processtags('playlist', $playlist);

if ($slideshow &! empty($gallery)) {
	$head.="		<script src='/lib/mootools-1.2.1-core-yc.js' type='text/javascript'></script>
		<script src='/lib/mootools-1.2-more.js' type='text/javascript'></script>
		<script src='/lib/jd.gallery.js' type='text/javascript'></script>
		<link rel='stylesheet' href='/lib/jd.layout.cssz' type='text/css' media='screen' charset='utf-8' />
		<link rel='stylesheet' href='/lib/jd.gallery.css' type='text/css' media='screen' charset='utf-8' />\n";
	$mediaplayer .= "
		<script type='text/javascript'>
		function startGallery() {
			var myGallery = new gallery($('myGallery'), {
				timed: true
			});
		}
		window.addEvent('domready',startGallery);
		</script>
		<div class='content'>
			<div id='myGallery'>
				${gallery}
			</div>
		</div>\n";
	unset($playlist);
}

// if($popup && $autoplay) {
// 	$onload.="toggle(\"playlists\");popup(0);";
// }

if ($preloadcode || $preloadvideo) {
	// $onload.="$preloadcode $preloadvideo";
	// $onload.="$preloadvideo";
	// $preload="<script type='text/javascript'>window.onLoad=preloadVideos();</script>";
	// $postload="<script type='text/javascript'>preloadVideos();</script>";
	$onload.="firefoxFixAll();";
}

if($REQUEST['ih'] || isset($showitem)) {
	if(!isset($showitem)) {
		$hash=$REQUEST['ih'];
		$showitem=$hashindex[$hash];
	}
	if(isset($showitem)) {
		$file=$index[$showitem];

		$onload.="$windowhide popOn(\"$showitem\");";
		unset($ogthumbs);
		$ogthumbs[]=$siteurl . $files[$file]['thumb'];
		$oglock=true;
		$oguri="$protocol//$hostname$uri?ih=$hash";
		// $ogtitle=$files[$file]['name'];
		$ogdescription=$files[$file]['description'];
		switch($files[$file]['type']) {
			case "video":
			// nearly there... still need to include an SWF video player (only format supported by fb)
			$ogvideo="$siteurl$file";
			break;
		}
	}
}

if($onload && $onload != "") {
	$onload="onload='$onload'";
}
//$description=$shownObject->buildTagsView();
if($shownObject && isset($REQUEST['id']))
{
	$description=$shownObject->buildItemInfo();
} else {
	if(is_array($controls)) {
		unset($controls['playall']);
	}
	$description="All";
}

if($mediaplayer) {
	$mediaplayer="
	<div class=media>
		$mediaplayer
		<div class=infos>
			<div class=description>$description</div>";
	if($controls && is_array($controls)) {
		$mediaplayer.="
			<div class=controls>" . join("\n", $controls) . "</div>";
	}
	$mediaplayer.="
		</div>
	</div>";
	// if(count($list) == 1)
	// {
	// 	unset($playlist);
	// }
}
unset($description);

if ($childsAsSisters)
{
	$sisters=ereg_replace("child", "sister", $childs);
	unset($childs);
	unset($subdirectories);
	$menuchilds=false;
}
else if($menusisters || $menutop)
{
	if($isroot) {
		unset($childs);
	}
#	unset($navigation);
}
else
{
	unset($sisters);
}

if($menuchilds)
{
	if(!ereg("\[subdirectories\]", $about)) {
		unset($subdirectories);
	}
}
else
{
	unset($childs);
}

// if($pageid == "mail") {
// 	unset($combinedcss);
// } else {
	unset($inpagecss);
// }

if($style || $inpagecss) {
	$style="
		<STYLE type='text/css'>
			<!--
			${style}${inpagecss}
			-->
		</STYLE>";

}

if(empty($headtitle)) {
	$headtitle=$pagetitle;
}
$headtitle=strip_tags(ereg_replace("</a>", " / ", processtags(get_defined_vars(), $headtitle)));
$facetitle=strip_tags(ereg_replace("</a>", " / ", processtags(get_defined_vars(), $facetitle)));

// $headtitle=ereg_replace("<[^>]*>", "", $headtitle);

if($rootdir=="") {
	$rooturi="";
	$siteurl="$siteurl/";
} else {
	$rooturi="/$rootdir";
	$siteurl="$siteurl/$rootdir/";
}

if($facebooklinks) {
	if(!$fbstyle) {
		$fbstyle="light";
	}
	if(!$fb_like_showfaces) {
		$fb_like_showfaces='false';
	} else {
		$fb_like_showfaces='true';
	}
	if($fb_like_buttonstyle != "standard")
	{
		$fb_like_buttonstyle="button_count";
	}
	$fb_like="
		<div class=fb_button id=fb_like_button>
			<iframe class=fb_like
				src=\"$protocol//www.facebook.com/plugins/like.php?href="
					. $encodedurl
					. "&amp;layout=$fb_like_buttonstyle&amp;show_faces=$fb_like_showfaces&amp;action=like&amp;font=lucida+grande&amp;colorscheme=light\"
				scrolling=\"no\"
				frameborder=\"0\"
				allowTransparency=\"true\"></iframe>
		</div>
	";

	$fb_recommend=ereg_replace("fb_like", "fb_recommend", ereg_replace("action=like", "action=recommend", $fb_like));
	$fb_share="
			<div class=fb_button id=fb_share_button>
				<a class=\"fb_share\" name=\"fb_share\" type=\"button_count\" href=\"$protocol//www.facebook.com/sharer.php\">Partager</a>
				<script src=\"$protocol//static.ak.fbcdn.net/connect.php/js/FB.Share\" type=\"text/javascript\"></script>
			</div>
	";

	$fb_like="<div style=\"margin-top: 0px\" id=\"fb-root\"></div><script src=\"$protocol//connect.facebook.net/fr_FR/all.js#appId=$fb_param_appid&amp;xfbml=1\"></script><fb:like href=\"$cleanurl\" send=\"$fbsend\" layout=\"button_count\" width=\"auto\" show_faces=\"true\" colorscheme=\"$fbstyle\" font=\"lucida grande\"></fb:like>";

	$fb_send="<div style=\"margin-top: 0px\" id=\"fb-root\"></div><script src=\"$protocol//connect.facebook.net/fr_FR/all.js#appId=$fb_param_appid&amp;xfbml=1\"></script><fb:send href=\"$cleanurl\" font=\"lucida grande\" colorscheme=\"$fbstyle\"></fb:send>";


	$fb_buttons="$fb_init
	<fb:like href=\"$cleanurl\" send=\"$fbsend\" layout=\"button_count\" width=\"auto\" show_faces=\"true\" colorscheme=\"$fbstyle\" font=\"lucida grande\"></fb:like>
	<fb:share-button type=\"button\" href=\"$url\" font=\"lucida grande\" colorscheme=\"$fbstyle\"></fb:share-button>";
}

if($facebookcommentspages) {
	$fb_comments="$fb_init<fb:comments href=\"$cleanurl\" num_posts=\"5\" width=\"$fb_comments_width\" colorscheme=\"$fbstyle\"></fb:comments>";
	// unset($fb_buttons);
}

if($facebooktags) {

	if($ogtype) {
		$videourl="$hostname/$index[0]";
		$fb_meta.="<meta property=\"og:type\" content=\"$ogtype\" />";
		if($ogtype=="movie") {
		$fb_meta.="
			<meta property=\"og:video\" content=\"http://$videourl\" />
			<meta property=\"og:video:secure_url\" content=\"https://$videourl\" />
			<meta property=\"og:video:type\" content=\"video/mp4\" \>
		  	<meta property=\"og:video:height\" content=\"270\" />
  			<meta property=\"og:video:width\" content=\"480\" />
			";
		}
	}
	if(!$oglock) {
		if(ereg("[<\]img", $about.$description)) {
			$flatarray=split("<", $about.$description);
			foreach($flatarray as $flattext) {
				if(ereg("^img ", $flattext)) {
					$image=ereg_replace(".*src=\"([^\"]*)\".*", "\\1", $flattext);
					if($image!=$flattext) {
						if(!ereg("http[s]*://", $image)) {
							$image=$url . $image;
							// Dont use external images for facebook thumbs
							$ogthumbs[]=$image;
						}
					}
				}
			}
		}
		if($ogimage) {
			$ogthumbs[]=$ogimage;
		}
	}
	if(is_array($ogthumbs)) {
		foreach($ogthumbs as $ogthumb) {
			// $ogthumb=ereg_replace("^\./", "", $ogthumb);
			if(!ereg("http[s]*://", "$ogthumb")) {
				if(ereg("^/", $ogthumb)) {
					$ogthumb="$siteurl/$ogthumb";
				} else {
					$ogthumb="$siteurl$directory/$ogthumb";
				}
			}
			$ogthumb=ereg_replace("([^:])//*", "\\1/", $ogthumb);
			while(ereg("/[^/]*/\.\./", $ogthumb)) {
				$ogthumb=ereg_replace("/[^/]*/\.\./", "/", $ogthumb);
			}
			$fb_meta.="<meta property=\"og:image\" content=\"$ogthumb\"/>";
		}
	}
	if($fbadmins) {
		$fb_meta.="<meta property=\"fb:admins\" content=\"$fbadmins\"/>";
	}
	if($fb_app_id) {
		$fb_meta.="<meta property=\"fb:app_id\" content=\"$fb_app_id\"/>";
	}
	if($oguri) {
		$fb_meta.="<meta property=\"og:url\" content=\"$oguri\"/>";
	} else {
		$fb_meta.="<meta property=\"og:url\" content=\"$protocol//$hostname$uri\"/>";
	}
	// if($facetitle) {
		$fb_meta.="<meta property=\"og:title\" content=\"" . quotesafe($facetitle) ."\"/>";
	// } else {
	// 	$fb_meta.="<meta property=\"og:title\" content=\"" . quotesafe($headtitle) ."\"/>";
	// }
	if($ogvideo) {
		$fb_meta.="<meta property=\"og:video\" content=\"" . quotesafe($ogvideo) ."\"/>";
	}
	if($ogdescription) {
		$fb_meta.="<meta property=\"og:description\" content=\"" . quotesafe($ogdescription) ."\"/>";
	}
	$fb_meta.="
			<meta property=\"og:site_name\" content=\"" . quotesafe($sitetitle) ."\"/>
			";
}

if($inputurl) {
	if(!ereg("://", $inputurl)) {
		if(getenv('SERVER_PORT') != 80) {
			$port=":" . getenv('SERVER_PORT');
		}
		$geturl.="$protocol//$hostname$port/";
		if(!ereg('^/', $inputurl)) {
			$geturl.="$directory/";
		}
	}
	$geturl.=$inputurl;
	$input=file_get_contents($geturl);
}

if(file_exists('$libdir/jaime.php'))
{
	include_once('$libdir/jaime.php');
}

if($top && $top != "") {
	$top="<div class=top>$top</div>";
}
if($left && $left != "") {
	$left="<div class=left><aside>$left</aside></div>";
}
if($right && $right != "") {
	$right="<div class=right><aside>$right</aside></div>";
}
if($surtitle && $surtitle != "") {
	$surtitle="<div class=surtitle>$surtitle</div>";
}
# <meta property=\"og:image\" content=\"abc.jpg\"/>

$pageurl=getenv('SCRIPT_URI');
$encodedurl=urlencode(getenv('SCRIPT_URI'));
$encodedpagetitle=ereg_replace("\+", "%20", urlencode($pagetitle));

###################
## Generate tag cloud

if(($sitekeywords || $pagekeywords)) {
	# &! $noindex
	if(!ereg(',', $sitekeywords)) $sitekeywords=ereg_replace(" ", ",", $sitekeywords);
	if(!ereg(',', $pagekeywords)) $pagekeywords=ereg_replace(" ", ",", $pagekeywords);
	$keywords="$pagekeywords,$sitekeywords";
	$keywords=ereg_replace("[\n\t]", " ", $keywords);
	$keywords=ereg_replace(";", ",", $keywords);
	$keywords=ereg_replace("-", " ", $keywords);
	$keywords=ereg_replace(" *, *", ",", $keywords);
	$keywords=ereg_replace("  *", " ", $keywords);
	$keywords=ereg_replace(",,*", ",", $keywords);
	$keywords=utf8_encode(strtolower(utf8_decode($keywords)));
	$metakeywords=trim($keywords);
	$metakeywords=ereg_replace("\|", ",", $metakeywords);
	$metakeywords=ereg_replace(",,*", ", ", $metakeywords);
	$metakeywords=ereg_replace("^, ", "", $metakeywords);
	$keywords=split(",", $keywords);
	$flattext="$navigation $pagetitle $headtitle $about $description $pagekeywords";
	$flattext=ereg_replace("\<[^>]*>", "", $flattext);
	$flattext=ereg_replace("[-,;:.\?!=+€()\"]", " ", $flattext);
	$flattext=ereg_replace("[\n\t]", " ", $flattext);
	$flattext=ereg_replace("[-_]", " ", $flattext);
	$flattext=ereg_replace("  *", " ", $flattext);
	$flattext=utf8_encode(strtolower(utf8_decode($flattext)));
	while(list($key, $expression)=each($keywords)) {
		$words=split("\|", $expression);
		$keyword=$words[0];
		foreach ($words as $word){
			if($word=="") {
				continue;
			}
			if($word != "")
			{
				$count=substr_count($flattext, $word);
			}
			if ($count) {
				$cloud[$keyword]+=substr_count($flattext, $word);
			}
		}
	}
	arsort($cloud);
	$cloud = array_chunk($cloud, $cloudmax, true);
	$cloud = $cloud[0];
	$steps=5;
	$i=0;
	$count=count($cloud);
	if(is_array($cloud)) {
		foreach ($cloud as $word => $popular){
			$p=ceil(($count - $i) * $steps / $count);
	        $class = "cloud$p";
			$cloudhtml[$word]="<a href='$link' class='cloud$p'>$word</a>";
			$i++;
		}
	}
	if(is_array($cloudhtml)) {
		ksort($cloudhtml);
		$cloud="<div class='cloud'>" . join(" ", $cloudhtml) . "</div>";
	} else {
		$cloud="";
	}
} else {
	$cloud="";
}

if($keeptags) {
	reset($wrap_editable_parts);
	foreach($wrap_editable_parts as $part) {
		eval("\$$part=ereg_replace('{', '&#123;', \$$part);");
		eval("\$$part=ereg_replace('\[', '&#91;', \$$part);");
	}
	// left curly brace: &#123;
	// right curly brace: &#125;
	// $about=ereg_replace("\[", "&#91;", $about);
	// $about=ereg_replace("\]", "&#93;", $about);
}

$about=removeChordPro($about);

###################
## Display all those little things
## (process html or rss)

if($REQUEST['output']=="rss" && $podcast)
{
	// would probably be better to use the higher mod date of displayed files
	$lastBuildDate=date ("D, d M Y H:i:s O");
	$pubDate=$lastBuildDate;
	//

	header("Content-Type: text/html; charset=$charset");
	echo "<?xml version='1.0' encoding='UTF-8'?>"
	. "<rss xmlns:itunes=\"http://www.itunes.com/dtds/podcast-1.0.dtd\" version=\"2.0\">"
	. "<channel>"
	. "<title>$globaltitle $pagetitle</title>"
	. "<description>$pagetitle</description>"
	. "<link>$protocol//" . $hostname . rewritelink() . "</link>"
	. "<language>en-us</language>"
	. "<copyright>Copyright 2008</copyright>"
	. "<lastBuildDate>$lastBuildDate</lastBuildDate>"
	. "<pubDate>$pubDate</pubDate>"
	. "<docs>http://blogs.law.harvard.edu/tech/rss</docs>"
	. "<webMaster>webmaster@magiiic.com</webMaster>";
	echo $podcastxml
	. "</channel>"
	. "</rss>";
}
else if($REQUEST['output']=="flv")
# else if(isset($REQUEST['flv']))
{
	header("Content-Type: text/xml; charset=$charset");
	echo $flvplaylist;
	exit;
} else {

	header("Content-Type: text/html; charset=$charset");

/*

## it's quite simple to output a Microsoft Word file...
## however, it's useless in this specific project. Keeping lines for memories

	if($REQUEST['output']=="doc") {
		header("Content-Type: application/msword; charset=$charset");
		header("Content-Disposition: attachment; filename=generated.doc; charset=$charset");
	} else {
		header("Content-Type: text/html; charset=$charset");
	}

*/

## set some tags
	if($levelisetitles) {
		$level=ereg_replace("[^0-9]", "", $pagesettings[$directory]['level']);
	}
	if(! $level || $level == "") {
		$level=1;
	}
	$pagetitle="<h$level id='pagetitle' class='pagetitle'>" . trim($pagetitle) . "</h$level>";

	if ($noindex)
	{
		$head.=  '		<meta name="robots" content="noindex, nofollow">' . "\n";
		$head.=  '		<meta name="googlebot" content="noindex, nofollow">' . "\n";
		header("X-Robots-Tag: noindex, nofollow", true);
	}
	if ($podcast)
	{
		$head.="		<link rel='alternate' type='application/rss+xml' title='RSS' href='/$directory/?output=rss'>\n";
	}
	if($pagetemplate && is_file($pagetemplate))
	{
		//	include($pagetemplate);
		$layout=eregi_replace("<head>", "<head>\n[head][style]", file_get_contents($pagetemplate));
	} else {
		$layout="<html>
	<head>
		<title>[headtitle]</title>
	</head>
	<body>
		<header>
			<nav>
				[navigation]
			</nav>
			[logo]
		</header>
		<aside>
			[tree][links][left]
		</aside>
		<article>
			[pagetitle]
			[about]
			[description]
		</article>
		[mediaplayer][blanket]
		[playlist]
		[cloud]
		<aside>
			[right]
		</aside>
		<footer>
			[footer][footerlogo]
		</footer>
	</body>
</html>";
	}
	if(!eregi('<meta[^<>]*content-type', $layout)) {
		$head.="\n	<meta http-equiv='content-type' content='text/html;charset=$charset'>";
	}
	$layout=eregi_replace('<body', '<body [onload]', $layout);
	if($metakeywords) {
		$head.="\n	<meta name='keywords' content='$metakeywords'/>";
	}
	if(!ereg('\[head\]', $layout))
	{
		$layout=eregi_replace('<head>', "<head>[head]", $layout);
	}
	if(!ereg("browser[0-9]*.js", $layout))
	{
		$layout=eregi_replace('</head>', "<script type='text/javascript' src='$libdirurl/$scriptname.js'></script></head>", $layout);
	}
	switch ($videofallback) {
		case "jwplayer":
			$layout=eregi_replace('</head>', "<script type='text/javascript' src='/lib/jwplayer/jwplayer.js'></script></head>", $layout);
			break;
		case "mediaelement":
			$layout=eregi_replace('</head>', "<link rel='stylesheet' href='/lib/mediaelement/mediaelementplayer.css' /></head>", $layout);
			$layout=eregi_replace('</head>', "<script src='/lib/mediaelement/jquery.js'></script><script src='/lib/mediaelement/mediaelement-and-player.min.js'></script></head>", $layout);
			$layout=eregi_replace('</body>', "<script>$('video,audio').mediaelementplayer();</script></body>", $layout);
			break;
		case "videojs":
			$layout=eregi_replace('</head>', "<script src='/lib/videojs/video.js' type='text/javascript' charset='utf-8'></script></head>", $layout);
			$layout=eregi_replace('</head>', "<link rel='stylesheet' href='/lib/videojs/video-js.css' type='text/css' media='screen' title='Video JS' charset='utf-8'></head>", $layout);
			$layout=eregi_replace('</body>', "<script type='text/javascript' charset='utf-8'>VideoJS.setupAllWhenReady();</script></body>", $layout);
			break;
		// default:
			// $layout=eregi_replace('</body>', "<script type='text/javascript' charset='utf-8'>firefoxFixAll();</script></script></body>", $layout);
	}

	// FireFox fix

	$layout=eregi_replace('</head>', "${combinedcss}\n${fb_meta}\n\t$preload</head>", $layout);

	$layout=ereg_replace("\t", " ", $layout);
	$layout=ereg_replace("\n *", "\n", $layout);
	$layout=eregi_replace("\n\n*", "\n", $layout);
	$layout=ereg_replace("\[blanket\]", "", $layout);

	if ($config['debug'] || $debug || $_REQUEST['debug']==true) {
		$debuginfo=ereg_replace("^</p>", "", $debuginfo);
		$debuginfo="<div class=debug>${debuginfo}[processtime]</p></div>";
	} else {
		unset($debuginfo);
	}
	$finalpage=processtags(get_defined_vars(), $layout);
	// if(!$keeptags) {
		$finalpage=processtags(get_defined_vars(), $finalpage);
	// }
	$finalpage=processChordPro($finalpage);

	if(is_array($bodyclasses)) {
	    $bodyclass="class=\"" . implode(" ", $bodyclasses) . "\"";
		$finalpage=ereg_replace("<body", "<body $bodyclass ", $finalpage);
	}

	if (! $pageid) {
	   if ($requesturi == "/") {
	      $pageid="front";
	   } else {
	      $pageid=preg_replace("/[^a-zA-Z0-9]+/", "-", $requesturi);
	      $pageid=preg_replace("/^-|-$/", "", $pageid);
	   }
	}
	if ($pageid) {
		$finalpage=ereg_replace("<body", "<body id='$pageid'", $finalpage);
	} elseif ($isroot) {
		$finalpage=ereg_replace("<body", "<body id='root'", $finalpage);
	}

	$finalpage=preg_replace_callback("|\[fbevents:([^\[]*)\]|", "parseFBEevents", $finalpage);
	$finalpage=preg_replace_callback("|\[itunes:([^\[]*)\]|", "parseItunes", $finalpage);
	$finalpage=preg_replace_callback("|\[rss:([^\[]*)\]|", "parseFromTag", $finalpage);
	$finalpage=preg_replace_callback("|\[weather:([^\[]*)\]|", "parseWeather", $finalpage);
	if(ereg("\[shop:", $finalpage)) {
		$shop=ereg_replace(".*\[shop:([^\[]*)\].*", "\\1", $finalpage);
		require_once ("$libdir/shop/shop.php");
		$finalpage=ereg_replace("\[shop:([^\[]*)\]", $session['shop']['form'], $finalpage);
		$finalpage=eregi_replace('</head>', $session['shop']['csslink'] . "\n</head>", $finalpage);
	}

	$viewport='<meta name="viewport" content="width=device-width, initial-scale=1.0">';
	$finalpage=eregi_replace('</head>', "${viewport}</head>", $finalpage);

#	if($output=="iPhone" || isset($bodyclasses['smartphone']))
	if($output=="iPhone")
	{
// 		<meta name='viewport' content='initial-scale=1' />

		$iphoneheaders="
			<meta name='viewport' content='initial-scale=0.6' />
			<link href='/browser-mobile.css' rel='stylesheet' media='all'>
			";
		$finalpage=eregi_replace('</head>', "${iphoneheaders}</head>", $finalpage);
		#		$layout=eregi_replace('</head>', "${combinedmobilecss}</head>", $layout);
	}

	$finalpage=preg_replace_callback("|\[playlist:([^\[]*)\]|", "parsePlaylists", $finalpage);
    $playlist="<div id='blanket' style='display:none;'></div><div id='blanketfix' style='display:none;'>$blanket</div>${playall}"
		. "<div id=playlists onMouseOver='$preloadvideo'>"
		. join("\n", $sections)
		. "</div>";

		#

	$finalpage=ereg_replace("<h1 [^>]*></h1>", "", $finalpage);

	unset($blanket);
	// $playlist="<div id='blanket' style='display:none;'>$blanket</div>"
	// 	. "<div id=playlists>"
	// 	. $playall . join("\n", $sections)
	// 	. "</div>";
	$finalpage=ereg_replace("\[playlist\]", $playlist, $finalpage);
	$finalpage=ereg_replace("<p>\[img([a-zA-Z0-9]*):([^\[]*)\]</p>", "<div class=intext\\1>[img\\1:\\2]</div>", $finalpage);
	$finalpage=ereg_replace("\[video([a-zA-Z0-9]*):([^\[]*)\.([a-zA-Z0-9]*)\]", "<video controls='' class='large intext' alt='\\2' preload='auto'><source src='\\2.\\3' type='video/\\3'><object class='player' codebase='http://www.apple.com/qtactivex/qtplugin.cab'><param name='src' value='\\2.\\3'><param name='controller' value='true'><param name='autoplay' value='false'><param name='cache' value='true'><param name='scale' value='aspect'><param name='kioskmode' value='true'><param name='saveembedtags' value='true'><param name='enablejs' value='true'><param name='allowscriptaccess' value='true'><embed class='player' name='\\2' src='\\2.\\3' controller='' autoplay='false' cache='true' scale='aspect' kioskmode='true' saveembedtags='true' enablejs='true' allowscriptaccess='true' type='video/\\3' pluginspage='http://www.apple.com/quicktime/download/'></object></video>", $finalpage);

	$finalpage=ereg_replace("\[img([a-zA-Z0-9]*):([^\[]*)\]", "<img class=intext\\1 src='\\2'>", $finalpage);

	$finalpage=ereg_replace("</body", "$postload</body", $finalpage);

	if($debug) {
		$timeend=time();
		$processtime="<p class=debug>Process time: " . ($timeend - $timebegin) . "s</p>";
		$finalpage=ereg_replace("\[processtime\]", $processtime, $finalpage);
	}
	// if(!$keeptags) {
		$finalpage=ereg_replace("\[[a-z_:]*\]", "", $finalpage);
	// }
	if($REQUEST['output']=='source') {
		$finalpage="<pre>" . htmlentities($finalpage) . "</pre>";
	}

	$finalpage=ereg_replace("<aside></aside>", "", $finalpage);
	$finalpage=ereg_replace("<div class=left>[:blank:]*</div>", "", $finalpage);
	$finalpage=clean_html_code($finalpage);
	$finalpage=ereg_replace("\n", " ", $finalpage);
	$finalpage=ereg_replace("  *", " ", $finalpage);
#	$finalpage=ereg_replace("> <", "><", $finalpage);
	$finalpage=ereg_replace("<p> *</p>", "", $finalpage);
	$finalpage=ereg_replace("<div[^>]*> *</div>", "", $finalpage);
	$finalpage=ereg_replace("<aside[^>]*> *</aside>", "", $finalpage);
	$finalpage=ereg_replace("<nav[^>]*> *</nav>", "", $finalpage);
	$finalpage=ereg_replace("<div[^>]*> *</div>", "", $finalpage);
	print "$finalpage";
}
?>
