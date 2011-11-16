<?php
/*
Plugin Name: iSimpleDesign Amazon S3 HTML Music Playlist Plugin
Plugin URI: http://http://www.isimpledesign.co.uk/
Description: Link your s3 bucket to sidebar custom css styling, m4a support i.e firefox chrome safari.
Version: 1.0
Author: Samuel East
Author URI: http://www.isimpledesign.co.uk/wordpress-plugins
License: GPL2
*/ 

class S3Player_Widget extends WP_Widget {

	
public function __construct() {
	
	parent::WP_Widget( /* Base ID */'s3player_widget', /* Name */'Amazon S3 Player', array( 'description' => 'iSimpleDesign Amazon S3 Player' ) );
	
	if (!class_exists('S3'))require_once("includes/S3.php"); 
	
	// Some Defaults
	$s3key					= '';
	$s3secretkey			= '';
	$s3bucket			    = '';
	$s3css			    = 'div.jp-audio, div.jp-video {
	font-size:1em; 
	font-family:Verdana, Arial, sans-serif;
	line-height:1.6;
	color: #fff;
	border-top:1px solid #554461;
	border-left:1px solid #554461;
	border-right:1px solid #180a1f;
	border-bottom:1px solid #180a1f;
	background-color:#000;
	position:relative;
border-radius: 20px;
}
div.jp-audio {
	width:201px;
	padding:20px;
}
div.jp-video-270p {
	width:480px;
}
div.jp-video-360p {
	width:640px;
}
div.jp-video-full {
	width:480px;
	height:270px;
	position:static !important;
	position:relative
}
div.jp-video-full div.jp-jplayer {
	top: 0;
	left: 0;
	position: fixed !important;
	position: relative; 
	overflow: hidden;
	z-index:1000;
}
div.jp-video-full div.jp-gui {
	position: fixed !important;
	position: static; 
	top: 0;
	left: 0;
	width:100%;
	height:100%;
	z-index:1000;
}
div.jp-video-full div.jp-interface {
	position: absolute !important;
	position: relative; 
	bottom: 0;
	left: 0;
	z-index:1000;
}
div.jp-interface {
	position: relative;
	width:100%;
	background-color:#000; 
}
div.jp-audio .jp-interface {
	height: 80px;
	padding-top:30px;
}

div.jp-controls-holder {
	clear: both;
	width:440px;
	margin:0 auto 10px auto;
	position: relative;
	overflow:hidden;
}
div.jp-interface ul.jp-controls {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") 0 0 no-repeat;
	list-style-type:none;
	padding: 1px 0 2px 1px;
	overflow:hidden;
	width: 201px;
	height: 34px;
}
div.jp-audio ul.jp-controls {
	margin:0 auto;
}
div.jp-video ul.jp-controls {
	margin:0 0 0 115px;
	float:left;
	display:inline; 
}
div.jp-interface ul.jp-controls li {
	display:inline;
	float: left;
}
div.jp-interface ul.jp-controls a {
	display:block;
	overflow:hidden;
	text-indent:-9999px;
	height: 34px;
	margin: 0 1px 2px 0;
	padding: 0;
}

div.jp-type-single .jp-controls li a {
	width: 99px;
}
div.jp-type-single .jp-play {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") 0px -40px no-repeat;
}
div.jp-type-single .jp-play:hover {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -100px -40px no-repeat;
}
div.jp-type-single .jp-pause {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") 0px -120px no-repeat;
}
div.jp-type-single .jp-pause:hover {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -100px -120px no-repeat;
}
div.jp-type-single .jp-stop {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") 0px -80px no-repeat;
}
div.jp-type-single .jp-stop:hover {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -100px -80px no-repeat;
}

div.jp-type-playlist .jp-controls li a {
	width: 49px;
}
div.jp-type-playlist .jp-play {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -24px -40px no-repeat;
}
div.jp-type-playlist .jp-play:hover {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -124px -40px no-repeat;
}
div.jp-type-playlist .jp-pause {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -24px -120px no-repeat;
}
div.jp-type-playlist .jp-pause:hover {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -124px -120px no-repeat;
}
div.jp-type-playlist .jp-stop {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -24px -80px no-repeat;
}
div.jp-type-playlist .jp-stop:hover {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -124px -80px no-repeat;
}
div.jp-type-playlist .jp-previous {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -24px -200px no-repeat;
}
div.jp-type-playlist .jp-previous:hover {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -124px -200px no-repeat;
}
div.jp-type-playlist .jp-next {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -24px -160px no-repeat;
}
div.jp-type-playlist .jp-next:hover {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -124px -160px no-repeat;
}

ul.jp-toggles {
	list-style-type:none;
	padding:0;
	margin:0 auto;
	z-index:20;
	overflow:hidden;
}
div.jp-audio ul.jp-toggles {
	width:55px;
}
div.jp-audio .jp-type-single ul.jp-toggles {
	width:25px;
}
div.jp-video ul.jp-toggles {
	width:100px;
	margin-top: 10px;
}
ul.jp-toggles li {
	display:block;
	float:right;
}
ul.jp-toggles li a {
	display:block;
	width:25px;
	height:18px;
	text-indent:-9999px;
	line-height:100%; /* need this for IE6 */
}
.jp-full-screen {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") 0 -420px no-repeat;
	margin-left: 20px;
}
.jp-full-screen:hover {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -30px -420px no-repeat;
}
.jp-restore-screen {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -60px -420px no-repeat;
	margin-left: 20px;
}
.jp-restore-screen:hover {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -90px -420px no-repeat;
}
.jp-repeat {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") 0 -440px no-repeat;
}
.jp-repeat:hover {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -30px -440px no-repeat;
}
.jp-repeat-off {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -60px -440px no-repeat;
}
.jp-repeat-off:hover {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -90px -440px no-repeat;
}
.jp-shuffle {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") 0 -460px no-repeat;
	margin-left: 5px;
}
.jp-shuffle:hover {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -30px -460px no-repeat;
}
.jp-shuffle-off {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -60px -460px no-repeat;
	margin-left: 5px;
}
.jp-shuffle-off:hover {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -90px -460px no-repeat;
}

div.jp-seeking-bg {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.seeking.gif");
}
.jp-progress {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") 0px -240px no-repeat;
	width: 197px;
	height: 13px;
	padding: 0 2px 2px 2px;
	margin-bottom: 4px;
	overflow:hidden;
}
div.jp-video .jp-progress {
	border-top:1px solid #180a1f;
	border-bottom: 1px solid #554560;
	width:100%;
	background-image: none;
	padding: 0;
}
.jp-seek-bar {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") 0px -260px repeat-x;
	width:0px;
	height: 100%;
	overflow:hidden;
	cursor:pointer;
}
.jp-play-bar {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") 0px -280px repeat-x;
	width:0px;
	height: 100%;
	overflow:hidden;
}

div.jp-interface ul.jp-controls a.jp-mute, div.jp-interface ul.jp-controls a.jp-unmute, div.jp-interface ul.jp-controls a.jp-volume-max {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") 0px -330px no-repeat;
	position: absolute;
	width: 16px;
	height: 11px;
}
div.jp-audio ul.jp-controls a.jp-mute, div.jp-audio ul.jp-controls a.jp-unmute {
	top:-6px;
	left: 0;
}
div.jp-audio ul.jp-controls a.jp-volume-max {
	top:-6px;
	right: 0;
}
div.jp-video ul.jp-controls a.jp-mute, div.jp-video ul.jp-controls a.jp-unmute {
	left: 0;
	top:14px;
}
div.jp-video ul.jp-controls a.jp-volume-max {
	left: 84px;
	top:14px;
}
div.jp-interface ul.jp-controls a.jp-mute:hover {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -25px -330px no-repeat;
}
div.jp-interface ul.jp-controls a.jp-unmute {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -60px -330px no-repeat;
}
div.jp-interface ul.jp-controls a.jp-unmute:hover {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -85px -330px no-repeat;
}
div.jp-interface ul.jp-controls a.jp-volume-max {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") 0px -350px no-repeat;
}
div.jp-interface ul.jp-controls a.jp-volume-max:hover {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -25px -350px no-repeat;
}
.jp-volume-bar {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") 0px -300px repeat-x;
	position: absolute;
	width: 197px;
	height: 4px;
	padding: 2px 2px 1px 2px;
	overflow: hidden;
}
.jp-volume-bar:hover {
	cursor:  pointer;
}
div.jp-audio .jp-interface .jp-volume-bar {
	top:10px;
	left: 0;
}
div.jp-video .jp-volume-bar {
	top: 0;
	left: 0;
	width:95px;
	border-right:1px solid #000;
	margin-top: 30px;
}
.jp-volume-bar-value {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") 0px -320px repeat-x;
	height: 4px;
}

.jp-current-time, .jp-duration {
	width:70px;
	font-size:.5em;
	color: #8c7a99;
}
.jp-current-time {
	float: left;
}
.jp-duration {
	float: right;
	text-align:right;
}
.jp-video .jp-current-time {
	padding-left:20px;
}
.jp-video .jp-duration {
	padding-right:20px;
}

.jp-title ul, .jp-playlist ul {
	list-style-type:none;
	font-size:.7em;
	margin: 0;
	padding: 0;
}
.jp-video .jp-title ul {
	margin: 0 20px 10px;
}
.jp-video .jp-playlist ul {
	margin: 0 20px;
}
.jp-title li, .jp-playlist li {
	position: relative;
	padding: 2px 0;
	border-top:1px solid #554461;
	border-bottom:1px solid #180a1f;
	overflow: hidden;
	margin:0px;
font-size:8px !important;
}
.jp-title li {
	border-bottom:none;
	border-top:none;
	padding:0;
	text-align:center;
}
/* Note that the first-child (IE6) and last-child (IE6/7/8) selectors do not work on IE */

div.jp-type-playlist div.jp-playlist li:first-child {
	border-top:none;
	padding-top:3px;
}
div.jp-type-playlist div.jp-playlist li:last-child {
	border-bottom:none;
	padding-bottom:3px;
}
div.jp-type-playlist div.jp-playlist a {
	color: #fff;
	text-decoration:none;
}
div.jp-type-playlist div.jp-playlist a:hover {
	color: #e892e9;
}
div.jp-type-playlist div.jp-playlist li.jp-playlist-current {
	background-color: #26102e;
	margin: 0 -20px;
	padding: 2px 20px;
	border-top: 1px solid #26102e;
	border-bottom: 1px solid #26102e;
}
div.jp-type-playlist div.jp-playlist li.jp-playlist-current a {
	color: #e892e9;
}
div.jp-type-playlist div.jp-playlist a.jp-playlist-item-remove {
	float:right;
	display:inline;
	text-align:right;
	margin-left:10px;
	font-weight:bold;
	color:#8C7A99;
}
div.jp-type-playlist div.jp-playlist a.jp-playlist-item-remove:hover {
	color:#E892E9;
}
div.jp-type-playlist div.jp-playlist span.jp-free-media {
	float: right;
	display:inline;
	text-align:right;
	color:#8C7A99;
}
div.jp-type-playlist div.jp-playlist span.jp-free-media a {
	color:#8C7A99;
}
div.jp-type-playlist div.jp-playlist span.jp-free-media a:hover {
	color:#E892E9;
}
span.jp-artist {
	font-size:.8em;
	color:#8C7A99;
}
/* @end */


div.jp-video div.jp-video-play {
	position:absolute;
	top:0;
	left:0;
	width:100%;
	cursor:pointer;
	background-color:rgba(0, 0, 0, 0); /* Makes IE9 work with the active area over the whole video area. IE6/7/8 only have the button as active area. */
}
div.jp-video-270p div.jp-video-play {
	height:270px;
}
div.jp-video-360p div.jp-video-play {
	height:360px;
}
div.jp-video-full div.jp-video-play {
	height:100%;
	z-index:1000;
}
a.jp-video-play-icon {
	position:relative;
	display:block;
	width: 112px;
	height: 100px;
	margin-left:-56px;
	margin-top:-50px;
	left:50%;
	top:50%;
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.video.play.png") 0 0 no-repeat;
	text-indent:-9999px;
}
div.jp-video-play:hover a.jp-video-play-icon {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.video.play.png") 0 -100px no-repeat;
}
div.jp-jplayer audio, div.jp-jplayer {
	width:0px;
	height:0px;
}
div.jp-jplayer {
	background-color: #000000;
}
/* @group NO SOLUTION error feedback */

.jp-no-solution {
	position:absolute;
	width:390px;
	margin-left:-202px;
	left:50%;
	top: 10px;
	padding:5px;
	font-size:.8em;
	background-color:#3a2a45;
	border-top:2px solid #554461;
	border-left:2px solid #554461;
	border-right:2px solid #180a1f;
	border-bottom:2px solid #180a1f;
	color:#FFF;
	display:none;
}
.jp-no-solution a {
	color:#FFF;
}
.jp-no-solution span {
	font-size:1em;
	display:block;
	text-align:center;
	font-weight:bold;
}
.jp-audio .jp-no-solution {
	width:190px;
	margin-left:-102px;
}

/* @end */
';
	
	
	
	// Put our defaults in the "wp-options" table
	add_option("s3key", $s3key);
	add_option("s3secretkey", $s3secretkey);
	add_option("s3bucket", $s3bucket);
	add_option("s3css", $s3css);
	
	// Set Plugin Path 
	$this->pluginPath = dirname(__FILE__); 
		
	// Set Plugin URL 
	$this->pluginUrl = WP_PLUGIN_URL . '/isimpledesign-s3player';
	
		
	//add_shortcode('ISDHtml5Player', array($this, 'isdHtml5Player'));
	add_action('admin_menu', array($this, 'cplayerAdminMenu'));
	add_action('wp_head',array($this, 'cplayerScripts'));	
	
}

private function s3buckets(){
	
	 $s3 = new S3( get_option("s3key"), get_option("s3secretkey"));
	
	echo "<select name='s3bucket'>";
	echo "<option value='" . get_option("s3bucket") . "'>" . get_option("s3bucket") . "</option>";
	foreach($s3->listBuckets() as $v){
		
		echo "<option value='" . $v . "'>" . $v . "</option>";
		
	}
	echo "</select>";
	
}

/**
* Adds Script file for plugin
*
* @param Place hooks into wordpress wp_head
* @param integer $repeat How many times something interesting should happen
* @return Status echo
*/ 
public function cplayerScripts() {
    
    echo "<style type='text/css'>".html_entity_decode(stripslashes(stripslashes(get_option("s3css"))))."</style>";
	
	if(!get_option("jquery")){
		echo '<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"><script>';
	}
	// add js scripts
	$scripts = array('jquery.jplayer.min.js','jplayer.playlist.min.js','jquery.jplayer.inspector.js');
	
	foreach($scripts as $v){
		
		echo '<script type="text/javascript" src="'.$this->pluginUrl."/js/" . $v. '"></script>';
		
	}
	
} 
/**
* Adds Script file for plugin
*
* @param Place hooks into wordpress wp_head
* @param integer $repeat How many times something interesting should happen
* @return Status echo
*/ 
public function cplayerAdminMenu() {	
	$icon_url = "http://tcpc.ipbhost.com/public/style_extra/mime_types/music.gif";
	add_menu_page( 'ISD S3 Player', 'ISD S3 Player', 10, 'ismpledesign-s3player', array($this, 'cplayerAdmin'), $icon_url );
}
/**
* Admin page on the wordpress site used in dashboard
*
* @param Place hooks into wordpress with add_action
* @return Status return
*/ 
public function cplayerAdmin() {	
	if ( isset($_POST['submit']) ) {
	$nonce = $_REQUEST['_wpnonce'];
	if (! wp_verify_nonce($nonce, 'cplayer-updatesettings') ) die('Security check failed'); 
	if (!current_user_can('manage_options')) die(__('You cannot edit the search-by-category options.'));
	check_admin_referer('cplayer-updatesettings');	
	
	$s3key	        = $_POST['s3key'];
	$s3secretkey	= $_POST['s3secretkey'];
	$s3bucket	= $_POST['s3bucket'];
	$s3css	= $_POST['s3css'];
	$s3autoplay	= $_POST['s3autoplay'];
	$jquery	= $_POST['jquery'];
	$reset	= $_POST['reset'];
	
	// Provides: Hll Wrld f PHP
	$disallow = array(">", "<", "?");
	$allowed = str_replace($disallow, "Please dont try enter < > ?", $s3css);
	
	// Update the DB with the new option values
	update_option("s3key", mysql_real_escape_string($s3key));
	update_option("s3secretkey", mysql_real_escape_string($s3secretkey));
	update_option("s3bucket", mysql_real_escape_string($s3bucket));
	update_option("s3autoplay", mysql_real_escape_string($s3autoplay));
	update_option("jquery", mysql_real_escape_string($jquery));
	
	if($reset == 'yes'){ 
	
	$s3cssReset			    = 'div.jp-audio, div.jp-video {
	font-size:1em; 
	font-family:Verdana, Arial, sans-serif;
	line-height:1.6;
	color: #fff;
	border-top:1px solid #554461;
	border-left:1px solid #554461;
	border-right:1px solid #180a1f;
	border-bottom:1px solid #180a1f;
	background-color:#000;
	position:relative;
border-radius: 20px;
}
div.jp-audio {
	width:201px;
	padding:20px;
}
div.jp-video-270p {
	width:480px;
}
div.jp-video-360p {
	width:640px;
}
div.jp-video-full {
	width:480px;
	height:270px;
	position:static !important;
	position:relative
}
div.jp-video-full div.jp-jplayer {
	top: 0;
	left: 0;
	position: fixed !important;
	position: relative; 
	overflow: hidden;
	z-index:1000;
}
div.jp-video-full div.jp-gui {
	position: fixed !important;
	position: static; 
	top: 0;
	left: 0;
	width:100%;
	height:100%;
	z-index:1000;
}
div.jp-video-full div.jp-interface {
	position: absolute !important;
	position: relative; 
	bottom: 0;
	left: 0;
	z-index:1000;
}
div.jp-interface {
	position: relative;
	width:100%;
	background-color:#000; 
}
div.jp-audio .jp-interface {
	height: 80px;
	padding-top:30px;
}

div.jp-controls-holder {
	clear: both;
	width:440px;
	margin:0 auto 10px auto;
	position: relative;
	overflow:hidden;
}
div.jp-interface ul.jp-controls {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") 0 0 no-repeat;
	list-style-type:none;
	padding: 1px 0 2px 1px;
	overflow:hidden;
	width: 201px;
	height: 34px;
}
div.jp-audio ul.jp-controls {
	margin:0 auto;
}
div.jp-video ul.jp-controls {
	margin:0 0 0 115px;
	float:left;
	display:inline; 
}
div.jp-interface ul.jp-controls li {
	display:inline;
	float: left;
}
div.jp-interface ul.jp-controls a {
	display:block;
	overflow:hidden;
	text-indent:-9999px;
	height: 34px;
	margin: 0 1px 2px 0;
	padding: 0;
}

div.jp-type-single .jp-controls li a {
	width: 99px;
}
div.jp-type-single .jp-play {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") 0px -40px no-repeat;
}
div.jp-type-single .jp-play:hover {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -100px -40px no-repeat;
}
div.jp-type-single .jp-pause {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") 0px -120px no-repeat;
}
div.jp-type-single .jp-pause:hover {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -100px -120px no-repeat;
}
div.jp-type-single .jp-stop {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") 0px -80px no-repeat;
}
div.jp-type-single .jp-stop:hover {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -100px -80px no-repeat;
}

div.jp-type-playlist .jp-controls li a {
	width: 49px;
}
div.jp-type-playlist .jp-play {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -24px -40px no-repeat;
}
div.jp-type-playlist .jp-play:hover {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -124px -40px no-repeat;
}
div.jp-type-playlist .jp-pause {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -24px -120px no-repeat;
}
div.jp-type-playlist .jp-pause:hover {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -124px -120px no-repeat;
}
div.jp-type-playlist .jp-stop {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -24px -80px no-repeat;
}
div.jp-type-playlist .jp-stop:hover {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -124px -80px no-repeat;
}
div.jp-type-playlist .jp-previous {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -24px -200px no-repeat;
}
div.jp-type-playlist .jp-previous:hover {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -124px -200px no-repeat;
}
div.jp-type-playlist .jp-next {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -24px -160px no-repeat;
}
div.jp-type-playlist .jp-next:hover {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -124px -160px no-repeat;
}

ul.jp-toggles {
	list-style-type:none;
	padding:0;
	margin:0 auto;
	z-index:20;
	overflow:hidden;
}
div.jp-audio ul.jp-toggles {
	width:55px;
}
div.jp-audio .jp-type-single ul.jp-toggles {
	width:25px;
}
div.jp-video ul.jp-toggles {
	width:100px;
	margin-top: 10px;
}
ul.jp-toggles li {
	display:block;
	float:right;
}
ul.jp-toggles li a {
	display:block;
	width:25px;
	height:18px;
	text-indent:-9999px;
	line-height:100%; /* need this for IE6 */
}
.jp-full-screen {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") 0 -420px no-repeat;
	margin-left: 20px;
}
.jp-full-screen:hover {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -30px -420px no-repeat;
}
.jp-restore-screen {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -60px -420px no-repeat;
	margin-left: 20px;
}
.jp-restore-screen:hover {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -90px -420px no-repeat;
}
.jp-repeat {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") 0 -440px no-repeat;
}
.jp-repeat:hover {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -30px -440px no-repeat;
}
.jp-repeat-off {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -60px -440px no-repeat;
}
.jp-repeat-off:hover {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -90px -440px no-repeat;
}
.jp-shuffle {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") 0 -460px no-repeat;
	margin-left: 5px;
}
.jp-shuffle:hover {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -30px -460px no-repeat;
}
.jp-shuffle-off {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -60px -460px no-repeat;
	margin-left: 5px;
}
.jp-shuffle-off:hover {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -90px -460px no-repeat;
}

div.jp-seeking-bg {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.seeking.gif");
}
.jp-progress {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") 0px -240px no-repeat;
	width: 197px;
	height: 13px;
	padding: 0 2px 2px 2px;
	margin-bottom: 4px;
	overflow:hidden;
}
div.jp-video .jp-progress {
	border-top:1px solid #180a1f;
	border-bottom: 1px solid #554560;
	width:100%;
	background-image: none;
	padding: 0;
}
.jp-seek-bar {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") 0px -260px repeat-x;
	width:0px;
	height: 100%;
	overflow:hidden;
	cursor:pointer;
}
.jp-play-bar {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") 0px -280px repeat-x;
	width:0px;
	height: 100%;
	overflow:hidden;
}

div.jp-interface ul.jp-controls a.jp-mute, div.jp-interface ul.jp-controls a.jp-unmute, div.jp-interface ul.jp-controls a.jp-volume-max {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") 0px -330px no-repeat;
	position: absolute;
	width: 16px;
	height: 11px;
}
div.jp-audio ul.jp-controls a.jp-mute, div.jp-audio ul.jp-controls a.jp-unmute {
	top:-6px;
	left: 0;
}
div.jp-audio ul.jp-controls a.jp-volume-max {
	top:-6px;
	right: 0;
}
div.jp-video ul.jp-controls a.jp-mute, div.jp-video ul.jp-controls a.jp-unmute {
	left: 0;
	top:14px;
}
div.jp-video ul.jp-controls a.jp-volume-max {
	left: 84px;
	top:14px;
}
div.jp-interface ul.jp-controls a.jp-mute:hover {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -25px -330px no-repeat;
}
div.jp-interface ul.jp-controls a.jp-unmute {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -60px -330px no-repeat;
}
div.jp-interface ul.jp-controls a.jp-unmute:hover {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -85px -330px no-repeat;
}
div.jp-interface ul.jp-controls a.jp-volume-max {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") 0px -350px no-repeat;
}
div.jp-interface ul.jp-controls a.jp-volume-max:hover {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") -25px -350px no-repeat;
}
.jp-volume-bar {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") 0px -300px repeat-x;
	position: absolute;
	width: 197px;
	height: 4px;
	padding: 2px 2px 1px 2px;
	overflow: hidden;
}
.jp-volume-bar:hover {
	cursor:  pointer;
}
div.jp-audio .jp-interface .jp-volume-bar {
	top:10px;
	left: 0;
}
div.jp-video .jp-volume-bar {
	top: 0;
	left: 0;
	width:95px;
	border-right:1px solid #000;
	margin-top: 30px;
}
.jp-volume-bar-value {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.jpg") 0px -320px repeat-x;
	height: 4px;
}

.jp-current-time, .jp-duration {
	width:70px;
	font-size:.5em;
	color: #8c7a99;
}
.jp-current-time {
	float: left;
}
.jp-duration {
	float: right;
	text-align:right;
}
.jp-video .jp-current-time {
	padding-left:20px;
}
.jp-video .jp-duration {
	padding-right:20px;
}

.jp-title ul, .jp-playlist ul {
	list-style-type:none;
	font-size:.7em;
	margin: 0;
	padding: 0;
}
.jp-video .jp-title ul {
	margin: 0 20px 10px;
}
.jp-video .jp-playlist ul {
	margin: 0 20px;
}
.jp-title li, .jp-playlist li {
	position: relative;
	padding: 2px 0;
	border-top:1px solid #554461;
	border-bottom:1px solid #180a1f;
	overflow: hidden;
	margin:0px;
font-size:8px !important;
}
.jp-title li {
	border-bottom:none;
	border-top:none;
	padding:0;
	text-align:center;
}
/* Note that the first-child (IE6) and last-child (IE6/7/8) selectors do not work on IE */

div.jp-type-playlist div.jp-playlist li:first-child {
	border-top:none;
	padding-top:3px;
}
div.jp-type-playlist div.jp-playlist li:last-child {
	border-bottom:none;
	padding-bottom:3px;
}
div.jp-type-playlist div.jp-playlist a {
	color: #fff;
	text-decoration:none;
}
div.jp-type-playlist div.jp-playlist a:hover {
	color: #e892e9;
}
div.jp-type-playlist div.jp-playlist li.jp-playlist-current {
	background-color: #26102e;
	margin: 0 -20px;
	padding: 2px 20px;
	border-top: 1px solid #26102e;
	border-bottom: 1px solid #26102e;
}
div.jp-type-playlist div.jp-playlist li.jp-playlist-current a {
	color: #e892e9;
}
div.jp-type-playlist div.jp-playlist a.jp-playlist-item-remove {
	float:right;
	display:inline;
	text-align:right;
	margin-left:10px;
	font-weight:bold;
	color:#8C7A99;
}
div.jp-type-playlist div.jp-playlist a.jp-playlist-item-remove:hover {
	color:#E892E9;
}
div.jp-type-playlist div.jp-playlist span.jp-free-media {
	float: right;
	display:inline;
	text-align:right;
	color:#8C7A99;
}
div.jp-type-playlist div.jp-playlist span.jp-free-media a {
	color:#8C7A99;
}
div.jp-type-playlist div.jp-playlist span.jp-free-media a:hover {
	color:#E892E9;
}
span.jp-artist {
	font-size:.8em;
	color:#8C7A99;
}
/* @end */


div.jp-video div.jp-video-play {
	position:absolute;
	top:0;
	left:0;
	width:100%;
	cursor:pointer;
	background-color:rgba(0, 0, 0, 0); /* Makes IE9 work with the active area over the whole video area. IE6/7/8 only have the button as active area. */
}
div.jp-video-270p div.jp-video-play {
	height:270px;
}
div.jp-video-360p div.jp-video-play {
	height:360px;
}
div.jp-video-full div.jp-video-play {
	height:100%;
	z-index:1000;
}
a.jp-video-play-icon {
	position:relative;
	display:block;
	width: 112px;
	height: 100px;
	margin-left:-56px;
	margin-top:-50px;
	left:50%;
	top:50%;
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.video.play.png") 0 0 no-repeat;
	text-indent:-9999px;
}
div.jp-video-play:hover a.jp-video-play-icon {
	background: url("'.get_bloginfo('url').'/wp-content/plugins/isimpledesign-s3player/css/jplayer.pink.flag.video.play.png") 0 -100px no-repeat;
}
div.jp-jplayer audio, div.jp-jplayer {
	width:0px;
	height:0px;
}
div.jp-jplayer {
	background-color: #000000;
}
/* @group NO SOLUTION error feedback */

.jp-no-solution {
	position:absolute;
	width:390px;
	margin-left:-202px;
	left:50%;
	top: 10px;
	padding:5px;
	font-size:.8em;
	background-color:#3a2a45;
	border-top:2px solid #554461;
	border-left:2px solid #554461;
	border-right:2px solid #180a1f;
	border-bottom:2px solid #180a1f;
	color:#FFF;
	display:none;
}
.jp-no-solution a {
	color:#FFF;
}
.jp-no-solution span {
	font-size:1em;
	display:block;
	text-align:center;
	font-weight:bold;
}
.jp-audio .jp-no-solution {
	width:190px;
	margin-left:-102px;
}

/* @end */
';

update_option("s3css", $s3cssReset);
	
	}else{
		
		update_option("s3css", $allowed);
	
	} 
	
}

	$s3key	= get_option("s3key");
    $s3secretkey	= get_option("s3secretkey");
	$s3bucket	= get_option("s3bucket");
	$s3css	= get_option("s3css");
	$s3autoplay	= get_option("s3autoplay");
?>
<div class="wrap">
<h2>Options</h2>
<form action="" method="post" id="isd-config">
  <table class="form-table">
    <?php if (function_exists('wp_nonce_field')) { wp_nonce_field('cplayer-updatesettings'); } ?>
    <tr>
      <th scope="row" valign="top"><label for="isdHtml5Ak">Amazon Key:</label></th>
      <td><input type="password" name="s3key" id="s3key" class="regular-text" value="<?php echo $s3key; ?>"/></td>
    </tr>
    <tr>
      <th scope="row" valign="top"><label for="isdHtml5ASk">Amazon Secret Key:</label></th>
      <td><input type="password" name="s3secretkey" id="s3secretkey" class="regular-text" value="<?php echo $s3secretkey; ?>"/></td>
    </tr>
    <tr>
      <th scope="row" valign="top"><label for="s3bucket">Your Amazon Bucket:</label></th>
      <td><?php $this->s3buckets(); ?></td>
    </tr>
     <tr>
      <th scope="row" valign="top"><label for="s3autoplay">Autoplay:</label></th>
      
      <td><input type="checkbox" value="yes" name="s3autoplay" <?php if($s3autoplay == 'yes'){ echo "checked='yes'";} ?>/></td>
    </tr>
    
     <tr>
      <th scope="row" valign="top"><label for="jquery">Remove Jquery:</label></th>
      
      <td><input type="checkbox" value="yes" name="jquery" <?php if($jquery == 'yes'){ echo "checked='yes'";} ?>/></td>
    </tr>
    
     <tr>
      <th scope="row" valign="top"><label for="reset">Reset CSS:</label></th>
      
      <td><input type="checkbox" value="yes" name="reset" /></td>
    </tr>
    
     <tr>
      <th scope="row" valign="top"><label for="s3css">Change Css:</label></th>
      <td><textarea name="s3css" rows="20" cols="50"><?php echo stripslashes(stripslashes($s3css)); ?></textarea></td>
    </tr>
  </table>
  <br/>
  <span class="submit" style="border: 0;">
  <input type="submit" name="submit" value="Save Settings" />
  </span>
</form>

<?php	

} 
/**
* Shortcode function
*
* @param Place called when shortcode is used within post page etc
* @return Status echo
*/ 
private function s3songs(){
	
	$s3 = new S3( get_option("s3key"), get_option("s3secretkey"));
	 
	if (($contents = $s3->getBucket(get_option("s3bucket"))) !== false) {
        foreach ($contents as $object) { 
		
		$name = basename($object['name']);
		$url = "http://".get_option("s3bucket").".s3.amazonaws.com/".urlencode($object['name']);
		
		if(preg_match("/\.m4a$/i", $url)) { 
		
		$songs .= '{title:"'.$name.'",m4a:"'.$url.'"},';
        
		}elseif(preg_match("/\.mp3$/i", $url)) { 
        
       $songs .= '{title:"'.$name.'",mp3:"'.$url.'"},';
        
		   }
            
        }
		
		$songs = rtrim($songs, ',');
		echo $songs;
    }
	
}
/**
* MAin function used to insert anywhere into template files via <?php googleLoginInsert(); ?>
*
* @param Place called when
<?php googleLoginInsert(); ?>
is used within theme
* @return Status return
*/ 
/** @see WP_Widget::widget */
function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title; ?>

<script type="text/javascript">
		//<![CDATA[ 
$.noConflict();
jQuery(document).ready(function(){
        new jPlayerPlaylist({ jPlayer: "#jquery_jplayer_1",cssSelectorAncestor: "#jp_container_1"}, [<?php $this->s3songs(); ?>], {
	      playlistOptions: {
		  autoPlay: <?php if(get_option("s3autoplay") == 'yes'){ echo "true";}else{echo "false";} ?>,
		  loopOnPrevious: false,
		  shuffleOnLoop: true,
		  enableRemoveControls: false,
		  displayTime: 'slow',
		  addTime: 'fast',
		  removeTime: 'fast',
		  shuffleTime: 'slow'
		},
		swfPath: "<?php bloginfo('url'); ?>/wp-content/plugins/isimpledesign-s3player/js/",
		solution:"flash,html",
		supplied: "oga, mp3, m4a",
		wmode: "window"
	});
	$("#jplayer_inspector_1").jPlayerInspector({
		jPlayer:$("#jquery_jplayer_1").jPlayer("play")
		});
});
//]]>
</script>
<div id="jquery_jplayer_1" class="jp-jplayer"></div><div id="jp_container_1" class="jp-audio"><div class="jp-type-playlist"><div class="jp-gui jp-interface"><ul class="jp-controls"><li><a href="javascript:;" class="jp-previous" tabindex="1">previous</a></li><li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li><li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li><li><a href="javascript:;" class="jp-next" tabindex="1">next</a></li><li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li><li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li><li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li><li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li></ul><div class="jp-progress"><div class="jp-seek-bar"><div class="jp-play-bar"></div></div></div><div class="jp-volume-bar"><div class="jp-volume-bar-value"></div></div><div class="jp-current-time"></div><div class="jp-duration"></div><ul class="jp-toggles"><li><a href="javascript:;" class="jp-shuffle" tabindex="1" title="shuffle">shuffle</a></li><li><a href="javascript:;" class="jp-shuffle-off" tabindex="1" title="shuffle off">shuffle off</a></li><li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li><li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a></li></ul></div><div class="jp-playlist"><ul><li></li></ul></div><div class="jp-no-solution"><span>Update Required</span>To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.</div></div></div>
<?php echo $after_widget;
	}
} // End Class


// register Foo_Widget widget
add_action( 'widgets_init', create_function( '', 'register_widget("S3Player_Widget");' ) );