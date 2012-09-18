<?php
	/* IMPORTANT! This code retrieves the option to disable the sidebar */
	global $wpdb;
	$style = $wpdb->get_results("SELECT display_sidebar,blog_meta FROM ".$wpdb->prefix."photocrati_styles WHERE option_set = 1");
	foreach ($style as $style) {
		$display_sidebar = $style->display_sidebar;
		$blog_meta = $style->blog_meta;
	}
?>

<?php get_header(); ?>
	
	<div id="container">	
		<div id="content-sm"><!-- Important!! If you remove the sidebar change the ID of this DIV to content -->
		
			<?php the_post(); ?>

			<div id="nav-above" class="navigation">
				<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">&laquo;</span> %title' ) ?></div>
				<div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">&raquo;</span>' ) ?></div>
			</div><!-- #nav-above -->

			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<h1 class="entry-title"><?php the_title(); ?></h1>
				
				<div class="entry-meta">
					<span class="meta-prep meta-prep-author"><?php _e('By ', 'photocrati-framework'); ?></span>
					<span class="author vcard"><a class="url fn n" href="<?php echo get_author_link( false, $authordata->ID, $authordata->user_nicename ); ?>" title="<?php printf( __( 'View all posts by %s', 'photocrati-framework' ), $authordata->display_name ); ?>"><?php the_author(); ?></a></span>
					<span class="meta-sep"> | </span>
					<span class="meta-prep meta-prep-entry-date"><?php _e('Published ', 'photocrati-framework'); ?></span>
					<span class="entry-date"><abbr class="published" title="<?php the_time('Y-m-d\TH:i:sO') ?>"><?php the_time( get_option( 'date_format' ) ); ?></abbr></span>
					<?php edit_post_link( __( 'Edit', 'photocrati-framework' ), "<span class=\"meta-sep\">|</span>\n\t\t\t\t\t\t<span class=\"edit-link\">", "</span>\n\t\t\t\t\t" ) ?>						
				</div><!-- .entry-meta -->
				
				<div class="entry-content">
				<?php the_content(); ?>
                <?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'photocrati-framework' ) . '&after=</div>') ?>
				</div><!-- .entry-content -->
					
				<div class="entry-utility"<?php if($blog_meta == 'OFF') { echo ' style="display:none;"'; } ?>>
				<?php printf( __( 'This entry was posted in %1$s%2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>. Follow any comments here with the <a href="%5$s" title="Comments RSS to %4$s" rel="alternate" type="application/rss+xml">RSS feed for this post</a>.', 'photocrati-framework' ),
					get_the_category_list(', '),
					get_the_tag_list( __( ' and tagged ', 'photocrati-framework' ), ', ', '' ),
					get_permalink(),
					the_title_attribute('echo=0'),
					comments_rss() ) ?>

				<?php if ( ('open' == $post->comment_status) && ('open' == $post->ping_status) ) : // Comments and trackbacks open ?>
                   	<?php printf( __( '<a class="comment-link" href="#respond" title="Post a comment">Post a comment</a> or leave a trackback: <a class="trackback-link" href="%s" title="Trackback URL for your post" rel="trackback">Trackback URL</a>.', 'photocrati-framework' ), get_trackback_url() ) ?>
                <?php elseif ( !('open' == $post->comment_status) && ('open' == $post->ping_status) ) : // Only trackbacks open ?>
                    <?php printf( __( 'Comments are closed, but you can leave a trackback: <a class="trackback-link" href="%s" title="Trackback URL for your post" rel="trackback">Trackback URL</a>.', 'photocrati-framework' ), get_trackback_url() ) ?>
                <?php elseif ( ('open' == $post->comment_status) && !('open' == $post->ping_status) ) : // Only comments open ?>
                    <?php _e( 'Trackbacks are closed, but you can <a class="comment-link" href="#respond" title="Post a comment">post a comment</a>.', 'photocrati-framework' ) ?>
                <?php elseif ( !('open' == $post->comment_status) && !('open' == $post->ping_status) ) : // Comments and trackbacks closed ?>
                    <?php _e( 'Both comments and trackbacks are currently closed.', 'photocrati-framework' ) ?>
                <?php endif; ?>
                <?php edit_post_link( __( 'Edit', 'photocrati-framework' ), "\n\t\t\t\t\t<span class=\"edit-link\">", "</span>" ) ?>
					
                </div><!-- .entry-utility -->													
			</div><!-- #post-<?php the_ID(); ?> -->			
				
			<div id="nav-below" class="navigation">
				<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">&laquo;</span> %title' ) ?></div>
				<div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">&raquo;</span>' ) ?></div>
			</div><!-- #nav-below -->				
			
			<?php if(get_post_meta($post->ID, 'music', true) == "YES") { ?>
			
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

		<?php comments_template('', true); ?>	
			
		</div><!-- #content -->
            
    <?php if($display_sidebar == 'YES') { get_sidebar(); } ?>
			
<?php get_footer(); ?>