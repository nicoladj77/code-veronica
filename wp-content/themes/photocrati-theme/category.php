<?php
	/* IMPORTANT! This code retrieves the option to disable the sidebar */
	global $wpdb;
	$style = $wpdb->get_results("SELECT display_sidebar,blog_meta FROM ".$wpdb->prefix."photocrati_styles WHERE option_set = 1");
	foreach ($style as $style) {
		$display_sidebar = $style->display_sidebar;
		$blog_meta = $style->blog_meta;
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

<?php get_header(); ?>
	
	<div id="container">	
		<div id="content-sm"><!-- Important!! If you remove the sidebar change the ID of this DIV to content -->
			
			<?php the_post(); ?>			
			
			<h1 class="page-title"><?php _e( 'Category Archives:', 'photocrati-framework' ) ?> <span><?php single_cat_title() ?></span></span></h1>
			<?php $categorydesc = category_description(); if ( !empty($categorydesc) ) echo apply_filters( 'archive_meta', '<div class="archive-meta">' . $categorydesc . '</div>' ); ?>

			<?php rewind_posts(); ?>
			
			<?php global $wp_query; $total_pages = $wp_query->max_num_pages; if ( $total_pages > 1 ) { ?>
				<div id="nav-above" class="navigation">
					<div class="nav-previous"><?php next_posts_link(__( '<span class="meta-nav">&laquo;</span> Older posts', 'photocrati-framework' )) ?></div>
					<div class="nav-next"><?php previous_posts_link(__( 'Newer posts <span class="meta-nav">&raquo;</span>', 'photocrati-framework' )) ?></div>
				</div><!-- #nav-above -->
			<?php } ?>			

			<?php while ( have_posts() ) : the_post(); ?>

			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( __('Permalink to %s', 'photocrati-framework'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

				<div class="entry-meta">
					<span class="meta-prep meta-prep-author"><?php _e('By ', 'photocrati-framework'); ?></span>
					<span class="author vcard"><a class="url fn n" href="<?php echo get_author_link( false, $authordata->ID, $authordata->user_nicename ); ?>" title="<?php printf( __( 'View all posts by %s', 'photocrati-framework' ), $authordata->display_name ); ?>"><?php the_author(); ?></a></span>
					<span class="meta-sep"> | </span>
					<span class="meta-prep meta-prep-entry-date"><?php _e('Published ', 'photocrati-framework'); ?></span>
					<span class="entry-date"><abbr class="published" title="<?php the_time('Y-m-d\TH:i:sO') ?>"><?php the_time( get_option( 'date_format' ) ); ?></abbr></span>
					<?php edit_post_link( __( 'Edit', 'photocrati-framework' ), "<span class=\"meta-sep\">|</span>\n\t\t\t\t\t\t<span class=\"edit-link\">", "</span>\n\t\t\t\t\t" ) ?>
				</div><!-- .entry-meta -->
					
				<div class="entry-summary">
					<?php the_content( __( 'Continue reading <span class="meta-nav">&raquo;</span>', 'photocrati-framework' )  ); ?>
					<?php //the_excerpt( __( 'Continue reading <span class="meta-nav">&raquo;</span>', 'photocrati-framework' )  ); ?>
				</div><!-- .entry-summary -->

				<div class="entry-utility"<?php if($blog_meta == 'OFF') { echo ' style="display:none;"'; } ?>>
					<?php if ( $cats_meow = cats_meow(', ') ) : // Returns categories other than the one queried ?>
						<span class="cat-links"><?php printf( __( 'Also posted in %s', 'photocrati-framework' ), $cats_meow ) ?></span>
						<span class="meta-sep"> | </span>
					<?php endif ?>
					<?php the_tags( '<span class="tag-links"><span class="entry-utility-prep entry-utility-prep-tag-links">' . __('Tagged ', 'photocrati-framework' ) . '</span>', ", ", "</span>\n\t\t\t\t\t\t<span class=\"meta-sep\">|</span>\n" ) ?>
					<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'photocrati-framework' ), __( '1 Comment', 'photocrati-framework' ), __( '% Comments', 'photocrati-framework' ) ) ?></span>
					<?php edit_post_link( __( 'Edit', 'photocrati-framework' ), "<span class=\"meta-sep\">|</span>\n\t\t\t\t\t\t<span class=\"edit-link\">", "</span>\n\t\t\t\t\t\n" ) ?>
				</div><!-- #entry-utility -->	
			</div><!-- #post-<?php the_ID(); ?> -->

			<?php endwhile; ?>			

			<?php global $wp_query; $total_pages = $wp_query->max_num_pages; if ( $total_pages > 1 ) { ?>
				<div id="nav-below" class="navigation">
					<div class="nav-previous"><?php next_posts_link(__( '<span class="meta-nav">&laquo;</span> Older posts', 'photocrati-framework' )) ?></div>
					<div class="nav-next"><?php previous_posts_link(__( 'Newer posts <span class="meta-nav">&raquo;</span>', 'photocrati-framework' )) ?></div>
				</div><!-- #nav-below -->
			<?php } ?>			
			
			<?php if($music_cat == "ON") { ?>
			
			<div id="jquery_jplayer"></div> 
 
			<div class="jp-single-player"> 
				<div class="jp-interface"> 
					<ul class="jp-controls"> 
						<li><a href="#" id="jplayer_play" class="jp-play" tabindex="1">play</a></li> 
						<li><a href="#" id="jplayer_pause" class="jp-pause" tabindex="1">pause</a></li> 
						<li><a href="#" id="jplayer_stop" class="jp-stop" tabindex="1">stop</a></li> 
					</ul> 
					<div class="jp-progress"> 
						<div id="jplayer_load_bar" class="jp-load-bar"> 
							<div id="jplayer_play_bar" class="jp-play-bar"></div> 
						</div> 
					</div> 
				</div> 
			</div>
			
			<?php } ?>	
			
		</div><!-- #content -->
        
    <?php if($display_sidebar == 'YES') { get_sidebar(); } ?>
		
<?php get_footer(); ?>