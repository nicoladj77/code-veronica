<?php
	include "scripts/scripts-css.php";
	global $wpdb;
	$style = $wpdb->get_results("SELECT custom_css FROM ".$wpdb->prefix."photocrati_styles WHERE option_set = 1");
	foreach ($style as $style) {
		$custom_css = $style->custom_css;
	}
	$style = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."photocrati_styles WHERE option_set = 1");
	foreach ($style as $style) {
		$dynamic_style = $style->dynamic_style;
	}
?>

<div id="admin-wrapper">
    
    <div id="container">
    
		<div class="options">Dynamic Styling</div>
        
            <div class="sub-options"><span id="comments">Disable or enable the dynamic styling. If the dynamic styling is disabled you can use styles/style.css to customize your theme.</span></div>
            <div class="option-content">
            
                <div id="option-container">
                
                	<div class="left" style="border-right:0;width:30%;">
                    
                        <form name="dynamic-stying" id="dynamic-styling" method="post">
                        
                            <div class="inner" style="width:100%;">
                                <p class="titles">Dynamic Styling Enabled?</p>
                                <p>
                                <select name="dynamic_style" id="dynamic_style">
                                    <option value="YES"<?php if($dynamic_style == 'YES') {echo ' SELECTED'; } ?>>YES </option>
                                    <option value="NO"<?php if($dynamic_style == 'NO') {echo ' SELECTED'; } ?>>NO </option>
                                </select>
                                </p>
                            </div>
                            
                            <div id="msg11" style="float:left;"></div>
                        
                        </form>
                        
                    </div>
					
					<div class="left" style="border-right:0;width:60%;">
						<p><i>
							<b>Note:</b>
							When you disable the dynamic styling a static style sheet will be generated
							based on the current theme style. You can edit this file at styles/style.css.
						</i></p>
					</div>
                                        
        		</div>
        </div>
	
		<?php if($dynamic_style == 'YES') { ?>
    	<div class="options">Custom CSS Code</div>
        
            <div class="sub-options"><span id="comments">If you insert code with custom classes you can style it here! You can also over ride theme styles.</span></div>
            <div class="option-content">
            
                <div id="option-container">
                
                <form name="css-options" id="css-options" method="post">
                
                    <div class="left" style="border:0;">
                    
                        <p class="titles">CSS Code (leave blank to exclude)</p>
                        <p>
                        	<textarea name="custom_css" cols="80" rows="10"><?php echo stripslashes(str_replace('"', '&quot;', $custom_css)); ?></textarea>
                        </p>
                        
                    </div>
                    
                    <div class="right">
                    
                    </div>
                    
                    <div class="submit-button-wrapper">
                        <input type="button" class="button" id="update-css" value="Update Custom CSS" style="clear:none;" /> 
                    </div>
                    <div id="msg2" style="float:left;"></div>
                
                </form>
                
                </div>
                
        </div>
		<?php } ?>
    
    </div>
    
</div>