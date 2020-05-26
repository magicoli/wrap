<?php
## Aloha integration

if($addons['aloha'] && $wrap_editable && $editmode) {
  // add_js (BASE_URI . "/contrib/aloha/plugins/com.gentics.aloha.plugins.Abbr/plugin.js");
  // add_js (BASE_URI . "/contrib/aloha/plugins/com.gentics.aloha.plugins.HighlightEditables/plugin.js");

	add_js (BASE_URI . "/contrib/aloha/aloha.js");
	add_js (BASE_URI . "/contrib/aloha/plugins/uk.co.magiiic.AutoSave/plugin.js");
	add_js (BASE_URI . "/contrib/aloha/plugins/com.gentics.aloha.plugins.Format/plugin.js");
	add_js (BASE_URI . "/contrib/aloha/plugins/com.gentics.aloha.plugins.Link/LinkList.js");
	add_js (BASE_URI . "/contrib/aloha/plugins/com.gentics.aloha.plugins.Link/delicious.js");
	add_js (BASE_URI . "/contrib/aloha/plugins/com.gentics.aloha.plugins.Link/plugin.js");
	add_js (BASE_URI . "/contrib/aloha/plugins/com.gentics.aloha.plugins.LinkChecker/plugin.js");
	add_js (BASE_URI . "/contrib/aloha/plugins/com.gentics.aloha.plugins.List/plugin.js");
	add_js (BASE_URI . "/contrib/aloha/plugins/com.gentics.aloha.plugins.Paste/plugin.js");
	add_js (BASE_URI . "/contrib/aloha/plugins/com.gentics.aloha.plugins.Paste/wordpastehandler.js");
	add_js (BASE_URI . "/contrib/aloha/plugins/com.gentics.aloha.plugins.TOC/plugin.js");
	add_js (BASE_URI . "/contrib/aloha/plugins/com.gentics.aloha.plugins.Table/plugin.js");

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
		global $directory, $pagecache;

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
