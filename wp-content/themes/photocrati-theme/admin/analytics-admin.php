<?php
	include "scripts/scripts-google.php";
	global $wpdb;
	$style = $wpdb->get_results("SELECT google_analytics FROM ".$wpdb->prefix."photocrati_styles WHERE option_set = 1");
	foreach ($style as $style) {
		$google_analytics = $style->google_analytics;
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
    
    	<div class="options">Google Analytics</div>
        
            <div class="sub-options"><span id="comments">Insert Google Analytics code in the footer</span></div>
            <div class="option-content">
            
                <div id="option-container">
                
                <form name="google-options" id="google-options" method="post">
                
                    <div class="left" style="border:0;">
                    
                        <p class="titles">Code (leave blank to exclude)</p>
                        <p>
                        	<textarea name="google_analytics" cols="80" rows="10"><?php echo stripslashes(str_replace('"', '&quot;', $google_analytics)); ?></textarea>
                        </p>
                        
                    </div>
                    
                    <div class="right">
                    
                    </div>
                    
                    <div class="submit-button-wrapper">
                        <input type="button" class="button" id="update-google" value="Update Google Analytics" style="clear:none;" /> 
                    </div>
                    <div id="msg" style="float:left;"></div>
                
                </form>
                
                </div>
                
        </div>
    
    </div>
    
</div>