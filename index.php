<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sketch-It</title>
<meta name="keywords" content="free css templates, free website templates, simple blue, light gray" />
<meta name="description" content="Simple Blue is a free CSS template from www.templatemo.com" />
<link href="templatemo_style.css" rel="stylesheet" type="text/css" />
<link href="css/jquery.ennui.contentslider.css" rel="stylesheet" type="text/css" media="screen,projection" />
<script language="javascript" type="text/javascript">
function clearText(field)
{
    if (field.defaultValue == field.value) field.value = '';
    else if (field.value == '') field.value = field.defaultValue;
}
</script>
</head>
<body>
<?php
  include_once 'fb/fbmain.php';
?>
<div id="templatemo_site_title_bar_wrapper">
	<div id="templatemo_site_title_bar">
    	<div id="site_title">
            <h1><a href="/index.php">Sketch It<span>sketches in a minute</span></a></h1>
        </div>
        <!--ul id="templatemo_menu">
            <li><a href="#" class="current"><span></span>Home</a></li>
            <li><a href="http://www.templatemo.com/page/1" target="_blank"><span></span>CSS</a></li>
						<li><a href="http://www.flashmo.com/page/1" target="_blank"><span></span>Flash</a></li>    
            <li><a href="http://www.koflash.com" target="_blank"><span></span>Gallery</a></li>
            <li><a href="#"><span></span>About</a></li>        
            <li><a href="#"><span></span>Contact</a></li>
        </ul-->
        
        <!--div id="search_box">
            <form action="#" method="get">
                <input type="text" value="Enter keyword here..." name="q" size="10" id="searchfield" title="searchfield" onfocus="clearText(this)" onblur="clearText(this)" />
                <input type="submit" name="Search" value="Search" alt="Search" id="searchbutton" title="Search" />
            </form>
       </div-->
       
	</div> <!-- end of templatemo_site_title_bar -->        
       
</div> <!-- end of templatemo_site_title_bar_wrapper -->

   <div id="templatemo_content_wrapper"> 
    <div id="templatemo_content">

    <!-- start of the slider -->
    
    <div id="one" class="contentslider" style="width:960px; height:700px;">
    <p algin="center">
            <div class="cs_wrapper">
                <div class="cs_slider">
                
                <? if( $photo ) { $i = 0; foreach( $photo as $key => $val ) { if($i>10) break; $i++;  ?>
                    <div class="cs_article">
                      <div class="cs_article_inner">
                        <div class="img_frame"><a href="/sketchit.php?p=<?=rawurlencode($val['src_big']);?>"><img src = "<?=$val['src_big']?>"/></a></div>
                        <p> You can now generate your sketches.
                        </p>
                        <a href="/sketchit.php?p=<?=rawurlencode($val['src_big']);?>">Click here to generate sketch of this pic.</a>
                      </div>
                    </div>
                <? }  } ?>
            </div>
    </p>
    </div>
        <script type="text/javascript" src="js/jquery-1.3.1.min.js"></script>
        <script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
        <script type="text/javascript" src="js/jquery.ennui.contentslider.js"></script>
        <script type="text/javascript">
            $(function() {
            $('#one').ContentSlider({
            width : '960px',
            height : '250px',
          	speed : 400,
            easing : 'easeOutSine'
            });
            });
        </script>
        <script src="js/jquery.chili-2.2.js" type="text/javascript"></script>
        <script src="js/chili/recipes.js" type="text/javascript"></script>
  
  		<!-- end of the slider -->  
  
       </div>
    
	<p align="center" style="font-weight:bold; font-size:20px; padding-top:30px;">Sketch your facebook profile pic.</p>
        <div class="cleaner"></div>
</div>

</body>
</html>
