<?php

include_once(dirname(__FILE__) . str_replace('/', DIRECTORY_SEPARATOR, '/../functions/admin-upload.php'));

	global $wpdb;
	$gallery = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."photocrati_gallery_settings WHERE id = 1", ARRAY_A);
	foreach ($gallery as $key => $value) {
		$$key = $value;
	}
	$style = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."photocrati_styles WHERE option_set = 1", ARRAY_A);
	foreach ($style as $key => $value) {
		$$key = $value;
	}
	
$option_disable_upload = false;
$current_version = get_bloginfo('version');

if (version_compare($current_version, '3.2', '>='))
{
	$option_disable_upload = true;
}

?>

<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/admin/js/swfobject.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/admin/js/jquery.uploadify.v2.1.4.js"></script>

<?php
	$gfont = 'Droid+Sans';
	$fonts = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."photocrati_fonts ORDER BY font_name");
	foreach ($fonts as $fonts) {
		if(strpos($fonts->font_value, 'G - ') === false) { } else {
			$gfont .= '|'.str_replace(" ", "+", str_replace(", serif", "", str_replace("G - ", "", str_replace("'", "", $fonts->font_value))));
		}
	}
?>
<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=<?php echo $gfont; ?>">

<script type='text/javascript'> 
/* <![CDATA[ */
var thickboxL10n = {
	next: "Next &gt;",
	prev: "&lt; Prev",
	image: "Image",
	of: "of",
	close: "Close",
	noiframes: "This feature requires inline frames. You have iframes disabled or your browser does not support them."
};
try{convertEntities(thickboxL10n);}catch(e){};
/* ]]> */
</script> 

<script type="text/javascript">
jQuery.noConflict();
jQuery(document).ready(function() {

	jQuery(".options").corner("top");

	jQuery("#view-theme").fancybox({
		'speedIn'		:	600, 
		'speedOut'		:	200, 
		'width'			:	1020, 
		'height'		:	450,
		'overlayShow'	:	true
	});
	
	jQuery("[id$='_preview']").fancybox();

	jQuery("[id$='_color']").ColorPicker({
			onSubmit: function(hsb, hex, rgb, el) {
				jQuery(el).val(hex);
				jQuery(el).ColorPickerHide();
				jQuery(el).css('background-color', '#'+hex);
			},
			onBeforeShow: function () {
				jQuery(this).ColorPickerSetColor(this.value);
				jQuery(this).css('background-color', '#'+this.value);
			}
		})
		.bind('keyup', function(){
			jQuery(this).ColorPickerSetColor(this.value);
	});

	//Default Action
	jQuery(".tab_content").hide(); //Hide all content
	jQuery("ul.tabs li:last").addClass("active").show(); //Activate first tab
	jQuery(".tab_content:last").show(); //Show first tab content
	
	//On Click Event
	jQuery("ul.tabs li").click(function() {
		jQuery("ul.tabs li").removeClass("active"); //Remove any "active" class
		jQuery(this).addClass("active"); //Add "active" class to selected tab
		jQuery(".tab_content").hide(); //Hide all tab content
		var activeTab = jQuery(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
		jQuery(activeTab).fadeIn(); //Fade in the active content
		return false;
	});
        
    jQuery("[id^=add_image_]").click(function() {
        currentId = jQuery(this).attr("id");
        formfield = jQuery("#"+currentId.substr(10)).attr("name");
        tb_show("Upload an MP3 file", "media-upload.php?type=audio&amp;post_id=1&amp;TB_iframe=true");
        return false;
    });

});
</script>

<div id="admin-wrapper">

	<div id="header-left">
    <img src="<?php bloginfo('template_directory'); ?>/admin/images/ph-logo.gif" align="absmiddle" />  &nbsp;<a id="view-theme" class="iframe" href="<?php bloginfo('wpurl'); ?>" style="text-decoration:none;" /><input type="button" class="button" value="View Theme" /></a>
    </div>
    
    <div id="header-right">
    <?php theme_version(); ?>
    </div>
    
</div>

<div style="height:132px;width:100%;margin-top:10px;clear:both;">
	
	<div style="float:left;width:210px;height:132px;margin-right:40px;background:url(<?php bloginfo('template_directory'); ?>/admin/images/web-layout.gif) no-repeat;"></div>
	<div style="float:left;width:525px;height:132px;text-align:right;">
	
		<br>
		<p style="font-size:13px;margin:20px 0 -10px 0;"><strong>Which part of your theme do you want to customize?</strong></p>
		<p style="font-size:13px;">Once finished you can save your settings as a custom theme <a href="admin.php?page=choose-theme">here</a>.</p>
	
	</div>
	
</div>

<div id="tabs_wrapper">

	<ul class="tabs">
		<li><a href="#custom_tab5">Footer</a></li>
		<li><a href="#custom_tab4">Sidebar</a></li>
		<?php if($dynamic_style == 'YES') { ?>
		<li><a href="#custom_tab3">Body</a></li>
		<li><a href="#custom_tab2">Header</a></li>
		<li><a href="#custom_tab1">Global</a></li>
		<?php } ?>
	</ul>
	
	<div class="tab_container">
		<div id="custom_tab5" class="tab_content">
		
		<script type="text/javascript">
		jQuery(document).ready(function()
		{
		
			jQuery("#footer_background_style").change(function()
			{
				if (jQuery("#footer_background_style").val() == 'color') {
					jQuery("#footer_background_color").val('FFFFFF');
					jQuery("#footer-color").show();
				} else {
					jQuery("#footer_background_color").val('transparent');
					jQuery("#footer-color").hide();
				}
			});
			
			jQuery("#update-footer-font").click(function()
			{
				
				jQuery("#msgff").html("<img src='<?php bloginfo('template_url'); ?>/admin/images/ajax-loader.gif'>");
				jQuery("#msgff").show();
				
				var str2 = jQuery("#footer-font").serialize();
				jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/edit-styles.php", data: str2, success: function(data)
				{
					jQuery("#msgff").html("Footer Font Saved");
					jQuery("#msgff")
						.animate({opacity: 1.0}, 2000)
						.fadeOut('slow');
				}
				});
			});	
			
			jQuery("#update-footer-height").click(function()
			{
				
				jQuery("#msgfh").html("<img src='<?php bloginfo('template_url'); ?>/admin/images/ajax-loader.gif'>");
				jQuery("#msgfh").show();
				
				var str2 = jQuery("#footer-height").serialize();
				jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/edit-styles.php", data: str2, success: function(data)
				{
					jQuery("#msgfh").html("Footer Height Saved");
					jQuery("#msgfh")
						.animate({opacity: 1.0}, 2000)
						.fadeOut('slow');
				}
				});
			});
			
			jQuery("#update-footer-widgets").click(function()
			{
				
				jQuery("#msgfw").html("<img src='<?php bloginfo('template_url'); ?>/admin/images/ajax-loader.gif'>");
				jQuery("#msgfw").show();
				
				var str2 = jQuery("#footer-widgets").serialize();
				jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/edit-styles.php", data: str2, success: function(data)
				{
					jQuery("#msgfw").html("Footer Widgets Saved");
					jQuery("#msgfw")
						.animate({opacity: 1.0}, 2000)
						.fadeOut('slow');
				}
				});
			});
		
			
			jQuery("#update-footer").click(function()
			{
				
				jQuery("#msgfu").html("<img src='<?php bloginfo('template_url'); ?>/admin/images/ajax-loader.gif'>");
				jQuery("#msgfu").show();
				
				var str2 = jQuery("#footer-options").serialize();
				jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/edit-styles.php", data: str2, success: function(data)
				{
					jQuery("#msgfu").html("Footer Copyright Saved");
					jQuery("#msgfu")
						.animate({opacity: 1.0}, 2000)
						.fadeOut('slow');
				}
				});
			});
		
		});
		</script>
		
		<div id="container"> 	
			
			<?php if($dynamic_style == 'YES') { ?>
			<div class="options">Footer & Footer Widget Styles</div>
        
				<div class="sub-options"><span id="comments">Here you can set the footer font color and size</span></div>
				<div class="option-content">
				
					<div id="option-container">
					
					<form name="footer-font" id="footer-font" method="post">
					
						<div class="left" style="width:60%">
						
							<div class="inner">
								<p class="titles">Footer Background Style</p>
								<p>
								<select id="footer_background_style">
									<option value="transparent"<?php if($footer_background == 'transparent') {echo ' SELECTED'; } ?>>Transparent </option>
									<option value="color"<?php if($footer_background <> 'transparent') {echo ' SELECTED'; } ?>>Color </option>
								</select>
								</p>
							</div>
							<div class="inner" id="footer-color"<?php if($footer_background == 'transparent') {echo ' style="display:none;"'; } ?>>
								<p class="titles">Background Color</p>
								<p>#<input type="text" name="footer_background" id="footer_background_color" value="<?php if($footer_background <> 'transparent') { echo $footer_background; } else { echo 'transparent'; } ?>" size="7"  <?php if($footer_background <> 'transparent') { ?>style="background:#<?php echo $footer_background; ?>;"<?php } ?> /> Color</p>
							</div>
						
						</div>
						
						<div class="left-sm" style="clear:both;">
							<p class="titles">Font Size</p>
							<p><input type="text" name="footer_font" id="footer_font" value="<?php echo $footer_font; ?>" size="2" />px</p>
						</div>
						
						<div class="right-lg" id="right-lg">
							<div class="left" style="border:0;width:50%;">
								<p class="titles">Font Color</p>
								<p>#<input type="text" name="footer_font_color" id="footer_font_color" value="<?php echo $footer_font_color; ?>" size="7"  style="background:#<?php echo $footer_font_color; ?>;" /> Color</p>
							</div>
							<div class="right" style="border:0;width:45%;">
								<p class="titles">Font Style</p>
								<p>
								<select name="footer_font_style" style="font-family:<?php echo str_replace('\"', '"', $footer_font_style).';'; ?>font-size:14px;">
									<?php
										$fonts = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."photocrati_fonts ORDER BY font_name");
										foreach ($fonts as $fonts) {
											if(strpos($fonts->font_name, 'G - ') === false) {
												echo '<option value="'.str_replace('"', '\"', $fonts->font_value).'"';
												if(str_replace('\"', '"', $footer_font_style) == $fonts->font_value) {
												echo " SELECTED"; 
												}
												echo ' style="font-family:'.str_replace('"', '\"', $fonts->font_value).';font-size:14px;">'.$fonts->font_name.' </option>';
											}
										}
									?>
								</select>
								</p>
							</div>
						</div>
						
						<div class="left-sm">
							
								<div class="inner">
									<p class="titles">Link Color</p>
									<p>#<input type="text" name="footer_link_color" id="footer_link_color" value="<?php echo $footer_link_color; ?>" size="7" style="background:#<?php echo $footer_link_color; ?>;" /> Color</p>
								</div>
							
						</div>
						
						<div class="right-lg" id="right-lg">
							
								<div class="left" style="border:0;width:50%;">
									<p class="titles">Hover Color</p>
									<p>#<input type="text" name="footer_link_hover_color" id="footer_link_hover_color" value="<?php echo $footer_link_hover_color; ?>" size="7" style="background:#<?php echo $footer_link_hover_color; ?>;" /> Color</p>
								</div>
						
								<div class="right" style="border:0;width:45%;">
									<p class="titles">Hover Style</p>
									<p>
									<select name="footer_link_hover_style">
										<option value="none"<?php if($footer_link_hover_style == 'none') {echo ' SELECTED'; } ?>>None </option>
										<option value="underline"<?php if($footer_link_hover_style == 'underline') {echo ' SELECTED'; } ?>>Underline </option>
										<option value="overline"<?php if($footer_link_hover_style == 'overline') {echo ' SELECTED'; } ?>>Overline </option>
									</select>
									</p>
								</div>
							
						</div>
						
						<div class="left-sm" style="border:0;width:35%;">
							<div class="left" style="border:0;width:45%;">
							<p class="titles">Widget Title Size</p>
							<p><input type="text" name="footer_widget_title" id="footer_widget_title" value="<?php echo $footer_widget_title; ?>" size="2" />px</p>
							</div>
							<div class="left" style="border:0;width:45%;">
								<p class="titles">Widget Title Color</p>
								<p>#<input type="text" name="footer_widget_color" id="footer_widget_color" value="<?php echo $footer_widget_color; ?>" size="7"  style="background:#<?php echo $footer_widget_color; ?>;" /> Color</p>
							</div>
						</div>
						
						<div class="right-lg" id="right-lg" style="border:0;width:63%;">
							<div class="right" style="border:0;width:100%;">
								<p class="titles">Widget Title Style</p>
								<div class="font-window">
									<h3>Designer Fonts</h3>
									<?php
										$fonts = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."photocrati_fonts ORDER BY font_name");
										foreach ($fonts as $fonts) {
											if(strpos($fonts->font_name, 'G - ') === false) {} else {
											echo '<div class="font-float">';
											echo '<input type="radio" style="vertical-align: middle" name="footer_widget_style" ';
											if(str_replace("\'", "'", str_replace('\"', '"', $footer_widget_style)) == $fonts->font_value) {
											echo 'checked="checked"'; 
											}
											echo ' value="'.str_replace('"', '\"', $fonts->font_value).'"> ';
											echo '<font style="font-family:'.str_replace(":800", "", str_replace(":100", "", str_replace(":bold", "", str_replace("\'", "'", str_replace('G - ', '', str_replace('\"', '"', $fonts->font_value)))))).';font-size:27px;">'.str_replace('G - ','',$fonts->font_name).' </font><BR>';
											echo '</div>';
											}
										}
									?>
									<h3 style="clear:both;">Standard Fonts</h3>
									<?php
										$fonts = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."photocrati_fonts ORDER BY font_name");
										foreach ($fonts as $fonts) {
											if(strpos($fonts->font_name, 'G - ') === false) {
											echo '<div class="font-float">';
											echo '<input type="radio" style="vertical-align: middle" name="footer_widget_style" ';
											if(str_replace("\'", "'", str_replace('\"', '"', $footer_widget_style)) == $fonts->font_value) {
											echo 'checked="checked"'; 
											}
											echo ' value="'.str_replace('"', '\"', $fonts->font_value).'"> ';
											echo '<font style="font-family:'.str_replace("G - ", "", str_replace("\'", "'", str_replace('"', '\"', $fonts->font_value))).';font-size:24px;text-transform:uppercase;">'.str_replace('G - ','',$fonts->font_name).' </font><BR>';
											echo '</div>';
											}
										}
									?>
								</div>
							</div>
						</div>
						
						<div class="submit-button-wrapper">
							<input type="button" class="button" id="update-footer-font" value="Save Footer Styles" style="clear:none;" /> 
						</div>
						<div class="msg" id="msgff" style="float:left;"></div>
					
					</form>
					
					</div>
					
			</div>
			<?php } ?>
			
			<div class="options">Footer Height</div>
			
				<div class="sub-options"><span id="comments">The footer is set to a fixed height. If you add more content please adjust this height to compensate.</span></div>
				<div class="option-content">
				
					<div id="option-container">
					
					<form name="footer-height" id="footer-height" method="post">
					
						<div class="left-sm">
							<p class="titles">Footer Height</p>
							<p>
							<input type="text" name="footer_height" id="footer_height" value="<?php echo $footer_height; ?>" size="3">px
							</p>
						</div>
						
						<div class="submit-button-wrapper">
							<input type="button" class="button" id="update-footer-height" value="Save Footer Height" style="clear:none;" /> 
						</div>
						<div class="msg" id="msgfh" style="float:left;"></div>
					
					</form>
					
					</div>
					
			</div>
			
			<div class="options">Footer Widget Placement</div>
			
				<div class="sub-options"><span id="comments">Here you can set where the footer widgets show</span></div>
				<div class="option-content">
				
					<div id="option-container">
					
					<form name="footer-widgets" id="footer-widgets" method="post">
					
						<div class="left-sm" style="width:95%;">
							<p class="titles">Widget Placement</p>
							<p>
							<select name="footer_widget_placement">
								<option value="0"<?php if($footer_widget_placement == '0') { echo ' SELECTED'; } ?>>Do Not Display</option>
								<option value="1"<?php if($footer_widget_placement == '1') { echo ' SELECTED'; } ?>>Only On Blog Pages</option>
								<option value="2"<?php if($footer_widget_placement == '2') { echo ' SELECTED'; } ?>>On All Pages Except Home</option>
								<option value="3"<?php if($footer_widget_placement == '3') { echo ' SELECTED'; } ?>>On All Pages Including Home</option>
								<option value="4"<?php if($footer_widget_placement == '4') { echo ' SELECTED'; } ?>>Only On Home</option>
							</select>
							</p>
							<p><i>To add content to your footer widget area, go to the <a href="widgets.php">widgets page</a> and drag widgets to the Footer Widget Area.</i></p>
						</div>
						
						<div class="submit-button-wrapper">
							<input type="button" class="button" id="update-footer-widgets" value="Save Footer Widgets" style="clear:none;" /> 
						</div>
						<div class="msg" id="msgfw" style="float:left;"></div>
					
					</form>
					
					</div>
					
			</div>
			
			<div class="options">Footer Copyright / Photocrati Link</div>
			
				<div class="sub-options"><span id="comments">Set a custom copyright to display in your footer and show or hide the Photocrati link</span></div>
				<div class="option-content">
				
					<div id="option-container">
					
					<form name="footer-options" id="footer-options" method="post">
					
						<div class="left" style="width:100%;">
						
							<p class="titles">Footer Copyright (HTML Allowed)</p>
							<p>
							<textarea name="footer_copy" cols="70" rows="4"><?php echo stripslashes(str_replace('"', '&quot;', $footer_copy)); ?></textarea>
							</p>
							
						</div>
						
						<div class="clear"></div>
					
						<div class="left" style="width:100%;">
						
							<p class="titles">Photocrati Link</p>
							<p>
								<select name="show_photocrati">
									<option value=""<?php if($show_photocrati == '') { echo ' SELECTED'; } ?>>Show</option>
									<option value="hide"<?php if($show_photocrati == 'hide') { echo ' SELECTED'; } ?>>Hide</option>
								</select>
							</p>
							
						</div>
							
						<div class="submit-button-wrapper">
							<input type="button" class="button" id="update-footer" value="Save Footer Copyright" style="clear:none;" /> 
						</div>
						<div class="msg" id="msgfu" style="float:left;"></div>
						
					</form>
					
					</div>
					
			</div>
		
		</div>
			
		</div>
		
		<div id="custom_tab4" class="tab_content">
		
		<script type="text/javascript">
		jQuery(document).ready(function()
		{
			
			jQuery("#update-size").click(function()
			{
				
				jQuery("#msg5").html("<img src='<?php bloginfo('template_url'); ?>/admin/images/ajax-loader.gif'>");
				jQuery("#msg5").show();
				
				var str2 = jQuery("#size-options").serialize();
				jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/edit-styles.php", data: str2, success: function(data)
				{
					jQuery("#msg5").html("Layout Changes Saved");
					jQuery("#msg5")
						.animate({opacity: 1.0}, 2000)
						.fadeOut('slow');
				}
				});
			});
			
			jQuery("#display_sidebar").change(function()
			{
				if (jQuery("#display_sidebar").val() == 'NO') {
					var answer = confirm("Are you sure you want to disable the sidebar and use full width for your blog posts?")
					if (answer){
						jQuery("#content_width").val('100');
						var str2 = jQuery("#size-options").serialize();
						jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/edit-styles.php", data: str2, success: function(data)
						{
							window.location = window.location;
						}
						});
					}
				} else {
					var answer = confirm("Are you sure you want to enable the sidebar?")
					if (answer){
						jQuery("#content_width").val('70');
						jQuery("#sidebar_width").val('30');
						var str2 = jQuery("#size-options").serialize();
						jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/edit-styles.php", data: str2, success: function(data)
						{
							window.location = window.location;
						}
						});
					}
				}
			});
			
			jQuery("#content_width").keyup(function()
			{
				if(jQuery("#content_width").val() == '') {		
				var content_width = 0;
				} else {
				var content_width = parseInt(jQuery("#content_width").val());
				}
				var	sidebar_width = 100 - content_width;
				jQuery("#sidebar_width").val(sidebar_width);
			});
			
			jQuery("#sidebar_width").keyup(function()
			{
				if(jQuery("#sidebar_width").val() == '') {		
				var sidebar_width = 0;
				} else {
				var sidebar_width = parseInt(jQuery("#sidebar_width").val());
				}
				var	content_width = 100 - sidebar_width;
				jQuery("#content_width").val(content_width);
			});
			
			jQuery("#reset-sidebar-styles").click(function()
			{
				var answer = confirm("Are you sure you want to reset the sidebar styles? This cannot be undone.")
				if (answer){
					jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/reset-sidebar-styles.php", data: '', success: function(data)
					{
						window.location = window.location;
					}
					});
				}
			});
			
			jQuery("#sidebar_style").change(function()
			{
				if (jQuery("#sidebar_style").val() == 'color') {
					jQuery("#sidebar_bg_color").val('FFFFFF');
					jQuery("#sidebar-color").show();
				} else {
					jQuery("#sidebar_bg_color").val('transparent');
					jQuery("#sidebar-color").hide();
				}
			});
			
			jQuery("#update-sidebar-c").click(function()
			{
				
				jQuery("#msg").html("<img src='<?php bloginfo('template_url'); ?>/admin/images/ajax-loader.gif'>");
				jQuery("#msg").show();
				
				var str2 = jQuery("#sidebar-bg-options").serialize();
				jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/edit-styles.php", data: str2, success: function(data)
				{
					jQuery("#msg").html("Sidebar Background Saved");
					jQuery("#msg")
						.animate({opacity: 1.0}, 2000)
						.fadeOut('slow');
				}
				});
			});
			
			jQuery("#update-sidebar-f").click(function()
			{
				
				jQuery("#msg3").html("<img src='<?php bloginfo('template_url'); ?>/admin/images/ajax-loader.gif'>");
				jQuery("#msg3").show();
				
				var str2 = jQuery("#sidebar-font-options").serialize();
				jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/edit-styles.php", data: str2, success: function(data)
				{
					jQuery("#msg3").html("Sidebar Fonts Saved");
					jQuery("#msg3")
						.animate({opacity: 1.0}, 2000)
						.fadeOut('slow');
				}
				});
			});
			
			jQuery("#update-sidebar-l").click(function()
			{
				
				jQuery("#msg2").html("<img src='<?php bloginfo('template_url'); ?>/admin/images/ajax-loader.gif'>");
				jQuery("#msg2").show();
				
				var str2 = jQuery("#sidebar-link-options").serialize();
				jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/edit-styles.php", data: str2, success: function(data)
				{
					jQuery("#msg2").html("Sidebar Links Saved");
					jQuery("#msg2")
						.animate({opacity: 1.0}, 2000)
						.fadeOut('slow');
				}
				});
			});
			
			jQuery("#update-sidebar-t").click(function()
			{
				
				jQuery("#msg4").html("<img src='<?php bloginfo('template_url'); ?>/admin/images/ajax-loader.gif'>");
				jQuery("#msg4").show();
				
				var str2 = jQuery("#sidebar-title-options").serialize();
				jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/edit-styles.php", data: str2, success: function(data)
				{
					jQuery("#msg4").html("Sidebar Title Saved");
					jQuery("#msg4")
						.animate({opacity: 1.0}, 2000)
						.fadeOut('slow');
				}
				});
			});
	
			jQuery("#custom_sidebar").change(function()
			{
				if (jQuery("#custom_sidebar").val() == 'ON') {
					jQuery("#custom-sidebar-position").show();
					jQuery("#sidebar-html").show();
				} else {
					jQuery("#custom-sidebar-position").hide();
					jQuery("#sidebar-html").hide();
					var str2 = jQuery("#sidebar-options").serialize();
					jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/edit-styles.php", data: str2, success: function(data)
					{
					}
					});
				}
			});
			
			jQuery("#update-sidebar").click(function()
			{
				
				jQuery("#msg6").html("<img src='<?php bloginfo('template_url'); ?>/admin/images/ajax-loader.gif'>");
				jQuery("#msg6").show();
				
				var str2 = jQuery("#sidebar-options").serialize();
				jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/edit-styles.php", data: str2, success: function(data)
				{
					jQuery("#msg6").html("Custom Sidebar Saved");
					jQuery("#msg6")
						.animate({opacity: 1.0}, 2000)
						.fadeOut('slow');
				}
				});
			});
			
			jQuery("#reset-social").click(function()
			{
				var answer = confirm("Are you sure you want to reset the social media options? This cannot be undone.")
				if (answer){
					jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/reset-social.php", data: '', success: function(data)
					{
						window.location = window.location;
					}
					});
				}
			});
			
			jQuery("#social_media").change(function()
			{
				if (jQuery("#social_media").val() == 'ON') {
					jQuery("#social-settings").show();
					jQuery("#social-title").show();
				} else {
					jQuery("#social-settings").hide();
					jQuery("#social-title").hide();
				}
			});
			
			jQuery("#update-social").click(function()
			{
				
				jQuery("#msg7").html("<img src='<?php bloginfo('template_url'); ?>/admin/images/ajax-loader.gif'>");
				jQuery("#msg7").show();
				
				var str2 = jQuery("#social-options").serialize();
				jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/edit-styles.php", data: str2, success: function(data)
				{
					jQuery("#msg7").html("Social Media Options Saved");
					jQuery("#msg7")
						.animate({opacity: 1.0}, 2000)
						.fadeOut('slow');
				}
				});
			});
		
		});
		</script>
		
			<div id="container">      
        
				<?php if($dynamic_style == 'YES') { ?>
				<div class="options">Sidebar / Content Width</div>
				
					<div class="sub-options"><span id="comments">Change the width of the blog content & sidebar. You can also disable your sidebar and use full width for posts.</span></div>
					<div class="option-content">
					
						<div id="option-container">
							
							<form name="size-options" id="size-options" method="post">
						
								<div class="left" style="border-right:0;">
								
									<div class="inner">
										<p class="titles">Content Area Width</p>
										<p><input type="text" name="content_width" id="content_width" value="<?php echo $content_width; ?>" size="2" />%</p>
									</div>
									
									<div class="inner">
										<p class="titles">Use Blog Sidebar?</p>
										<p>
										<select name="display_sidebar" id="display_sidebar">
											<option value="YES"<?php if($display_sidebar == 'YES') {echo ' SELECTED'; } ?>>YES </option>
											<option value="NO"<?php if($display_sidebar == 'NO') {echo ' SELECTED'; } ?>>NO </option>
										</select>
										</p>
									</div>
									
									<div class="submit-button-wrapper">
										<input type="button" class="button" id="update-size" value="Save Layout Sizes" style="clear:none;" /> 
									</div>
									<div class="msg" id="msg5" style="float:left;"></div>
								
								
								
								</div>
							
								<div class="right">
							
									<div class="inner"<?php if($display_sidebar == 'NO') {echo ' style="visibility:hidden;"'; } ?>>
										<p class="titles">Sidebar Area Width</p>
										<p><input type="text" name="sidebar_width" id="sidebar_width" value="<?php echo $sidebar_width; ?>" size="2" />%</p>
									</div>  
														
								</div>                  	
								  
							</form>
							
						</div>
				</div>
					
				<div class="options">Background</div>
				
					<div class="sub-options"><span id="comments">Change the color of the sidebar background</span></div>
					<div class="option-content">
					
						<div id="option-container">
							
							<form name="sidebar-bg-options" id="sidebar-bg-options" method="post">
						
								<div class="left" style="border-right:0;">
								
									<div class="inner">
										<p class="titles">Sidebar Background Style</p>
										<p>
										<select id="sidebar_style">
											<option value="transparent"<?php if($sidebar_bg_color == 'transparent') {echo ' SELECTED'; } ?>>Transparent </option>
											<option value="color"<?php if($sidebar_bg_color <> 'transparent') {echo ' SELECTED'; } ?>>Color </option>
										</select>
										</p>
									</div>
									<div class="inner" id="sidebar-color"<?php if($sidebar_bg_color == 'transparent') {echo ' style="display:none;"'; } ?>>
										<p class="titles">Sidebar Background Color</p>
										<p>#<input type="text" name="sidebar_bg_color" id="sidebar_bg_color" value="<?php if($sidebar_bg_color <> 'transparent') { echo $sidebar_bg_color; } else { echo 'transparent'; } ?>" size="7"  <?php if($sidebar_bg_color <> 'transparent') { ?>style="background:#<?php echo $sidebar_bg_color; ?>;"<?php } ?> /> Color</p>
									</div>
									
									<div class="submit-button-wrapper">
										<input type="button" class="button" id="update-sidebar-c" value="Save Background" style="clear:none;" /> 
									</div>
									<div class="msg" id="msg" style="float:left;"></div>
								
								</div>
								
							</form>
						
						</div>
								
					</div>
				
				
				<div class="options">Font Styles</div>
				
					<div class="sub-options"><span id="comments">Change the color, size and style of the sidebar fonts</span></div>
					<div class="option-content">
					
						<div id="option-container">
							
							<form name="sidebar-font-options" id="sidebar-font-options" method="post">
						
								<div class="left" style="border-right:0;">
								
									<div class="inner">
										<p class="titles">Font Color</p>
										<p>#<input type="text" name="sidebar_font_color" id="sidebar_font_color" value="<?php echo $sidebar_font_color; ?>" size="7" style="background:#<?php echo $sidebar_font_color; ?>;" /> Color</p>
									</div>
									<div class="inner">
										<p class="titles">Font Size</p>
										<p><input type="text" name="sidebar_font_size" id="sidebar_font_size" value="<?php echo $sidebar_font_size; ?>" size="2" />px</p>
									</div>
									
									<div class="submit-button-wrapper">
										<input type="button" class="button" id="update-sidebar-f" value="Save Fonts" style="clear:none;" /> 
									</div>
									<div class="msg" id="msg3" style="float:left;"></div>
								
								</div>
							
								<div class="right">
								
									<div class="inner">
										<p class="titles">Font Style</p>
										<p>
										<select name="sidebar_font_style" style="font-family:<?php echo str_replace('\"', '"', $sidebar_font_style).';'; ?>font-size:14px;">
										<?php
											$fonts = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."photocrati_fonts ORDER BY font_name");
											foreach ($fonts as $fonts) {
												if(strpos($fonts->font_name, 'G - ') === false) {
													echo '<option value="'.str_replace('"', '\"', $fonts->font_value).'"';
													if(str_replace('\"', '"', $sidebar_font_style) == $fonts->font_value) {
													echo " SELECTED"; 
													}
													echo ' style="font-family:'.str_replace('"', '\"', $fonts->font_value).';font-size:14px;">'.$fonts->font_name.' </option>';
												}
											}
										?>
										</select>
										</p>
									</div>
							
								</div>
									
							</form>
						
						</div>
								
					</div>
				
				<div class="options">Title Styles</div>
				
					<div class="sub-options"><span id="comments">Change the color, size and style of the sidebar titles</span></div>
					<div class="option-content">
					
						<div id="option-container">
							
							<form name="sidebar-title-options" id="sidebar-title-options" method="post">
						
								<div class="left" style="border-right:0;width:100%;">
								
									<div class="inner">
										<p class="titles">Title Color</p>
										<p>#<input type="text" name="sidebar_title_color" id="sidebar_title_color" value="<?php echo $sidebar_title_color; ?>" size="7" style="background:#<?php echo $sidebar_title_color; ?>;" /> Color</p>
									</div>
									<div class="inner">
										<p class="titles">Title Size</p>
										<p><input type="text" name="sidebar_title_size" id="sidebar_title_size" value="<?php echo $sidebar_title_size; ?>" size="2" />px</p>
									</div>
								
								</div>
						
								<div class="left" style="border:0;width:100%;">
									<p class="titles">Title Style</p>
									<div class="font-window">
									<h3>Designer Fonts</h3>
									<?php
										$fonts7 = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."photocrati_fonts ORDER BY font_name");
										foreach ($fonts7 as $fonts7) {
											if(strpos($fonts7->font_name, 'G - ') === false) {} else {
											echo '<div class="font-float">';
											echo '<input type="radio" style="vertical-align: middle" name="sidebar_title_style" ';
											if(str_replace("\'", "'", str_replace('\"', '"', $sidebar_title_style)) == $fonts7->font_value) {
											echo 'checked="checked"'; 
											}
											echo ' value="'.str_replace('"', '\"', $fonts7->font_value).'"> ';
											echo '<font style="font-family:'.str_replace("G - ", "", str_replace(":800", "", str_replace(":100", "", str_replace(":bold", "", str_replace("\'", "'", str_replace('G - ', '', str_replace('\"', '"', $fonts7->font_value))))))).';font-size:27px;">'.str_replace('G - ','',$fonts7->font_name).' </font><BR>';
											echo '</div>';
											}
										}
									?>
									<h3 style="clear:both;">Standard Fonts</h3>
									<?php
										$fonts8 = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."photocrati_fonts ORDER BY font_name");
										foreach ($fonts8 as $fonts8) {
											if(strpos($fonts8->font_name, 'G - ') === false) {
											echo '<div class="font-float">';
											echo '<input type="radio" style="vertical-align: middle" name="sidebar_title_style" ';
											if(str_replace("\'", "'", str_replace('\"', '"', $sidebar_title_style)) == $fonts8->font_value) {
											echo 'checked="checked"'; 
											}
											echo ' value="'.str_replace('"', '\"', $fonts8->font_value).'"> ';
											echo '<font style="font-family:'.str_replace("G - ", "", str_replace("\'", "'", str_replace('"', '\"', $fonts8->font_value))).';font-size:26px;">'.str_replace('G - ','',$fonts8->font_name).' </font><BR>';
											echo '</div>';
											}
										}
									?>
									</div>
								
								<div class="submit-button-wrapper">
									<input type="button" class="button" id="update-sidebar-t" value="Save Titles" style="clear:none;" /> 
								</div>
								<div class="msg" id="msg4" style="float:left;"></div>
							</div>
							
							</form>
						
						</div>
								
					</div>
					
				<div class="options">Link Styles</div>
				
					<div class="sub-options"><span id="comments">Change the color and style of the sidebar links</span></div>
					<div class="option-content">
					
						<div id="option-container">
							
							<form name="sidebar-link-options" id="sidebar-link-options" method="post">
						
								<div class="left" style="border-right:0;">
								
										<div class="inner">
											<p class="titles">Link Color</p>
											<p>#<input type="text" name="sidebar_link_color" id="sidebar_link_color" value="<?php echo $sidebar_link_color; ?>" size="7" style="background:#<?php echo $sidebar_link_color; ?>;" /> Color</p>
										</div>
										<div class="inner">
											<p class="titles">Hover Color</p>
											<p>#<input type="text" name="sidebar_link_hover_color" id="sidebar_link_hover_color" value="<?php echo $sidebar_link_hover_color; ?>" size="7" style="background:#<?php echo $sidebar_link_hover_color; ?>;" /> Color</p>
										</div>
									
										<div class="submit-button-wrapper">
											<input type="button" class="button" id="update-sidebar-l" value="Save Links" style="clear:none;" /> 
										</div>
										<div class="msg" id="msg2" style="float:left;"></div>
								
								</div>
							
								<div class="right">
								
										<div class="inner">
											<p class="titles">Hover Style</p>
											<p>
											<select name="sidebar_link_hover_style">
												<option value="none"<?php if($sidebar_link_hover_style == 'none') {echo ' SELECTED'; } ?>>None </option>
												<option value="underline"<?php if($sidebar_link_hover_style == 'underline') {echo ' SELECTED'; } ?>>Underline </option>
												<option value="overline"<?php if($sidebar_link_hover_style == 'overline') {echo ' SELECTED'; } ?>>Overline </option>
											</select>
											</p>
										</div>
							
								</div>
									
							</form>
						
						</div>
								
					</div>
			
				<?php } ?>
			
				<div class="options">Social Media Settings</div>
				
					<div class="sub-options"><span id="comments">Enable / disable social media icons on the sidebar & choose the style</span></div>
					<div class="option-content">
					
						<div id="option-container">
						
						<form name="social-options" id="social-options" method="post">
						
							<div class="left" style="border:0;">
							
								<p class="titles">Social Media Icons</p>
								<p>
									<select name="social_media" id="social_media">
										<option value="OFF"<?php if($social_media == 'OFF') {echo ' SELECTED'; } ?>>OFF </option>
										<option value="ON"<?php if($social_media == 'ON') {echo ' SELECTED'; } ?>>ON </option>
									</select>
								</p>
								
							</div>
							
							<div class="right" id="social-title" <?php if($social_media <> 'ON') { echo 'style="display:none;"'; } ?>>
							
								<p class="titles">Sidebar Title (leave blank for no title)</p>
								<p>
									<input type="text" name="social_media_title" value="<?php echo $social_media_title; ?>" size="50" />
								</p>
							
							</div>
							
							<div id="social-settings" style="clear:both;<?php if($social_media <> 'ON') { echo 'display:none;'; } ?>">
							
								<div class="left" style="border:0;">
									<p class="titles">Icon Set</p>
									<p>
									<em>Small Icons</em><BR />
									<input type="radio" name="social_media_set" value="small"<?php if($social_media_set == 'small') {echo ' CHECKED'; } ?> /> &nbsp;
									<img src="<?php bloginfo('template_directory'); ?>/images/social/small-set.png" align="absmiddle" />
									</p>
									<p>
									<em>Chrome Icons</em><BR />
									<input type="radio" name="social_media_set" value="chrome"<?php if($social_media_set == 'chrome') {echo ' CHECKED'; } ?> /> &nbsp;
									<img src="<?php bloginfo('template_directory'); ?>/images/social/chrome-set.png" align="absmiddle" />
									</p>
									<p>
									<em>Polaroid Icons</em><BR />
									<input type="radio" name="social_media_set" value="polaroid"<?php if($social_media_set == 'polaroid') {echo ' CHECKED'; } ?> /> &nbsp;
									<img src="<?php bloginfo('template_directory'); ?>/images/social/polaroid-set.png" align="absmiddle" />
									</p>
								</div>
								
								<div class="right">
								
									<p class="titles">URLs (leave blank to exclude)</p>
									

									<p>
									<em>RSS Feed (please include http://)</em><BR />
									<input type="text" name="social_rss" size="50" value="<?php echo $social_rss; ?>" />
									</p>
									
									<p>
									<em>Email Address</em><BR />
									<input type="text" name="social_email" size="50" value="<?php echo $social_email; ?>" />
									</p>
									
									<p>
									<em>Twitter</em><BR />
									http://www.twitter.com/<input type="text" name="social_twitter" size="25" value="<?php echo $social_twitter; ?>" />
									</p>
									
									<p>
									<em>Facebook</em><BR />
									http://www.facebook.com/<input type="text" name="social_facebook" size="25" value="<?php echo $social_facebook; ?>" />
									</p>
									
									<p>
									<em>Flickr</em><BR />
									http://www.flickr.com/<input type="text" name="social_flickr" size="25" value="<?php echo $social_flickr; ?>" />
									</p>
								
								</div>
							
							</div>
							
							<div class="submit-button-wrapper">
								<input type="button" class="button" id="update-social" value="Save Social Media" style="clear:none;" /> 
							</div>
							<div class="msg" id="msg7" style="float:left;"></div>
						
						</form>
						
						</div>
						
				</div>
    
				<div class="options">Custom Sidebar Content</div>
							
				<form name="sidebar-options" id="sidebar-options" method="post">
				
					<div class="sub-options"><span id="comments">Enable / disable custom sidebar content and set the position</span></div>
					<div class="option-content">
					
						<div id="option-container">
						
							<div class="left" style="border:0;">
							
								<div class="inner">
							
									<p class="titles">Use custom content?</p>
									<p>
										<select name="custom_sidebar" id="custom_sidebar">
											<option value="OFF"<?php if($custom_sidebar == 'OFF') {echo ' SELECTED'; } ?>>OFF </option>
											<option value="ON"<?php if($custom_sidebar == 'ON') {echo ' SELECTED'; } ?>>ON </option>
										</select>
									</p>
								
								</div>
								
							</div>
							
							<div class="right" id="custom-sidebar-position" <?php if($custom_sidebar <> 'ON') { echo 'style="display:none;"'; } ?>>
								
								<div class="inner">
							
									<p class="titles">Above or below widgets?</p>
									<p>
										<select name="custom_sidebar_position">
											<option value="ABOVE"<?php if($custom_sidebar_position == 'ABOVE') {echo ' SELECTED'; } ?>>ABOVE </option>
											<option value="BELOW"<?php if($custom_sidebar_position == 'BELOW') {echo ' SELECTED'; } ?>>BELOW </option>
										</select>
									</p>
								
								</div>
							
							</div>
						
						</div>
						
				</div>
				
				<div id="sidebar-html" <?php if($custom_sidebar <> 'ON') { echo 'style="display:none;"'; } ?>>
				
				<div class="options">Custom Sidebar HTML</div>
				
					<div class="sub-options"><span id="comments">Insert HTML to appear on the sidebar</span></div>
					<div class="option-content">
					
						<div id="option-container">
							
								<div class="left" style="border:0;width:58%;">
									<p class="titles">Insert HTML</p>
									<p>
									
									<textarea name="custom_sidebar_html" id="custom_sidebar_html" cols="45" rows="10"><?php echo stripslashes(str_replace('\"', '"', $custom_sidebar_html)); ?></textarea>
									
									</p>
								
								</div>
								
								<div class="right" style="border:0;width:40%;">
									<p class="titles">Tips</p>
									<p>
									
									<em>Use an H3 tag with a class of "widget-title" to use the existing sidebar title style:</em>
									<BR /><BR />
									&lt;h3 class="widget-title"&gt;Title&lt;/h3&gt;
									
									</p>
								</div>
							
							<div class="submit-button-wrapper">
								<input type="button" class="button" id="update-sidebar" value="Save Custom Sidebar" style="clear:none;" /> 
							</div>
							<div class="msg" id="msg6" style="float:left;"></div>
						
						</div>
								
					</form>
						
				</div>
							
				</div>
			
			</div>
		
		</div>
		
		<?php if($dynamic_style == 'YES') { ?>
		<div id="custom_tab3" class="tab_content">
		
			<script type="text/javascript">
			jQuery(document).ready(function()
			{
				
				jQuery("#container_style").change(function()
				{
					if (jQuery("#container_style").val() == 'color') {
						jQuery("#container_color").val('FFFFFF');
						jQuery("#container-color").show();
						jQuery("#container-border").show();
						jQuery("#container-border-color").show();
					} else {
						jQuery("#container_color").val('transparent');
						jQuery("#container-color").hide();
						jQuery("#container-border").hide();
						jQuery("#container-border-color").hide();
					}
				});
				
				jQuery("#update-meta").click(function()
				{
				
				jQuery("#msgmeta").html("<img src='<?php bloginfo('template_url'); ?>/admin/images/ajax-loader.gif'>");
				jQuery("#msgmeta").show();
				
					var str2 = jQuery("#meta-options").serialize();
					jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/edit-styles.php", data: str2, success: function(data)
					{
						jQuery("#msgmeta").html("Blog META Saved");
						jQuery("#msgmeta")
							.animate({opacity: 1.0}, 2000)
							.fadeOut('slow');
					}
					});
				});
				
				jQuery("#update-container").click(function()
				{
				
				jQuery("#msgcb").html("<img src='<?php bloginfo('template_url'); ?>/admin/images/ajax-loader.gif'>");
				jQuery("#msgcb").show();
				
					var str2 = jQuery("#container-options").serialize();
					jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/edit-styles.php", data: str2, success: function(data)
					{
						jQuery("#msgcb").html("Content Changes Saved");
						jQuery("#msgcb")
							.animate({opacity: 1.0}, 2000)
							.fadeOut('slow');
					}
					});
				});
				
				jQuery("#update-font").click(function()
				{
				
				jQuery("#msgcfs").html("<img src='<?php bloginfo('template_url'); ?>/admin/images/ajax-loader.gif'>");
				jQuery("#msgcfs").show();
				
					var str2 = jQuery("#font-options").serialize();
					jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/edit-styles.php", data: str2, success: function(data)
					{
						jQuery("#msgcfs").html("Fonts Updated");
						jQuery("#msgcfs")
							.animate({opacity: 1.0}, 2000)
							.fadeOut('slow');
					}
					});
				});
				
				jQuery("#update-h").click(function()
				{
				
				jQuery("#msgh1").html("<img src='<?php bloginfo('template_url'); ?>/admin/images/ajax-loader.gif'>");
				jQuery("#msgh1").show();
				
					var str2 = jQuery("#h-options").serialize();
					jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/edit-styles.php", data: str2, success: function(data)
					{
						jQuery("#msgh1").html("H1-H5 Updated");
						jQuery("#msgh1")
							.animate({opacity: 1.0}, 2000)
							.fadeOut('slow');
					}
					});
				});
				
				jQuery("#update-link-c").click(function()
				{
				
				jQuery("#msgcl").html("<img src='<?php bloginfo('template_url'); ?>/admin/images/ajax-loader.gif'>");
				jQuery("#msgcl").show();
				
					var str2 = jQuery("#link-options").serialize();
					jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/edit-styles.php", data: str2, success: function(data)
					{
						jQuery("#msgcl").html("Link Style Updated");
						jQuery("#msgcl")
							.animate({opacity: 1.0}, 2000)
							.fadeOut('slow');
					}
					});
				});
				
				jQuery("#update-comments").click(function()
				{
				
				jQuery("#msgcomments").html("<img src='<?php bloginfo('template_url'); ?>/admin/images/ajax-loader.gif'>");
				jQuery("#msgcomments").show();
				
					var str2 = jQuery("#page_comments").serialize();
					jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/edit-styles.php", data: str2, success: function(data)
					{
						jQuery("#msgcomments").html("Page Comments Updated");
						jQuery("#msgcomments")
							.animate({opacity: 1.0}, 2000)
							.fadeOut('slow');
					}
					});
				});
				
			});
			</script>	
			
			<div id="container"> 				
				
			<div class="options">Content Font / Paragraph Styles</div>
			
				<div class="sub-options"><span id="comments">Change the color, size and style of the content fonts (sidebar controlled separately) and paragraph spacing</span></div>
				<div class="option-content">
				
					<div id="option-container">
					
						<div class="left" style="border-right:0;">
						
							<form name="font-options" id="font-options" method="post">
							
								<div class="inner">
									<p class="titles">Font Color</p>
									<p>#<input type="text" name="font_color" id="font_color" value="<?php echo $font_color; ?>" size="7" style="background:#<?php echo $font_color; ?>;" /> Color</p>
								</div>
								<div class="inner">
									<p class="titles">Font Size</p>
									<p><input type="text" name="font_size" id="font_size" value="<?php echo $font_size; ?>" size="2" />px</p>
								</div>	
							
								<div class="inner">
									<p class="titles">Paragraph Line Height</p>
									<p><input type="text" name="p_line" id="p_line" value="<?php echo $p_line; ?>" size="2" />px</p>
								</div>
								<div class="inner">
									<p class="titles">Paragraph Spacing</p>
									<p><input type="text" name="p_space" id="p_space" value="<?php echo $p_space; ?>" size="2" />px</p>
								</div>
								
								<div class="submit-button-wrapper">
									<input type="button" class="button" id="update-font" value="Save Fonts / Paragraphs" style="clear:none;" /> 
								</div>
								<div class="msg" id="msgcfs" style="float:left;"></div>						
							
						</div>
						
						<div class="right">
							
								<div class="inner">
									<p class="titles">Font Style</p>
									<p>
									<select name="font_style" style="font-family:<?php echo str_replace('\"', '"', $font_style).';'; ?>font-size:14px;">
									<?php
										$fonts = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."photocrati_fonts ORDER BY font_name");
										foreach ($fonts as $fonts) {
											if(strpos($fonts->font_name, 'G - ') === false) {
												echo '<option value="'.str_replace('"', '\"', $fonts->font_value).'"';
												if(str_replace('\"', '"', $font_style) == $fonts->font_value) {
												echo " SELECTED"; 
												}
												echo ' style="font-family:'.str_replace('"', '\"', $fonts->font_value).';font-size:14px;">'.$fonts->font_name.' </option>';
											}
										}
									?>
									</select>
									</p>
								</div>
							
							</form>
							
						</div>
					
					</div>
					
				</div>
				 
				 
				<div class="options">Title Styles</div>
			
				<div class="sub-options"><span id="comments">Change the color and size of the H1-H5 tags</span></div>   
				<div class="option-content"> 
					
					<div id="option-container">
					
						<div class="left" style="width:100%;">
						
							<form name="h-options" id="h-options" method="post">
							
								<div class="inner" style="width:20%;">
									<p class="titles">H1 Color</p>
									<p>#<input type="text" name="h1_color" id="h1_color" value="<?php echo $h1_color; ?>" size="7" style="background:#<?php echo $h1_color; ?>;" /> Color</p>
								</div>
								<div class="inner" style="width:20%;">
									<p class="titles">H1 Size</p>
									<p><input type="text" name="h1_size" id="h1_size" value="<?php echo $h1_size; ?>" size="2" />px</p>
								</div>
								<div class="inner" style="width:20%;">
									<p class="titles">H1 Case</p>
									<p>
										<select name="h1_font_case">
											<option value=""<?php if($h1_font_case == '') { echo ' SELECTED'; } ?>>Normal</option>
											<option value="uppercase"<?php if($h1_font_case == 'uppercase') { echo ' SELECTED'; } ?>>All Uppercase</option>
										</select>
									</p>
								</div>
								<div class="inner" style="width:20%;">
									<p class="titles">H1 Weight</p>
									<p>
										<select name="h1_font_weight">
											<option value=""<?php if($h1_font_weight == '') { echo ' SELECTED'; } ?>>Normal</option>
											<option value="bold"<?php if($h1_font_weight == 'bold') { echo ' SELECTED'; } ?>>Bold</option>
										</select>
									</p>
								</div>
								<div class="inner" style="width:20%;">
									<p class="titles">H1 Align</p>
									<p>
										<select name="h1_font_align">
											<option value=""<?php if($h1_font_align == '') { echo ' SELECTED'; } ?>>Left</option>
											<option value="center"<?php if($h1_font_align == 'center') { echo ' SELECTED'; } ?>>Centered</option>
										</select>
									</p>
								</div>
								
						</div>
						
						<div class="left" style="border:0;width:100%;">
							<p class="titles">H1 Font Style</p>
							<div class="font-window">
							<h3>Designer Fonts</h3>
							<?php
								$fonts1 = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."photocrati_fonts ORDER BY font_name");
								foreach ($fonts1 as $fonts1) {
									if(strpos($fonts1->font_name, 'G - ') === false) {} else {
									echo '<div class="font-float">';
									echo '<input type="radio" style="vertical-align: middle" name="h1_font_style" ';
									if(str_replace("\'", "'", str_replace('\"', '"', $h1_font_style)) == $fonts1->font_value) {
									echo 'checked="checked"'; 
									}
									echo ' value="'.str_replace('"', '\"', $fonts1->font_value).'"> ';
									echo '<font style="font-family:'.str_replace("G - ", "", str_replace(":800", "", str_replace(":100", "", str_replace(":bold", "", str_replace("\'", "'", str_replace('G - ', '', str_replace('\"', '"', $fonts1->font_value))))))).';font-size:27px;">'.str_replace('G - ','',$fonts1->font_name).' </font><BR>';
									echo '</div>';
									}
								}
							?>
							<h3 style="clear:both;">Standard Fonts</h3>
							<?php
								$fonts2 = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."photocrati_fonts ORDER BY font_name");
								foreach ($fonts2 as $fonts2) {
									if(strpos($fonts2->font_name, 'G - ') === false) {
									echo '<div class="font-float">';
									echo '<input type="radio" style="vertical-align: middle" name="h1_font_style" ';
									if(str_replace("\'", "'", str_replace('\"', '"', $h1_font_style)) == $fonts2->font_value) {
									echo 'checked="checked"'; 
									}
									echo ' value="'.str_replace('"', '\"', $fonts2->font_value).'"> ';
									echo '<font style="font-family:'.str_replace("G - ", "", str_replace("\'", "'", str_replace('"', '\"', $fonts2->font_value))).';font-size:26px;">'.str_replace('G - ','',$fonts2->font_name).' </font><BR>';
									echo '</div>';
									}
								}
							?>
							</div>
						</div>
						
						<div class="left" style="width:100%;">
							
								<div class="inner" style="width:25%;">
									<p class="titles">H2 Color</p>
									<p>#<input type="text" name="h2_color" id="h2_color" value="<?php echo $h2_color; ?>" size="7" style="background:#<?php echo $h2_color; ?>;" /> Color</p>
								</div>
								<div class="inner" style="width:25%;">
									<p class="titles">H2 Size</p>
									<p><input type="text" name="h2_size" id="h2_size" value="<?php echo $h2_size; ?>" size="2" />px</p>
								</div>
								<div class="inner" style="width:25%;">
									<p class="titles">H2 Case</p>
									<p>
										<select name="h2_font_case">
											<option value=""<?php if($h2_font_case == '') { echo ' SELECTED'; } ?>>Normal</option>
											<option value="uppercase"<?php if($h2_font_case == 'uppercase') { echo ' SELECTED'; } ?>>All Uppercase</option>
										</select>
									</p>
								</div>
								<div class="inner" style="width:25%;">
									<p class="titles">H2 Weight</p>
									<p>
										<select name="h2_font_weight">
											<option value=""<?php if($h2_font_weight == '') { echo ' SELECTED'; } ?>>Normal</option>
											<option value="bold"<?php if($h2_font_weight == 'bold') { echo ' SELECTED'; } ?>>Bold</option>
										</select>
									</p>
								</div>
							
						</div>
						
						<div class="left" style="border:0;width:100%;">
							<p class="titles">H2 Font Style</p>
							<div class="font-window">
							<h3>Designer Fonts</h3>
							<?php
								$fonts3 = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."photocrati_fonts ORDER BY font_name");
								foreach ($fonts3 as $fonts3) {
									if(strpos($fonts3->font_name, 'G - ') === false) {} else {
									echo '<div class="font-float">';
									echo '<input type="radio" style="vertical-align: middle" name="h2_font_style" ';
									if(str_replace("\'", "'", str_replace('\"', '"', $h2_font_style)) == $fonts3->font_value) {
									echo 'checked="checked"'; 
									}
									echo ' value="'.str_replace('"', '\"', $fonts3->font_value).'"> ';
									echo '<font style="font-family:'.str_replace("G - ", "", str_replace(":800", "", str_replace(":100", "", str_replace(":bold", "", str_replace("\'", "'", str_replace('G - ', '', str_replace('\"', '"', $fonts3->font_value))))))).';font-size:27px;">'.str_replace('G - ','',$fonts3->font_name).' </font><BR>';
									echo '</div>';
									}
								}
							?>
							<h3 style="clear:both;">Standard Fonts</h3>
							<?php
								$fonts4 = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."photocrati_fonts ORDER BY font_name");
								foreach ($fonts4 as $fonts4) {
									if(strpos($fonts4->font_name, 'G - ') === false) {
									echo '<div class="font-float">';
									echo '<input type="radio" style="vertical-align: middle" name="h2_font_style" ';
									if(str_replace("\'", "'", str_replace('\"', '"', $h2_font_style)) == $fonts4->font_value) {
									echo 'checked="checked"'; 
									}
									echo ' value="'.str_replace('"', '\"', $fonts4->font_value).'"> ';
									echo '<font style="font-family:'.str_replace("G - ", "", str_replace("\'", "'", str_replace('"', '\"', $fonts4->font_value))).';font-size:26px;">'.str_replace('G - ','',$fonts4->font_name).' </font><BR>';
									echo '</div>';
									}
								}
							?>
							</div>
						</div>
					
					</div>
					
					
					<div id="option-container">
					
						<div class="left" style="width:100%;">
							
								<div class="inner" style="width:25%;">
									<p class="titles">H3 Color</p>
									<p>#<input type="text" name="h3_color" id="h3_color" value="<?php echo $h3_color; ?>" size="7" style="background:#<?php echo $h3_color; ?>;" /> Color</p>
								</div>
								<div class="inner" style="width:25%;">
									<p class="titles">H3 Size</p>
									<p><input type="text" name="h3_size" id="h3_size" value="<?php echo $h3_size; ?>" size="2" />px</p>
								</div>
								<div class="inner" style="width:25%;">
									<p class="titles">H3 Case</p>
									<p>
										<select name="h3_font_case">
											<option value=""<?php if($h3_font_case == '') { echo ' SELECTED'; } ?>>Normal</option>
											<option value="uppercase"<?php if($h3_font_case == 'uppercase') { echo ' SELECTED'; } ?>>All Uppercase</option>
										</select>
									</p>
								</div>
								<div class="inner" style="width:25%;">
									<p class="titles">H3 Weight</p>
									<p>
										<select name="h3_font_weight">
											<option value=""<?php if($h3_font_weight == '') { echo ' SELECTED'; } ?>>Normal</option>
											<option value="bold"<?php if($h3_font_weight == 'bold') { echo ' SELECTED'; } ?>>Bold</option>
										</select>
									</p>
								</div>
							
						</div>
						
						<div class="left" style="border:0;width:100%;">
							<p class="titles">H3 Font Style</p>
							<div class="font-window">
							<h3>Designer Fonts</h3>
							<?php
								$fonts5 = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."photocrati_fonts ORDER BY font_name");
								foreach ($fonts5 as $fonts5) {
									if(strpos($fonts5->font_name, 'G - ') === false) {} else {
									echo '<div class="font-float">';
									echo '<input type="radio" style="vertical-align: middle" name="h3_font_style" ';
									if(str_replace("\'", "'", str_replace('\"', '"', $h3_font_style)) == $fonts5->font_value) {
									echo 'checked="checked"'; 
									}
									echo ' value="'.str_replace('"', '\"', $fonts5->font_value).'"> ';
									echo '<font style="font-family:'.str_replace("G - ", "", str_replace(":800", "", str_replace(":100", "", str_replace(":bold", "", str_replace("\'", "'", str_replace('G - ', '', str_replace('\"', '"', $fonts5->font_value))))))).';font-size:27px;">'.str_replace('G - ','',$fonts5->font_name).' </font><BR>';
									echo '</div>';
									}
								}
							?>
							<h3 style="clear:both;">Standard Fonts</h3>
							<?php
								$fonts6 = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."photocrati_fonts ORDER BY font_name");
								foreach ($fonts6 as $fonts6) {
									if(strpos($fonts6->font_name, 'G - ') === false) {
									echo '<div class="font-float">';
									echo '<input type="radio" style="vertical-align: middle" name="h3_font_style" ';
									if(str_replace("\'", "'", str_replace('\"', '"', $h3_font_style)) == $fonts6->font_value) {
									echo 'checked="checked"'; 
									}
									echo ' value="'.str_replace('"', '\"', $fonts6->font_value).'"> ';
									echo '<font style="font-family:'.str_replace("G - ", "", str_replace("\'", "'", str_replace('"', '\"', $fonts6->font_value))).';font-size:26px;">'.str_replace('G - ','',$fonts6->font_name).' </font><BR>';
									echo '</div>';
									}
								}
							?>
							</div>
						</div>
						
						<div class="left" style="width:100%;">
							
								<div class="inner" style="width:25%;">
									<p class="titles">H4 Color</p>
									<p>#<input type="text" name="h4_color" id="h4_color" value="<?php echo $h4_color; ?>" size="7" style="background:#<?php echo $h4_color; ?>;" /> Color</p>
								</div>
								<div class="inner" style="width:25%;">
									<p class="titles">H4 Size</p>
									<p><input type="text" name="h4_size" id="h4_size" value="<?php echo $h4_size; ?>" size="2" />px</p>
								</div>
								<div class="inner" style="width:25%;">
									<p class="titles">H4 Case</p>
									<p>
										<select name="h4_font_case">
											<option value=""<?php if($h4_font_case == '') { echo ' SELECTED'; } ?>>Normal</option>
											<option value="uppercase"<?php if($h4_font_case == 'uppercase') { echo ' SELECTED'; } ?>>All Uppercase</option>
										</select>
									</p>
								</div>
								<div class="inner" style="width:25%;">
									<p class="titles">H4 Weight</p>
									<p>
										<select name="h4_font_weight">
											<option value=""<?php if($h4_font_weight == '') { echo ' SELECTED'; } ?>>Normal</option>
											<option value="bold"<?php if($h4_font_weight == 'bold') { echo ' SELECTED'; } ?>>Bold</option>
										</select>
									</p>
								</div>
							
						</div>
						
						<div class="left" style="border:0;width:100%;">
							<p class="titles">H4 Font Style</p>
							<div class="font-window">
							<h3>Designer Fonts</h3>
							<?php
								$fonts7 = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."photocrati_fonts ORDER BY font_name");
								foreach ($fonts7 as $fonts7) {
									if(strpos($fonts7->font_name, 'G - ') === false) {} else {
									echo '<div class="font-float">';
									echo '<input type="radio" style="vertical-align: middle" name="h4_font_style" ';
									if(str_replace("\'", "'", str_replace('\"', '"', $h4_font_style)) == $fonts7->font_value) {
									echo 'checked="checked"'; 
									}
									echo ' value="'.str_replace('"', '\"', $fonts7->font_value).'"> ';
									echo '<font style="font-family:'.str_replace("G - ", "", str_replace(":800", "", str_replace(":100", "", str_replace(":bold", "", str_replace("\'", "'", str_replace('G - ', '', str_replace('\"', '"', $fonts7->font_value))))))).';font-size:27px;">'.str_replace('G - ','',$fonts7->font_name).' </font><BR>';
									echo '</div>';
									}
								}
							?>
							<h3 style="clear:both;">Standard Fonts</h3>
							<?php
								$fonts8 = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."photocrati_fonts ORDER BY font_name");
								foreach ($fonts8 as $fonts8) {
									if(strpos($fonts8->font_name, 'G - ') === false) {
									echo '<div class="font-float">';
									echo '<input type="radio" style="vertical-align: middle" name="h4_font_style" ';
									if(str_replace("\'", "'", str_replace('\"', '"', $h4_font_style)) == $fonts8->font_value) {
									echo 'checked="checked"'; 
									}
									echo ' value="'.str_replace('"', '\"', $fonts8->font_value).'"> ';
									echo '<font style="font-family:'.str_replace("G - ", "", str_replace("\'", "'", str_replace('"', '\"', $fonts8->font_value))).';font-size:26px;">'.str_replace('G - ','',$fonts8->font_name).' </font><BR>';
									echo '</div>';
									}
								}
							?>
							</div>
						</div>
					
					</div>
					
					<div id="option-container">
					
						<div class="left" style="width:100%;">
							
								<div class="inner" style="width:25%;">
									<p class="titles">H5 Color</p>
									<p>#<input type="text" name="h5_color" id="h5_color" value="<?php echo $h5_color; ?>" size="7" style="background:#<?php echo $h5_color; ?>;" /> Color</p>
								</div>
								<div class="inner" style="width:25%;">
									<p class="titles">H5 Size</p>
									<p><input type="text" name="h5_size" id="h5_size" value="<?php echo $h5_size; ?>" size="2" />px</p>
								</div>
								<div class="inner" style="width:25%;">
									<p class="titles">H5 Case</p>
									<p>
										<select name="h5_font_case">
											<option value=""<?php if($h5_font_case == '') { echo ' SELECTED'; } ?>>Normal</option>
											<option value="uppercase"<?php if($h5_font_case == 'uppercase') { echo ' SELECTED'; } ?>>All Uppercase</option>
										</select>
									</p>
								</div>
								<div class="inner" style="width:25%;">
									<p class="titles">H5 Weight</p>
									<p>
										<select name="h5_font_weight">
											<option value=""<?php if($h5_font_weight == '') { echo ' SELECTED'; } ?>>Normal</option>
											<option value="bold"<?php if($h5_font_weight == 'bold') { echo ' SELECTED'; } ?>>Bold</option>
										</select>
									</p>
								</div>
							
						</div>
						
						<div class="left" style="border:0;width:100%;">
							<p class="titles">H5 Font Style</p>
							<div class="font-window">
							<h3>Designer Fonts</h3>
							<?php
								$fonts9 = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."photocrati_fonts ORDER BY font_name");
								foreach ($fonts9 as $fonts9) {
									if(strpos($fonts9->font_name, 'G - ') === false) {} else {
									echo '<div class="font-float">';
									echo '<input type="radio" style="vertical-align: middle" name="h5_font_style" ';
									if(str_replace("\'", "'", str_replace('\"', '"', $h5_font_style)) == $fonts9->font_value) {
									echo 'checked="checked"'; 
									}
									echo ' value="'.str_replace('"', '\"', $fonts9->font_value).'"> ';
									echo '<font style="font-family:'.str_replace("G - ", "", str_replace(":800", "", str_replace(":100", "", str_replace(":bold", "", str_replace("\'", "'", str_replace('G - ', '', str_replace('\"', '"', $fonts9->font_value))))))).';font-size:27px;">'.str_replace('G - ','',$fonts9->font_name).' </font><BR>';
									echo '</div>';
									}
								}
							?>
							<h3 style="clear:both;">Standard Fonts</h3>
							<?php
								$fonts10 = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."photocrati_fonts ORDER BY font_name");
								foreach ($fonts10 as $fonts10) {
									if(strpos($fonts10->font_name, 'G - ') === false) {
									echo '<div class="font-float">';
									echo '<input type="radio" style="vertical-align: middle" name="h5_font_style" ';
									if(str_replace("\'", "'", str_replace('\"', '"', $h5_font_style)) == $fonts10->font_value) {
									echo 'checked="checked"'; 
									}
									echo ' value="'.str_replace('"', '\"', $fonts10->font_value).'"> ';
									echo '<font style="font-family:'.str_replace("G - ", "", str_replace("\'", "'", str_replace('"', '\"', $fonts10->font_value))).';font-size:26px;">'.str_replace('G - ','',$fonts10->font_name).' </font><BR>';
									echo '</div>';
									}
								}
							?>
							</div>
								
								<div class="submit-button-wrapper">
									<input type="button" class="button" id="update-h" value="Save H1-H5 Settings" style="clear:none;" /> 
								</div>
								<div class="msg" id="msgh1" style="float:left;"></div>
								
							</form>
						</div>
					
					</div>
					
				</div>
						   
				
			<div class="options">Link Styles</div>
			
				<div class="sub-options"><span id="comments">Change the color and hover style of the links</span></div>
				<div class="option-content">
				
					<div id="option-container">
					
						<div class="left" style="border-right:0;">
						
							<form name="link-options" id="link-options" method="post">
							
								<div class="inner">
									<p class="titles">Link Color</p>
									<p>#<input type="text" name="link_color" id="link_color" value="<?php echo $link_color; ?>" size="7" style="background:#<?php echo $link_color; ?>;" /> Color</p>
								</div>
								<div class="inner">
									<p class="titles">Hover Color</p>
									<p>#<input type="text" name="link_hover_color" id="link_hover_color" value="<?php echo $link_hover_color; ?>" size="7" style="background:#<?php echo $link_hover_color; ?>;" /> Color</p>
								</div>
								
								<div class="submit-button-wrapper">
									<input type="button" class="button" id="update-link-c" value="Save Links" style="clear:none;" /> 
								</div>
								<div class="msg" id="msgcl" style="float:left;"></div>
							
						</div>
						
						<div class="right">
						
								<div class="inner">
									<p class="titles">Hover Style</p>
									<p>
									<select name="link_hover_style">
										<option value="none"<?php if($link_hover_style == 'none') {echo ' SELECTED'; } ?>>None </option>
										<option value="underline"<?php if($link_hover_style == 'underline') {echo ' SELECTED'; } ?>>Underline </option>
										<option value="overline"<?php if($link_hover_style == 'overline') {echo ' SELECTED'; } ?>>Overline </option>
									</select>
									</p>
								</div>
															
							</form>
							
						</div>
					
					</div>
							
				</div>	
				
			</div>
		
		</div>
		<?php } ?>
		
		<?php if($dynamic_style == 'YES') { ?>
		<div id="custom_tab2" class="tab_content">
			
			<script type="text/javascript">
			jQuery(document).ready(function()
			{
	
				jQuery('#fileUploadcl').uploadify({
				'uploader'  : '<?php bloginfo('template_url'); ?>/admin/js/uploadify.swf',
				'script'    : '<?php bloginfo('template_url'); ?>/admin/scripts/uploadify.php',
				'scriptData': { 'cookie' : escape(document.cookie + ';<?php echo photocrati_upload_parameter_string(); ?>'), 'session_id' : '<?php echo session_id(); ?>' },
				'auto'      : true,
				'buttonImg'	: '<?php echo photocrati_gallery_file_uri('image/upload.jpg'); ?>',
				'folder'    : '/images/uploads',
				'onComplete': function(event, queueID, fileObj, response, data) {
					 jQuery("#filesUploadedcl").html('<input type="hidden" id="custom_logo_image" name="custom_logo_image" value="'+fileObj.name+'">');
					 jQuery("#fileNamecl")
							.fadeIn('slow')
							.html(fileObj.name+' uploaded successfully!<BR><em>Remember to save.</em>');
				}
				});
	
				jQuery("#custom_logo").change(function()
				{
					if (jQuery("#custom_logo").val() == 'custom') {
						jQuery("#right-lg-cl").show();
						<?php if($one_column == 'ON') { ?>
						jQuery("#right-lg-full").show();
						jQuery("#left-sm-full").show();
						<?php } ?>
						jQuery("#right-lg-custom").hide();
						jQuery("#right-lg-custom2").hide();
						jQuery("#left-sm-custom").hide();
					} else {
						jQuery("#right-lg-cl").hide();
						<?php if($one_column == 'ON') { ?>
						jQuery("#right-lg-full").hide();
						jQuery("#left-sm-full").hide();
						<?php } ?>
						jQuery("#right-lg-custom").show();
						jQuery("#right-lg-custom2").show();
						jQuery("#left-sm-custom").show();
					}
				});
	
				jQuery("#one_column_logo").change(function()
				{
					if (jQuery("#one_column_logo").val() == 'ON') {
						jQuery("#right-lg-margin").show();
						jQuery("#left-sm-margin").show();
					} else {
						jQuery("#right-lg-margin").hide();
						jQuery("#left-sm-margin").hide();
					}
				});
				
				jQuery("#update-logo").click(function()
				{
				
				jQuery("#msghl").html("<img src='<?php bloginfo('template_url'); ?>/admin/images/ajax-loader.gif'>");
				jQuery("#msghl").show();
				
					var str2 = jQuery("#logo-options").serialize();
					jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/edit-styles.php", data: str2, success: function(data)
					{
						jQuery("#msghl").html("Logo Changes Saved");
						jQuery("#msghl")
							.animate({opacity: 1.0}, 2000)
							.fadeOut('slow');
						if(jQuery('#custom_logo_image').length == 0){ } else {
						jQuery("#fileName").html(jQuery('#custom_logo_image').val()+'');
						}
					}
					});
				});
				
				jQuery("#delete-image").click(function()
				{
					var answer = confirm("Are you sure you want to remove the custom logo? It will remain in your theme directory under images/uploads.")
					if (answer){
						jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/delete-logo.php", data: "custom_logo=default&custom_logo_image=", success: function(data)
						{
				
				jQuery("#msghl").html("<img src='<?php bloginfo('template_url'); ?>/admin/images/ajax-loader.gif'>");
				jQuery("#msghl").show();
				
							jQuery("#msghl").html("Background image removed");
							jQuery("#msghl")
								.animate({opacity: 1.0}, 2000)
								.fadeOut('slow');
							jQuery("#fileNamecl").html('<em>There is currently no image uploaded</em>');
						}
						});
					}
				});
				
				jQuery("#update-sizes").click(function()
				{
				
				jQuery("#msghhlp").html("<img src='<?php bloginfo('template_url'); ?>/admin/images/ajax-loader.gif'>");
				jQuery("#msghhlp").show();
				
					var str2 = jQuery("#header-sizes").serialize();
					jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/edit-styles.php", data: str2, success: function(data)
					{
						jQuery("#msghhlp").html("Header Height & Logo Padding Saved");
						jQuery("#msghhlp")
							.animate({opacity: 1.0}, 2000)
							.fadeOut('slow');
					}
					});
				});
				
				var clicked = '';
				
				jQuery("#left-right").click(function()
				{
					var answer = confirm("Are you sure you want to set your logo to the left and your menu to the right?")
					if (answer){
						jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/logo-left-right.php", data: '', success: function(data)
						{
							//window.location = window.location;
							jQuery("[id^=msgmp_]").each(function(index) {
							jQuery(this).fadeOut('slow');
							});
							jQuery("#msgmp_1").fadeIn('slow');
							//jQuery("#msgmp1").attr("id","msgmpc");
							<?php if($one_column_logo == 'ON') { ?>
							jQuery("#header_logo_margin_above").val("0");
							jQuery("#header_logo_margin_below").val("0");
							<?php } ?>
							if (jQuery("#one_column_logo").val() == 'ON') {
								<?php if($one_column == 'ON') { ?>
								jQuery("#right-lg-margin").show();
								jQuery("#left-sm-margin").show();
								<?php } ?>
							} else {
								<?php if($one_column == 'ON') { ?>
								jQuery("#right-lg-margin").hide();
								jQuery("#left-sm-margin").hide();
								<?php } ?>
							}
						}
						});
					}
				});	
				
				jQuery("#right-left").click(function()
				{
					var answer = confirm("Are you sure you want to set your logo to the right and your menu to the left?")
					if (answer){
						jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/logo-right-left.php", data: '', success: function(data)
						{
							//window.location = window.location;
							jQuery("[id^=msgmp_]").each(function(index) {
							jQuery(this).fadeOut('slow');
							});
							jQuery("#msgmp_2").fadeIn('slow');
							//jQuery("#msgmp2").attr("id","msgmpc");
							<?php if($one_column_logo == 'ON') { ?>
							jQuery("#header_logo_margin_above").val("0");
							jQuery("#header_logo_margin_below").val("0");
							<?php } ?>
							if (jQuery("#one_column_logo").val() == 'ON') {
								<?php if($one_column == 'ON') { ?>
								jQuery("#right-lg-margin").show();
								jQuery("#left-sm-margin").show();
								<?php } ?>
							} else {
								<?php if($one_column == 'ON') { ?>
								jQuery("#right-lg-margin").hide();
								jQuery("#left-sm-margin").hide();
								<?php } ?>
							}
						}
						});
					}
				});	
				
				jQuery("#bottom-top").click(function()
				{
					var answer = confirm("Are you sure you want to set your logo to the bottom and your menu to the top?")
					if (answer){
						jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/logo-bottom-top.php", data: '', success: function(data)
						{
							//window.location = window.location;
							jQuery("[id^=msgmp_]").each(function(index) {
							jQuery(this).fadeOut('slow');
							});
							jQuery("#msgmp_3").fadeIn('slow');
							//jQuery("#msgmp3").attr("id","msgmpc");
							<?php if($one_column_logo == 'ON') { ?>
							jQuery("#header_logo_margin_above").val("0");
							jQuery("#header_logo_margin_below").val("0");
							<?php } ?>
							jQuery("#right-lg-margin").hide();
							jQuery("#left-sm-margin").hide();
						}
						});
					}
				});	
				
				jQuery("#top-bottom").click(function()
				{
					var answer = confirm("Are you sure you want to set your logo to the top and your menu to the bottom?")
					if (answer){
						jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/logo-top-bottom.php", data: '', success: function(data)
						{
							//window.location = window.location;
							jQuery("[id^=msgmp_]").each(function(index) {
							jQuery(this).fadeOut('slow');
							});
							jQuery("#msgmp_4").fadeIn('slow');
							//jQuery("#msgmp4").attr("id","msgmpc_4");
							<?php if($one_column_logo == 'ON') { ?>
							jQuery("#header_logo_margin_above").val("0");
							jQuery("#header_logo_margin_below").val("0");
							<?php } ?>
							jQuery("#right-lg-margin").hide();
							jQuery("#left-sm-margin").hide();
						}
						});
					}
				});
	
				jQuery('#fileUploadh').uploadify({
				'uploader'  : '<?php bloginfo('template_url'); ?>/admin/js/uploadify.swf',
				'script'    : '<?php bloginfo('template_url'); ?>/admin/scripts/uploadify.php',
				'scriptData': { 'cookie' : escape(document.cookie + ';<?php echo photocrati_upload_parameter_string(); ?>'), 'session_id' : '<?php echo session_id(); ?>' },
				'auto'      : true,
				'buttonImg'	: '<?php echo photocrati_gallery_file_uri('image/upload.jpg'); ?>',
				'folder'    : '/images/uploads',
				'onComplete': function(event, queueID, fileObj, response, data) {
					 jQuery("#filesUploadedh").html('<input type="hidden" id="header_bg_image" name="header_bg_image" value="'+fileObj.name+'">');
					 jQuery("#fileNameh")
							.fadeIn('slow')
							.html(fileObj.name+' uploaded successfully!<BR><em>Remember to save.</em>');
				}
				});
	
				jQuery("#update-header").click(function()
				{
				
				jQuery("#msghb").html("<img src='<?php bloginfo('template_url'); ?>/admin/images/ajax-loader.gif'>");
				jQuery("#msghb").show();
				
					var str2 = jQuery("#header-options").serialize();
					jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/edit-styles.php", data: str2, success: function(data)
					{
						jQuery("#msghb").html("Header Changes Saved");
						jQuery("#msghb")
							.animate({opacity: 1.0}, 2000)
							.fadeOut('slow');
						if(jQuery('#header_bg_image').length == 0){ } else {
						jQuery("#fileNameh").html(jQuery('#header_bg_image').val()+'');
						}
					}
					});
				});
	
				jQuery("#delete-header-image").click(function()
				{
				
					var answer = confirm("Are you sure you want to remove the header background image? It will remain in your theme directory under images/uploads.")
					if (answer){
				
				jQuery("#msghb").html("<img src='<?php bloginfo('template_url'); ?>/admin/images/ajax-loader.gif'>");
				jQuery("#msghb").show();
				
						jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/delete-header-background.php", data: "header_bg_image=", success: function(data)
						{
							jQuery("#msghb").html("Background image removed");
							jQuery("#msghb")
								.animate({opacity: 1.0}, 2000)
								.fadeOut('slow');
							jQuery("#fileNameh").html('<em>There is currently no image uploaded</em>');
						}
						});
					}
				});
				
				jQuery("#reset-menu-styles").click(function()
				{
					var answer = confirm("Are you sure you want to reset the menu styles? This cannot be undone.")
					if (answer){
						jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/reset-menu-styles.php", data: '', success: function(data)
						{
							window.location = window.location;
						}
						});
					}
				});
				
				jQuery("#menu_style").change(function()
				{
					if (jQuery("#menu_style").val() == 'color') {
						jQuery("#menu-style").show();
					} else {
						jQuery("#menu-style").hide();
					}
				});
				
				jQuery("#update-menu-c").click(function()
				{
				
				jQuery("#msgms").html("<img src='<?php bloginfo('template_url'); ?>/admin/images/ajax-loader.gif'>");
				jQuery("#msgms").show();
				
					var str2 = jQuery("#menu-options").serialize();
					jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/edit-styles.php", data: str2, success: function(data)
					{
						jQuery("#msgms").html("Menu Changes Saved");
						jQuery("#msgms")
							.animate({opacity: 1.0}, 2000)
							.fadeOut('slow');
					}
					});
				});
				
				jQuery("#update-submenu-c").click(function()
				{
				
				jQuery("#msgsms").html("<img src='<?php bloginfo('template_url'); ?>/admin/images/ajax-loader.gif'>");
				jQuery("#msgsms").show();
				
					var str2 = jQuery("#submenu-options").serialize();
					jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/edit-styles.php", data: str2, success: function(data)
					{
						jQuery("#msgsms").html("Dropdown Changes Saved");
						jQuery("#msgsms")
							.animate({opacity: 1.0}, 2000)
							.fadeOut('slow');
					}
					});
				});
				
			});
			</script>	
			
			<div id="container"> 	
				
				<div class="options">Header Logo</div>
        
					<div class="sub-options"><span id="comments">Upload your own logo (225px by 90px recommended) or use the blog title / description</span></div>
					<div class="option-content">
					
						<div id="option-container">
						
						<form name="logo-options" id="logo-options" method="post">
						
							<div class="left-sm">
								<p class="titles">Logo Options</p>
								<p>
									<select name="custom_logo" id="custom_logo">
										<option value="title"<?php if($custom_logo == 'title') {echo ' SELECTED'; } ?>>Wordpress Title </option>
										<option value="custom"<?php if($custom_logo == 'custom') {echo ' SELECTED'; } ?>>Custom Logo </option>
									</select>
								</p>
							</div>
							
							<div class="right-lg" id="right-lg-custom" <?php if($custom_logo == 'custom') { echo 'style="display:none;"'; } ?>>
								<div class="right" style="width:100%;">
									<div class="inner" style="width:22%;">
										<p class="titles">Title Size</p>
										<p><input type="text" name="title_size" id="title_size" value="<?php echo $title_size; ?>" size="2" />px</p>
									</div>
									<div class="inner" style="width:28%;">
										<p class="titles">Title Color</p>
										<p>#<input type="text" name="title_color" id="title_color" value="<?php echo $title_color; ?>" size="7" style="background:#<?php echo $title_color; ?>;" /> Color</p>
									</div>
									<div class="inner" style="width:28%;">
										<p class="titles">Title Case</p>
										<p>
											<select name="title_font_style">
												<option value=""<?php if($title_font_style == '') { echo ' SELECTED'; } ?>>Normal</option>
												<option value="uppercase"<?php if($title_font_style == 'uppercase') { echo ' SELECTED'; } ?>>All Uppercase</option>
											</select>
										</p>
									</div>
									<div class="inner" style="width:22%;">
										<p class="titles">Title Weight</p>
										<p>
											<select name="title_font_weight">
												<option value=""<?php if($title_font_weight == '') { echo ' SELECTED'; } ?>>Normal</option>
												<option value="bold"<?php if($title_font_weight == 'bold') { echo ' SELECTED'; } ?>>Bold</option>
											</select>
										</p>
									</div>
								</div>
								<div class="left" style="border:0;width:100%;">
									<p class="titles">Title Style</p>
									<div class="font-window">
									<h3>Designer Fonts</h3>
									<?php
										$fonts = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."photocrati_fonts ORDER BY font_name");
										foreach ($fonts as $fonts) {
											if(strpos($fonts->font_name, 'G - ') === false) {} else {
											echo '<div class="font-float">';
											echo '<input type="radio" style="vertical-align: middle" name="title_style" ';
											if(str_replace("\'", "'", str_replace('\"', '"', $title_style)) == $fonts->font_value) {
											echo 'checked="checked"'; 
											}
											echo ' value="'.str_replace('"', '\"', $fonts->font_value).'"> ';
											echo '<font style="font-family:'.str_replace(":800", "", str_replace(":100", "", str_replace(":bold", "", str_replace("\'", "'", str_replace('G - ', '', str_replace('\"', '"', $fonts->font_value)))))).';font-size:27px;">'.str_replace('G - ','',$fonts->font_name).' </font><BR>';
											echo '</div>';
											}
										}
									?>
									<h3 style="clear:both;">Standard Fonts</h3>
									<?php
										$fonts = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."photocrati_fonts ORDER BY font_name");
										foreach ($fonts as $fonts) {
											if(strpos($fonts->font_name, 'G - ') === false) {
											echo '<div class="font-float">';
											echo '<input type="radio" style="vertical-align: middle" name="title_style" ';
											if(str_replace("\'", "'", str_replace('\"', '"', $title_style)) == $fonts->font_value) {
											echo 'checked="checked"'; 
											}
											echo ' value="'.str_replace('"', '\"', $fonts->font_value).'"> ';
											echo '<font style="font-family:'.str_replace("G - ", "", str_replace("\'", "'", str_replace('"', '\"', $fonts->font_value))).';font-size:24px;text-transform:uppercase;">'.str_replace('G - ','',$fonts->font_name).' </font><BR>';
											echo '</div>';
											}
										}
									?>
									</div>
								</div>
							</div>
							
							<div class="left-sm" id="left-sm-custom" <?php if($custom_logo == 'custom') { echo 'style="display:none;"'; } ?>>
								<p class="titles"></p>
							</div>
							
							<div class="right-lg" id="right-lg-custom2" <?php if($custom_logo == 'custom') { echo 'style="display:none;"'; } ?>>
								<div class="right" style="width:100%;">
									<div class="inner">
										<p class="titles">Description Size</p>
										<p><input type="text" name="description_size" id="description_size" value="<?php echo $description_size; ?>" size="2" />px</p>
									</div>
									<div class="inner">
										<p class="titles">Description Color</p>
										<p>#<input type="text" name="description_color" id="description_color" value="<?php echo $description_color; ?>" size="7" style="background:#<?php echo $description_color; ?>;" /> Color</p>
									</div>
								</div>
								
								<div class="left" style="border:0;width:100%;">
									<p class="titles">Description Style</p>
									<div class="font-window">
									<h3>Designer Fonts</h3>
									<?php
										$fonts = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."photocrati_fonts ORDER BY font_name");
										foreach ($fonts as $fonts) {
											if(strpos($fonts->font_name, 'G - ') === false) {} else {
											echo '<div class="font-float">';
											echo '<input type="radio" style="vertical-align: middle" name="description_style" ';
											if(str_replace("\'", "'", str_replace('\"', '"', $description_style)) == $fonts->font_value) {
											echo 'checked="checked"'; 
											}
											echo ' value="'.str_replace('"', '\"', $fonts->font_value).'"> ';
											echo '<font style="font-family:'.str_replace("G - ", "", str_replace(":800", "", str_replace(":100", "", str_replace(":bold", "", str_replace("\'", "'", str_replace('G - ', '', str_replace('\"', '"', $fonts->font_value))))))).';font-size:27px;">'.str_replace('G - ','',$fonts->font_name).' </font><BR>';
											echo '</div>';
											}
										}
									?>
									<h3 style="clear:both;">Standard Fonts</h3>
									<?php
										$fonts = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."photocrati_fonts ORDER BY font_name");
										foreach ($fonts as $fonts) {
											if(strpos($fonts->font_name, 'G - ') === false) {
											echo '<div class="font-float">';
											echo '<input type="radio" style="vertical-align: middle" name="description_style" ';
											if(str_replace("\'", "'", str_replace('\"', '"', $description_style)) == $fonts->font_value) {
											echo 'checked="checked"'; 
											}
											echo ' value="'.str_replace('"', '\"', $fonts->font_value).'"> ';
											echo '<font style="font-family:'.str_replace("G - ", "", str_replace("\'", "'", str_replace('"', '\"', $fonts->font_value))).';font-size:26px;">'.str_replace('G - ','',$fonts->font_name).' </font><BR>';
											echo '</div>';
											}
										}
									?>
									</div>
								</div>
							</div>
							
							<div class="right-lg" id="right-lg-cl" <?php if($custom_logo <> 'custom') { echo 'style="display:none;"'; } ?>>
								<div class="left" style="border:0;">
									<p class="titles" style="margin-bottom:4px;">Upload a Custom logo</p>
									<?php 
										$load = dirname(dirname(__FILE__)).'/images/uploads/'; 
										if (!is_writable($load)) {
											echo '<p class="warning"><b>The uploads directory images/uploads must be writable</b>!<BR><em>See <a href="http://codex.wordpress.org/Changing_File_Permissions" target="_blank">the Codex</a> for more information.</em></p>';
										} else {
											echo '<input type="file" name="fileUploadcl" id="fileUploadcl" />';
										}						
									?>
									<div id="filesUploadedcl"></div>
								</div>
								<div class="right">
									<p class="titles">Current Custom Logo</p>
									<?php if($custom_logo_image <> '') { ?>
										<div id="fileNamecl">
										<p><?php echo $custom_logo_image; ?>
										&nbsp;<a id="image_preview" href="<?php bloginfo('template_url'); ?>/images/uploads/<?php echo $custom_logo_image; ?>"><img src="<?php bloginfo('template_url'); ?>/admin/images/view.png" border="0" /></a> 
										&nbsp;<a id="delete-image"><img class="delete" src="<?php bloginfo('template_url'); ?>/admin/images/delete.png" border="0" /></a> 
										</p>
										</div>
									<?php } else { ?>
										<div id="fileNamecl"><p><em>There is currently no logo uploaded</em></p></div>
									<?php } ?>
								</div>
							</div>
		
							<div style="<?php if($one_column <> 'ON') { echo 'display:none;'; } ?>" id="full_width_wrapper">
							
								<div class="clear"></div>
								<div class="left-sm" id="left-sm-full" <?php if($custom_logo <> 'custom') { echo 'style="display:none;"'; } ?>>
									<p class="titles">Full Width Logo / Header</p>
									<p>
										<select name="one_column_logo" id="one_column_logo">
											<option value="OFF"<?php if($one_column_logo == 'OFF') {echo ' SELECTED'; } ?>>OFF </option>
											<option value="ON"<?php if($one_column_logo == 'ON') {echo ' SELECTED'; } ?>>ON </option>
										</select>
									</p>
								</div>
								
								<div class="right-lg" id="right-lg-full" <?php if($custom_logo <> 'custom') { echo 'style="display:none;"'; } ?>>
									<div class="left" style="border:0;width:100%;">
										<p class="notes" style="padding-top:10px;">
											If you turn Full Width Logo / Header on, you must upload an image that is <b>990px wide</b> to fill the
											entire header width!
										</p>
									</div>
								</div>
								
							</div>
							
							<div class="submit-button-wrapper">
								<input type="button" class="button" id="update-logo" value="Save Logo" style="clear:none;" /> 
							</div>
							<div class="msg" id="msghl" style="float:left;"></div>
						
						</form>
						
						</div>
						
				</div>
				
				<div class="options">Header Height & Logo Padding</div>
				
					<div class="sub-options"><span id="comments">If you are using a large logo you can adjust the header height and logo padding here</span></div>
					<div class="option-content">
					
						<div id="option-container">
						
						<form name="header-sizes" id="header-sizes" method="post">
						
							<div class="left-sm">
								<p class="titles">Header Height</p>
								<p><input type="text" name="header_height" id="header_height" value="<?php echo $header_height; ?>" size="2" />px</p>
							</div>
							
							<div class="right-lg" id="right-lg">
								<div class="left" style="border:0;">
									<p class="titles">Logo Top Padding</p>
									<p><input type="text" name="header_logo_margin_above" id="header_logo_margin_above" value="<?php echo $header_logo_margin_above; ?>" size="2" />px</p>
								</div>
								<div class="right">
									<p class="titles">Logo Bottom Padding</p>
									<p><input type="text" name="header_logo_margin_below" id="header_logo_margin_below" value="<?php echo $header_logo_margin_below; ?>" size="2" />px</p>
								</div>
							</div>
		
							<div class="clear"></div>
							<div class="left-sm" id="left-sm-margin" <?php if($custom_logo <> 'custom' || $one_column_logo == 'OFF') { echo 'style="display:none;"'; } ?>>
								<p class="titles">Menu Top Margin</p>
									<p><input type="text" name="one_column_margin" id="one_column_margin" value="<?php echo $one_column_margin; ?>" size="2" />px</p>
							</div>
							
							<div class="right-lg" id="right-lg-margin" <?php if($custom_logo <> 'custom' || $one_column_logo == 'OFF') { echo 'style="display:none;"'; } ?>>
								<div class="left" style="border:0;width:100%;">
									<p class="notes" style="padding-top:10px;">
										You can control the vertical position of the menu with this setting. This is useful if you have a full
										width logo and want the menu positioned near the top or bottom of the image.
									</p>
								</div>
							</div>
							
							<div class="submit-button-wrapper">
								<input type="button" class="button" id="update-sizes" value="Save Height & Logo Margins" style="clear:none;" /> 
							</div>
							<div class="msg" id="msghhlp" style="float:left;"></div>
						
						</form>
						
						</div>
						
				</div>
				
						
				<div class="options">Logo & Menu Positions</div>
				
					<div class="sub-options"><span id="comments">Choose the positions of the menu and logo. Click the button of choice to select the desired position.</span></div>
					<div class="option-content">
					
						<div id="option-container">
						
						<form name="logo-menu-options" id="logo-menu-options" method="post">
						
							<div class="left" id="color-choices" style="overflow:hidden;">
							
								<p>
									<div class="option">
									<img src="<?php bloginfo('template_directory'); ?>/admin/images/logo-left-right.jpg" />
									<input type="button" class="button" id="left-right" value="Logo Left / Menu Right" /> 
									<?php if($logo_menu_position == 'left-right') { ?>
									<img id="msgmp_c" src="<?php bloginfo('template_directory'); ?>/admin/images/check.png" style="border:0;" align="absmiddle" />
									<?php } ?>
									<img id="msgmp_1" src="<?php bloginfo('template_directory'); ?>/admin/images/check.png" style="border:0;display:none;" align="absmiddle" />
									</div>
									<div class="option">
									<img src="<?php bloginfo('template_directory'); ?>/admin/images/logo-right-left.jpg" />
									<input type="button" class="button" id="right-left" value="Logo Right / Menu Left" /> 
									<?php if($logo_menu_position == 'right-left') { ?>
									<img id="msgmp_c" src="<?php bloginfo('template_directory'); ?>/admin/images/check.png" style="border:0;" align="absmiddle" />
									<?php } ?>
									<img id="msgmp_2" src="<?php bloginfo('template_directory'); ?>/admin/images/check.png" style="border:0;display:none;" align="absmiddle" />
									</div>
									<div class="option">
									<img src="<?php bloginfo('template_directory'); ?>/admin/images/logo-bottom-top.jpg" />
									<input type="button" class="button" id="bottom-top" value="Logo Bottom / Menu Top" /> 
									<?php if($logo_menu_position == 'bottom-top') { ?>
									<img id="msgmp_c" src="<?php bloginfo('template_directory'); ?>/admin/images/check.png" style="border:0;" align="absmiddle" />
									<?php } ?>
									<img id="msgmp_3" src="<?php bloginfo('template_directory'); ?>/admin/images/check.png" style="border:0;display:none;" align="absmiddle" />
									</div>
								</p>
								
								<p>
									<div class="option">
									<img src="<?php bloginfo('template_directory'); ?>/admin/images/logo-top-bottom.jpg" />
									<input type="button" class="button" id="top-bottom" value="Logo Top / Menu Bottom" /> 
									<?php if($logo_menu_position == 'top-bottom') { ?>
									<img id="msgmp_c" src="<?php bloginfo('template_directory'); ?>/admin/images/check.png" style="border:0;" align="absmiddle" />
									<?php } ?>
									<img id="msgmp_4" src="<?php bloginfo('template_directory'); ?>/admin/images/check.png" style="border:0;display:none;" align="absmiddle" />
									</div>
								</p>
								
							</div>
							
						</form>
						
						</div>
						
				</div>
				
				<div class="options">Header Background</div>
			
				<div class="sub-options"><span id="comments">Change the color or image on the header background</span></div>
				<div class="option-content">
				
					<div id="option-container">
					
					<form name="header-options" id="header-options" method="post">
					
						<div class="left-sm">
							<p class="titles">Background Color</p>
							<p>#<input type="text" name="header_bg_color" id="header_bg_color" value="<?php echo $header_bg_color; ?>" size="7" style="background:#<?php echo $header_bg_color; ?>;" /> Color</p>
						</div>
						
						<div class="right-lg">
							<div class="left" style="border:0;">
								<p class="titles" style="margin-bottom:4px;">Background Image</p>
								<?php 
									$load = dirname(dirname(__FILE__)).'/images/uploads/'; 
									if (!is_writable($load)) {
										echo '<p class="warning"><b>The uploads directory images/uploads must be writable</b>!<BR><em>See <a href="http://codex.wordpress.org/Changing_File_Permissions" target="_blank">the Codex</a> for more information.</em></p>';
									} else {
										echo '<input type="file" name="fileUploadh" id="fileUploadh" />';
									}							
								?>
								<div id="filesUploadedh"></div>
							</div>
							<div class="right">
								<p class="titles">Current Background Image</p>
								
									<div id="fileNameh">
									<p>
									<?php if($header_bg_image <> '') { ?>
										<?php echo $header_bg_image; ?> 
										&nbsp;<a id="image_preview" href="<?php bloginfo('template_url'); ?>/images/uploads/<?php echo $header_bg_image; ?>"><img src="<?php bloginfo('template_url'); ?>/admin/images/view.png" border="0" /></a>
										&nbsp;<a id="delete-header-image"><img class="delete" src="<?php bloginfo('template_url'); ?>/admin/images/delete.png" border="0" /></a>
									<?php } else { ?>
										<div id="fileNameh"><p><em>There is currently no image uploaded</em></p></div>
									<?php } ?>
									</p>
									</div>
									<p>
									<input type="radio" name="header_bg_repeat" value="repeat"<?php if($header_bg_repeat == 'repeat') { echo ' checked'; } ?> /> Tile
									<BR /><input type="radio" name="header_bg_repeat" value="no-repeat"<?php if($header_bg_repeat == 'no-repeat') { echo ' checked'; } ?> /> No Repeat
									<BR /><input type="radio" name="header_bg_repeat" value="repeat-x"<?php if($header_bg_repeat == 'repeat-x') { echo ' checked'; } ?> /> Repeat Horizontal
									<BR /><input type="radio" name="header_bg_repeat" value="repeat-y"<?php if($header_bg_repeat == 'repeat-y') { echo ' checked'; } ?> /> Repeat Vertical
									</p>
								
							</div>
						</div>
						
						<div class="submit-button-wrapper">
							<input type="button" class="button" id="update-header" value="Save Header Background" style="clear:none;" /> 
						</div>
						<div class="msg" id="msghb" style="float:left;"></div>
					
					</form>
					
					</div>
					
				</div>
				
				<div class="options">Parent Menu Items</div>
        
					<div class="sub-options"><span id="comments">Change the color of menus and menu text</span></div>
					<div class="option-content">
					
						<div id="option-container">
						
							<div class="left" style="width:100%;">
							
								<form name="menu-options" id="menu-options" method="post">
								
									<div class="inner" style="width:33%;">
										<p class="titles">Menu Background Style</p>
										<p>
										<select id="menu_style" name="menu_style">
											<option value="transparent"<?php if($menu_style == 'transparent') {echo ' SELECTED'; } ?>>Transparent </option>
											<option value="color"<?php if($menu_style <> 'transparent') {echo ' SELECTED'; } ?>>Color </option>
										</select>
										</p>
									</div>
									
									<div id="menu-style"<?php if($menu_style == 'transparent') {echo ' style="display:none;"'; } ?>>
										<div class="inner" style="width:33%;">
											<p class="titles">Background Color</p>
											<p>#<input type="text" name="menu_color" id="menu_color" value="<?php echo $menu_color; ?>" size="7" style="background:#<?php echo $menu_color; ?>;" /> Color</p>
										</div>
										<div class="inner" style="width:33%;">
											<p class="titles">Hover / Active Color</p>
											<p>#<input type="text" name="menu_hover_color" id="menu_hover_color" value="<?php echo $menu_hover_color; ?>" size="7" style="background:#<?php echo $menu_hover_color; ?>;" /> Color</p>
										</div>
									</div>      
								
								
							</div>
							
							<div class="left" style="width:100%;">
									
									<div class="inner" style="width:33%;">
										<p class="titles">Font Color</p>
										<p>#<input type="text" name="menu_font_color" id="menu_font_color" value="<?php echo $menu_font_color; ?>" size="7" style="background:#<?php echo $menu_font_color; ?>;" /> Color</p>
									</div>
									<div class="inner" style="width:33%;">
										<p class="titles">Font Hover/Active Color</p>
										<p>#<input type="text" name="menu_font_hover_color" id="menu_font_hover_color" value="<?php echo $menu_font_hover_color; ?>" size="7" style="background:#<?php echo $menu_font_hover_color; ?>;" /> Color</p>
									</div>
							
									<div class="inner" style="width:33%;">
										<p class="titles">Font Size</p>
										<p><input type="text" name="menu_font_size" id="menu_font_size" value="<?php echo $menu_font_size; ?>" size="2" />px</p>
									</div>
									<div class="inner" style="width:62%;padding-right:4%;">
										<p class="titles">Font Style</p>
										<div class="font-window">
										<h3>Designer Fonts</h3>
										<?php
											$fonts = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."photocrati_fonts ORDER BY font_name");
											foreach ($fonts as $fonts) {
												if(strpos($fonts->font_name, 'G - ') === false) {} else {
												echo '<div class="font-float">';
												echo '<input type="radio" style="vertical-align: middle" name="menu_font_style" ';
												if(str_replace("\'", "'", str_replace('\"', '"', $menu_font_style)) == $fonts->font_value) {
												echo 'checked="checked"'; 
												}
												echo ' value="'.str_replace('"', '\"', $fonts->font_value).'"> ';
												echo '<font style="font-family:'.str_replace(":800", "", str_replace(":100", "", str_replace(":bold", "", str_replace("\'", "'", str_replace('G - ', '', str_replace('\"', '"', $fonts->font_value)))))).';font-size:27px;">'.str_replace('G - ','',$fonts->font_name).' </font><BR>';
												echo '</div>';
												}
											}
										?>
										<h3 style="clear:both;">Standard Fonts</h3>
										<?php
											$fonts = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."photocrati_fonts ORDER BY font_name");
											foreach ($fonts as $fonts) {
												if(strpos($fonts->font_name, 'G - ') === false) {
												echo '<div class="font-float">';
												echo '<input type="radio" style="vertical-align: middle" name="menu_font_style" ';
												if(str_replace("\'", "'", str_replace('\"', '"', $menu_font_style)) == $fonts->font_value) {
												echo 'checked="checked"'; 
												}
												echo ' value="'.str_replace('"', '\"', $fonts->font_value).'"> ';
												echo '<font style="font-family:'.str_replace("G - ", "", str_replace("\'", "'", str_replace('"', '\"', $fonts->font_value))).';font-size:24px;text-transform:uppercase;">'.str_replace('G - ','',$fonts->font_name).' </font><BR>';
												echo '</div>';
												}
											}
										?>
										</div>
									</div>
									<div class="inner" style="width:33%;">
										<p class="titles">Font Case</p>
										<p>
											<select name="menu_font_case">
												<option value="normal"<?php if($menu_font_case == 'normal') { echo ' SELECTED'; } ?>>Normal</option>
												<option value="uppercase"<?php if($menu_font_case == '' || $menu_font_case == 'uppercase') { echo ' SELECTED'; } ?>>All Uppercase</option>
											</select>
										</p>
									</div>
									
									<div class="submit-button-wrapper">
										<input type="button" class="button" id="update-menu-c" value="Save Menu Changes" style="clear:none;" /> 
									</div>
									<div class="msg" id="msgms" style="float:left;"></div>
							   
							   </form>
													   
							</div>
						
						</div>
								
					</div>
					
					<div class="options">Dropdown Menu Items</div>
					
						<div class="sub-options"><span id="comments">Change the color of dropdown menus and dropdown menu text</span></div>
						<div class="option-content">
						
							<div id="option-container">
							
								<div class="left" style="width:100%;">
								
									<form name="submenu-options" id="submenu-options" method="post">
									
										<div class="inner" style="width:24%;">
											<p class="titles">Background Color</p>
											<p>#<input type="text" name="submenu_color" id="submenu_color" value="<?php echo $submenu_color; ?>" size="7" style="background:#<?php echo $submenu_color; ?>;" /> Color</p>
										</div>
										<div class="inner" style="width:24%;">
											<p class="titles">Hover / Active Color</p>
											<p>#<input type="text" name="submenu_hover_color" id="submenu_hover_color" value="<?php echo $submenu_hover_color; ?>" size="7" style="background:#<?php echo $submenu_hover_color; ?>;" /> Color</p>
										</div>
										
										<div class="inner" style="width:24%;">
											<p class="titles">Font Color</p>
											<p>#<input type="text" name="submenu_font_color" id="submenu_font_color" value="<?php echo $submenu_font_color; ?>" size="7" style="background:#<?php echo $submenu_font_color; ?>;" /> Color</p>
										</div>
										<div class="inner" style="width:24%;">
											<p class="titles">Font Hover / Active Color</p>
											<p>#<input type="text" name="submenu_font_hover_color" id="submenu_font_hover_color" value="<?php echo $submenu_font_hover_color; ?>" size="7" style="background:#<?php echo $submenu_font_hover_color; ?>;" /> Color</p>
										</div>
									
									
									
								</div>
								
								<div class="left" style="width:100%;">
										
										<div class="inner">
											<p class="titles">Font Size</p>
											<p><input type="text" name="submenu_font_size" id="submenu_font_size" value="<?php echo $submenu_font_size; ?>" size="2" />px</p>
										</div>
										<div class="inner">
											<p class="titles">Font Case</p>
											<p>
												<select name="submenu_font_case">
													<option value="normal"<?php if($submenu_font_case == 'normal') { echo ' SELECTED'; } ?>>Normal</option>
													<option value="uppercase"<?php if($submenu_font_case == '' || $submenu_font_case == 'uppercase') { echo ' SELECTED'; } ?>>All Uppercase</option>
												</select>
											</p>
										</div>
								
										<div class="inner" style="width:100%;">
											<p class="titles">Font Style</p>
											<div class="font-window">
											<h3>Designer Fonts</h3>
											<?php
												$fonts = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."photocrati_fonts ORDER BY font_name");
												foreach ($fonts as $fonts) {
													if(strpos($fonts->font_name, 'G - ') === false) {} else {
													echo '<div class="font-float">';
													echo '<input type="radio" style="vertical-align: middle" name="submenu_font_style" ';
													if(str_replace("\'", "'", str_replace('\"', '"', $submenu_font_style)) == $fonts->font_value) {
													echo 'checked="checked"'; 
													}
													echo ' value="'.str_replace('"', '\"', $fonts->font_value).'"> ';
													echo '<font style="font-family:'.str_replace(":800", "", str_replace(":100", "", str_replace(":bold", "", str_replace("\'", "'", str_replace('G - ', '', str_replace('\"', '"', $fonts->font_value)))))).';font-size:27px;">'.str_replace('G - ','',$fonts->font_name).' </font><BR>';
													echo '</div>';
													}
												}
											?>
											<h3 style="clear:both;">Standard Fonts</h3>
											<?php
												$fonts = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."photocrati_fonts ORDER BY font_name");
												foreach ($fonts as $fonts) {
													if(strpos($fonts->font_name, 'G - ') === false) {
													echo '<div class="font-float">';
													echo '<input type="radio" style="vertical-align: middle" name="submenu_font_style" ';
													if(str_replace("\'", "'", str_replace('\"', '"', $submenu_font_style)) == $fonts->font_value) {
													echo 'checked="checked"'; 
													}
													echo ' value="'.str_replace('"', '\"', $fonts->font_value).'"> ';
													echo '<font style="font-family:'.str_replace("G - ", "", str_replace("\'", "'", str_replace('"', '\"', $fonts->font_value))).';font-size:24px;text-transform:uppercase;">'.str_replace('G - ','',$fonts->font_name).' </font><BR>';
													echo '</div>';
													}
												}
											?>
											</div>
										</div>
									
										<div class="submit-button-wrapper">
											<input type="button" class="button" id="update-submenu-c" value="Save Dropdown Changes" style="clear:none;" /> 
										</div>
										<div class="msg" id="msgsms" style="float:left;"></div>
								   
								   </form>
														   
								</div>
							
							</div>
									
						</div>
			
			</div>
		
		</div>
		<?php } ?>
		
		<?php if($dynamic_style == 'YES') { ?>
		<div id="custom_tab1" class="tab_content">
		
		<?php include "scripts/scripts-upload.php"; ?>
		<script type="text/javascript">
		jQuery(document).ready(function()
		{
			
			jQuery("#update-layout").click(function()
			{
				
				jQuery("#msglay").html("<img src='<?php bloginfo('template_url'); ?>/admin/images/ajax-loader.gif'>");
				jQuery("#msglay").show();
				
				var str2 = jQuery("#layout-options").serialize();
				jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/edit-styles.php", data: str2, success: function(data)
				{
					jQuery("#msglay").html("Layout Changes Saved");
					jQuery("#msglay")
						.animate({opacity: 1.0}, 2000)
						.fadeOut('slow');
						
					if(jQuery("input[name='one_column']:checked").val() == "ON" || <?php if($one_column) { echo $one_column; } else { echo 'OFF'; } ?> != 'ON') {
						jQuery("#full_width_wrapper").show();
					} else {
						jQuery("#full_width_wrapper").hide();
					}
				}
				});
			});
			
			jQuery('#fileUpload2').uploadify({
			'uploader'  : '<?php bloginfo('template_url'); ?>/admin/js/uploadify.swf',
			'script'    : '<?php bloginfo('template_url'); ?>/admin/scripts/uploadify.php',
			'scriptData': { 'cookie' : escape(document.cookie + ';<?php echo photocrati_upload_parameter_string(); ?>'), 'session_id' : '<?php echo session_id(); ?>' },
			'cancelImg' : '<?php bloginfo('template_url'); ?>/admin/images/cancel_gallery.gif',
			'auto'      : true,
			'buttonImg'	: '<?php echo photocrati_gallery_file_uri('image/upload.jpg'); ?>',
			'folder'    : '/images/uploads',
			'onComplete': function(event, queueID, fileObj, response, data) {
				jQuery("#filesUploaded2").html('<input type="hidden" id="bg_image" name="bg_image" value="'+fileObj.name+'">');
				jQuery("#fileName2")
						.fadeIn('slow')
						.html(fileObj.name+' uploaded successfully!<BR><em>Remember to save.</em>');
			}
			});
			
			jQuery("#update-background").click(function()
			{
				
				jQuery("#msgmb").html("<img src='<?php bloginfo('template_url'); ?>/admin/images/ajax-loader.gif'>");
				jQuery("#msgmb").show();
				
				var str2 = jQuery("#bg-options").serialize();
				jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/edit-styles.php", data: str2, success: function(data)
				{
					jQuery("#msgmb").html("Background Changes Saved");
					jQuery("#msgmb")
						.animate({opacity: 1.0}, 2000)
						.fadeOut('slow');
					if(jQuery('#bg_image').length == 0){ } else {
					jQuery("#fileName").html(jQuery('#bg_image').val()+'');
					}
				}
				});
			});
			
			jQuery("#update-mp3").click(function()
			{
				
				jQuery("#msgmp3").html("<img src='<?php bloginfo('template_url'); ?>/admin/images/ajax-loader.gif'>");
				jQuery("#msgmp3").show();
				
				var str2 = jQuery("#mp3-options").serialize();
				jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/edit-gallery.php", data: str2, success: function(data)
				{
					jQuery("#msgmp3").html("Music Changes Saved");
					jQuery("#msgmp3")
						.animate({opacity: 1.0}, 2000)
						.fadeOut('slow');
				}
				});
			});
	
			jQuery("#delete-image2").click(function()
			{
				var answer = confirm("Are you sure you want to remove the background image? It will remain in your theme directory under images/uploads.")
				if (answer){
				
				jQuery("#msgmb").html("<img src='<?php bloginfo('template_url'); ?>/admin/images/ajax-loader.gif'>");
				jQuery("#msgmb").show();
				
					jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/delete-background.php", data: "bg_image=", success: function(data)
					{
						jQuery("#msgmb").html("Background image removed");
						jQuery("#msgmb")
							.animate({opacity: 1.0}, 2000)
							.fadeOut('slow');
						jQuery("#fileName2").html('<em>There is currently no image uploaded</em>');
					}
					});
				}
			});
			
		});
		</script>
		
			<div id="container">
				
		
			<div class="options">Layout Style</div>
				
					<div class="sub-options"><span id="comments">Set the theme layout style - full width or one column blog style</span></div>
					<div class="option-content">
					
						<div id="option-container">
						
						<form name="layout-options" id="layout-options" method="post">
						
							<div class="left-sm" style="float:left;width:33%;">
								<p class="titles">Layout Style</p>
								<p>
									<input type="radio" name="one_column" id="one_column" value="OFF" <?php if($one_column == 'OFF' || $one_column == '' || $one_column == NULL) {echo'CHECKED';} ?> /> 100% Width<BR>
									<input type="radio" name="one_column" id="one_column" value="ON" <?php if($one_column == 'ON') {echo'CHECKED';} ?> /> One Column Blog - Centered
								</p>
							</div>
						
							<div class="left-sm" style="float:left;width:66%;">
								<p class="titles">One Column Content Background Color</p>
								<p>#<input type="text" name="one_column_color" id="one_column_color" value="<?php echo $one_column_color; ?>" size="7" style="background:#<?php echo $one_column_color; ?>;" /> Color</p>
							</div>
							
							<div class="submit-button-wrapper">
								<input type="button" class="button" id="update-layout" value="Save Layout Style" style="clear:none;" /> 
							</div>
							<div class="msg" id="msglay" style="float:left;"></div>
						
						</form>
						
						</div>
						
				</div>
        
				<div class="options">Theme Background</div>
				
					<div class="sub-options"><span id="comments">Change the color or image on the main background. <b>Please ensure your image names have no spaces in the filename.</b></span></div>
					<div class="option-content">
					
						<div id="option-container">
						
						<form name="bg-options" id="bg-options" method="post">
						
							<div class="left-sm">
								<p class="titles">Background Color</p>
								<p>#<input type="text" name="bg_color" id="bg_color" value="<?php echo $bg_color; ?>" size="7" style="background:#<?php echo $bg_color; ?>;" /> Color</p>
							</div>
							
							<div class="right-lg">
								<div class="left" style="border:0;">
									<p class="titles" style="margin-bottom:4px;">Background Image</p>
									<?php 
										$load = dirname(dirname(__FILE__)).'/images/uploads/'; 
										if (!is_writable($load)) {
											echo '<p class="warning"><b>The uploads directory images/uploads must be writable</b>!<BR><em>See <a href="http://codex.wordpress.org/Changing_File_Permissions" target="_blank">the Codex</a> for more information.</em></p>';
										} else {
											echo '<input type="file" name="fileUpload2" id="fileUpload2" />';
										}						
									?>
									<div id="filesUploaded2"></div>
								</div>
								<div class="right">
									<p class="titles">Current Background Image</p>
									
										<div id="fileName2">
										<p>
										<?php if($bg_image <> '') { ?>
											<?php echo $bg_image; ?>
											&nbsp;<a id="image_preview" href="<?php bloginfo('template_url'); ?>/images/uploads/<?php echo $bg_image; ?>"><img src="<?php bloginfo('template_url'); ?>/admin/images/view.png" border="0" /></a> 
											&nbsp;<a id="delete-image2"><img class="delete" src="<?php bloginfo('template_url'); ?>/admin/images/delete.png" border="0" /></a>
										<?php } else { ?>
											<div id="fileName"><p><em>There is currently no image uploaded</em></p></div>
										<?php } ?>
										</p>
										</div>
										<p>
										<input type="radio" name="bg_repeat" value="repeat"<?php if($bg_repeat == 'repeat') { echo ' checked'; } ?> /> Tile
										<BR /><input type="radio" name="bg_repeat" value="no-repeat"<?php if($bg_repeat == 'no-repeat') { echo ' checked'; } ?> /> No Repeat
										<BR /><input type="radio" name="bg_repeat" value="repeat-x"<?php if($bg_repeat == 'repeat-x') { echo ' checked'; } ?> /> Repeat Horizontal
										<BR /><input type="radio" name="bg_repeat" value="repeat-y"<?php if($bg_repeat == 'repeat-y') { echo ' checked'; } ?> /> Repeat Vertical
										<BR />Offset <input type="text" name="bg_top_offset" id="bg_top_offset" value="<?php echo $bg_top_offset; ?>" size="2" />px From Top
										</p>
									
								</div>
							</div>
							
							<div class="submit-button-wrapper">
								<input type="button" class="button" id="update-background" value="Save Main Background" style="clear:none;" /> 
							</div>
							<div class="msg" id="msgmb" style="float:left;"></div>
						
						</form>
						
						</div>
						
				</div>
			
			<div class="options">Content Background</div>
			
				<div class="sub-options"><span id="comments">Change the color of the content area background</span></div>
				<div class="option-content">
				
					<div id="option-container">
					
						<div class="left" style="border-right:0;">
						
							<form name="container-options" id="container-options" method="post">
							
								<div class="inner">
									<p class="titles">Background Style</p>
									<p>
									<select id="container_style">
										<option value="transparent"<?php if($container_color == 'transparent') {echo ' SELECTED'; } ?>>Transparent </option>
										<option value="color"<?php if($container_color <> 'transparent') {echo ' SELECTED'; } ?>>Color </option>
									</select>
									</p>
								</div>
								<div class="inner" id="container-color"<?php if($container_color == 'transparent') {echo ' style="display:none;"'; } ?>>
									<p class="titles">Background Color</p>
									<p>#<input type="text" name="container_color" id="container_color" value="<?php if($container_color <> 'transparent') { echo $container_color; } else { echo 'transparent'; } ?>" size="7"  <?php if($container_color <> 'transparent') { ?>style="background:#<?php echo $container_color; ?>;"<?php } ?> /> Color</p>
								</div>
								
								<div class="submit-button-wrapper">
									<input type="button" class="button" id="update-container" value="Save Content Background" style="clear:none;" /> 
								</div>
								<div class="msg" id="msgcb" style="float:left;"></div>
							
						</div>
						
						<div class="right">
							
								<div class="inner" style="width:30%;" id="container-border"<?php if($container_color == 'transparent') {echo ' style="display:none;"'; } ?>>
									<p class="titles">Border</p>
									<p><input type="text" name="container_border" id="container_border" value="<?php echo $container_border; ?>" size="2" />px</p>
								</div>  
								
								<div class="inner" style="width:36%;" id="container-border-color"<?php if($container_color == 'transparent') {echo ' style="display:none;"'; } ?>>
									<p class="titles">Border Color</p>
									<p>#<input type="text" name="container_border_color" id="container_border_color" value="<?php echo $container_border_color; ?>" size="7"  style="background:#<?php echo $container_border_color; ?>;" /> Color</p>
								</div>    
								
								<div class="inner" style="width:33%;" id="container-padding"<?php if($container_color == 'transparent') {echo ' style="display:none;"'; } ?>>
									<p class="titles">Content Padding</p>
									<p><input type="text" name="container_padding" id="container_padding" value="<?php echo $container_padding; ?>" size="2" />px</p>
								</div>     
																				
						</div>
						
						</form>
					
					</div>
							
				</div>
			
			
			<div class="options">Blog Meta</div>
			
				<div class="sub-options"><span id="comments">Hide or show the blog meta paragraph at the bottom of the post</span></div>
				<div class="option-content">
				
					<div id="option-container">
					
						<div class="left" style="border-right:0;width:100%;">
						
							<form name="meta-options" id="meta-options" method="post">
							
								<div class="inner">
									<p class="titles">Meta Paragraph</p>
									<p>
									<select name="blog_meta">
										<option value=""<?php if($blog_meta == '') {echo ' SELECTED'; } ?>>ON </option>
										<option value="OFF"<?php if($blog_meta == 'OFF') {echo ' SELECTED'; } ?>>OFF </option>
									</select>
									</p>
								</div>
								
								<div class="submit-button-wrapper">
									<input type="button" class="button" id="update-meta" value="Update Meta" style="clear:none;" /> 
								</div>
								<div class="msg" id="msgmeta" style="float:left;"></div>
						
							</form>
							
						</div>
					
					</div>
							
				</div>
					
					
					
			<div class="options">Blog & Category Music</div>
			
				<div class="sub-options"><span id="comments">Add an MP3 file for playback on the blog and category pages</span></div>
				<div class="option-content">
				
					<form name="mp3-options" id="mp3-options" method="post">
				
					<div id="option-container">
					
						<div class="left" style="width:99%;">
							
							<div class="inner" style="width:33%;">
								<p class="titles">Blog Music</p>
								<p>
								<input type="radio" name="music_blog" id="music_blog" value="ON" <?php if($music_blog == 'ON') {echo'CHECKED';} ?> /> On &nbsp;&nbsp;
								<input type="radio" name="music_blog" id="music_blog" value="OFF" <?php if($music_blog == 'OFF') {echo'CHECKED';} ?> /> Off
								</p>
							</div>
							
							<div class="inner" style="width:33%;">
								<p class="titles">Auto Play?</p>
								<p>
								<input type="radio" name="music_blog_auto" id="music_blog_auto" value="YES" <?php if($music_blog_auto == 'YES') {echo'CHECKED';} ?> /> Yes &nbsp;&nbsp;
								<input type="radio" name="music_blog_auto" id="music_blog_auto" value="NO" <?php if($music_blog_auto == 'NO') {echo'CHECKED';} ?> /> No
								</p>
							</div>
							
							<div class="inner" style="width:33%;">
								<p class="titles">Show Controls?</p>
								<p>
								<input type="radio" name="music_blog_controls" id="music_blog_controls" value="YES" <?php if($music_blog_controls == 'YES') {echo'CHECKED';} ?> /> Yes &nbsp;&nbsp;
								<input type="radio" name="music_blog_controls" id="music_blog_controls" value="NO" <?php if($music_blog_controls == 'NO') {echo'CHECKED';} ?> /> No
								</p>
							</div>
							
						</div>
					
						<div class="left" style="width:99%;">
							
							<div class="inner" style="width:99%;">
								<p class="titles">Blog File (mp3 format)</p>
								<p>Upload a file, copy the "Link URL", paste it into the field below and save this page/post.</p>
								<?php
								if ($option_disable_upload)
								{
									echo '<p style="color:#ee3311"><b>Note</b>: Because of incompatibilities with WordPress 3.2 and above the following Upload button functionality has been disabled, please upload your MP3 files using the <a href="' . esc_url(admin_url('upload.php')) . '">Media Library</a>, then copy and paste the URL to the file in the field below.</p>';
								}
								?>
								<p>
								<input type="text" name="music_blog_file" id="music_blog_file" value="<?php echo $music_blog_file; ?>" size="70" />
								<input type="button" class="button" id="add_image_music_blog_file" value="Upload mp3" style="clear:none;"<? echo $option_disable_upload ? ' disabled="disabled"' : null; ?> />
								</p>
							</div>
							
						</div>
					
						<div class="left" style="width:99%;">
							
							<div class="inner" style="width:33%;">
								<p class="titles">Category / Archive Music</p>
								<p>
								<input type="radio" name="music_cat" id="music_cat" value="ON" <?php if($music_cat == 'ON') {echo'CHECKED';} ?> /> On &nbsp;&nbsp;
								<input type="radio" name="music_cat" id="music_cat" value="OFF" <?php if($music_cat == 'OFF') {echo'CHECKED';} ?> /> Off
								</p>
							</div>
							
							<div class="inner" style="width:33%;">
								<p class="titles">Auto Play?</p>
								<p>
								<input type="radio" name="music_cat_auto" id="music_cat_auto" value="YES" <?php if($music_cat_auto == 'YES') {echo'CHECKED';} ?> /> Yes &nbsp;&nbsp;
								<input type="radio" name="music_cat_auto" id="music_cat_auto" value="NO" <?php if($music_cat_auto == 'NO') {echo'CHECKED';} ?> /> No
								</p>
							</div>
							
							<div class="inner" style="width:33%;">
								<p class="titles">Show Controls?</p>
								<p>
								<input type="radio" name="music_cat_controls" id="music_cat_controls" value="YES" <?php if($music_cat_controls == 'YES') {echo'CHECKED';} ?> /> Yes &nbsp;&nbsp;
								<input type="radio" name="music_cat_controls" id="music_cat_controls" value="NO" <?php if($music_cat_controls == 'NO') {echo'CHECKED';} ?> /> No
								</p>
							</div>
							
						</div>
					
						<div class="left" style="width:99%;">
							
							<div class="inner" style="width:99%;">
								<p class="titles">Category File (mp3 format)</p>
								<p>Upload a file, copy the "Link URL", paste it into the field below and save this page/post.</p>
								<?php
								if ($option_disable_upload)
								{
									echo '<p style="color:#ee3311"><b>Note</b>: Because of incompatibilities with WordPress 3.2 and above the following Upload button functionality has been disabled, please upload your MP3 files using the <a href="' . esc_url(admin_url('upload.php')) . '">Media Library</a>, then copy and paste the URL to the file in the field below.</p>';
								}
								?>
								<p>
								<input type="text" name="music_cat_file" id="music_cat_file" value="<?php echo $music_cat_file; ?>" size="70" />
								<input type="button" class="button" id="add_image_music_cat_file" value="Upload mp3" style="clear:none;"<? echo $option_disable_upload ? ' disabled="disabled"' : null; ?> />
								</p>
							</div>
							
						</div>
						
						<div class="left" style="width:99%;">
							
							<div class="inner" style="width:99%;">
								<p class="notes">
									<b>Note:</b> <i>You can add music to individual pages or posts in the add / edit post or page
									screens.</i>
								</p>
							</div>
							
						</div>
						
						<div class="submit-button-wrapper">
							<input type="button" class="button" id="update-mp3" value="Save Music Settings" style="clear:none;" /> 
						</div>
						<div class="msg" id="msgmp3" style="float:left;"></div>
						
					</form>
						  
					</div>
						
			</div>
	
				
				</div>
			</div>
		
		</div>
		<?php } ?>
