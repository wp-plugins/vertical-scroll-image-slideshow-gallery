<?php

/*
Plugin Name: Vertical scroll image slideshow gallery
Plugin URI: http://gopi.coolpage.biz/gSlideshow/index.html
Description:  This (gSlideshow) is a simple Image slideshow Gallery plugin for WordPress with javascript.
Author: Gopi.R
Version: 1.0
Author URI: http://gopi.coolpage.biz/gSlideshow/index.html
*/

function gSlideshow_slideshow() 
{
	
	?>
	<script language="JavaScript1.2">
	
	var scrollerwidth='<?php echo get_option('gSlideshow_width'); ?>'
	var scrollerheight='<?php echo get_option('gSlideshow_height'); ?>'
	var pausebetweenimages=<?php echo get_option('gSlideshow_time'); ?>
	
	var slideimages=new Array()
	
	<?php
	$gSlidedir = get_option('gSlideshow_dir');
	$gSlideimglink = get_option('gSlideshow_imglink');
	$gSlidesiteurl = get_option('siteurl');
	if($gSlideimglink=="")
	{
		$gSlideimglink = '#';
	}
	// open specified directory
	$gSlidedirHandle = opendir($gSlidedir);
	$count = -1;
	$returnstr = "";
	while ($gSlidefile = readdir($gSlidedirHandle)) 
	{
	  if(!is_dir($gSlidefile) && (strpos($gSlidefile, '.jpg')>0 or strpos($gSlidefile, '.gif')>0)) 
	  {
		 $count++;
		 $gSlidereturnstr = $gSlidereturnstr . "slideimages[$count]='<a href=\'$gSlideimglink\'><img src=\'$gSlidesiteurl/$gSlidedir$gSlidefile\' border=\'0\'></a>'; ";
	  }
	} 
	echo $gSlidereturnstr;
	closedir($gSlidedirHandle);
	?>
	
	//////////////////////Vertical scroll image slideshow gallery/////////////////////////////////////////////
	
	var ie=document.all
	var dom=document.getElementById
	
	if (slideimages.length>2)
	i=2
	else
	i=0
	
	function move1(whichlayer){
	tlayer=eval(whichlayer)
	if (tlayer.top>0&&tlayer.top<=5){
	tlayer.top=0
	setTimeout("move1(tlayer)",pausebetweenimages)
	setTimeout("move2(document.main.document.second)",pausebetweenimages)
	return
	}
	if (tlayer.top>=tlayer.document.height*-1){
	tlayer.top-=5
	setTimeout("move1(tlayer)",50)
	}
	else{
	tlayer.top=parseInt(scrollerheight)
	tlayer.document.write(slideimages[i])
	tlayer.document.close()
	if (i==slideimages.length-1)
	i=0
	else
	i++
	}
	}
	
	function move2(whichlayer){
	tlayer2=eval(whichlayer)
	if (tlayer2.top>0&&tlayer2.top<=5){
	tlayer2.top=0
	setTimeout("move2(tlayer2)",pausebetweenimages)
	setTimeout("move1(document.main.document.first)",pausebetweenimages)
	return
	}
	if (tlayer2.top>=tlayer2.document.height*-1){
	tlayer2.top-=5
	setTimeout("move2(tlayer2)",50)
	}
	else{
	tlayer2.top=parseInt(scrollerheight)
	tlayer2.document.write(slideimages[i])
	tlayer2.document.close()
	if (i==slideimages.length-1)
	i=0
	else
	i++
	}
	}
	
	function move3(whichdiv){
	tdiv=eval(whichdiv)
	if (parseInt(tdiv.style.top)>0&&parseInt(tdiv.style.top)<=5){
	tdiv.style.top=0+"px"
	setTimeout("move3(tdiv)",pausebetweenimages)
	setTimeout("move4(second2_obj)",pausebetweenimages)
	return
	}
	if (parseInt(tdiv.style.top)>=tdiv.offsetHeight*-1){
	tdiv.style.top=parseInt(tdiv.style.top)-5+"px"
	setTimeout("move3(tdiv)",50)
	}
	else{
	tdiv.style.top=scrollerheight
	tdiv.innerHTML=slideimages[i]
	if (i==slideimages.length-1)
	i=0
	else
	i++
	}
	}
	
	function move4(whichdiv){
	tdiv2=eval(whichdiv)
	if (parseInt(tdiv2.style.top)>0&&parseInt(tdiv2.style.top)<=5){
	tdiv2.style.top=0+"px"
	setTimeout("move4(tdiv2)",pausebetweenimages)
	setTimeout("move3(first2_obj)",pausebetweenimages)
	return
	}
	if (parseInt(tdiv2.style.top)>=tdiv2.offsetHeight*-1){
	tdiv2.style.top=parseInt(tdiv2.style.top)-5+"px"
	setTimeout("move4(second2_obj)",50)
	}
	else{
	tdiv2.style.top=scrollerheight
	tdiv2.innerHTML=slideimages[i]
	if (i==slideimages.length-1)
	i=0
	else
	i++
	}
	}
	
	function startscroll(){
	if (ie||dom){
	first2_obj=ie? first2 : document.getElementById("first2")
	second2_obj=ie? second2 : document.getElementById("second2")
	move3(first2_obj)
	second2_obj.style.top=scrollerheight
	second2_obj.style.visibility='visible'
	}
	else if (document.layers){
	document.main.visibility='show'
	move1(document.main.document.first)
	document.main.document.second.top=parseInt(scrollerheight)+5
	document.main.document.second.visibility='show'
	}
	}
	
	window.onload=startscroll
	
	</script>
	
	<ilayer id="main" width=&{scrollerwidth}; height=&{scrollerheight}; visibility=hide>
	<layer id="first" width=&{scrollerwidth};>
	<script language="JavaScript1.2">
	if (document.layers)
	document.write(slideimages[0])
	</script>
	</layer>
	<layer id="second" width=&{scrollerwidth}; visibility=hide>
	<script language="JavaScript1.2">
	if (document.layers)
	document.write(slideimages[dyndetermine=(slideimages.length==1)? 0 : 1])
	</script>
	</layer>
	</ilayer>
	<script language="JavaScript1.2">
	if (ie||dom)
	{
		document.writeln('<div style="padding:8px 0px 8px 0px;">')
		document.writeln('<div id="main2" style="position:relative;width:'+scrollerwidth+';height:'+scrollerheight+';overflow:hidden;">')
		document.writeln('<div style="position:absolute;width:'+scrollerwidth+';height:'+scrollerheight+';clip:rect(0 '+scrollerwidth+' '+scrollerheight+' 0);">')
		document.writeln('<div id="first2" style="position:absolute;width:'+scrollerwidth+';left:0px;top:1px;">')
		document.write(slideimages[0])
		document.writeln('</div>')
		document.writeln('<div id="second2" style="position:absolute;width:'+scrollerwidth+';visibility:hidden">')
		document.write(slideimages[dyndetermine=(slideimages.length==1)? 0 : 1])
		document.writeln('</div>')
		document.writeln('</div>')
		document.writeln('</div>')
		document.writeln('</div>')
	}
	</script>
    
	<?php
	
}



function gSlideshow_install() 
{
	add_option('gSlideshow_title', "Slide Show");
	add_option('gSlideshow_width', "200px");
	add_option('gSlideshow_height', "175px");
	add_option('gSlideshow_time', "3000");
	add_option('gSlideshow_dir', "wp-content/plugins/gSlideshow/gSlideimages/");
	add_option('gSlideshow_imglink', "#");
}

function gSlideshow_widget($args) 
{
	extract($args);
	echo $before_widget . $before_title;
	echo get_option('gSlideshow_title');
	echo $after_title;
	gSlideshow_slideshow();
	echo $after_widget;
}

function gSlideshow_control() 
{
	$gSlideshow_title = get_option('gSlideshow_title');
	$gSlideshow_width = get_option('gSlideshow_width');
	$gSlideshow_height = get_option('gSlideshow_height');
	$gSlideshow_time = get_option('gSlideshow_time');
	$gSlideshow_dir = get_option('gSlideshow_dir');
	$gSlideshow_imglink = get_option('gSlideshow_imglink');
	
	if ($_POST['gSlideshow_submit']) 
	{
		$gSlideshow_title = stripslashes($_POST['gSlideshow_title']);
		$gSlideshow_width = stripslashes($_POST['gSlideshow_width']);
		$gSlideshow_height = stripslashes($_POST['gSlideshow_height']);
		$gSlideshow_time = stripslashes($_POST['gSlideshow_time']);
		$gSlideshow_dir = stripslashes($_POST['gSlideshow_dir']);
		$gSlideshow_imglink = stripslashes($_POST['gSlideshow_imglink']);
		
		update_option('gSlideshow_title', $gSlideshow_title );
		update_option('gSlideshow_width', $gSlideshow_width );
		update_option('gSlideshow_height', $gSlideshow_height );
		update_option('gSlideshow_time', $gSlideshow_time );
		update_option('gSlideshow_dir', $gSlideshow_dir );
		update_option('gSlideshow_imglink', $gSlideshow_imglink );
	}
	
	echo '<p>Title:<input  style="width: 200px;" maxlength="100" type="text" value="';
	echo $gSlideshow_title . '" name="gSlideshow_title" id="gSlideshow_title" /></p>';
	
	echo '<p>set the scrollerwidth and scrollerheight to the width/height of the LARGEST image in your slideshow!</p>';
	
	echo '<p>Width:<input  style="width: 100px;" maxlength="5" type="text" value="';
	echo $gSlideshow_width . '" name="gSlideshow_width" id="gSlideshow_width" />';
	
	echo '&nbsp;&nbsp;&nbsp;Height:<input  style="width: 100px;" maxlength="5" type="text" value="';
	echo $gSlideshow_height . '" name="gSlideshow_height" id="gSlideshow_height" /></p>';
	
	echo '<p>Slide timeout:<input  style="width: 200px;" maxlength="6" type="text" value="';
	echo $gSlideshow_time . '" name="gSlideshow_time" id="gSlideshow_time" />(3000 = 3 seconds)</p>';
	
	echo '<p>Images Link:<br><input  style="width: 400px;" type="text" value="';
	echo $gSlideshow_imglink . '" name="gSlideshow_imglink" id="gSlideshow_imglink" /></p>';
	
	echo '<p>Image directory:(Upload all your images in this directory)<br><input  style="width: 400px;" type="text" value="';
	echo $gSlideshow_dir . '" name="gSlideshow_dir" id="gSlideshow_dir" />';
	echo '<br>Default: wp-content/plugins/gSlideshow/gSlideimages/</p>';
	
	echo '<input type="hidden" id="gSlideshow_submit" name="gSlideshow_submit" value="1" />';
}

function gSlideshow_widget_init() 
{
  	register_sidebar_widget(__('gSlideshow'), 'gSlideshow_widget');   
	
	if(function_exists('register_sidebar_widget')) 	
	{
		register_sidebar_widget('gSlideshow', 'gSlideshow_widget');
	}
	
	if(function_exists('register_widget_control')) 	
	{
		register_widget_control(array('gSlideshow', 'widgets'), 'gSlideshow_control',500,400);
	} 
}

function gSlideshow_deactivation() 
{
	delete_option('gSlideshow_title');
	delete_option('gSlideshow_width');
	delete_option('gSlideshow_height');
	delete_option('gSlideshow_time');
	delete_option('gSlideshow_dir');
	delete_option('gSlideshow_imglink');
}

add_action("plugins_loaded", "gSlideshow_widget_init");
register_activation_hook(__FILE__, 'gSlideshow_install');
register_deactivation_hook(__FILE__, 'gSlideshow_deactivation');
add_action('init', 'gSlideshow_widget_init');
?>