<!-- This file gets included in ssmods-options.php as a help file -->

<hr style='background-color:#000000;border-width:0;color:#000000;height:1px;line-height:0;text-align:left;width:90%;'/>

<div>
	<h1>DOX..</h1>
	<h2>Login URL:</h2>
	<ul style="list-style-type:circle; padding-left:30px">
		<li>This plugin changes your default <b>wp-login</b> address to <b>/backend</b><br>You can change that in the /settings /permalinks section</li>
	</ul>
</div>
<div style="overflow-x:auto;">
	</br>
	<h2>Shortcodes available from this plugin:</h2>
	<table id="ss_t01" class="ss_striped_table" style="width: 90%;">
		<tr><td width=""><b>[ss-login]</b></td><td>Login</td></tr>
		<tr><td><b>[ss-login3]</b></td><td>Login with hard coded redirect (Currently home_url)</td></tr>
		<tr><td><b>[ss-logout]</b></td><td>Only displays for logged in users</td></tr>
		<tr><td><b>[ss-alreadyloggedin]</b></td><td>Only displays for logged in users, with a nice message</td></tr>
		<tr><td><b>[ss_current_year]</b></td><td>Echos the year - Please use this on footers</td></tr>
		<tr><td><b>[ss_current_date]</b></td><td>Echos the day name then date eg: Thursday, 18/4/19</td></tr>
		<tr><td><b>[ss-current-username]</b></td><td>Echos the logged in username</td></tr>
		<tr><td><b>[ss-theme-folder]</b></td><td>Gets the theme folder and removes trailing slash</td></tr>
		<tr><td><b>[ss_user_count]</b></td><td>Total user count</td></tr>
		<tr><td><b>[ss-backtotop-btn]</b></td><td>Back-to-top button</td></tr>
		<tr><td><b>[ss-adminonly]</b></td><td>[ss-adminonly]only admin can see this content[/ss-adminonly]</td></tr>
		<tr><td><b>[ss-ifloggedin]</b></td><td>[ss-ifloggedin]only logged in users can see this content[/ss-ifloggedin]</td></tr>
		<tr><td><b>[ss_tick]</b></td><td>Bootstrap 3 tick button</td></tr>
		<tr><td><b>[ss-cross]</b></td><td>Bootstrap 3 cross button</td></tr>
		<tr><td><b>[ss-bb-edit]</b></td><td>Manual Beaver Builder Edit this content button</td></tr>
		<tr><td><b>[]</b></td><td>spare line here :)</td></tr>
	</table>
</div>
<div style="overflow-x:auto;">
	</br>
	<h2>Other goodies</h2>
	<table id="ss_t02" style="width: 90%;">
		<tr><td width=""><b>White Labeling - /inc/ss-mods-whitlabel.php</b></td><td>Removes the word "Wordpress" from just about everywhere in admin</td></tr>
		    <tr><td width=""><b></b></td><td>Changes top left admin icon to Shipwreck's icon</td></tr>
		    <tr><td width=""><b></b></td><td>Changes bottom left Wordpress message to Shipwreck msg with backlink</td></tr>
		    <tr><td width=""><b></b></td><td>Cleans & changes admin login screen to a Shipwreck one</td></tr>
		    <tr><td width=""><b></b></td><td>Removes the Wordpress top black bar so that users can have a clean front end ONLY Beaver Builder editing experience</td></tr>
		    <tr><td width=""><b></b></td><td>Removes some admin menu items for everyone except administrator. Currently adjusted only in code /inc/ss-mods-whitelabel.php - However this list needs to be switchable in admin screen</td></tr>
		    <tr><td width=""><b></b></td><td>ads a user class just below Administrator called Admin for use by clients. Hides the actual Administrators (us) from the user list for lower classes</td></tr>
		    <tr><td width=""><b></b></td><td>disables most dashboard widgets for admin and below</td></tr>
		<tr><td width=""><b>Security - /inc/ss-mods-security.php</b></td><td>Suppress error msgs for everyone except administrator</td></tr>
		    <tr><td width=""><b></b></td><td>Set custom login time (default 2 weeks) - needs to be adjustable in admin options</td></tr>
			<tr><td width=""><b></b></td><td>hide error msgs that give away login attempt stuff</td></tr>
			<tr><td width=""><b></b></td><td>login attempt limiter, needs work - please see notes in code</td></tr>
			<tr><td width=""><b></b></td><td>redirection for certain user classes to front end only - incomplete, please see notes in code</td></tr>
		<tr><td width=""><b>More to come..</b></td><td>Plugin does more that I haven't doxxed here yet..</td></tr>
	</table>
</div>
<div style="overflow-x:auto;">
	</br>
	<h2>Dev Todos:</h2>
	<table id="ss_t03" style="width: 90%;">
		<tr><td width=""><b>More help docs</b></td><td>Rick to review further need</td></tr>
		<tr><td><b>Fix Front End Edit Button Styles</b></td><td>Button probably needs it's own CSS so it;s always properly visible</td></tr>
		<tr><td><b>This plugin needs centrally located auto updating</b></td><td>We need to research this and sort it out so that we don;t have to manually update it on every site</td></tr>
		<tr><td><b>The above options screen needs to be completed</b></td><td>Need to be able to turn certain features off and on easily from the above UI</td></tr>
	</table>
</div>