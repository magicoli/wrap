<?php
function get_facebook_cookie($fb_app_id, $fb_app_secret) {
	$args = array();
	parse_str(trim($_COOKIE['fbs_' . $fb_app_id], '\\"'), $args);
	ksort($args);
	$payload = '';
	foreach ($args as $key => $value) {
		if ($key != 'sig') {
			$payload .= $key . '=' . $value;
		}
	}
	if (md5($payload . $fb_app_secret) != $args['sig']) {
		return null;
	}
	return $args;
}

function wrapSessionConnect() {
	global $user;
	if($_SESSION['wrap']['disconnected']) {
		$_SESSION['wrap']['toolbox']=true;
		if(!$_SESSION['auth']) $_SESSION['wrap']['edit']=true;
	}
	$_SESSION['wrap']['connected']=true;
	unset($_SESSION['wrap']['disconnected']);
	unset($_SESSION['wrap']['idle']);
}

function wrapSessionDisconnect() {
	unset($_SESSION['request']);
	unset($_SESSION['wrap']);
	$_SESSION['wrap']['disconnected']=true;
	$_SESSION['wrap']['connected']=false;
}


function validateAuthRequest() {
	global $localserver, $wrap_info, $localisation;
	unset($_SESSION['auth']);
			
	if($_SESSION['wrap']['connected']) {

		// $referer=getenv("HTTP_REFERER");
		// if(!$referer && $localserver) {
		// 	$referer="http://www.van-helden.net/wrap/?wrap=connect";
		// }		
		$referer=$_SESSION['request']['referer'];
		$refparts=parse_url($_SESSION['request']['referer']);
		$refdomain = preg_replace("(^preview\.|^dev\.|^www\.)", "", $refparts['host']);

		if($_SESSION['request']['auth']) {
			$authdomain = preg_replace("(^preview\.|^dev\.|^www\.)", "", $_SESSION['request']['auth']);
			if($refdomain != $authdomain) {
				unset($_SESSION['request']);
				$_SESSION['auth']['result']=localise("Invalid domain");
				return false;
			}
		}
		
		$returnpage = "$refparts[scheme]://$refparts[host]$refparts[path]";

		$wraptoken=md5("wrapped by magiiic $refdomain");
		
		if($_SESSION['request']['token']!=$wraptoken) {
			// echo "wraptoken: $wraptoken<br>";
			unset($_SESSION['request']);
			$_SESSION['auth']['result']=localise("Invalid token");
			// hint
			$_SESSION['auth']['result'].=" (hint: $wraptoken)";
			return false;
		} else {
			$_SESSION['auth']['result']=localise("Validated");
			$_SESSION['auth']['authdomain']=$authdomain;
			$_SESSION['auth']['referer']=$referer;
			$_SESSION['auth']['refdomain']=$refdomain;
			$_SESSION['auth']['returnpage']=$returnpage;
			$_SESSION['auth']['wraptoken']=$wraptoken;
			$_SESSION['auth']['format']=$_SESSION['request']['format'];
			$_SESSION['auth']['user']=$_SESSION['user'];
			unset($_SESSION['request']);
			$_SESSION['wrap']['edit']=false;
			return true;
		}
		$_SESSION['auth']['result']=localise("Connected, but obscure status");
		return false;
	} else {
		$_SESSION['auth']['result']=localise("Identification needed");
		return false;
	}
	$_SESSION['auth']['result']=localise("Unknown status");
	return false;
}

?>