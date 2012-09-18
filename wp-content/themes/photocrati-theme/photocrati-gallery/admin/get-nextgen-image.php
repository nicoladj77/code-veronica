<?php
define('ABSPATH', dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))).'/');
include_once(ABSPATH.'wp-config.php');
include_once(ABSPATH.'wp-load.php');
include_once(ABSPATH.'wp-includes/wp-db.php');
global $wpdb;

$upload_dir = wp_upload_dir();
?>
<link rel="stylesheet" type="text/css" href="<?php echo get_bloginfo('template_directory'); ?>/admin/admin.css" />
<script type="text/javascript" src="<?php echo get_bloginfo('wpurl'); ?>/wp-includes/js/jquery/jquery.js"></script>
<script type="text/javascript">
jQuery.noConflict();
jQuery(document).ready(function()
{
    
    jQuery('#cancel_nexgen').click(function(){
		jQuery('#import_nexgen_window').html("");
		jQuery('#import_nexgen_window').hide();
    });
	
    jQuery('[id^=expand_images_]').click(function(){
        var currentId = jQuery(this).attr('id');
        jQuery('#nggallery_images_'+currentId.substr(14)).show();
        jQuery('#expand_images_'+currentId.substr(14)).hide();
        jQuery('#hide_images_'+currentId.substr(14)).show();
    });
	
    jQuery('[id^=hide_images_]').click(function(){
        var currentId = jQuery(this).attr('id');
        jQuery('#nggallery_images_'+currentId.substr(12)).hide();
        jQuery('#expand_images_'+currentId.substr(12)).show();
        jQuery('#hide_images_'+currentId.substr(12)).hide();
    });    	
	
    jQuery('[id^=select_all_]').click(function(){
        var currentId = jQuery(this).attr('id');
	if(jQuery(this).is(':checked')) {
        jQuery("input[name='"+currentId.substr(11)+"']").each(function(){
            jQuery(this).attr('checked', true);
            //alert(jQuery(this).val());
        });
	} else {
        jQuery("input[name='"+currentId.substr(11)+"']").each(function(){
            jQuery(this).attr('checked', false);
            //alert(jQuery(this).val());
        });
    }
    });
	
	
});
</script>
        
        <h3>Import Images From NextGen Galleries</h3>
        
        <p class="tips">Expand the galleries by clicking the plus sign and check off the images you want to import into this gallery. When you are done click the Import Images button.</p>
        <p style="font-weight:normal;"><b>Note:</b> You can only import images that are less than 2MB. Images larger than that are disabled.</p>
		
        <?php
        $galnums = 1;
        $nggallery = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."ngg_gallery ORDER BY title ASC");
        foreach ($nggallery as $nggallery) {
        ?>
        
        <p>
			<a name="<?php echo $galnums; ?>"></a>
            <a href="#<?php echo $galnums; ?>" id="expand_images_<?php echo $galnums; ?>"><img src="<?php bloginfo('template_url'); ?>/admin/images/plus.gif" align="absmiddle" border="0"></a> 
            <a href="#<?php echo $galnums; ?>" id="hide_images_<?php echo $galnums; ?>" style="display:none;"><img src="<?php bloginfo('template_url'); ?>/admin/images/minus.gif" align="absmiddle" border="0"></a> 
            <?php echo $nggallery->title; ?>
            <?php
            $count = 0;
            $cntimages = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."ngg_pictures WHERE galleryid = " . ((int)$nggallery->gid) . " ORDER BY filename ASC");
            foreach ($cntimages as $cntimages) { $count = $count + 1; }
            echo ' - <i>'.$count.' images</i>';
            ?>
        </p>
        <div id="nggallery_images_<?php echo $galnums; ?>" class="nggallery_images" style="display:none;">
        
        <div class="nggallery_filenames_wrapper">
		
	    <div style="clear:both;margin:5px 20px;">
		<input type="checkbox" id="select_all_<?php echo $nggallery->gid; ?>" value="<?php echo $ngimages->galleryid; ?>" align="top">
		Select All
	    </div>
	    
            <ul class="nggallery_filenames">
                
                <?php
                $ngimages = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."ngg_pictures WHERE galleryid = ".$nggallery->gid." ORDER BY filename ASC");
                foreach ($ngimages as $ngimages) {
                ?>
                
                <li>
				<?php
				$filedir = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))).'/'.$nggallery->path.'/'.$ngimages->filename;
				$filesize = 2097152;
				?>
                <input type="checkbox" name="<?php echo $ngimages->galleryid; ?>" title="<?php echo $ngimages->alttext; ?>" alt="<?php echo $ngimages->description; ?>" id="nggallery_image_<?php echo $galnums; ?>" value="<?php echo $ngimages->filename; ?>" align="top"<?php if(filesize($filedir) > $filesize) { echo ' DISABLED'; } ?>> 
                <img src="<?php bloginfo('wpurl'); ?>/<?php echo $nggallery->path; ?>/thumbs/thumbs_<?php echo str_replace("%","%25",$ngimages->filename); ?>" style="max-width:60px;max-height:60px;border:1px solid #CCC;<?php if(filesize($filedir) > $filesize) { echo '-moz-opacity:.30; filter:alpha(opacity=30); opacity:.30;'; } ?>" align="top">
                <input type="hidden" id="nggallery_path_<?php echo $galnums; ?>" value="/<?php echo $nggallery->path; ?>/">
				</li>
                
                <?php $galnums = $galnums+1; } ?>
            
            </ul>
        </div>
        
        </div>
        
        <?php } ?>
        
        <div class="nggallery_buttons">
        
        <input type="image" src="<?php echo photocrati_gallery_file_uri('image/gallery_nexgen_import.jpg'); ?>" id="import_nexgen_images" value="Import From NexGen" onclick="return false;" /> 
        <input type="image" src="<?php echo photocrati_gallery_file_uri('image/gallery_nexgen_cancel.jpg'); ?>" id="cancel_nexgen" value="Cancel Import" onclick="return false;" />   
        
        </div>
