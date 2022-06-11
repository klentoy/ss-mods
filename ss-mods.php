<?php
/*
Plugin Name: SS-Mods
Plugin URI: http://shipwreckstudio.com
Description: Shipwreck Studio mods - started 12/11/15 - Last mod 22/2/19 - Agency mods for all client sites
Version: 1.0.0
Author: Rick Moore
Author URI: http://shipwreckstudio.com
Plugin Type: Agency
License: GPL2
*/
/*---Register style sheet---*/
add_action( 'wp_enqueue_scripts', 'register_plugin_styles' );
function register_plugin_styles() {
    wp_register_style( 'ss-mods', plugins_url( 'ss-mods/css/ss-mods.css' ) );
    wp_enqueue_style( 'ss-mods' );
    //wp_enqueue_style( 'dashicons' ); //make the WP dash icons available on the front end
}
/*------*/
/*---Includes---*/
include( plugin_dir_path( __FILE__ ) . 'inc/ss-mods-functions.php');
include( plugin_dir_path( __FILE__ ) . 'inc/ss-mods-shortcodes.php');
include( plugin_dir_path( __FILE__ ) . 'inc/ss-mods-whitelabel.php');
include( plugin_dir_path( __FILE__ ) . 'inc/ss-mods-security.php');
include( plugin_dir_path( __FILE__ ) . 'inc/loginaddress.php');
include( plugin_dir_path( __FILE__ ) . 'admin/ssmods-options.php');
include( plugin_dir_path( __FILE__ ) . 'inc/ss-mods-update.php');
/*------*/

/*---additional code from ubermenu for integration with toolset bootstrap theme---*/
//add_action( 'init' , 'toolset_child_stop_removing_menu_container' );
//function toolset_child_stop_removing_menu_container(){
//	remove_filter('wp_nav_menu_args', 'wpbootstrap_nav_menu_defaults');
//}
/*--------------*/
/*---SECURITY---*/
/*--------------*/
/*---SEC: hide error msgs that give away login attempt stuff---*/
	add_filter('login_errors', 'ss_no_login_errors');
/*---SEC: Set custom login time (default 2 weeks)---*/
	add_filter('auth_cookie_expiration', 'ss_custom_login_time');
/*---SEC: Suppress error msgs for everyone except administrator---*/
	add_action('admin_head', 'ss_hide_error_messages');
/*---SEC local: Disable XML-RPC---*/
	add_filter('xmlrpc_enabled', '__return_false');
/*-----------------*/
/*---WHITE LABEL---*/
/*-----------------*/
/*---WL: Logo and other CSS mods to login page---*/
	add_action('login_enqueue_scripts', 'ss_custom_login_page');
/*---WL: Suppress some admin menu items for everyone except administrator---*/
	add_action('admin_head', 'ss_hide_admin_menu_items');
/*---WL: Custom Admin Dashboard Logo---*/
	add_action('wp_before_admin_bar_render', 'ss_replace_wp_logo_in_admin_bar', 0);
/*---WL: Custom Dashboard Widget---*/
	add_action('wp_dashboard_setup', 'ss_dashboard_widgets');
/*---WL: Admin - Remove Administrators from user list---*/
 	add_action('pre_user_query','ss_pre_user_query');
/*---WL: Remove drop menu from the old wordpress logo admin spot top left---*/
	add_action('admin_bar_menu', 'ss_remove_credits_menu_items',999);
/*---WL: Change footer in admin panel---*/
	add_filter('admin_footer_text', 'ss_remove_footer_admin');
/*---WL: disable default dashboard widgets---*/
	add_action('admin_menu', 'ss_disable_default_dashboard_widgets');
/*---WL: Swap out the Howdy greeting for something else---*/
	add_filter('gettext', 'ss_change_howdy', 10, 3);
/*---WL local: Remove admin bar from front-end for logged in users---*/
	add_filter('show_admin_bar', '__return_false');
/*------*/
/*------*/
/*------*/
/*------*/
/*--- Remove wordpress version number and a bunch of wordpress meta ---*/
	  function ss_remove_version() {
	  return '';
	  }
	  add_filter('the_generator', 'ss_remove_version');
	  remove_action( 'wp_head', 'wp_generator' ) ;
	  remove_action( 'wp_head', 'wlwmanifest_link' ) ;
	  remove_action( 'wp_head', 'rsd_link' ) ;
	  remove_action( 'welcome_panel', 'wp_welcome_panel' ); //Dump the wordpress welcome panel
/*--- Hide non-essential RSS feeds ---*/
	  remove_action( 'wp_head', 'feed_links', 2 );
	  remove_action( 'wp_head', 'feed_links_extra', 3 );
/*------*/
/*---------------*/
/*---FUNCTIONS---*/
/*---------------*/
/*---FUN: Change excerpt length if required - default is 55 words---*/
	add_filter('excerpt_length', 'ss_custom_excerpt_length');
/*---FUN: Automated Beaver Builder content edit button for front end---*/
	add_filter ('the_content', 'ss_bb_edit_btn');
/*---Limit post revisions---*/
	define( 'WP_POST_REVISIONS', 5);
/*---Push post edit autosaving back to 2 minutes (default 1)---*/
	define( 'AUTOSAVE_INTERVAL', 120 );
// Function that includes the path to admin favicon   **** CHECK ME - not working?
function add_favicon() {
  	$favicon_url = get_stylesheet_directory_uri() . '/images/icons/admin-favicon.ico';
	echo '<link rel="shortcut icon" href="' . $favicon_url . '" />';
}
// Make sure function runs when you're on the login page and admin pages  
add_action('login_head', 'add_favicon');
add_action('admin_head', 'add_favicon');
/*------*/
/*------*/
/*---Change the default Gravater---*/
//     http://www.wpbeginner.com/wp-tutorials/how-to-change-the-default-gravatar-on-wordpress/
/*------*/
/*------*/
/*------*/
/*------*/
/*------*/
/*------*/
/*------*/
	  // Enable shortcodes in text widgets
	  add_filter('widget_text','do_shortcode');
/*------*/
/*--- add login to footer
function ss_footer_login2() {
	wp_loginout();
}
add_filter ('fl_footer_col2_open', 'ss_footer_login2');
/*-----------------------------------------------------------------*/
/*---ACTIVATION - These functions fire once on plugin activation---*/
/*-----------------------------------------------------------------*/
/*---Create the 'admin' role if it doesn't exist---*/
/*---This should likely be part of the White Label section?---*/
function ss_custom_role_admin() {
  $editor = get_role( 'editor' ); // Get the editor role capabilities and duplicate those for initial setup
  $capabilities = $editor->capabilities;
  $admin = add_role( 'admin', 'Admin', $capabilities );
//  $admin->add_cap( 'list_users' ); //adding capabilities
//  $admin->add_cap( 'promote_users' );
//  $admin->add_cap( 'remove_users' );
}
register_activation_hook( __FILE__, 'ss_custom_role_admin' );
/*------*/
function ss_add_capabilities_to_admin() {
  $admin = get_role( 'admin' );
  $admin->add_cap( 'list_users' ); //adding capabilities
  $admin->add_cap( 'remove_users' );
//  $admin->add_cap( 'promote_users' ); //removed as it gave user the ability to promote themself to administrator
}
register_activation_hook( __FILE__, 'ss_add_capabilities_to_admin' );
/*------*/
/*--------------------------------------------------------*/
/*---Function to read settings back out for use in code---*/
/*----Run this in local code where settings are needed----*/
// NEEDS WORK - does not return all the vars to local :( - likely to sack this function
/*--------------------------------------------------------*/
function ssmods_settings_array_reader() {
	$ssmodsettings=get_option('ssmods_settings'); //read the whole array into $ssmodsettings
	$prefix="array_"; //prefix every var name with array_ to avoid local conflicts with other vars 
	foreach ($ssmodsettings as $key => $value) { //loop through array automatically putting every value into it's field name var for use in local code
		${$prefix.$key}=$value;
		return ${$prefix.$key}; //not returning all the vars for local use i don't think?
		} //function guts (without return) loop perfectly in code giving correct set of vars
	}
/*------*/
?>