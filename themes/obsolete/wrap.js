savedstatus=new Array();
fullscreenstate=new Boolean();
// posinitial=new String();

function changeBackground(id, image) {
	// url = 'url(' + image + ')';
	el = document.getElementById(id);
	el.style.backgroundImage = 'url(' + image + ') ';
	return;
}

function preloadImage(url) {
	if (document.images) {
 		cache = newImage(url);
	}
}

function preloadVideos() {
	var arVideos = document.getElementsByTagName('video');
//	for (var i = arVideos.length - 1; i >= 0; i--) {
//	    var elmVideo = arVideos[i];
//	    elmVideo.preload = "auto";
		// var elmCache = document.createElement('video');
		//         elmCache.preload = 'metadata';
		//         elmCache.id = elmVideo.id;
		//         elmCache.src = elmVideo.src;
		//         cache = elmCache;
		// cache=elmVideo;
		// cache=new Video(elmVideo.url);
//	}
}

function showNav(div_id) {
	nav_id = 'nav_' + div_id;
	el = document.getElementById(nav_id);
	el.style.display = 'block';
}
function hideNav(div_id) {
	nav_id = 'nav_' + div_id;
	el = document.getElementById(nav_id);
	el.style.display = 'none';
}
function toggle(div_id) {
	video_id = 'video_' + div_id;
	el = document.getElementById(div_id);
	// video = document.getElementById(video_id);
	if ( el.style.display == 'none' ) {	
		el.style.display = 'block';
		// video.play();
	}
	else {
		el.style.display = 'none';
		// video.pause();
	}
}

function windowShow(div_id) {
	el = document.getElementById(div_id);
	if(el) {
		// el.style.display = 'block';
		if(!savedstatus[div_id] || savedstatus[div_id] == "none") {
			el.style.display='block';
		} else {
			el.style.display = savedstatus[div_id];
		}
		el.style.display.width = getStyle(el, 'width');
		el.style.display.height = getStyle(el, 'height');
	}
}

function windowHide(div_id) {
	el = document.getElementById(div_id);
	if(el) {
		var thisstatus=getStyle(el, 'display');
		if(thisstatus != 'none') {
			savedstatus[div_id]=thisstatus;
		}
		el.style.display = 'none';
	}
}

function getStyle(oElm, strCssRule){
	var strValue = "";
	if(document.defaultView && document.defaultView.getComputedStyle){
		strValue = document.defaultView.getComputedStyle(oElm, "").getPropertyValue(strCssRule);
	}
	else if(oElm.currentStyle){
		strCssRule = strCssRule.replace(/\-(\w)/g, function (strMatch, p1){
			return p1.toUpperCase();
		});
		strValue = oElm.currentStyle[strCssRule];
	}
	return strValue;
}

function switchSrc(div_id, src){
	video = getVideoById(div_id);
	if(video) {
		video.src=src;
		videoRewind(div_id);
		videoPlay(div_id);
		return;
	}
	el = document.getElementById(div_id);
	if(el) {
		el.src=src;		
	}
	return;
}
function videotoggle(div_id) {
	el = document.getElementById(div_id);
	video = document.getElementById('video_' + div_id);
	if(video) {
		// playbutton = document.getElementById('play_' + div_id);
		// pausebutton = document.getElementById('pause_' + div_id);
		if ( el.style.display != 'none' ) {
			// video.preload="auto";
			video.currentTime = 0;
			video.play();
			// playbutton.style.display = 'none';
			// pausebutton.style.display = 'inline-block';
		} else {
			video.pause();
			// playbutton.style.display = 'none';
			// pausebutton.style.display = 'none';
		}
	}
	return;
}

// function videoPreload(div_id) {
// 	el = document.getElementById(div_id);
// 	video = document.getElementById('video_' + div_id);
// 	if(video) {
// 		video.preload = 'metadata';
// 	}
// }

function getVideoById(div_id) {
	video = document.getElementById('video_' + div_id);
	// firefoxFixVideo(video);
	if(!video) {
	// if(typeof(video.play) != 'function'){
		// tryjw;
		// video = jwplayer('jw_' + div_id);
		// if(!video) {
			video=document['object_' + div_id];
			if(typeof(video) != 'object'){
				video=document['embed_' + div_id];
			}
		// }
	}
	return video;
}
function videoSaveState(div_id) {
	video = getVideoById(div_id);
	if(video) {
		// fullscreenstate=video.fullscreen();
	}
}

function videoRestoreState(div_id) {
	video = getVideoById(div_id);
}

function videoPlay(div_id) {
	video = getVideoById(div_id);
	if(video) {
		video.preload = 'auto';
		video.play();
	}
	return;
}

function videoPause(div_id) {
	video = getVideoById(div_id);
	if(video) {
		if(typeof video.pause == 'function') {
			video.pause();
		}
	}
	return;
}

function videoRewind(div_id) {
	video = getVideoById(div_id);
	if(video) {
		if(video.currentTime) {
			video.currentTime = 0;
		}
	}
	return;
}

function blanket_size(popUpDivVar) {
	if (typeof window.innerWidth != 'undefined') {
		viewportheight = window.innerHeight;
	} else {
		viewportheight = document.documentElement.clientHeight;
	}
	if ((viewportheight > document.body.parentNode.scrollHeight) && (viewportheight > document.body.parentNode.clientHeight)) {
		blanket_height = viewportheight;
	} else {
		if (document.body.parentNode.clientHeight > document.body.parentNode.scrollHeight) {
			blanket_height = document.body.parentNode.clientHeight;
		} else {
			blanket_height = document.body.parentNode.scrollHeight;
		}
	}
	var blanket = document.getElementById('blanket');
//	blanket.style.height = blanket_height + 'px';
	var popUpDiv = document.getElementById(popUpDivVar);
//	popUpDiv_height=blanket_height/2-150;//150 is half popup's height
//	popUpDiv_height=(blanket_height-popUpDiv.style.height)/2;//150 is half popup's height
//	popUpDiv.style.top = popUpDiv_height + 'px';
}
function window_pos(popUpDivVar) {
	if (typeof window.innerWidth != 'undefined') {
		viewportwidth = window.innerHeight;
	} else {
		viewportwidth = document.documentElement.clientHeight;
	}
	if ((viewportwidth > document.body.parentNode.scrollWidth) && (viewportwidth > document.body.parentNode.clientWidth)) {
		window_width = viewportwidth;
	} else {
		if (document.body.parentNode.clientWidth > document.body.parentNode.scrollWidth) {
			window_width = document.body.parentNode.clientWidth;
		} else {
			window_width = document.body.parentNode.scrollWidth;
		}
	}
	var popUpDiv = document.getElementById(popUpDivVar);
	// if(popUpDiv) {
		window_width=window_width/2-(popUpDiv.style.width);//150 is half popup's width
	// }
//	popUpDiv.style.left = window_width + 'px';
}
function popup(windowname) {
	// blanket_size(windowname);
	// window_pos(windowname);
	videoSaveState(windowname);
	toggle('blanket');
	toggle('blanketfix');
	videotoggle(windowname);	
	toggle(windowname);
}

function popOn(windowname) {
	// blanket_size(windowname);
	// window_pos(windowname);
	// preloadVideos();
	windowShow('blanket');
	windowShow('blanketfix');
	videoRewind(windowname);
	windowShow(windowname);
	// videoRestoreState(windowname);
	videoPlay(windowname);	
}

function popOff(windowname) {
	// blanket_size(windowname);
	// window_pos(windowname);
	videoSaveState(windowname);
	videoPause(windowname);	
	windowHide('blanket');
	windowHide('blanketfix');
	windowHide(windowname);
}

function moveObject(div_id, x) {
	el = document.getElementById(div_id);
	el.style.left = x;
}

function textediv_id(div_id) { 
   if (!div_id) div_id = document.getElementById('scroll'); 
   if (div_id) { 
      if(poscurrent < ( - div_id.offsetWidth) ){ 
         poscurrent = posinitial; 
                } else { 
         poscurrent+= -1; // pixel par deplacement 
      } 
      div_id.style.left = poscurrent+"px"; 
   } 
} 

function canPlayVideo(object) {
	if(typeof(object)!='object') return false;
	// if(!object.src) return false;
	if(object.src) {
		extension=getFileExtension(object.src).toLowerCase();
		if(extension=='m4v') extension='mp4';
		if(extension=="") return false;
		if(typeof(object.canPlayType) != 'function') return false;
		if(!object.canPlayType("video/" + extension)) return false;
		return true;
	}
	if(object.currentSrc) {
		return true;
	}
	return false;
}
function getFileExtension(filename) {
	if( filename.length == 0 ) return "";
	var dot = filename.lastIndexOf(".");
	if( dot == -1 ) return "";
	var extension = filename.substr(dot + 1,filename.length);
	return extension; 
} 

function firefoxFixVideo(object) {
	if(!object) {
		return;
	}
	tagname=object.tagName.toLowerCase();
	if(tagname != 'video') {
		return;
	} 
	if(canPlayVideo(object)) {
		return;
	}
	if(!object.innerHTML) {
		return;
	}
 	if(object.NETWORK_NO_SOURCE) {
		fallback=object.innerHTML;
		fallback.id=object.id;

		if(object.outerHTML) {
			object.outerHTML=fallback;
		} else {
			parent=object.parentNode;
			parent.innerHTML=fallback;
		}
	}
	return;
}

function firefoxFixAll () {
	addfeedback("fixing all");
	elements=document.plugins;
	for (x=0;x<elements.length;x++){
		o=elements[x];
		firefoxFixVideo(o.parentNode);
		firefoxFixVideo(o.parentNode.parentNode);
	}
}

function feedback(feedbacktext) {
	feeddiv=document.getElementById('feedback');
	if(feeddiv) {
		feeddiv.innerHTML=feedbacktext;
	}
}
function addfeedback(feedbacktext) {
	feeddiv=document.getElementById('feedback');
	if(feeddiv) {
		feeddiv.innerHTML+='<br>\r\n' + feedbacktext;
	}
}

document.onLoad=firefoxFixAll();

