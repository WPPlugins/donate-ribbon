<?php
/*
Plugin Name: Donate Ribbon
Plugin URI: http://wordpress.org/extend/plugins/donate-ribbon
Description: Places a black ribbon in the upper right corner of your blog displaying the word "Donate" in white text. You can set the link to any URL you choose.
Author: Al Lamb
Version: 1.1.1
License: GPLv2
Author URI: http://bowierocks.com/donate-ribbon
*/

function donate_ribbon_admin() {
	add_submenu_page( 'tools.php', 'Donate  Ribbon Settings', 'Donate Ribbon', 10, __FILE__, 'donate_ribbon_admin_menu' );
}

function donate_ribbon_first() {
	if ( get_option( 'donate_ribbon_url' ) == false ) {
		add_option( 'donate_ribbon_url', 'https://american.redcross.org/site/SPageServer?s_subsrc=RCO_BigRedButton&pagename=ntld_main&s_src=RSG000000000' );
		add_option( 'donate_ribbon_title','Please help the Red Cross by donating to one of their varied humanitarian efforts.');
 		add_option( 'donate_ribbon_user_offset', '0' );
		add_option( 'donate_ribbon_admin_offset', '0' );
   }

}

function donate_ribbon_admin_menu() {
	if ( ( get_option( 'donate_ribbon_url' ) ) == false ) {
		donate_ribbon_first();
	}

	echo('
		<div class="wrap">
		<h2>Donate Ribbon Options</h2><address style="font-size: 8pt; font-weight: 700;">Version 1.1 (<a href="http://www.bowierocks.com/donate-ribbon" target="_blank">Donate Ribbon</a>)</address>
	');
	if ( isset( $_POST['submit'] ) ) {
		$str = strtr( $_POST['donate_ribbon_url'], array( '"' => '&#34;', '\\' => '', '\'' => '&#39;' ) );
		$donate_ribbon = update_option( 'donate_ribbon_url', $str );
		$str = strtr( $_POST['donate_ribbon_title'], array( '"' => '&#34;', '\\' => '', '\'' => '&#39;' ) );
		$donate_ribbon .= update_option( 'donate_ribbon_title', $str);
		$str = strtr( $_POST['donate_ribbon_admin_offset'], array( '"' => '&#34;', '\\' => '', '\'' => '&#39;' ) );
		$donate_ribbon .= update_option( 'donate_ribbon_admin_offset', $str );
		$str = strtr( $_POST['donate_ribbon_user_offset'], array( '"' => '&#34;', '\\' => '', '\'' => '&#39;' ) );
		$donate_ribbon .= update_option( 'donate_ribbon_user_offset', $str );
		if ( $donate_ribbon )
			echo('<div class="updated"><p><strong>Your setting have been saved.</strong></p></div>');
		else
			echo('<div class="error"><p><strong>Your setting have not been saved.</strong></p></div>');
	}

	echo('
		<form action="" method="post">
		<table class="form-table">
		<tr><td>URL to Link to<br/><span class="donate_ribbon_hint">Insert full HTTP quallifed link. for example: http://bowierocks.com/donate</span></td>
<td><input type="text" name="donate_ribbon_url" size="80" value="'.get_option( 'donate_ribbon_url' ).'"></td>
</tr>
		<tr><td>TITLE for Link<br/><span class="donate_ribbon_hint">This is the message that pops up when you hove over links.</span></td>
<td><input type="text" name="donate_ribbon_title" size="80" value="'.get_option( 'donate_ribbon_title' ).'"></td>
</tr>
		<tr><td>Admin Vertical Offset<br/><span class="donate_ribbon_hint">Enter a positive number to push the ribbon down, negative for up. Suggest 28 to offset the ADMIN bar.</span></td>
<td><input type="text" name="donate_ribbon_admin_offset" size="5" maxlength=5 value="'.get_option( 'donate_ribbon_admin_offset','0' ).'"></td>
</tr>
		<tr><td>User Vertical Offset<br/><span class="donate_ribbon_hint">Enter a positive number to push the ribbon down, negative for up. Suggest 28 to offset the USER bar.</span></td>
<td><input type="text" name="donate_ribbon_user_offset" size="5" maxlength=5 value="'.get_option( 'donate_ribbon_user_offset','0' ).'"></td>
</tr>
		<hr />
		<tr><td colspan="2"><hr /></td></tr>
		<tr><td><input class="button-primary" type="submit" name="submit" value="Save Changes" /></td><td>&nbsp;</td></tr>
		</table>
		</form>
		</div>
	' );
}

function donate_ribbon_admin_css() {
	echo( '
		<style type="text/css">
		.donate_ribbon_admin_hint {
		font-size: 7pt;
		font-style: italic;
		color: #080;
		}
		</style>
	' );
}
add_action( 'admin_menu', 'donate_ribbon_admin' );
add_action( 'admin_head', 'donate_ribbon_admin_css' );

function render_donate_ribbon() {
        $img = plugins_url("donate-ribbon.png",__FILE__);

	if(is_admin_bar_showing()) 
	  $offset = get_option("donate_ribbon_admin_offset");
	else
	  $offset = get_option("donate_ribbon_user_offset");
	  
	echo "<a target='_blank' class='stop-cispa-ribbon' href='". get_option("donate_ribbon_url")."' title='".get_option("donate_ribbon_title")."'><img src='{$img}' alt='Stop CISPA' style='position: fixed; top: {$offset}px; right: 0; z-index: 100000; cursor: pointer;' /></a>";
}

add_action( 'wp_footer', 'render_donate_ribbon' );
?>