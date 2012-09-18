<?php ob_start();
define('ABSPATH', dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))).'/');
include_once(ABSPATH.'wp-config.php');
include_once(ABSPATH.'wp-load.php');
include_once(ABSPATH.'wp-includes/wp-db.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
<META content="text/html; charset=utf-8" http-equiv=Content-Type>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/styles/dynamic-style.php" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<script>
jQuery.noConflict();
document.oncontextmenu=disableit
function disableit()
{
return false;
}
</script>
</HEAD>
<BODY style="margin:0;padding:0;background:transparent;">
<?php

$browser = $_SERVER['HTTP_USER_AGENT'];
$version = 'MSIE 7';
$pos = strpos($browser, $version);

$upload_dir = wp_upload_dir();

    global $wpdb;
    
    $global = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."photocrati_gallery_settings WHERE id = 1", ARRAY_A);
	foreach ($global as $key => $value) {
		$$key = $value;
	}
    
    $galinfo = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."photocrati_gallery_ids WHERE gallery_id = '" . $wpdb->escape($_GET['gal_id']) . "'");
	foreach ($galinfo as $galinfo) {
        $setheight = $galinfo->gal_height;
	}
	
	$gallery = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."photocrati_galleries WHERE gallery_id = '" . $wpdb->escape($_GET['gal_id']) . "' ORDER BY image_order,image_name ASC");
    $u = 0;
    $json = "[";

    foreach ($gallery as $gallery) {
        if($u > 0) {
        $json .= ",";
        }
		if($image_resolution == '1') {
			
			if (file_exists($upload_dir['basedir'].'/galleries/post-'.$gallery->post_id.'/'.str_replace("&amp;","&",$gallery->image_name))) {
				$json .= "{image:'".$upload_dir['baseurl']."/galleries/post-".$gallery->post_id."/".str_replace("%","%25",str_replace("&amp;","&",$gallery->image_name))."'";
			} else {
				$json .= "{image:'".get_bloginfo('template_url')."/galleries/post-".$gallery->post_id."/".str_replace("%","%25",str_replace("&amp;","&",$gallery->image_name))."'";	
			}
        
		} else {
			
			if (file_exists($upload_dir['basedir'].'/galleries/post-'.$gallery->post_id.'/full/'.str_replace("&amp;","&",$gallery->image_name))) {
				$json .= "{image:'".$upload_dir['baseurl']."/galleries/post-".$gallery->post_id."/full/".str_replace("%","%25",str_replace("&amp;","&",$gallery->image_name))."'";
			} else {
				$json .= "{image:'".get_bloginfo('template_url')."/galleries/post-".$gallery->post_id."/full/".str_replace("%","%25",str_replace("&amp;","&",$gallery->image_name))."'";	
			}
       
		}
		if(function_exists('gd_info') && $_GET['gal_type'] == '4' || function_exists('gd_info') && $_GET['gal_type'] == '3') {
			
			if (file_exists($upload_dir['basedir'].'/galleries/post-'.$gallery->post_id.'/thumbnails/'.str_replace("&amp;","&",$gallery->image_name))) {
				$json .= ",thumb:'".$upload_dir['baseurl']."/galleries/post-".$gallery->post_id."/thumbnails/".str_replace("%","%25",str_replace("&amp;","&",$gallery->image_name))."'";
			} else {
				$json .= ",thumb:'".get_bloginfo('template_url')."/galleries/post-".$gallery->post_id."/thumbnails/".str_replace("%","%25",str_replace("&amp;","&",$gallery->image_name))."'";
			}
        
        }
        if($image_resolution == '1' && function_exists('gd_info') && $_GET['gal_type'] == '2') {
			
			if (file_exists($upload_dir['basedir'].'/galleries/post-'.$gallery->post_id.'/thumbnails/'.str_replace("&amp;","&",$gallery->image_name))) {
				$json .= ",thumb:'".$upload_dir['baseurl']."/galleries/post-".$gallery->post_id."/thumbnails/med-".str_replace("%","%25",str_replace("&amp;","&",$gallery->image_name))."'";
			} else {
				$json .= ",thumb:'".get_bloginfo('template_url')."/galleries/post-".$gallery->post_id."/thumbnails/med-".str_replace("%","%25",str_replace("&amp;","&",$gallery->image_name))."'";
			}
        
        }
        $json .= ",description:'<b>".htmlspecialchars(addslashes($gallery->image_alt))."</b>";
        if($gallery->image_desc){
        $json .= " - ".htmlspecialchars(addslashes(str_replace(array("\r", "\r\n", "\n"), '', $gallery->image_desc)))."";
        }
        $json .= "'}";
        
        $u = $u + 1;
    }
	
    $json .= "]";
    
    $style = $wpdb->get_row("SELECT content_width,container_padding,container_border FROM ".$wpdb->prefix."photocrati_styles WHERE option_set = 1", ARRAY_A);
	foreach ($style as $key => $value) {
		$$key = $value;
	}
    
    if($_GET['gal_page'] == 'true' && $_GET['page_template'] == 'false'){
    $contwidth = $content_width / 100;
    } else {
    $contwidth = $content_width / 100;    
    }
    
    $gallerydesc = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."photocrati_galleries WHERE gallery_id = '" . $wpdb->escape($_GET['gal_id']) . "' ORDER BY image_order,image_name ASC");
    $hiddendesc = "";
	$galheight = 0;
	$fullwidth = floor(((960 - ($container_padding * 2) - ($container_border * 2)) - 0));
	$blogwidth = floor((((960 - ($container_padding * 2) - ($container_border * 2)) - 0) * $contwidth));
    foreach ($gallerydesc as $gallerydesc) {
        $hiddendesc .= "<input type='hidden' id='post-".$gallerydesc->post_id."-";
        if($image_resolution == '0' && $pos === false) {
		$hiddendesc .= "full";
		}
		$hiddendesc .= "-".str_replace("&amp;","&",$gallerydesc->image_name)."'";
		
		if($_GET['gal_type'] == '4' && $_GET['gal_cap'] == 'OFF') {
			
		$hiddendesc .= "value='";
		
		} else {
			
		$hiddendesc .= "value='".str_replace("'", "&#39;", stripslashes($gallerydesc->image_alt))."";
		if($gallerydesc->image_desc){
        $hiddendesc .= " - ".str_replace("'", "&#39;", stripslashes($gallerydesc->image_desc))."";
        }
		
		}
        $hiddendesc .= "'>";
        
    }
    
    $bgcolor = $wpdb->get_results("SELECT container_color,bg_color FROM ".$wpdb->prefix."photocrati_styles WHERE option_set = 1");
	foreach ($bgcolor as $bgcolor) {
        
        $background_color = $bgcolor->container_color;
        $bg_color = $bgcolor->bg_color;
	
	}   
    
    // Single Image Gallery Calcs
    
    if($_GET['gal_page'] == 'true' && $_GET['page_template'] == 'false'){
		
		if($gallery_w1 < (960 - ($container_padding * 2) - ($container_border * 2))) {
			$maxwidth1 = ($gallery_w1);
		} else {
			$maxwidth1 = ceil((960 - ($container_padding * 2) - ($container_border * 2)));
		}
		
		$height_single = round((($maxwidth1) * .664));
		
    } else {
		
		if($gallery_w1 < ((960 - ($container_padding * 2) - ($container_border * 2)) * $contwidth)) {
			$maxwidth1 = ($gallery_w1);
		} else {
			$maxwidth1 = ceil(((945 - ($container_padding * 2) - ($container_border * 2)) * $contwidth));
		}
    
		$height_single = round((($maxwidth1) * .664));
		
    }
    
    // Blog Style Gallery Calcs
    if($_GET['gal_page'] == 'true' && $_GET['page_template'] == 'false'){
        
    if($gallery_w2 < (960 - ($container_padding * 2) - ($container_border * 2))) {
        $maxwidth2 = ($gallery_w2);
    } else {
        $maxwidth2 = ceil((960 - ($container_padding * 2) - ($container_border * 2)));
    }
	
    } else {
        
    if($gallery_w2 < ((960 - ($container_padding * 2) - ($container_border * 2)) * $contwidth)) {
        $maxwidth2 = ($gallery_w2);
    } else {
		if($contwidth == '1') {
        $maxwidth2 = ceil(((960 - ($container_padding * 2) - ($container_border * 2)) * $contwidth));
		} else {
        $maxwidth2 = floor(((960 - ($container_padding * 2) - ($container_border * 2)) * $contwidth - 15));
		}
    }
	
    }
    
    // Horizontal Filmstrip Gallery Calcs
	$thumbsblock3 = $thumbnail_h3 + 36;
    $thumbsblockh3 = $thumbnail_h3 + 11;
    $thumbsblocklr3 = $thumbnail_h3 + 10;
	
	if($_GET['gal_page'] == 'true' && $_GET['page_template'] == 'false'){
		
		if($gallery_w3 < (960 - ($container_padding * 2) - ($container_border * 2))) {
			$maxwidth3 = ($gallery_w3);
		} else {
			$maxwidth3 = ceil((960 - ($container_padding * 2) - ($container_border * 2)));
		}
	
	} else {
		
		if($gallery_w3 < ((960 - ($container_padding * 2) - ($container_border * 2)) * $contwidth)) {
			$maxwidth3 = ($gallery_w3);
		} else {
			$maxwidth3 = ceil(((945 - ($container_padding * 2) - ($container_border * 2)) * $contwidth));
		}
		
	}
    
    
    if($_GET['gal_page'] == 'true' && $_GET['page_template'] == 'false'){
	$height3 = round(($maxwidth3 * .664) + $thumbsblock3 + ($hfgallery_b*2));
    } else {
    $height3 = round((($maxwidth3 * $contwidth) * .664) + $thumbsblock3 + ($hfgallery_b*2));  
    }
    $width3 = round(((960 - ((int)$container_padding * 2) - ((int)$container_border * 2)) * .664) + $thumbsblock3);
    

	$insertgallery .= '<script src="'.get_bloginfo('template_url').'/admin/js/galleria.js"></script>';
    $insertgallery .= '<style>.galleria-container{background:transparent;}</style>';	
    
    $insertgallery .= '
	<link rel="stylesheet" type="text/css" href="'.get_bloginfo('template_directory').'/admin/css/jquery.lightbox-0.5.css" />
	<script type="text/javascript" src="'.get_bloginfo('template_directory').'/admin/js/jquery.lightbox-0.5.js"></script>
    ';

    
	if($_GET['gal_type'] == '1') {
        
    $insertgallery .= '<script>Galleria.loadTheme(\''.get_bloginfo('template_url').'/admin/js/themes/classic/galleria.classic.js\');';
	if($_GET['gal_page'] != 'true'){
		if($setheight == '') {
		$insertgallery .= 'parent.jQuery("iFrame#g'.$_GET['gal_id'].'").css("height","'.(($height_single * $contwidth) + 0).'px");';
		} else {
		$insertgallery .= 'parent.jQuery("iFrame#g'.$_GET['gal_id'].'").css("height","'.(($setheight * $contwidth) + 0).'px");';	
		}
	} else {
		if($setheight == '') {
		$insertgallery .= 'parent.jQuery("iFrame#g'.$_GET['gal_id'].'").css("height","'.($height_single + 0).'px");';
		} else {
		$insertgallery .= 'parent.jQuery("iFrame#g'.$_GET['gal_id'].'").css("height","'.($setheight + 0).'px");';	
		}
	}

$insertgallery .= 'parent.jQuery("iFrame#g'.$_GET['gal_id'].'").css("width","'.$maxwidth1.'px");
jQuery(document).ready(function() {
var gallerydata = '.stripslashes(htmlspecialchars_decode($json)).';
jQuery(\'#gallery-'.$_GET['gal_id'].'\').galleria({
transition: \''.$sgallery_t.'\',
transition_speed: '.$sgallery_ts.',
image_crop: false,
data_type: \'json\',
data_source: gallerydata,
max_scale_ratio: 1,
carousel: false,
thumbnails: false,
extend: function() {';

if($gallery_buttons1 == 'ON') {

if($setheight == '') {
	if($_GET['gal_page'] == 'true'){
	$buttonheight = $height_single;
	} else {
	$buttonheight = ceil($height_single * $contwidth);
	}
} else {
	if($_GET['gal_page'] == 'true'){
	$buttonheight = $setheight;
	} else {
	$buttonheight = ceil(($setheight * $contwidth) * 1.15);
	}
}
	
$insertgallery .= 'var gallery = this;
jQuery(".galleria-container").append(\'<div class="play_wrapper" style="display:none;z-index:99;position:absolute;top:'.(($buttonheight / 2) - 35).'px;left:'.(($maxwidth1 / 2) - 30).'px;moz-opacity:.0;opacity:.0;filter:alpha(opacity=0);"><a id="play_button" style="cursor:pointer;"><img src="'.get_bloginfo('template_directory').'/images/play_button.png"></a></div>\');
jQuery(".galleria-container").append(\'<div class="pause_wrapper" style="z-index:99;position:absolute;top:'.(($buttonheight / 2) - 35).'px;left:'.(($maxwidth1 / 2) - 30).'px;moz-opacity:.0;opacity:.0;filter:alpha(opacity=0);"><a id="pause_button" style="cursor:pointer;"><img src="'.get_bloginfo('template_directory').'/images/pause_button.png"></a></div>\');

jQuery(".galleria-container").hover(
	function () {
		jQuery(".play_wrapper").css("moz-opacity",".75").css("opacity",".75").css("filter","alpha(opacity=75)");
		jQuery(".pause_wrapper").css("moz-opacity",".75").css("opacity",".75").css("filter","alpha(opacity=75)");
	},
	function () {
		jQuery(".play_wrapper").css("moz-opacity",".0").css("opacity",".0").css("filter","alpha(opacity=0)");
		jQuery(".pause_wrapper").css("moz-opacity",".0").css("opacity",".0").css("filter","alpha(opacity=0)");
	}
);
jQuery(".play_wrapper").click(function() {
	gallery.play();
	jQuery(".play_wrapper").hide();
	jQuery(".pause_wrapper").show();
});
jQuery(".pause_wrapper").click(function() {
	gallery.pause();
	jQuery(".play_wrapper").show();
	jQuery(".pause_wrapper").hide();
});';

}
 
$insertgallery .= '// Added to notify parent
this.bind("loadfinish", function() {
	
	// Set iframe height
	parent.iframe_'.$_GET['gal_id'].'_loaded();
	
});

this.play('.$sgallery_s.'000); // advances after 6 seconds

function md(e) 
{ 
	try { if (event.button==2||event.button==3) return false; }  
	catch (e) { if (e.which == 3) return false; } 
}
jQuery(".galleria-stage")[0].oncontextmenu = function() {return false;}
jQuery(".galleria-stage")[0].ondragstart   = function() {return false;}
jQuery(".galleria-stage")[0].onmousedown   = md;
parent.jQuery("iFrame#g'.$_GET['gal_id'].'").oncontextmenu = function() {return false;}

}
});
}); </script>';
    $insertgallery .= '<style>';
    if($_GET['gal_cap'] == 'OFF') {
    $insertgallery .= '
.galleria-info-text{display:none;}';
    }

if($_GET['gal_page'] != 'true'){
    
$insertgallery .= '.galleria-container{';
#	if($_GET['gal_cap'] == 'ON') { 
#		if($setheight == '') { 
#		$insertgallery .= 'height:'.ceil((((960 - ($container_padding * 2) - ($container_border * 2)) * $contwidth) * .664) + 51).'px;';
#		} else {
#		$insertgallery .= 'height:'.ceil((($setheight * $contwidth) + 51) * 1.15).'px;';		
#		} 
#	} 
#	else 
	{
		if($setheight == '') {
		$insertgallery .= 'height:'.ceil((((960 - ($container_padding * 2) - ($container_border * 2)) * $contwidth) * .664) + ($hfgallery_b*2)).'px;';
		} else {
		$insertgallery .= 'height:'.ceil(($setheight * $contwidth) * 1.15).'px;';
		} 
	} 
$insertgallery .= '}
.galleria-stage{
position: relative;';
	if($setheight == '') {
    $insertgallery .= 'height:'.ceil((((960 - ($container_padding * 2) - ($container_border * 2)) * $contwidth) * .664) + ($sgallery_b*2) + 0).'px;';
	} else {
	$insertgallery .= 'height:'.ceil(($setheight * $contwidth) + ($sgallery_b*2) * 1.20).'px;';	
	}
if($maxwidth1 >= ceil(((945 - ($container_padding * 2) - ($container_border * 2)) * $contwidth))) {
$insertgallery .= 'width:'.ceil(((945 - ($container_padding * 2) - ($container_border * 2)) * $contwidth)).'px;';
} else if($maxwidth1 < ceil(((945 - ($container_padding * 2) - ($container_border * 2)) * $contwidth))) {
$insertgallery .= 'width:'.ceil($maxwidth1).'px;';
}
$insertgallery .= 'top: -'.($sgallery_b).'px;';
$insertgallery .= '
}
.galleria-stage img {';
if($maxwidth1 >= ceil(((945 - ($container_padding * 2) - ($container_border * 2)) * $contwidth))) {
$insertgallery .= 'max-width:'.ceil(((945 - ($container_padding * 2) - ($container_border * 2)) * $contwidth) - ($sgallery_b*2) - 1).'px;
max-height:'.ceil((((960 - ($container_padding * 2) - ($container_border * 2)) * .664) * $contwidth) - ($sgallery_b*2)).'px;';
} else if($maxwidth1 < ceil(((945 - ($container_padding * 2) - ($container_border * 2)) * $contwidth))) {
$insertgallery .= 'max-width:'.ceil($maxwidth1 - ($sgallery_b*2)).'px;
max-height:'.ceil($maxwidth1 * .664).'px;';
}
$insertgallery .= '
width: auto;
border: '.$sgallery_b.'px solid #'.$sgallery_b_color.' !important; 
margin-left: -'.($sgallery_b).'px;
}';

#if($_GET['gal_cap'] == 'ON') {
#    $insertgallery .= '.galleria-info {bottom:17px}';
#} 
#else 
{
	$insertgallery .= '.galleria-info {bottom:0px}';
	$insertgallery .= '.galleria-info {bottom:'.floor(($sgallery_b*4) + 10).'px}';	
}

} else {

$insertgallery .= '.galleria-container{';
#	if($_GET['gal_cap'] == 'ON') {
#		if($setheight == '') {
#		$insertgallery .= 'height:'.($height_single+50).'px;';
#		} else {
#		$insertgallery .= 'height:'.ceil($setheight + 50).'px;';	
#		} 
#	} 
#	else 
	{
		if($setheight == '') {
		//$insertgallery .= 'height:'.($height_single+10).'px;';
		$insertgallery .= 'height:' . ($height_single+($sgallery_b*4)+10) . 'px;';
		} else {
		$insertgallery .= 'height:'.ceil($setheight + 0).'px;';	
		} 
	} 
$insertgallery .= '}
.galleria-stage{
position: relative;
width: '.$maxwidth1.';';
	if($setheight == '') {
    $insertgallery .= 'height:'.ceil(($maxwidth1 * .664) + ($sgallery_b*2) + 0).'px;';
	} else {
	$insertgallery .= 'height:'.ceil($setheight + ($sgallery_b*4) + 0).'px;';	
	} 
$insertgallery .= '
top: -'.(($sgallery_b*2) + 0).'px;
}
.galleria-stage img {
max-height:'.floor(($maxwidth1 * .664) - ($sgallery_b*2) - 2).'px;
max-width:'.floor(($maxwidth1) - ($sgallery_b*2) - 1).'px;
width: auto;
border: '.$sgallery_b.'px solid #'.$sgallery_b_color.' !important;
margin-left: -'.($sgallery_b).'px;
}
';	
	
}

$insertgallery .= '.galleria-thumbnails-container {height:0px;}';
#  if($_GET['gal_cap'] == 'ON') {
#    $insertgallery .= '.galleria-info {bottom:0px;}';
#	} 
#	else 
	{
	//$insertgallery .= '.galleria-info {bottom:0px}';	
	$insertgallery .= '.galleria-info {bottom:'.floor(($sgallery_b*4) + 10).'px}';	
	}
$insertgallery .= '</style>';

	$insertgallery .= '<div id="content"><div class="gallery" id="gallery-'.$_GET['gal_id'].'"></div></div>';

	} else if($_GET['gal_type'] == '2') {
        
    $insertgallery .= '<script>Galleria.loadTheme(\''.get_bloginfo('template_url').'/admin/js/themes/lightbox/galleria.lightbox.js\');
parent.jQuery("iFrame#g'.$_GET['gal_id'].'").css("min-height","100px");
parent.jQuery("iFrame#g'.$_GET['gal_id'].'").css("width","'.$maxwidth2.'px");
jQuery(document).ready(function() {
var gallerydata = '.stripslashes(htmlspecialchars_decode($json)).';
jQuery(\'#gallery-'.$_GET['gal_id'].'\').galleria({
data_type: \'json\',
data_source: gallerydata,
keep_source: false,
max_scale_ratio: 1,
thumb_crop: false,
thumb_fit: true,
data_config: function(img) {
return {
description: jQuery(img).next(\'.caption\').html()
}
},
extend: function() {
 
// Added to notify parent
this.bind("thumbnail", function() {
	
	// Set iframe height
	parent.iframe_'.$_GET['gal_id'].'_loaded();
	
});

jQuery(".galleria-image img").each(function(index) {
function md(e) 
{ 
	try { if (event.button==2||event.button==3) return false; }  
	catch (e) { if (e.which == 3) return false; } 
}
jQuery(this)[0].oncontextmenu = function() {return false;}
jQuery(this)[0].ondragstart   = function() {return false;}
jQuery(this)[0].onmousedown   = md;

jQuery(".galleria-image img").click(function(){

return false;

});

});

parent.jQuery("iFrame#g'.$_GET['gal_id'].'").oncontextmenu = function() {return false;}
}
});
});</script>';

    $insertgallery .= '<style>';
    if($_GET['gal_cap'] == 'OFF') {
    $insertgallery .= '
.galleria-info-text{display:none;}';
    } 
    $insertgallery .= '
.galleria-thumbnails {
width: '.($maxwidth2).'px;
}
.galleria-thumbnails .galleria-image {
height: '.($maxwidth2).'px;
width: '.($maxwidth2).'px;
_height: '.($maxwidth2).'px;
_width: '.($maxwidth2).'px;
margin-bottom: '.($gallery_pad2).'px!important;';
$insertgallery .= 'clear: both!important;
border: '.$bgallery_b.'px solid #'.$bgallery_b_color.' !important;
}
.galleria-thumbnails .galleria-image img {
cursor: default;
max-height: '.(($maxwidth2) - ($bgallery_b*2)).'px!important;
max-width: '.(($maxwidth2) - ($bgallery_b*2)).'px!important;
}
</style>';

	$insertgallery .= '<div id="content"><div class="gallery" id="gallery-'.$_GET['gal_id'].'"></div></div>';

	} else if($_GET['gal_type'] == '3') {
        
    $insertgallery .= '<script>Galleria.loadTheme(\''.get_bloginfo('template_url').'/admin/js/themes/classic/galleria.classic.js\');';
	if($_GET['gal_page'] != 'true'){
		if($setheight == '') {
	$insertgallery .= 'parent.jQuery("iFrame#g'.$_GET['gal_id'].'").css("height","'.(($height3 * $contwidth) +33).'px");';
		} else {
		$insertgallery .= 'parent.jQuery("iFrame#g'.$_GET['gal_id'].'").css("height","'.((($setheight + $thumbsblock3) * $contwidth) + 0).'px");';	
		}
	} else {
		if($setheight == '') {
	$insertgallery .= 'parent.jQuery("iFrame#g'.$_GET['gal_id'].'").css("height","'.($height3+33).'px");';
		} else {
		$insertgallery .= 'parent.jQuery("iFrame#g'.$_GET['gal_id'].'").css("height","'.(($setheight + $thumbsblock3) + 33).'px");';	
		}
	}

$insertgallery .= 'parent.jQuery("iFrame#g'.$_GET['gal_id'].'").css("width","'.$maxwidth3.'px");
jQuery(document).ready(function() { 
var gallerydata = '.stripslashes(htmlspecialchars_decode($json)).';
jQuery(\'#gallery-'.$_GET['gal_id'].'\').galleria({
transition: \''.$hfgallery_t.'\',
transition_speed: '.$hfgallery_ts.',
image_crop: false,';
if($film_crop == 'ON') {
$insertgallery .= 'thumb_crop: true,';
} else {
$insertgallery .= 'thumb_crop: \'height\',';
}
$insertgallery .= 'data_type: \'json\',
data_source: gallerydata,
carousel: true,
max_scale_ratio: 1,
extend: function() {';

if($gallery_buttons3 == 'ON') {	

if($setheight == '') {
	if($_GET['gal_page'] == 'true'){
	$playtop = ((($height3 / 2) - 20) - ($thumbsblock3 / 2));
	} else {
	$playtop = ((($height3 / 2) - 50));
	}
} else {
	if($_GET['gal_page'] == 'true'){
	$playtop = ((($setheight / 2) - 20));
	} else {
	$playtop = ((($setheight / 2) - 50));
	}
}
	
$insertgallery .= 'var gallery = this;
jQuery(".galleria-stage").append(\'<div class="play_wrapper" style="display:none;z-index:99;position:absolute;top:'.$playtop.'px;left:'.(($maxwidth3 / 2) - 30).'px;moz-opacity:.0;opacity:.0;filter:alpha(opacity=0);"><a id="play_button" style="cursor:pointer;"><img src="'.get_bloginfo('template_directory').'/images/play_button.png" style="border:0;"></a></div>\');
jQuery(".galleria-stage").append(\'<div class="pause_wrapper" style="z-index:99;position:absolute;top:'.$playtop.'px;left:'.(($maxwidth3 / 2) - 30).'px;moz-opacity:.0;opacity:.0;filter:alpha(opacity=0);"><a id="pause_button" style="cursor:pointer;"><img src="'.get_bloginfo('template_directory').'/images/pause_button.png" style="border:0;"></a></div>\');
jQuery(".galleria-stage").hover(
	function () {
		jQuery(".play_wrapper").css("moz-opacity",".75").css("opacity",".75").css("filter","alpha(opacity=75)");
		jQuery(".pause_wrapper").css("moz-opacity",".75").css("opacity",".75").css("filter","alpha(opacity=75)");
	},
	function () {
		jQuery(".play_wrapper").css("moz-opacity",".0").css("opacity",".0").css("filter","alpha(opacity=0)");
		jQuery(".pause_wrapper").css("moz-opacity",".0").css("opacity",".0").css("filter","alpha(opacity=0)");
	}
);
jQuery(".play_wrapper").click(function() {
	gallery.play();
	jQuery(".play_wrapper").hide();
	jQuery(".pause_wrapper").show();
});
jQuery(".pause_wrapper").click(function() {
	gallery.pause();
	jQuery(".play_wrapper").show();
	jQuery(".pause_wrapper").hide();
});';

}
 
$insertgallery .= '
 
// Added to notify parent
this.bind("loadfinish", function() {
	
	// Set iframe height
	parent.iframe_'.$_GET['gal_id'].'_loaded();
	
});

this.play('.$hfgallery_s.'000); // advances after 6 seconds

jQuery(".galleria-image img").each(function(index) {

var imgname = jQuery(this).attr("src").split("/");
jQuery(this).attr("title",jQuery("[id$=\'-"+imgname[imgname.length-1]+"\']").val());

function md(e) 
{ 
	try { if (event.button==2||event.button==3) return false; }  
	catch (e) { if (e.which == 3) return false; } 
}
jQuery(this)[0].oncontextmenu = function() {return false;}
jQuery(this)[0].ondragstart   = function() {return false;}
jQuery(this)[0].onmousedown   = md;
jQuery(".galleria-stage")[0].oncontextmenu = function() {return false;}
jQuery(".galleria-stage")[0].ondragstart   = function() {return false;}
jQuery(".galleria-stage")[0].onmousedown   = md;
});

parent.jQuery("iFrame#g'.$_GET['gal_id'].'").oncontextmenu = function() {return false;}
}
});
}); </script>';
    $insertgallery .= '<style>';
    if($_GET['gal_cap'] == 'OFF') {
    $insertgallery .= '
.galleria-info-text{display:none;}';
    }
    
if($_GET['gal_page'] != 'true' || $_GET['page_template'] == 'true'){
    
$insertgallery .= '
.galleria-stage {
position: relative;';
#	if($_GET['gal_cap'] == 'ON') {
#		if($setheight == '') {
#		$insertgallery .= 'height:'.ceil((((960 - ($container_padding * 2) - ($container_border * 2)) * $contwidth) * .664) + ($hfgallery_b*2)).'px;';
#		} else {
#		$insertgallery .= 'height:'.ceil((($setheight * $contwidth) + 51) * 1.15).'px;';		
#		} 
#	} 
#	else
	{
		if($setheight == '') {
		$insertgallery .= 'height:'.ceil((((960 - ($container_padding * 2) - ($container_border * 2)) * $contwidth) * .664) + ($hfgallery_b*2)).'px;';
		} else {
		$insertgallery .= 'height:'.ceil(($setheight * $contwidth) * 1.15).'px;';
		} 
	}
if($maxwidth3 >= ceil(((945 - ($container_padding * 2) - ($container_border * 2)) * $contwidth))) {
$insertgallery .= 'width:'.ceil(((945 - ($container_padding * 2) - ($container_border * 2)) * $contwidth)).'px;';
} else if($maxwidth3 < ceil(((945 - ($container_padding * 2) - ($container_border * 2)) * $contwidth))) {
$insertgallery .= 'width:'.ceil($maxwidth3).'px;';
}
$insertgallery .= 'top: -'.($hfgallery_b).'px;
}
.galleria-stage img {';
if($maxwidth3 >= ceil(((945 - ($container_padding * 2) - ($container_border * 2)) * $contwidth))) {
$insertgallery .= 'max-width:'.ceil(((945 - ($container_padding * 2) - ($container_border * 2)) * $contwidth) - ($hfgallery_b*2) - 1).'px;
max-height:'.ceil((((960 - ($container_padding * 2) - ($container_border * 2)) * .664) * $contwidth) - ($hfgallery_b*2)).'px;';
} else if($maxwidth3 < ceil(((945 - ($container_padding * 2) - ($container_border * 2)) * $contwidth))) {
$insertgallery .= 'max-width:'.ceil($maxwidth3 - ($hfgallery_b*2)).'px;
max-height:'.ceil($maxwidth3 * .664).'px;';
}
$insertgallery .= 'width: auto;
border: '.$hfgallery_b.'px solid #'.$hfgallery_b_color.' !important;
margin-left: -'.($hfgallery_b).'px;
}
.galleria-container{';
#	if($_GET['gal_cap'] == 'ON') {
#		if($setheight == '') {
#		$insertgallery .= 'height:'.ceil((((960 - ($container_padding * 2) - ($container_border * 2)) * $contwidth) * .664)+$thumbsblock3 + 30 + ($hfgallery_b*2)).'px;';
#		} else {
#		$insertgallery .= 'height:'.ceil(((($setheight + $thumbsblock3) * $contwidth) + 51) * 1.23).'px;';		
#		} 
#	}
#	else
	{
		if($setheight == '') {
		$insertgallery .= 'height:'.ceil((((960 - ($container_padding * 2) - ($container_border * 2)) * $contwidth) * .664)+$thumbsblock3).'px;';
		} else {
		$insertgallery .= 'height:'.ceil((($setheight + $thumbsblock3) * $contwidth) * 1.23).'px;';
		} 
	} 
$insertgallery .= 'max-width:'.ceil(((945 - ($container_padding * 2) - ($container_border * 2)) * $contwidth)).'px;
}
.galleria-stage{ bottom:'.($thumbsblock3 + ($hfgallery_b*2)).'px;}
.galleria-thumbnails-container {height:'.($thumbsblockh3 + ($hfgallery_b*2)).'px; overflow:visible;}
.galleria-info {bottom:'.($thumbsblock3 + ($hfgallery_b*2)).'px;}
.galleria-thumbnails {
padding-top: '.(10 + ($hfgallery_b * 2)).'px;
text-align: left;
margin: 0 auto;
}
.galleria-thumbnails .galleria-image {
height: '.$thumbnail_h3.'px;
width: '.$thumbnail_w3.'px;
_height: '.$thumbnail_h3.'px;
_width: '.$thumbnail_w3.'px;
border: '.$hfgallery_b.'px solid #'.$hfgallery_b_color.' !important;
margin-top: 0px;
bottom: '.(2 + ($hfgallery_b * 2)).'px;
}
.galleria-thumb-nav-left,
.galleria-thumb-nav-right {top: '.($thumbsblocklr3 + 5).'px;}';

} else {

$insertgallery .= '.galleria-container{';
#	if($_GET['gal_cap'] == 'ON') {
#		if($setheight == '') {
#		$insertgallery .= 'height:'.($height3 + 35 + ($hfgallery_b)).'px;';
#		} else {
#		$insertgallery .= 'height:'.ceil(($setheight + $thumbsblock3) + 35).'px;';		
#		} 
#	}
#	else
	{
		if($setheight == '') {
		$insertgallery .= 'height:'.($height3).'px;';	
		} else {
		$insertgallery .= 'height:'.ceil(($setheight + $thumbsblock3) + 10).'px;';
		} 
	} 
$insertgallery .= 'max-width:'.$maxwidth3.'px;
}
.galleria-stage {
position: relative;
bottom:'.($thumbsblock3 + 20).'px;
width: '.$maxwidth3.';';
	if($setheight == '') {
    $insertgallery .= 'height:'.ceil(($maxwidth3 * .664) + ($hfgallery_b*2)).'px;';
	} else {
	$insertgallery .= 'height:'.ceil($setheight + 20).'px;';	
	} 
$insertgallery .= '
top: -'.($hfgallery_b*2).'px;
}
.galleria-stage img {
border: '.$hfgallery_b.'px solid #'.$hfgallery_b_color.' !important;
max-height:'.floor(($maxwidth3 * .664) - ($hfgallery_b*2)).'px;
max-width:'.floor(($maxwidth3) - ($hfgallery_b*2) - 1).'px;
width: auto;
margin-left: -'.($hfgallery_b).'px;
}
.galleria-thumbnails-container {
height:'.($thumbsblockh3 + ($hfgallery_b * 2)).'px;
overflow:visible;
}
.galleria-info {bottom:'.($thumbsblock3 + ($hfgallery_b * 2) - 1).'px;}
.galleria-thumbnails {
padding-top: '.(10 + ($hfgallery_b * 2)).'px;
text-align: left;
margin: 0 auto;
}

.galleria-thumbnails .galleria-image {
height: '.$thumbnail_h3.'px;
width: '.$thumbnail_w3.'px;
_height: '.$thumbnail_h3.'px;
_width: '.$thumbnail_w3.'px;
border: '.$hfgallery_b.'px solid #'.$hfgallery_b_color.' !important;
margin-top: 0px;
bottom: '.(2 + ($hfgallery_b * 2)).'px;
}

.galleria-thumb-nav-left,
.galleria-thumb-nav-right {top: '.($thumbsblocklr3 + ($hfgallery_b*2)).'px;}';
}

$insertgallery .= '</style>';

	$insertgallery .= '<div id="content"><div class="gallery" id="gallery-'.$_GET['gal_id'].'"></div></div>';
    
    } else if($_GET['gal_type'] == '4') {
        
	$insertgallery .= '<script>Galleria.loadTheme(\''.get_bloginfo('template_url').'/admin/js/themes/lightbox/galleria.lightbox.js\');
parent.jQuery("iFrame#g'.$_GET['gal_id'].'").css("min-height","100px");
parent.jQuery("iFrame#g'.$_GET['gal_id'].'").css("width","100%");
jQuery(document).ready(function() {
var gallerydata = '.stripslashes(htmlspecialchars_decode($json)).';
jQuery(\'#gallery-'.$_GET['gal_id'].'\').galleria({
data_type: \'json\',
data_source: gallerydata,
data_config: function(img) {
return {
description: jQuery(img).next(\'.caption\').html()
}
},';
if($thumb_crop == 'ON') {
$insertgallery .= 'thumb_crop: true,';
} else {
$insertgallery .= 'thumb_crop: false,';
}
$insertgallery .= 'extend: function() {
 
// Added to notify parent
this.bind("thumbnail", function() {
	
	// Set iframe height
	parent.iframe_'.$_GET['gal_id'].'_loaded();
	
});

var j = 0;
jQuery(".galleria-image img").each(function(index) {

j++;

function md(e) 
{ 
	try { if (event.button==2||event.button==3) return false; }  
	catch (e) { if (e.which == 3) return false; } 
}
jQuery(this)[0].oncontextmenu = function() {return false;}
jQuery(this)[0].ondragstart   = function() {return false;}
jQuery(this)[0].onmousedown   = md;

		var s = jQuery(this).attr("src");
		var search = "/thumbnails/";
		var ind = s.lastIndexOf(search);
		var before = s.substring(0, ind);
		var after = s.substring(ind+search.length);
		var finished = before + "/full/" + after;';

if($image_resolution == '1') {
	
	if($pos === false) {
		
		$insertgallery .= 'jQuery(this).attr("href",jQuery(this).attr("src"));';
		
	} else {
	
	}

} else {
	
	if($pos === false) {
			
		$insertgallery .= '
		
		jQuery(this).attr("href",finished);';
		
	} else {
	
	}

}

$insertgallery .= '
jQuery(this).attr("rel","lightbox");
var imgname = jQuery(this).attr("src").split("/");';
$insertgallery .= 'jQuery(this).attr("title",jQuery("[id$=\'-"+imgname[imgname.length-1]+"\']").val());
var thissrc = jQuery(this).attr("src");
//parent.jQuery("#decoys").append(\'<a href="\'+finished+\'" style="display:none;" class="decoy" id="decoy_\'+imgname[imgname.length-1]+\'" rel="'.$_GET['gal_id'].'" title="Test">\'+finished+\'</a>\');

jQuery(this).click(function() {
listItem = jQuery(this);
currId = jQuery(".galleria-image img").index(listItem) + 1;
//alert(jQuery(".galleria-image img").index(listItem));
parent.jQuery("a#img_'.$_GET['gal_id'].'_"+currId).trigger("click");
});';

$insertgallery .= '

});

parent.jQuery("iFrame#g'.$_GET['gal_id'].'").oncontextmenu = function() {return false;}

var iw = parent.window.innerWidth;
var ih = parent.window.innerHeight;
/*
jQuery(".galleria-image img").lightBox({
    maxHeight: (parseFloat(ih) - 160),
    maxWidth: (parseFloat(iw) - 200),
    imageLoading: "'.get_bloginfo('template_url').'/admin/js/themes/lightbox/loader.gif",
	imageBtnPrev: "'.get_bloginfo('template_url').'/admin/js/themes/lightbox/p.png",
	imageBtnNext: "'.get_bloginfo('template_url').'/admin/js/themes/lightbox/n.png",
	imageBtnClose: "'.get_bloginfo('template_url').'/admin/js/themes/lightbox/close.png",
	imageBlank:	"'.get_bloginfo('template_url').'/admin/images/lightbox-blank.gif"
});
*/
jQuery(".galleria-image img").click(function(){

//return false;

});

}

});
}); </script>';

    $insertgallery .= '<style>';
    if($_GET['gal_cap'] == 'OFF') {
    $insertgallery .= '
.galleria-info-text{display:none;}';
    }
    $insertgallery .= '
.galleria-thumbnails .galleria-image { 
height: '.($thumbnail_h4 - ($tgallery_b*2)).'px;
width: '.($thumbnail_w4 - ($tgallery_b*2)).'px;
_height: '.($thumbnail_h4 - ($tgallery_b*2)).'px;
_width: '.($thumbnail_w4 - ($tgallery_b*2)).'px;
border: '.$tgallery_b.'px solid #'.$tgallery_b_color.' !important;
margin: 0;}
</style>';

	$insertgallery .= '<div id="content"><div class="gallery" id="gallery-'.$_GET['gal_id'].'"></div></div>';

	} else if($_GET['gal_type'] == '5') {
        
	$insertgallery .= '';

	}

    echo $insertgallery;
    echo $hiddendesc;

?>
</BODY>
</HTML>
