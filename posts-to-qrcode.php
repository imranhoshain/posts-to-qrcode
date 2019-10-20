<?php
/*

Plugin Name: Posts To QRcode
Plugin URI: https://nurictworld.com/plugin/post-to-qrcode
Discription: Post url to qr code ganarate
Version: 1.0
Author: Imran Hoshain
Author URI: https://facebook.com/iforuimran
License: GPLv2 or later
Text Domain: posts-to-qrcode
Domain Path: /languages/

*/

/*function pqrc_activation_hook(){}
register_activation_hook(__FILE__,"pqrc_activation_hook");

function pqrc_deactivation_hook(){}
register_deactivation_hook(__FILE__,"pqrc_deactivation_hook");*/

function pqrc_load_textdomain(){
	load_plugin_textdomain('posts-to-qrcode', false, dirname(__FILE__)."/languages");
}

function pqrc_display_qr_code($content){
	$current_post_id = get_the_Id();
	$current_post_title = get_the_title();
	$current_post_url = urlencode(get_the_permalink($current_post_id));
	$current_post_type = get_post_type($current_post_id);

	//Post Type Check
	$excluded_post_types = apply_filters('pqrc_excluded_post_types',array());
	var_dump($current_post_type);
	if(in_array($current_post_type, $excluded_post_types)){
		return $content;
	}
	
	//Image Dimention
	$dimention = apply_filters( 'pqrc_qrcode_dimantion', '150x150' );	
	
	//Image Attribuites
	$image_attribuites = apply_filters( 'pqrc_qrcode_attribuites', null );

	$image_src = sprintf('https://api.qrserver.com/v1/create-qr-code/?size=%s&data=%s', $dimention, $current_post_url);
	$content .= sprintf("<img %s src='%s' alt='%s' />", $image_attribuites, $image_src, $current_post_title);
	return $content;

} 
add_filter('the_content', 'pqrc_display_qr_code');