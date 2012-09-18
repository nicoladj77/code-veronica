<?php

// Create theme update widget

function theme_update_widget() {
	global $themename,$shortname,$version;
	
	$welcome = '
	<p><b>You are using '.$themename.' version '.$version.'</b></p>
	<p>You can customize your theme using the Theme Options menu to the left.<BR>If you have any questions
	please visit our member area at <a href="http://members.photocrati.com" target="_blank">
	http://members.photocrati.com</a></p><p><b>Theme Updates</b></p>
	';
	$return = '';
	
	// Use MagpieRSS
	require_once(ABSPATH . WPINC . '/rss.php');

	// Feed where updates are located
	$rss = fetch_rss('http://www.photocrati.com/theme-updates/photocrati-updates-v'.$version.'.xml');

	if($rss) {
		
		//loop through the latest rss items
		foreach($rss->items as $item) {
			
			// Do our shornames match up?
			if($item['shortname']==$shortname) {
				
				// Compare version numbers.
				if($item['version'] > $version) {
					$return = '<p>A new version of your theme is <a href="'.$item['description'].'">now available here</a>!</p>';
				} else {
					$return = '<p><em>There are no updates to this theme available at this time.</em></p>';
				}
				
			}
			
		}
		
	} else {
		
		// No updates.
		$return = '<p><em>There are no updates to this theme available at this time.</em></p>';
		
	}
	
	echo $welcome;
	echo $return;
}



// Create header update notification

function theme_update_header() {
	global $themename,$shortname,$version;
	
	$return = '';
	
	// Use MagpieRSS
	require_once(ABSPATH . WPINC . '/rss.php');

	// Feed where updates are located
	$rss = fetch_rss('http://www.photocrati.com/theme-updates/photocrati-updates-v'.$version.'.xml');

	if($rss) {
		
		//loop through the latest rss items
		foreach($rss->items as $item) {
			
			// Do our shornames match up?
			if($item['shortname']==$shortname) {
				
				// Compare version numbers.
				if($item['version'] > $version) {
					$return = '<p>A new version of your theme is <a href="'.$item['description'].'">now available here</a>!</p>';
				} else {
					$return = '<p><em>There are no updates to this theme available at this time.</em></p>';
				}
				
			}
			
		}
		
	} else {
		
		// No updates.
		$return = '<p><em>There are no updates to this theme available at this time.</em></p>';
		
	}
	
	echo $return;
	
}


// Display theme version on admin header

function theme_version() {
	global $themename,$shortname,$version;
	echo '<h1>'.$themename.' '.$version.'</h1>';
	theme_update_header();
}


// Display theme update feed on update page

function theme_updates() {
	global $newversion,$version,$themename,$shortname;
	
	// Get latest version
	
	// Use MagpieRSS
	require_once(ABSPATH . WPINC . '/rss.php');
	
	// Feed where updates are located
	$rss = fetch_rss('http://www.photocrati.com/theme-updates/photocrati-updates-v'.$version.'.xml');
	
	if($rss) {
			
		//loop through the latest rss items
		foreach($rss->items as $item) {
				
			// Do our shornames match up?
			if($item['shortname']==$shortname) {
				
				$newversion = $item['version'];
					
			}
				
		}
			
	}
	
	if($newversion > $version) {
	echo '<input type="hidden" name="theme-version" value="'.$newversion.'">';
	echo '<input type="hidden" name="theme-name" value="photocrati-theme">';
	echo '<p><div class="submit-button-wrapper"><input type="button" id="update-theme" value="&raquo; Get Update Now" style="clear:none;background:#0F7C11;color:#FFF;" /></div>';
	echo '<div id="loader" style="float:left;display:none;margin-top:7px;"><img src="'.get_template_directory_uri().'/admin/images/ajax-loader.gif"></div><div id="msg" style="float:left;"></div></p>';
	} else {
	echo '<p>There are no updates to this theme available at this time.</p>';
	}
}



// Create welcome dashboard widget

function add_dashboard_update_widget() {
	wp_add_dashboard_widget('theme_update_widget', 'Welcome to Photocrati', 'theme_update_widget');
	
	// Globalize the metaboxes array, this holds all the widgets for wp-admin

	global $wp_meta_boxes;
	
	// Get the regular dashboard widgets array 
	// (which has our new widget already but at the end)

	$normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
	
	// Backup and delete our new dashbaord widget from the end of the array

	$example_widget_backup = array('theme_update_widget' => $normal_dashboard['theme_update_widget']);
	unset($normal_dashboard['theme_update_widget']);

	// Merge the two arrays together so our widget is at the beginning

	$sorted_dashboard = array_merge($example_widget_backup, $normal_dashboard);

	// Save the sorted array back into the original metaboxes 

	$wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
}

add_action('wp_dashboard_setup', 'add_dashboard_update_widget' );

?>