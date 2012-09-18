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
	
	jQuery("a#single_image").fancybox();
	
	jQuery('[id^=preset-]').click(function()
	{
		var answer = confirm("Are you sure you want to use this preset style? This cannot be undone and will overwrite any customizations you have done thus far. You can save your current customizations before you proceed under Save Custom Themes.")
		if (answer){
			var currentId = jQuery(this).attr('id');
			jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/preset-selector.php", data: "preset_name="+currentId, success: function(data)
			{
				window.location = window.location;
			}
			});
		}
	});	

	jQuery("#update-pages").click(function()
	{
		var answer = confirm("Are you sure you want create the default page set now? This should only be done on a fresh install of Wordpress!")
		if (answer){
			
			jQuery("#msgpages").html("Creating pages - please wait...");
			jQuery("#msgpages").fadeIn('slow');
				
			var str2 = jQuery("#page-options").serialize();
			jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/setup-pages.php", data: str2, success: function(data)
			{
				jQuery("#msgpages").hide();
				jQuery("#msgpages").html("Pages Created Successfully!");
				jQuery("#msgpages")
					.fadeIn('slow')
					.animate({opacity: 1.0}, 2000)
					.fadeOut('slow');
			}
			});
		}
	});

	jQuery("#update-plugins").click(function()
	{
		var str2 = jQuery("#plugin-options").serialize();
		jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/setup-nggallery.php", data: str2, success: function(data)
		{
			jQuery("#msg2").html("NextGen Moved!");
			jQuery("#msg2")
				.fadeIn('slow')
				.animate({opacity: 1.0}, 2000)
				.fadeOut('slow');
			alert("Please activate the plugin now by going to Plugins and clicking the Activate link under NextGEN Gallery");
			window.location = window.location;
		}
		});
	});

	jQuery("#add_custom_name").focus(function()
	{
		jQuery(this).val('');
		jQuery(this).css('color','#333');
	});
	

	jQuery("#add_custom").click(function()
	{
		if(jQuery("#add_custom_name").val() == 'Custom Setting Name...' || jQuery("#add_custom_name").val() == '') {
			alert("Please type in a custom setting name");
		} else {
			
			var str2 = jQuery("#add_custom_settings").serialize();
			
			jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/check-custom-settings.php", data: str2, success: function(data)
			{
			
				if(data.indexOf('EXISTS - YES') == -1) {
			
					jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/add-custom-settings.php", data: str2, success: function(data)
					{
						jQuery("#msg2").html("NextGen Moved!");
						jQuery("#msg2")
							.fadeIn('slow')
							.animate({opacity: 1.0}, 2000)
							.fadeOut('slow');
						window.location = window.location;
					}
					});
				
				} else {
					
					alert('A preset or custom setting with this name already exists. Please choose another.');
					
				}
			
			}
			});
			
		}
		
	});
	
	jQuery('[id^=custom-]').click(function()
	{
		var answer = confirm("Are you sure you want to use this custom style? This cannot be undone and will overwrite any customizations you have done thus far. You can save your current customizations before you proceed under Save Custom Themes.")
		if (answer){
			var currentId = jQuery(this).attr('id');
			jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/preset-selector.php", data: "preset_name="+currentId.substr(7), success: function(data)
			{
				window.location = window.location;
			}
			});
		}
	});	
	
	jQuery('[id^=preset_delete_]').click(function()
	{
		var answer = confirm("Are you sure you want to delete your custom settings? This cannot be undone.")
		if (answer){
			var currentId = jQuery(this).attr('id');
			jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/delete-custom-settings.php", data: "preset_name="+currentId.substr(14), success: function(data)
			{
				window.location = window.location;
			}
			});
		}
	});	
	
	jQuery('[id^=preset_update_]').click(function()
	{
		var answer = confirm("Are you sure you want to update your custom settings? This will overwrite the saved settings with the current customizations.")
		if (answer){
			var currentId = jQuery(this).attr('id');
			jQuery.ajax({type: "POST", url: "<?php bloginfo('template_url'); ?>/admin/scripts/update-custom-settings.php", data: "preset_name="+currentId.substr(14)+"&preset_title="+jQuery('#preset_title_'+currentId.substr(14)).val(), success: function(data)
			{
				window.location = window.location;
			}
			});
		}
	});	
	
});
</script>