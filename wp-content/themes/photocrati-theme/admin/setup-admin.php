<?php
	include "scripts/scripts-setup.php";
	global $wpdb;
	$style = $wpdb->get_results("SELECT dynamic_style FROM ".$wpdb->prefix."photocrati_styles WHERE option_set = 1");
	foreach ($style as $style) {
		$dynamic_style = $style->dynamic_style;
	}
?>

<div id="admin-wrapper">

	<div id="header-left">
    <img src="<?php bloginfo('template_directory'); ?>/admin/images/ph-logo.gif" align="absmiddle" /> &nbsp;<a id="view-theme" class="iframe" href="<?php bloginfo('wpurl'); ?>" style="text-decoration:none;" /><input type="button" class="button" value="View Theme" /></a>
	</div>
    
    <div id="header-right">
    <?php theme_version(); ?>
    </div>
    
    <div id="container">
        
        <?php if($dynamic_style == 'YES') { ?>
        
        <div class="options">Choose Theme</div>
        
            <div class="sub-options"><span id="comments">Pick from preset color & layout schemes at the click of a button. <strong>Click the thumbnail for a larger preview</strong>.</span></div>
            <div class="option-content">
            
                <div id="option-container">
                
                	<div class="left" id="color-choices" style="z-index:0;">
                        
					<?php
					$current = $wpdb->get_results("SELECT preset_name FROM ".$wpdb->prefix."photocrati_styles WHERE option_set = 1 LIMIT 1");
					foreach ($current as $current) { $currentpreset = $current->preset_name; }
					
					$currtitle = $wpdb->get_results("SELECT preset_title FROM ".$wpdb->prefix."photocrati_presets WHERE preset_name = '" . $wpdb->escape($currentpreset) . "'");
					foreach ($currtitle as $currtitle) { $currentpre = $currtitle->preset_title; }
					
					?>
					
					<p style="font-size:15px;"><b>Current Theme:</b> <?php echo $currentpre; ?></p>
					
                    	<p>
						
                        	<?php
							$presets = $wpdb->get_results("SELECT preset_title,preset_name FROM ".$wpdb->prefix."photocrati_presets WHERE custom_setting != 'YES' OR custom_setting IS NULL");
							foreach ($presets as $presets) {
							?>
								
                                <div class="option">
                                <a href="http://www.photocrati.com/presets/<?php echo str_replace("-", "_", $presets->preset_name); ?>.jpg" id="single_image"><img src="http://www.photocrati.com/presets/<?php echo str_replace("-", "_", $presets->preset_name); ?>_sm.jpg" style="width:225px;" /></a>
                                <input type="button" class="button" id="<?php echo $presets->preset_name; ?>" value="Use <?php echo $presets->preset_title; ?>" />
								</div>
                                
                            <?php
							}
							?>
                            
                        </p>
                    </div>
                                        
        		</div>
        </div>
			
		<div class="options">Save Custom Themes</div>
        
            <div class="sub-options"><span id="comments">You can save your current customizations here and re-activate them anytime.</span></div>
            <div class="option-content">
				
				<form name="add_custom_settings" id="add_custom_settings" method="post">
					<div style="width:36%;float:left;margin:8px 0 15px 0;">
						<input type="text" id="add_custom_name" name="preset_name" style="padding:4px;border:1px solid #CCC;color:#999;font-size:12px;" size="40" value="Custom Setting Name..."> 
					</div>
					<div style="width:64%;float:left;margin:10px 0 15px 0;">
						<input type="button" class="button" id="add_custom" value="Save Current Customizations" style="font-weight:bold;" />
					</div>
				</form>
				
                <div id="option-container">
                
                	<div class="left" id="color-choices" style="z-index:0;">
                    
                    	<p>
                        
                        	<?php
							$presets = $wpdb->get_results("SELECT preset_title,preset_name FROM ".$wpdb->prefix."photocrati_presets WHERE custom_setting = 'YES'");
							foreach ($presets as $presets) {
							?>
								
                                <div class="option">
                                <img src="<?php bloginfo('template_directory'); ?>/admin/images/custom-preset-sm.jpg" style="width:225px;" />
                                <input type="button" class="button" id="custom-<?php echo $presets->preset_name; ?>" value="Use <?php echo $presets->preset_title; ?>" />
								<?php if($presets->preset_name == $currentpreset) { ?>
								<img src="<?php bloginfo('template_directory'); ?>/admin/images/check.png" style="border:0;" align="absmiddle" />
								<?php } ?><BR>
								<input type="button" class="button" id="preset_update_<?php echo $presets->preset_name; ?>" value="Update" style="margin-top:-5px;" /> 
								<input type="button" class="button" id="preset_delete_<?php echo $presets->preset_name; ?>" value="Delete" style="margin-top:-5px;" />
                                <input type="hidden" id="preset_title_<?php echo $presets->preset_name; ?>" value="<?php echo $presets->preset_title; ?>" /> 
								</div>
                                
                            <?php
							}
							?>
                            
                        </p>
                    </div>
                                        
        		</div>
        </div>
        
        <?php } ?>
    
    	<div class="options">Create Default Pages</div>
        
            <div class="sub-options"><span id="comments">*WARNING!* This should only be done on a fresh install of Wordpress!</span></div>
            <div class="option-content">
            
                <div id="option-container">
                
                <form name="page-options" id="page-options" method="post">
                
                    <div class="left" style="border:0;width:90%;">
                    
                        <p class="titles">Default Page Set</p>
                        <p>
                        	By clicking the "Create Pages Now" button below a default set of pages will be created for your website:
                            <BR /><BR />
                            <strong>Home</strong> | <strong>Galleries</strong> | <strong>About</strong> | <strong>Blog</strong> | <strong>Contact</strong>
                            <BR /><BR />
                            This will set the "Blog" page for your posts and the "Home" page as the default page.<BR>
							<b><i>* Please only click this button once and wait for the confirmation!</i></b>
                        </p>
                        
                    </div>
                    
                    <div class="right">
                    
                    </div>
                    
                    <div class="submit-button-wrapper">
                        <input type="button" class="button" id="update-pages" value="Create Pages Now" style="clear:none;" /> 
                    </div>
                    <div class="msg" id="msgpages" style="float:left;"></div>
                
                </form>
                
                </div>
                
        </div>
    
    </div>
    
</div>
