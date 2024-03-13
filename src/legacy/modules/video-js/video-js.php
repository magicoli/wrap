<?php
	$videofallback='video-js';
	$videojslib="/lib/video-js/";
	$classes['video'].="video-js vjs-default-skin";

	$head.="<link href='${videojslib}video-js.css' rel='stylesheet' type='text/css'>";
	$head.="<script src='${videojslib}video.js'></script>";
	$head.="<script>
    		videojs.options.flash.swf = '${videojslib}video-js.swf';
  		</script>";
?>