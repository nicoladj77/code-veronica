<?php
global $post;
global $wpdb;
?>

<script type="text/javascript">
jQuery.noConflict();
jQuery(document).ready(function()
{
    jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/gallery/get_galleries.php", data: 'post_id=<?php echo $_GET['post']; ?>', success: function(data)
        {
            jQuery('#display_galleries').html(data)
        }
    });
        
});
</script>

<div id="display_galleries"></div>