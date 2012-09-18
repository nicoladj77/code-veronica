<?php
	/* IMPORTANT! This code retrieves the option to disable the sidebar */
	global $wpdb;
	$style = $wpdb->get_results("SELECT display_sidebar FROM ".$wpdb->prefix."photocrati_styles WHERE option_set = 1");
	foreach ($style as $style) {
		$display_sidebar = $style->display_sidebar;
	}
?>

<?php get_header(); ?>
	
		<div id="container">	
			<div id="content-sm"><!-- Important!! If you remove the sidebar change the ID of this DIV to content -->
				
				<div id="post-0" class="post error404 not-found">
					<h1 class="entry-title"><?php _e( 'Not Found', 'photocrati-framework' ); ?></h1>
					<div class="entry-content">
						<p><?php _e( 'Apologies, but we were unable to find what you were looking for. Perhaps searching will help.', 'photocrati-framework' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</div><!-- #post-0 -->

			</div><!-- #content -->		
            
    <?php if($display_sidebar == 'YES') { get_sidebar(); } ?>
 	
<?php get_footer(); ?>