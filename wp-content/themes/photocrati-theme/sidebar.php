<?php
	/* This code retrieves the sidebar social media options */
	global $wpdb;
	$style = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."photocrati_styles WHERE option_set = 1");
	foreach ($style as $style) {
		$custom_sidebar = $style->custom_sidebar;
		$custom_sidebar_position = $style->custom_sidebar_position;
		$custom_sidebar_html = $style->custom_sidebar_html;
		$social_media = $style->social_media;
		$social_media_title = $style->social_media_title;
		$social_media_set = $style->social_media_set;
		$social_rss = $style->social_rss;
		$social_email = $style->social_email;
		$social_twitter = $style->social_twitter;
		$social_facebook = $style->social_facebook;
		$social_flickr = $style->social_flickr;
	}
?>

<script type="text/javascript">
jQuery.noConflict();
jQuery(document).ready(function()
{

	jQuery(function(){
    var spt = jQuery('span.mailme');
    var at = / at /;
    var dot = / dot /g;
    var addr = jQuery(spt).text().replace(at,"@").replace(dot,".");
    jQuery(spt).after('<a href="mailto:'+addr+'" title="Email us"><img src="<?php bloginfo('template_directory'); ?>/images/social/<?php echo $social_media_set; ?>-email.png" alt="email" /></a>')
    .hover(function(){window.status="Email us!";}, function(){window.status="";});
    jQuery(spt).remove();
	jQuery('span.mailme').show();
    });
	
});
</script>

<div id="sidebar">	

	<!-- This is the dynamic social media icons -->
	<?php if($social_media == 'ON') { ?>
	<div class="social-media">
    
    	<?php if($social_media_title <> '') { ?>
    	<h3 class="widget-title"><?php echo $social_media_title; ?></h3>
        <?php } ?>
    
    	<?php if($social_rss <> '') { ?>
    	<a href="<?php echo $social_rss; ?>" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/social/<?php echo $social_media_set; ?>-rss.png" alt="rss" /></a>
    	<?php } ?>
        
        <?php if($social_email <> '') { ?>
        <span class="mailme" style="display:none;"><?php echo str_replace('.', ' dot ', str_replace('@', ' at ', $social_email)); ?></span>
    	<?php } ?>
        
        <?php if($social_twitter <> '') { ?>
    	<a href="http://www.twitter.com/<?php echo $social_twitter; ?>" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/social/<?php echo $social_media_set; ?>-twitter.png" alt="twitter" /></a>
    	<?php } ?>
        
        <?php if($social_facebook <> '') { ?>
    	<a href="http://www.facebook.com/<?php echo $social_facebook; ?>" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/social/<?php echo $social_media_set; ?>-facebook.png" alt="facebook" /></a>
    	<?php } ?>
        
        <?php if($social_flickr <> '') { ?>
    	<a href="http://www.flickr.com/<?php echo $social_flickr; ?>" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/social/<?php echo $social_media_set; ?>-flickr.png" alt="flickr" /></a>
    	<?php } ?>
    
    </div>
    <?php } ?>
	<!-- End dynamic social media icons -->

	
	<!-- Custom sidebar code above widgets -->
    <?php 
	if($custom_sidebar == 'ON') { 
		if($custom_sidebar_position == 'ABOVE') { 
		echo '<div id="primary_custom" class="widget-area"><ul><li>';
		echo stripslashes(str_replace('\"', '"', $custom_sidebar_html)); 
		echo '</li></ul></div>';
		}
	}
	?>
    <!-- End custom sidebar code above widgets -->

	<?php if ( is_sidebar_active('primary_widget_area') ) : ?>
		<div id="primary" class="widget-area">
			<ul>
				<?php dynamic_sidebar('primary_widget_area'); ?>
			</ul>
		</div><!-- #primary .widget-area -->
	<?php endif; ?>	
    
    <!-- Custom sidebar code below widgets -->
    <?php 
	if($custom_sidebar == 'ON') { 
		if($custom_sidebar_position == 'BELOW') { 
		echo '<div id="primary_custom" class="widget-area"><ul><li>';
		echo stripslashes(str_replace('\"', '"', $custom_sidebar_html)); 
		echo '</li></ul></div>';
		}
	}
	?>
    <!-- End custom sidebar code below widgets -->
    	
</div>	
