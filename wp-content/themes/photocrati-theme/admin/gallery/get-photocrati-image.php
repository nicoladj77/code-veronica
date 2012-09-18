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
    
    jQuery('#cancel_photocrati').click(function(){
		jQuery('#import_photocrati_window').html("");
        jQuery('#import_photocrati_window').hide();
    });
	
    jQuery('[id^=expand_images2_]').click(function(){
        var currentId = jQuery(this).attr('id');
        jQuery('#photocrati_images_'+currentId.substr(15)).show();
        jQuery('#expand_images2_'+currentId.substr(15)).hide();
        jQuery('#hide_images2_'+currentId.substr(15)).show();
    });
	
    jQuery('[id^=hide_images2_]').click(function(){
        var currentId = jQuery(this).attr('id');
        jQuery('#photocrati_images_'+currentId.substr(13)).hide();
        jQuery('#expand_images2_'+currentId.substr(13)).show();
        jQuery('#hide_images2_'+currentId.substr(13)).hide();
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
        
		<h3>Import Images From Photocrati Galleries</h3>
        
        <p class="tips">Expand the galleries by clicking the plus sign and check off the images you want to import into this gallery. When you are done click the Import Images button.</p>
		
        <?php
        $galnums2 = 1;
        $phgallery = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."photocrati_gallery_ids ORDER BY gal_title ASC");
        foreach ($phgallery as $phgallery) {
		if($phgallery->gal_type != 6 && $phgallery->gal_type != 7) {
        ?>
        
        <p>
			<a name="<?php echo $galnums2; ?>"></a>
            <a href="#<?php echo $galnums2; ?>" id="expand_images2_<?php echo $galnums2; ?>"><img src="<?php bloginfo('template_url'); ?>/admin/images/plus.gif" align="absmiddle" border="0"></a> 
            <a href="#<?php echo $galnums2; ?>" id="hide_images2_<?php echo $galnums2; ?>" style="display:none;"><img src="<?php bloginfo('template_url'); ?>/admin/images/minus.gif" align="absmiddle" border="0"></a> 
            <?php if($phgallery->gal_title <> "") { echo $phgallery->gal_title; } else { echo "No Title"; } ?>
            <?php
            $count2 = 0;
            $cntimages2 = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."photocrati_galleries WHERE gallery_id = '".$phgallery->gallery_id."' ORDER BY image_name ASC");
            foreach ($cntimages2 as $cntimages2) { $count2 = $count2 + 1; }
            echo ' - <i>'.$count2.' images</i>';
            ?>
        </p>
        <div id="photocrati_images_<?php echo $galnums2; ?>" class="nggallery_images" style="display:none;">
        
        <div class="nggallery_filenames_wrapper">
		
	    <div style="clear:both;margin:5px 20px;">
		<input type="checkbox" id="select_all_<?php echo $phgallery->gallery_id; ?>" value="<?php echo $ngimages->galleryid; ?>" align="top">
		Select All
	    </div>
	    
            <ul class="nggallery_filenames">
                
                <?php
                $photocratiimages = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."photocrati_galleries WHERE gallery_id = '".$phgallery->gallery_id."' ORDER BY image_order ASC, image_name ASC");
                foreach ($photocratiimages as $photocratiimages) {
                ?>
                
                <li>
                <input type="checkbox" name="<?php echo $photocratiimages->gallery_id; ?>" title="<?php echo $photocratiimages->image_alt; ?>" alt="<?php echo $photocratiimages->image_desc; ?>" id="photocrati_image_<?php echo $galnums2; ?>" value="<?php echo $photocratiimages->image_name; ?>" align="top"> 
                
					<?php if (file_exists($upload_dir['basedir'].'/galleries/post-'.$photocratiimages->post_id.'/thumbnails/'.str_replace("&amp;","&",$photocratiimages->image_name))) { ?>
						<img src="<?php echo $upload_dir['baseurl']; ?>/galleries/post-<?php echo $photocratiimages->post_id; ?>/thumbnails/<?php echo str_replace("%","%25",$photocratiimages->image_name); ?>" style="max-width:60px;max-height:60px;border:1px solid #CCC;" align="top">
					<?php } else { ?>
						<img src="<?php echo get_bloginfo('template_url'); ?>/galleries/post-<?php echo $photocratiimages->post_id; ?>/thumbnails/<?php echo str_replace("%","%25",$photocratiimages->image_name); ?>" style="max-width:60px;max-height:60px;border:1px solid #CCC;" align="top">
					<?php } ?>
				
                <input type="hidden" id="photocrati_path_<?php echo $galnums2; ?>" value="/galleries/post-<?php echo $photocratiimages->post_id; ?>/">
				</li>
                
                <?php $galnums2 = $galnums2 + 1; } ?>
            
            </ul>
        </div>
        
        </div>
        
        <?php
		}
		}
		?>
        
        <div class="photocrati_buttons">
        
        <input type="image" src="<?php bloginfo('template_url'); ?>/admin/images/gallery_nexgen_import.jpg" id="import_photocrati_images" value="Import From Photocrati" onclick="return false;" /> 
        <input type="image" src="<?php bloginfo('template_url'); ?>/admin/images/gallery_nexgen_cancel.jpg" id="cancel_photocrati" value="Cancel Import" onclick="return false;" />   
        
        </div>
