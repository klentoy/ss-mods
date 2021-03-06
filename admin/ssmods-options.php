<?php
/////////////////////////////////////////////////////////////
// /settings/SS-Mods - admin area options page for SS Mods //
// Version	1.0.0                                          //
/////////////////////////////////////////////////////////////
// IMPORTANT NOTE: Need to setup default values for options? On activation only perhaps? Or will that wipe old values from previous activation?
// RESEARCH on above:
// https://wordpress.stackexchange.com/questions/240679/how-to-set-default-values-for-options-page
// https://stackoverflow.com/questions/6497789/how-can-i-have-default-values-for-options-for-a-wordpress-plugin
// https://www.sitepoint.com/wordpress-settings-api-build-custom-admin-page/
// https://www.wpexplorer.com/wordpress-theme-options/
// could also cheap out on an 'if empty then this' approach to the settings screen in this file?
//
add_action('admin_menu', 'ssmods_add_admin_menu');
add_action('admin_init', 'ssmods_settings_init');

/*--------------------*/
/*---Define Options---*/
/*--------------------*/

function ssmods_add_admin_menu()
{
    add_menu_page('SS-Mods', 'SS-Mods', 'manage_options', 'ss-mods', 'ssmods_options_page');
    add_submenu_page('ss-mods', 'Advance Settings', 'Advance Settings', 'manage_options', 'ss-mods-advance-settings', 'ssmods_advance_settings_page');
}

function ssmods_advance_settings_page()
{
?>
	<div class="wrap">
		<h1>Advance Settings</h1>
		<form method="post" action="options.php">
			<?php 
				settings_fields('SSAdvanceSettingsPage');
				do_settings_sections('SSAdvanceSettingsPage');
				submit_button();
			?>
		</form>
	</div>
	<?php
}

function ssmods_settings_init()
{
    register_setting('SSpluginPage', 'ssmods_settings');
    add_settings_section('ssmods_pluginPage_section', __('SS Mods - Options', 'ssmods') , 'ssmods_settings_section_callback', 'SSpluginPage');
    add_settings_field('ssmods_greeting_textfield', __('Swap the greeting (top right of admin) out for: ', 'ssmods') , 'ssmods_greeting_textfield_render', 'SSpluginPage', 'ssmods_pluginPage_section');
    add_settings_field('ssmods_checkbox_field_1', __('var name is ssmods_checkbox_field_1', 'ssmods') , 'ssmods_checkbox_field_1_render', 'SSpluginPage', 'ssmods_pluginPage_section');
    add_settings_field('ssmods_radio_field_2', __('var name is ssmods_radio_field_2', 'ssmods') , 'ssmods_radio_field_2_render', 'SSpluginPage', 'ssmods_pluginPage_section');
    add_settings_field('ssmods_textarea_field_3', __('var name is ssmods_textarea_field_3 This filed is adding a blank line every setting save :(', 'ssmods') , 'ssmods_textarea_field_3_render', 'SSpluginPage', 'ssmods_pluginPage_section');
    add_settings_field('ssmods_select_field_4', __('var name is ssmods_select_field_4', 'ssmods') , 'ssmods_select_field_4_render', 'SSpluginPage', 'ssmods_pluginPage_section');

	register_setting('SSAdvanceSettingsPage', 'ssmods_advance_settings');
    add_settings_section('ssmods_advance_pluginPage_section', __('SS Mods - Options', 'ssmods') , function(){
		echo __('Listings', 'ssmods');
	}, 'SSAdvanceSettingsPage');
	/*
	add_settings_field('ssmods_advance_textarea_bl', __('Black List IPs', 'ssmods') , function(){
		?>
		<textarea name="" id="" cols="50" rows="10"></textarea>
		<?php
	}, 'SSAdvanceSettingsPage', 'ssmods_advance_pluginPage_section');
	*/
	add_settings_field('ssmods_advance_textarea_wl', __('White List IPs', 'ssmods') , function(){
		if (!function_exists('get_home_path')) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
		}
		$options = get_option('ssmods_advance_settings');
		$ips = explode(PHP_EOL, $options['ssmods_advance_textarea_wl']);
		$err_message = "";
		// if ( isset( $_GET['settings-updated'] ) && $_GET['settings_updated'] == true ) {
			$htaccess = "<Files wp-login.php>\n";
			$htaccess .= "	order deny,allow\n";
			foreach($ips as $ip){
				if (rest_is_ip_address(trim($ip)) == true){
					$htaccess .= "	allow from ". $ip . "\n";
				}
			}
			$htaccess .= "	deny from all\n";
			$htaccess .= "</Files>\n";
			$root_path = get_home_path();
			insert_with_markers($root_path . '.htaccess', 'Whitelist IPs', $htaccess);
		// }
		?>
		<textarea name="ssmods_advance_settings[ssmods_advance_textarea_wl]" id="" cols="50" rows="10"><?php echo trim($options['ssmods_advance_textarea_wl']); ?></textarea>
		<?php
		foreach($ips as $ip2){
			if (rest_is_ip_address(trim($ip2)) == false){
				$err_message .= "<li>". $ip2 ."</li>";
			}
		}
		if(strlen($err_message) > 0){
			?>
			<hr>
			<span>IP(s) listed below are not valid:</span>
			<ul>
				<?php echo $err_message; ?>
			</ul>
			<?php
		}
	}, 'SSAdvanceSettingsPage', 'ssmods_advance_pluginPage_section');

}
/*------------------------*/
/*---End Define Options---*/
/*------------------------*/
/*---Begin options page---*/
/*------------------------*/

function ssmods_greeting_textfield_render()
{
    $options = get_option('ssmods_settings');
?>
	<input type='text' name='ssmods_settings[ssmods_greeting_textfield]' value='<?php echo $options['ssmods_greeting_textfield']; ?>'>
	<?php
}

function ssmods_checkbox_field_1_render()
{
    $options = get_option('ssmods_settings');
?>
	<input type='checkbox' name='ssmods_settings[ssmods_checkbox_field_1]' <?php checked($options['ssmods_checkbox_field_1'], 1); ?> value='1'>
	<?php
}

function ssmods_radio_field_2_render()
{
    $options = get_option('ssmods_settings');
?>
	<input type='radio' name='ssmods_settings[ssmods_radio_field_2]' <?php checked($options['ssmods_radio_field_2'], 1); ?> value='1'>
	<input type='radio' name='ssmods_settings[ssmods_radio_field_2]' <?php checked($options['ssmods_radio_field_2'], 2); ?> value='2'>
	<input type='radio' name='ssmods_settings[ssmods_radio_field_2]' <?php checked($options['ssmods_radio_field_2'], 3); ?> value='3'>
	<?php
}

function ssmods_textarea_field_3_render()
{
    $options = get_option('ssmods_settings');
?>
	<textarea cols='40' rows='5' name='ssmods_settings[ssmods_textarea_field_3]'> 
		<?php echo $options['ssmods_textarea_field_3']; ?>
 	</textarea>
	<?php
}

function ssmods_select_field_4_render()
{
    $options = get_option('ssmods_settings');
?>
	<select name='ssmods_settings[ssmods_select_field_4]'>
		<option value='1' <?php selected($options['ssmods_select_field_4'], 1); ?>>Option 1</option>
		<option value='2' <?php selected($options['ssmods_select_field_4'], 2); ?>>Option 2</option>
	</select>
<?php
}

function ssmods_settings_section_callback()
{
    echo __('Options Section 1', 'ssmods');
}

function ssmods_options_page()
{
?>
	<div class="wrap">
		<h1>Shipwreck Studio Mods</h1>
	<form action='options.php' method='post'>
		<?php
			settings_fields('SSpluginPage');
			do_settings_sections('SSpluginPage');
			submit_button();
		?>
	</form>
<?php include 'helpnotes.php'; //*****Displays the help files HERE*****
    
?>
	</div>
	<?php
}
/*----------------------*/
/*---End options page---*/
/*----------------------*/

/*----------------------------------------------------------------------------------*/
/*--- Debug Shortcode - echo all settings data (requires below print_r2 function)---*/
/*----------------------------------------------------------------------------------*/
function echo_settings_data()
{
    $settings1 = get_option('ssmods_settings'); //read the whole array into $settings1
    $textfield1 = $settings1['ssmods_greeting_textfield']; //read that val from the array into $textfield1
    $checkbox1 = $settings1['ssmods_checkbox_field_1']; // ""  ""  "" $checkbox1
    echo '<br>Auto looping through array to create vars from all keys and store values in them<br>';
    $prefix = "array_";
    foreach ($settings1 as $key => $value)
    { //loop through array automatically putting every value into it's field name var for use in local code
        $
        {
            $prefix . $key
        } = $value;
        echo '<br>String Name Created: ' . $prefix . '' . $key . '';
    }
    echo '<br>------------------------------------<br>';
    echo 'The first textfield value: ' . $textfield1 . '.<br>';
    echo 'The checkbox value: ' . $checkbox1 . '.<br>';
    echo '<br>------------------------------------<br>';
    echo 'Result data from auto-array read and naming:<br>';
    echo '' . $array_ssmods_greeting_textfield . ', ' . $array_ssmods_checkbox_field_1 . '';
    echo '<br>------------------------------------<br>';
    echo 'Raw Array Data from array:<br>';
    print_r2($settings1);
}
add_shortcode('ss_settings_data', 'echo_settings_data');
/*------*/
/*---Function: print_r2 to improve readability of print_r for displaying array content on front end---*/
function print_r2($val)
{
    echo '<pre>';
    print_r($val);
    echo '</pre>';
}
/*------*/
/*------*/
/*--------------------------------------------------------*/
/*---Function to read settings back out for use in code---*/
/*----Run this in local code where settings are needed----*/
/*--------------------------------------------------------*/
/*---
function ssmods_settings_array_reader() {
	$ssmodsettings=get_option('ssmods_settings'); //read the whole array into $ssmodsettings
	$prefix="array_"; //prefix every var name with array_ to avoid local conflicts with other vars 
	foreach ($ssmodsettings as $key => $value) { //loop through array automatically putting every value into it's field name var for use in local code
		${$prefix.$key}=$value;
		}
	}
	--*/
?>
