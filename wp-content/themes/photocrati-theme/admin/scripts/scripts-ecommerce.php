<script type="text/javascript">
jQuery.noConflict();
jQuery(document).ready(function()
{

	jQuery(".options").corner("top");

	jQuery("#view-theme").fancybox({
		'speedIn'		:	600, 
		'speedOut'		:	200, 
		'width'			:	1020, 
		'height'		:	450,
		'overlayShow'	:	true
	});
	
	jQuery("#update-global").click(function()
	{
		var str2 = jQuery("#ecommerce-options").serialize();
		jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/edit-ecommerce.php", data: str2, success: function(data)
		{
			jQuery("#msg").html("Settings Saved");
			jQuery("#msg")
				.fadeIn('slow')
				.animate({opacity: 1.0}, 2000)
				.fadeOut('slow');
		}
		});
	});
	
});
</script>