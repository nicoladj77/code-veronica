<?php

function add_column_if_not_exist($db, $column, $column_attr, $default){
    global $wpdb;
    $columns = $wpdb->get_results("SHOW COLUMNS FROM $db LIKE '$column'");
    if(!$columns){
        $wpdb->query("ALTER TABLE `$db` ADD `$column` $column_attr");
    }
}

// Create custom admin table if it doesn't exist

function createtable_photocrati_admin() {
	global $version, $table_prefix, $wpdb;
		
		
	$photocrati_version = $table_prefix . "photocrati_version";
	
	if($wpdb->get_var("show tables like '$photocrati_version'") == $photocrati_version) {
		
		$sql19 = "UPDATE ". $photocrati_version . " SET ";
		$sql19 .= "version = '".$version."' ";
		$sql19 .= "WHERE id = 1";
		$wpdb->query($sql19);
	
		$sql = "ALTER TABLE ". $photocrati_version . " CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
		$wpdb->query($sql);
	
	} else {
	
		$sql18 = "CREATE TABLE `". $photocrati_version . "` ( ";
		$sql18 .= " `id` numeric NOT NULL, ";
		$sql18 .= " `version` TINYTEXT NOT NULL ";
		$sql18 .= ") ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1 ; ";
		
		require_once(ABSPATH . 'wp-admin/upgrade-functions.php');
		dbDelta($sql18);
        
        $sql19 = "INSERT INTO ". $photocrati_version . " VALUES (";
		$sql19 .= "1 "; // id
		$sql19 .= ",'".$version."' "; // version
		$sql19 .= ")";
		$wpdb->query($sql19);
		
	}
	
	
	$photocrati_styles = $table_prefix . "photocrati_styles";
	
	if($wpdb->get_var("show tables like '$photocrati_styles'") == $photocrati_styles) {
		
		add_column_if_not_exist($photocrati_styles, 'preset_name', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_styles, 'preset_title', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_styles, 'one_column', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_styles, 'one_column_color', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_styles, 'one_column_logo', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_styles, 'one_column_margin', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_styles, 'header_height', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_styles, 'header_logo_margin_above', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_styles, 'header_logo_margin_below', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_styles, 'title_size', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_styles, 'title_color', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_styles, 'title_font_style', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_styles, 'title_font_weight', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_styles, 'title_style', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_styles, 'description_size', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_styles, 'description_color', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_styles, 'description_style', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_styles, 'p_line', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_styles, 'p_space', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_styles, 'h1_font_style', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_styles, 'h2_font_style', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_styles, 'h3_font_style', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_styles, 'h4_font_style', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_styles, 'h5_font_style', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_styles, 'h1_font_case', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_styles, 'h2_font_case', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_styles, 'h3_font_case', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_styles, 'h4_font_case', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_styles, 'h5_font_case', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_styles, 'h1_font_weight', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_styles, 'h2_font_weight', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_styles, 'h3_font_weight', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_styles, 'h4_font_weight', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_styles, 'h5_font_weight', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_styles, 'h1_font_align', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_styles, 'bg_top_offset', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_styles, 'container_padding', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_styles, 'footer_font', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_styles, 'footer_font_color', 'TINYTEXT NULL', '');
        add_column_if_not_exist($photocrati_styles, 'custom_setting', 'TINYTEXT NULL', ' ');
        add_column_if_not_exist($photocrati_styles, 'footer_widget_placement', 'TINYTEXT NULL', '');
        add_column_if_not_exist($photocrati_styles, 'footer_background', 'TINYTEXT NULL', '');
        add_column_if_not_exist($photocrati_styles, 'footer_font_style', 'TINYTEXT NULL', '');
        add_column_if_not_exist($photocrati_styles, 'footer_widget_title', 'TINYTEXT NULL', '');
        add_column_if_not_exist($photocrati_styles, 'footer_widget_color', 'TINYTEXT NULL', '');
        add_column_if_not_exist($photocrati_styles, 'footer_widget_style', 'TINYTEXT NULL', '');
        add_column_if_not_exist($photocrati_styles, 'footer_link_color', 'TINYTEXT NULL', '');
        add_column_if_not_exist($photocrati_styles, 'footer_link_hover_color', 'TINYTEXT NULL', '');
        add_column_if_not_exist($photocrati_styles, 'footer_link_hover_style', 'TINYTEXT NULL', '');
        add_column_if_not_exist($photocrati_styles, 'footer_height', 'TINYTEXT NULL', '');
        add_column_if_not_exist($photocrati_styles, 'page_comments', 'TINYTEXT NULL', '');
        add_column_if_not_exist($photocrati_styles, 'social_flickr', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_styles, 'menu_font_case', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_styles, 'submenu_font_case', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_styles, 'blog_meta', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_styles, 'show_photocrati', 'TINYTEXT NULL', '');
	
		$sql = "ALTER TABLE ". $photocrati_styles . " CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
		$wpdb->query($sql);
		
		$check = $wpdb->get_results("SELECT footer_widget_placement,one_column_color FROM ".$wpdb->prefix."photocrati_styles WHERE option_set = 1");
		foreach ($check as $check) {
			$footer_widget_placement = $check->footer_widget_placement;
		}
		
		if($footer_widget_placement == '' || $footer_widget_placement == NULL) {
		
		$sqladd = "UPDATE ". $photocrati_styles . " SET ";
		$sqladd .= "custom_setting='', "; // custom_setting
		$sqladd .= "footer_widget_placement='3', "; // footer_widget_placement
		$sqladd .= "footer_background='FFFFFF', "; // footer_background
		$sqladd .= "footer_font_style='Georgia, \"Times New Roman\", Times, serif', "; // footer_font_style
		$sqladd .= "footer_widget_title='16', "; // footer_widget_title
		$sqladd .= "footer_widget_color='7695b2', "; // footer_widget_color
		$sqladd .= "footer_widget_style='Georgia, \"Times New Roman\", Times, serif', "; // footer_widget_style
		$sqladd .= "footer_link_color='7695b2', "; // footer_link_color
		$sqladd .= "footer_link_hover_color='7695b2', "; // footer_link_hover_color
		$sqladd .= "footer_link_hover_style='none', "; // footer_link_hover_style
		$sqladd .= "footer_height='250'"; // footer_height
		$sqladd .= " WHERE option_set = 1";
		$wpdb->query($sqladd);
		
		}$check = $wpdb->get_results("SELECT p_line FROM ".$wpdb->prefix."photocrati_styles WHERE option_set = 1");
		foreach ($check as $check) {
			$p_line = $check->p_line;
		}
		
		if($p_line == '' || $p_line == NULL) {
		
		$sqladd = "UPDATE ". $photocrati_styles . " SET ";
		$sqladd .= "p_line='20', "; 
		$sqladd .= "p_space='10'";
		$sqladd .= " WHERE option_set = 1";
		$wpdb->query($sqladd);
		
		}
	
	} else {
	
		$sql0 = "CREATE TABLE `". $photocrati_styles . "` ( ";
		$sql0 .= " `option_set` numeric NOT NULL, ";
		$sql0 .= " `dynamic_style` tinytext NOT NULL, ";
		$sql0 .= " `one_column` tinytext NOT NULL, ";
		$sql0 .= " `one_column_color` tinytext NOT NULL, ";
		$sql0 .= " `one_column_logo` tinytext NOT NULL, ";
		$sql0 .= " `one_column_margin` tinytext NOT NULL, ";
		$sql0 .= " `display_sidebar` tinytext NOT NULL, ";
		$sql0 .= " `content_width` tinytext NOT NULL, ";
		$sql0 .= " `sidebar_width` tinytext NOT NULL, ";
		$sql0 .= " `logo_menu_position` tinytext NOT NULL, ";
		$sql0 .= " `bg_color` tinytext NOT NULL, ";
		$sql0 .= " `bg_image` tinytext NOT NULL, ";
		$sql0 .= " `bg_repeat` tinytext NOT NULL, ";
		$sql0 .= " `header_bg_color` tinytext NOT NULL, ";
		$sql0 .= " `header_bg_image` tinytext NOT NULL, ";
		$sql0 .= " `header_bg_repeat` tinytext NOT NULL, ";
		$sql0 .= " `container_color` tinytext NOT NULL, ";
		$sql0 .= " `container_border` tinytext NOT NULL, ";
		$sql0 .= " `container_border_color` tinytext NOT NULL, ";
		$sql0 .= " `font_color` tinytext NOT NULL, ";
		$sql0 .= " `font_size` tinytext NOT NULL, ";
		$sql0 .= " `font_style` tinytext NOT NULL, ";
		$sql0 .= " `p_line` tinytext NOT NULL, ";
		$sql0 .= " `p_space` tinytext NOT NULL, ";
		$sql0 .= " `h1_color` tinytext NOT NULL, ";
		$sql0 .= " `h1_size` tinytext NOT NULL, ";
		$sql0 .= " `h1_font_style` tinytext NOT NULL, ";
		$sql0 .= " `h1_font_case` tinytext NOT NULL, ";
		$sql0 .= " `h1_font_weight` tinytext NOT NULL, ";
		$sql0 .= " `h1_font_align` tinytext NOT NULL, ";
		$sql0 .= " `h2_color` tinytext NOT NULL, ";
		$sql0 .= " `h2_size` tinytext NOT NULL, ";
		$sql0 .= " `h2_font_style` tinytext NOT NULL, ";
		$sql0 .= " `h2_font_case` tinytext NOT NULL, ";
		$sql0 .= " `h2_font_weight` tinytext NOT NULL, ";
		$sql0 .= " `h3_color` tinytext NOT NULL, ";
		$sql0 .= " `h3_size` tinytext NOT NULL, ";
		$sql0 .= " `h3_font_style` tinytext NOT NULL, ";
		$sql0 .= " `h3_font_case` tinytext NOT NULL, ";
		$sql0 .= " `h3_font_weight` tinytext NOT NULL, ";
		$sql0 .= " `h4_color` tinytext NOT NULL, ";
		$sql0 .= " `h4_size` tinytext NOT NULL, ";
		$sql0 .= " `h4_font_style` tinytext NOT NULL, ";
		$sql0 .= " `h4_font_case` tinytext NOT NULL, ";
		$sql0 .= " `h4_font_weight` tinytext NOT NULL, ";
		$sql0 .= " `h5_color` tinytext NOT NULL, ";
		$sql0 .= " `h5_size` tinytext NOT NULL, ";
		$sql0 .= " `h5_font_style` tinytext NOT NULL, ";
		$sql0 .= " `h5_font_case` tinytext NOT NULL, ";
		$sql0 .= " `h5_font_weight` tinytext NOT NULL, ";
		$sql0 .= " `link_color` tinytext NOT NULL, ";
		$sql0 .= " `link_hover_color` tinytext NOT NULL, ";
		$sql0 .= " `link_hover_style` tinytext NOT NULL, ";
		$sql0 .= " `sidebar_font_color` tinytext NOT NULL, ";
		$sql0 .= " `sidebar_font_size` tinytext NOT NULL, ";
		$sql0 .= " `sidebar_font_style` tinytext NOT NULL, ";
		$sql0 .= " `sidebar_bg_color` tinytext NOT NULL, ";
		$sql0 .= " `sidebar_link_color` tinytext NOT NULL, ";
		$sql0 .= " `sidebar_link_hover_color` tinytext NOT NULL, ";
		$sql0 .= " `sidebar_link_hover_style` tinytext NOT NULL, ";
		$sql0 .= " `sidebar_title_color` tinytext NOT NULL, ";
		$sql0 .= " `sidebar_title_size` tinytext NOT NULL, ";
		$sql0 .= " `sidebar_title_style` tinytext NOT NULL, ";
		$sql0 .= " `menu_style` tinytext NOT NULL, ";
		$sql0 .= " `menu_color` tinytext NOT NULL, ";
		$sql0 .= " `menu_hover_color` tinytext NOT NULL, ";
		$sql0 .= " `menu_font_size` tinytext NOT NULL, ";
		$sql0 .= " `menu_font_style` tinytext NOT NULL, ";
		$sql0 .= " `menu_font_color` tinytext NOT NULL, ";
		$sql0 .= " `menu_font_hover_color` tinytext NOT NULL, ";
		$sql0 .= " `menu_font_case` tinytext NOT NULL, ";
		$sql0 .= " `submenu_color` tinytext NOT NULL, ";
		$sql0 .= " `submenu_hover_color` tinytext NOT NULL, ";
		$sql0 .= " `submenu_font_size` tinytext NOT NULL, ";
		$sql0 .= " `submenu_font_style` tinytext NOT NULL, ";
		$sql0 .= " `submenu_font_color` tinytext NOT NULL, ";
		$sql0 .= " `submenu_font_hover_color` tinytext NOT NULL, ";
		$sql0 .= " `submenu_font_case` tinytext NOT NULL, ";
		$sql0 .= " `nextgen_border` tinytext NOT NULL, ";
		$sql0 .= " `nextgen_border_color` tinytext NOT NULL, ";
		$sql0 .= " `custom_logo` tinytext NOT NULL, ";
		$sql0 .= " `custom_logo_image` tinytext NOT NULL, ";
		$sql0 .= " `footer_copy` longtext NOT NULL, ";
		$sql0 .= " `custom_sidebar` tinytext NOT NULL, ";
		$sql0 .= " `custom_sidebar_position` tinytext NOT NULL, ";
		$sql0 .= " `custom_sidebar_html` longtext NOT NULL, ";
		$sql0 .= " `social_media` tinytext NOT NULL, ";
		$sql0 .= " `social_media_title` tinytext NOT NULL, ";
		$sql0 .= " `social_media_set` tinytext NOT NULL, ";
		$sql0 .= " `social_rss` tinytext NOT NULL, ";
		$sql0 .= " `social_email` longtext NOT NULL, ";
		$sql0 .= " `social_twitter` tinytext NOT NULL, ";
		$sql0 .= " `social_facebook` longtext NOT NULL, ";
		$sql0 .= " `social_flickr` longtext NOT NULL, ";
		$sql0 .= " `google_analytics` longtext NOT NULL, ";
		$sql0 .= " `custom_css` longtext NOT NULL, ";
		$sql0 .= " `preset_name` tinytext NOT NULL, ";
		$sql0 .= " `preset_title` tinytext NOT NULL, ";
		$sql0 .= " `header_height` tinytext NOT NULL, ";
		$sql0 .= " `header_logo_margin_above` tinytext NOT NULL, ";
		$sql0 .= " `header_logo_margin_below` tinytext NOT NULL, ";
		$sql0 .= " `title_size` tinytext NOT NULL, ";
		$sql0 .= " `title_color` tinytext NOT NULL, ";
		$sql0 .= " `title_font_style` tinytext NOT NULL, ";
		$sql0 .= " `title_font_weight` tinytext NOT NULL, ";
		$sql0 .= " `title_style` tinytext NOT NULL, ";
		$sql0 .= " `description_size` tinytext NOT NULL, ";
		$sql0 .= " `description_color` tinytext NOT NULL, ";
		$sql0 .= " `description_style` tinytext NOT NULL, ";
		$sql0 .= " `bg_top_offset` tinytext NOT NULL, ";
		$sql0 .= " `container_padding` tinytext NOT NULL, ";
		$sql0 .= " `footer_font` tinytext NOT NULL, ";
		$sql0 .= " `footer_font_color` tinytext NOT NULL, ";
		$sql0 .= " `custom_setting` tinytext NOT NULL, ";
		$sql0 .= " `footer_widget_placement` tinytext NOT NULL, ";
		$sql0 .= " `footer_background` tinytext NOT NULL, ";
		$sql0 .= " `footer_font_style` tinytext NOT NULL, ";
		$sql0 .= " `footer_widget_title` tinytext NOT NULL, ";
		$sql0 .= " `footer_widget_color` tinytext NOT NULL, ";
		$sql0 .= " `footer_widget_style` tinytext NOT NULL, ";
		$sql0 .= " `footer_link_color` tinytext NOT NULL, ";
		$sql0 .= " `footer_link_hover_color` tinytext NOT NULL, ";
		$sql0 .= " `footer_link_hover_style` tinytext NOT NULL, ";
		$sql0 .= " `footer_height` tinytext NOT NULL, ";
		$sql0 .= " `show_photocrati` tinytext NOT NULL, ";
		$sql0 .= " `page_comments` tinytext NOT NULL, ";
		$sql0 .= " `blog_meta` tinytext NOT NULL ";
		$sql0 .= ") ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1 ; ";
		
		require_once(ABSPATH . 'wp-admin/upgrade-functions.php');
		dbDelta($sql0);
		
		$sql1 = "INSERT INTO ". $photocrati_styles . " VALUES (";
		$sql1 .= "1 "; // option_set
		$sql1 .= ",'YES'"; // dynamic_style
		$sql1 .= ",'OFF'"; // one_column
		$sql1 .= ",'FFFFFF'"; // one_column_color
		$sql1 .= ",'OFF'"; // one_column_logo
		$sql1 .= ",'30'"; // one_column_margin
		$sql1 .= ",'YES'"; // display_sidebar
		$sql1 .= ",'70'"; // content_width
		$sql1 .= ",'30'"; // sidebar_width
		$sql1 .= ",'left-right'"; // logo_menu_position
		$sql1 .= ",'FFFFFF'"; // bg_color
		$sql1 .= ",''"; // bg_image
		$sql1 .= ",'repeat'"; // bg_repeat
		$sql1 .= ",'FFFFFF'"; // header_bg_color
		$sql1 .= ",''"; // header_bg_image
		$sql1 .= ",'repeat'"; // header_bg_repeat
		$sql1 .= ",'transparent'"; // container_color
		$sql1 .= ",'0'"; // container_border
		$sql1 .= ",'CCCCCC'"; // container_border_color
		$sql1 .= ",'666666'"; // font_color
		$sql1 .= ",'13'"; // font_size
		$sql1 .= ",'helvetica, arial, sans-serif'"; // font_style
		$sql1 .= ",'20'"; // p_line
		$sql1 .= ",'10'"; // p_space
		$sql1 .= ",'7695B2'"; // h1_color
		$sql1 .= ",'22'"; // h1_size
		$sql1 .= ",'\'G - Josefin Slab\', serif'"; // h1_font_style
		$sql1 .= ",''"; // h1_font_case
		$sql1 .= ",''"; // h1_font_weight
		$sql1 .= ",''"; // h1_font_align
		$sql1 .= ",'333333'"; // h2_color
		$sql1 .= ",'20'"; // h2_size
		$sql1 .= ",'\'G - Josefin Slab\', serif'"; // h2_font_style
		$sql1 .= ",''"; // h2_font_case
		$sql1 .= ",''"; // h2_font_weight
		$sql1 .= ",'333333'"; // h3_color
		$sql1 .= ",'18'"; // h3_size
		$sql1 .= ",'\'G - Josefin Slab\', serif'"; // h3_font_style
		$sql1 .= ",''"; // h3_font_case
		$sql1 .= ",''"; // h3_font_weight
		$sql1 .= ",'333333'"; // h4_color
		$sql1 .= ",'16'"; // h4_size
		$sql1 .= ",'\'G - Josefin Slab\', serif'"; // h4_font_style
		$sql1 .= ",''"; // h4_font_case
		$sql1 .= ",''"; // h4_font_weight
		$sql1 .= ",'333333'"; // h5_color
		$sql1 .= ",'14'"; // h5_size
		$sql1 .= ",'\'G - Josefin Slab\', serif'"; // h5_font_style
		$sql1 .= ",''"; // h5_font_case
		$sql1 .= ",''"; // h5_font_weight
		$sql1 .= ",'2B5780'"; // link_color
		$sql1 .= ",'266ead'"; // link_hover_color
		$sql1 .= ",'underline'"; // link_hover_style
		$sql1 .= ",'666666'"; // sidebar_font_color
		$sql1 .= ",'12'"; // sidebar_font_size
		$sql1 .= ",'Verdana, Arial, Helvetica, sans-serif'"; // sidebar_font_style
		$sql1 .= ",'transparent'"; // sidebar_bg_color
		$sql1 .= ",'2B5780'"; // sidebar_link_color
		$sql1 .= ",'2B5780'"; // sidebar_link_hover_color
		$sql1 .= ",'underline'"; // sidebar_link_hover_style
		$sql1 .= ",'333333'"; // sidebar_title_color
		$sql1 .= ",'14'"; // sidebar_title_size
		$sql1 .= ",'Arial, Helvetica, sans-serif'"; // sidebar_title_style
		$sql1 .= ",'transparent'"; // menu_style
		$sql1 .= ",'FFFFFF'"; // menu_color
		$sql1 .= ",'FFFFFF'"; // menu_hover_color
		$sql1 .= ",'12'"; // menu_font_size
		$sql1 .= ",'Arial, Helvetica, sans-serif'"; // menu_font_style
		$sql1 .= ",'A8A8A8'"; // menu_font_color
		$sql1 .= ",'2D73B6'"; // menu_font_hover_color
		$sql1 .= ",''"; // menu_font_case
		$sql1 .= ",'E8E8E8'"; // submenu_color
		$sql1 .= ",'C8C9CB'"; // submenu_hover_color
		$sql1 .= ",'12'"; // submenu_font_size
		$sql1 .= ",'Arial, Helvetica, sans-serif'"; // submenu_font_style
		$sql1 .= ",'484848'"; // submenu_font_color
		$sql1 .= ",'2D73B6'"; // submenu_font_hover_color
		$sql1 .= ",''"; // submenu_font_case
		$sql1 .= ",'5'"; // nextgen_border
		$sql1 .= ",'CCCCCC'"; // nextgen_border_color
		$sql1 .= ",'title'"; // custom_logo
		$sql1 .= ",'Logo_Steel.png'"; // custom_logo_image
		$sql1 .= ",''"; // footer_copy
		$sql1 .= ",'OFF'"; // custom_sidebar
		$sql1 .= ",'ABOVE'"; // custom_sidebar_position
		$sql1 .= ",''"; // custom_sidebar_html
		$sql1 .= ",'OFF'"; // social_media
		$sql1 .= ",'Follow Me'"; // social_media_title
		$sql1 .= ",'small'"; // social_media_set
		$sql1 .= ",''"; // social_rss
		$sql1 .= ",''"; // social_email
		$sql1 .= ",''"; // social_twitter
		$sql1 .= ",''"; // social_facebook
		$sql1 .= ",''"; // social_flickr
		$sql1 .= ",''"; // google_analytics
		$sql1 .= ",'p {
margin-bottom:0.5em;
}

#footer {
border-top:0 solid #E8E7E7;
text-align:center;
}'"; // custom_css
		$sql1 .= ",'preset-lightbox'"; // preset_name
		$sql1 .= ",'Photocrati Lightbox'"; // preset_title
		$sql1 .= ",'120'"; // header_height
		$sql1 .= ",'15'"; // header_logo_margin_above
		$sql1 .= ",'10'"; // header_logo_margin_below
		$sql1 .= ",'30'"; // title_size
		$sql1 .= ",'7695b2'"; // title_color
		$sql1 .= ",''"; // title_font_style
		$sql1 .= ",''"; // title_font_weight
		$sql1 .= ",'\'G - Josefin Slab\', serif'"; // title_style
		$sql1 .= ",'16'"; // description_size
		$sql1 .= ",'999999'"; // description_color
		$sql1 .= ",'\'G - Josefin Slab\', serif'"; // description_style
		$sql1 .= ",'0'"; // bg_top_offset
		$sql1 .= ",'10'"; // container_padding
		$sql1 .= ",'12'"; // footer_font
		$sql1 .= ",'333333'"; // footer_font_color
		$sql1 .= ",''"; // custom_setting
		$sql1 .= ",'3'"; // footer_widget_placement
		$sql1 .= ",'FFFFFF'"; // footer_background
		$sql1 .= ",'Georgia, \"Times New Roman\", Times, serif'"; // footer_font_style
		$sql1 .= ",'16'"; // footer_widget_title
		$sql1 .= ",'7695b2'"; // footer_widget_color
		$sql1 .= ",'Georgia, \"Times New Roman\", Times, serif'"; // footer_widget_style
		$sql1 .= ",'7695b2'"; // footer_link_color
		$sql1 .= ",'7695b2'"; // footer_link_hover_color
		$sql1 .= ",'none'"; // footer_link_hover_style
		$sql1 .= ",'250'"; // footer_height
		$sql1 .= ",''"; // show_photocrati
		$sql1 .= ",'OFF'"; // page_comments
		$sql1 .= ",''"; // blog_meta
		$sql1 .= ")";
		$wpdb->query($sql1);
		
	}
	

	// XXX disable 3 extra new themes as they're broken 'Zoom', 'Exposure' and 'Telephoto'
	$enable_extra_themes = false;
	$photocrati_presets = $table_prefix . "photocrati_presets";
	
    if($wpdb->get_var("show tables like '$photocrati_presets'") == $photocrati_presets) {
		
		add_column_if_not_exist($photocrati_presets, 'custom_setting', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_presets, 'one_column', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_presets, 'one_column_color', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_presets, 'one_column_logo', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_presets, 'one_column_margin', 'TINYTEXT NULL', '');
        add_column_if_not_exist($photocrati_presets, 'footer_widget_placement', 'TINYTEXT NULL', '');
        add_column_if_not_exist($photocrati_presets, 'footer_background', 'TINYTEXT NULL', '');
        add_column_if_not_exist($photocrati_presets, 'footer_font_style', 'TINYTEXT NULL', '');
        add_column_if_not_exist($photocrati_presets, 'footer_widget_title', 'TINYTEXT NULL', '');
        add_column_if_not_exist($photocrati_presets, 'footer_widget_color', 'TINYTEXT NULL', '');
        add_column_if_not_exist($photocrati_presets, 'footer_widget_style', 'TINYTEXT NULL', '');
        add_column_if_not_exist($photocrati_presets, 'footer_link_color', 'TINYTEXT NULL', '');
        add_column_if_not_exist($photocrati_presets, 'footer_link_hover_color', 'TINYTEXT NULL', '');
        add_column_if_not_exist($photocrati_presets, 'footer_link_hover_style', 'TINYTEXT NULL', '');
        add_column_if_not_exist($photocrati_presets, 'footer_height', 'TINYTEXT NULL', '');
        add_column_if_not_exist($photocrati_presets, 'page_comments', 'TINYTEXT NULL', '');
        add_column_if_not_exist($photocrati_presets, 'social_flickr', 'TINYTEXT NULL', '');
        add_column_if_not_exist($photocrati_presets, 'p_line', 'TINYTEXT NULL', '');
        add_column_if_not_exist($photocrati_presets, 'p_space', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_presets, 'h1_font_style', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_presets, 'h2_font_style', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_presets, 'h3_font_style', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_presets, 'h4_font_style', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_presets, 'h5_font_style', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_presets, 'h1_font_case', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_presets, 'h2_font_case', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_presets, 'h3_font_case', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_presets, 'h4_font_case', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_presets, 'h5_font_case', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_presets, 'h1_font_weight', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_presets, 'h2_font_weight', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_presets, 'h3_font_weight', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_presets, 'h4_font_weight', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_presets, 'h5_font_weight', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_presets, 'h1_font_align', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_presets, 'title_font_style', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_presets, 'title_font_weight', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_presets, 'menu_font_case', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_presets, 'submenu_font_case', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_presets, 'blog_meta', 'TINYTEXT NULL', '');
		add_column_if_not_exist($photocrati_presets, 'show_photocrati', 'TINYTEXT NULL', '');
	
		$sql = "ALTER TABLE " . $photocrati_presets . " CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
		$wpdb->query($sql);
	
		$sqladd = "UPDATE ". $photocrati_presets . " SET ";
		$sqladd .= "custom_setting='', "; // custom_setting
		$sqladd .= "one_column_color='FFFFFF', "; // one_column_color
		$sqladd .= "footer_widget_placement='3', "; // footer_widget_placement
		$sqladd .= "footer_background='000000', "; // footer_background
		$sqladd .= "footer_font_style='Georgia, \"Times New Roman\", Times, serif', "; // footer_font_style
		$sqladd .= "footer_widget_title='16', "; // footer_widget_title
		$sqladd .= "footer_widget_color='c78425', "; // footer_widget_color
		$sqladd .= "footer_widget_style='Georgia, \"Times New Roman\", Times, serif', "; // footer_widget_style
		$sqladd .= "footer_link_color='c78425', "; // footer_link_color
		$sqladd .= "footer_link_hover_color='c78425', "; // footer_link_hover_color
		$sqladd .= "footer_link_hover_style='none', "; // footer_link_hover_style
		$sqladd .= "footer_height='250'"; // footer_height
		$sqladd .= " WHERE preset_name = 'preset-fstop'";
		$wpdb->query($sqladd);
	
		$sqladd = "UPDATE ". $photocrati_presets . " SET ";
		$sqladd .= "custom_setting='', "; // custom_setting
		$sqladd .= "one_column_color='FFFFFF', "; // one_column_color
		$sqladd .= "footer_widget_placement='3', "; // footer_widget_placement
		$sqladd .= "footer_background='FFFFFF', "; // footer_background
		$sqladd .= "footer_font_style='Georgia, \"Times New Roman\", Times, serif', "; // footer_font_style
		$sqladd .= "footer_widget_title='16', "; // footer_widget_title
		$sqladd .= "footer_widget_color='b2d3b1', "; // footer_widget_color
		$sqladd .= "footer_widget_style='Georgia, \"Times New Roman\", Times, serif', "; // footer_widget_style
		$sqladd .= "footer_link_color='5da85b', "; // footer_link_color
		$sqladd .= "footer_link_hover_color='b2d3b1', "; // footer_link_hover_color
		$sqladd .= "footer_link_hover_style='none', "; // footer_link_hover_style
		$sqladd .= "footer_height='250'"; // footer_height
		$sqladd .= " WHERE preset_name = 'preset-emulsion'";
		$wpdb->query($sqladd);
	
		$sqladd = "UPDATE ". $photocrati_presets . " SET ";
		$sqladd .= "custom_setting='', "; // custom_setting
		$sqladd .= "one_column_color='FFFFFF', "; // one_column_color
		$sqladd .= "footer_widget_placement='3', "; // footer_widget_placement
		$sqladd .= "footer_background='42413F', "; // footer_background
		$sqladd .= "footer_font_style='Georgia, \"Times New Roman\", Times, serif', "; // footer_font_style
		$sqladd .= "footer_widget_title='16', "; // footer_widget_title
		$sqladd .= "footer_widget_color='bcd4eb', "; // footer_widget_color
		$sqladd .= "footer_widget_style='Georgia, \"Times New Roman\", Times, serif', "; // footer_widget_style
		$sqladd .= "footer_link_color='6197CA', "; // footer_link_color
		$sqladd .= "footer_link_hover_color='bcd4eb', "; // footer_link_hover_color
		$sqladd .= "footer_link_hover_style='none', "; // footer_link_hover_style
		$sqladd .= "footer_height='250'"; // footer_height
		$sqladd .= " WHERE preset_name = 'preset-signature'";
		$wpdb->query($sqladd);
	
		$sqladd = "UPDATE ". $photocrati_presets . " SET ";
		$sqladd .= "custom_setting='', "; // custom_setting
		$sqladd .= "one_column_color='FFFFFF', "; // one_column_color
		$sqladd .= "footer_widget_placement='3', "; // footer_widget_placement
		$sqladd .= "footer_background='000000', "; // footer_background
		$sqladd .= "footer_font_style='Georgia, \"Times New Roman\", Times, serif', "; // footer_font_style
		$sqladd .= "footer_widget_title='16', "; // footer_widget_title
		$sqladd .= "footer_widget_color='e6e6a1', "; // footer_widget_color
		$sqladd .= "footer_widget_style='Georgia, \"Times New Roman\", Times, serif', "; // footer_widget_style
		$sqladd .= "footer_link_color='e6e6a1', "; // footer_link_color
		$sqladd .= "footer_link_hover_color='e6e6a1', "; // footer_link_hover_color
		$sqladd .= "footer_link_hover_style='none', "; // footer_link_hover_style
		$sqladd .= "footer_height='250'"; // footer_height
		$sqladd .= " WHERE preset_name = 'preset-vignette'";
		$wpdb->query($sqladd);
	
		$sqladd = "UPDATE ". $photocrati_presets . " SET ";
		$sqladd .= "custom_setting='', "; // custom_setting
		$sqladd .= "one_column_color='FFFFFF', "; // one_column_color
		$sqladd .= "header_height='160', "; // header_height
		$sqladd .= "header_bg_image='', "; // header_bg_image
		$sqladd .= "header_bg_repeat='repeat', "; // header_bg_repeat
		$sqladd .= "footer_widget_placement='3', "; // footer_widget_placement
		$sqladd .= "footer_background='FFFFFF', "; // footer_background
		$sqladd .= "footer_font_style='Georgia, \"Times New Roman\", Times, serif', "; // footer_font_style
		$sqladd .= "footer_widget_title='16', "; // footer_widget_title
		$sqladd .= "footer_widget_color='c2adbd', "; // footer_widget_color
		$sqladd .= "footer_widget_style='Georgia, \"Times New Roman\", Times, serif', "; // footer_widget_style
		$sqladd .= "footer_link_color='e55070', "; // footer_link_color
		$sqladd .= "footer_link_hover_color='c2adbd', "; // footer_link_hover_color
		$sqladd .= "footer_link_hover_style='none', "; // footer_link_hover_style
		$sqladd .= "footer_height='250'"; // footer_height
		$sqladd .= " WHERE preset_name = 'preset-canvas'";
		$wpdb->query($sqladd);
	
		$sqladd = "UPDATE ". $photocrati_presets . " SET ";
		$sqladd .= "custom_setting='', "; // custom_setting
		$sqladd .= "one_column_color='FFFFFF', "; // one_column_color
		$sqladd .= "footer_widget_placement='3', "; // footer_widget_placement
		$sqladd .= "footer_background='FFFFFF', "; // footer_background
		$sqladd .= "footer_font_style='Georgia, \"Times New Roman\", Times, serif', "; // footer_font_style
		$sqladd .= "footer_widget_title='16', "; // footer_widget_title
		$sqladd .= "footer_widget_color='7695b2', "; // footer_widget_color
		$sqladd .= "footer_widget_style='Georgia, \"Times New Roman\", Times, serif', "; // footer_widget_style
		$sqladd .= "footer_link_color='7695b2', "; // footer_link_color
		$sqladd .= "footer_link_hover_color='7695b2', "; // footer_link_hover_color
		$sqladd .= "footer_link_hover_style='none', "; // footer_link_hover_style
		$sqladd .= "footer_height='250'"; // footer_height
		$sqladd .= " WHERE preset_name = 'preset-lightbox'";
		$wpdb->query($sqladd);
	
		$sqladd = "UPDATE ". $photocrati_presets . " SET ";
		$sqladd .= "custom_setting='', "; // custom_setting
		$sqladd .= "one_column_color='FFFFFF', "; // one_column_color
		$sqladd .= "footer_widget_placement='3', "; // footer_widget_placement
		$sqladd .= "footer_background='000000', "; // footer_background
		$sqladd .= "footer_font_style='Georgia, \"Times New Roman\", Times, serif', "; // footer_font_style
		$sqladd .= "footer_widget_title='16', "; // footer_widget_title
		$sqladd .= "footer_widget_color='8ca644', "; // footer_widget_color
		$sqladd .= "footer_widget_style='Georgia, \"Times New Roman\", Times, serif', "; // footer_widget_style
		$sqladd .= "footer_link_color='8ca644', "; // footer_link_color
		$sqladd .= "footer_link_hover_color='8ca644', "; // footer_link_hover_color
		$sqladd .= "footer_link_hover_style='none', "; // footer_link_hover_style
		$sqladd .= "footer_height='250'"; // footer_height
		$sqladd .= " WHERE preset_name = 'preset-darkroom'";
		$wpdb->query($sqladd);
	
		$sqladd = "UPDATE ". $photocrati_presets . " SET ";
		$sqladd .= "custom_setting='', "; // custom_setting
		$sqladd .= "one_column_color='FFFFFF', "; // one_column_color
		$sqladd .= "footer_widget_placement='3', "; // footer_widget_placement
		$sqladd .= "footer_background='24221f', "; // footer_background
		$sqladd .= "footer_font_style='Georgia, \"Times New Roman\", Times, serif', "; // footer_font_style
		$sqladd .= "footer_widget_title='16', "; // footer_widget_title
		$sqladd .= "footer_widget_color='637a8f', "; // footer_widget_color
		$sqladd .= "footer_widget_style='Georgia, \"Times New Roman\", Times, serif', "; // footer_widget_style
		$sqladd .= "footer_link_color='637a8f', "; // footer_link_color
		$sqladd .= "footer_link_hover_color='637a8f', "; // footer_link_hover_color
		$sqladd .= "footer_link_hover_style='none', "; // footer_link_hover_style
		$sqladd .= "footer_height='250'"; // footer_height
		$sqladd .= " WHERE preset_name = 'preset-exposure'";
		$wpdb->query($sqladd);
	
		$sqladd = "UPDATE ". $photocrati_presets . " SET ";
		$sqladd .= "footer_font_color = '333333', "; // footer_font_color
		$sqladd .= "custom_setting='', "; // custom_setting
		$sqladd .= "one_column_color='FFFFFF', "; // one_column_color
		$sqladd .= "footer_widget_placement='3', "; // footer_widget_placement
		$sqladd .= "footer_background='ebe8dd', "; // footer_background
		$sqladd .= "footer_font_style='Georgia, \"Times New Roman\", Times, serif', "; // footer_font_style
		$sqladd .= "footer_widget_title='16', "; // footer_widget_title
		$sqladd .= "footer_widget_color='ad9966', "; // footer_widget_color
		$sqladd .= "footer_widget_style='Georgia, \"Times New Roman\", Times, serif', "; // footer_widget_style
		$sqladd .= "footer_link_color='be3501', "; // footer_link_color
		$sqladd .= "footer_link_hover_color='ad9966', "; // footer_link_hover_color
		$sqladd .= "footer_link_hover_style='none', "; // footer_link_hover_style
		$sqladd .= "footer_height='250'"; // footer_height
		$sqladd .= " WHERE preset_name = 'preset-rangefinder'";
		$wpdb->query($sqladd);
	
		$sqladd = "UPDATE ". $photocrati_presets . " SET ";
		$sqladd .= "footer_font_color = '333333', "; // footer_font_color
		$sqladd .= "custom_setting='', "; // custom_setting
		$sqladd .= "one_column_color='FFFFFF', "; // one_column_color
		$sqladd .= "footer_widget_placement='3', "; // footer_widget_placement
		$sqladd .= "footer_background='FFFFFF', "; // footer_background
		$sqladd .= "footer_font_style='Georgia, \"Times New Roman\", Times, serif', "; // footer_font_style
		$sqladd .= "footer_widget_title='16', "; // footer_widget_title
		$sqladd .= "footer_widget_color='57697a', "; // footer_widget_color
		$sqladd .= "footer_widget_style='Georgia, \"Times New Roman\", Times, serif', "; // footer_widget_style
		$sqladd .= "footer_link_color='57697a', "; // footer_link_color
		$sqladd .= "footer_link_hover_color='57697a', "; // footer_link_hover_color
		$sqladd .= "footer_link_hover_style='none', "; // footer_link_hover_style
		$sqladd .= "footer_height='250'"; // footer_height
		$sqladd .= " WHERE preset_name = 'preset-polarized'";
		$wpdb->query($sqladd);
	
		$sqladd = "UPDATE ". $photocrati_presets . " SET ";
		$sqladd .= "footer_font_color = '333333', "; // footer_font_color
		$sqladd .= "custom_setting='', "; // custom_setting
		$sqladd .= "one_column_color='FFFFFF', "; // one_column_color
		$sqladd .= "footer_widget_placement='3', "; // footer_widget_placement
		$sqladd .= "footer_background='FFFFFF', "; // footer_background
		$sqladd .= "footer_font_style='Georgia, \"Times New Roman\", Times, serif', "; // footer_font_style
		$sqladd .= "footer_widget_title='16', "; // footer_widget_title
		$sqladd .= "footer_widget_color='d46b58', "; // footer_widget_color
		$sqladd .= "footer_widget_style='Georgia, \"Times New Roman\", Times, serif', "; // footer_widget_style
		$sqladd .= "footer_link_color='d46b58', "; // footer_link_color
		$sqladd .= "footer_link_hover_color='d46b58', "; // footer_link_hover_color
		$sqladd .= "footer_link_hover_style='none', "; // footer_link_hover_style
		$sqladd .= "footer_height='250'"; // footer_height
		$sqladd .= " WHERE preset_name = 'preset-wideangle'";
		$wpdb->query($sqladd);
	
		$sqladd = "UPDATE ". $photocrati_presets . " SET ";
		$sqladd .= "custom_setting='', "; // custom_setting
		$sqladd .= "one_column_color='FFFFFF', "; // one_column_color
		$sqladd .= "footer_widget_placement='3', "; // footer_widget_placement
		$sqladd .= "footer_background='000000', "; // footer_background
		$sqladd .= "footer_font_style='Georgia, \"Times New Roman\", Times, serif', "; // footer_font_style
		$sqladd .= "footer_widget_title='16', "; // footer_widget_title
		$sqladd .= "footer_widget_color='c9ac71', "; // footer_widget_color
		$sqladd .= "footer_widget_style='Georgia, \"Times New Roman\", Times, serif', "; // footer_widget_style
		$sqladd .= "footer_link_color='c9ac71', "; // footer_link_color
		$sqladd .= "footer_link_hover_color='c9ac71', "; // footer_link_hover_color
		$sqladd .= "footer_link_hover_style='none', "; // footer_link_hover_style
		$sqladd .= "footer_height='250'"; // footer_height
		$sqladd .= " WHERE preset_name = 'preset-silverhalide'";
		$wpdb->query($sqladd);
	
		$sqladd = "UPDATE ". $photocrati_presets . " SET ";
		$sqladd .= "footer_font_color = 'FFFFFF', "; // footer_font_color
		$sqladd .= "custom_setting='', "; // custom_setting
		$sqladd .= "one_column_color='FFFFFF', "; // one_column_color
		$sqladd .= "footer_widget_placement='3', "; // footer_widget_placement
		$sqladd .= "footer_background='2E2E2E', "; // footer_background
		$sqladd .= "footer_font_style='Georgia, \"Times New Roman\", Times, serif', "; // footer_font_style
		$sqladd .= "footer_widget_title='16', "; // footer_widget_title
		$sqladd .= "footer_widget_color='91995e', "; // footer_widget_color
		$sqladd .= "footer_widget_style='Georgia, \"Times New Roman\", Times, serif', "; // footer_widget_style
		$sqladd .= "footer_link_color='91995e', "; // footer_link_color
		$sqladd .= "footer_link_hover_color='91995e', "; // footer_link_hover_color
		$sqladd .= "footer_link_hover_style='none', "; // footer_link_hover_style
		$sqladd .= "footer_height='250'"; // footer_height
		$sqladd .= " WHERE preset_name = 'preset-filter'";
		$wpdb->query($sqladd);
	
		$sqladd = "UPDATE ". $photocrati_presets . " SET ";
		$sqladd .= "custom_setting='', "; // custom_setting
		$sqladd .= "one_column_color='FFFFFF', "; // one_column_color
		$sqladd .= "footer_widget_placement='3', "; // footer_widget_placement
		$sqladd .= "footer_background='FFFFFF', "; // footer_background
		$sqladd .= "footer_font_style='Georgia, \"Times New Roman\", Times, serif', "; // footer_font_style
		$sqladd .= "footer_widget_title='16', "; // footer_widget_title
		$sqladd .= "footer_widget_color='d6874e', "; // footer_widget_color
		$sqladd .= "footer_widget_style='Georgia, \"Times New Roman\", Times, serif', "; // footer_widget_style
		$sqladd .= "footer_link_color='d6874e', "; // footer_link_color
		$sqladd .= "footer_link_hover_color='d6874e', "; // footer_link_hover_color
		$sqladd .= "footer_link_hover_style='none', "; // footer_link_hover_style
		$sqladd .= "footer_height='250'"; // footer_height
		$sqladd .= " WHERE preset_name = 'preset-bokeh'";
		$wpdb->query($sqladd);
	
		$sqladd = "UPDATE ". $photocrati_presets . " SET ";
		$sqladd .= "custom_setting='', "; // custom_setting
		$sqladd .= "one_column_color='FFFFFF', "; // one_column_color
		$sqladd .= "footer_widget_placement='3', "; // footer_widget_placement
		$sqladd .= "footer_background='FFFFFF', "; // footer_background
		$sqladd .= "footer_font_style='Georgia, \"Times New Roman\", Times, serif', "; // footer_font_style
		$sqladd .= "footer_widget_title='16', "; // footer_widget_title
		$sqladd .= "footer_widget_color='d1a1ac', "; // footer_widget_color
		$sqladd .= "footer_widget_style='Georgia, \"Times New Roman\", Times, serif', "; // footer_widget_style
		$sqladd .= "footer_link_color='d1a1ac', "; // footer_link_color
		$sqladd .= "footer_link_hover_color='d1a1ac', "; // footer_link_hover_color
		$sqladd .= "footer_link_hover_style='none', "; // footer_link_hover_style
		$sqladd .= "footer_height='250'"; // footer_height
		$sqladd .= " WHERE preset_name = 'preset-prime'";
		$wpdb->query($sqladd);
		
		$preset_name = '';
		$check = $wpdb->get_results("SELECT preset_name FROM ".$wpdb->prefix."photocrati_presets WHERE preset_name = 'preset-zoom'");
		foreach ($check as $check) {
			$preset_name = $check->preset_name;
		}
		
		if($preset_name == '' && $enable_extra_themes) {
		
		$pre = "INSERT INTO ". $photocrati_presets . " VALUES (";
		$pre .= "1 "; // option_set
		$pre .= ",'YES'"; // dynamic_style
		$pre .= ",'ON'"; // one_column
		$pre .= ",'FFFFFF'"; // one_column_color
		$pre .= ",'OFF'"; // one_column_logo
		$pre .= ",'30'"; // one_column_margin
		$pre .= ",'NO'"; // display_sidebar
		$pre .= ",'100'"; // content_width
		$pre .= ",'0'"; // sidebar_width
		$pre .= ",'right-left'"; // logo_menu_position
		$pre .= ",'000000'"; // bg_color
		$pre .= ",'Circles_BG.gif'"; // bg_image
		$pre .= ",'repeat'"; // bg_repeat
		$pre .= ",'FFFFFF'"; // header_bg_color
		$pre .= ",'BlueScratchHeader_BG.jpg'"; // header_bg_image
		$pre .= ",'no-repeat'"; // header_bg_repeat
		$pre .= ",''"; // container_color
		$pre .= ",'0'"; // container_border
		$pre .= ",'CCCCCC'"; // container_border_color
		$pre .= ",'666666'"; // font_color
		$pre .= ",'13'"; // font_size
		$pre .= ",'\'G - PT Sans\', serif'"; // font_style
		$pre .= ",'20'"; // p_line
		$pre .= ",'10'"; // p_space
		$pre .= ",'D53900'"; // h1_color
		$pre .= ",'38'";  // h1_size
		$pre .= ",'\'G - Yanone Kaffeesatz\', serif'"; // h1_font_style
		$pre .= ",''"; // h1_font_case
		$pre .= ",'bold'";// h1_font_weight
		$pre .= ",''"; // h1_font_align
		$pre .= ",'D53900'"; // h2_color
		$pre .= ",'24'";  // h2_size
		$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // h2_font_style
		$pre .= ",''"; // h2_font_case
		$pre .= ",'bold'"; // h2_font_weight
		$pre .= ",'333333'"; // h3_color
		$pre .= ",'18'";  // h3_size
		$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // h3_font_style
		$pre .= ",''"; // h3_font_case
		$pre .= ",''"; // h3_font_weight
		$pre .= ",'333333'"; // h4_color
		$pre .= ",'16'";  // h4_size
		$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // h4_font_style
		$pre .= ",''"; // h4_font_case
		$pre .= ",''"; // h4_font_weight
		$pre .= ",'333333'"; // h5_color
		$pre .= ",'14'";  // h5_size
		$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // h5_font_style
		$pre .= ",''"; // h5_font_case
		$pre .= ",''"; // h5_font_weight
		$pre .= ",'2B5780'"; // link_color
		$pre .= ",'266ead'"; // link_hover_color
		$pre .= ",'underline'"; // link_hover_style
		$pre .= ",'666666'"; // sidebar_font_color
		$pre .= ",'12'"; // sidebar_font_size
		$pre .= ",'Verdana, Arial, Helvetica, sans-serif'"; // sidebar_font_style
		$pre .= ",'transparent'"; // sidebar_bg_color
		$pre .= ",'2B5780'"; // sidebar_link_color
		$pre .= ",'2B5780'"; // sidebar_link_hover_color
		$pre .= ",'underline'"; // sidebar_link_hover_style
		$pre .= ",'333333'"; // sidebar_title_color
		$pre .= ",'14'"; // sidebar_title_size
		$pre .= ",'Arial, Helvetica, sans-serif'"; // sidebar_title_style
		$pre .= ",'transparent'"; // menu_style
		$pre .= ",'E8E8E8'"; // menu_color
		$pre .= ",'C8C9CB'"; // menu_hover_color
		$pre .= ",'20'"; // menu_font_size
		$pre .= ",'\'G - Yanone Kaffeesatz\', serif'"; // menu_font_style
		$pre .= ",'A8A8A8'"; // menu_font_color
		$pre .= ",'d53800'"; // menu_font_hover_color
		$pre .= ",'uppercase'"; // menu_font_case
		$pre .= ",'E8E8E8'"; // submenu_color
		$pre .= ",'C8C9CB'"; // submenu_hover_color
		$pre .= ",'18'"; // submenu_font_size
		$pre .= ",'\'G - Yanone Kaffeesatz\', serif'"; // submenu_font_style
		$pre .= ",'484848'"; // submenu_font_color
		$pre .= ",'d53800'"; // submenu_font_hover_color
		$pre .= ",'uppercase'"; // submenu_font_case
		$pre .= ",'5'"; // nextgen_border
		$pre .= ",'e8e7e7'"; // nextgen_border_color
		$pre .= ",'title'"; // custom_logo
		$pre .= ",'Photocrati_LogoRed1.png'"; // custom_logo_image
		$pre .= ",''"; // footer_copy
		$pre .= ",'OFF'"; // custom_sidebar
		$pre .= ",'ABOVE'"; // custom_sidebar_position
		$pre .= ",''"; // custom_sidebar_html
		$pre .= ",'OFF'"; // social_media
		$pre .= ",'Follow Me'"; // social_media_title
		$pre .= ",'small'"; // social_media_set
		$pre .= ",''"; // social_rss
		$pre .= ",''"; // social_email
		$pre .= ",''"; // social_twitter
		$pre .= ",''"; // social_facebook
		$pre .= ",''"; // social_flickr
		$pre .= ",''"; // google_analytics
		$pre .= ",'a:hover, a:active {
text-decoration:none;
}

a:link, a:visited {
color:#D53900;
text-decoration:none;
}

p {
margin-bottom:0.5em;
}

h1, .entry-title {
clear:none;
padding-bottom:1px;
margin:20px 0 6px;
}

h2 {
clear:none;
padding-bottom:1px;
margin:20px 0 6px;
}

#main_container {
background: url(\"../images/uploads/BlueScratchBody2_BG.jpg\") no-repeat scroll center top #FFF;
margin:0 auto;
min-height:100%;
z-index:-1;
}

#container {
border:0 solid #CCCCCC;
float:left;
}

#content p, #content-sm p {
line-height:20px;
margin-bottom:20px;
margin-top:20px;
}

.menu a:hover, .menu a:active, .menu .current_page_item a:link, .menu .current_page_item a:visited {
font-weight:bold;
text-shadow: 1px 1px 1px #ffffff; filter: dropshadow(color=#ffffff, offx=1, offy=1), -1px -1px 1px #000000;
}

.menu a:link, .menu a:visited {
font-weight:bold;
padding:22px 15px 12px;
text-decoration:none;
text-shadow: 1px 1px 1px #ffffff; filter: dropshadow(color=#ffffff, offx=1, offy=1);
}

.sub-menu {
font-weight:bold;
text-shadow: 1px 1px 1px #ffffff; filter: dropshadow(color=#ffffff, offx=1, offy=1), -1px -1px 1px #000000;
}

.size-full, .entry-content img {
border:4px solid #FFF;
}

#footer {
border-top:0 solid #E8E7E7;
text-align:center;
}

#footer #site-info p  {
z-index:3;
font-size:10px;
text-transform:uppercase;
}'"; // custom_css
		$pre .= ",'preset-zoom'"; // preset_name
		$pre .= ",'Photocrati Zoom'"; // preset_title
		$pre .= ",'120'"; // header_height
		$pre .= ",'10'"; // header_logo_margin_above
		$pre .= ",'10'"; // header_logo_margin_below
		$pre .= ",'30'"; // title_size
		$pre .= ",'d53900'"; // title_color
		$pre .= ",''"; // title_font_style
		$pre .= ",''"; // title_font_weight
		$pre .= ",'\'G - Josefin Slab\', serif'"; // title_style
		$pre .= ",'16'"; // description_size
		$pre .= ",'999999'"; // description_color
		$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // description_style
		$pre .= ",'0'"; // bg_top_offset
		$pre .= ",'30'"; // container_padding
		$pre .= ",'12'"; // footer_font
		$pre .= ",'333333'"; // footer_font_color
		$pre .= ",''"; // custom_setting
		$pre .= ",'3'"; // footer_widget_placement
		$pre .= ",'FFFFFF'"; // footer_background
		$pre .= ",'\'G - PT Sans\', serif'"; // footer_font_style
		$pre .= ",'16'"; // footer_widget_title
		$pre .= ",'d53900'"; // footer_widget_color
		$pre .= ",'\'G - PT Sans\', serif'"; // footer_widget_style
		$pre .= ",'d53900'"; // footer_link_color
		$pre .= ",'ff4400'"; // footer_link_hover_color
		$pre .= ",'none'"; // footer_link_hover_style
		$pre .= ",'250'"; // footer_height
		$pre .= ",''"; // show_photocrati
		$pre .= ",'OFF'"; // page_comments
		$pre .= ",''"; // blog_meta
		$pre .= ")";
		$wpdb->query($pre);
		
		}
		
		$preset_name = '';
		$check = $wpdb->get_results("SELECT preset_name FROM ".$wpdb->prefix."photocrati_presets WHERE preset_name = 'preset-exposure2'");
		foreach ($check as $check) {
			$preset_name = $check->preset_name;
		}
		
		if($preset_name == '' && $enable_extra_themes) {
		
		$pre = "INSERT INTO ". $photocrati_presets . " VALUES (";
		$pre .= "1 "; // option_set
		$pre .= ",'YES'"; // dynamic_style
		$pre .= ",'ON'"; // one_column
		$pre .= ",'FFFFFF'"; // one_column_color
		$pre .= ",'ON'"; // one_column_logo



		$pre .= ",'30'"; // one_column_margin
		$pre .= ",'NO'"; // display_sidebar
		$pre .= ",'100'"; // content_width
		$pre .= ",'0'"; // sidebar_width
		$pre .= ",'top-bottom'"; // logo_menu_position
		$pre .= ",'333538'"; // bg_color
		$pre .= ",'DarkTileBG3.gif'"; // bg_image
		$pre .= ",'repeat'"; // bg_repeat
		$pre .= ",'2D96BB'"; // header_bg_color
		$pre .= ",''"; // header_bg_image
		$pre .= ",'no-repeat'"; // header_bg_repeat
		$pre .= ",'ffffff'"; // container_color
		$pre .= ",'0'"; // container_border
		$pre .= ",'CCCCCC'"; // container_border_color
		$pre .= ",'332c2c'"; // font_color
		$pre .= ",'13'"; // font_size
		$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // font_style
		$pre .= ",'22'"; // p_line
		$pre .= ",'20'"; // p_space
		$pre .= ",'4095ba'"; // h1_color
		$pre .= ",'38'";  // h1_size
		$pre .= ",'\'G - Yanone Kaffeesatz\', serif'"; // h1_font_style
		$pre .= ",''"; // h1_font_case
		$pre .= ",''";// h1_font_weight
		$pre .= ",''"; // h1_font_align
		$pre .= ",'4095ba'"; // h2_color
		$pre .= ",'32'";  // h2_size
		$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // h2_font_style
		$pre .= ",''"; // h2_font_case
		$pre .= ",''"; // h2_font_weight
		$pre .= ",'333333'"; // h3_color
		$pre .= ",'22'";  // h3_size
		$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // h3_font_style
		$pre .= ",''"; // h3_font_case
		$pre .= ",''"; // h3_font_weight
		$pre .= ",'333333'"; // h4_color
		$pre .= ",'16'";  // h4_size
		$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // h4_font_style
		$pre .= ",''"; // h4_font_case
		$pre .= ",''"; // h4_font_weight
		$pre .= ",'333333'"; // h5_color
		$pre .= ",'14'";  // h5_size
		$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // h5_font_style
		$pre .= ",''"; // h5_font_case
		$pre .= ",''"; // h5_font_weight
		$pre .= ",'4095ba'"; // link_color
		$pre .= ",'4ab7e6'"; // link_hover_color
		$pre .= ",'none'"; // link_hover_style
		$pre .= ",'666666'"; // sidebar_font_color
		$pre .= ",'12'"; // sidebar_font_size
		$pre .= ",'Verdana, Arial, Helvetica, sans-serif'"; // sidebar_font_style
		$pre .= ",'transparent'"; // sidebar_bg_color
		$pre .= ",'2B5780'"; // sidebar_link_color
		$pre .= ",'2B5780'"; // sidebar_link_hover_color
		$pre .= ",'underline'"; // sidebar_link_hover_style
		$pre .= ",'333333'"; // sidebar_title_color
		$pre .= ",'14'"; // sidebar_title_size
		$pre .= ",'Arial, Helvetica, sans-serif'"; // sidebar_title_style
		$pre .= ",'transparent'"; // menu_style
		$pre .= ",''"; // menu_color
		$pre .= ",'272e38'"; // menu_hover_color
		$pre .= ",'20'"; // menu_font_size
		$pre .= ",'\'G - Yanone Kaffeesatz\', serif'"; // menu_font_style
		$pre .= ",'e6e6e6'"; // menu_font_color
		$pre .= ",'ffffff'"; // menu_font_hover_color
		$pre .= ",'uppercase'"; // menu_font_case
		$pre .= ",'E8E8E8'"; // submenu_color
		$pre .= ",'6c92a6'"; // submenu_hover_color
		$pre .= ",'18'"; // submenu_font_size
		$pre .= ",'\'G - Yanone Kaffeesatz\', serif'"; // submenu_font_style
		$pre .= ",'484848'"; // submenu_font_color
		$pre .= ",'171d42'"; // submenu_font_hover_color
		$pre .= ",'uppercase'"; // submenu_font_case
		$pre .= ",'5'"; // nextgen_border
		$pre .= ",'e8e7e7'"; // nextgen_border_color
		$pre .= ",'custom'"; // custom_logo
		$pre .= ",'DarkTilePhotoHeader.jpg'"; // custom_logo_image
		$pre .= ",''"; // footer_copy
		$pre .= ",'OFF'"; // custom_sidebar
		$pre .= ",'ABOVE'"; // custom_sidebar_position
		$pre .= ",''"; // custom_sidebar_html
		$pre .= ",'OFF'"; // social_media
		$pre .= ",'Follow Me'"; // social_media_title
		$pre .= ",'small'"; // social_media_set
		$pre .= ",''"; // social_rss
		$pre .= ",''"; // social_email
		$pre .= ",''"; // social_twitter
		$pre .= ",''"; // social_facebook
		$pre .= ",''"; // social_flickr
		$pre .= ",''"; // google_analytics
		$pre .= ",'body {
background-position: top center;
}

h1, .entry-title {
clear:none;
padding-bottom:1px;
margin:20px 0 6px;
}

h3 {
clear:none;
border-top:1 dotted #E8E7E7;
font-size:22px;
}

.menu a:link, .menu a:visited {
padding:18px 17px 22px;
}

#blog-title img {
margin-top: -100px;
}

#menu_wrapper {
height:40px;
margin-top: -8px;
}

#menu_wrapper .menu {
text-align: left;
margin: 0 auto;
width: 960px;
}

#footer #site-info p  {
z-index:3;
font-size:10px;
text-transform:uppercase;
text-align:right;
}'"; // custom_css
		$pre .= ",'preset-exposure2'"; // preset_name
		$pre .= ",'Photocrati Exposure'"; // preset_title
		$pre .= ",'365'"; // header_height
		$pre .= ",'100'"; // header_logo_margin_above
		$pre .= ",'160'"; // header_logo_margin_below
		$pre .= ",'45'"; // title_size
		$pre .= ",'ffffff'"; // title_color
		$pre .= ",''"; // title_font_style
		$pre .= ",'bold'"; // title_font_weight
		$pre .= ",'\'G - Yanone Kaffeesatz\', serif'"; // title_style
		$pre .= ",'16'"; // description_size
		$pre .= ",'dbdbdb'"; // description_color
		$pre .= ",'\'G - Josefin Slab\', serif'"; // description_style
		$pre .= ",'0'"; // bg_top_offset
		$pre .= ",'10'"; // container_padding
		$pre .= ",'13'"; // footer_font
		$pre .= ",'362d2d'"; // footer_font_color
		$pre .= ",''"; // custom_setting
		$pre .= ",'4'"; // footer_widget_placement
		$pre .= ",'FFFFFF'"; // footer_background
		$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // footer_font_style
		$pre .= ",'16'"; // footer_widget_title
		$pre .= ",'4095ba'"; // footer_widget_color
		$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // footer_widget_style
		$pre .= ",'4095ba'"; // footer_link_color
		$pre .= ",'4ab7e6'"; // footer_link_hover_color
		$pre .= ",'none'"; // footer_link_hover_style
		$pre .= ",'275'"; // footer_height
		$pre .= ",''"; // show_photocrati
		$pre .= ",'OFF'"; // page_comments
		$pre .= ",''"; // blog_meta
		$pre .= ")";
		$wpdb->query($pre);
		
		}
		
		$preset_name = '';
		$check = $wpdb->get_results("SELECT preset_name FROM ".$wpdb->prefix."photocrati_presets WHERE preset_name = 'preset-telephoto'");
		foreach ($check as $check) {
			$preset_name = $check->preset_name;
		}
		
		if($preset_name == '' && $enable_extra_themes) {		
		
		$pre = "INSERT INTO ". $photocrati_presets . " VALUES (";
		$pre .= "1 "; // option_set
		$pre .= ",'YES'"; // dynamic_style
		$pre .= ",'ON'"; // one_column
		$pre .= ",'FFFFFF'"; // one_column_color
		$pre .= ",'ON'"; // one_column_logo
		$pre .= ",'0'"; // one_column_margin
		$pre .= ",'NO'"; // display_sidebar
		$pre .= ",'100'"; // content_width
		$pre .= ",'0'"; // sidebar_width
		$pre .= ",'top-bottom'"; // logo_menu_position
		$pre .= ",'312826'"; // bg_color
		$pre .= ",'WallpaperBG3.jpg'"; // bg_image
		$pre .= ",'repeat'"; // bg_repeat
		$pre .= ",'af3e11'"; // header_bg_color
		$pre .= ",''"; // header_bg_image
		$pre .= ",'no-repeat'"; // header_bg_repeat
		$pre .= ",'ffffff'"; // container_color
		$pre .= ",'0'"; // container_border
		$pre .= ",'CCCCCC'"; // container_border_color
		$pre .= ",'666666'"; // font_color
		$pre .= ",'13'"; // font_size
		$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // font_style
		$pre .= ",'20'"; // p_line
		$pre .= ",'10'"; // p_space
		$pre .= ",'a32b0f'"; // h1_color
		$pre .= ",'38'";  // h1_size
		$pre .= ",'\'G - Yanone Kaffeesatz\', serif'"; // h1_font_style
		$pre .= ",''"; // h1_font_case
		$pre .= ",''";// h1_font_weight
		$pre .= ",''"; // h1_font_align
		$pre .= ",'3d312c'"; // h2_color
		$pre .= ",'32'";  // h2_size
		$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // h2_font_style
		$pre .= ",''"; // h2_font_case
		$pre .= ",''"; // h2_font_weight
		$pre .= ",'3d312c'"; // h3_color
		$pre .= ",'22'";  // h3_size
		$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // h3_font_style
		$pre .= ",''"; // h3_font_case
		$pre .= ",''"; // h3_font_weight
		$pre .= ",'3d312c'"; // h4_color
		$pre .= ",'16'";  // h4_size
		$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // h4_font_style
		$pre .= ",''"; // h4_font_case
		$pre .= ",''"; // h4_font_weight
		$pre .= ",'3d312c'"; // h5_color
		$pre .= ",'14'";  // h5_size
		$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // h5_font_style
		$pre .= ",''"; // h5_font_case
		$pre .= ",''"; // h5_font_weight
		$pre .= ",'cc3300'"; // link_color
		$pre .= ",'ff4000'"; // link_hover_color
		$pre .= ",'none'"; // link_hover_style
		$pre .= ",'666666'"; // sidebar_font_color
		$pre .= ",'12'"; // sidebar_font_size
		$pre .= ",'Verdana, Arial, Helvetica, sans-serif'"; // sidebar_font_style
		$pre .= ",'transparent'"; // sidebar_bg_color
		$pre .= ",'2B5780'"; // sidebar_link_color
		$pre .= ",'2B5780'"; // sidebar_link_hover_color
		$pre .= ",'underline'"; // sidebar_link_hover_style
		$pre .= ",'333333'"; // sidebar_title_color
		$pre .= ",'14'"; // sidebar_title_size
		$pre .= ",'Arial, Helvetica, sans-serif'"; // sidebar_title_style
		$pre .= ",'transparent'"; // menu_style
		$pre .= ",'AF3F11'"; // menu_color
		$pre .= ",'96350f'"; // menu_hover_color
		$pre .= ",'20'"; // menu_font_size
		$pre .= ",'\'G - Yanone Kaffeesatz\', serif'"; // menu_font_style
		$pre .= ",'ff734f'"; // menu_font_color
		$pre .= ",'ffffff'"; // menu_font_hover_color
		$pre .= ",'uppercase'"; // menu_font_case
		$pre .= ",'E8E8E8'"; // submenu_color
		$pre .= ",'C8C9CB'"; // submenu_hover_color
		$pre .= ",'18'"; // submenu_font_size
		$pre .= ",'\'G - Yanone Kaffeesatz\', serif'"; // submenu_font_style
		$pre .= ",'484848'"; // submenu_font_color
		$pre .= ",'2D73B6'"; // submenu_font_hover_color
		$pre .= ",'uppercase'"; // submenu_font_case
		$pre .= ",'5'"; // nextgen_border
		$pre .= ",'e8e7e7'"; // nextgen_border_color
		$pre .= ",'custom'"; // custom_logo
		$pre .= ",'WallpaperHeader3.jpg'"; // custom_logo_image
		$pre .= ",''"; // footer_copy
		$pre .= ",'OFF'"; // custom_sidebar
		$pre .= ",'ABOVE'"; // custom_sidebar_position
		$pre .= ",''"; // custom_sidebar_html
		$pre .= ",'OFF'"; // social_media
		$pre .= ",'Follow Me'"; // social_media_title
		$pre .= ",'small'"; // social_media_set
		$pre .= ",''"; // social_rss
		$pre .= ",''"; // social_email
		$pre .= ",''"; // social_twitter
		$pre .= ",''"; // social_facebook
		$pre .= ",''"; // social_flickr
		$pre .= ",''"; // google_analytics
		$pre .= ",'body {
background-position: top center;
}

.entry-meta, .entry-utility {
margin-left:25px;
margin-top:20px;
}

h1, .entry-title {
clear:none;
padding-bottom:1px;
margin:20px 0 6px;
}

#blog-title img {
margin-top: -100px;
}

#menu_wrapper {
height: 27px;
margin-top:3px;
}

#menu_wrapper .menu {
width: 960px;
margin: 0 auto;
text-align: right;
}

.menu a:link, .menu a:visited {
padding:18px 18px 11px;
}

.menu ul {
line-height:2px;
}

.menu ul li ul {
line-height:18px;
}

#container {

}

#footer {
text-align:center;
}

#footer #site-info {
clear:both;
margin:5px 18px 0;
}

#footer #site-info p  {
font-size:10px;
margin-right:20px;
text-align:right;
text-transform:uppercase;
z-index:3;
}'"; // custom_css
		$pre .= ",'preset-telephoto'"; // preset_name
		$pre .= ",'Photocrati Telephoto'"; // preset_title
		$pre .= ",'364'"; // header_height
		$pre .= ",'100'"; // header_logo_margin_above
		$pre .= ",'0'"; // header_logo_margin_below
		$pre .= ",'45'"; // title_size
		$pre .= ",'ffffff'"; // title_color
		$pre .= ",''"; // title_font_style
		$pre .= ",'bold'"; // title_font_weight
		$pre .= ",'\'G - Yanone Kaffeesatz\', serif'"; // title_style
		$pre .= ",'16'"; // description_size
		$pre .= ",'dbdbdb'"; // description_color
		$pre .= ",'\'G - Josefin Slab\', serif'"; // description_style
		$pre .= ",'0'"; // bg_top_offset
		$pre .= ",'10'"; // container_padding
		$pre .= ",'13'"; // footer_font
		$pre .= ",'362d2d'"; // footer_font_color
		$pre .= ",''"; // custom_setting
		$pre .= ",'3'"; // footer_widget_placement
		$pre .= ",'FFFFFF'"; // footer_background
		$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // footer_font_style
		$pre .= ",'16'"; // footer_widget_title
		$pre .= ",'A32B0F'"; // footer_widget_color
		$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // footer_widget_style
		$pre .= ",'A32B0F'"; // footer_link_color
		$pre .= ",'ff4000'"; // footer_link_hover_color
		$pre .= ",'none'"; // footer_link_hover_style
		$pre .= ",'300'"; // footer_height
		$pre .= ",''"; // show_photocrati
		$pre .= ",'OFF'"; // page_comments
		$pre .= ",''"; // blog_meta
		$pre .= ")";
		$wpdb->query($pre);
		
		}
	
	} else {
	
		$sqlcopy = "CREATE TABLE `". $photocrati_presets . "` LIKE `". $photocrati_styles . "`";
		
		require_once(ABSPATH . 'wp-admin/upgrade-functions.php');
		dbDelta($sqlcopy);
		
		
		$pre = "INSERT INTO ". $photocrati_presets . " VALUES (";
		$pre .= "1 "; // option_set
		$pre .= ",'YES'"; // dynamic_style
		$pre .= ",'OFF'"; // one_column
		$pre .= ",'FFFFFF'"; // one_column_color
		$pre .= ",'OFF'"; // one_column_logo
		$pre .= ",'30'"; // one_column_margin
		$pre .= ",'YES'"; // display_sidebar
		$pre .= ",'70'"; // content_width
		$pre .= ",'30'"; // sidebar_width
		$pre .= ",'bottom-top'"; // logo_menu_position
		$pre .= ",'000000'"; // bg_color
		$pre .= ",''"; // bg_image
		$pre .= ",'repeat'"; // bg_repeat
		$pre .= ",'000000'"; // header_bg_color
		$pre .= ",''"; // header_bg_image
		$pre .= ",'repeat'"; // header_bg_repeat
		$pre .= ",'transparent'"; // container_color
		$pre .= ",'0'"; // container_border
		$pre .= ",'FFFFFF'"; // container_border_color
		$pre .= ",'FFFFFF'"; // font_color
		$pre .= ",'12'"; // font_size
		$pre .= ",'Arial, Helvetica, sans-serif'"; // font_style
		$pre .= ",'20'"; // p_line
		$pre .= ",'10'"; // p_space
		$pre .= ",'FFFFFF'"; // h1_color
		$pre .= ",'22'";  // h1_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h1_font_style
		$pre .= ",''"; // h1_font_case
		$pre .= ",''";// h1_font_weight
		$pre .= ",''"; // h1_font_align
		$pre .= ",'FFFFFF'"; // h2_color
		$pre .= ",'20'";  // h2_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h2_font_style
		$pre .= ",''"; // h2_font_case
		$pre .= ",''"; // h2_font_weight
		$pre .= ",'FFFFFF'"; // h3_color
		$pre .= ",'18'";  // h3_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h3_font_style
		$pre .= ",''"; // h3_font_case
		$pre .= ",''"; // h3_font_weight
		$pre .= ",'FFFFFF'"; // h4_color
		$pre .= ",'16'";  // h4_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h4_font_style
		$pre .= ",''"; // h4_font_case
		$pre .= ",''"; // h4_font_weight
		$pre .= ",'FFFFFF'"; // h5_color
		$pre .= ",'14'";  // h5_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h5_font_style
		$pre .= ",''"; // h5_font_case
		$pre .= ",''"; // h5_font_weight
		$pre .= ",'eb941a'"; // link_color
		$pre .= ",'ff6600'"; // link_hover_color
		$pre .= ",'none'"; // link_hover_style
		$pre .= ",'ababab'"; // sidebar_font_color
		$pre .= ",'12'"; // sidebar_font_size
		$pre .= ",'Arial, Helvetica, sans-serif'"; // sidebar_font_style
		$pre .= ",'transparent'"; // sidebar_bg_color
		$pre .= ",'eb941a'"; // sidebar_link_color
		$pre .= ",'ff6600'"; // sidebar_link_hover_color
		$pre .= ",'underline'"; // sidebar_link_hover_style
		$pre .= ",'b0854a'"; // sidebar_title_color
		$pre .= ",'14'"; // sidebar_title_size
		$pre .= ",'Arial, Helvetica, sans-serif'"; // sidebar_title_style
		$pre .= ",'color'"; // menu_style
		$pre .= ",'000000'"; // menu_color
		$pre .= ",'eb941a'"; // menu_hover_color
		$pre .= ",'12'"; // menu_font_size
		$pre .= ",'Arial, Helvetica, sans-serif'"; // menu_font_style
		$pre .= ",'FFFFFF'"; // menu_font_color
		$pre .= ",'704100'"; // menu_font_hover_color
		$pre .= ",''"; // menu_font_case
		$pre .= ",'474747'"; // submenu_color
		$pre .= ",'eb941a'"; // submenu_hover_color
		$pre .= ",'12'"; // submenu_font_size
		$pre .= ",'Arial, Helvetica, sans-serif'"; // submenu_font_style
		$pre .= ",'FFFFFF'"; // submenu_font_color
		$pre .= ",'704100'"; // submenu_font_hover_color
		$pre .= ",''"; // submenu_font_case
		$pre .= ",'5'"; // nextgen_border
		$pre .= ",'E1E1E1'"; // nextgen_border_color
		$pre .= ",'title'"; // custom_logo
		$pre .= ",'Logo_Orange2.png'"; // custom_logo_image
		$pre .= ",''"; // footer_copy
		$pre .= ",'OFF'"; // custom_sidebar
		$pre .= ",'ABOVE'"; // custom_sidebar_position
		$pre .= ",''"; // custom_sidebar_html
		$pre .= ",'OFF'"; // social_media
		$pre .= ",'Follow Me'"; // social_media_title
		$pre .= ",'small'"; // social_media_set
		$pre .= ",''"; // social_rss
		$pre .= ",''"; // social_email
		$pre .= ",''"; // social_twitter
		$pre .= ",''"; // social_facebook
		$pre .= ",''"; // social_flickr
		$pre .= ",''"; // google_analytics
		$pre .= ",'#footer {
border-top:0 solid #E8E7E7;
text-align:center;
}'"; // custom_css
		$pre .= ",'preset-fstop'"; // preset_name
		$pre .= ",'Photocrati F-Stop'"; // preset_title
		$pre .= ",'140'"; // header_height
		$pre .= ",'60'"; // header_logo_margin_above
		$pre .= ",'20'"; // header_logo_margin_below
		$pre .= ",'30'"; // title_size
		$pre .= ",'c78425'"; // title_color
		$pre .= ",''"; // title_font_style
		$pre .= ",''"; // title_font_weight
		$pre .= ",'\'G - Josefin Slab\', serif'"; // title_style
		$pre .= ",'16'"; // description_size
		$pre .= ",'b5b5b5'"; // description_color
		$pre .= ",'\'G - Josefin Slab\', serif'"; // description_style
		$pre .= ",'0'"; // bg_top_offset
		$pre .= ",'10'"; // container_padding
		$pre .= ",'12'"; // footer_font
		$pre .= ",'FFFFFF'"; // footer_font_color
		$pre .= ",''"; // custom_setting
		$pre .= ",'3'"; // footer_widget_placement
		$pre .= ",'000000'"; // footer_background
		$pre .= ",'Georgia, \"Times New Roman\", Times, serif'"; // footer_font_style
		$pre .= ",'16'"; // footer_widget_title
		$pre .= ",'c78425'"; // footer_widget_color
		$pre .= ",'Georgia, \"Times New Roman\", Times, serif'"; // footer_widget_style
		$pre .= ",'c78425'"; // footer_link_color
		$pre .= ",'c78425'"; // footer_link_hover_color
		$pre .= ",'none'"; // footer_link_hover_style
		$pre .= ",'250'"; // footer_height
		$pre .= ",''"; // show_photocrati
		$pre .= ",'OFF'"; // page_comments
		$pre .= ",''"; // blog_meta
		$pre .= ")";
		$wpdb->query($pre);
		
		
		$pre = "INSERT INTO ". $photocrati_presets . " VALUES (";
		$pre .= "1 "; // option_set
		$pre .= ",'YES'"; // dynamic_style
		$pre .= ",'OFF'"; // one_column
		$pre .= ",'FFFFFF'"; // one_column_color
		$pre .= ",'OFF'"; // one_column_logo
		$pre .= ",'30'"; // one_column_margin
		$pre .= ",'YES'"; // display_sidebar
		$pre .= ",'70'"; // content_width
		$pre .= ",'30'"; // sidebar_width
		$pre .= ",'bottom-top'"; // logo_menu_position
		$pre .= ",'FFFFFF'"; // bg_color
		$pre .= ",''"; // bg_image
		$pre .= ",'repeat'"; // bg_repeat
		$pre .= ",'FFFFFF'"; // header_bg_color
		$pre .= ",''"; // header_bg_image
		$pre .= ",'repeat'"; // header_bg_repeat
		$pre .= ",'transparent'"; // container_color
		$pre .= ",'0'"; // container_border
		$pre .= ",'666666'"; // container_border_color
		$pre .= ",'333333'"; // font_color
		$pre .= ",'12'"; // font_size
		$pre .= ",'helvetica, arial, sans-serif'"; // font_style
		$pre .= ",'20'"; // p_line
		$pre .= ",'10'"; // p_space
		$pre .= ",'333333'"; // h1_color
		$pre .= ",'22'";  // h1_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h1_font_style
		$pre .= ",''"; // h1_font_case
		$pre .= ",''";// h1_font_weight
		$pre .= ",''"; // h1_font_align
		$pre .= ",'333333'"; // h2_color
		$pre .= ",'20'";  // h2_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h2_font_style
		$pre .= ",''"; // h2_font_case
		$pre .= ",''"; // h2_font_weight
		$pre .= ",'333333'"; // h3_color
		$pre .= ",'18'";  // h3_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h3_font_style
		$pre .= ",''"; // h3_font_case
		$pre .= ",''"; // h3_font_weight
		$pre .= ",'333333'"; // h4_color
		$pre .= ",'16'";  // h4_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h4_font_style
		$pre .= ",''"; // h4_font_case
		$pre .= ",''"; // h4_font_weight
		$pre .= ",'333333'"; // h5_color
		$pre .= ",'14'";  // h5_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h5_font_style
		$pre .= ",''"; // h5_font_case
		$pre .= ",''"; // h5_font_weight
		$pre .= ",'5da85b'"; // link_color
		$pre .= ",'2ecc29'"; // link_hover_color
		$pre .= ",'none'"; // link_hover_style
		$pre .= ",'545454'"; // sidebar_font_color
		$pre .= ",'12'"; // sidebar_font_size
		$pre .= ",'helvetica, arial, sans-serif'"; // sidebar_font_style
		$pre .= ",'transparent'"; // sidebar_bg_color
		$pre .= ",'5da85b'"; // sidebar_link_color
		$pre .= ",'2ecc29'"; // sidebar_link_hover_color
		$pre .= ",'none'"; // sidebar_link_hover_style
		$pre .= ",'a6a6a6'"; // sidebar_title_color
		$pre .= ",'15'"; // sidebar_title_size
		$pre .= ",'helvetica, arial, sans-serif'"; // sidebar_title_style
		$pre .= ",'color'"; // menu_style
		$pre .= ",'FFFFFF'"; // menu_color
		$pre .= ",'E8E8EA'"; // menu_hover_color
		$pre .= ",'12'"; // menu_font_size
		$pre .= ",'helvetica, arial, sans-serif'"; // menu_font_style
		$pre .= ",'666666'"; // menu_font_color
		$pre .= ",'5da85b'"; // menu_font_hover_color
		$pre .= ",''"; // menu_font_case
		$pre .= ",'E8E8EA'"; // submenu_color
		$pre .= ",'b2d3b1'"; // submenu_hover_color
		$pre .= ",'12'"; // submenu_font_size
		$pre .= ",'helvetica, arial, sans-serif'"; // submenu_font_style
		$pre .= ",'5da85b'"; // submenu_font_color
		$pre .= ",'595959'"; // submenu_font_hover_color
		$pre .= ",''"; // submenu_font_case
		$pre .= ",'1'"; // nextgen_border
		$pre .= ",'CCCCCC'"; // nextgen_border_color
		$pre .= ",'title'"; // custom_logo
		$pre .= ",'Logo_Tall_Green.png'"; // custom_logo_image
		$pre .= ",''"; // footer_copy
		$pre .= ",'OFF'"; // custom_sidebar
		$pre .= ",'ABOVE'"; // custom_sidebar_position
		$pre .= ",''"; // custom_sidebar_html
		$pre .= ",'OFF'"; // social_media
		$pre .= ",'Follow Me'"; // social_media_title
		$pre .= ",'small'"; // social_media_set
		$pre .= ",''"; // social_rss
		$pre .= ",''"; // social_email
		$pre .= ",''"; // social_twitter
		$pre .= ",''"; // social_facebook
		$pre .= ",''"; // social_flickr
		$pre .= ",''"; // google_analytics
		$pre .= ",'#footer {
border-top:0 solid #E8E7E7;
text-align:center;
}

h1 {
border-bottom:0 solid #E1E1E1;
text-align:center;
}'"; // custom_css
		$pre .= ",'preset-emulsion'"; // preset_name
		$pre .= ",'Photocrati Emulsion'"; // preset_title
		$pre .= ",'140'"; // header_height
		$pre .= ",'60'"; // header_logo_margin_above
		$pre .= ",'20'"; // header_logo_margin_below
		$pre .= ",'30'"; // title_size
		$pre .= ",'b2d3b1'"; // title_color
		$pre .= ",''"; // title_font_style
		$pre .= ",''"; // title_font_weight
		$pre .= ",'\'G - Josefin Slab\', serif'"; // title_style
		$pre .= ",'16'"; // description_size
		$pre .= ",'999999'"; // description_color
		$pre .= ",'\'G - Josefin Slab\', serif'"; // description_style
		$pre .= ",'0'"; // bg_top_offset
		$pre .= ",'10'"; // container_padding
		$pre .= ",'12'"; // footer_font
		$pre .= ",'333333'"; // footer_font_color
		$pre .= ",''"; // custom_setting
		$pre .= ",'3'"; // footer_widget_placement
		$pre .= ",'FFFFFF'"; // footer_background
		$pre .= ",'Georgia, \"Times New Roman\", Times, serif'"; // footer_font_style
		$pre .= ",'16'"; // footer_widget_title
		$pre .= ",'b2d3b1'"; // footer_widget_color
		$pre .= ",'Georgia, \"Times New Roman\", Times, serif'"; // footer_widget_style
		$pre .= ",'5da85b'"; // footer_link_color
		$pre .= ",'b2d3b1'"; // footer_link_hover_color
		$pre .= ",'none'"; // footer_link_hover_style
		$pre .= ",'250'"; // footer_height
		$pre .= ",''"; // show_photocrati
		$pre .= ",'OFF'"; // page_comments
		$pre .= ",''"; // blog_meta
		$pre .= ")";
		$wpdb->query($pre);
		
		
		$pre = "INSERT INTO ". $photocrati_presets . " VALUES (";
		$pre .= "1 "; // option_set
		$pre .= ",'YES'"; // dynamic_style
		$pre .= ",'OFF'"; // one_column
		$pre .= ",'FFFFFF'"; // one_column_color
		$pre .= ",'OFF'"; // one_column_logo
		$pre .= ",'30'"; // one_column_margin
		$pre .= ",'YES'"; // display_sidebar
		$pre .= ",'70'"; // content_width
		$pre .= ",'30'"; // sidebar_width
		$pre .= ",'bottom-top'"; // logo_menu_position
		$pre .= ",'42413F'"; // bg_color
		$pre .= ",''"; // bg_image
		$pre .= ",'repeat'"; // bg_repeat
		$pre .= ",'42413F'"; // header_bg_color
		$pre .= ",''"; // header_bg_image
		$pre .= ",'repeat'"; // header_bg_repeat
		$pre .= ",'transparent'"; // container_color
		$pre .= ",'0'"; // container_border
		$pre .= ",'CCCCCC'"; // container_border_color
		$pre .= ",'F1F1F1'"; // font_color
		$pre .= ",'13'"; // font_size
		$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // font_style
		$pre .= ",'20'"; // p_line
		$pre .= ",'10'"; // p_space
		$pre .= ",'F0F0EE'"; // h1_color
		$pre .= ",'22'";  // h1_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h1_font_style
		$pre .= ",''"; // h1_font_case
		$pre .= ",''";// h1_font_weight
		$pre .= ",''"; // h1_font_align
		$pre .= ",'FFFFFF'"; // h2_color
		$pre .= ",'20'";  // h2_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h2_font_style
		$pre .= ",''"; // h2_font_case
		$pre .= ",''"; // h2_font_weight
		$pre .= ",'FFFFFF'"; // h3_color
		$pre .= ",'18'";  // h3_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h3_font_style
		$pre .= ",''"; // h3_font_case
		$pre .= ",''"; // h3_font_weight
		$pre .= ",'FFFFFF'"; // h4_color
		$pre .= ",'16'";  // h4_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h4_font_style
		$pre .= ",''"; // h4_font_case
		$pre .= ",''"; // h4_font_weight
		$pre .= ",'FFFFFF'"; // h5_color
		$pre .= ",'14'";  // h5_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h5_font_style
		$pre .= ",''"; // h5_font_case
		$pre .= ",''"; // h5_font_weight
		$pre .= ",'6197CA'"; // link_color
		$pre .= ",'1c84e6'"; // link_hover_color
		$pre .= ",'none'"; // link_hover_style
		$pre .= ",'a8a8a8'"; // sidebar_font_color
		$pre .= ",'12'"; // sidebar_font_size
		$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // sidebar_font_style
		$pre .= ",'transparent'"; // sidebar_bg_color
		$pre .= ",'6197CA'"; // sidebar_link_color
		$pre .= ",'3597f2'"; // sidebar_link_hover_color
		$pre .= ",'underline'"; // sidebar_link_hover_style
		$pre .= ",'bcd4eb'"; // sidebar_title_color
		$pre .= ",'16'"; // sidebar_title_size
		$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // sidebar_title_style
		$pre .= ",'color'"; // menu_style
		$pre .= ",'42413F'"; // menu_color
		$pre .= ",'666666'"; // menu_hover_color
		$pre .= ",'12'"; // menu_font_size
		$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // menu_font_style
		$pre .= ",'ffffff'"; // menu_font_color
		$pre .= ",'bcd4eb'"; // menu_font_hover_color
		$pre .= ",''"; // menu_font_case
		$pre .= ",'C2C2C2'"; // submenu_color
		$pre .= ",'A0A6AA'"; // submenu_hover_color
		$pre .= ",'12'"; // submenu_font_size
		$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // submenu_font_style
		$pre .= ",'1B1B1B'"; // submenu_font_color
		$pre .= ",'F0F0EE'"; // submenu_font_hover_color
		$pre .= ",''"; // submenu_font_case
		$pre .= ",'5'"; // nextgen_border
		$pre .= ",'E1E1E1'"; // nextgen_border_color
		$pre .= ",'title'"; // custom_logo
		$pre .= ",'Logo_Script_Blue.png'"; // custom_logo_image
		$pre .= ",''"; // footer_copy
		$pre .= ",'OFF'"; // custom_sidebar
		$pre .= ",'ABOVE'"; // custom_sidebar_position
		$pre .= ",''"; // custom_sidebar_html
		$pre .= ",'OFF'"; // social_media
		$pre .= ",'Follow Me'"; // social_media_title
		$pre .= ",'small'"; // social_media_set
		$pre .= ",''"; // social_rss
		$pre .= ",''"; // social_email
		$pre .= ",''"; // social_twitter
		$pre .= ",''"; // social_facebook
		$pre .= ",''"; // social_flickr
		$pre .= ",''"; // google_analytics
		$pre .= ",'#footer {
border-top:0;
text-align:center;
}

h1 {
border-bottom:0px;
}

p {
margin-bottom:0.5em;
}'"; // custom_css
		$pre .= ",'preset-signature'"; // preset_name
		$pre .= ",'Photocrati Signature'"; // preset_title
		$pre .= ",'140'"; // header_height
		$pre .= ",'60'"; // header_logo_margin_above
		$pre .= ",'20'"; // header_logo_margin_below
		$pre .= ",'30'"; // title_size
		$pre .= ",'bcd4eb'"; // title_color
		$pre .= ",''"; // title_font_style
		$pre .= ",''"; // title_font_weight
		$pre .= ",'\'G - Josefin Slab\', serif'"; // title_style
		$pre .= ",'16'"; // description_size
		$pre .= ",'CCCCCC'"; // description_color
		$pre .= ",'\'G - Josefin Slab\', serif'"; // description_style
		$pre .= ",'0'"; // bg_top_offset
		$pre .= ",'10'"; // container_padding
		$pre .= ",'12'"; // footer_font
		$pre .= ",'FFFFFF'"; // footer_font_color
		$pre .= ",''"; // custom_setting
		$pre .= ",'3'"; // footer_widget_placement
		$pre .= ",'42413F'"; // footer_background
		$pre .= ",'Georgia, \"Times New Roman\", Times, serif'"; // footer_font_style
		$pre .= ",'16'"; // footer_widget_title
		$pre .= ",'bcd4eb'"; // footer_widget_color
		$pre .= ",'Georgia, \"Times New Roman\", Times, serif'"; // footer_widget_style
		$pre .= ",'6197CA'"; // footer_link_color
		$pre .= ",'bcd4eb'"; // footer_link_hover_color
		$pre .= ",'none'"; // footer_link_hover_style
		$pre .= ",'250'"; // footer_height
		$pre .= ",''"; // show_photocrati
		$pre .= ",'OFF'"; // page_comments
		$pre .= ",''"; // blog_meta
		$pre .= ")";
		$wpdb->query($pre);
		
		
		$pre = "INSERT INTO ". $photocrati_presets . " VALUES (";
		$pre .= "1 "; // option_set
		$pre .= ",'YES'"; // dynamic_style
		$pre .= ",'OFF'"; // one_column
		$pre .= ",'FFFFFF'"; // one_column_color
		$pre .= ",'OFF'"; // one_column_logo
		$pre .= ",'30'"; // one_column_margin
		$pre .= ",'YES'"; // display_sidebar
		$pre .= ",'73'"; // content_width
		$pre .= ",'27'"; // sidebar_width
		$pre .= ",'right-left'"; // logo_menu_position
		$pre .= ",'067506'"; // bg_color
		$pre .= ",'Green_BG.jpg'"; // bg_image
		$pre .= ",'no-repeat'"; // bg_repeat
		$pre .= ",'000000'"; // header_bg_color
		$pre .= ",''"; // header_bg_image
		$pre .= ",'repeat'"; // header_bg_repeat
		$pre .= ",'e1e8d0'"; // container_color
		$pre .= ",'0'"; // container_border
		$pre .= ",'d9f5a2'"; // container_border_color
		$pre .= ",'000000'"; // font_color
		$pre .= ",'13'"; // font_size
		$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // font_style
		$pre .= ",'20'"; // p_line
		$pre .= ",'10'"; // p_space
		$pre .= ",'4a640b'"; // h1_color
		$pre .= ",'26'";  // h1_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h1_font_style
		$pre .= ",''"; // h1_font_case
		$pre .= ",''";// h1_font_weight
		$pre .= ",''"; // h1_font_align
		$pre .= ",'4a640b'"; // h2_color
		$pre .= ",'24'";  // h2_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h2_font_style
		$pre .= ",''"; // h2_font_case
		$pre .= ",''"; // h2_font_weight
		$pre .= ",'4a640b'"; // h3_color
		$pre .= ",'22'";  // h3_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h3_font_style
		$pre .= ",''"; // h3_font_case
		$pre .= ",''"; // h3_font_weight
		$pre .= ",'4a640b'"; // h4_color
		$pre .= ",'20'";  // h4_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h4_font_style
		$pre .= ",''"; // h4_font_case
		$pre .= ",''"; // h4_font_weight
		$pre .= ",'4a640b'"; // h5_color
		$pre .= ",'18'";  // h5_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h5_font_style
		$pre .= ",''"; // h5_font_case
		$pre .= ",''"; // h5_font_weight
		$pre .= ",'6ea34b'"; // link_color
		$pre .= ",'8bc714'"; // link_hover_color
		$pre .= ",'underline'"; // link_hover_style
		$pre .= ",'5c5c5c'"; // sidebar_font_color
		$pre .= ",'12'"; // sidebar_font_size
		$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // sidebar_font_style
		$pre .= ",'transparent'"; // sidebar_bg_color
		$pre .= ",'417e4a'"; // sidebar_link_color
		$pre .= ",'417e4a'"; // sidebar_link_hover_color
		$pre .= ",'underline'"; // sidebar_link_hover_style
		$pre .= ",'417e4a'"; // sidebar_title_color
		$pre .= ",'14'"; // sidebar_title_size
		$pre .= ",'Georgia, \"Times New Roman\", Times, serif'"; // sidebar_title_style
		$pre .= ",'color'"; // menu_style
		$pre .= ",'000000'"; // menu_color
		$pre .= ",'067506'"; // menu_hover_color
		$pre .= ",'13'"; // menu_font_size
		$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // menu_font_style
		$pre .= ",'ffffff'"; // menu_font_color
		$pre .= ",'fefeb9'"; // menu_font_hover_color
		$pre .= ",''"; // menu_font_case
		$pre .= ",'000000'"; // submenu_color
		$pre .= ",'067506'"; // submenu_hover_color
		$pre .= ",'12'"; // submenu_font_size
		$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // submenu_font_style
		$pre .= ",'FFFFFF'"; // submenu_font_color
		$pre .= ",'fefeb9'"; // submenu_font_hover_color
		$pre .= ",''"; // submenu_font_case
		$pre .= ",'5'"; // nextgen_border
		$pre .= ",'007401'"; // nextgen_border_color
		$pre .= ",'title'"; // custom_logo
		$pre .= ",'Logo_Shiny_Green.png'"; // custom_logo_image
		$pre .= ",''"; // footer_copy
		$pre .= ",'OFF'"; // custom_sidebar
		$pre .= ",'ABOVE'"; // custom_sidebar_position
		$pre .= ",''"; // custom_sidebar_html
		$pre .= ",'OFF'"; // social_media
		$pre .= ",'Follow Me'"; // social_media_title
		$pre .= ",'small'"; // social_media_set
		$pre .= ",''"; // social_rss
		$pre .= ",''"; // social_email
		$pre .= ",''"; // social_twitter
		$pre .= ",''"; // social_facebook
		$pre .= ",''"; // social_flickr
		$pre .= ",''"; // google_analytics
		$pre .= ",'.menu ul {
line-height:2;
}

.menu a:link, .menu a:visited {
padding:93px 17px 47px;
}

h1 {
border-bottom:0px;
}

h2 {
font-family:Georgia, Times, Sans Serif;
}

div.sidebar {
padding: 20px;
}

div.slideshow {
margin-bottom:20px;
}

p {
margin-bottom:0.5em;
line-height:1.9em;
}'"; // custom_css
		$pre .= ",'preset-vignette'"; // preset_name
		$pre .= ",'Photocrati Vignette'"; // preset_title
		$pre .= ",'120'"; // header_height
		$pre .= ",'15'"; // header_logo_margin_above
		$pre .= ",'10'"; // header_logo_margin_below
		$pre .= ",'30'"; // title_size
		$pre .= ",'e6e6a1'"; // title_color
		$pre .= ",''"; // title_font_style
		$pre .= ",''"; // title_font_weight
		$pre .= ",'\'G - Josefin Slab\', serif'"; // title_style
		$pre .= ",'16'"; // description_size
		$pre .= ",'b5b5b5'"; // description_color
		$pre .= ",'\'G - Josefin Slab\', serif'"; // description_style
		$pre .= ",'0'"; // bg_top_offset
		$pre .= ",'30'"; // container_padding
		$pre .= ",'12'"; // footer_font
		$pre .= ",'FFFFFF'"; // footer_font_color
		$pre .= ",''"; // custom_setting
		$pre .= ",'3'"; // footer_widget_placement
		$pre .= ",'000000'"; // footer_background
		$pre .= ",'Georgia, \"Times New Roman\", Times, serif'"; // footer_font_style
		$pre .= ",'16'"; // footer_widget_title
		$pre .= ",'e6e6a1'"; // footer_widget_color
		$pre .= ",'Georgia, \"Times New Roman\", Times, serif'"; // footer_widget_style
		$pre .= ",'e6e6a1'"; // footer_link_color
		$pre .= ",'e6e6a1'"; // footer_link_hover_color
		$pre .= ",'none'"; // footer_link_hover_style
		$pre .= ",'250'"; // footer_height
		$pre .= ",''"; // show_photocrati
		$pre .= ",'OFF'"; // page_comments
		$pre .= ",''"; // blog_meta
		$pre .= ")";
		$wpdb->query($pre);
		
		
		$pre = "INSERT INTO ". $photocrati_presets . " VALUES (";
		$pre .= "1 "; // option_set
		$pre .= ",'YES'"; // dynamic_style
		$pre .= ",'OFF'"; // one_column
		$pre .= ",'FFFFFF'"; // one_column_color
		$pre .= ",'OFF'"; // one_column_logo
		$pre .= ",'30'"; // one_column_margin
		$pre .= ",'N0'"; // display_sidebar
		$pre .= ",'100'"; // content_width
		$pre .= ",'30'"; // sidebar_width
		$pre .= ",'bottom-top'"; // logo_menu_position
		$pre .= ",'FFFFFF'"; // bg_color
		$pre .= ",'Muslin_BG.jpg'"; // bg_image
		$pre .= ",'repeat'"; // bg_repeat
		$pre .= ",'FFFFFF'"; // header_bg_color
		$pre .= ",''"; // header_bg_image
		$pre .= ",'repeat'"; // header_bg_repeat
		$pre .= ",'FFFFFF'"; // container_color
		$pre .= ",'0'"; // container_border
		$pre .= ",'666666'"; // container_border_color
		$pre .= ",'333333'"; // font_color
		$pre .= ",'14'"; // font_size
		$pre .= ",'Georgia, \"Times New Roman\", Times, serif'"; // font_style
		$pre .= ",'20'"; // p_line
		$pre .= ",'10'"; // p_space
		$pre .= ",'944C7D'"; // h1_color
		$pre .= ",'22'";  // h1_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h1_font_style
		$pre .= ",''"; // h1_font_case
		$pre .= ",''";// h1_font_weight
		$pre .= ",''"; // h1_font_align
		$pre .= ",'944C7D'"; // h2_color
		$pre .= ",'20'";  // h2_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h2_font_style
		$pre .= ",''"; // h2_font_case
		$pre .= ",''"; // h2_font_weight
		$pre .= ",'944C7D'"; // h3_color
		$pre .= ",'18'";  // h3_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h3_font_style
		$pre .= ",''"; // h3_font_case
		$pre .= ",''"; // h3_font_weight
		$pre .= ",'944C7D'"; // h4_color
		$pre .= ",'16'";  // h4_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h4_font_style
		$pre .= ",''"; // h4_font_case
		$pre .= ",''"; // h4_font_weight
		$pre .= ",'944C7D'"; // h5_color
		$pre .= ",'14'";  // h5_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h5_font_style
		$pre .= ",''"; // h5_font_case
		$pre .= ",''"; // h5_font_weight
		$pre .= ",'e65370'"; // link_color
		$pre .= ",'c2adbd'"; // link_hover_color
		$pre .= ",'none'"; // link_hover_style
		$pre .= ",'333333'"; // sidebar_font_color
		$pre .= ",'12'"; // sidebar_font_size
		$pre .= ",'Arial, Helvetica, sans-serif'"; // sidebar_font_style
		$pre .= ",'transparent'"; // sidebar_bg_color
		$pre .= ",'0072CB'"; // sidebar_link_color
		$pre .= ",'c2adbd'"; // sidebar_link_hover_color
		$pre .= ",'underline'"; // sidebar_link_hover_style
		$pre .= ",'333333'"; // sidebar_title_color
		$pre .= ",'14'"; // sidebar_title_size
		$pre .= ",'Arial, Helvetica, sans-serif'"; // sidebar_title_style
		$pre .= ",'color'"; // menu_style
		$pre .= ",'FFFFFF'"; // menu_color
		$pre .= ",'e3d6c6'"; // menu_hover_color
		$pre .= ",'12'"; // menu_font_size
		$pre .= ",'helvetica, arial, sans-serif'"; // menu_font_style
		$pre .= ",'995083'"; // menu_font_color
		$pre .= ",'e55070'"; // menu_font_hover_color
		$pre .= ",''"; // menu_font_case
		$pre .= ",'f5efe7'"; // submenu_color
		$pre .= ",'e3d6c6'"; // submenu_hover_color
		$pre .= ",'12'"; // submenu_font_size
		$pre .= ",'helvetica, arial, sans-serif'"; // submenu_font_style
		$pre .= ",'73604a'"; // submenu_font_color
		$pre .= ",'e55070'"; // submenu_font_hover_color
		$pre .= ",''"; // submenu_font_case
		$pre .= ",'0'"; // nextgen_border
		$pre .= ",'ffffff'"; // nextgen_border_color
		$pre .= ",'title'"; // custom_logo
		$pre .= ",'Logo_Fade_Pink.png'"; // custom_logo_image
		$pre .= ",''"; // footer_copy
		$pre .= ",'OFF'"; // custom_sidebar
		$pre .= ",'ABOVE'"; // custom_sidebar_position
		$pre .= ",''"; // custom_sidebar_html
		$pre .= ",'OFF'"; // social_media
		$pre .= ",'Follow Me'"; // social_media_title
		$pre .= ",'small'"; // social_media_set
		$pre .= ",''"; // social_rss
		$pre .= ",''"; // social_email
		$pre .= ",''"; // social_twitter
		$pre .= ",''"; // social_facebook
		$pre .= ",''"; // social_flickr
		$pre .= ",''"; // google_analytics
		$pre .= ",'.widget-title, .widgettitle {
       margin-top:5px;
}

.widget-title, .widgettitle {
color:#944C7D;
font-family:Georgia,Times,Serif;
font-size:17px;
font-weight:bold;
margin-bottom:21px;
}

p {
margin-bottom:2.5em;
}

.widget-title, .widgettitle {
padding:4px 0;
}

div.slideshow {
margin-bottom: 23px;
}'"; // custom_css
		$pre .= ",'preset-canvas'"; // preset_name
		$pre .= ",'Photocrati Canvas'"; // preset_title
		$pre .= ",'160'"; // header_height
		$pre .= ",'60'"; // header_logo_margin_above
		$pre .= ",'20'"; // header_logo_margin_below
		$pre .= ",'30'"; // title_size
		$pre .= ",'c2adbd'"; // title_color
		$pre .= ",''"; // title_font_style
		$pre .= ",''"; // title_font_weight
		$pre .= ",'\'G - Josefin Slab\', serif'"; // title_style
		$pre .= ",'16'"; // description_size
		$pre .= ",'999999'"; // description_color
		$pre .= ",'\'G - Josefin Slab\', serif'"; // description_style
		$pre .= ",'0'"; // bg_top_offset
		$pre .= ",'30'"; // container_padding
		$pre .= ",'12'"; // footer_font
		$pre .= ",'333333'"; // footer_font_color
		$pre .= ",''"; // custom_setting
		$pre .= ",'3'"; // footer_widget_placement
		$pre .= ",'FFFFFF'"; // footer_background
		$pre .= ",'Georgia, \"Times New Roman\", Times, serif'"; // footer_font_style
		$pre .= ",'16'"; // footer_widget_title
		$pre .= ",'c2adbd'"; // footer_widget_color
		$pre .= ",'Georgia, \"Times New Roman\", Times, serif'"; // footer_widget_style
		$pre .= ",'e55070'"; // footer_link_color
		$pre .= ",'c2adbd'"; // footer_link_hover_color
		$pre .= ",'none'"; // footer_link_hover_style
		$pre .= ",'250'"; // footer_height
		$pre .= ",''"; // show_photocrati
		$pre .= ",'OFF'"; // page_comments
		$pre .= ",''"; // blog_meta
		$pre .= ")";
		$wpdb->query($pre);
		
		
		$pre = "INSERT INTO ". $photocrati_presets . " VALUES (";
		$pre .= "1 "; // option_set
		$pre .= ",'YES'"; // dynamic_style
		$pre .= ",'OFF'"; // one_column
		$pre .= ",'FFFFFF'"; // one_column_color
		$pre .= ",'OFF'"; // one_column_logo
		$pre .= ",'30'"; // one_column_margin
		$pre .= ",'YES'"; // display_sidebar
		$pre .= ",'70'"; // content_width
		$pre .= ",'30'"; // sidebar_width
		$pre .= ",'left-right'"; // logo_menu_position
		$pre .= ",'FFFFFF'"; // bg_color
		$pre .= ",''"; // bg_image
		$pre .= ",'repeat'"; // bg_repeat
		$pre .= ",'FFFFFF'"; // header_bg_color
		$pre .= ",''"; // header_bg_image
		$pre .= ",'repeat'"; // header_bg_repeat
		$pre .= ",'transparent'"; // container_color
		$pre .= ",'0'"; // container_border
		$pre .= ",'CCCCCC'"; // container_border_color
		$pre .= ",'666666'"; // font_color
		$pre .= ",'13'"; // font_size
		$pre .= ",'helvetica, arial, sans-serif'"; // font_style
		$pre .= ",'20'"; // p_line
		$pre .= ",'10'"; // p_space
		$pre .= ",'7695B2'"; // h1_color
		$pre .= ",'22'";  // h1_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h1_font_style
		$pre .= ",''"; // h1_font_case
		$pre .= ",''";// h1_font_weight
		$pre .= ",''"; // h1_font_align
		$pre .= ",'333333'"; // h2_color
		$pre .= ",'20'";  // h2_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h2_font_style
		$pre .= ",''"; // h2_font_case
		$pre .= ",''"; // h2_font_weight
		$pre .= ",'333333'"; // h3_color
		$pre .= ",'18'";  // h3_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h3_font_style
		$pre .= ",''"; // h3_font_case
		$pre .= ",''"; // h3_font_weight
		$pre .= ",'333333'"; // h4_color
		$pre .= ",'16'";  // h4_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h4_font_style
		$pre .= ",''"; // h4_font_case
		$pre .= ",''"; // h4_font_weight
		$pre .= ",'333333'"; // h5_color
		$pre .= ",'14'";  // h5_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h5_font_style
		$pre .= ",''"; // h5_font_case
		$pre .= ",''"; // h5_font_weight
		$pre .= ",'2B5780'"; // link_color
		$pre .= ",'266ead'"; // link_hover_color
		$pre .= ",'underline'"; // link_hover_style
		$pre .= ",'666666'"; // sidebar_font_color
		$pre .= ",'12'"; // sidebar_font_size
		$pre .= ",'Verdana, Arial, Helvetica, sans-serif'"; // sidebar_font_style
		$pre .= ",'transparent'"; // sidebar_bg_color
		$pre .= ",'2B5780'"; // sidebar_link_color
		$pre .= ",'2B5780'"; // sidebar_link_hover_color
		$pre .= ",'underline'"; // sidebar_link_hover_style
		$pre .= ",'333333'"; // sidebar_title_color
		$pre .= ",'14'"; // sidebar_title_size
		$pre .= ",'Arial, Helvetica, sans-serif'"; // sidebar_title_style
		$pre .= ",'transparent'"; // menu_style
		$pre .= ",'FFFFFF'"; // menu_color
		$pre .= ",'FFFFFF'"; // menu_hover_color
		$pre .= ",'12'"; // menu_font_size
		$pre .= ",'Arial, Helvetica, sans-serif'"; // menu_font_style
		$pre .= ",'A8A8A8'"; // menu_font_color
		$pre .= ",'2D73B6'"; // menu_font_hover_color
		$pre .= ",''"; // menu_font_case
		$pre .= ",'E8E8E8'"; // submenu_color
		$pre .= ",'C8C9CB'"; // submenu_hover_color
		$pre .= ",'12'"; // submenu_font_size
		$pre .= ",'Arial, Helvetica, sans-serif'"; // submenu_font_style
		$pre .= ",'484848'"; // submenu_font_color
		$pre .= ",'2D73B6'"; // submenu_font_hover_color
		$pre .= ",''"; // submenu_font_case
		$pre .= ",'5'"; // nextgen_border
		$pre .= ",'CCCCCC'"; // nextgen_border_color
		$pre .= ",'title'"; // custom_logo
		$pre .= ",'Logo_Steel.png'"; // custom_logo_image
		$pre .= ",''"; // footer_copy
		$pre .= ",'OFF'"; // custom_sidebar
		$pre .= ",'ABOVE'"; // custom_sidebar_position
		$pre .= ",''"; // custom_sidebar_html
		$pre .= ",'OFF'"; // social_media
		$pre .= ",'Follow Me'"; // social_media_title
		$pre .= ",'small'"; // social_media_set
		$pre .= ",''"; // social_rss
		$pre .= ",''"; // social_email
		$pre .= ",''"; // social_twitter
		$pre .= ",''"; // social_facebook
		$pre .= ",''"; // social_flickr
		$pre .= ",''"; // google_analytics
		$pre .= ",'p {
margin-bottom:0.5em;
}

#footer {
border-top:0 solid #E8E7E7;
text-align:center;
}'"; // custom_css
		$pre .= ",'preset-lightbox'"; // preset_name
		$pre .= ",'Photocrati Lightbox'"; // preset_title
		$pre .= ",'120'"; // header_height
		$pre .= ",'25'"; // header_logo_margin_above
		$pre .= ",'10'"; // header_logo_margin_below
		$pre .= ",'30'"; // title_size
		$pre .= ",'7695b2'"; // title_color
		$pre .= ",''"; // title_font_style
		$pre .= ",''"; // title_font_weight
		$pre .= ",'\'G - Josefin Slab\', serif'"; // title_style
		$pre .= ",'16'"; // description_size
		$pre .= ",'999999'"; // description_color
		$pre .= ",'\'G - Josefin Slab\', serif'"; // description_style
		$pre .= ",'0'"; // bg_top_offset
		$pre .= ",'10'"; // container_padding
		$pre .= ",'12'"; // footer_font
		$pre .= ",'333333'"; // footer_font_color
		$pre .= ",''"; // custom_setting
		$pre .= ",'3'"; // footer_widget_placement
		$pre .= ",'FFFFFF'"; // footer_background
		$pre .= ",'Georgia, \"Times New Roman\", Times, serif'"; // footer_font_style
		$pre .= ",'16'"; // footer_widget_title
		$pre .= ",'7695b2'"; // footer_widget_color
		$pre .= ",'Georgia, \"Times New Roman\", Times, serif'"; // footer_widget_style
		$pre .= ",'7695b2'"; // footer_link_color
		$pre .= ",'7695b2'"; // footer_link_hover_color
		$pre .= ",'none'"; // footer_link_hover_style
		$pre .= ",'250'"; // footer_height
		$pre .= ",''"; // show_photocrati
		$pre .= ",'OFF'"; // page_comments
		$pre .= ",''"; // blog_meta
		$pre .= ")";
		$wpdb->query($pre);
		
		
		$pre = "INSERT INTO ". $photocrati_presets . " VALUES (";
		$pre .= "1 "; // option_set
		$pre .= ",'YES'"; // dynamic_style
		$pre .= ",'OFF'"; // one_column
		$pre .= ",'FFFFFF'"; // one_column_color
		$pre .= ",'OFF'"; // one_column_logo
		$pre .= ",'30'"; // one_column_margin
		$pre .= ",'YES'"; // display_sidebar
		$pre .= ",'70'"; // content_width
		$pre .= ",'30'"; // sidebar_width
		$pre .= ",'left-right'"; // logo_menu_position
		$pre .= ",'000000'"; // bg_color
		$pre .= ",''"; // bg_image
		$pre .= ",'repeat'"; // bg_repeat
		$pre .= ",'000000'"; // header_bg_color
		$pre .= ",''"; // header_bg_image
		$pre .= ",'repeat'"; // header_bg_repeat
		$pre .= ",'transparent'"; // container_color
		$pre .= ",'0'"; // container_border
		$pre .= ",'CCCCCC'"; // container_border_color
		$pre .= ",'F1F1F1'"; // font_color
		$pre .= ",'13'"; // font_size
		$pre .= ",'helvetica, arial, sans-serif'"; // font_style
		$pre .= ",'20'"; // p_line
		$pre .= ",'10'"; // p_space
		$pre .= ",'F0F0EE'"; // h1_color
		$pre .= ",'22'";  // h1_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h1_font_style
		$pre .= ",''"; // h1_font_case
		$pre .= ",''";// h1_font_weight
		$pre .= ",''"; // h1_font_align
		$pre .= ",'FFFFFF'"; // h2_color
		$pre .= ",'20'";  // h2_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h2_font_style
		$pre .= ",''"; // h2_font_case
		$pre .= ",''"; // h2_font_weight
		$pre .= ",'FFFFFF'"; // h3_color

		$pre .= ",'18'";  // h3_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h3_font_style
		$pre .= ",''"; // h3_font_case
		$pre .= ",''"; // h3_font_weight
		$pre .= ",'FFFFFF'"; // h4_color
		$pre .= ",'16'";  // h4_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h4_font_style
		$pre .= ",''"; // h4_font_case
		$pre .= ",''"; // h4_font_weight
		$pre .= ",'FFFFFF'"; // h5_color
		$pre .= ",'14'";  // h5_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h5_font_style
		$pre .= ",''"; // h5_font_case
		$pre .= ",''"; // h5_font_weight
		$pre .= ",'7c943b'"; // link_color
		$pre .= ",'a9e600'"; // link_hover_color
		$pre .= ",'underline'"; // link_hover_style
		$pre .= ",'F1F1F1'"; // sidebar_font_color
		$pre .= ",'12'"; // sidebar_font_size
		$pre .= ",'Verdana, Arial, Helvetica, sans-serif'"; // sidebar_font_style
		$pre .= ",'transparent'"; // sidebar_bg_color
		$pre .= ",'6197CA'"; // sidebar_link_color
		$pre .= ",'6197CA'"; // sidebar_link_hover_color
		$pre .= ",'underline'"; // sidebar_link_hover_style
		$pre .= ",'FFFFFF'"; // sidebar_title_color
		$pre .= ",'14'"; // sidebar_title_size
		$pre .= ",'Arial, Helvetica, sans-serif'"; // sidebar_title_style
		$pre .= ",'transparent'"; // menu_style
		$pre .= ",'000000'"; // menu_color
		$pre .= ",'000000'"; // menu_hover_color
		$pre .= ",'12'"; // menu_font_size
		$pre .= ",'helvetica, arial, sans-serif'"; // menu_font_style
		$pre .= ",'c2c2c2'"; // menu_font_color
		$pre .= ",'9ac22b'"; // menu_font_hover_color
		$pre .= ",''"; // menu_font_case
		$pre .= ",'bdbdbd'"; // submenu_color
		$pre .= ",'1F1F1F'"; // submenu_hover_color
		$pre .= ",'12'"; // submenu_font_size
		$pre .= ",'helvetica, arial, sans-serif'"; // submenu_font_style
		$pre .= ",'35382d'"; // submenu_font_color
		$pre .= ",'9ac22b'"; // submenu_font_hover_color
		$pre .= ",''"; // submenu_font_case
		$pre .= ",'5'"; // nextgen_border
		$pre .= ",'E1E1E1'"; // nextgen_border_color
		$pre .= ",'title'"; // custom_logo
		$pre .= ",'Logo_Stretch_Green.png'"; // custom_logo_image
		$pre .= ",''"; // footer_copy
		$pre .= ",'OFF'"; // custom_sidebar
		$pre .= ",'ABOVE'"; // custom_sidebar_position
		$pre .= ",''"; // custom_sidebar_html
		$pre .= ",'OFF'"; // social_media
		$pre .= ",'Follow Me'"; // social_media_title
		$pre .= ",'small'"; // social_media_set
		$pre .= ",''"; // social_rss
		$pre .= ",''"; // social_email
		$pre .= ",''"; // social_twitter
		$pre .= ",''"; // social_facebook
		$pre .= ",''"; // social_flickr
		$pre .= ",''"; // google_analytics
		$pre .= ",'p {
margin-bottom:0.5em;
}

h1 {
border-bottom:0px;
}

#footer {
border-top:0px;
}'"; // custom_css
		$pre .= ",'preset-darkroom'"; // preset_name
		$pre .= ",'Photocrati Darkroom'"; // preset_title
		$pre .= ",'120'"; // header_height
		$pre .= ",'15'"; // header_logo_margin_above
		$pre .= ",'10'"; // header_logo_margin_below
		$pre .= ",'30'"; // title_size
		$pre .= ",'8ca644'"; // title_color
		$pre .= ",''"; // title_font_style
		$pre .= ",''"; // title_font_weight
		$pre .= ",'\'G - Josefin Slab\', serif'"; // title_style
		$pre .= ",'16'"; // description_size
		$pre .= ",'b5b5b5'"; // description_color
		$pre .= ",'\'G - Josefin Slab\', serif'"; // description_style
		$pre .= ",'0'"; // bg_top_offset
		$pre .= ",'10'"; // container_padding
		$pre .= ",'12'"; // footer_font
		$pre .= ",'F1F1F1'"; // footer_font_color
		$pre .= ",''"; // custom_setting
		$pre .= ",'3'"; // footer_widget_placement
		$pre .= ",'000000'"; // footer_background
		$pre .= ",'Georgia, \"Times New Roman\", Times, serif'"; // footer_font_style
		$pre .= ",'16'"; // footer_widget_title
		$pre .= ",'8ca644'"; // footer_widget_color
		$pre .= ",'Georgia, \"Times New Roman\", Times, serif'"; // footer_widget_style
		$pre .= ",'8ca644'"; // footer_link_color
		$pre .= ",'8ca644'"; // footer_link_hover_color
		$pre .= ",'none'"; // footer_link_hover_style
		$pre .= ",'250'"; // footer_height
		$pre .= ",''"; // show_photocrati
		$pre .= ",'OFF'"; // page_comments
		$pre .= ",''"; // blog_meta
		$pre .= ")";
		$wpdb->query($pre);
		
		
		$pre = "INSERT INTO ". $photocrati_presets . " VALUES (";
		$pre .= "1 "; // option_set
		$pre .= ",'YES'"; // dynamic_style
		$pre .= ",'OFF'"; // one_column
		$pre .= ",'FFFFFF'"; // one_column_color
		$pre .= ",'OFF'"; // one_column_logo
		$pre .= ",'30'"; // one_column_margin
		$pre .= ",'YES'"; // display_sidebar
		$pre .= ",'70'"; // content_width
		$pre .= ",'30'"; // sidebar_width
		$pre .= ",'left-right'"; // logo_menu_position
		$pre .= ",'24221f'"; // bg_color
		$pre .= ",''"; // bg_image
		$pre .= ",'repeat'"; // bg_repeat
		$pre .= ",'24221f'"; // header_bg_color
		$pre .= ",''"; // header_bg_image
		$pre .= ",'repeat'"; // header_bg_repeat
		$pre .= ",'transparent'"; // container_color
		$pre .= ",'0'"; // container_border
		$pre .= ",'CCCCCC'"; // container_border_color
		$pre .= ",'F1F1F1'"; // font_color
		$pre .= ",'13'"; // font_size
		$pre .= ",'Tahoma, Trebuchet, Helvetica, sans-serif'"; // font_style
		$pre .= ",'20'"; // p_line
		$pre .= ",'10'"; // p_space
		$pre .= ",'F0F0EE'"; // h1_color
		$pre .= ",'22'";  // h1_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h1_font_style
		$pre .= ",''"; // h1_font_case
		$pre .= ",''";// h1_font_weight
		$pre .= ",''"; // h1_font_align
		$pre .= ",'FFFFFF'"; // h2_color
		$pre .= ",'20'";  // h2_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h2_font_style
		$pre .= ",''"; // h2_font_case
		$pre .= ",''"; // h2_font_weight
		$pre .= ",'FFFFFF'"; // h3_color
		$pre .= ",'18'";  // h3_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h3_font_style
		$pre .= ",''"; // h3_font_case
		$pre .= ",''"; // h3_font_weight
		$pre .= ",'FFFFFF'"; // h4_color
		$pre .= ",'16'";  // h4_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h4_font_style
		$pre .= ",''"; // h4_font_case
		$pre .= ",''"; // h4_font_weight
		$pre .= ",'FFFFFF'"; // h5_color
		$pre .= ",'14'";  // h5_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h5_font_style
		$pre .= ",''"; // h5_font_case
		$pre .= ",''"; // h5_font_weight
		$pre .= ",'6197CA'"; // link_color
		$pre .= ",'2993f5'"; // link_hover_color
		$pre .= ",'underline'"; // link_hover_style
		$pre .= ",'c2c2c2'"; // sidebar_font_color
		$pre .= ",'12'"; // sidebar_font_size
		$pre .= ",'Tahoma, Trebuchet, Helvetica, sans-serif'"; // sidebar_font_style
		$pre .= ",'transparent'"; // sidebar_bg_color
		$pre .= ",'6197CA'"; // sidebar_link_color
		$pre .= ",'2c92f2'"; // sidebar_link_hover_color
		$pre .= ",'underline'"; // sidebar_link_hover_style
		$pre .= ",'FFFFFF'"; // sidebar_title_color
		$pre .= ",'14'"; // sidebar_title_size
		$pre .= ",'Tahoma, Trebuchet, Helvetica, sans-serif'"; // sidebar_title_style
		$pre .= ",'transparent'"; // menu_style
		$pre .= ",'42413F'"; // menu_color
		$pre .= ",'42413F'"; // menu_hover_color
		$pre .= ",'12'"; // menu_font_size
		$pre .= ",'Tahoma, Trebuchet, Helvetica, sans-serif'"; // menu_font_style
		$pre .= ",'8C8C8C'"; // menu_font_color
		$pre .= ",'2f90eb'"; // menu_font_hover_color
		$pre .= ",''"; // menu_font_case
		$pre .= ",'999999'"; // submenu_color
		$pre .= ",'2f90eb'"; // submenu_hover_color
		$pre .= ",'12'"; // submenu_font_size
		$pre .= ",'Tahoma, Trebuchet, Helvetica, sans-serif'"; // submenu_font_style
		$pre .= ",'1B1B1B'"; // submenu_font_color
		$pre .= ",'F0F0EE'"; // submenu_font_hover_color
		$pre .= ",''"; // submenu_font_case
		$pre .= ",'5'"; // nextgen_border
		$pre .= ",'E1E1E1'"; // nextgen_border_color
		$pre .= ",'title'"; // custom_logo
		$pre .= ",'Logo_Bright_Blue.png'"; // custom_logo_image
		$pre .= ",''"; // footer_copy
		$pre .= ",'OFF'"; // custom_sidebar
		$pre .= ",'ABOVE'"; // custom_sidebar_position
		$pre .= ",''"; // custom_sidebar_html
		$pre .= ",'OFF'"; // social_media
		$pre .= ",'Follow Me'"; // social_media_title
		$pre .= ",'small'"; // social_media_set
		$pre .= ",''"; // social_rss
		$pre .= ",''"; // social_email
		$pre .= ",''"; // social_twitter
		$pre .= ",''"; // social_facebook
		$pre .= ",''"; // social_flickr
		$pre .= ",''"; // google_analytics
		$pre .= ",'#footer {
border-top:0 solid #E8E7E7;
text-align:center;
}

h1 {
border-bottom:0 solid #E1E1E1;
}'"; // custom_css
		$pre .= ",'preset-exposure'"; // preset_name
		$pre .= ",'Photocrati Exposure'"; // preset_title
		$pre .= ",'120'"; // header_height
		$pre .= ",'15'"; // header_logo_margin_above
		$pre .= ",'10'"; // header_logo_margin_below
		$pre .= ",'30'"; // title_size
		$pre .= ",'637a8f'"; // title_color
		$pre .= ",''"; // title_font_style
		$pre .= ",''"; // title_font_weight
		$pre .= ",'\'G - Josefin Slab\', serif'"; // title_style
		$pre .= ",'16'"; // description_size
		$pre .= ",'b5b5b5'"; // description_color
		$pre .= ",'\'G - Josefin Slab\', serif'"; // description_style
		$pre .= ",'0'"; // bg_top_offset
		$pre .= ",'10'"; // container_padding
		$pre .= ",'12'"; // footer_font
		$pre .= ",'F1F1F1'"; // footer_font_color
		$pre .= ",''"; // custom_setting
		$pre .= ",'3'"; // footer_widget_placement
		$pre .= ",'24221f'"; // footer_background
		$pre .= ",'Georgia, \"Times New Roman\", Times, serif'"; // footer_font_style
		$pre .= ",'16'"; // footer_widget_title
		$pre .= ",'637a8f'"; // footer_widget_color
		$pre .= ",'Georgia, \"Times New Roman\", Times, serif'"; // footer_widget_style
		$pre .= ",'637a8f'"; // footer_link_color
		$pre .= ",'637a8f'"; // footer_link_hover_color
		$pre .= ",'none'"; // footer_link_hover_style
		$pre .= ",'250'"; // footer_height
		$pre .= ",''"; // show_photocrati
		$pre .= ",'OFF'"; // page_comments
		$pre .= ",''"; // blog_meta
		$pre .= ")";
		$wpdb->query($pre);
		
		
		$pre = "INSERT INTO ". $photocrati_presets . " VALUES (";
		$pre .= "1 "; // option_set
		$pre .= ",'YES'"; // dynamic_style
		$pre .= ",'OFF'"; // one_column
		$pre .= ",'FFFFFF'"; // one_column_color
		$pre .= ",'OFF'"; // one_column_logo
		$pre .= ",'30'"; // one_column_margin
		$pre .= ",'YES'"; // display_sidebar
		$pre .= ",'70'"; // content_width
		$pre .= ",'30'"; // sidebar_width
		$pre .= ",'top-bottom'"; // logo_menu_position
		$pre .= ",'2f1c0b'"; // bg_color
		$pre .= ",'Wood_BG.jpg'"; // bg_image
		$pre .= ",'repeat-x'"; // bg_repeat
		$pre .= ",'ebe8dd'"; // header_bg_color
		$pre .= ",''"; // header_bg_image
		$pre .= ",'repeat'"; // header_bg_repeat
		$pre .= ",'transparent'"; // container_color
		$pre .= ",'0'"; // container_border
		$pre .= ",'CCCCCC'"; // container_border_color
		$pre .= ",'ebe8dd'"; // font_color
		$pre .= ",'13'"; // font_size
		$pre .= ",'helvetica, arial, sans-serif'"; // font_style
		$pre .= ",'20'"; // p_line
		$pre .= ",'10'"; // p_space
		$pre .= ",'ffffff'"; // h1_color
		$pre .= ",'24'";  // h1_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h1_font_style
		$pre .= ",''"; // h1_font_case
		$pre .= ",''";// h1_font_weight
		$pre .= ",''"; // h1_font_align
		$pre .= ",'d4c6a3'"; // h2_color
		$pre .= ",'20'";  // h2_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h2_font_style
		$pre .= ",''"; // h2_font_case
		$pre .= ",''"; // h2_font_weight
		$pre .= ",'ded7ca'"; // h3_color
		$pre .= ",'18'";  // h3_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h3_font_style
		$pre .= ",''"; // h3_font_case
		$pre .= ",''"; // h3_font_weight
		$pre .= ",'c5b383'"; // h4_color
		$pre .= ",'16'";  // h4_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h4_font_style
		$pre .= ",''"; // h4_font_case
		$pre .= ",''"; // h4_font_weight
		$pre .= ",'c5b383'"; // h5_color
		$pre .= ",'14'";  // h5_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h5_font_style
		$pre .= ",''"; // h5_font_case
		$pre .= ",''"; // h5_font_weight
		$pre .= ",'be3501'"; // link_color
		$pre .= ",'eb551e'"; // link_hover_color
		$pre .= ",'none'"; // link_hover_style
		$pre .= ",'c5b383'"; // sidebar_font_color
		$pre .= ",'12'"; // sidebar_font_size
		$pre .= ",'helvetica, arial, sans-serif'"; // sidebar_font_style
		$pre .= ",'transparent'"; // sidebar_bg_color
		$pre .= ",'be3501'"; // sidebar_link_color
		$pre .= ",'eb551e'"; // sidebar_link_hover_color
		$pre .= ",'underline'"; // sidebar_link_hover_style
		$pre .= ",'FFFFFF'"; // sidebar_title_color
		$pre .= ",'16'"; // sidebar_title_size
		$pre .= ",'helvetica, arial, sans-serif'"; // sidebar_title_style
		$pre .= ",'transparent'"; // menu_style
		$pre .= ",'FFFFFF'"; // menu_color
		$pre .= ",'FFFFFF'"; // menu_hover_color
		$pre .= ",'14'"; // menu_font_size
		$pre .= ",'helvetica, arial, sans-serif'"; // menu_font_style
		$pre .= ",'280b03'"; // menu_font_color
		$pre .= ",'be3501'"; // menu_font_hover_color
		$pre .= ",''"; // menu_font_case
		$pre .= ",'f5f3eb'"; // submenu_color
		$pre .= ",'ccc4a7'"; // submenu_hover_color
		$pre .= ",'12'"; // submenu_font_size
		$pre .= ",'helvetica, arial, sans-serif'"; // submenu_font_style
		$pre .= ",'280b03'"; // submenu_font_color
		$pre .= ",'be3501'"; // submenu_font_hover_color
		$pre .= ",''"; // submenu_font_case
		$pre .= ",'1'"; // nextgen_border
		$pre .= ",'f5f3ed'"; // nextgen_border_color
		$pre .= ",'title'"; // custom_logo
		$pre .= ",'Logo_Brown.png'"; // custom_logo_image
		$pre .= ",''"; // footer_copy
		$pre .= ",'OFF'"; // custom_sidebar
		$pre .= ",'ABOVE'"; // custom_sidebar_position
		$pre .= ",''"; // custom_sidebar_html
		$pre .= ",'OFF'"; // social_media
		$pre .= ",'Follow Me'"; // social_media_title
		$pre .= ",'small'"; // social_media_set
		$pre .= ",''"; // social_rss
		$pre .= ",''"; // social_email
		$pre .= ",''"; // social_twitter
		$pre .= ",''"; // social_facebook
		$pre .= ",''"; // social_flickr
		$pre .= ",''"; // google_analytics
		$pre .= ",'h1 {
     border-bottom: 0px;
     padding-top: 24px;

}

h2 {
     padding-top: 41px;
}

#menu_wrapper {
     margin-top: -7px;
}

.widget-title, .widgettitle {
     padding-top: 12px;
]

#footer {
     border-top: 0px;
}'"; // custom_css
		$pre .= ",'preset-rangefinder'"; // preset_name
		$pre .= ",'Photocrati Rangefinder'"; // preset_title
		$pre .= ",'140'"; // header_height
		$pre .= ",'5'"; // header_logo_margin_above
		$pre .= ",'20'"; // header_logo_margin_below
		$pre .= ",'30'"; // title_size
		$pre .= ",'ad9966'"; // title_color
		$pre .= ",''"; // title_font_style
		$pre .= ",''"; // title_font_weight
		$pre .= ",'\'G - Josefin Slab\', serif'"; // title_style
		$pre .= ",'16'"; // description_size
		$pre .= ",'666666'"; // description_color
		$pre .= ",'\'G - Josefin Slab\', serif'"; // description_style
		$pre .= ",'0'"; // bg_top_offset
		$pre .= ",'10'"; // container_padding
		$pre .= ",'12'"; // footer_font
		$pre .= ",'333333'"; // footer_font_color
		$pre .= ",''"; // custom_setting
		$pre .= ",'3'"; // footer_widget_placement
		$pre .= ",'ebe8dd'"; // footer_background
		$pre .= ",'Georgia, \"Times New Roman\", Times, serif'"; // footer_font_style
		$pre .= ",'16'"; // footer_widget_title
		$pre .= ",'ad9966'"; // footer_widget_color
		$pre .= ",'Georgia, \"Times New Roman\", Times, serif'"; // footer_widget_style
		$pre .= ",'be3501'"; // footer_link_color
		$pre .= ",'ad9966'"; // footer_link_hover_color
		$pre .= ",'none'"; // footer_link_hover_style
		$pre .= ",'250'"; // footer_height
		$pre .= ",''"; // show_photocrati
		$pre .= ",'OFF'"; // page_comments
		$pre .= ",''"; // blog_meta
		$pre .= ")";
		$wpdb->query($pre);
		
		
		$pre = "INSERT INTO ". $photocrati_presets . " VALUES (";
		$pre .= "1 "; // option_set
		$pre .= ",'YES'"; // dynamic_style
		$pre .= ",'OFF'"; // one_column
		$pre .= ",'FFFFFF'"; // one_column_color
		$pre .= ",'OFF'"; // one_column_logo
		$pre .= ",'30'"; // one_column_margin
		$pre .= ",'YES'"; // display_sidebar
		$pre .= ",'70'"; // content_width
		$pre .= ",'30'"; // sidebar_width
		$pre .= ",'left-right'"; // logo_menu_position
		$pre .= ",'000000'"; // bg_color
		$pre .= ",'Grille_BG.jpg'"; // bg_image
		$pre .= ",'repeat-x'"; // bg_repeat
		$pre .= ",'ffffff'"; // header_bg_color
		$pre .= ",''"; // header_bg_image
		$pre .= ",'repeat'"; // header_bg_repeat
		$pre .= ",'e3e3e3'"; // container_color
		$pre .= ",'9'"; // container_border
		$pre .= ",'fffcf7'"; // container_border_color
		$pre .= ",'423f3d'"; // font_color
		$pre .= ",'11'"; // font_size
		$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // font_style
		$pre .= ",'20'"; // p_line
		$pre .= ",'10'"; // p_space
		$pre .= ",'274a6b'"; // h1_color
		$pre .= ",'20'";  // h1_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h1_font_style
		$pre .= ",''"; // h1_font_case
		$pre .= ",''";// h1_font_weight
		$pre .= ",''"; // h1_font_align
		$pre .= ",'274a6b'"; // h2_color
		$pre .= ",'18'";  // h2_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h2_font_style
		$pre .= ",''"; // h2_font_case
		$pre .= ",''"; // h2_font_weight
		$pre .= ",'274a6b'"; // h3_color
		$pre .= ",'16'";  // h3_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h3_font_style
		$pre .= ",''"; // h3_font_case
		$pre .= ",''"; // h3_font_weight
		$pre .= ",'274a6b'"; // h4_color
		$pre .= ",'14'";  // h4_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h4_font_style
		$pre .= ",''"; // h4_font_case
		$pre .= ",''"; // h4_font_weight
		$pre .= ",'274a6b'"; // h5_color
		$pre .= ",'12'";  // h5_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h5_font_style
		$pre .= ",''"; // h5_font_case
		$pre .= ",''"; // h5_font_weight
		$pre .= ",'6197CA'"; // link_color
		$pre .= ",'61b3ff'"; // link_hover_color
		$pre .= ",'none'"; // link_hover_style
		$pre .= ",'383738'"; // sidebar_font_color
		$pre .= ",'12'"; // sidebar_font_size
		$pre .= ",'Georgia, \"Times New Roman\", Times, serif'"; // sidebar_font_style
		$pre .= ",'transparent'"; // sidebar_bg_color
		$pre .= ",'6197CA'"; // sidebar_link_color
		$pre .= ",'61b3ff'"; // sidebar_link_hover_color
		$pre .= ",'underline'"; // sidebar_link_hover_style
		$pre .= ",'274a6b'"; // sidebar_title_color
		$pre .= ",'14'"; // sidebar_title_size
		$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // sidebar_title_style
		$pre .= ",'transparent'"; // menu_style
		$pre .= ",'42413F'"; // menu_color
		$pre .= ",'42413F'"; // menu_hover_color
		$pre .= ",'11'"; // menu_font_size
		$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // menu_font_style
		$pre .= ",'8C8C8C'"; // menu_font_color
		$pre .= ",'6197ca'"; // menu_font_hover_color
		$pre .= ",''"; // menu_font_case
		$pre .= ",'6f7378'"; // submenu_color
		$pre .= ",'6197ca'"; // submenu_hover_color
		$pre .= ",'11'"; // submenu_font_size
		$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // submenu_font_style
		$pre .= ",'1B1B1B'"; // submenu_font_color
		$pre .= ",'ffffff'"; // submenu_font_hover_color
		$pre .= ",''"; // submenu_font_case
		$pre .= ",'5'"; // nextgen_border
		$pre .= ",'E1E1E1'"; // nextgen_border_color
		$pre .= ",'title'"; // custom_logo
		$pre .= ",'Logo_Steel.png'"; // custom_logo_image
		$pre .= ",''"; // footer_copy
		$pre .= ",'OFF'"; // custom_sidebar
		$pre .= ",'ABOVE'"; // custom_sidebar_position
		$pre .= ",''"; // custom_sidebar_html
		$pre .= ",'OFF'"; // social_media
		$pre .= ",'Follow Me'"; // social_media_title
		$pre .= ",'small'"; // social_media_set
		$pre .= ",''"; // social_rss
		$pre .= ",''"; // social_email
		$pre .= ",''"; // social_twitter
		$pre .= ",''"; // social_facebook
		$pre .= ",''"; // social_flickr
		$pre .= ",''"; // google_analytics
		$pre .= ",'.menu ul {
       line-height: 1.5em;
}

p {
margin-bottom:0.5em;
}'"; // custom_css
		$pre .= ",'preset-polarized'"; // preset_name
		$pre .= ",'Photocrati Polarized'"; // preset_title
		$pre .= ",'140'"; // header_height
		$pre .= ",'15'"; // header_logo_margin_above
		$pre .= ",'10'"; // header_logo_margin_below
		$pre .= ",'30'"; // title_size
		$pre .= ",'57697a'"; // title_color
		$pre .= ",''"; // title_font_style
		$pre .= ",''"; // title_font_weight
		$pre .= ",'\'G - Josefin Slab\', serif'"; // title_style
		$pre .= ",'16'"; // description_size
		$pre .= ",'999999'"; // description_color
		$pre .= ",'\'G - Josefin Slab\', serif'"; // description_style
		$pre .= ",'20'"; // bg_top_offset
		$pre .= ",'20'"; // container_padding
		$pre .= ",'12'"; // footer_font
		$pre .= ",'333333'"; // footer_font_color
		$pre .= ",''"; // custom_setting
		$pre .= ",'3'"; // footer_widget_placement
		$pre .= ",'FFFFFF'"; // footer_background
		$pre .= ",'Georgia, \"Times New Roman\", Times, serif'"; // footer_font_style
		$pre .= ",'16'"; // footer_widget_title
		$pre .= ",'57697a'"; // footer_widget_color
		$pre .= ",'Georgia, \"Times New Roman\", Times, serif'"; // footer_widget_style
		$pre .= ",'57697a'"; // footer_link_color
		$pre .= ",'57697a'"; // footer_link_hover_color
		$pre .= ",'none'"; // footer_link_hover_style
		$pre .= ",'250'"; // footer_height
		$pre .= ",''"; // show_photocrati
		$pre .= ",'OFF'"; // page_comments
		$pre .= ",''"; // blog_meta
		$pre .= ")";
		$wpdb->query($pre);
		
		
		$pre = "INSERT INTO ". $photocrati_presets . " VALUES (";
		$pre .= "1 "; // option_set
		$pre .= ",'YES'"; // dynamic_style
		$pre .= ",'OFF'"; // one_column
		$pre .= ",'FFFFFF'"; // one_column_color
		$pre .= ",'OFF'"; // one_column_logo
		$pre .= ",'30'"; // one_column_margin
		$pre .= ",'YES'"; // display_sidebar
		$pre .= ",'70'"; // content_width
		$pre .= ",'30'"; // sidebar_width
		$pre .= ",'left-right'"; // logo_menu_position
		$pre .= ",'000000'"; // bg_color
		$pre .= ",''"; // bg_image
		$pre .= ",'repeat'"; // bg_repeat
		$pre .= ",'ffffff'"; // header_bg_color
		$pre .= ",'header-bg.jpg'"; // header_bg_image
		$pre .= ",'repeat-x'"; // header_bg_repeat
		$pre .= ",'transparent'"; // container_color
		$pre .= ",'0'"; // container_border
		$pre .= ",'CCCCCC'"; // container_border_color
		$pre .= ",'E1E1E1'"; // font_color
		$pre .= ",'13'"; // font_size
		$pre .= ",'helvetica, arial, sans-serif'"; // font_style
		$pre .= ",'20'"; // p_line
		$pre .= ",'10'"; // p_space
		$pre .= ",'f09f8f'"; // h1_color
		$pre .= ",'22'";  // h1_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h1_font_style
		$pre .= ",''"; // h1_font_case
		$pre .= ",''";// h1_font_weight
		$pre .= ",''"; // h1_font_align
		$pre .= ",'FFFFFF'"; // h2_color
		$pre .= ",'20'";  // h2_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h2_font_style
		$pre .= ",''"; // h2_font_case
		$pre .= ",''"; // h2_font_weight
		$pre .= ",'FFFFFF'"; // h3_color
		$pre .= ",'18'";  // h3_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h3_font_style
		$pre .= ",''"; // h3_font_case
		$pre .= ",''"; // h3_font_weight
		$pre .= ",'FFFFFF'"; // h4_color
		$pre .= ",'16'";  // h4_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h4_font_style
		$pre .= ",''"; // h4_font_case
		$pre .= ",''"; // h4_font_weight
		$pre .= ",'FFFFFF'"; // h5_color
		$pre .= ",'14'";  // h5_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h5_font_style
		$pre .= ",''"; // h5_font_case
		$pre .= ",''"; // h5_font_weight
		$pre .= ",'995c53'"; // link_color
		$pre .= ",'d46b58'"; // link_hover_color
		$pre .= ",'none'"; // link_hover_style
		$pre .= ",'E1E1E1'"; // sidebar_font_color
		$pre .= ",'12'"; // sidebar_font_size
		$pre .= ",'helvetica, arial, sans-serif'"; // sidebar_font_style
		$pre .= ",'transparent'"; // sidebar_bg_color
		$pre .= ",'f09f8f'"; // sidebar_link_color
		$pre .= ",'d46b58'"; // sidebar_link_hover_color
		$pre .= ",'none'"; // sidebar_link_hover_style
		$pre .= ",'a8a8a8'"; // sidebar_title_color
		$pre .= ",'16'"; // sidebar_title_size
		$pre .= ",'helvetica, arial, sans-serif'"; // sidebar_title_style
		$pre .= ",'transparent'"; // menu_style
		$pre .= ",'FFFFFF'"; // menu_color
		$pre .= ",'FFFFFF'"; // menu_hover_color
		$pre .= ",'12'"; // menu_font_size
		$pre .= ",'helvetica, arial, sans-serif'"; // menu_font_style
		$pre .= ",'d4d4d4'"; // menu_font_color
		$pre .= ",'d46b58'"; // menu_font_hover_color
		$pre .= ",''"; // menu_font_case
		$pre .= ",'E8E8E8'"; // submenu_color
		$pre .= ",'d46b58'"; // submenu_hover_color
		$pre .= ",'12'"; // submenu_font_size
		$pre .= ",'helvetica, arial, sans-serif'"; // submenu_font_style
		$pre .= ",'995c53'"; // submenu_font_color
		$pre .= ",'ffffff'"; // submenu_font_hover_color
		$pre .= ",''"; // submenu_font_case
		$pre .= ",'5'"; // nextgen_border
		$pre .= ",'E1E1E1'"; // nextgen_border_color
		$pre .= ",'title'"; // custom_logo
		$pre .= ",'Logo_Melon.png'"; // custom_logo_image
		$pre .= ",''"; // footer_copy
		$pre .= ",'OFF'"; // custom_sidebar
		$pre .= ",'ABOVE'"; // custom_sidebar_position
		$pre .= ",''"; // custom_sidebar_html
		$pre .= ",'OFF'"; // social_media
		$pre .= ",'Follow Me'"; // social_media_title
		$pre .= ",'small'"; // social_media_set
		$pre .= ",''"; // social_rss
		$pre .= ",''"; // social_email
		$pre .= ",''"; // social_twitter
		$pre .= ",''"; // social_facebook
		$pre .= ",''"; // social_flickr
		$pre .= ",''"; // google_analytics
		$pre .= ",'#footer {
border-top:0;
text-align:center;
}

h1 {
border-bottom:0px;
}

p {
margin-bottom:0.5em;
line-height:1.7em;
}'"; // custom_css
		$pre .= ",'preset-wideangle'"; // preset_name
		$pre .= ",'Photocrati Wide Angle'"; // preset_title
		$pre .= ",'120'"; // header_height
		$pre .= ",'11'"; // header_logo_margin_above
		$pre .= ",'10'"; // header_logo_margin_below
		$pre .= ",'30'"; // title_size
		$pre .= ",'d46b58'"; // title_color
		$pre .= ",''"; // title_font_style
		$pre .= ",''"; // title_font_weight
		$pre .= ",'\'G - Josefin Slab\', serif'"; // title_style
		$pre .= ",'16'"; // description_size
		$pre .= ",'999999'"; // description_color
		$pre .= ",'\'G - Josefin Slab\', serif'"; // description_style
		$pre .= ",'0'"; // bg_top_offset
		$pre .= ",'20'"; // container_padding
		$pre .= ",'12'"; // footer_font
		$pre .= ",'333333'"; // footer_font_color
		$pre .= ",''"; // custom_setting
		$pre .= ",'3'"; // footer_widget_placement
		$pre .= ",'FFFFFF'"; // footer_background
		$pre .= ",'Georgia, \"Times New Roman\", Times, serif'"; // footer_font_style
		$pre .= ",'16'"; // footer_widget_title
		$pre .= ",'d46b58'"; // footer_widget_color
		$pre .= ",'Georgia, \"Times New Roman\", Times, serif'"; // footer_widget_style
		$pre .= ",'d46b58'"; // footer_link_color
		$pre .= ",'d46b58'"; // footer_link_hover_color
		$pre .= ",'none'"; // footer_link_hover_style
		$pre .= ",'250'"; // footer_height
		$pre .= ",''"; // show_photocrati
		$pre .= ",'OFF'"; // page_comments
		$pre .= ",''"; // blog_meta
		$pre .= ")";
		$wpdb->query($pre);
		
		
		$pre = "INSERT INTO ". $photocrati_presets . " VALUES (";
		$pre .= "1 "; // option_set
		$pre .= ",'YES'"; // dynamic_style
		$pre .= ",'OFF'"; // one_column
		$pre .= ",'FFFFFF'"; // one_column_color
		$pre .= ",'OFF'"; // one_column_logo
		$pre .= ",'30'"; // one_column_margin
		$pre .= ",'YES'"; // display_sidebar
		$pre .= ",'70'"; // content_width
		$pre .= ",'30'"; // sidebar_width
		$pre .= ",'left-right'"; // logo_menu_position
		$pre .= ",'FFFFFF'"; // bg_color
		$pre .= ",''"; // bg_image
		$pre .= ",'repeat'"; // bg_repeat
		$pre .= ",'000000'"; // header_bg_color
		$pre .= ",'header-bg-blk.jpg'"; // header_bg_image
		$pre .= ",'repeat-x'"; // header_bg_repeat
		$pre .= ",'transparent'"; // container_color
		$pre .= ",'0'"; // container_border
		$pre .= ",'CCCCCC'"; // container_border_color
		$pre .= ",'333333'"; // font_color
		$pre .= ",'12'"; // font_size
		$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // font_style
		$pre .= ",'20'"; // p_line
		$pre .= ",'10'"; // p_space
		$pre .= ",'786644'"; // h1_color
		$pre .= ",'22'";  // h1_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h1_font_style
		$pre .= ",''"; // h1_font_case
		$pre .= ",''";// h1_font_weight
		$pre .= ",''"; // h1_font_align
		$pre .= ",'333333'"; // h2_color
		$pre .= ",'20'";  // h2_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h2_font_style
		$pre .= ",''"; // h2_font_case
		$pre .= ",''"; // h2_font_weight
		$pre .= ",'333333'"; // h3_color
		$pre .= ",'18'";  // h3_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h3_font_style
		$pre .= ",''"; // h3_font_case
		$pre .= ",''"; // h3_font_weight
		$pre .= ",'333333'"; // h4_color
		$pre .= ",'16'";  // h4_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h4_font_style
		$pre .= ",''"; // h4_font_case
		$pre .= ",''"; // h4_font_weight
		$pre .= ",'333333'"; // h5_color
		$pre .= ",'14'";  // h5_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h5_font_style
		$pre .= ",''"; // h5_font_case
		$pre .= ",''"; // h5_font_weight
		$pre .= ",'cbb07b'"; // link_color
		$pre .= ",'e3cc9e'"; // link_hover_color
		$pre .= ",'none'"; // link_hover_style
		$pre .= ",'757375'"; // sidebar_font_color
		$pre .= ",'12'"; // sidebar_font_size
		$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // sidebar_font_style
		$pre .= ",'transparent'"; // sidebar_bg_color
		$pre .= ",'b39968'"; // sidebar_link_color
		$pre .= ",'f0d198'"; // sidebar_link_hover_color
		$pre .= ",'none'"; // sidebar_link_hover_style
		$pre .= ",'786644'"; // sidebar_title_color
		$pre .= ",'14'"; // sidebar_title_size
		$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // sidebar_title_style
		$pre .= ",'transparent'"; // menu_style
		$pre .= ",'000000'"; // menu_color
		$pre .= ",'000000'"; // menu_hover_color
		$pre .= ",'12'"; // menu_font_size
		$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // menu_font_style
		$pre .= ",'c9ac71'"; // menu_font_color
		$pre .= ",'d4d0d4'"; // menu_font_hover_color
		$pre .= ",''"; // menu_font_case
		$pre .= ",'333333'"; // submenu_color
		$pre .= ",'666666'"; // submenu_hover_color
		$pre .= ",'12'"; // submenu_font_size
		$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // submenu_font_style
		$pre .= ",'cbb07b'"; // submenu_font_color
		$pre .= ",'e3cc9e'"; // submenu_font_hover_color
		$pre .= ",''"; // submenu_font_case
		$pre .= ",'5'"; // nextgen_border
		$pre .= ",'CCCCCC'"; // nextgen_border_color
		$pre .= ",'title'"; // custom_logo
		$pre .= ",'Logo_Gold.png'"; // custom_logo_image
		$pre .= ",''"; // footer_copy
		$pre .= ",'OFF'"; // custom_sidebar
		$pre .= ",'ABOVE'"; // custom_sidebar_position
		$pre .= ",''"; // custom_sidebar_html
		$pre .= ",'OFF'"; // social_media
		$pre .= ",'Follow Me'"; // social_media_title
		$pre .= ",'small'"; // social_media_set
		$pre .= ",''"; // social_rss
		$pre .= ",''"; // social_email
		$pre .= ",''"; // social_twitter
		$pre .= ",''"; // social_facebook
		$pre .= ",''"; // social_flickr
		$pre .= ",''"; // google_analytics
		$pre .= ",'#footer {
border-top:0;
text-align:center;
}

h1 {
border-bottom:0px;
}

p {
margin-bottom:0.5em;
line-height:1.7em;
}'"; // custom_css
		$pre .= ",'preset-silverhalide'"; // preset_name
		$pre .= ",'Photocrati Silver Halide'"; // preset_title
		$pre .= ",'120'"; // header_height
		$pre .= ",'11'"; // header_logo_margin_above
		$pre .= ",'10'"; // header_logo_margin_below
		$pre .= ",'30'"; // title_size
		$pre .= ",'c9ac71'"; // title_color
		$pre .= ",''"; // title_font_style
		$pre .= ",''"; // title_font_weight
		$pre .= ",'\'G - Josefin Slab\', serif'"; // title_style
		$pre .= ",'16'"; // description_size
		$pre .= ",'b5b5b5'"; // description_color
		$pre .= ",'\'G - Josefin Slab\', serif'"; // description_style
		$pre .= ",'0'"; // bg_top_offset
		$pre .= ",'20'"; // container_padding
		$pre .= ",'12'"; // footer_font
		$pre .= ",'F1F1F1'"; // footer_font_color
		$pre .= ",''"; // custom_setting
		$pre .= ",'3'"; // footer_widget_placement
		$pre .= ",'000000'"; // footer_background
		$pre .= ",'Georgia, \"Times New Roman\", Times, serif'"; // footer_font_style
		$pre .= ",'16'"; // footer_widget_title
		$pre .= ",'c9ac71'"; // footer_widget_color
		$pre .= ",'Georgia, \"Times New Roman\", Times, serif'"; // footer_widget_style
		$pre .= ",'c9ac71'"; // footer_link_color
		$pre .= ",'c9ac71'"; // footer_link_hover_color
		$pre .= ",'none'"; // footer_link_hover_style
		$pre .= ",'250'"; // footer_height
		$pre .= ",''"; // show_photocrati
		$pre .= ",'OFF'"; // page_comments
		$pre .= ",''"; // blog_meta
		$pre .= ")";
		$wpdb->query($pre);
		
		
		$pre = "INSERT INTO ". $photocrati_presets . " VALUES (";
		$pre .= "1 "; // option_set
		$pre .= ",'YES'"; // dynamic_style
		$pre .= ",'OFF'"; // one_column
		$pre .= ",'FFFFFF'"; // one_column_color
		$pre .= ",'OFF'"; // one_column_logo
		$pre .= ",'30'"; // one_column_margin
		$pre .= ",'YES'"; // display_sidebar
		$pre .= ",'70'"; // content_width
		$pre .= ",'30'"; // sidebar_width
		$pre .= ",'left-right'"; // logo_menu_position
		$pre .= ",'a5a6a1'"; // bg_color
		$pre .= ",''"; // bg_image
		$pre .= ",'repeat'"; // bg_repeat
		$pre .= ",'2E2E2E'"; // header_bg_color
		$pre .= ",''"; // header_bg_image
		$pre .= ",'repeat-x'"; // header_bg_repeat
		$pre .= ",'transparent'"; // container_color
		$pre .= ",'0'"; // container_border
		$pre .= ",'CCCCCC'"; // container_border_color
		$pre .= ",'000000'"; // font_color
		$pre .= ",'12'"; // font_size
		$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // font_style
		$pre .= ",'20'"; // p_line
		$pre .= ",'10'"; // p_space
		$pre .= ",'565945'"; // h1_color
		$pre .= ",'22'";  // h1_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h1_font_style
		$pre .= ",''"; // h1_font_case
		$pre .= ",''";// h1_font_weight
		$pre .= ",''"; // h1_font_align
		$pre .= ",'737851'"; // h2_color
		$pre .= ",'20'";  // h2_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h2_font_style
		$pre .= ",''"; // h2_font_case
		$pre .= ",''"; // h2_font_weight
		$pre .= ",'000000'"; // h3_color
		$pre .= ",'18'";  // h3_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h3_font_style
		$pre .= ",''"; // h3_font_case
		$pre .= ",''"; // h3_font_weight
		$pre .= ",'000000'"; // h4_color
		$pre .= ",'16'";  // h4_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h4_font_style
		$pre .= ",''"; // h4_font_case
		$pre .= ",''"; // h4_font_weight
		$pre .= ",'000000'"; // h5_color
		$pre .= ",'14'";  // h5_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h5_font_style
		$pre .= ",''"; // h5_font_case
		$pre .= ",''"; // h5_font_weight
		$pre .= ",'91995e'"; // link_color
		$pre .= ",'94a683'"; // link_hover_color
		$pre .= ",'none'"; // link_hover_style
		$pre .= ",'424242'"; // sidebar_font_color
		$pre .= ",'12'"; // sidebar_font_size
		$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // sidebar_font_style
		$pre .= ",'transparent'"; // sidebar_bg_color
		$pre .= ",'91995e'"; // sidebar_link_color
		$pre .= ",'94a683'"; // sidebar_link_hover_color
		$pre .= ",'none'"; // sidebar_link_hover_style
		$pre .= ",'f1ffe3'"; // sidebar_title_color
		$pre .= ",'16'"; // sidebar_title_size
		$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // sidebar_title_style
		$pre .= ",'transparent'"; // menu_style
		$pre .= ",'2E2E2E'"; // menu_color
		$pre .= ",'2E2E2E'"; // menu_hover_color
		$pre .= ",'12'"; // menu_font_size
		$pre .= ",'Arial, Helvetica, sans-serif'"; // menu_font_style
		$pre .= ",'faffe3'"; // menu_font_color
		$pre .= ",'d4f52e'"; // menu_font_hover_color
		$pre .= ",''"; // menu_font_case
		$pre .= ",'999999'"; // submenu_color
		$pre .= ",'C8C9CB'"; // submenu_hover_color
		$pre .= ",'12'"; // submenu_font_size
		$pre .= ",'Arial, Helvetica, sans-serif'"; // submenu_font_style
		$pre .= ",'FFFFFF'"; // submenu_font_color
		$pre .= ",'333333'"; // submenu_font_hover_color
		$pre .= ",''"; // submenu_font_case
		$pre .= ",'5'"; // nextgen_border
		$pre .= ",'E1E1E1'"; // nextgen_border_color
		$pre .= ",'title'"; // custom_logo
		$pre .= ",'Logo_Lime.png'"; // custom_logo_image
		$pre .= ",''"; // footer_copy
		$pre .= ",'OFF'"; // custom_sidebar
		$pre .= ",'ABOVE'"; // custom_sidebar_position
		$pre .= ",''"; // custom_sidebar_html
		$pre .= ",'OFF'"; // social_media
		$pre .= ",'Follow Me'"; // social_media_title
		$pre .= ",'small'"; // social_media_set
		$pre .= ",''"; // social_rss
		$pre .= ",''"; // social_email
		$pre .= ",''"; // social_twitter
		$pre .= ",''"; // social_facebook
		$pre .= ",''"; // social_flickr
		$pre .= ",''"; // google_analytics
		$pre .= ",'#footer {
border-top:0;
text-align:right;
}

h1 {
border-bottom:0px;
}

p {
margin-bottom:0.5em;
line-height:1.7em;
}'"; // custom_css
		$pre .= ",'preset-filter'"; // preset_name
		$pre .= ",'Photocrati Filter'"; // preset_title
		$pre .= ",'120'"; // header_height
		$pre .= ",'15'"; // header_logo_margin_above
		$pre .= ",'10'"; // header_logo_margin_below
		$pre .= ",'30'"; // title_size
		$pre .= ",'91995e'"; // title_color
		$pre .= ",''"; // title_font_style
		$pre .= ",''"; // title_font_weight
		$pre .= ",'\'G - Josefin Slab\', serif'"; // title_style
		$pre .= ",'16'"; // description_size
		$pre .= ",'CCCCCC'"; // description_color
		$pre .= ",'\'G - Josefin Slab\', serif'"; // description_style
		$pre .= ",'0'"; // bg_top_offset
		$pre .= ",'20'"; // container_padding
		$pre .= ",'12'"; // footer_font
		$pre .= ",'FFFFFF'"; // footer_font_color
		$pre .= ",''"; // custom_setting
		$pre .= ",'3'"; // footer_widget_placement
		$pre .= ",'2E2E2E'"; // footer_background
		$pre .= ",'Georgia, \"Times New Roman\", Times, serif'"; // footer_font_style
		$pre .= ",'16'"; // footer_widget_title
		$pre .= ",'91995e'"; // footer_widget_color
		$pre .= ",'Georgia, \"Times New Roman\", Times, serif'"; // footer_widget_style
		$pre .= ",'91995e'"; // footer_link_color
		$pre .= ",'91995e'"; // footer_link_hover_color
		$pre .= ",'none'"; // footer_link_hover_style
		$pre .= ",'250'"; // footer_height
		$pre .= ",''"; // show_photocrati
		$pre .= ",'OFF'"; // page_comments
		$pre .= ",''"; // blog_meta
		$pre .= ")";
		$wpdb->query($pre);
		
		
		$pre = "INSERT INTO ". $photocrati_presets . " VALUES (";
		$pre .= "1 "; // option_set
		$pre .= ",'YES'"; // dynamic_style
		$pre .= ",'OFF'"; // one_column
		$pre .= ",'FFFFFF'"; // one_column_color
		$pre .= ",'OFF'"; // one_column_logo
		$pre .= ",'30'"; // one_column_margin
		$pre .= ",'YES'"; // display_sidebar
		$pre .= ",'70'"; // content_width
		$pre .= ",'30'"; // sidebar_width
		$pre .= ",'left-right'"; // logo_menu_position
		$pre .= ",'000000'"; // bg_color
		$pre .= ",'background_bokeh.jpg'"; // bg_image
		$pre .= ",'repeat-x'"; // bg_repeat
		$pre .= ",'FFFFFF'"; // header_bg_color
		$pre .= ",'polnlig_header_bg.gif'"; // header_bg_image
		$pre .= ",'repeat-x'"; // header_bg_repeat
		$pre .= ",'transparent'"; // container_color
		$pre .= ",'0'"; // container_border
		$pre .= ",'CCCCCC'"; // container_border_color
		$pre .= ",'E1E1E1'"; // font_color
		$pre .= ",'12'"; // font_size
		$pre .= ",'Arial, Helvetica, sans-serif'"; // font_style
		$pre .= ",'20'"; // p_line
		$pre .= ",'10'"; // p_space
		$pre .= ",'f04a16'"; // h1_color
		$pre .= ",'22'";  // h1_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h1_font_style
		$pre .= ",''"; // h1_font_case
		$pre .= ",''";// h1_font_weight
		$pre .= ",''"; // h1_font_align
		$pre .= ",'FFFFFF'"; // h2_color
		$pre .= ",'20'";  // h2_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h2_font_style
		$pre .= ",''"; // h2_font_case
		$pre .= ",''"; // h2_font_weight
		$pre .= ",'FFFFFF'"; // h3_color
		$pre .= ",'18'";  // h3_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h3_font_style
		$pre .= ",''"; // h3_font_case
		$pre .= ",''"; // h3_font_weight
		$pre .= ",'FFFFFF'"; // h4_color
		$pre .= ",'16'";  // h4_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h4_font_style
		$pre .= ",''"; // h4_font_case
		$pre .= ",''"; // h4_font_weight
		$pre .= ",'FFFFFF'"; // h5_color
		$pre .= ",'14'";  // h5_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h5_font_style
		$pre .= ",''"; // h5_font_case
		$pre .= ",''"; // h5_font_weight
		$pre .= ",'ebdfd9'"; // link_color
		$pre .= ",'ff8661'"; // link_hover_color
		$pre .= ",'underline'"; // link_hover_style
		$pre .= ",'E1E1E1'"; // sidebar_font_color
		$pre .= ",'12'"; // sidebar_font_size
		$pre .= ",'Verdana, Arial, Helvetica, sans-serif'"; // sidebar_font_style
		$pre .= ",'transparent'"; // sidebar_bg_color
		$pre .= ",'d6874e'"; // sidebar_link_color
		$pre .= ",'f04916'"; // sidebar_link_hover_color
		$pre .= ",'underline'"; // sidebar_link_hover_style
		$pre .= ",'FFFFFF'"; // sidebar_title_color
		$pre .= ",'14'"; // sidebar_title_size
		$pre .= ",'Arial, Helvetica, sans-serif'"; // sidebar_title_style
		$pre .= ",'color'"; // menu_style
		$pre .= ",''"; // menu_color
		$pre .= ",'f04a16'"; // menu_hover_color
		$pre .= ",'12'"; // menu_font_size
		$pre .= ",'Arial, Helvetica, sans-serif'"; // menu_font_style
		$pre .= ",'d6874e'"; // menu_font_color
		$pre .= ",'FFFFFF'"; // menu_font_hover_color
		$pre .= ",''"; // menu_font_case
		$pre .= ",'E8E8E8'"; // submenu_color
		$pre .= ",'f04a16'"; // submenu_hover_color
		$pre .= ",'12'"; // submenu_font_size
		$pre .= ",'Arial, Helvetica, sans-serif'"; // submenu_font_style
		$pre .= ",'333333'"; // submenu_font_color
		$pre .= ",'FFFFFF'"; // submenu_font_hover_color
		$pre .= ",''"; // submenu_font_case
		$pre .= ",'2'"; // nextgen_border
		$pre .= ",'faf7f7'"; // nextgen_border_color
		$pre .= ",'title'"; // custom_logo
		$pre .= ",'Logo_Bokeh.png'"; // custom_logo_image
		$pre .= ",''"; // footer_copy
		$pre .= ",'OFF'"; // custom_sidebar
		$pre .= ",'ABOVE'"; // custom_sidebar_position
		$pre .= ",''"; // custom_sidebar_html
		$pre .= ",'OFF'"; // social_media
		$pre .= ",'Follow Me'"; // social_media_title
		$pre .= ",'small'"; // social_media_set
		$pre .= ",''"; // social_rss
		$pre .= ",''"; // social_email
		$pre .= ",''"; // social_twitter
		$pre .= ",''"; // social_facebook
		$pre .= ",''"; // social_flickr
		$pre .= ",''"; // google_analytics
		$pre .= ",'.menu a:link, .menu a:visited {
padding:52px 17px 29px;
}

#footer {
border-top:0;
}'"; // custom_css
		$pre .= ",'preset-bokeh'"; // preset_name
		$pre .= ",'Photocrati Bokeh'"; // preset_title
		$pre .= ",'120'"; // header_height
		$pre .= ",'10'"; // header_logo_margin_above
		$pre .= ",'10'"; // header_logo_margin_below
		$pre .= ",'30'"; // title_size
		$pre .= ",'d6874e'"; // title_color
		$pre .= ",''"; // title_font_style
		$pre .= ",''"; // title_font_weight
		$pre .= ",'\'G - Josefin Slab\', serif'"; // title_style
		$pre .= ",'16'"; // description_size
		$pre .= ",'999999'"; // description_color
		$pre .= ",'\'G - Josefin Slab\', serif'"; // description_style
		$pre .= ",'0'"; // bg_top_offset
		$pre .= ",'20'"; // container_padding
		$pre .= ",'12'"; // footer_font
		$pre .= ",'333333'"; // footer_font_color
		$pre .= ",''"; // custom_setting
		$pre .= ",'3'"; // footer_widget_placement
		$pre .= ",'FFFFFF'"; // footer_background
		$pre .= ",'Georgia, \"Times New Roman\", Times, serif'"; // footer_font_style
		$pre .= ",'16'"; // footer_widget_title
		$pre .= ",'d6874e'"; // footer_widget_color
		$pre .= ",'Georgia, \"Times New Roman\", Times, serif'"; // footer_widget_style
		$pre .= ",'d6874e'"; // footer_link_color
		$pre .= ",'d6874e'"; // footer_link_hover_color
		$pre .= ",'none'"; // footer_link_hover_style
		$pre .= ",'250'"; // footer_height
		$pre .= ",''"; // show_photocrati
		$pre .= ",'OFF'"; // page_comments
		$pre .= ",''"; // blog_meta
		$pre .= ")";
		$wpdb->query($pre);
		
		
		$pre = "INSERT INTO ". $photocrati_presets . " VALUES (";
		$pre .= "1 "; // option_set
		$pre .= ",'YES'"; // dynamic_style
		$pre .= ",'OFF'"; // one_column
		$pre .= ",'FFFFFF'"; // one_column_color
		$pre .= ",'OFF'"; // one_column_logo
		$pre .= ",'30'"; // one_column_margin
		$pre .= ",'YES'"; // display_sidebar
		$pre .= ",'74'"; // content_width
		$pre .= ",'26'"; // sidebar_width
		$pre .= ",'right-left'"; // logo_menu_position
		$pre .= ",'f5dddb'"; // bg_color
		$pre .= ",'pink_stripes.gif'"; // bg_image
		$pre .= ",'repeat'"; // bg_repeat
		$pre .= ",'FFFFFF'"; // header_bg_color
		$pre .= ",'header_fadepink.gif'"; // header_bg_image
		$pre .= ",'repeat-x'"; // header_bg_repeat
		$pre .= ",'ffffff'"; // container_color
		$pre .= ",'0'"; // container_border
		$pre .= ",'CCCCCC'"; // container_border_color
		$pre .= ",'000000'"; // font_color
		$pre .= ",'14'"; // font_size
		$pre .= ",'\"Times New Roman\", Times, serif'"; // font_style
		$pre .= ",'20'"; // p_line
		$pre .= ",'10'"; // p_space
		$pre .= ",'e3628b'"; // h1_color
		$pre .= ",'24'";  // h1_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h1_font_style
		$pre .= ",''"; // h1_font_case
		$pre .= ",''";// h1_font_weight
		$pre .= ",''"; // h1_font_align
		$pre .= ",'e3628b'"; // h2_color
		$pre .= ",'22'";  // h2_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h2_font_style
		$pre .= ",''"; // h2_font_case
		$pre .= ",''"; // h2_font_weight
		$pre .= ",'e3628b'"; // h3_color
		$pre .= ",'18'";  // h3_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h3_font_style
		$pre .= ",''"; // h3_font_case
		$pre .= ",''"; // h3_font_weight
		$pre .= ",'e3628b'"; // h4_color
		$pre .= ",'16'";  // h4_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h4_font_style
		$pre .= ",''"; // h4_font_case
		$pre .= ",''"; // h4_font_weight
		$pre .= ",'e3628b'"; // h5_color
		$pre .= ",'14'";  // h5_size
		$pre .= ",'\'G - Josefin Slab\', serif'"; // h5_font_style
		$pre .= ",''"; // h5_font_case
		$pre .= ",''"; // h5_font_weight
		$pre .= ",'d1a1ac'"; // link_color
		$pre .= ",'ff548d'"; // link_hover_color
		$pre .= ",'none'"; // link_hover_style
		$pre .= ",'858085'"; // sidebar_font_color
		$pre .= ",'12'"; // sidebar_font_size
		$pre .= ",'\"Times New Roman\", Times, serif'"; // sidebar_font_style
		$pre .= ",'eeeadf'"; // sidebar_bg_color
		$pre .= ",'c6869a'"; // sidebar_link_color
		$pre .= ",'e3628b'"; // sidebar_link_hover_color
		$pre .= ",'none'"; // sidebar_link_hover_style
		$pre .= ",'c6869a'"; // sidebar_title_color
		$pre .= ",'14'"; // sidebar_title_size
		$pre .= ",'Arial, Helvetica, sans-serif'"; // sidebar_title_style
		$pre .= ",'transparent'"; // menu_style
		$pre .= ",'FFFFFF'"; // menu_color
		$pre .= ",'FFFFFF'"; // menu_hover_color
		$pre .= ",'12'"; // menu_font_size
		$pre .= ",'Arial, Helvetica, sans-serif'"; // menu_font_style
		$pre .= ",'d1a1ac'"; // menu_font_color
		$pre .= ",'e3628b'"; // menu_font_hover_color
		$pre .= ",''"; // menu_font_case
		$pre .= ",'eeeadf'"; // submenu_color
		$pre .= ",'ffffff'"; // submenu_hover_color
		$pre .= ",'12'"; // submenu_font_size
		$pre .= ",'Arial, Helvetica, sans-serif'"; // submenu_font_style
		$pre .= ",'c6869a'"; // submenu_font_color
		$pre .= ",'e3628b'"; // submenu_font_hover_color
		$pre .= ",''"; // submenu_font_case
		$pre .= ",'5'"; // nextgen_border
		$pre .= ",'e8e7e7'"; // nextgen_border_color
		$pre .= ",'title'"; // custom_logo
		$pre .= ",'Logo_Pink.png'"; // custom_logo_image
		$pre .= ",''"; // footer_copy
		$pre .= ",'OFF'"; // custom_sidebar
		$pre .= ",'ABOVE'"; // custom_sidebar_position
		$pre .= ",''"; // custom_sidebar_html
		$pre .= ",'OFF'"; // social_media
		$pre .= ",'Follow Me'"; // social_media_title
		$pre .= ",'small'"; // social_media_set
		$pre .= ",''"; // social_rss
		$pre .= ",''"; // social_email
		$pre .= ",''"; // social_twitter
		$pre .= ",''"; // social_facebook
		$pre .= ",''"; // social_flickr
		$pre .= ",''"; // google_analytics
		$pre .= ",'div.slideshow {
margin-bottom: 20px;
}

#primary {
padding:25px 23px;
width:79%;
}'"; // custom_css
		$pre .= ",'preset-prime'"; // preset_name
		$pre .= ",'Photocrati Prime'"; // preset_title
		$pre .= ",'120'"; // header_height
		$pre .= ",'10'"; // header_logo_margin_above
		$pre .= ",'10'"; // header_logo_margin_below

		$pre .= ",'30'"; // title_size
		$pre .= ",'d1a1ac'"; // title_color
		$pre .= ",''"; // title_font_style
		$pre .= ",''"; // title_font_weight
		$pre .= ",'\'G - Josefin Slab\', serif'"; // title_style
		$pre .= ",'16'"; // description_size
		$pre .= ",'999999'"; // description_color
		$pre .= ",'\'G - Josefin Slab\', serif'"; // description_style
		$pre .= ",'0'"; // bg_top_offset
		$pre .= ",'30'"; // container_padding
		$pre .= ",'12'"; // footer_font
		$pre .= ",'333333'"; // footer_font_color
		$pre .= ",''"; // custom_setting
		$pre .= ",'3'"; // footer_widget_placement
		$pre .= ",'FFFFFF'"; // footer_background
		$pre .= ",'Georgia, \"Times New Roman\", Times, serif'"; // footer_font_style
		$pre .= ",'16'"; // footer_widget_title
		$pre .= ",'d1a1ac'"; // footer_widget_color
		$pre .= ",'Georgia, \"Times New Roman\", Times, serif'"; // footer_widget_style
		$pre .= ",'d1a1ac'"; // footer_link_color
		$pre .= ",'d1a1ac'"; // footer_link_hover_color
		$pre .= ",'none'"; // footer_link_hover_style
		$pre .= ",'250'"; // footer_height
		$pre .= ",''"; // show_photocrati
		$pre .= ",'OFF'"; // page_comments
		$pre .= ",''"; // blog_meta
		$pre .= ")";
		$wpdb->query($pre);
		
		
		if ($enable_extra_themes)
		{
			$pre = "INSERT INTO ". $photocrati_presets . " VALUES (";
			$pre .= "1 "; // option_set
			$pre .= ",'YES'"; // dynamic_style
			$pre .= ",'ON'"; // one_column
			$pre .= ",'FFFFFF'"; // one_column_color
			$pre .= ",'OFF'"; // one_column_logo
			$pre .= ",'30'"; // one_column_margin
			$pre .= ",'NO'"; // display_sidebar
			$pre .= ",'100'"; // content_width
			$pre .= ",'0'"; // sidebar_width
			$pre .= ",'right-left'"; // logo_menu_position
			$pre .= ",'000000'"; // bg_color
			$pre .= ",'Circles_BG.gif'"; // bg_image
			$pre .= ",'repeat'"; // bg_repeat
			$pre .= ",'FFFFFF'"; // header_bg_color
			$pre .= ",'BlueScratchHeader_BG.jpg'"; // header_bg_image
			$pre .= ",'no-repeat'"; // header_bg_repeat
			$pre .= ",''"; // container_color
			$pre .= ",'0'"; // container_border
			$pre .= ",'CCCCCC'"; // container_border_color
			$pre .= ",'666666'"; // font_color
			$pre .= ",'13'"; // font_size
			$pre .= ",'\'G - PT Sans\', serif'"; // font_style
			$pre .= ",'20'"; // p_line
			$pre .= ",'10'"; // p_space
			$pre .= ",'D53900'"; // h1_color
			$pre .= ",'38'";  // h1_size
			$pre .= ",'\'G - Yanone Kaffeesatz\', serif'"; // h1_font_style
			$pre .= ",''"; // h1_font_case
			$pre .= ",'bold'";// h1_font_weight
			$pre .= ",''"; // h1_font_align
			$pre .= ",'D53900'"; // h2_color
			$pre .= ",'24'";  // h2_size
			$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // h2_font_style
			$pre .= ",''"; // h2_font_case
			$pre .= ",'bold'"; // h2_font_weight
			$pre .= ",'333333'"; // h3_color
			$pre .= ",'18'";  // h3_size
			$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // h3_font_style
			$pre .= ",''"; // h3_font_case
			$pre .= ",''"; // h3_font_weight
			$pre .= ",'333333'"; // h4_color
			$pre .= ",'16'";  // h4_size
			$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // h4_font_style
			$pre .= ",''"; // h4_font_case
			$pre .= ",''"; // h4_font_weight
			$pre .= ",'333333'"; // h5_color
			$pre .= ",'14'";  // h5_size
			$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // h5_font_style
			$pre .= ",''"; // h5_font_case
			$pre .= ",''"; // h5_font_weight
			$pre .= ",'2B5780'"; // link_color
			$pre .= ",'266ead'"; // link_hover_color
			$pre .= ",'underline'"; // link_hover_style
			$pre .= ",'666666'"; // sidebar_font_color
			$pre .= ",'12'"; // sidebar_font_size
			$pre .= ",'Verdana, Arial, Helvetica, sans-serif'"; // sidebar_font_style
			$pre .= ",'transparent'"; // sidebar_bg_color
			$pre .= ",'2B5780'"; // sidebar_link_color
			$pre .= ",'2B5780'"; // sidebar_link_hover_color
			$pre .= ",'underline'"; // sidebar_link_hover_style
			$pre .= ",'333333'"; // sidebar_title_color
			$pre .= ",'14'"; // sidebar_title_size
			$pre .= ",'Arial, Helvetica, sans-serif'"; // sidebar_title_style
			$pre .= ",'transparent'"; // menu_style
			$pre .= ",'E8E8E8'"; // menu_color
			$pre .= ",'C8C9CB'"; // menu_hover_color
			$pre .= ",'20'"; // menu_font_size
			$pre .= ",'\'G - Yanone Kaffeesatz\', serif'"; // menu_font_style
			$pre .= ",'A8A8A8'"; // menu_font_color
			$pre .= ",'d53800'"; // menu_font_hover_color
			$pre .= ",'uppercase'"; // menu_font_case
			$pre .= ",'E8E8E8'"; // submenu_color
			$pre .= ",'C8C9CB'"; // submenu_hover_color
			$pre .= ",'18'"; // submenu_font_size
			$pre .= ",'\'G - Yanone Kaffeesatz\', serif'"; // submenu_font_style
			$pre .= ",'484848'"; // submenu_font_color
			$pre .= ",'d53800'"; // submenu_font_hover_color
			$pre .= ",'uppercase'"; // submenu_font_case
			$pre .= ",'5'"; // nextgen_border
			$pre .= ",'e8e7e7'"; // nextgen_border_color
			$pre .= ",'title'"; // custom_logo
			$pre .= ",'Photocrati_LogoRed1.png'"; // custom_logo_image
			$pre .= ",''"; // footer_copy
			$pre .= ",'OFF'"; // custom_sidebar
			$pre .= ",'ABOVE'"; // custom_sidebar_position
			$pre .= ",''"; // custom_sidebar_html
			$pre .= ",'OFF'"; // social_media
			$pre .= ",'Follow Me'"; // social_media_title
			$pre .= ",'small'"; // social_media_set
			$pre .= ",''"; // social_rss
			$pre .= ",''"; // social_email
			$pre .= ",''"; // social_twitter
			$pre .= ",''"; // social_facebook
			$pre .= ",''"; // social_flickr
			$pre .= ",''"; // google_analytics
			$pre .= ",'a:hover, a:active {
	text-decoration:none;
	}

	a:link, a:visited {
	color:#D53900;
	text-decoration:none;
	}

	p {
	margin-bottom:0.5em;
	}

	h1, .entry-title {
	clear:none;
	padding-bottom:1px;
	margin:20px 0 6px;
	}

	h2 {
	clear:none;
	padding-bottom:1px;
	margin:20px 0 6px;
	}

	#main_container {
	background: url(\"../images/uploads/BlueScratchBody2_BG.jpg\") no-repeat scroll center top #FFF;
	margin:0 auto;
	min-height:100%;
	z-index:-1;
	}

	#container {
	border:0 solid #CCCCCC;
	float:left;
	}

	#content p, #content-sm p {
	line-height:20px;
	margin-bottom:20px;
	margin-top:20px;
	}

	.menu a:hover, .menu a:active, .menu .current_page_item a:link, .menu .current_page_item a:visited {
	font-weight:bold;
	text-shadow: 1px 1px 1px #ffffff; filter: dropshadow(color=#ffffff, offx=1, offy=1), -1px -1px 1px #000000;
	}

	.menu a:link, .menu a:visited {
	font-weight:bold;
	padding:22px 15px 12px;
	text-decoration:none;
	text-shadow: 1px 1px 1px #ffffff; filter: dropshadow(color=#ffffff, offx=1, offy=1);
	}

	.sub-menu {
	font-weight:bold;
	text-shadow: 1px 1px 1px #ffffff; filter: dropshadow(color=#ffffff, offx=1, offy=1), -1px -1px 1px #000000;
	}

	.size-full, .entry-content img {
	border:4px solid #FFF;
	}

	#footer {
	border-top:0 solid #E8E7E7;
	text-align:center;
	}

	#footer #site-info p  {
	z-index:3;
	font-size:10px;
	text-transform:uppercase;
	}'"; // custom_css
			$pre .= ",'preset-zoom'"; // preset_name
			$pre .= ",'Photocrati Zoom'"; // preset_title
			$pre .= ",'120'"; // header_height
			$pre .= ",'10'"; // header_logo_margin_above
			$pre .= ",'10'"; // header_logo_margin_below
			$pre .= ",'30'"; // title_size
			$pre .= ",'d53900'"; // title_color
			$pre .= ",''"; // title_font_style
			$pre .= ",''"; // title_font_weight
			$pre .= ",'\'G - Josefin Slab\', serif'"; // title_style
			$pre .= ",'16'"; // description_size
			$pre .= ",'999999'"; // description_color
			$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // description_style
			$pre .= ",'0'"; // bg_top_offset
			$pre .= ",'30'"; // container_padding
			$pre .= ",'12'"; // footer_font
			$pre .= ",'333333'"; // footer_font_color
			$pre .= ",''"; // custom_setting
			$pre .= ",'3'"; // footer_widget_placement
			$pre .= ",'FFFFFF'"; // footer_background
			$pre .= ",'\'G - PT Sans\', serif'"; // footer_font_style
			$pre .= ",'16'"; // footer_widget_title
			$pre .= ",'d53900'"; // footer_widget_color
			$pre .= ",'\'G - PT Sans\', serif'"; // footer_widget_style
			$pre .= ",'d53900'"; // footer_link_color
			$pre .= ",'ff4400'"; // footer_link_hover_color
			$pre .= ",'none'"; // footer_link_hover_style
			$pre .= ",'250'"; // footer_height
			$pre .= ",''"; // show_photocrati
			$pre .= ",'OFF'"; // page_comments
			$pre .= ",''"; // blog_meta
			$pre .= ")";
			$wpdb->query($pre);
		
		
			$pre = "INSERT INTO ". $photocrati_presets . " VALUES (";
			$pre .= "1 "; // option_set
			$pre .= ",'YES'"; // dynamic_style
			$pre .= ",'ON'"; // one_column
			$pre .= ",'FFFFFF'"; // one_column_color
			$pre .= ",'ON'"; // one_column_logo
			$pre .= ",'30'"; // one_column_margin
			$pre .= ",'NO'"; // display_sidebar
			$pre .= ",'100'"; // content_width
			$pre .= ",'0'"; // sidebar_width
			$pre .= ",'top-bottom'"; // logo_menu_position
			$pre .= ",'333538'"; // bg_color
			$pre .= ",'DarkTileBG3.gif'"; // bg_image
			$pre .= ",'repeat'"; // bg_repeat
			$pre .= ",'2D96BB'"; // header_bg_color
			$pre .= ",''"; // header_bg_image
			$pre .= ",'no-repeat'"; // header_bg_repeat
			$pre .= ",'ffffff'"; // container_color
			$pre .= ",'0'"; // container_border
			$pre .= ",'CCCCCC'"; // container_border_color
			$pre .= ",'332c2c'"; // font_color
			$pre .= ",'13'"; // font_size
			$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // font_style
			$pre .= ",'22'"; // p_line
			$pre .= ",'20'"; // p_space
			$pre .= ",'4095ba'"; // h1_color
			$pre .= ",'38'";  // h1_size
			$pre .= ",'\'G - Yanone Kaffeesatz\', serif'"; // h1_font_style
			$pre .= ",''"; // h1_font_case
			$pre .= ",''";// h1_font_weight
			$pre .= ",''"; // h1_font_align
			$pre .= ",'4095ba'"; // h2_color
			$pre .= ",'32'";  // h2_size
			$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // h2_font_style
			$pre .= ",''"; // h2_font_case
			$pre .= ",''"; // h2_font_weight
			$pre .= ",'333333'"; // h3_color
			$pre .= ",'22'";  // h3_size
			$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // h3_font_style
			$pre .= ",''"; // h3_font_case
			$pre .= ",''"; // h3_font_weight
			$pre .= ",'333333'"; // h4_color
			$pre .= ",'16'";  // h4_size
			$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // h4_font_style
			$pre .= ",''"; // h4_font_case
			$pre .= ",''"; // h4_font_weight
			$pre .= ",'333333'"; // h5_color
			$pre .= ",'14'";  // h5_size
			$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // h5_font_style
			$pre .= ",''"; // h5_font_case
			$pre .= ",''"; // h5_font_weight
			$pre .= ",'4095ba'"; // link_color
			$pre .= ",'4ab7e6'"; // link_hover_color
			$pre .= ",'none'"; // link_hover_style
			$pre .= ",'666666'"; // sidebar_font_color
			$pre .= ",'12'"; // sidebar_font_size
			$pre .= ",'Verdana, Arial, Helvetica, sans-serif'"; // sidebar_font_style
			$pre .= ",'transparent'"; // sidebar_bg_color
			$pre .= ",'2B5780'"; // sidebar_link_color
			$pre .= ",'2B5780'"; // sidebar_link_hover_color
			$pre .= ",'underline'"; // sidebar_link_hover_style
			$pre .= ",'333333'"; // sidebar_title_color
			$pre .= ",'14'"; // sidebar_title_size
			$pre .= ",'Arial, Helvetica, sans-serif'"; // sidebar_title_style
			$pre .= ",'transparent'"; // menu_style
			$pre .= ",''"; // menu_color
			$pre .= ",'272e38'"; // menu_hover_color
			$pre .= ",'20'"; // menu_font_size
			$pre .= ",'\'G - Yanone Kaffeesatz\', serif'"; // menu_font_style
			$pre .= ",'e6e6e6'"; // menu_font_color
			$pre .= ",'ffffff'"; // menu_font_hover_color
			$pre .= ",'uppercase'"; // menu_font_case
			$pre .= ",'E8E8E8'"; // submenu_color
			$pre .= ",'6c92a6'"; // submenu_hover_color
			$pre .= ",'18'"; // submenu_font_size
			$pre .= ",'\'G - Yanone Kaffeesatz\', serif'"; // submenu_font_style
			$pre .= ",'484848'"; // submenu_font_color
			$pre .= ",'171d42'"; // submenu_font_hover_color
			$pre .= ",'uppercase'"; // submenu_font_case
			$pre .= ",'5'"; // nextgen_border
			$pre .= ",'e8e7e7'"; // nextgen_border_color
			$pre .= ",'custom'"; // custom_logo
			$pre .= ",'DarkTilePhotoHeader.jpg'"; // custom_logo_image
			$pre .= ",''"; // footer_copy
			$pre .= ",'OFF'"; // custom_sidebar
			$pre .= ",'ABOVE'"; // custom_sidebar_position
			$pre .= ",''"; // custom_sidebar_html
			$pre .= ",'OFF'"; // social_media
			$pre .= ",'Follow Me'"; // social_media_title
			$pre .= ",'small'"; // social_media_set
			$pre .= ",''"; // social_rss
			$pre .= ",''"; // social_email
			$pre .= ",''"; // social_twitter
			$pre .= ",''"; // social_facebook
			$pre .= ",''"; // social_flickr
			$pre .= ",''"; // google_analytics
			$pre .= ",'body {
	background-position: top center;
	}

	h1, .entry-title {
	clear:none;
	padding-bottom:1px;
	margin:20px 0 6px;
	}

	h3 {
	clear:none;
	border-top:1 dotted #E8E7E7;
	font-size:22px;
	}

	.menu a:link, .menu a:visited {
	padding:18px 17px 22px;
	}

	#blog-title img {
	margin-top: -100px;
	}

	#menu_wrapper {
	height:40px;
	margin-top: -8px;
	}

	#menu_wrapper .menu {
	text-align: left;
	margin: 0 auto;
	width: 960px;
	}

	#footer #site-info p  {
	z-index:3;
	font-size:10px;
	text-transform:uppercase;
	text-align:right;
	}'"; // custom_css
			$pre .= ",'preset-exposure2'"; // preset_name
			$pre .= ",'Photocrati Exposure'"; // preset_title
			$pre .= ",'365'"; // header_height
			$pre .= ",'100'"; // header_logo_margin_above
			$pre .= ",'160'"; // header_logo_margin_below
			$pre .= ",'45'"; // title_size
			$pre .= ",'ffffff'"; // title_color
			$pre .= ",''"; // title_font_style
			$pre .= ",'bold'"; // title_font_weight
			$pre .= ",'\'G - Yanone Kaffeesatz\', serif'"; // title_style
			$pre .= ",'16'"; // description_size
			$pre .= ",'dbdbdb'"; // description_color
			$pre .= ",'\'G - Josefin Slab\', serif'"; // description_style
			$pre .= ",'0'"; // bg_top_offset
			$pre .= ",'10'"; // container_padding
			$pre .= ",'13'"; // footer_font
			$pre .= ",'362d2d'"; // footer_font_color
			$pre .= ",''"; // custom_setting
			$pre .= ",'4'"; // footer_widget_placement
			$pre .= ",'FFFFFF'"; // footer_background
			$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // footer_font_style
			$pre .= ",'16'"; // footer_widget_title
			$pre .= ",'4095ba'"; // footer_widget_color
			$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // footer_widget_style
			$pre .= ",'4095ba'"; // footer_link_color
			$pre .= ",'4ab7e6'"; // footer_link_hover_color
			$pre .= ",'none'"; // footer_link_hover_style
			$pre .= ",'275'"; // footer_height
			$pre .= ",''"; // show_photocrati
			$pre .= ",'OFF'"; // page_comments
			$pre .= ",''"; // blog_meta
			$pre .= ")";
			$wpdb->query($pre);
		
		
			$pre = "INSERT INTO ". $photocrati_presets . " VALUES (";
			$pre .= "1 "; // option_set
			$pre .= ",'YES'"; // dynamic_style
			$pre .= ",'ON'"; // one_column
			$pre .= ",'FFFFFF'"; // one_column_color
			$pre .= ",'ON'"; // one_column_logo
			$pre .= ",'0'"; // one_column_margin
			$pre .= ",'NO'"; // display_sidebar
			$pre .= ",'100'"; // content_width
			$pre .= ",'0'"; // sidebar_width
			$pre .= ",'top-bottom'"; // logo_menu_position
			$pre .= ",'312826'"; // bg_color
			$pre .= ",'WallpaperBG3.jpg'"; // bg_image
			$pre .= ",'repeat'"; // bg_repeat
			$pre .= ",'af3e11'"; // header_bg_color
			$pre .= ",''"; // header_bg_image
			$pre .= ",'no-repeat'"; // header_bg_repeat
			$pre .= ",'ffffff'"; // container_color
			$pre .= ",'0'"; // container_border
			$pre .= ",'CCCCCC'"; // container_border_color
			$pre .= ",'666666'"; // font_color
			$pre .= ",'13'"; // font_size
			$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // font_style
			$pre .= ",'20'"; // p_line
			$pre .= ",'10'"; // p_space
			$pre .= ",'a32b0f'"; // h1_color
			$pre .= ",'38'";  // h1_size
			$pre .= ",'\'G - Yanone Kaffeesatz\', serif'"; // h1_font_style
			$pre .= ",''"; // h1_font_case
			$pre .= ",''";// h1_font_weight
			$pre .= ",''"; // h1_font_align
			$pre .= ",'3d312c'"; // h2_color
			$pre .= ",'32'";  // h2_size
			$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // h2_font_style
			$pre .= ",''"; // h2_font_case
			$pre .= ",''"; // h2_font_weight
			$pre .= ",'3d312c'"; // h3_color
			$pre .= ",'22'";  // h3_size
			$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // h3_font_style
			$pre .= ",''"; // h3_font_case
			$pre .= ",''"; // h3_font_weight
			$pre .= ",'3d312c'"; // h4_color
			$pre .= ",'16'";  // h4_size
			$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // h4_font_style
			$pre .= ",''"; // h4_font_case
			$pre .= ",''"; // h4_font_weight
			$pre .= ",'3d312c'"; // h5_color
			$pre .= ",'14'";  // h5_size
			$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // h5_font_style
			$pre .= ",''"; // h5_font_case
			$pre .= ",''"; // h5_font_weight
			$pre .= ",'cc3300'"; // link_color
			$pre .= ",'ff4000'"; // link_hover_color
			$pre .= ",'none'"; // link_hover_style
			$pre .= ",'666666'"; // sidebar_font_color
			$pre .= ",'12'"; // sidebar_font_size
			$pre .= ",'Verdana, Arial, Helvetica, sans-serif'"; // sidebar_font_style
			$pre .= ",'transparent'"; // sidebar_bg_color
			$pre .= ",'2B5780'"; // sidebar_link_color
			$pre .= ",'2B5780'"; // sidebar_link_hover_color
			$pre .= ",'underline'"; // sidebar_link_hover_style
			$pre .= ",'333333'"; // sidebar_title_color
			$pre .= ",'14'"; // sidebar_title_size
			$pre .= ",'Arial, Helvetica, sans-serif'"; // sidebar_title_style
			$pre .= ",'transparent'"; // menu_style
			$pre .= ",'AF3F11'"; // menu_color
			$pre .= ",'96350f'"; // menu_hover_color
			$pre .= ",'20'"; // menu_font_size
			$pre .= ",'\'G - Yanone Kaffeesatz\', serif'"; // menu_font_style
			$pre .= ",'ff734f'"; // menu_font_color
			$pre .= ",'ffffff'"; // menu_font_hover_color
			$pre .= ",'uppercase'"; // menu_font_case
			$pre .= ",'E8E8E8'"; // submenu_color
			$pre .= ",'C8C9CB'"; // submenu_hover_color
			$pre .= ",'18'"; // submenu_font_size
			$pre .= ",'\'G - Yanone Kaffeesatz\', serif'"; // submenu_font_style
			$pre .= ",'484848'"; // submenu_font_color
			$pre .= ",'2D73B6'"; // submenu_font_hover_color
			$pre .= ",'uppercase'"; // submenu_font_case
			$pre .= ",'5'"; // nextgen_border
			$pre .= ",'e8e7e7'"; // nextgen_border_color
			$pre .= ",'custom'"; // custom_logo
			$pre .= ",'WallpaperHeader3.jpg'"; // custom_logo_image
			$pre .= ",''"; // footer_copy
			$pre .= ",'OFF'"; // custom_sidebar
			$pre .= ",'ABOVE'"; // custom_sidebar_position
			$pre .= ",''"; // custom_sidebar_html
			$pre .= ",'OFF'"; // social_media
			$pre .= ",'Follow Me'"; // social_media_title
			$pre .= ",'small'"; // social_media_set
			$pre .= ",''"; // social_rss
			$pre .= ",''"; // social_email
			$pre .= ",''"; // social_twitter
			$pre .= ",''"; // social_facebook
			$pre .= ",''"; // social_flickr
			$pre .= ",''"; // google_analytics
			$pre .= ",'body {
	background-position: top center;
	}

	.entry-meta, .entry-utility {
	margin-left:25px;
	margin-top:20px;
	}

	h1, .entry-title {
	clear:none;
	padding-bottom:1px;
	margin:20px 0 6px;
	}

	#blog-title img {
	margin-top: -100px;
	}

	#menu_wrapper {
	height: 27px;
	margin-top:3px;
	}

	#menu_wrapper .menu {
	width: 960px;
	margin: 0 auto;
	text-align: right;
	}

	.menu a:link, .menu a:visited {
	padding:18px 18px 11px;
	}

	.menu ul {
	line-height:2px;
	}

	.menu ul li ul {
	line-height:18px;
	}

	#container {

	}

	#footer {
	text-align:center;
	}

	#footer #site-info {
	clear:both;
	margin:5px 18px 0;
	}

	#footer #site-info p  {
	font-size:10px;
	margin-right:20px;
	text-align:right;
	text-transform:uppercase;
	z-index:3;
	}'"; // custom_css
			$pre .= ",'preset-telephoto'"; // preset_name
			$pre .= ",'Photocrati Telephoto'"; // preset_title
			$pre .= ",'364'"; // header_height
			$pre .= ",'100'"; // header_logo_margin_above
			$pre .= ",'0'"; // header_logo_margin_below
			$pre .= ",'45'"; // title_size
			$pre .= ",'ffffff'"; // title_color
			$pre .= ",''"; // title_font_style
			$pre .= ",'bold'"; // title_font_weight
			$pre .= ",'\'G - Yanone Kaffeesatz\', serif'"; // title_style
			$pre .= ",'16'"; // description_size
			$pre .= ",'dbdbdb'"; // description_color
			$pre .= ",'\'G - Josefin Slab\', serif'"; // description_style
			$pre .= ",'0'"; // bg_top_offset
			$pre .= ",'10'"; // container_padding
			$pre .= ",'13'"; // footer_font
			$pre .= ",'362d2d'"; // footer_font_color
			$pre .= ",''"; // custom_setting
			$pre .= ",'3'"; // footer_widget_placement
			$pre .= ",'FFFFFF'"; // footer_background
			$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // footer_font_style
			$pre .= ",'16'"; // footer_widget_title
			$pre .= ",'A32B0F'"; // footer_widget_color
			$pre .= ",'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'"; // footer_widget_style
			$pre .= ",'A32B0F'"; // footer_link_color
			$pre .= ",'ff4000'"; // footer_link_hover_color
			$pre .= ",'none'"; // footer_link_hover_style
			$pre .= ",'300'"; // footer_height
			$pre .= ",''"; // show_photocrati
			$pre .= ",'OFF'"; // page_comments
			$pre .= ",''"; // blog_meta
			$pre .= ")";
			$wpdb->query($pre);
		}
		
	}
	
	
	$photocrati_fonts = $table_prefix . "photocrati_fonts";
	
	if($wpdb->get_var("show tables like '$photocrati_fonts'") != $photocrati_fonts) {
	
		$sql2 = "CREATE TABLE `". $photocrati_fonts . "` ( ";
		$sql2 .= " `font_name` tinytext NOT NULL, ";
		$sql2 .= " `font_value` tinytext NOT NULL ";
		$sql2 .= ") ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1 ; ";
		
		require_once(ABSPATH . 'wp-admin/upgrade-functions.php');
		dbDelta($sql2);
		
		$sql3 = "INSERT INTO ". $photocrati_fonts . " VALUES (
		'Arial'
		,'Arial, Helvetica, sans-serif'
		)";
		$wpdb->query($sql3);
		
		$sql4 = "INSERT INTO ". $photocrati_fonts . " VALUES (
		'Times New Roman'
		,'\"Times New Roman\", Times, serif'
		)";
		$wpdb->query($sql4);
		
		$sql5 = "INSERT INTO ". $photocrati_fonts . " VALUES (
		'Verdana'
		,'Verdana, Arial, Helvetica, sans-serif'
		)";
		$wpdb->query($sql5);
		
		$sql6 = "INSERT INTO ". $photocrati_fonts . " VALUES (
		'Geneva'
		,'Geneva, Arial, Helvetica, sans-serif'
		)";
		$wpdb->query($sql6);
		
		$sql7 = "INSERT INTO ". $photocrati_fonts . " VALUES (
		'Georgia'
		,'Georgia, \"Times New Roman\", Times, serif'
		)";
		$wpdb->query($sql7);
		
		$sql8 = "INSERT INTO ". $photocrati_fonts . " VALUES (
		'Times'
		,'Times, serif, \"Times New Roman\"'
		)";
		$wpdb->query($sql8);
		
		$sql9 = "INSERT INTO ". $photocrati_fonts . " VALUES (
		'Helvetica'
		,'helvetica, arial, sans-serif'
		)";
		$wpdb->query($sql9);
		
		$sql10 = "INSERT INTO ". $photocrati_fonts . " VALUES (
		'Courier'
		,'Courier, monospace, sans-serif'
		)";
		$wpdb->query($sql10);
		
		$sql11 = "INSERT INTO ". $photocrati_fonts . " VALUES (
		'Courier New'
		,'Courier New, monospace, sans-serif'
		)";
		$wpdb->query($sql11);
		
		$sql12 = "INSERT INTO ". $photocrati_fonts . " VALUES (
		'Trebuchet'
		,'Trebuchet, Tahoma, Helvetica, sans-serif'
		)";
		$wpdb->query($sql12);
		
		$sql13 = "INSERT INTO ". $photocrati_fonts . " VALUES (
		'Tahoma'
		,'Tahoma, Trebuchet, Helvetica, sans-serif'
		)";
		$wpdb->query($sql13);
		
		$sql14 = "INSERT INTO ". $photocrati_fonts . " VALUES (
		'Lucida'
		,'Lucida Grande, Lucida Sans, Lucida Sans Unicode, sans-serif'
		)";
		$wpdb->query($sql14);
		
		$sql14 = "INSERT INTO ". $photocrati_fonts . " VALUES (
		'G - Allan'
		,'\'G - Allan:bold\', serif'
		)";
		$wpdb->query($sql14);
		
		$sql14 = "INSERT INTO ". $photocrati_fonts . " VALUES (
		'G - Allerta Stencil'
		,'\'G - Allerta Stencil\', serif'
		)";
		$wpdb->query($sql14);
		
		$sql14 = "INSERT INTO ". $photocrati_fonts . " VALUES (
		'G - IM Fell English'
		,'\'G - IM Fell English SC\', serif'
		)";
		$wpdb->query($sql14);
		
		$sql14 = "INSERT INTO ". $photocrati_fonts . " VALUES (
		'G - Josefin Slab'
		,'\'G - Josefin Slab\', serif'
		)";
		$wpdb->query($sql14);
		
		$sql14 = "INSERT INTO ". $photocrati_fonts . " VALUES (
		'G - Lobster'
		,'\'G - Lobster\', serif'
		)";
		$wpdb->query($sql14);
		
		$sql14 = "INSERT INTO ". $photocrati_fonts . " VALUES (
		'G - Orbitron'
		,'\'G - Orbitron\', serif'
		)";
		$wpdb->query($sql14);
		
		$sql14 = "INSERT INTO ". $photocrati_fonts . " VALUES (
		'G - PT Sans'
		,'\'G - PT Sans\', serif'
		)";
		$wpdb->query($sql14);
		
		$sql14 = "INSERT INTO ". $photocrati_fonts . " VALUES (
		'G - Raleway'
		,'\'G - Raleway:100\', serif'
		)";
		$wpdb->query($sql14);
		
		$sql14 = "INSERT INTO ". $photocrati_fonts . " VALUES (
		'G - Reenie Beanie'
		,'\'G - Reenie Beanie\', serif'
		)";
		$wpdb->query($sql14);
		
		$sql14 = "INSERT INTO ". $photocrati_fonts . " VALUES (
		'G - Sniglet'
		,'\'G - Sniglet:800\', serif'
		)";
		$wpdb->query($sql14);
		
		$sql14 = "INSERT INTO ". $photocrati_fonts . " VALUES (
		'G - Tangerine'
		,'\'G - Tangerine\', serif'
		)";
		$wpdb->query($sql14);
		
		$sql14 = "INSERT INTO ". $photocrati_fonts . " VALUES (
		'G - Unifraktur'
		,'\'G - UnifrakturMaguntia\', serif'
		)";
		$wpdb->query($sql14);
		
		$sql14 = "INSERT INTO ". $photocrati_fonts . " VALUES (
		'G - Yanone Kaffeesatz'
		,'\'G - Yanone Kaffeesatz\', serif'
		)";
		$wpdb->query($sql14);
		
	} else {
	
		$sql = "ALTER TABLE " . $photocrati_fonts . " CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
		$wpdb->query($sql);
		
		$exists = '';
	
		$check = $wpdb->get_results("SELECT font_name FROM ".$wpdb->prefix."photocrati_fonts WHERE font_name = 'G - Allan'");
		foreach ($check as $check) {
			$exists = $check->font_name;
		}
		
		if($exists == '') {
		
		$sql14 = "INSERT INTO ". $photocrati_fonts . " VALUES (
		'G - Allan'
		,'\'G - Allan:bold\', serif'
		)";
		$wpdb->query($sql14);
		
		}
		
		
		$exists = '';
	
		$check = $wpdb->get_results("SELECT font_name FROM ".$wpdb->prefix."photocrati_fonts WHERE font_name = 'G - Allerta Stencil'");
		foreach ($check as $check) {
			$exists = $check->font_name;
		}
		
		if($exists == '') {
		
		$sql14 = "INSERT INTO ". $photocrati_fonts . " VALUES (
		'G - Allerta Stencil'
		,'\'G - Allerta Stencil\', serif'
		)";
		$wpdb->query($sql14);
		
		}
		
		
		$exists = '';
	
		$check = $wpdb->get_results("SELECT font_name FROM ".$wpdb->prefix."photocrati_fonts WHERE font_name = 'G - IM Fell English'");
		foreach ($check as $check) {
			$exists = $check->font_name;
		}
		
		if($exists == '') {
		
		$sql14 = "INSERT INTO ". $photocrati_fonts . " VALUES (
		'G - IM Fell English'
		,'\'G - IM Fell English SC\', serif'
		)";
		$wpdb->query($sql14);
		
		}
		
		
		$exists = '';
	
		$check = $wpdb->get_results("SELECT font_name FROM ".$wpdb->prefix."photocrati_fonts WHERE font_name = 'G - Josefin Slab'");
		foreach ($check as $check) {
			$exists = $check->font_name;
		}
		
		if($exists == '') {
		
		$sql14 = "INSERT INTO ". $photocrati_fonts . " VALUES (
		'G - Josefin Slab'
		,'\'G - Josefin Slab\', serif'
		)";
		$wpdb->query($sql14);
		
		}
		
		
		$exists = '';
	
		$check = $wpdb->get_results("SELECT font_name FROM ".$wpdb->prefix."photocrati_fonts WHERE font_name = 'G - Lobster'");
		foreach ($check as $check) {
			$exists = $check->font_name;
		}
		
		if($exists == '') {
		
		$sql14 = "INSERT INTO ". $photocrati_fonts . " VALUES (
		'G - Lobster'
		,'\'G - Lobster\', serif'
		)";
		$wpdb->query($sql14);
		
		}
		
		
		$exists = '';
	
		$check = $wpdb->get_results("SELECT font_name FROM ".$wpdb->prefix."photocrati_fonts WHERE font_name = 'G - Orbitron'");
		foreach ($check as $check) {
			$exists = $check->font_name;
		}
		
		if($exists == '') {
		
		$sql14 = "INSERT INTO ". $photocrati_fonts . " VALUES (
		'G - Orbitron'
		,'\'G - Orbitron\', serif'
		)";
		$wpdb->query($sql14);
		
		}
		
		
		$exists = '';
	
		$check = $wpdb->get_results("SELECT font_name FROM ".$wpdb->prefix."photocrati_fonts WHERE font_name = 'G - PT Sans'");
		foreach ($check as $check) {
			$exists = $check->font_name;
		}
		
		if($exists == '') {
		
		$sql14 = "INSERT INTO ". $photocrati_fonts . " VALUES (
		'G - PT Sans'
		,'\'G - PT Sans\', serif'
		)";
		$wpdb->query($sql14);
		
		}
		
		
		$exists = '';
	
		$check = $wpdb->get_results("SELECT font_name FROM ".$wpdb->prefix."photocrati_fonts WHERE font_name = 'G - Raleway'");
		foreach ($check as $check) {
			$exists = $check->font_name;
		}
		
		if($exists == '') {
		
		$sql14 = "INSERT INTO ". $photocrati_fonts . " VALUES (
		'G - Raleway'
		,'\'G - Raleway:100\', serif'
		)";
		$wpdb->query($sql14);
		
		}
		
		
		$exists = '';
	
		$check = $wpdb->get_results("SELECT font_name FROM ".$wpdb->prefix."photocrati_fonts WHERE font_name = 'G - Reenie Beanie'");
		foreach ($check as $check) {
			$exists = $check->font_name;
		}
		
		if($exists == '') {
		
		$sql14 = "INSERT INTO ". $photocrati_fonts . " VALUES (
		'G - Reenie Beanie'
		,'\'G - Reenie Beanie\', serif'
		)";
		$wpdb->query($sql14);
		
		}
		
		
		$exists = '';
	
		$check = $wpdb->get_results("SELECT font_name FROM ".$wpdb->prefix."photocrati_fonts WHERE font_name = 'G - Sniglet'");
		foreach ($check as $check) {
			$exists = $check->font_name;
		}
		
		if($exists == '') {
		
		$sql14 = "INSERT INTO ". $photocrati_fonts . " VALUES (
		'G - Sniglet'
		,'\'G - Sniglet:800\', serif'
		)";
		$wpdb->query($sql14);
		
		}
		
		
		$exists = '';
	
		$check = $wpdb->get_results("SELECT font_name FROM ".$wpdb->prefix."photocrati_fonts WHERE font_name = 'G - Tangerine'");
		foreach ($check as $check) {
			$exists = $check->font_name;
		}
		
		if($exists == '') {
		
		$sql14 = "INSERT INTO ". $photocrati_fonts . " VALUES (
		'G - Tangerine'
		,'\'G - Tangerine\', serif'
		)";
		$wpdb->query($sql14);
		
		}
		
		
		$exists = '';
	
		$check = $wpdb->get_results("SELECT font_name FROM ".$wpdb->prefix."photocrati_fonts WHERE font_name = 'G - Unifraktur'");
		foreach ($check as $check) {
			$exists = $check->font_name;
		}
		
		if($exists == '') {
		
		$sql14 = "INSERT INTO ". $photocrati_fonts . " VALUES (
		'G - Unifraktur'
		,'\'G - UnifrakturMaguntia\', serif'
		)";
		$wpdb->query($sql14);
		
		}
		
		
		$exists = '';
	
		$check = $wpdb->get_results("SELECT font_name FROM ".$wpdb->prefix."photocrati_fonts WHERE font_name = 'G - Yanone Kaffeesatz'");
		foreach ($check as $check) {
			$exists = $check->font_name;
		}
		
		if($exists == '') {
		
		$sql14 = "INSERT INTO ". $photocrati_fonts . " VALUES (
		'G - Yanone Kaffeesatz'
		,'\'G - Yanone Kaffeesatz\', serif'
		)";
		$wpdb->query($sql14);
		
		}
		
	}
	
	
	$photocrati_gallery_ids = $table_prefix . "photocrati_gallery_ids";
	
	if($wpdb->get_var("show tables like '$photocrati_gallery_ids'") != $photocrati_gallery_ids) {
	
		$sql15 = "CREATE TABLE `". $photocrati_gallery_ids . "` ( ";
		$sql15 .= " `id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL, ";
		$sql15 .= " `gallery_id` TINYTEXT NOT NULL, ";
		$sql15 .= " `post_id` SMALLINT NOT NULL, ";
        $sql15 .= " `gal_height` TINYTEXT  NOT NULL, ";
        $sql15 .= " `gal_aspect_ratio` TINYTEXT  NOT NULL, ";
        $sql15 .= " `gal_title` TINYTEXT NOT NULL, ";
        $sql15 .= " `gal_desc` LONGTEXT NOT NULL, ";
		$sql15 .= " `gal_type` SMALLINT NOT NULL ";
		$sql15 .= ") ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1 ; ";
		
		require_once(ABSPATH . 'wp-admin/upgrade-functions.php');
		dbDelta($sql15);
		
	} else {
		
		add_column_if_not_exist($photocrati_gallery_ids, 'gal_desc', 'LONGTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_gallery_ids, 'gal_height', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_gallery_ids, 'gal_aspect_ratio', 'TINYTEXT NOT NULL', '');
		
		$sql = "ALTER TABLE ". $photocrati_gallery_ids . " CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
		$wpdb->query($sql);
		
	}
	
	
	$photocrati_galleries = $table_prefix . "photocrati_galleries";
	
	if($wpdb->get_var("show tables like '$photocrati_galleries'") == $photocrati_galleries) {
		
		add_column_if_not_exist($photocrati_galleries, 'ecomm_options', 'TINYTEXT NOT NULL', '');
	
		$sql = "ALTER TABLE " . $photocrati_galleries . " CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
		$wpdb->query($sql);
		
		$sqladd = "UPDATE ". $photocrati_galleries . " SET ";
		$sqladd .= "ecomm_options='1,2,3,4,5,6,7,8,9,10,11,12'";
		$sqladd .= " WHERE ecomm_options = ''";
		$wpdb->query($sqladd);
	
	} else {
	
		$sql16 = "CREATE TABLE `". $photocrati_galleries . "` ( ";
		$sql16 .= " `id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL, ";
		$sql16 .= " `gallery_id` TINYTEXT NOT NULL, ";
		$sql16 .= " `post_id` SMALLINT NOT NULL, ";
		$sql16 .= " `gal_type` TINYTEXT NOT NULL, ";
		$sql16 .= " `image_name` TINYTEXT NOT NULL, ";
		$sql16 .= " `image_desc` LONGTEXT NOT NULL, ";
		$sql16 .= " `image_alt` LONGTEXT NOT NULL, ";
		$sql16 .= " `image_order` SMALLINT NOT NULL, ";
		$sql16 .= " `ecomm_options` TINYTEXT NOT NULL ";
		$sql16 .= ") ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1 ; ";
		
		require_once(ABSPATH . 'wp-admin/upgrade-functions.php');
		dbDelta($sql16);
		
	}
	
	
	$photocrati_albums = $table_prefix . "photocrati_albums";
	
	if($wpdb->get_var("show tables like '$photocrati_albums'") != $photocrati_albums) {
	
		$sql16 = "CREATE TABLE `". $photocrati_albums . "` ( ";
		$sql16 .= " `id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL, ";
		$sql16 .= " `album_id` TINYTEXT NOT NULL, ";
		$sql16 .= " `gallery_id` TINYTEXT NOT NULL, ";
		$sql16 .= " `album_order` SMALLINT NOT NULL ";
		$sql16 .= ") ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1 ; ";
		
		require_once(ABSPATH . 'wp-admin/upgrade-functions.php');
		dbDelta($sql16);
		
	}
	else
	{
		$sql = "ALTER TABLE " . $photocrati_albums . " CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
		$wpdb->query($sql);
	}
    
    
    $photocrati_gallery_settings = $table_prefix . "photocrati_gallery_settings";
	
	if($wpdb->get_var("show tables like '$photocrati_gallery_settings'") == $photocrati_gallery_settings) {
		
		add_column_if_not_exist($photocrati_gallery_settings, 'image_resolution', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_gallery_settings, 'lightbox_mode', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_gallery_settings, 'lightbox_type', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_gallery_settings, 'gallery_pad2', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_gallery_settings, 'sgallery_t', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_gallery_settings, 'sgallery_ts', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_gallery_settings, 'sgallery_s', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_gallery_settings, 'sgallery_b', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_gallery_settings, 'sgallery_b_color', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_gallery_settings, 'sgallery_cap_loc', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_gallery_settings, 'hfgallery_t', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_gallery_settings, 'hfgallery_ts', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_gallery_settings, 'hfgallery_s', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_gallery_settings, 'hfgallery_b', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_gallery_settings, 'hfgallery_b_color', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_gallery_settings, 'hfgallery_cap_loc', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_gallery_settings, 'bgallery_b', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_gallery_settings, 'bgallery_b_color', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_gallery_settings, 'tgallery_b', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_gallery_settings, 'tgallery_b_color', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_gallery_settings, 'thumb_crop', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_gallery_settings, 'blog_crop', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_gallery_settings, 'film_crop', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_gallery_settings, 'fs_rightclick', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_gallery_settings, 'music_blog', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_gallery_settings, 'music_blog_file', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_gallery_settings, 'music_blog_controls', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_gallery_settings, 'music_blog_auto', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_gallery_settings, 'music_cat', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_gallery_settings, 'music_cat_file', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_gallery_settings, 'music_cat_controls', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_gallery_settings, 'music_cat_auto', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_gallery_settings, 'gallery_h2', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_gallery_settings, 'albuml_per_row', 'LONGTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_gallery_settings, 'albuml_back_color', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_gallery_settings, 'albuml_font_color', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_gallery_settings, 'albuml_font_size', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_gallery_settings, 'albuml_line_color', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_gallery_settings, 'albuml_line_size', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_gallery_settings, 'albumg_per_row', 'LONGTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_gallery_settings, 'albumg_back_color', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_gallery_settings, 'albumg_font_color', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_gallery_settings, 'albumg_font_size', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_gallery_settings, 'albumg_line_color', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_gallery_settings, 'albumg_line_size', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_gallery_settings, 'gallery_buttons1', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_gallery_settings, 'gallery_buttons3', 'TINYTEXT NOT NULL', '');
		
		$sql = "ALTER TABLE " . $photocrati_gallery_settings . " CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
		$wpdb->query($sql);
		
		$check = $wpdb->get_results("SELECT image_resolution FROM ".$wpdb->prefix."photocrati_gallery_settings WHERE id = 1");
		foreach ($check as $check) {
			$image_resolution = $check->image_resolution;
		}
		
		if($image_resolution == '' || $image_resolution == NULL) {
		
		$sqladd = "UPDATE ". $photocrati_gallery_settings . " SET ";
		$sqladd .= "image_resolution='0', ";
		$sqladd .= "sgallery_t='fade', ";
		$sqladd .= "sgallery_ts='400', ";
		$sqladd .= "sgallery_s='4', ";
		$sqladd .= "hfgallery_t='fade', ";
		$sqladd .= "hfgallery_ts='400', ";
		$sqladd .= "hfgallery_s='4', ";
		$sqladd .= "thumb_crop='ON', ";
		$sqladd .= "blog_crop='ON', ";
		$sqladd .= "film_crop='ON', ";
		$sqladd .= "fs_rightclick='ON'";
		$sqladd .= " WHERE id = 1";
		$wpdb->query($sqladd);
		
		}
		
		$check2 = $wpdb->get_results("SELECT music_blog FROM ".$wpdb->prefix."photocrati_gallery_settings WHERE id = 1");
		foreach ($check2 as $check2) {
			$music_blog = $check2->music_blog;
		}
		
		if($music_blog == '' || $music_blog == NULL) {
		
		$sqladd = "UPDATE ". $photocrati_gallery_settings . " SET ";
		$sqladd .= "music_blog='OFF', ";
		$sqladd .= "music_blog_file='', ";
		$sqladd .= "music_blog_controls='YES', ";
		$sqladd .= "music_blog_auto='YES', ";
		$sqladd .= "music_cat='OFF', ";
		$sqladd .= "music_cat_file='', ";
		$sqladd .= "music_cat_controls='YES', ";
		$sqladd .= "music_cat_auto='YES'";
		$sqladd .= " WHERE id = 1";
		$wpdb->query($sqladd);
		
		}
		
		$check3 = $wpdb->get_results("SELECT albuml_per_row, albumg_per_row FROM ".$wpdb->prefix."photocrati_gallery_settings WHERE id = 1");
		foreach ($check3 as $check3) {
			$albuml_per_row = $check3->albuml_per_row;
		}
		
		if($albuml_per_row == '' || $albuml_per_row == NULL) {
		
		$sqladd = "UPDATE ". $photocrati_gallery_settings . " SET ";
		$sqladd .= "albuml_per_row='1', ";
		$sqladd .= "albuml_back_color='FFFFFF', ";
		$sqladd .= "albuml_font_color='333333', ";
		$sqladd .= "albuml_font_size='16', ";
		$sqladd .= "albuml_line_color='AAAAAA', ";
		$sqladd .= "albuml_line_size='1', ";
		$sqladd .= "albumg_per_row='3', ";
		$sqladd .= "albumg_back_color='FFFFFF', ";
		$sqladd .= "albumg_font_color='333333', ";
		$sqladd .= "albumg_font_size='16', ";
		$sqladd .= "albumg_line_color='AAAAAA', ";
		$sqladd .= "albumg_line_size='1' ";
		$sqladd .= " WHERE id = 1";
		$wpdb->query($sqladd);
		
		}
		
		$check4 = $wpdb->get_results("SELECT gallery_pad2 FROM ".$wpdb->prefix."photocrati_gallery_settings WHERE id = 1");
		foreach ($check4 as $check4) {
			$gallery_pad2 = $check4->gallery_pad2;
		}
		
		if($gallery_pad2 == '' || $gallery_pad2 == NULL) {
		
		$sqladd = "UPDATE ". $photocrati_gallery_settings . " SET ";
		$sqladd .= "gallery_pad2='10'";
		$sqladd .= " WHERE id = 1";
		$wpdb->query($sqladd);
		
		}
		
		$check5 = $wpdb->get_results("SELECT lightbox_type FROM ".$wpdb->prefix."photocrati_gallery_settings WHERE id = 1");
		foreach ($check5 as $check5) {
			$lightbox_type = $check5->lightbox_type;
		}
		
		if($lightbox_type == '' || $lightbox_type == NULL) {
		
		$sqladd = "UPDATE ". $photocrati_gallery_settings . " SET ";
		$sqladd .= "lightbox_type='fancy'";
		$sqladd .= " WHERE id = 1";
		$wpdb->query($sqladd);
		
		}
		
		$check6 = $wpdb->get_results("SELECT gallery_buttons1 FROM ".$wpdb->prefix."photocrati_gallery_settings WHERE id = 1");
		foreach ($check6 as $check6) {
			$gallery_buttons1 = $check6->gallery_buttons1;
		}
		
		if($gallery_buttons1 == '' || $gallery_buttons1 == NULL) {
		
		$sqladd = "UPDATE ". $photocrati_gallery_settings . " SET ";
		$sqladd .= "gallery_buttons1='OFF'";
		$sqladd .= " WHERE id = 1";
		$wpdb->query($sqladd);
		
		}
		
		$check7 = $wpdb->get_results("SELECT gallery_buttons3 FROM ".$wpdb->prefix."photocrati_gallery_settings WHERE id = 1");
		foreach ($check7 as $check7) {
			$gallery_buttons3 = $check7->gallery_buttons3;
		}
		
		if($gallery_buttons3 == '' || $gallery_buttons3 == NULL) {
		
		$sqladd = "UPDATE ". $photocrati_gallery_settings . " SET ";
		$sqladd .= "gallery_buttons3='OFF'";
		$sqladd .= " WHERE id = 1";
		$wpdb->query($sqladd);
		
		}
	
	} else {
	
		$sql18 = "CREATE TABLE `". $photocrati_gallery_settings . "` ( ";
		$sql18 .= " `id` INT PRIMARY KEY NOT NULL, ";
		$sql18 .= " `thumbnail_w1` TINYTEXT NOT NULL, ";
		$sql18 .= " `thumbnail_h1` TINYTEXT NOT NULL, ";
		$sql18 .= " `gallery_w1` TINYTEXT NOT NULL, ";
		$sql18 .= " `gallery_cap1` TINYTEXT NOT NULL, ";
		$sql18 .= " `gallery_buttons1` TINYTEXT NOT NULL, ";
		$sql18 .= " `thumbnail_w2` TINYTEXT NOT NULL, ";
		$sql18 .= " `thumbnail_h2` TINYTEXT NOT NULL, ";
		$sql18 .= " `gallery_w2` TINYTEXT NOT NULL, ";
		$sql18 .= " `gallery_pad2` TINYTEXT NOT NULL, ";
		$sql18 .= " `gallery_h2` TINYTEXT NOT NULL, ";
		$sql18 .= " `gallery_cap2` TINYTEXT NOT NULL, ";
		$sql18 .= " `thumbnail_w3` TINYTEXT NOT NULL, ";
		$sql18 .= " `thumbnail_h3` TINYTEXT NOT NULL, ";
		$sql18 .= " `gallery_w3` TINYTEXT NOT NULL, ";
		$sql18 .= " `gallery_cap3` TINYTEXT NOT NULL, ";
		$sql18 .= " `gallery_buttons3` TINYTEXT NOT NULL, ";
		$sql18 .= " `thumbnail_w4` TINYTEXT NOT NULL, ";
		$sql18 .= " `thumbnail_h4` TINYTEXT NOT NULL, ";
		$sql18 .= " `gallery_w4` TINYTEXT NOT NULL, ";
		$sql18 .= " `gallery_cap4` TINYTEXT NOT NULL, ";
		$sql18 .= " `gallery_crop` TINYTEXT NOT NULL, ";
		$sql18 .= " `image_resolution` TINYTEXT NOT NULL, ";
		$sql18 .= " `lightbox_mode` TINYTEXT NOT NULL, ";
		$sql18 .= " `lightbox_type` TINYTEXT NOT NULL, ";
		$sql18 .= " `sgallery_t` TINYTEXT NOT NULL, ";
		$sql18 .= " `sgallery_ts` TINYTEXT NOT NULL, ";
		$sql18 .= " `sgallery_s` TINYTEXT NOT NULL, ";
		$sql18 .= " `sgallery_b` TINYTEXT NOT NULL, ";
		$sql18 .= " `sgallery_b_color` TINYTEXT NOT NULL, ";
		$sql18 .= " `sgallery_cap_loc` TINYTEXT NOT NULL, ";
		$sql18 .= " `hfgallery_t` TINYTEXT NOT NULL, ";
		$sql18 .= " `hfgallery_ts` TINYTEXT NOT NULL, ";
		$sql18 .= " `hfgallery_s` TINYTEXT NOT NULL, ";
		$sql18 .= " `hfgallery_b` TINYTEXT NOT NULL, ";
		$sql18 .= " `hfgallery_b_color` TINYTEXT NOT NULL, ";
		$sql18 .= " `hfgallery_cap_loc` TINYTEXT NOT NULL, ";
		$sql18 .= " `bgallery_b` TINYTEXT NOT NULL, ";
		$sql18 .= " `bgallery_b_color` TINYTEXT NOT NULL, ";
		$sql18 .= " `tgallery_b` TINYTEXT NOT NULL, ";
		$sql18 .= " `tgallery_b_color` TINYTEXT NOT NULL, ";
		$sql18 .= " `thumb_crop` TINYTEXT NOT NULL, ";
		$sql18 .= " `blog_crop` TINYTEXT NOT NULL, ";
		$sql18 .= " `film_crop` TINYTEXT NOT NULL, ";
		$sql18 .= " `fs_rightclick` TINYTEXT NOT NULL, ";
		$sql18 .= " `music_blog` TINYTEXT NOT NULL, ";
		$sql18 .= " `music_blog_file` TINYTEXT NOT NULL, ";
		$sql18 .= " `music_blog_controls` TINYTEXT NOT NULL, ";
		$sql18 .= " `music_blog_auto` TINYTEXT NOT NULL, ";
		$sql18 .= " `music_cat` TINYTEXT NOT NULL, ";
		$sql18 .= " `music_cat_file` TINYTEXT NOT NULL, ";
		$sql18 .= " `music_cat_controls` TINYTEXT NOT NULL, ";
		$sql18 .= " `music_cat_auto` TINYTEXT NOT NULL, ";
		$sql18 .= " `albuml_per_row` TINYTEXT NOT NULL, ";
		$sql18 .= " `albuml_back_color` TINYTEXT NOT NULL, ";
		$sql18 .= " `albuml_font_color` TINYTEXT NOT NULL, ";
		$sql18 .= " `albuml_font_size` TINYTEXT NOT NULL, ";
		$sql18 .= " `albuml_line_color` TINYTEXT NOT NULL, ";
		$sql18 .= " `albuml_line_size` TINYTEXT NOT NULL, ";
		$sql18 .= " `albumg_per_row` TINYTEXT NOT NULL, ";
		$sql18 .= " `albumg_back_color` TINYTEXT NOT NULL, ";
		$sql18 .= " `albumg_font_color` TINYTEXT NOT NULL, ";
		$sql18 .= " `albumg_font_size` TINYTEXT NOT NULL, ";
		$sql18 .= " `albumg_line_color` TINYTEXT NOT NULL, ";
		$sql18 .= " `albumg_line_size` TINYTEXT NOT NULL ";
		$sql18 .= ") ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1 ; ";
		
		require_once(ABSPATH . 'wp-admin/upgrade-functions.php');
		dbDelta($sql18);
        
        $sql19 = "INSERT INTO ". $photocrati_gallery_settings . " VALUES (";
		$sql19 .= "1 "; // id
		$sql19 .= ",'110'"; // thumbnail_w1
		$sql19 .= ",'75'"; // thumbnail_h1
		$sql19 .= ",'800'"; // gallery_w1
		$sql19 .= ",'OFF'"; // gallery_cap1
		$sql19 .= ",'OFF'"; // gallery_buttons1
		$sql19 .= ",'110'"; // thumbnail_w2
		$sql19 .= ",'75'"; // thumbnail_h2
		$sql19 .= ",'800'"; // gallery_w2
		$sql19 .= ",'10'"; // gallery_pad2
		$sql19 .= ",''"; // gallery_h2
		$sql19 .= ",'OFF'"; // gallery_cap2
		$sql19 .= ",'110'"; // thumbnail_w3
		$sql19 .= ",'75'"; // thumbnail_h3
		$sql19 .= ",'800'"; // gallery_w3
		$sql19 .= ",'OFF'"; // gallery_cap3
		$sql19 .= ",'OFF'"; // gallery_buttons3
		$sql19 .= ",'140'"; // thumbnail_w4
		$sql19 .= ",'95'"; // thumbnail_h4
		$sql19 .= ",'800'"; // gallery_w4
		$sql19 .= ",'OFF'"; // gallery_cap4
		$sql19 .= ",'false'"; // gallery_crop
		$sql19 .= ",'0'"; // image_resolution
		$sql19 .= ",'manual'"; // lightbox_mode
		$sql19 .= ",'fancy'"; // lightbox_type
		$sql19 .= ",'fade'"; // sgallery_t
		$sql19 .= ",'400'"; // sgallery_ts
		$sql19 .= ",'4'"; // sgallery_s
		$sql19 .= ",'0'"; // sgallery_b
		$sql19 .= ",''"; // sgallery_b_color
		$sql19 .= ",'overlay_bottom'"; // sgallery_cap_loc
		$sql19 .= ",'fade'"; // hfgallery_t
		$sql19 .= ",'400'"; // hfgallery_ts
		$sql19 .= ",'4'"; // hfgallery_s
		$sql19 .= ",'0'"; // hfgallery_b
		$sql19 .= ",''"; // hfgallery_b_color
		$sql19 .= ",'overlay_bottom'"; // hfgallery_cap_loc
		$sql19 .= ",'0'"; // bgallery_b
		$sql19 .= ",''"; // bgallery_b_color
		$sql19 .= ",'0'"; // tgallery_b
		$sql19 .= ",''"; // tgallery_b_color
		$sql19 .= ",'ON'"; // thumb_crop
		$sql19 .= ",'ON'"; // blog_crop
		$sql19 .= ",'ON'"; // film_crop
		$sql19 .= ",'ON'"; // fs_rightclick
		$sql19 .= ",'OFF'"; // music_blog
		$sql19 .= ",''"; // music_blog_file
		$sql19 .= ",'YES'"; // music_blog_control
		$sql19 .= ",'YES'"; // music_blog_auto
		$sql19 .= ",'OFF'"; // music_cat
		$sql19 .= ",''"; // music_cat_file
		$sql19 .= ",'YES'"; // music_cat_control
		$sql19 .= ",'YES'"; // music_cat_auto
		$sql19 .= ",'1'"; // albuml_per_row
		$sql19 .= ",'FFFFFF'"; // albuml_back_color
		$sql19 .= ",'333333'"; // albuml_font_color
		$sql19 .= ",'16'"; // albuml_font_size
		$sql19 .= ",'AAAAAA'"; // albuml_line_color
		$sql19 .= ",'1'"; // albuml_line_size
		$sql19 .= ",'3'"; // albumg_per_row
		$sql19 .= ",'FFFFFF'"; // albumg_back_color
		$sql19 .= ",'333333'"; // albumg_font_color
		$sql19 .= ",'16'"; // albumg_font_size
		$sql19 .= ",'AAAAAA'"; // albumg_line_color
		$sql19 .= ",'1'"; // albumg_line_size
		$sql19 .= ")";
		$wpdb->query($sql19);
		
	}
    
    
    $photocrati_ecommerce_settings = $table_prefix . "photocrati_ecommerce_settings";
	
	if($wpdb->get_var("show tables like '$photocrati_ecommerce_settings'") == $photocrati_ecommerce_settings) {
		
		$l = 1;
		while($l < 21) {
		add_column_if_not_exist($photocrati_ecommerce_settings, 'ecomm_op'.$l, 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_ecommerce_settings, 'ecomm_cost'.$l, 'TINYTEXT NOT NULL', '');
		$l = $l + 1;
		}
		add_column_if_not_exist($photocrati_ecommerce_settings, 'ecomm_tax', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_ecommerce_settings, 'ecomm_tax_name', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_ecommerce_settings, 'ecomm_tax_method', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_ecommerce_settings, 'ecomm_note', 'LONGTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_ecommerce_settings, 'ecomm_per_row', 'LONGTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_ecommerce_settings, 'ecomm_back_color', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_ecommerce_settings, 'ecomm_font_color', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_ecommerce_settings, 'ecomm_line_color', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_ecommerce_settings, 'ecomm_line_size', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_ecommerce_settings, 'ecomm_but_color', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_ecommerce_settings, 'ecomm_buttext_color', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_ecommerce_settings, 'ecomm_butborder_color', 'TINYTEXT NOT NULL', '');
		add_column_if_not_exist($photocrati_ecommerce_settings, 'ecomm_captions', 'TINYTEXT NOT NULL', '');
	
		$sql = "ALTER TABLE ". $photocrati_ecommerce_settings . " CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
		$wpdb->query($sql);
	} else {
	
		$sql18 = "CREATE TABLE `". $photocrati_ecommerce_settings . "` ( ";
		$sql18 .= " `id` INT PRIMARY KEY NOT NULL, ";
		$sql18 .= " `pp_account` TINYTEXT NOT NULL, ";
		$sql18 .= " `pp_return` TINYTEXT NOT NULL, ";
		$sql18 .= " `pp_profile` TINYTEXT NOT NULL, ";
		$l = 1;
		while($l < 21) {	
		$sql18 .= " `ecomm_op$l` TINYTEXT NOT NULL, ";
		$sql18 .= " `ecomm_cost$l` TINYTEXT NOT NULL, ";
		$l = $l + 1;
		}
		$sql18 .= " `ecomm_currency` TINYTEXT NOT NULL, ";
		$sql18 .= " `ecomm_country` TINYTEXT NOT NULL, ";
		$sql18 .= " `ecomm_title` TINYTEXT NOT NULL, ";
		$sql18 .= " `ecomm_empty` TINYTEXT NOT NULL, ";
		$sql18 .= " `ecomm_but_text` TINYTEXT NOT NULL, ";
		$sql18 .= " `ecomm_but_image` TINYTEXT NOT NULL, ";
		$sql18 .= " `ecomm_tax` TINYTEXT NOT NULL, ";
		$sql18 .= " `ecomm_tax_name` TINYTEXT NOT NULL, ";
		$sql18 .= " `ecomm_tax_method` TINYTEXT NOT NULL, ";
		$sql18 .= " `ecomm_ship_st` TINYTEXT NOT NULL, ";
		$sql18 .= " `ecomm_ship_exp` TINYTEXT NOT NULL, ";
		$sql18 .= " `ecomm_ship_method` TINYTEXT NOT NULL, ";
		$sql18 .= " `ecomm_ship_free` TINYTEXT NOT NULL, ";
		$sql18 .= " `ecomm_ship_en` TINYTEXT NOT NULL, ";
		$sql18 .= " `ecomm_ship_int` TINYTEXT NOT NULL, ";
		$sql18 .= " `ecomm_note` LONGTEXT NOT NULL, ";
		$sql18 .= " `ecomm_per_row` TINYTEXT NOT NULL, ";
		$sql18 .= " `ecomm_captions` TINYTEXT NOT NULL, ";
		$sql18 .= " `ecomm_back_color` TINYTEXT NOT NULL, ";
		$sql18 .= " `ecomm_font_color` TINYTEXT NOT NULL, ";
		$sql18 .= " `ecomm_line_color` TINYTEXT NOT NULL, ";
		$sql18 .= " `ecomm_line_size` TINYTEXT NOT NULL, ";
		$sql18 .= " `ecomm_but_color` TINYTEXT NOT NULL, ";
		$sql18 .= " `ecomm_buttext_color` TINYTEXT NOT NULL, ";
		$sql18 .= " `ecomm_butborder_color` TINYTEXT NOT NULL ";
		$sql18 .= ") ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1 ; ";
		
		require_once(ABSPATH . 'wp-admin/upgrade-functions.php');
		dbDelta($sql18);
        
        $sql19 = "INSERT INTO ". $photocrati_ecommerce_settings . " VALUES (";
		$sql19 .= "1 "; // id
		$sql19 .= ",''"; // pp_account
		$sql19 .= ",''"; // pp_return
		$sql19 .= ",'OFF'"; // pp_profile
		$l = 1;
		while($l < 21) {
		$sql19 .= ",''"; // ecomm_op	
		$sql19 .= ",''"; // ecomm_cost	
		$l = $l + 1;
		}
		$sql19 .= ",'USD'"; // ecomm_currency
		$sql19 .= ",'US'"; // ecomm_country
		$sql19 .= ",'Shopping Cart'"; // ecomm_title
		$sql19 .= ",'There are no items in your shopping cart'"; // ecomm_empty
		$sql19 .= ",'Add to Cart'"; // ecomm_but_text
		$sql19 .= ",''"; // ecomm_but_image
		$sql19 .= ",''"; // ecomm_tax
		$sql19 .= ",''"; // ecomm_tax_name
		$sql19 .= ",'before'"; // ecomm_tax_method
		$sql19 .= ",'5.00'"; // ecomm_ship_st
		$sql19 .= ",''"; // ecomm_ship_exp
		$sql19 .= ",'total'"; // ecomm_ship_method
		$sql19 .= ",''"; // ecomm_ship_free
		$sql19 .= ",'ON'"; // ecomm_ship_en
		$sql19 .= ",'10.00'"; // ecomm_ship_int
		$sql19 .= ",'Please enter your name and email address so we can get in touch if we have questions about your order. Once you click Pay Now, you\'ll be taken to Paypal for secure payment processing. Thanks very much for your purchase!'"; // ecomm_note
		$sql19 .= ",'4'"; // ecomm_per_row
		$sql19 .= ",'ON'"; // ecomm_captions
		$sql19 .= ",'F1F1F1'"; // ecomm_back_color
		$sql19 .= ",'333333'"; // ecomm_font_color
		$sql19 .= ",'CCCCCC'"; // ecomm_line_color
		$sql19 .= ",'1'"; // ecomm_line_size
		$sql19 .= ",'CCCCCC'"; // ecomm_but_color
		$sql19 .= ",'333333'"; // ecomm_buttext_color
		$sql19 .= ",'999999'"; // ecomm_butborder_color
		$sql19 .= ")";
		$wpdb->query($sql19);
		
	}
 
 
// Schedule Gallery Move 
wp_schedule_single_event(time()+30, 'ph_move_gallery_files');
	
}


// Move all images to the uploads folder for the new gallery system

function check_for_empty_folder($folder) {
	$files = array ();
	if ( $handle = opendir ( $folder ) ) {
		while ( false !== ( $file = readdir ( $handle ) ) ) {
			if ( $file != "." && $file != ".." ) {
				$files [] = $file;
			}
		}
		closedir ( $handle );
	}
	return ( count ( $files ) > 0 ) ? FALSE : TRUE;
}

function move_galleries() {
	
	$upload_dir = wp_upload_dir();
	$path = dirname(dirname(__FILE__))."/galleries";
	$dest = $upload_dir['basedir']."/galleries";
		
	if (!is_dir($dest)) {
		mkdir( $dest, 0755 );
	}

	global $wpdb;
	$gallery = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."photocrati_gallery_ids");
    foreach ($gallery as $gallery) {
	
		if (!is_dir($dest.'/post-'.$gallery->post_id)) {
			
			mkdir( $dest.'/post-'.$gallery->post_id.'/', 0755 );
			mkdir( $dest.'/post-'.$gallery->post_id.'/full/', 0755 );
			mkdir( $dest.'/post-'.$gallery->post_id.'/thumbnails/', 0755 );
			
		}

			
		$images = $wpdb->get_results("SELECT image_name FROM ".$wpdb->prefix."photocrati_galleries WHERE gallery_id = '".$gallery->gallery_id."'");
		foreach ($images as $images) {
			
			if (!file_exists($dest.'/post-'.$gallery->post_id.'/'.$images->image_name)) {
					
				if (copy( $path.'/post-'.$gallery->post_id.'/'.$images->image_name, $dest.'/post-'.$gallery->post_id.'/'.$images->image_name )) {
			
					if (file_exists($dest.'/post-'.$gallery->post_id.'/'.$images->image_name)) {
						unlink($path.'/post-'.$gallery->post_id.'/'.$images->image_name);
					}
						
				}
					
				if (copy( $path.'/post-'.$gallery->post_id.'/full/'.$images->image_name, $dest.'/post-'.$gallery->post_id.'/full/'.$images->image_name )) {
			
					if (file_exists($dest.'/post-'.$gallery->post_id.'/full/'.$images->image_name)) {
						unlink( $path.'/post-'.$gallery->post_id.'/full/'.$images->image_name );
					}
						
				}
					
				if (copy( $path.'/post-'.$gallery->post_id.'/thumbnails/'.$images->image_name, $dest.'/post-'.$gallery->post_id.'/thumbnails/'.$images->image_name )) {
			
					if (file_exists($dest.'/post-'.$gallery->post_id.'/thumbnails/'.$images->image_name)) {
						unlink( $path.'/post-'.$gallery->post_id.'/thumbnails/'.$images->image_name );
					}
						
				}
					
				if (copy( $path.'/post-'.$gallery->post_id.'/thumbnails/med-'.$images->image_name, $dest.'/post-'.$gallery->post_id.'/thumbnails/med-'.$images->image_name )) {
			
					if (file_exists($dest.'/post-'.$gallery->post_id.'/thumbnails/med-'.$images->image_name)) {
						unlink( $path.'/post-'.$gallery->post_id.'/thumbnails/med-'.$images->image_name );
					}
						
				}
					
			}
		
		}
	
		if (check_for_empty_folder($path.'/post-'.$gallery->post_id.'/thumbnails/')) {
			
			rmdir( $path.'/post-'.$gallery->post_id.'/thumbnails/' );
			
		}
	
		if (check_for_empty_folder($path.'/post-'.$gallery->post_id.'/full/')) {
			
			rmdir( $path.'/post-'.$gallery->post_id.'/full/' );
			
		}
	
		if (check_for_empty_folder($path.'/post-'.$gallery->post_id.'/')) {
			
			rmdir( $path.'/post-'.$gallery->post_id.'/' );
			
		}
	
	}
	
}

add_action('ph_move_gallery_files', 'move_galleries');


$photocrati_version = $table_prefix . "photocrati_version";
$check = $wpdb->get_results("SELECT version FROM ".$wpdb->prefix."photocrati_version WHERE id = 1");
foreach ($check as $check) {
	$dbversion = $check->version;
}

if($wpdb->get_var("show tables like '$photocrati_version'") != $photocrati_version || $dbversion != $version) {
	
add_action('admin_init', 'createtable_photocrati_admin');

}
	
	
$upload_dir =  dirname(dirname(__FILE__)) . '/images/uploads/';

if(file_exists($upload_dir.'Doilly_BG2.jpg')){
	
	unlink($upload_dir.'Doilly_BG2.jpg');
	
}

?>
