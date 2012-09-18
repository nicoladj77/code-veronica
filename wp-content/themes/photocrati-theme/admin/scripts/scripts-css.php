<script type="text/javascript">
jQuery.noConflict();
jQuery(document).ready(function()
{

	jQuery(".options").corner("top");
	
	jQuery("#dynamic_style").change(function()
	{
		if (jQuery("#dynamic_style").val() == 'NO') {
			var answer = confirm("Are you sure you want to disable the dynamic styles and use the static style sheet? You can also enter custom styles the Custom CSS menu option.")
			if (answer){
				var str2 = jQuery("#dynamic-styling").serialize();
				jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/edit-styles.php", data: str2, success: function(data)
				{
					window.location = window.location;
				}
				});
			}
		} else {
			var answer = confirm("Are you sure you want to enable the dynamic styles? This will over ride any changes you made to styles/style.css.")
			if (answer){
				var str2 = jQuery("#dynamic-styling").serialize();
				jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/edit-styles.php", data: str2, success: function(data)
				{
					window.location = window.location;
				}
				});
			}
		}
	});

	jQuery("#update-css").click(function()
	{
		var str2 = jQuery("#css-options").serialize();
		jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/edit-styles.php", data: str2, success: function(data)
		{
			jQuery("#msg2").html("Custom CSS Saved");
			jQuery("#msg2")
				.fadeIn('slow')
				.animate({opacity: 1.0}, 2000)
				.fadeOut('slow');
		}
		});
	});
	
});
</script>