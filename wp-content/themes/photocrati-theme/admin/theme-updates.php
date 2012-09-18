<?php
	include "scripts/scripts-update.php";
?>

<div id="admin-wrapper">
    
    <div id="container">
    
    	<div class="options">Photocrati Theme Update</div>
        
            <div class="sub-options"><span id="comments">You can automatically update your theme files if an update is available here.</span></div>
            <div class="option-content">
            
                <div id="option-container">
                
                <div class="left" style="width:100%">
                
                <p>
                
                <form name="theme-update" id="theme-update" method="post">
                                     
                    <?php 
							
						theme_updates();
					
						$load = dirname(dirname(dirname(__FILE__))).'/photocrati-theme/'; 
						$perms = substr(sprintf('%o', fileperms($load)), -4); 
                        if ($perms < '0755') {
                            echo '<p style="color:#FF0000;clear:both;"><b>Warning: The theme directory is not writable</b>! <em>See <a href="http://codex.wordpress.org/Changing_File_Permissions" target="_blank">the Codex</a> for more information.</em><BR>You can attempt the update anyway and we will try to make your theme directory writable for you.</p>';
						} 
					
					?>
                    
                
                </form>
                
                </p>
                
                <p style="border-top:1px solid #CCC;margin:10px 0 5px 0;padding:5px 0 0 0;clear:both;">
                
                <h3>Important Notice</h3>
                
                Please be aware that updating your theme this way <u>overwrites some core theme files</u> with the latest versions. If you have made any 
                customizations to the code in your theme files <strong>please back them up first</strong>. Any style changes you have made with the theme 
                admin <u>will <strong>not</strong> be lost</u>.
                </p>
                <p>
                <em>You can also download the latest files and manually update them yourself here: 
                <a href="http://members.photocrati.com" target="_blank">http://members.photocrati.com</a></em>
                </p>
                
                </div>
                
                </div>
                
        </div>
    
    </div>
    
</div>