<?php
ini_set('display_errors','off');
///////////////////////////
// Functions for SS Mods
// Version	1.0.0
///////////////////////////
/*---Load admin area style mods---*/
add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );
function load_custom_wp_admin_style() {
        wp_register_style( 'custom_wp_admin_css', get_template_directory_uri() . '/css/admin-style.css', false, '1.0.0' );
        wp_enqueue_style( 'custom_wp_admin_css' );
}
/*------*/
/*------*/
/*------*/
/*---Custom Dashboard Widget---*/
	add_action('wp_dashboard_setup', 'ss_dashboard_widgets');
	  
	  function ss_dashboard_widgets() {
	  global $wp_meta_boxes;
	  
	  wp_add_dashboard_widget('custom_help_widget', 'Shipwreck Studio', 'custom_dashboard_help');
	  }
	  
	  function custom_dashboard_help() {
		echo '<p>Welcome to your Shipwreck Studio dashboard Contact the developer <a href="mailto:rick@shipwreckstudio.com">here</a>.</br> For billing and other information visit our client portal: </br><a href="https://shipwreckstudio.com/client-portal/" target="_blank">Shipwreck Client Portal</a></p>';
	  }
/*------*/
/*---Change excerpt length if required - default is 55 words---*/
	  function ss_custom_excerpt_length($length) {
	  return 55;
	  }
/*------*/
/*--- Automated Beaver Builder content edit button for front end ---*/
//Now with funky new rainbow glow (css only) - appears overlayed on top right corner as a black circle when logged in
function ss_bb_edit_btn($content) {
	  if ( FLBuilderModel::is_builder_enabled() )
		if (current_user_can('edit_posts'))
		    $custom_content = '<div class="ss_floateditbtn_ontop"><a href="?fl_builder"><button class="glow-on-hover ss_floateditbtn_ontop" title="EDIT CONTENT - Only Admins can see this button"><img src= "/wp-content/plugins/ss-mods/images/shipwreck32x32.png" width="40" height="40"></button></a></div>';
			$custom_content .= $content; //concatenate
			return $custom_content;
}
/*------*/
/*------*/
/*------*/
?>