<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sketch-It</title>
<meta name="keywords" content="Sketch picture facebook profile pic" />
<meta name="description" content="Sketch your pictures in a minute and save them." />
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
  include_once 'uploader.php';
?>
<div id="templatemo_site_title_bar_wrapper">
	<div id="templatemo_site_title_bar">
    	<div id="site_title">
            <h1><a href="/index.php">Sketch It<span>sketches in a minute</span></a></h1>
        </div>
        <? include_once 'fblike.php'; ?>
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
     <div id="imageContainer">
        <? 
          if( $photo ) { 
            $ppic = $photo[0];
            $pname = explode('/', $ppic['src_big']);
            $pname = $pname[count($pname)-1];
           
            exec("wget -P /home/sketchit/input/ {$photo[0]['src_big']}");
            exec("/home/sketchit/backend/sketcher $pname");
            exec("cp /home/sketchit/output/$pname /var/www/sketchit.com/output/");
          } 
        ?>
        <!--<img id="sketch" src = "<?//=$ppic['src_big']?>"/> -->
        <p align="center"><img id="sketch" src = "<?=$host.'/output/'.$pname?>"/></p>
        
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
        <div class="cleaner"></div>
  
  		<!-- end of the slider -->  
  
      </div>
   	  </div> <!-- end of templatemo_popular_posts -->
    </div>

      <? include_once 'footer.php'; ?>


</body>
</html>
