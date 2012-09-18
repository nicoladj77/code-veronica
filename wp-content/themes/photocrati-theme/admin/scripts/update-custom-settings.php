<?php

	define('ABSPATH', dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))).'/');
	include_once(ABSPATH.'wp-config.php');
	include_once(ABSPATH.'wp-load.php');
	include_once(ABSPATH.'wp-includes/wp-db.php');
	global $wpdb;
	
	if (!current_user_can('edit_pages') && !current_user_can('edit_posts'))
	{
		wp_die('Permission Denied.');
	}
	
	$SQL = "DELETE FROM ".$wpdb->prefix."photocrati_presets WHERE preset_name = '" . $wpdb->escape($_POST['preset_name']) . "' AND custom_setting = 'YES'";	
	$wpdb->query($SQL);
	
	$SQL1 = "
	UPDATE ".$wpdb->prefix."photocrati_styles
	SET custom_setting = 'YES', preset_title = '" . $wpdb->escape($_POST['preset_title']) . "', preset_name = '" . $wpdb->escape(str_replace(' ', '-', strtolower($_POST['preset_name']))) . "'
	WHERE option_set = 1
	";
	$wpdb->query($SQL1);
	
	$SQL2 = "
	INSERT INTO ".$wpdb->prefix."photocrati_presets
	SELECT * FROM ".$wpdb->prefix."photocrati_styles
	WHERE option_set = 1
	";
	$wpdb->query($SQL2);
					
?>

