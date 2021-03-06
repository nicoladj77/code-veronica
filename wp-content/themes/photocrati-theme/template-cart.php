<?php
/*
Template Name: Shopping Cart Template
*/

ini_set('session.bug_compat_warn', 0);
ini_set('session.bug_compat_42', 0);
?>
<?php get_header(); ?>

<script src="<?php bloginfo('template_directory'); ?>/admin/js/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/admin/css/jquery.fancybox-1.3.4.css" type="text/css" />
	
<?php
	/* IMPORTANT! This code retrieves the shopping cart options */
	global $wpdb;
    $cart_settings = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."photocrati_ecommerce_settings WHERE id = 1", ARRAY_A);
	foreach ($cart_settings as $key => $value) {
		$$key = $value;
	}
	
	if($ecomm_currency == 'JPY' || $ecomm_currency == 'HUF' || $ecomm_currency == 'TWD') {
	$fnum = 0;
	} else {
	$fnum = 2;	
	}

	$upload_dir = wp_upload_dir();
?>	

<script type="text/javascript">
jQuery.noConflict();
jQuery(document).ready(function()
{
	
	var gttl = parseFloat(0.00);
		
	jQuery('[id^=line_]').each(function()
	{
			
		gttl = gttl + parseFloat(jQuery(this).val());
			
	});
		
	jQuery("#cart_sub").val(gttl.toFixed(<?php echo $fnum; ?>));
	
	
	<?php if ($ecomm_ship_method == "total") { ?>
	
		var sendl = jQuery("#country").val();
		var homel = "<?php echo $ecomm_country; ?>";
		
		if(sendl != homel) {
			<?php if($pp_profile == "OFF") { ?>
			jQuery("#cart_shipping").val("<?php echo $ecomm_ship_int; ?>");
			jQuery("#ppshipping").val("<?php echo $ecomm_ship_int; ?>");
			<?php } else { ?>
			jQuery("#cart_shipping").val("0");
			jQuery("#ppshipping").val("0");
			<?php } ?>
			jQuery("#shipping_label").html("International Shipping");
		} else {
			
			var shipm2 = jQuery("#ship_method").val();
			
			if(shipm2 == "expedited") {
				<?php if($pp_profile == "OFF") { ?>
				jQuery("#cart_shipping").val("<?php echo $ecomm_ship_exp; ?>");
				jQuery("#ppshipping").val("<?php echo $ecomm_ship_exp; ?>");
				<?php } else { ?>
				jQuery("#cart_shipping").val("0");
				jQuery("#ppshipping").val("0");
				<?php } ?>
				jQuery("#shipping_label").html("Expedited Shipping");
			} else {
				<?php if($pp_profile == "OFF") { ?>
				jQuery("#cart_shipping").val("<?php echo $ecomm_ship_st; ?>");
				jQuery("#ppshipping").val("<?php echo $ecomm_ship_st; ?>");
				<?php } else { ?>
				jQuery("#cart_shipping").val("0");
				jQuery("#ppshipping").val("0");
				<?php } ?>
				jQuery("#shipping_label").html("Shipping");
			}
			
		}
		
	<?php } else { ?>
	
		var sendl = jQuery("#country").val();
		var homel = "<?php echo $ecomm_country; ?>";
		
		if(sendl != homel) {
			<?php if($pp_profile == "OFF") { ?>
			jQuery("#cart_shipping").val("<?php echo $ecomm_ship_int; ?>");
			jQuery("#ppshipping").val("<?php echo $ecomm_ship_int; ?>");
			<?php } else { ?>
			jQuery("#cart_shipping").val("0");
			jQuery("#ppshipping").val("0");
			<?php } ?>
			jQuery("#shipping_label").html("International Shipping");
		} else {
			var sttl = parseFloat(0.00);
			var samt = <?php echo $ecomm_ship_st; ?>;
				
			jQuery('[id^=qty_]').each(function()
			{
					
				sttl = sttl + parseFloat(jQuery(this).val());
					
			});
			
			var stotal = sttl * samt;
			
			<?php if($pp_profile == "OFF") { ?>
			jQuery("#cart_shipping").val(stotal.toFixed(<?php echo $fnum; ?>));
			jQuery("#ppshipping").val(stotal.toFixed(<?php echo $fnum; ?>));
			<?php } else { ?>
			jQuery("#cart_shipping").val("0");
			jQuery("#ppshipping").val("0");
			<?php } ?>
			jQuery("#shipping_label").html("Shipping");
		}
	
	<?php } ?>
		
		
	var subtotal = parseFloat(jQuery("#cart_sub").val());
	
	<?php if ($ecomm_ship_free) { ?>
	
	var shipfree = <?php echo $ecomm_ship_free; ?>;
	
	if (subtotal > shipfree) {
	
	jQuery("#cart_shipping").val("0.00");
	jQuery("#ppshipping").val("0.00");
	
	}
	
	<?php } ?>
	
	
	<?php if ($ecomm_tax) { ?>
	
		<?php if ($ecomm_tax_method == "before") { ?>
	
			var subb = parseFloat(jQuery("#cart_sub").val());
			var taxb = <?php echo $ecomm_tax; ?>;
			var taxbp = taxb / 100;
			var subbp = subb * taxbp;
	
			jQuery("#cart_tax").val(subbp.toFixed(<?php echo $fnum; ?>));
			jQuery("#pptax").val(subbp.toFixed(<?php echo $fnum; ?>));
			
		<?php } else { ?>
			
			var suba = parseFloat(jQuery("#cart_sub").val());
			var shipa = parseFloat(jQuery("#cart_shipping").val());
			var subshipa = suba + shipa;
			var taxa = <?php echo $ecomm_tax; ?>;
			var taxap = taxa / 100;
			var subap = subshipa * taxap;
	
			jQuery("#cart_tax").val(subap.toFixed(<?php echo $fnum; ?>));
			jQuery("#pptax").val(subap.toFixed(<?php echo $fnum; ?>));
	
		<?php } ?>
	
	<?php } ?>
	
	
	var shippingtotal = parseFloat(jQuery("#cart_shipping").val());
	<?php if ($ecomm_tax) { ?>
	var taxtotal = parseFloat(jQuery("#cart_tax").val());
	var grandtotal = subtotal + taxtotal + shippingtotal;
	<?php } else { ?>
	var grandtotal = subtotal + shippingtotal;
	<?php } ?>
	jQuery("#cart_total").val(grandtotal.toFixed(<?php echo $fnum; ?>));
	
	
	jQuery("#addto").click(function()
	{
		var answer = confirm("Are you sure you want to empty the <?php echo $ecomm_title; ?>?")
		if (answer){
			
			jQuery.ajax({type: "POST", url: "<?php echo photocrati_gallery_file_uri('ecomm-empty-cart.php'); ?>", data: '', success: function(data)
			{
			
				location.reload();
				
			}	
			});

		}
		
		return false;
		
	});	
	
	
	jQuery("#go_back").click(function()
	{
			
		history.back(-1);
		return false;
		
	});	
	
	jQuery('[id^=remove_]').click(function()
	{
		
		var answer = confirm("Are you sure you want to remove this item from the <?php echo $ecomm_title; ?>?")
		if (answer){
			
			var currentId = jQuery(this).attr('id');
			jQuery.ajax({type: "POST", url: "<?php echo photocrati_gallery_file_uri('ecomm-remove-item-cart.php'); ?>", data: 'remove_id='+currentId.substr(7), success: function(data)
			{
			
				location.reload();
				
			}	
			});

		}
		
		return false;
		
	});	
			
	jQuery("a.iframe").fancybox({
		'width'				: 650,
		'height'			: 500,
		'autoScale'     	: false,
		'transitionIn'		: 'elastic',
		'transitionOut'		: 'elastic',
		'overlayColor'		: '#0b0b0f',
		'type'				: 'iframe'
	});
	
	
	jQuery("#checkout").click(function()
	{
		
		jQuery(this).hide();
		jQuery("#cancel_checkout").show();
		
		jQuery('#checkout_fields').slideDown(400, function() {
			// Animation complete.
		});
		
		jQuery('#cart_contents').slideUp(400, function() {
			// Animation complete.
		});
		
		jQuery("#top_buttons").slideUp(400, function() {
			// Animation complete.
		});
		
		jQuery("#bottom_buttons").slideUp(400, function() {
			// Animation complete.
		});
		
		jQuery("#cart_total_wrapper").animate({width: "65%"}, 400);
		
		return false;
		
	});	
	
	
	jQuery("#cancel_checkout").click(function()
	{
		
		jQuery("#top_buttons").slideDown(100, function() {
			// Animation complete.
		});
		
		jQuery("#bottom_buttons").slideDown(100, function() {
			// Animation complete.
		});
		
		jQuery(this).hide();
		jQuery("#checkout").show();
		
		jQuery('#checkout_fields').slideUp(400, function() {
			// Animation complete.
		});
		
		jQuery('#cart_contents').slideDown(400, function() {
			// Animation complete.
		});
		
		jQuery("#cart_total_wrapper").animate({width: "100%"}, 400);
		
		return false;
		
	});
	
	jQuery("#pay_now").click(function()
	{
		jQuery("#paypal_form").submit();
	});
	
	jQuery("#country").change(function()
	{
		
		var sendc = jQuery(this).val();
		var homec = "<?php echo $ecomm_country; ?>";
		
		if(sendc != homec) {
			<?php if($pp_profile == "OFF") { ?>
			jQuery("#cart_shipping").val("<?php echo $ecomm_ship_int; ?>");
			jQuery("#ppshipping").val("<?php echo $ecomm_ship_int; ?>");
			<?php } else { ?>
			jQuery("#cart_shipping").val("0");
			jQuery("#ppshipping").val("0");
			<?php } ?>
			jQuery("#shipping_label").html("International Shipping");
			jQuery("#ship_method").attr("disabled", "disabled");
		} else {
			
			var shipm2 = jQuery("#ship_method").val();
			jQuery("#ship_method").attr("disabled", "");
			
			if(shipm2 == "expedited") {
				<?php if($pp_profile == "OFF") { ?>
				jQuery("#cart_shipping").val("<?php echo $ecomm_ship_exp; ?>");
				jQuery("#ppshipping").val("<?php echo $ecomm_ship_exp; ?>");
				<?php } else { ?>
				jQuery("#cart_shipping").val("0");
				jQuery("#ppshipping").val("0");
				<?php } ?>
				jQuery("#shipping_label").html("Expedited Shipping");
			} else {
				<?php if($pp_profile == "OFF") { ?>
				jQuery("#cart_shipping").val("<?php echo $ecomm_ship_st; ?>");
				jQuery("#ppshipping").val("<?php echo $ecomm_ship_st; ?>");
				<?php } else { ?>
				jQuery("#cart_shipping").val("0");
				jQuery("#ppshipping").val("0");
				<?php } ?>
				jQuery("#shipping_label").html("Shipping");
			}
			
		}
		
		var shippingtotal2 = parseFloat(jQuery("#cart_shipping").val());
		<?php if ($ecomm_tax) { ?>
		var taxtotal2 = parseFloat(jQuery("#cart_tax").val());
		var grandtotal2 = subtotal + taxtotal2 + shippingtotal2;
		<?php } else { ?>
		var grandtotal2 = subtotal + shippingtotal2;
		<?php } ?>
		jQuery("#cart_total").val(grandtotal2.toFixed(<?php echo $fnum; ?>));
		
	});	
	
	jQuery("#ship_method").change(function()
	{
		
		<?php if ($ecomm_ship_method == "total") { ?>
		
			var shipm = jQuery(this).val();
			
			if(shipm == "expedited") {
				<?php if($pp_profile == "OFF") { ?>
				jQuery("#cart_shipping").val("<?php echo $ecomm_ship_exp; ?>");
				jQuery("#ppshipping").val("<?php echo $ecomm_ship_exp; ?>");
				<?php } else { ?>
				jQuery("#cart_shipping").val("0");
				jQuery("#ppshipping").val("0");
				<?php } ?>
				jQuery("#shipping_label").html("Expedited Shipping");
			} else {
				<?php if($pp_profile == "OFF") { ?>
				jQuery("#cart_shipping").val("<?php echo $ecomm_ship_st; ?>");
				jQuery("#ppshipping").val("<?php echo $ecomm_ship_st; ?>");
				<?php } else { ?>
				jQuery("#cart_shipping").val("0");
				jQuery("#ppshipping").val("0");
				<?php } ?>
				jQuery("#shipping_label").html("Shipping");
			}
			
			var shippingtotal2 = parseFloat(jQuery("#cart_shipping").val());
			<?php if ($ecomm_tax) { ?>
			var taxtotal2 = parseFloat(jQuery("#cart_tax").val());
			var grandtotal2 = subtotal + taxtotal2 + shippingtotal2;
			<?php } else { ?>
			var grandtotal2 = subtotal + shippingtotal2;
			<?php } ?>
			jQuery("#cart_total").val(grandtotal2.toFixed(<?php echo $fnum; ?>));
			
		<?php } else { ?>
		
			var shipm = jQuery(this).val();
			
			if(shipm == "expedited") {
				var sttl2 = parseFloat(0.00);
				var samt2 = '<?php echo $ecomm_ship_exp; ?>';
					
				jQuery('[id^=qty_]').each(function()
				{
						
					sttl2 = sttl2 + parseFloat(jQuery(this).val());
						
				});
				
				var stotal2 = sttl2 * samt2;
				
				<?php if($pp_profile == "OFF") { ?>
				jQuery("#cart_shipping").val(stotal2.toFixed(<?php echo $fnum; ?>));
				jQuery("#ppshipping").val(stotal2.toFixed(<?php echo $fnum; ?>));
				<?php } else { ?>
				jQuery("#cart_shipping").val("0");
				jQuery("#ppshipping").val("0");
				<?php } ?>	
				jQuery("#shipping_label").html("Expedited Shipping");
			} else {
				var sttl2 = parseFloat(0.00);
				var samt2 = <?php echo $ecomm_ship_st; ?>;
					
				jQuery('[id^=qty_]').each(function()
				{
						
					sttl2 = sttl2 + parseFloat(jQuery(this).val());
						
				});
				
				var stotal2 = sttl2 * samt2;
				
				<?php if($pp_profile == "OFF") { ?>
				jQuery("#cart_shipping").val(stotal2.toFixed(<?php echo $fnum; ?>));
				jQuery("#ppshipping").val(stotal2.toFixed(<?php echo $fnum; ?>));
				<?php } else { ?>
				jQuery("#cart_shipping").val("0");
				jQuery("#ppshipping").val("0");
				<?php } ?>	
				jQuery("#shipping_label").html("Shipping");
			}
			
			var shippingtotal2 = parseFloat(jQuery("#cart_shipping").val());
			<?php if ($ecomm_tax) { ?>
			var taxtotal2 = parseFloat(jQuery("#cart_tax").val());
			var grandtotal2 = subtotal + taxtotal2 + shippingtotal2;
			<?php } else { ?>
			var grandtotal2 = subtotal + shippingtotal2;
			<?php } ?>
			jQuery("#cart_total").val(grandtotal2.toFixed(<?php echo $fnum; ?>));
		
	
		<?php } ?>
		
	});
	
});
</script>

<SCRIPT LANGUAGE="JavaScript">
	
	function checkform()
	{
		if (document.paypal.first_name.value == '')
		{
			alert('Please fill in all the required fields');
			return false;
		}
		else if (document.paypal.last_name.value == '')
		{
			alert('Please fill in all the required fields');
			return false;
		}
		else if (document.paypal.email.value == '')
		{
			alert('Please fill in all the required fields');
			return false;
		}
	
		return true;
	}
	
</SCRIPT>
	
		<form id="paypal_form" action="https://www.paypal.com/cgi-bin/webscr" method="post" name="paypal" onSubmit="return checkform()">
	
		<div id="container">	
			<div id="content"> 
			
				<?php the_post(); ?>
				
				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                
                	<?php if(!is_front_page()) { ?>
					<h1 class="entry-title"><?php the_title(); ?></h1>
                    <?php } ?>
                    
                        <div class="entry-content">
                            <?php the_content(); ?>
                        </div><!-- .entry-content -->
						
						<div id="shopping_cart_wrapper">
						
						<?php
						
						if(
						   $ecomm_currency == "USD" ||
						   $ecomm_currency == "CAD" ||
						   $ecomm_currency == "AUD" ||
						   $ecomm_currency == "NZD" ||
						   $ecomm_currency == "HKD" ||
						   $ecomm_currency == "SGD"
						) {
							$curr = "$";
						} else if($ecomm_currency == "EUR") {
							$curr = "&euro;";
						} else if($ecomm_currency == "GBP") {
							$curr = "&pound;";
						} else if($ecomm_currency == "JPY") {
							$curr = "&yen;";
						}
						
						$cart = $_SESSION['cart'];
						if (!$cart) {
							echo '<p><em>'.$ecomm_empty.'</em> </p>';
						} else {
						?>
						
						<div class="buttons" id="top_buttons">
							
							<button id="addto" class="positive" style="margin:0 5px;">
								Empty <?php echo $ecomm_title; ?>
							</button>
							
							<button class="addto" id="go_back" class="positive" style="margin:0 5px;">
								Continue Shopping
							</button>
							
						</div>
						
						<div class="cart_contents" id="cart_contents">
							
						<div class="cart_image">
						
							<div class="cart_qty titles" style="width:100%;">&nbsp;<b>Thumbnail</b></div>
							
						</div>
								
						<div class="cart_items">	
							
							<div class="cart_qty titles"><b>Qty</b></div>
								
							<div class="cart_desc titles"><b>Description</b></div>
											
							<div class="cart_amt titles"><b>Price</b></div>
											
							<div class="cart_line titles"><b>Totals&nbsp;</b></div>
									
							<div class="clear"></div>
							
						</div>
						
						<?php
						$pp = 1;
						$crt = explode(",", $_SESSION['cart']);
						$qty = explode(",", $_SESSION['cart_qty']);
						
						foreach ($crt as $cart_id) {
						?>
						
							<div class="item_wrapper">
							
								<?php
								$gal_item = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."photocrati_galleries WHERE id = " . ((int)$cart_id), ARRAY_A);
								foreach ($gal_item as $key => $value) {
									$$key = $value;
								}
								?>
								
								<div class="cart_image">
									
									<?php if (file_exists($upload_dir['basedir'].'/galleries/post-'.$post_id.'/'.$image_name)) { ?>
										<img src="<?php echo $upload_dir['baseurl']; ?>/galleries/post-<?php echo $post_id; ?>/thumbnails/<?php echo str_replace("%","%25",$image_name); ?>">
									<?php } else { ?>
										<img src="<?php echo get_bloginfo('template_url'); ?>/galleries/post-<?php echo $post_id; ?>/thumbnails/<?php echo str_replace("%","%25",$image_name); ?>">
									<?php } ?>
								
								</div>
								
								<div class="cart_items">
								
								<?php
									foreach ($qty as $cart_items) {
										
									$item = explode("|", $cart_items);
									if($item[0] == $cart_id) {
										
									$l = 1;
									while($l < 21) {
									if((string)$l == $item[1]) {
									if($item[2] != '0') {
									?>
									
										<?php if(${"ecomm_op$l"}) { ?>
											
											<div class="cart_qty">
												
												<?php echo $item[2]; ?>
												<input type="hidden" id="qty_<?php echo $l; ?>" name="qty_<?php echo $l; ?>" value="<?php echo $item[2]; ?>">
												
											</div>
													
											<div class="cart_desc">
												
												<?php echo ${"ecomm_op$l"}; ?>
												
											</div>
													
											<div class="cart_amt">
												
												<?php echo $curr.${"ecomm_cost$l"}; ?>
												
											</div>
											
											<?php
											$gal_id = $wpdb->get_results("SELECT gal_title FROM ".$wpdb->prefix."photocrati_gallery_ids WHERE gallery_id = '" . $wpdb->escape($gallery_id) . "'");
											foreach ($gal_id as $galid) {
												$gal_title = $galid->gal_title;
											}
											?>
													
											<div class="cart_line">
												
												<?php echo $curr.$item[3]; ?>
												
												<input type="hidden" id="line_<?php echo $l; ?>" name="line_<?php echo $l; ?>" value="<?php echo $item[3]; ?>">
												
											</div>
											
											<input type="hidden" name="quantity_<?php echo $pp; ?>" value="<?php echo $item[2]; ?>">
											<input type="hidden" name="item_name_<?php echo $pp; ?>" value="<?php echo 'Gallery: '.$gal_title.' | Image: '.$image_name.' | '.${"ecomm_op$l"}; ?>">
											<input type="hidden" name="amount_<?php echo $pp; ?>" value="<?php echo ${"ecomm_cost$l"}; ?>">
											
											<div class="clear"></div>
										
										<?php } ?>
									
									<?php
									$pp = $pp + 1;
									}
									}
									$l = $l + 1;
									}
									}
										
								}
								?>
								
								<div class="clear">
								
									<button class="addto" id="remove_<?php echo $cart_id; ?>" class="positive" style="padding:1px 3px;margin:0 5px;">Remove</button>
									<a class="iframe" href="<?php echo photocrati_gallery_file_uri('ecomm-sizes.php'); ?>?prod_id=<?php echo $cart_id; ?>&actions=edit">
									<button class="addto" class="positive" style="padding:1px 3px;margin:0 5px;">
										Edit
									</button>
									</a>
								
								</div>
								
								</div>
							
							</div>
							
						<?php
						}
						?>
						
						</div>
						
						<div id="cart_total_wrapper" style="width:100%;margin:0 auto;">
						<div class="cart_total_wrapper">
						
							<div class="cart_total">Sub Total</div>
			
							<div class="cart_total_amount"><?php echo $curr."<input id='cart_sub' name='cart_sub' value='0.00' readonly>"; ?></div>
							<div class="clear"></div>
							
							<?php if($ecomm_tax_method == 'after') { ?>
							
							<?php if($pp_profile == "ON") { echo '<div style="display:none;">'; } ?>
							<div class="cart_total" id="shipping_label">Shipping</div>
			
							<div class="cart_total_amount"><?php echo $curr."<input id='cart_shipping' name='cart_shipping' value='0.00' readonly>"; ?></div>
							<div class="clear"></div>
							<?php if($pp_profile == "ON") { echo '</div>'; } ?>
							
							<?php } ?>
							
							
							<?php if($ecomm_tax) { ?>
							
							<div class="cart_total">
							
								<?php
								if($ecomm_tax_name) {
									echo $ecomm_tax_name;
								} else {
									echo 'Tax';
								}
								?>	
							
							</div>
			
							<div class="cart_total_amount"><?php echo $curr."<input id='cart_tax' name='cart_tax' value='0.00' readonly>"; ?></div>
							<div class="clear"></div>
							
							<?php } ?>
							
							
							<?php if($ecomm_tax_method == 'before') { ?>
							
							<?php if($pp_profile == "ON") { echo '<div style="display:none;">'; } ?>
							<div class="cart_total" id="shipping_label">Shipping</div>
			
							<div class="cart_total_amount"><?php echo $curr."<input id='cart_shipping' name='cart_shipping' value='0.00' readonly>"; ?></div>
							<div class="clear"></div>
							<?php if($pp_profile == "ON") { echo '</div>'; } ?>
							
							<?php } ?>
							
							
							<div class="cart_total">TOTAL</div>
			
							<div class="cart_total_amount"><?php echo $curr."<input id='cart_total' name='cart_total' value='0.00' readonly>"; ?></div>
							<div class="clear"></div>
							
						</div>
						</div>
						
						<div class="clear" style="height:10px;"></div>
						<div class="buttons" id="bottom_buttons">
							
							<button class="addto" id="checkout" class="positive" style="margin:0 5px;">
								Checkout Now
							</button>
							
						</div>
						
						
						<div class="checkout_fields" id="checkout_fields">
						
							<div class="checkout_wrapper">
								
								<div class="lable">
									First Name *
								</div>
								<div class="field">
									<input type="text" name="first_name">
								</div>
								
								<div class="lable">
									Last Name *
								</div>
								<div class="field">
									<input type="text" name="last_name">
								</div>
								
								<div class="lable">
									Email Address *
								</div>
								<div class="field">
									<input type="text" name="email">
								</div> 	
                
								<?php
								$country_list = array(
									'US'	=>	'United States',
									'AF'	=>	'Afghanistan',
									'AL'	=>	'Albania',
									'DZ'	=>	'Algeria',
									'AS'	=>	'American Samoa',
									'AD'	=>	'Andorra',
									'AO'	=>	'Angola',
									'AI'	=>	'Anguilla',
									'AQ'	=>	'Antarctica',
									'AG'	=>	'Antigua And Barbuda',
									'AR'	=>	'Argentina',
									'AM'	=>	'Armenia',
									'AW'	=>	'Aruba',
									'AU'	=>	'Australia',
									'AT'	=>	'Austria',
									'AZ'	=>	'Azerbaijan',
									'BS'	=>	'Bahamas',
									'BH'	=>	'Bahrain',
									'BD'	=>	'Bangladesh',
									'BB'	=>	'Barbados',
									'BY'	=>	'Belarus',
									'BE'	=>	'Belgium',
									'BZ'	=>	'Belize',
									'BJ'	=>	'Benin',
									'BM'	=>	'Bermuda',
									'BT'	=>	'Bhutan',
									'BO'	=>	'Bolivia',
									'BA'	=>	'Bosnia And Herzegowina',
									'BW'	=>	'Botswana',
									'BV'	=>	'Bouvet Island',
									'BR'	=>	'Brazil',
									'IO'	=>	'British Indian Ocean Territory',
									'BN'	=>	'Brunei Darussalam',
									'BG'	=>	'Bulgaria',
									'BF'	=>	'Burkina Faso',
									'BI'	=>	'Burundi',
									'KH'	=>	'Cambodia',
									'CM'	=>	'Cameroon',
									'CA'	=>	'Canada',
									'CV'	=>	'Cape Verde',
									'KY'	=>	'Cayman Islands',
									'CF'	=>	'Central African Republic',
									'TD'	=>	'Chad',
									'CL'	=>	'Chile',
									'CN'	=>	'China',
									'CX'	=>	'Christmas Island',
									'CC'	=>	'Cocos (Keeling) Islands',
									'CO'	=>	'Colombia',
									'KM'	=>	'Comoros',
									'CG'	=>	'Congo',
									'CD'	=>	'Congo, The Democratic Republic Of The',
									'CK'	=>	'Cook Islands',
									'CR'	=>	'Costa Rica',
									'CI'	=>	'Cote D\'Ivoire',
									'HR'	=>	'Croatia (Local Name: Hrvatska)',
									'CU'	=>	'Cuba',
									'CY'	=>	'Cyprus',
									'CZ'	=>	'Czech Republic',
									'DK'	=>	'Denmark',
									'DJ'	=>	'Djibouti',
									'DM'	=>	'Dominica',
									'DO'	=>	'Dominican Republic',
									'TP'	=>	'East Timor',
									'EC'	=>	'Ecuador',
									'EG'	=>	'Egypt',
									'SV'	=>	'El Salvador',
									'GQ'	=>	'Equatorial Guinea',
									'ER'	=>	'Eritrea',
									'EE'	=>	'Estonia',
									'ET'	=>	'Ethiopia',
									'FK'	=>	'Falkland Islands (Malvinas)',
									'FO'	=>	'Faroe Islands',
									'FJ'	=>	'Fiji',
									'FI'	=>	'Finland',
									'FR'	=>	'France',
									'FX'	=>	'France, Metropolitan',
									'GF'	=>	'French Guiana',
									'PF'	=>	'French Polynesia',
									'TF'	=>	'French Southern Territories',
									'GA'	=>	'Gabon',
									'GM'	=>	'Gambia',
									'GE'	=>	'Georgia',
									'DE'	=>	'Germany',
									'GH'	=>	'Ghana',
									'GI'	=>	'Gibraltar',
									'GR'	=>	'Greece',
									'GL'	=>	'Greenland',
									'GD'	=>	'Grenada',
									'GP'	=>	'Guadeloupe',
									'GU'	=>	'Guam',
									'GT'	=>	'Guatemala',
									'GN'	=>	'Guinea',
									'GW'	=>	'Guinea-Bissau',
									'GY'	=>	'Guyana',
									'HT'	=>	'Haiti',
									'HM'	=>	'Heard And Mc Donald Islands',
									'HN'	=>	'Honduras',
									'HK'	=>	'Hong Kong',
									'HU'	=>	'Hungary',
									'IS'	=>	'Iceland',
									'IN'	=>	'India',
									'ID'	=>	'Indonesia',
									'IR'	=>	'Iran (Islamic Republic Of)',
									'IQ'	=>	'Iraq',
									'IE'	=>	'Ireland',
									'IL'	=>	'Israel',
									'IT'	=>	'Italy',
									'JM'	=>	'Jamaica',
									'JP'	=>	'Japan',
									'JO'	=>	'Jordan',
									'KZ'	=>	'Kazakhstan',
									'KE'	=>	'Kenya',
									'KI'	=>	'Kiribati',
									'KP'	=>	'Korea, Democratic People\'S Republic Of',
									'KR'	=>	'Korea, Republic Of',
									'KW'	=>	'Kuwait',
									'KG'	=>	'Kyrgyzstan',
									'LA'	=>	'Lao People\'S Democratic Republic',
									'LV'	=>	'Latvia',
									'LB'	=>	'Lebanon',
									'LS'	=>	'Lesotho',
									'LR'	=>	'Liberia',
									'LY'	=>	'Libyan Arab Jamahiriya',
									'LI'	=>	'Liechtenstein',
									'LT'	=>	'Lithuania',
									'LU'	=>	'Luxembourg',
									'MO'	=>	'Macau',
									'MK'	=>	'Macedonia, Former Yugoslav Republic Of',
									'MG'	=>	'Madagascar',
									'MW'	=>	'Malawi',
									'MY'	=>	'Malaysia',
									'MV'	=>	'Maldives',
									'ML'	=>	'Mali',
									'MT'	=>	'Malta',
									'MH'	=>	'Marshall Islands, Republic of the',
									'MQ'	=>	'Martinique',
									'MR'	=>	'Mauritania',
									'MU'	=>	'Mauritius',
									'YT'	=>	'Mayotte',
									'MX'	=>	'Mexico',
									'FM'	=>	'Micronesia, Federated States Of',
									'MD'	=>	'Moldova, Republic Of',
									'MC'	=>	'Monaco',
									'MN'	=>	'Mongolia',
									'MS'	=>	'Montserrat',
									'MA'	=>	'Morocco',
									'MZ'	=>	'Mozambique',
									'MM'	=>	'Myanmar',
									'NA'	=>	'Namibia',
									'NR'	=>	'Nauru',
									'NP'	=>	'Nepal',
									'NL'	=>	'Netherlands',
									'AN'	=>	'Netherlands Antilles',
									'NC'	=>	'New Caledonia',
									'NZ'	=>	'New Zealand',
									'NI'	=>	'Nicaragua',
									'NE'	=>	'Niger',
									'NG'	=>	'Nigeria',
									'NU'	=>	'Niue',
									'NF'	=>	'Norfolk Island',
									'MP'	=>	'Northern Mariana Islands, Commonwealth of the',
									'NO'	=>	'Norway',
									'OM'	=>	'Oman',
									'PK'	=>	'Pakistan',
									'PW'	=>	'Palau, Republic of',
									'PA'	=>	'Panama',
									'PG'	=>	'Papua New Guinea',
									'PY'	=>	'Paraguay',
									'PE'	=>	'Peru',
									'PH'	=>	'Philippines',
									'PN'	=>	'Pitcairn',
									'PL'	=>	'Poland',
									'PT'	=>	'Portugal',
									'PR'	=>	'Puerto Rico',
									'QA'	=>	'Qatar',
									'RE'	=>	'Reunion',
									'RO'	=>	'Romania',
									'RU'	=>	'Russian Federation',
									'RW'	=>	'Rwanda',
									'KN'	=>	'Saint Kitts And Nevis',
									'LC'	=>	'Saint Lucia',
									'VC'	=>	'Saint Vincent And The Grenadines',
									'WS'	=>	'Samoa',
									'SM'	=>	'San Marino',
									'ST'	=>	'Sao Tome And Principe',
									'SA'	=>	'Saudi Arabia',
									'SN'	=>	'Senegal',
									'SC'	=>	'Seychelles',
									'SL'	=>	'Sierra Leone',
									'SG'	=>	'Singapore',
									'SK'	=>	'Slovakia (Slovak Republic)',
									'SI'	=>	'Slovenia',
									'SB'	=>	'Solomon Islands',
									'SO'	=>	'Somalia',
									'ZA'	=>	'South Africa',
									'GS'	=>	'South Georgia, South Sandwich Islands',
									'ES'	=>	'Spain',
									'LK'	=>	'Sri Lanka',
									'SH'	=>	'St. Helena',
									'PM'	=>	'St. Pierre And Miquelon',
									'SD'	=>	'Sudan',
									'SR'	=>	'Suriname',
									'SJ'	=>	'Svalbard And Jan Mayen Islands',
									'SZ'	=>	'Swaziland',
									'SE'	=>	'Sweden',
									'CH'	=>	'Switzerland',
									'SY'	=>	'Syrian Arab Republic',
									'TW'	=>	'Taiwan',
									'TJ'	=>	'Tajikistan',
									'TZ'	=>	'Tanzania, United Republic Of',
									'TH'	=>	'Thailand',
									'TG'	=>	'Togo',
									'TK'	=>	'Tokelau',
									'TO'	=>	'Tonga',
									'TT'	=>	'Trinidad And Tobago',
									'TN'	=>	'Tunisia',
									'TR'	=>	'Turkey',
									'TM'	=>	'Turkmenistan',
									'TC'	=>	'Turks And Caicos Islands',
									'TV'	=>	'Tuvalu',
									'UG'	=>	'Uganda',
									'UA'	=>	'Ukraine',
									'AE'	=>	'United Arab Emirates',
									'GB'	=>	'United Kingdom',
									'UM'	=>	'United States Minor Outlying Islands',
									'UY'	=>	'Uruguay',
									'UZ'	=>	'Uzbekistan',
									'VU'	=>	'Vanuatu',
									'VA'	=>	'Vatican City, State of the',
									'VE'	=>	'Venezuela',
									'VN'	=>	'Viet Nam',
									'VG'	=>	'Virgin Islands (British)',
									'VI'	=>	'Virgin Islands (U.S.)',
									'WF'	=>	'Wallis And Futuna Islands',
									'EH'	=>	'Western Sahara',
									'YE'	=>	'Yemen',
									'YU'	=>	'Yugoslavia',
									'ZM'	=>	'Zambia',
									'ZW'	=>	'Zimbabwe'
								);
								?>
										
								
								<div class="lable">
									Country
								</div>
								<div class="field">
										
									<?php if($ecomm_ship_en == "ON") { ?>
									
									<select name="country" id="country">
										<?php foreach ($country_list as $k => $v) { ?>
											
												<option value="<?php echo $k; ?>"<?php if ($ecomm_country == $k) { echo ' SELECTED'; } ?>><?php echo $v; ?></option>

										<?php } ?>
									</select>
										
									<?php } else { ?>
									
										<?php foreach ($country_list as $k => $v) { ?>
											
											<?php if ($ecomm_country == $k) { ?>
											
												<strong>Note:</strong> We do not ship outside of <?php if($k == 'US' || $k == 'GB') { echo 'the '; } ?><?php echo $v; ?>
												
												<input type="hidden" name="country" id="country" value="<?php echo $k; ?>">
												
											<?php } ?>
												
										<?php } ?>
									
									<?php } ?>
									
								</div>
								
								<?php if($pp_profile == "OFF") { ?>
								<?php if($ecomm_ship_exp <> "") { ?>
								<div class="lable">
									Shipping Method
								</div>
								<div class="field">
									<select id="ship_method">
										
										<option value="standard">Standard</option>
										<option value="expedited">Expedited</option>
											
									</select>
								</div>
								<?php } ?>
								<?php } ?>
								
								<div class="checkout_footer">
								
									<?php echo stripslashes($ecomm_note); ?>
								
								</div>
								
									<input type="hidden" name="cmd" value="_cart">
									<input type="hidden" name="business" value="<?php echo $pp_account; ?>">
									<input type="hidden" name="upload" value="1">
									<input type="hidden" name="no_shipping" value="2">
									<input type="hidden" name="handling_cart" id="ppshipping" value="0.00">
									<input type="hidden" name="tax_cart" id="pptax" value="0.00">
									<input type="hidden" name="currency_code" value="<?php echo $ecomm_currency; ?>">
									<INPUT TYPE="hidden" name="return" value="<?php if($pp_return <> "") { echo $pp_return; if (parse_url($pp_return, PHP_URL_QUERY) != null) { echo '&photocrati_return_link=yes'; } else { echo '?photocrati_return_link=yes'; } } else { echo get_bloginfo('url').'/?photocrati_return_link=yes'; } ?>">
									<input type="hidden" name="rm" value="2">
									<input type="hidden" name="button_subtype" value="products">
									<input type="hidden" name="bn" value="PP-BuyNowBF:btn_paynowCC_LG.gif:NonHostedGuest">
									<input type="hidden" name="notify_url" value="<?php echo get_bloginfo('template_directory').'/ppnotifier.php'; ?>">
									<!--<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_paynowCC_LG.gif" border="0" id="ppsubmit" name="submit" style="border:0;width:144px;" alt="PayPal - The safer, easier way to pay online!">-->
									<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
						
								<div class="buttons">
									
									<button class="addto" id="pay_now" class="positive" style="margin:0 5px;width:75px;text-align:center;">
										Pay Now
									</button>
							
									<button class="addto" id="cancel_checkout" class="positive" style="margin:0 5px;display:none;">
										Cancel
									</button>
									
								</div>
								
								<div class="checkout_image">
								
									<img src="<?php echo photocrati_gallery_file_uri('image/secure-payment-paypal.gif'); ?>">
								
								</div>
						
							</div>
						
						</div>
						
						
						<?php } ?>
						
						</div>
                        
				</div><!-- #post-<?php the_ID(); ?> -->			
			
			</div><!-- #content -->
			
			</form>
		
<?php get_footer(); ?>
