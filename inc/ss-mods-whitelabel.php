<?php
////////////////////////////
// Whitelabel for SS Mods //
// Version	1.0.0        //
////////////////////////////
/*------*/
/*---Custom Admin Dashboard Logo---*/
function ss_replace_wp_logo_in_admin_bar() {
    ?>
        <style type="text/css">
            #wpadminbar #wp-admin-bar-wp-logo > .ab-item .ab-icon:before {
			content: url(<?php echo plugins_url(); ?>/ss-mods/images/shipwreck32x32.png)   !important;
                top: 0px;
            }

            #wpadminbar #wp-admin-bar-wp-logo > a.ab-item {
                pointer-events: none;
                cursor: default;
            }
        </style>
    <?php
	}
/*------*/
/*---Logo and other mods to login page---*/
function ss_custom_login_page() { ?>
    <style type="text/css">
        /*---Login Logo---*/
		#login h1 a, .login h1 a {
			background-image: url(<?php echo plugins_url(); ?>/ss-mods/images/shipwreckstudiologo320x76.png);
			height:76px;
			width:320px;
			background-size: 320px 76px;
			background-repeat: no-repeat;
			padding-bottom: 5px;
        }
		/*---Login Background---*/
		body.login {
			background-image: url(<?php echo plugins_url(); ?>/ss-mods/images/ss-middle-whitewash.jpg);
			background-repeat: no-repeat;
			background-attachment: fixed;
			background-position: center;
			background-size: cover;
		}
		/*---Remove 'Lost Password' Link---*/
		p#nav {
		  	display: none;
		}
		/*---Remove 'Back To' Link---*/
		p#backtoblog {
  			display: none;
		}
    </style>
<?php }
/*------*/
/*--- Suppress some admin menu items for everyone except administrator ---*/
// reference: http://codex.wordpress.org/Function_Reference/remove_menu_page
// reference: http://www.wpbeginner.com/wp-tutorials/how-to-remove-menu-item-in-wordpress-admin-panel/
// reference: http://wordpress.stackexchange.com/questions/136058/how-to-remove-admin-menu-pages-inserted-by-plugins
function ss_hide_admin_menu_items() {
if (!current_user_can('administrator')) { // Is Not Administrator
     	remove_menu_page( 'options-general.php' );        				//Settings
   	 	remove_menu_page( 'duplicator-pro' );        					//Duplicator Pro (had odd differences to others)
       	//add_menu_page( 'woocommerce' );        						//Woocommerce
       	//add_menu_page( 'edit.php?post_type=product' );  			//Products
	    remove_menu_page( 'edit.php?post_type=fl-builder-template' );   //Beaver Builder
    	/*--  	echo '<style>
				#toplevel_page_duplicator-pro {display:none;}
				#menu-settings {display:none;}
				</style>'; --*/                				//Can also be hidden by ID with CSS if required
}
}
/*------*/
/*---Admin - Remove Administrators from user list---*/
  function ss_pre_user_query($user_search) {
	$user = wp_get_current_user();
	if (!current_user_can('administrator')) { // Is Not Administrator - Remove Administrator
	  global $wpdb;
  
	  $user_search->query_where = 
		  str_replace('WHERE 1=1', 
			  "WHERE 1=1 AND {$wpdb->users}.ID IN (
				   SELECT {$wpdb->usermeta}.user_id FROM $wpdb->usermeta 
					  WHERE {$wpdb->usermeta}.meta_key = '{$wpdb->prefix}capabilities'
					  AND {$wpdb->usermeta}.meta_value NOT LIKE '%administrator%')", 
			  $user_search->query_where
		  );
	}
  }
/*------*/
/*---Remove drop menu from the old wordpress logo admin spot top left---*/
	function ss_remove_credits_menu_items($wp_admin_bar) {
		$wp_admin_bar->remove_node('about');
		$wp_admin_bar->remove_node('wporg');
		$wp_admin_bar->remove_node('documentation');
		$wp_admin_bar->remove_node('support-forums');
		$wp_admin_bar->remove_node('feedback');
	}
/*------*/
/*---Change footer in admin panel---*/
	function ss_remove_footer_admin () {
	  echo 'Application Coding & Site Design: <a href="http://shipwreckstudio.com" target="_blank">Shipwreck Studio</a></p>';
	}
/*------*/
/*---disable default dashboard widgets---*/
		function ss_disable_default_dashboard_widgets() {	
			remove_meta_box('dashboard_right_now', 'dashboard', 'core');
			remove_meta_box('dashboard_activity', 'dashboard', 'core');
			remove_meta_box('dashboard_recent_comments', 'dashboard', 'core');
			remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');
			remove_meta_box('dashboard_plugins', 'dashboard', 'core');
			remove_meta_box('dashboard_quick_press', 'dashboard', 'core');
			remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');
			remove_meta_box('dashboard_primary', 'dashboard', 'core');
			remove_meta_box('dashboard_secondary', 'dashboard', 'core');
			/*---Remove the Welcome Panel from dashboard---*/
			remove_action('welcome_panel', 'wp_welcome_panel');
		}
/*------*/
/*---Swap out the Howdy greeting for something else---*/
	function ss_change_howdy($translated, $text, $domain) {
		$greeting=get_option('ssmods_settings')['ssmods_greeting_textfield']; //get greeting from settings
		if (!is_admin() || 'default' != $domain)
			return $translated;
		if (false !== strpos($translated, 'G\'day'))
			return str_replace('G\'day', $greeting, $translated);
		return $translated;
	  }
/*------*/
/*------*/
/*------*/
/*------*/
?>