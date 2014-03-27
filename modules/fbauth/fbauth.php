<?php
require_once("fbauth_functions.php");

if($addons['fbauth']) {
	// if($facebookapi) {
	// 	$facebook = new Facebook(array(
	// 	        'appId'  => $fb_app_id,
	// 	        'secret' => $fb_app_secret,
	// 	        'cookie' => true));
	// }
	
	// $wrap_buttons.="<a href='" . $facebook->getLogoutUrl(array('next' => $url)) . "'>logout</a>";

	if($_REQUEST['wrap']=='connect') {
		wrapSessionConnect();
		$redirect=$url;
	}
	
	// if(!$_SESSION['wrap']['connected'] && $user->id) {
	// } else 
	if($_REQUEST['wrap']=='disconnect') {
		wrapSessionDisconnect();
		
		// still something to find out;
		$redirect=$url;
	} else if(! isset($fb_app_id) || !isset($fb_app_secret)) {
		debug("fb_auth set but no app id or no secret");
	} else if ($localserver) {
		debug("fb_auth set but server is local");
		// if($_SESSION['wrap']['connected']) {
		// 	$_SESSION['wrap']['connected']=true;
		// }
	} else {
		// $fb_app_id = "109191889117913";
		// $fb_app_secret = "723096ec9e86f3b03c46a7c0cf0d4ca6";
		$fb_cookie = get_facebook_cookie($fb_app_id, $fb_app_secret);
		$fb_graphurl='https://graph.facebook.com/me?access_token=' . $fb_cookie['access_token'];

		if ($fb_cookie) {
			$graph=file_get_contents($fb_graphurl);
			$user = json_decode($graph);
			$user->wrap_auth_last=time();
			$user->wrap_auth_method="facebook";
		}

		if($user->id && $_SESSION['wrap']['idle']) {
			wrapSessionConnect();
		}
		
		if($user->id && $_SESSION['wrap']['connected']) {
			$auth_id="fb_" . $user->id;
			$auth_name=$user->name;
			$users[$auth_id]=$user;
			$usercache="$cacheroot/wrap_info_$auth_id.info";
			file_put_contents($usercache, json_encode($user));
			if($user->gender=="female") {
				$localisation['e']="e";
			} else {
				$localisation['e']="";
			};
			
			$wrap_info.="<div class=connected>" 
				. localise("Connected as") . " $user->name (via $user->wrap_auth_method)" 
				. "</div>";
			
			if(is_array($wrap_rights[$auth_id])) {
				ksort($wrap_rights[$auth_id]);
				foreach($wrap_rights[$auth_id] as $key => $value) {
					$indexkey=ereg_replace("^/", "", $key);
					if (ereg("^$indexkey", "$directory")) {
						$wrap_editable=$value;
					}
					$dirtitle=firstValidValue($pagesettings[$indexkey]['menutitle'], $pagesettings[$indexkey]['pagetitle'], generateFolderName($indexkey));
					if($value) {
						$hassomerights=true;
						$wrapdirs.="<li class=dir><a href=\"$key\">$dirtitle ($key)</a></li>";
					// } else {
					// 	$wrapdirs.="<li class=dir><stroke>$dirtitle ($key)</stroke></li>";
					}
					$editable[$indexkey]=$value;
				}
			}
		} else if(!$user->id &! $localserver) {
			wrapSessionDisconnect();
			$_SESSION['wrap']['idle']=true;
		}
		if($wraploginscreen) {
			$wrap_connect_buttons.="<a class=button href=\"$wraploginscreen?auth=${domain}&token=${wraptoken}\" target=wrap>" . localise("login") . "</a>";
		} else {
			if(!$localserver) {
				$fb_login="<div id=\"fb-root\"></div><div id=\"fb-root\"></div>
					<script src=\"http://connect.facebook.net/fr_FR/all.js\"></script>
				<script>
					FB.init({appId: '$fb_app_id', status: true,
					cookie: true, xfbml: true});
				FB.Event.subscribe('auth.login', function(response) {
					window.location.reload();
					});
					</script><fb:login-button></fb:login-button>";
				}
			}
	}
}

?>