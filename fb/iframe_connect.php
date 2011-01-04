<?
  include_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
  include_once 'fbmain.php';
//  print_r($fbme);
?>
<html>
  <head></head>
<body style="background-color: transparent;">

<script type="text/javascript" src="<?php echo TPL_URL_ROOT ?>assets/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="<?php echo TPL_URL_ROOT ?>assets/js/basic_functionality.js"></script>
<script type='text/javascript'>
function sitelogin()  {
    //showLoadingImage('fconnect-loading','bouncing.gif');
    var host = getHost();
    $.ajax({
      url: host + '/fconnect.v2/login_handler.php',
      method: 'post',
      success: function(data) {
        parent.window.location.reload();
        //removeLoadingImage('fconnect-loading');
      }
    });
}
</script>

<? //if( !isset($fbme) ) {  ?>
<script type='text/javascript' src = 'https://connect.facebook.net/en_US/all.js' async = true></script>
<script type="text/javascript">

window.fbAsyncInit = function() {
  FB.init({appId: '<?=$fbconfig['appid' ]?>', status: true, cookie: true, xfbml: true});

  /* All the events registered */
/*  FB.Event.subscribe('auth.login', function(response) {
    sitelogin();
  });
*/
  FB.Event.subscribe('auth.logout', function(response) {
    //Nothing to do for now..
  });

};

function fb_login() {
  FB.login( function (response) {
    if(response.session) {
      if( response.perms ) {
        sitelogin();
      } else  {
        // logged in but didnt allow the application.
      }
    } else  {
      // not logged in.
    }
  }, {perms:'read_stream,publish_stream,offline_access,email'});
}
</script>

<style type = 'text/css'>
.fconnect {
  color: #fff;
  float: right;
}
/*.fconnect p{
  float: right;
  margin-top: -5px;
}*/
.fconnect a img{
  border: none;
  float: right;
}
.fconnect a img:alt {
  border: none;
  font-size: 12px;
  color: white;
}
</style>

    <div id='fb-root'></div>
      <!--fb:login-button size="large" background="white" length="long" autologoutlink="true" perms="email,user_birthday,status_update,publish_stream,read_stream,offline_access"></fb:login-button-->
<?  //} else { ?>
    <div class='fconnect'>
      <a href = 'javascript:fb_login();'>
        <img src = '<?=IMG_URL_ROOT?>ui/fconnect.png' alt='Login with Facebook' width= '180' height='40' />
      </a>
    </div>
<?  //} ?>
  </body>
<!-- code to connect to facebook and our db queries  -->
</html>
