<?php

/**
Plugin Name: Post Views for WP
Description: Post Views for WP will allow you to unveil how many number of times a post or page had been viewed. It is quite easy to use as it has only one step to Set it up and running.
Author: uniqe-coder
Version: 1.0.1
Author URI: https://graspers.000webhostapp.com/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: postviews-for-wp
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

define('POSTVIEWS_FOR_WP_VERSION','1.0.1');
define('POSTVIEWS_FOR_WP_PLUGIN_URI', plugin_dir_url(__FILE__));
define('POSTVIEWS_FOR_WP_PLUGIN_DIR', plugin_dir_path( __DIR__ ) );
define('POSTVIEWS_FOR_WP_BASENAME',plugin_basename(__FILE__));

require_once plugin_dir_path( __DIR__ ).'postviews-for-wp/admin/postviews-admin-settings.php';

function setter_PostViews($postID) {
    $user_ip = $_SERVER['REMOTE_ADDR']; //retrieve the current IP address of the visitor
    $key = $user_ip . 'x' . $postID;
    $value = array($user_ip, $postID);
    $visited = get_transient($key);
    global $post, $options;	
	$options = get_option( 'pv_forwp_settings' );
	$selected_type = array();
			$count_key = 'post_views_count';
        global $count, $k;
         $k = '1';
    $count = get_post_meta($postID, $count_key, true);
    if(!isset($options['post_v_forwp_field_IP_Filter'])) 
            {
                $options['post_v_forwp_field_IP_Filter'] = '';
            }
   if ( $options['post_v_forwp_field_IP_Filter'] == 0 ) {

	$count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    $pv_forwp_html = '<div class="pv_for_wp_view">';
    $pv_forwp_htmlend = '</div>';
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
    return $pv_forwp_html.' Post Views: '.$count.$pv_forwp_htmlend;
}

    
    elseif( $options['post_v_forwp_field_IP_Filter'] == 1){
    		
    	$count = get_post_meta($postID, $count_key, true);
    	$t = 0;
    	if ($t==0) {
    		$t++;
    	}
    	if( $t>=1 && $options['post_v_forwp_field_IP_Filter'] == 1 ){
		
    	$user_ip = '192.68.1.1';
    
    $key = $user_ip . 'x' . $postID;
    
    $value = array($user_ip, $postID);
    
    $visited = get_transient($key);
    
    global $post, $options;	
	$options = get_option( 'pv_forwp_settings' );
		
	$selected_type = array();
			$count_key = 'post_views_count';
        global $count, $k;
         $k = '1';
    $count = get_post_meta($postID, $count_key, true);
    	
    		
		
    		if ( false === ( $visited ) ) {
    		//store the unique key, Post ID & IP address for 12 hours if it does not exist
    			$pv_forwp_opt = get_option( 'pv_forwp_settings' );
	    		$textbox_val = $pv_forwp_opt['post_v_forwp_field_IP_Timer'];
    			set_transient( $key, $value, 60*60*$textbox_val );
    			// now run post views function
    			$count_key = 'post_views_count';
        global $count, $k;
         $k = '1';
    $count = get_post_meta($postID, $count_key, true);
    $pv_forwp_html = '<div class="pv_for_wp_view">';
    $pv_forwp_htmlend = '</div>';
    if($count==''){
    	   $k = '1';
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
    	   $k = '1';
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
    return $pv_forwp_html.' Post Views: '.$count.$pv_forwp_htmlend;

    }
}
       
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    $pv_forwp_html = '<div class="pv_for_wp_view">';
    $pv_forwp_htmlend = '</div>';
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }elseif($count<1){
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
    return $pv_forwp_html.' Post Views: '.$count.$pv_forwp_htmlend;
}



}

// Remove issues with prefetching adding extra views
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
//above the content

add_action( 'wp', 'PostViews_for_wp_render_out' );
function PostViews_for_wp_render_out() {
    $postviewssettings = get_option( 'pv_forwp_settings' );
    		if(isset($postviewssettings['post_v_forwp_field_posttypes'])){
    				$internal_settings  = $postviewssettings['post_v_forwp_field_posttypes'];
        				$support_array = array();
      		foreach ($internal_settings as $key => $value) {		
        		$support_array[] = $key;
        	}
        	if(!empty($support_array) && is_singular($support_array)){
        		add_filter('the_content','post_views_for_wp_above_the_content');
        	}
        }
    }
//add_filter('the_content','post_views_for_wp_above_the_content');
function post_views_for_wp_above_the_content($the_content){
	if( function_exists('setter_PostViews') ){
	echo setter_PostViews(get_the_ID());
}
	return $the_content;
}


//below content
//add_filter('the_content', 'post_views_for_wp_below_the_content');
function post_views_for_wp_below_the_content( $content ) {
	if( function_exists('setter_PostViews') ){

    if( /*is_single() && */! empty( $GLOBALS['post'] ) ) {

        if ( $GLOBALS['post']->ID == get_the_ID() ) {
        	$appender =  setter_PostViews(get_the_ID());
            $content .=  $appender;

        }

    }
}

    return $content;
}


add_shortcode('post_viewsfwp', 'postviews_for_wp_shortcode');
function postviews_for_wp_shortcode(){ 
    //$PostViews_for_wp_render_value = PostViews_for_wp_render_out();
    //if($PostViews_for_wp_render_value ){
    if( function_exists('setter_PostViews') ){
    echo setter_PostViews(get_the_ID());
}
//}
}