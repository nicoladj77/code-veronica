<?php
	/* This code retrieves the footer copyright options */
	global $wpdb;
	$style = $wpdb->get_results("SELECT footer_copy,show_photocrati,google_analytics,footer_widget_placement FROM ".$wpdb->prefix."photocrati_styles WHERE option_set = 1");
	foreach ($style as $style) {
		$footer_copy = $style->footer_copy;
		$show_photocrati = $style->show_photocrati;
		$google_analytics = $style->google_analytics;
		$footer_widget_placement = $style->footer_widget_placement;
	}
?>	
    
		</div><!-- #container -->
    </div><!-- #main -->

</div><!-- #wrapper -->	

</div> <!-- #main_container -->

<div class="footer_wrapper">
	
	<?php
	
	$footerwidgetstop = '<script type="text/javascript">
	jQuery.noConflict();
	jQuery(document).ready(function()
	{
		
		var countwidgets = jQuery(".footer-widget-container").size();
		var widgetarea = jQuery(".footer-widget-area").width();
		var widgetsize = widgetarea / countwidgets - 20;
		jQuery(".footer-widget-container").css("width", widgetsize+"px");
			
	});
	</script>
    
	<div id="footer-widgets" class="footer-widget-area">';
	$footerwidgetsbot = '</div><!-- #footer .widget-area -->';
	
	if($footer_widget_placement == '4' && is_front_page() && is_sidebar_active('footer_widget_area')) {
		echo $footerwidgetstop;
		dynamic_sidebar("footer_widget_area");
		echo $footerwidgetsbot;
	} else if($footer_widget_placement == '3' && is_sidebar_active('footer_widget_area')) {
		echo $footerwidgetstop;
		dynamic_sidebar("footer_widget_area");
		echo $footerwidgetsbot;
	} else if($footer_widget_placement == '2' && !is_front_page() && is_sidebar_active('footer_widget_area')) {
		echo $footerwidgetstop;
		dynamic_sidebar("footer_widget_area");
		echo $footerwidgetsbot;
	} else if($footer_widget_placement == '1' && !is_page() && is_sidebar_active('footer_widget_area')) {
		echo $footerwidgetstop;
		dynamic_sidebar("footer_widget_area");
		echo $footerwidgetsbot;
	} else if($footer_widget_placement == '0') {
		
	}
	?> 	
    
	<div id="footer">
		<div id="colophon">
		
        	<?php if ( function_exists( wp_nav_menu ) ) { //Check if function exists for less than Wordpress 3.0 ?>
			<?php wp_nav_menu( array( 'container_class' => 'footer_menu', 'menu_class' => '', 'theme_location' => 'footer', 'fallback_cb' => '', 'depth' => 1 ) ); ?>		
        	<?php } ?>
        
			<div id="site-info">
				<p>
				<?php
				/* This inserts the footer copyright notice */
				if($footer_copy <> '') {
					echo str_replace('\"', '"', str_replace("\'", "'", $footer_copy));
					if($show_photocrati <> 'hide') {
					echo ' | ';
					}
				}
				?>
				<?php if($show_photocrati <> 'hide') { ?>
				Powered by <span id="theme-link"><a href="http://www.photocrati.com/" title="<?php _e( 'Photocrati Wordpress Themes', 'photocrati-framework' ) ?>" rel="designer"><?php _e( 'Photocrati', 'photocrati-framework' ) ?></a></span>
				<?php } ?>
				</p>			
			</div><!-- #site-info -->
			
		</div><!-- #colophon -->
	</div><!-- #footer -->

<?php wp_footer(); ?>
</div>
<div id="wrapper_bottom"></div>

<?php /* This inserts the Google Analytics code */ echo str_replace('\"', '"', str_replace("\'", "'", $google_analytics)); ?>

</body>
</html>