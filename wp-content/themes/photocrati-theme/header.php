<?php

	if($_GET["photocrati-debug"] == '1'){
		define('ABSBUG', dirname(__FILE__));
		require_once(ABSBUG.'/admin/scripts/ChromePhp.php');
		require_once(ABSBUG.'/admin/scripts/FirePHP.class.php');
		$firephp = FirePHP::getInstance(true);
		require_once(ABSBUG.'/admin/scripts/fb.php');
	}
	
	/* IMPORTANT! This code retrieves the custom logo options & dynamic styling */
	global $wpdb;
	$style = $wpdb->get_results("SELECT custom_logo,custom_logo_image,dynamic_style,title_style,description_style,h1_font_style,h2_font_style,h3_font_style,h4_font_style,h5_font_style,sidebar_title_style,logo_menu_position,menu_font_style,submenu_font_style,footer_widget_style FROM ".$wpdb->prefix."photocrati_styles WHERE option_set = 1");
	foreach ($style as $style) {
		$custom_logo = $style->custom_logo;
		$custom_logo_image = $style->custom_logo_image;
		$dynamic_style =  $style->dynamic_style;
		$title_style =  $style->title_style;
		$h1_font_style = $style->h1_font_style;
		$h2_font_style = $style->h2_font_style;
		$h3_font_style = $style->h3_font_style;
		$h4_font_style = $style->h4_font_style;
		$h5_font_style = $style->h5_font_style;
		$sidebar_title_style = $style->sidebar_title_style;
		$description_style =  $style->description_style;
		$logo_menu_position = $style->logo_menu_position;
		$menu_font_style = $style->menu_font_style;
		$submenu_font_style = $style->submenu_font_style;
		$footer_widget_style = $style->footer_widget_style;
	}
	$rcp = $wpdb->get_results("SELECT fs_rightclick,lightbox_mode,lightbox_type FROM ".$wpdb->prefix."photocrati_gallery_settings WHERE id = 1");
	foreach ($rcp as $rcp) {
		$fs_rightclick = $rcp->fs_rightclick;
		$lightbox_mode = $rcp->lightbox_mode;
		$lightbox_type = $rcp->lightbox_type;
	}
	$music = $wpdb->get_results("SELECT music_blog,music_blog_auto,music_blog_file,music_blog_controls,music_cat,music_cat_auto,music_cat_file,music_cat_controls FROM ".$wpdb->prefix."photocrati_gallery_settings WHERE id = 1");
	foreach ($music as $music) {
		$music_blog = $music->music_blog;
		$music_blog_auto = $music->music_blog_auto;
		$music_blog_controls = $music->music_blog_controls;
		$music_blog_file = $music->music_blog_file;
		$music_cat = $music->music_cat;
		$music_cat_auto = $music->music_cat_auto;
		$music_cat_controls = $music->music_cat_controls;
		$music_cat_file = $music->music_cat_file;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
    <title><?php
        if ( is_single() ) { single_post_title(); }       
        elseif ( is_home() || is_front_page() ) { bloginfo('name'); print ' | '; bloginfo('description'); get_page_number(); }
        elseif ( is_page() ) { single_post_title(''); }
        elseif ( is_search() ) { bloginfo('name'); print ' | Search results for ' . wp_specialchars($s); get_page_number(); }
        elseif ( is_404() ) { bloginfo('name'); print ' | Not Found'; }
        else { bloginfo('name'); wp_title('|'); get_page_number(); }
    ?></title>
	
	<meta http-equiv="content-type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	
	<?php
	if(strpos($title_style, 'G - ') === false) { } else {
	$gfont = str_replace(" ", "+", str_replace(", serif", "", str_replace("G - ", "", str_replace("'", "", str_replace("\'", "", $title_style)))));
	?>
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=<?php echo $gfont; ?>" />
	<?php } ?>
	
	<?php
	if(strpos($sidebar_title_style, 'G - ') === false) { } else {
	$gfont = str_replace(" ", "+", str_replace(", serif", "", str_replace("G - ", "", str_replace("'", "", str_replace("\'", "", $sidebar_title_style)))));
	?>
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=<?php echo $gfont; ?>" />
	<?php } ?>
	
	<?php
	if(strpos($h1_font_style, 'G - ') === false) { } else {
	$gfont = str_replace(" ", "+", str_replace(", serif", "", str_replace("G - ", "", str_replace("'", "", str_replace("\'", "", $h1_font_style)))));
	?>
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=<?php echo $gfont; ?>" />
	<?php } ?>
	
	<?php
	if(strpos($h2_font_style, 'G - ') === false) { } else {
	$gfont = str_replace(" ", "+", str_replace(", serif", "", str_replace("G - ", "", str_replace("'", "", str_replace("\'", "", $h2_font_style)))));
	?>
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=<?php echo $gfont; ?>" />
	<?php } ?>
	
	<?php
	if(strpos($h3_font_style, 'G - ') === false) { } else {
	$gfont = str_replace(" ", "+", str_replace(", serif", "", str_replace("G - ", "", str_replace("'", "", str_replace("\'", "", $h3_font_style)))));
	?>
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=<?php echo $gfont; ?>" />
	<?php } ?>
	
	<?php
	if(strpos($h4_font_style, 'G - ') === false) { } else {
	$gfont = str_replace(" ", "+", str_replace(", serif", "", str_replace("G - ", "", str_replace("'", "", str_replace("\'", "", $h4_font_style)))));
	?>
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=<?php echo $gfont; ?>" />
	<?php } ?>
	
	<?php
	if(strpos($h5_font_style, 'G - ') === false) { } else {
	$gfont = str_replace(" ", "+", str_replace(", serif", "", str_replace("G - ", "", str_replace("'", "", str_replace("\'", "", $h5_font_style)))));
	?>
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=<?php echo $gfont; ?>" />
	<?php } ?>
	
	<?php
	if(strpos($description_style, 'G - ') === false) { } else {
	$gfontd = str_replace(" ", "+", str_replace(", serif", "", str_replace("G - ", "", str_replace("\'", "", $description_style))));
	?>
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=<?php echo $gfontd; ?>" />
	<?php } ?>
	
	<?php
	if(strpos($menu_font_style, 'G - ') === false) { } else {
	$gfontd = str_replace(" ", "+", str_replace(", serif", "", str_replace("G - ", "", str_replace("\'", "", $menu_font_style))));
	?>
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=<?php echo $gfontd; ?>" />
	<?php } ?>
	
	<?php
	if(strpos($submenu_font_style, 'G - ') === false) { } else {
	$gfontd = str_replace(" ", "+", str_replace(", serif", "", str_replace("G - ", "", str_replace("\'", "", $submenu_font_style))));
	?>
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=<?php echo $gfontd; ?>" />
	<?php } ?>
	
	<?php
	if(strpos($footer_widget_style, 'G - ') === false) { } else {
	$gfontd = str_replace(" ", "+", str_replace(", serif", "", str_replace("G - ", "", str_replace("\'", "", $footer_widget_style))));
	?>
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=<?php echo $gfontd; ?>" />
	<?php } ?>
	
	<!-- IMPORTANT! Do not remove this code. This is used for enabling & disabling the dynamic styling -->
		<?php if($dynamic_style == 'YES') { ?>
        
            <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/styles/dynamic-style.php" />
			<?php if($logo_menu_position == 'left-right') { ?>
			<!--[if lt IE 8]>
			<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/styles/style-ie7-menufix.css" type="text/css" />
			<![endif]-->
			<?php } ?>
            
        <?php } else { ?>
        
            <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/styles/style.css" />
			<?php if($logo_menu_position == 'left-right') { ?>
			<!--[if lt IE 8]>
			<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/styles/style-ie7-menufix.css" type="text/css" />
			<![endif]-->
			<?php } ?>
        
        <?php } ?>
    <!-- End dynamic styling -->
	
    <!--[if IE 8]>
    <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/styles/style-ie.css" type="text/css" />
    <![endif]-->
    
    <!--[if lt IE 8]>
    <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/styles/style-ie7.css" type="text/css" />
    <![endif]-->
	
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/admin/css/jquery.lightbox-0.5.css" />
	
	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
	
	<?php
	if( !is_admin()){
		wp_deregister_script('jquery');
		wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"), false, '');
		wp_enqueue_script('jquery');
	 }
	?>
	
	<?php wp_head(); ?>
	
	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url'); ?>" title="<?php printf( __( '%s latest posts', 'photocrati-framework' ), wp_specialchars( get_bloginfo('name'), 1 ) ); ?>" />
	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('comments_rss2_url') ?>" title="<?php printf( __( '%s latest comments', 'photocrati-framework' ), wp_specialchars( get_bloginfo('name'), 1 ) ); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<?php if($fs_rightclick == "ON") { ?>
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/scripts/clickprotect.js"></script>
	<?php } ?>
	
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/scripts/jquery.jplayer.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/scripts/jplayer.style.css" />

<?php if($lightbox_type == 'fancy') { ?>
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/admin/css/jquery.fancybox-1.3.4.css" type="text/css" />
<?php } else if($lightbox_type == 'light') { ?>
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/admin/css/jquery.fancybox-1.3.4-light.css" type="text/css" />
<?php } else if($lightbox_type == 'thick') { ?>
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/admin/css/jquery.fancybox-1.3.4-thick.css" type="text/css" />
<?php } ?>
	
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/admin/js/jquery.fancybox-1.3.4.pack.js"></script>

<script type="text/javascript">
//<![CDATA[	
jQuery.noConflict();

(function () {
	var div = document.createElement('div'),
	ref = document.getElementsByTagName('base')[0] ||
		    document.getElementsByTagName('script')[0];

	div.innerHTML = '&shy;<style> iframe { visibility: hidden; } </style>';

	ref.parentNode.insertBefore(div, ref);

	jQuery(window).load(function() {
		div.parentNode.removeChild(div);
	});
})();

	function formatTitle(title, currentArray, currentIndex, currentOpts) {
		return '<div id="tip7-title"><span><a href="javascript:;" onclick="jQuery.fancybox.close();"><img src="<?php bloginfo('template_url'); ?>/admin/css/closelabel.gif" alt="close label" /></a></span>' + (title && title.length ? '<b>' + title + '</b>' : '' ) + 'Image ' + (currentIndex + 1) + ' of ' + currentArray.length + '</div>';
	}
	//]]>
	jQuery(document).ready(function() {
			
	jQuery("a.decoy").fancybox({
		'overlayColor'		: '#0b0b0f',
		'overlayOpacity'	: 0.8,
		'centerOnScroll'	: true,
		<?php if($lightbox_type == 'fancy') { ?>
		'titlePosition'		: 'outside'
		<?php } else if($lightbox_type == 'light') { ?>
		'titlePosition'		: 'inside',
		'titleFormat'		: formatTitle
		<?php } else if($lightbox_type == 'thick') { ?>
		'titlePosition' 	: 'inside',
		'showNavArrows'		: false,
    	'titleFormat'       : function(title, currentArray, currentIndex, currentOpts) {
			var gettitle;
			gettitle = '<span id="fancybox-title-inside">'+title+'<BR><span class="counter">Image ' +  (currentIndex + 1) + ' of ' + currentArray.length + ' &nbsp;&nbsp;';
			if(currentIndex != 0) {
			gettitle = gettitle + '<a onclick="jQuery.fancybox.prev();" style="cursor:pointer;">&laquo; Prev</a> | ';
			}
			gettitle = gettitle + '<a onclick="jQuery.fancybox.next();" style="cursor:pointer;">Next &raquo;</a></span>';
			
			gettitle = gettitle + '<div id="close_button"><a onclick="jQuery.fancybox.close();" style="cursor:pointer;">Close</a></div></span>';
		
			return gettitle;
    	}
		<?php } ?>
		//'href'				: ''+site+''
	});
	
	<?php 
	
	$lightbox_selector = '.photocrati_lightbox_always';
	$lightbox_custom = null;
	
	switch($lightbox_mode)
	{
		case 'always':
		{
			$lightbox_custom = 'a:has(\\\'[class*=\\\'wp-image\\\']\\\'), .photocrati_lightbox';
			
			break;
		}
		case 'never':
		{
			break;
		}
		case 'manual':
		default:
		{
			$lightbox_custom = '.photocrati_lightbox';
			
			break;
		}
	}
	
	if ($lightbox_custom != null)
	{
		$lightbox_selector .= ', ' . $lightbox_custom;
	}
	
	if ($lightbox_selector != null)
	{
	?>

	var lighboxSelector = '<?php echo $lightbox_selector; ?>';

	jQuery(lighboxSelector).fancybox({
		'overlayColor'		: '#0b0b0f',
		'overlayOpacity'	: 0.8,
		'centerOnScroll'	: true,
		<?php if($lightbox_type == 'fancy') { ?>
		'titlePosition'		: 'outside'
		<?php } else if($lightbox_type == 'light') { ?>
		'titlePosition'		: 'inside',
		'titleFormat'		: formatTitle
		<?php } else if($lightbox_type == 'thick') { ?>
		'titlePosition' 	: 'inside',
		'showNavArrows'		: false,
		'titleFormat'       : function(title, currentArray, currentIndex, currentOpts) {
			var gettitle;
			gettitle = '<span id="fancybox-title-inside">'+title+'<BR><span class="counter">Image ' +  (currentIndex + 1) + ' of ' + currentArray.length + ' &nbsp;&nbsp;';
			if(currentIndex != 0) {
			gettitle = gettitle + '<a onclick="jQuery.fancybox.prev();" style="cursor:pointer;">&laquo; Prev</a> | ';
			}
			gettitle = gettitle + '<a onclick="jQuery.fancybox.next();" style="cursor:pointer;">Next &raquo;</a></span>';
			
			gettitle = gettitle + '<div id="close_button"><a onclick="jQuery.fancybox.close();" style="cursor:pointer;">Close</a></div></span>';
		
			return gettitle;
		}
		<?php } ?>
	});
		
	<?php
	}
	?>
	
});
</script>

<?php if(is_single() || is_page()) { ?>
	
	<script type="text/javascript">
	jQuery.noConflict();
	jQuery(document).ready(function() {
		
		<?php if(get_post_meta($post->ID, 'music', true) == "YES") { ?>
		
		jQuery("#jquery_jplayer").jPlayer({
			ready: function () {
				<?php if(get_post_meta($post->ID, 'music_auto', true) == "YES") { ?>
				this.element.jPlayer("setFile", "<?php echo get_post_meta($post->ID, 'music_file', true); ?>").jPlayer("play");
				<?php } else { ?>
				this.element.jPlayer("setFile", "<?php echo get_post_meta($post->ID, 'music_file', true); ?>");
				<?php } ?>
			},
			oggSupport: false,
			preload: 'none',
			swfPath: "<?php echo get_bloginfo('template_directory'); ?>/scripts"
		})
		.jPlayer("onSoundComplete", function() {
			this.element.jPlayer("play");
		});
	
		<?php } ?>
			
	});
	</script>
	
	<?php if(get_post_meta($post->ID, 'music_controls', true) == "NO") { ?>
	
	<style type="text/css">
	.jp-single-player {
		display:none;
	}
	</style>
	
	<?php } ?>
	
<?php } ?>


<?php if(is_category() || is_archive()) { ?>

	<?php if($music_cat == "ON") { ?>
	
	<script type="text/javascript">
	jQuery.noConflict();
	jQuery(document).ready(function() {
		
		jQuery("#jquery_jplayer").jPlayer({
			ready: function () {
				<?php if($music_cat_auto == "YES") { ?>
				this.element.jPlayer("setFile", "<?php echo $music_cat_file; ?>").jPlayer("play");
				<?php } else { ?>
				this.element.jPlayer("setFile", "<?php echo $music_cat_file; ?>");
				<?php } ?>
			},
			oggSupport: false,
			preload: 'none',
			swfPath: "<?php echo get_bloginfo('template_directory'); ?>/scripts"
		})
		.jPlayer("onSoundComplete", function() {
			this.element.jPlayer("play");
		});
	
	});
	</script>
	
	<?php if($music_cat_controls == "NO") { ?>
	
	<style>
	.jp-single-player {
		display:none;
	}
	</style>
	
	<?php } ?>
	
	<?php } ?>
	
<?php } ?>


</head>

<body <?php body_class(); ?> id="themebody">
<div id="main_container">
<div id="decoys"></div>
<div id="header">
		<div id="masthead">
		
			<div id="branding">
				<div id="blog-title">
                    <span>
                        <a href="<?php bloginfo( 'url' ) ?>/" title="<?php bloginfo( 'name' ) ?>" rel="home">
                            <?php if($custom_logo == 'custom') { ?>
                                <img src="<?php bloginfo('template_directory'); ?>/images/uploads/<?php echo $custom_logo_image; ?>" border="0" alt="<?php bloginfo( 'name' ) ?>" />
                            <?php } else if($custom_logo == 'default') { ?>
                            	<img src="<?php bloginfo('template_directory'); ?>/images/logo.png" border="0" alt="<?php bloginfo( 'name' ) ?>" />
                            <?php } else { ?>
                                <h1><?php bloginfo('name'); ?></h1>
                                <div class="description"><?php bloginfo('description'); ?></div>
                            <?php } ?>
                        </a>
                    </span>
                </div>
			</div><!-- #branding -->
			
			<div id="menu_wrapper">
                <?php if ( function_exists( wp_nav_menu ) ) { //Check if function exists for less than Wordpress 3.0 ?>
                <?php wp_nav_menu( array( 'container_class' => 'menu', 'theme_location' => 'primary' ) ); ?>
                <?php } else { ?>
                <?php wp_page_menu( 'sort_column=menu_order' ); ?>	
                <?php } ?>	
			</div><!-- #access -->
			
		</div><!-- #masthead -->	
</div><!-- #header -->

<div id="wrapper" class="hfeed">

	<div id="main">
