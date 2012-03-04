<?php

/*
Plugin Name: Vertical scroll image slideshow gallery
Plugin URI: http://www.gopiplus.com/work/2010/07/18/vertical-scroll-image-slideshow-gallery/
Description:  This (VS slideshow) is a simple Image Vertical scroll slideshow Gallery plugin for WordPress widget. <a target="_blank" href='http://www.gopiplus.com/work/2010/07/18/vertical-scroll-image-slideshow-gallery/'>Click here to check more useful plugins.</a>
Author: Gopi.R
Version: 6.0
Author URI: http://www.gopiplus.com/work/
Donate link: http://www.gopiplus.com/work/2010/07/18/vertical-scroll-image-slideshow-gallery/
*/

/**
 *     Vertical scroll image slideshow gallery
 *     Copyright (C) 2011  www.gopiplus.com
 * 
 *     This program is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 * 
 *     This program is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 * 
 *     You should have received a copy of the GNU General Public License
 *     along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
 
function VSslideshow_slideshow() 
{
	
	?>
	<script language="JavaScript1.2">
	
	var vs_scrollerwidth='<?php echo get_option('VSslideshow_width'); ?>'
	var vs_scrollerheight='<?php echo get_option('VSslideshow_height'); ?>'
	var vs_pausebetweenimages=<?php echo get_option('VSslideshow_time'); ?>
	
	var vs_slideimages=new Array()
	
	<?php
	$gSlidedir = get_option('VSslideshow_dir');
	$gSlideimglink = get_option('VSslideshow_imglink');
	$gSlidesiteurl = get_option('siteurl');
	if($gSlideimglink=="")
	{
		$gSlideimglink = '#';
	}
	// open specified directory
	$gSlidedirHandle = opendir($gSlidedir);
	$vs_count = -1;
	$returnstr = "";
	$gSlidereturnstr = "";
	while ($gSlidefile = readdir($gSlidedirHandle)) 
	{
	  if(!is_dir($gSlidefile) && (strpos(strtoupper($gSlidefile), '.JPG')>0 or strpos(strtoupper($gSlidefile), '.GIF')>0 or strpos(strtoupper($gSlidefile), '.PNG')>0 or strpos(strtoupper($gSlidefile), '.JPEG')>0)) 
	  {
		 $vs_count++;
		 $gSlidereturnstr = $gSlidereturnstr . "vs_slideimages[$vs_count]='<a href=\'$gSlideimglink\'><img src=\'$gSlidesiteurl/$gSlidedir$gSlidefile\' border=\'0\'></a>'; ";
	  }
	} 
	echo $gSlidereturnstr;
	closedir($gSlidedirHandle);
	?>
	
	//////////////////////Vertical scroll image slideshow gallery/////////////////////////////////////////////
	
	var ie=document.all
	var dom=document.getElementById
	
	if (vs_slideimages.length>2)
	vs_i=2
	else
	vs_i=0
	
	function vs_move1(whichlayer){
	tlayer=eval(whichlayer)
	if (tlayer.top>0&&tlayer.top<=5){
	tlayer.top=0
	setTimeout("vs_move1(tlayer)",vs_pausebetweenimages)
	setTimeout("vs_move2(document.vs_main.document.vs_second)",vs_pausebetweenimages)
	return
	}
	if (tlayer.top>=tlayer.document.height*-1){
	tlayer.top-=5
	setTimeout("vs_move1(tlayer)",50)
	}
	else{
	tlayer.top=parseInt(vs_scrollerheight)
	tlayer.document.write(vs_slideimages[vs_i])
	tlayer.document.close()
	if (vs_i==vs_slideimages.length-1)
	vs_i=0
	else
	vs_i++
	}
	}
	
	function vs_move2(whichlayer){
	tlayer2=eval(whichlayer)
	if (tlayer2.top>0&&tlayer2.top<=5){
	tlayer2.top=0
	setTimeout("vs_move2(tlayer2)",vs_pausebetweenimages)
	setTimeout("vs_move1(document.vs_main.document.vs_first)",vs_pausebetweenimages)
	return
	}
	if (tlayer2.top>=tlayer2.document.height*-1){
	tlayer2.top-=5
	setTimeout("vs_move2(tlayer2)",50)
	}
	else{
	tlayer2.top=parseInt(vs_scrollerheight)
	tlayer2.document.write(vs_slideimages[vs_i])
	tlayer2.document.close()
	if (vs_i==vs_slideimages.length-1)
	vs_i=0
	else
	vs_i++
	}
	}
	
	function vs_move3(whichdiv){
	tdiv=eval(whichdiv)
	if (parseInt(tdiv.style.top)>0&&parseInt(tdiv.style.top)<=5){
	tdiv.style.top=0+"px"
	setTimeout("vs_move3(tdiv)",vs_pausebetweenimages)
	setTimeout("vs_move4(vs_second2_obj)",vs_pausebetweenimages)
	return
	}
	if (parseInt(tdiv.style.top)>=tdiv.offsetHeight*-1){
	tdiv.style.top=parseInt(tdiv.style.top)-5+"px"
	setTimeout("vs_move3(tdiv)",50)
	}
	else{
	tdiv.style.top=vs_scrollerheight
	tdiv.innerHTML=vs_slideimages[vs_i]
	if (vs_i==vs_slideimages.length-1)
	vs_i=0
	else
	vs_i++
	}
	}
	
	function vs_move4(whichdiv){
	tdiv2=eval(whichdiv)
	if (parseInt(tdiv2.style.top)>0&&parseInt(tdiv2.style.top)<=5){
	tdiv2.style.top=0+"px"
	setTimeout("vs_move4(tdiv2)",vs_pausebetweenimages)
	setTimeout("vs_move3(vs_first2_obj)",vs_pausebetweenimages)
	return
	}
	if (parseInt(tdiv2.style.top)>=tdiv2.offsetHeight*-1){
	tdiv2.style.top=parseInt(tdiv2.style.top)-5+"px"
	setTimeout("vs_move4(vs_second2_obj)",50)
	}
	else{
	tdiv2.style.top=vs_scrollerheight
	tdiv2.innerHTML=vs_slideimages[vs_i]
	if (vs_i==vs_slideimages.length-1)
	vs_i=0
	else
	vs_i++
	}
	}
	
	function startscroll(){
	if (ie||dom){
	vs_first2_obj=ie? vs_first2 : document.getElementById("vs_first2")
	vs_second2_obj=ie? vs_second2 : document.getElementById("vs_second2")
	vs_move3(vs_first2_obj)
	vs_second2_obj.style.top=vs_scrollerheight
	vs_second2_obj.style.visibility='visible'
	}
	else if (document.layers){
	document.vs_main.visibility='show'
	vs_move1(document.vs_main.document.vs_first)
	document.vs_main.document.vs_second.top=parseInt(vs_scrollerheight)+5
	document.vs_main.document.vs_second.visibility='show'
	}
	}
	
	window.onload=startscroll
	
	</script>
	
	<ilayer id="vs_main" width=&{vs_scrollerwidth}; height=&{vs_scrollerheight}; visibility=hide>
	<layer id="vs_first" width=&{vs_scrollerwidth};>
	<script language="JavaScript1.2">
	if (document.layers)
	document.write(vs_slideimages[0])
	</script>
	</layer>
	<layer id="vs_second" width=&{vs_scrollerwidth}; visibility=hide>
	<script language="JavaScript1.2">
	if (document.layers)
	document.write(vs_slideimages[dyndetermine=(vs_slideimages.length==1)? 0 : 1])
	</script>
	</layer>
	</ilayer>
	<script language="JavaScript1.2">
	if (ie||dom)
	{
		document.writeln('<div style="padding:8px 0px 8px 0px;">')
		document.writeln('<div id="vs_main2" style="position:relative;width:'+vs_scrollerwidth+';height:'+vs_scrollerheight+';overflow:hidden;">')
		document.writeln('<div style="position:absolute;width:'+vs_scrollerwidth+';height:'+vs_scrollerheight+';clip:rect(0 '+vs_scrollerwidth+' '+vs_scrollerheight+' 0);">')
		document.writeln('<div id="vs_first2" style="position:absolute;width:'+vs_scrollerwidth+';left:0px;top:1px;">')
		document.write(vs_slideimages[0])
		document.writeln('</div>')
		document.writeln('<div id="vs_second2" style="position:absolute;width:'+vs_scrollerwidth+';visibility:hidden">')
		document.write(vs_slideimages[dyndetermine=(vs_slideimages.length==1)? 0 : 1])
		document.writeln('</div>')
		document.writeln('</div>')
		document.writeln('</div>')
		document.writeln('</div>')
	}
	</script>
    
	<?php
	
}



function VSslideshow_install() 
{
	add_option('VSslideshow_title', "Slide Show");
	add_option('VSslideshow_width', "200px");
	add_option('VSslideshow_height', "175px");
	add_option('VSslideshow_time', "3000");
	add_option('VSslideshow_dir', "wp-content/plugins/vertical-scroll-image-slideshow-gallery/VSslideshow/");
	add_option('VSslideshow_imglink', "#");
}

function VSslideshow_widget($args) 
{
	extract($args);
	echo $before_widget . $before_title;
	echo get_option('VSslideshow_title');
	echo $after_title;
	VSslideshow_slideshow();
	echo $after_widget;
}

function VSslideshow_control() 
{
	$VSslideshow_title = get_option('VSslideshow_title');
	$VSslideshow_width = get_option('VSslideshow_width');
	$VSslideshow_height = get_option('VSslideshow_height');
	$VSslideshow_time = get_option('VSslideshow_time');
	$VSslideshow_dir = get_option('VSslideshow_dir');
	$VSslideshow_imglink = get_option('VSslideshow_imglink');
	
	if (@$_POST['VSslideshow_submit']) 
	{
		$VSslideshow_title = stripslashes($_POST['VSslideshow_title']);
		$VSslideshow_width = stripslashes($_POST['VSslideshow_width']);
		$VSslideshow_height = stripslashes($_POST['VSslideshow_height']);
		$VSslideshow_time = stripslashes($_POST['VSslideshow_time']);
		$VSslideshow_dir = stripslashes($_POST['VSslideshow_dir']);
		$VSslideshow_imglink = stripslashes($_POST['VSslideshow_imglink']);
		
		update_option('VSslideshow_title', $VSslideshow_title );
		update_option('VSslideshow_width', $VSslideshow_width );
		update_option('VSslideshow_height', $VSslideshow_height );
		update_option('VSslideshow_time', $VSslideshow_time );
		update_option('VSslideshow_dir', $VSslideshow_dir );
		update_option('VSslideshow_imglink', $VSslideshow_imglink );
	}
	
	echo '<p>Title:<input  style="width: 400px;" maxlength="100" type="text" value="';
	echo $VSslideshow_title . '" name="VSslideshow_title" id="VSslideshow_title" /></p>';
	
	echo '<p>Set the scrollerwidth and scrollerheight to the width/height of the LARGEST image in your slideshow!</p>';
	
	echo '<p>Width:<input  style="width: 100px;" maxlength="5" type="text" value="';
	echo $VSslideshow_width . '" name="VSslideshow_width" id="VSslideshow_width" />';
	
	echo '&nbsp;&nbsp;&nbsp;Height:<input  style="width: 100px;" maxlength="5" type="text" value="';
	echo $VSslideshow_height . '" name="VSslideshow_height" id="VSslideshow_height" /></p>';
	
	echo '<p>Slide timeout:<input  style="width: 200px;" maxlength="6" type="text" value="';
	echo $VSslideshow_time . '" name="VSslideshow_time" id="VSslideshow_time" />(3000 = 3 seconds)</p>';
	
	echo '<p>Images Link:<br><input  style="width: 570px;" type="text" value="';
	echo $VSslideshow_imglink . '" name="VSslideshow_imglink" id="VSslideshow_imglink" /></p>';
	
	echo '<p>Image directory:(Upload all your images in this directory)<br><input  style="width: 570px;" type="text" value="';
	echo $VSslideshow_dir . '" name="VSslideshow_dir" id="VSslideshow_dir" />';
	echo '<br />Default: wp-content/plugins/vertical-scroll-image-slideshow-gallery/VSslideshow/';
	echo '<br /><br />Best practice : Dont upload your original images into this default folder instead you change this default path to original path. Otherwise you may lose the images when you update the plugin to next version.</p>';
	
	echo '<input type="hidden" id="VSslideshow_submit" name="VSslideshow_submit" value="1" />';
	
	?>
	<h2>About Plugin</h2>
	<a target="_blank" href='http://www.gopiplus.com/work/2010/07/18/vertical-scroll-image-slideshow-gallery/'>Check official website</a><br> 
	<?php
}

function VSslideshow_widget_init() 
{
	if(function_exists('wp_register_sidebar_widget')) 	
	{
		wp_register_sidebar_widget('vs-slideshow', 'VS slideshow', 'VSslideshow_widget');
	}
	
	if(function_exists('wp_register_widget_control')) 	
	{
		wp_register_widget_control('vs-slideshow', array('VS slideshow', 'widgets'), 'VSslideshow_control', 'width=650');
	} 
}

function VSslideshow_deactivation() 
{
//	delete_option('VSslideshow_title');
//	delete_option('VSslideshow_width');
//	delete_option('VSslideshow_height');
//	delete_option('VSslideshow_time');
//	delete_option('VSslideshow_dir');
//	delete_option('VSslideshow_imglink');
}

add_action("plugins_loaded", "VSslideshow_widget_init");
register_activation_hook(__FILE__, 'VSslideshow_install');
register_deactivation_hook(__FILE__, 'VSslideshow_deactivation');
add_action('init', 'VSslideshow_widget_init');
?>