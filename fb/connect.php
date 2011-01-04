<?
  include_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
  include_once 'fbmain.php';
//  print_r($fbme);
?>
<script type='text/javascript'>
function sitelogin()  {
    $('#fb-button').remove();
    CozyUi.Helpers.showLoadingImage('fconnect','ajax-loader.gif', 'middle');
    var host = Cozy.Helpers.getHost();
    $.ajax({
      url: host + '/fconnect.v2/login_handler.php',
      method: 'post',
      success: function(data) {
        parent.window.location.reload();
        CozyUi.Helpers.removeLoadingImage('fconnect');
      }
    });
}
</script>

<script type='text/javascript' src = 'https://connect.facebook.net/en_US/all.js' async = true></script>
<script type="text/javascript">

window.fbAsyncInit = function() {
  FB.init({appId: '<?=$fbconfig['appid' ]?>', status: true, cookie: true, xfbml: true,
          session : <?php  echo json_encode($facebook->getSession()) ?>
  });

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
//  $.getScript('https://connect.facebook.net/en_US/all.js', function () {
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
//  });
}
</script>

<style type = 'text/css'>
.fconnect {
  color: #fff;
  float: right;
  margin-top: 30px;
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
    <div class='fconnect' id='fconnect'>
      <a href = 'javascript:fb_login();' id='fb-button'>
        <img src = '<?=IMG_URL_ROOT?>ui/fconnect.png' alt='Login with Facebook' width= '180' height='40' />
      </a>
    </div>
