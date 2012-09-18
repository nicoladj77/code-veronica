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

	jQuery("#update-theme").click(function()
	{
		var answer = confirm("Are you sure you want to update your theme now? This will overwrite some theme files! Any code changes you made to these files will be lost.")
		if (answer){
			jQuery("#loader").show();
			var str2 = jQuery("#theme-update").serialize();
			jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/updates/update-theme.php", data: str2, success: function(data)
			{
				jQuery("#loader").hide();
				jQuery("#msg").html(data);
				jQuery("#msg")
					.fadeIn('slow')
					.animate({opacity: 1.0}, 2000)
					.fadeOut('slow');
				window.location = 'admin.php?page=set-up';
			}
			});
		}
	});
	
});
</script>