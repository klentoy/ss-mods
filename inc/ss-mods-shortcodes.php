<?php
////////////////////////////
// Shortcodes for SS Mods //
// Version	1.0.0         //
////////////////////////////
/*----------------*/
/*---Shortcode - logout link---*/
function ss_logout_func ($atts, $content = null) {
  if ( is_user_logged_in() ) { //only displays for logged in users
	
	extract(shortcode_atts(array(
		'linktext' => 'Logout',
		), $atts));
	$logoutlink = wp_logout_url( home_url() );
	 return '<a href="' . $logoutlink . '" title="Logout">'. $linktext .'</a>';
}
}
add_shortcode( 'ss-logout', 'ss_logout_func' );
//  [ss-logout linktext="YES"] - if you don't specify linktext, will just display "Logout"
/*------*/
/*---Shortcode - logout link conditional---*/
function ss_alreadyloggedin_func ($atts, $content = null) {
  if ( is_user_logged_in() ) { //only displays for logged in users
	?>You are already logged in, would you like to [ss-logout]?<?php
}
}
add_shortcode( 'ss-alreadyloggedin', 'ss_alreadyloggedin_func' );
/*------*/
/*--- Shortcode - standard wordpress login/out ---*/
// Currently this and the similar login scripts around it all create an issue with displaying way outside/above their div
function ss_login() {
	wp_loginout();
}
add_shortcode('ss-login', 'ss_login');
/*------*/
/*--- Shortcode - standard wordpress login/out ---*/
function ss_login3() {
$args = array(
    'redirect' => home_url(), 
    'id_username' => 'user',
    'id_password' => 'pass',
   ) 
;?>
<?php wp_login_form( $args );
}
  add_shortcode('ss-login3', 'ss_login3');
/*------*/
/*--- Shortcode - echo year ---*/
function echo_current_year() {
  $ss_year = date('Y');
  return $ss_year;
}
add_shortcode('ss_current_year', 'echo_current_year');
/*------*/
/*---Shortcode - Display username for logged in user---*/
/*---Consider using ucwords to capitalize first char?---*/
add_shortcode( 'ss-current-username' , 'ss_get_current_username' );
function ss_get_current_username(){
    $user = wp_get_current_user();
    return $user->first_name; /*---Choose alternate parameter here - codex.wordpress.org/Function_Reference/the_author_meta---*/
}
/*------*/
/*---Shortcode - theme address---*/
add_shortcode('ss-theme-folder', 'shipwreck_theme_uri_shortcode' );
function shipwreck_theme_uri_shortcode( $attrs = array (), $content = '' )
{
    $theme_uri = is_child_theme()
        ? get_stylesheet_directory_uri()
        : get_template_directory_uri();
    return trailingslashit( $theme_uri ); //remove trailing slash if exists already
}
/*---Shortcode - user count---*/
add_shortcode( 'ss_user_count', 'the_user_count' );
function the_user_count() {
   $count = count_users();
   return $count['total_users'];
}
/*--- Shortcode - Back to top button - Beaver Builder specific smooth scroll class included ---*/
function ss_backtotop_btn() {
		return '<a href="#ss_pagetop" class="fl-scroll-link ss_backtotop_btn ss_getitinthecenter" rel="tooltip" title="Scroll to top"><span class="fl-icon"><i class="fa fa-chevron-circle-up"></i></span></a>';
}
add_shortcode('ss-backtotop-btn', 'ss_backtotop_btn');
// add pagetopper ID to wordpress header for the backtotop button to smooth scroll to
add_action('wp_head','ss_hook_css');
function ss_hook_css() {
  $ssthiscontent = '<div id="ss_pagetop"></div>';
  echo $ssthiscontent;
}
/*---Shortcode - admin ONLY content for frontend---*/
// [ss-adminonly]only admin can see this content[/ss-adminonly]
function ss_adminonly($atts, $content = null) {
	if (current_user_can('create_users'))
		return '<div class="ssadminonly">' . $content . '</div>';//create a CSS class for ssadminonly if needed
	return '';//This returns for everyone else (presently empty - so nothing)
}
add_shortcode('ss-adminonly', 'ss_adminonly');
/*---Shortcode - only displays for any logged in users---*/
// [ss-ifloggedin]only admin can see this content[/ss-ifloggedin]
function ss_ifloggedin($atts, $content = null) {
  if ( is_user_logged_in() ) { //only displays for logged in users
		return '<div class="ssifloggedin">' . $content . '</div>';//create a CSS class for ssifloggedin if needed
	return '';//This returns for everyone else (presently empty - so nothing)
}
}
add_shortcode('ss-ifloggedin', 'ss_ifloggedin');
/*------*/
/*---Shortcode - Success TICK button - round---*/
//currently coded for Bootstrap3 button
function ss_tick() {
		return '<button type="button" class="btn btn-success btn-circle"><i class="glyphicon glyphicon-ok"></i></button>';
}
add_shortcode('ss-tick', 'ss_tick');
/*---Shortcode - Success CROSS button - round---*/
//currently coded for Bootstrap3 button
function ss_cross() {
		return '<button type="button" class="btn btn-danger btn-circle"><i class="glyphicon glyphicon-remove"></i></button>';
}
add_shortcode('ss-cross', 'ss_cross');
/*--- Shortcode - Beaver Builder content edit button for front end ---*/
//currently coded for Bootstrap3 button
function ss_bb_edit() {
    if (current_user_can('create_users'))
        return '<abbr rel="tooltip" title="Only Admins can see this button"><a href="?fl_builder" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-th-large"></span>Edit Content</a></abbr>';
    return '';//This returns for everyone else (presently empty - so nothing)
}
add_shortcode('ss-bb-edit', 'ss_bb_edit');
/*------*/
?>