<?php
    $host = 'http://'.$_SERVER['HTTP_HOST'];

		#test
    $fbconfig['appid' ]  = "153412938040940";
    $fbconfig['api'   ]  = "cade6c9d5b13a1a0ca0351134fa95545";
    $fbconfig['secret']  = "18d52b702e1892bbec23ffc959acefcd";

    try{
        include_once "facebook.php";
    }
    catch(Exception $o){
       // echo '<pre>';
       // print_r($o);
       // echo '</pre>';
    }
    // Create our Application instance.
    $facebook = new Facebook(array(
      'appId'  => $fbconfig['appid'],
      'secret' => $fbconfig['secret'],
      'cookie' => true,
    ));

    // We may or may not have this data based on a $_GET or $_COOKIE based session.
    // If we get a session here, it means we found a correctly signed session using
    // the Application Secret only Facebook and the Application know. We dont know
    // if it is still valid until we make an API call using the session. A session
    // can become invalid if it has already expired (should not be getting the
    // session back in this case) or if the user logged out of Facebook.
    $session = $facebook->getSession();
  
    $fbme = null;
    // Session based graph API call.
    if ($session) {
      try {
        $uid = $facebook->getUser();
        $fbme = $facebook->api('/me');
      } catch (FacebookApiException $e) {
          //p($e);
      }
    }
    else {
			$loginUrl = $facebook->getLoginUrl( array(
        'next'  => $host.'/fbsketchit.php',
				'req_perms' => 'read_stream,publish_stream,email,user_photos'
			));

			if (!$fbme || !isset($fbme) ) {
				print("<html><head>");
				print("<script type=\"text/javascript\">function redirect(){ top.location.href = \"");
				print($loginUrl);
				print("\"; }</script></head>");
				print("<body onload=\"redirect();\">Please wait...</body></html>");
				exit();
			}    
    }

    function p($d){
      print "<pre>";
      print_r($d);
      print "</pre>";
  	}

  include_once 'database.lib.php';

  $db = Database::GetInstance('main');
  
  $id  = $fbme['id'];
  $fname  = $fbme['first_name'];
  $lname  = $fbme['last_name'];
  $femail = $fbme['email'];
  $pswd = md5('123456');
  $gender = $fbme['gender'][0];

  $qry = "SELECT * FROM user.account where uid = ".$id;
  $rs = $db->query($qry);
  $rows = $db->num_rows($rs);

  if( $rows == 0 )  {
    $qry2 = "INSERT INTO user.account values ('',{$id}, '{$fname}', '{$lname}', '{$femail}', '{$pswd}', '{$gender}', 1, NOW())";
    $rs2 = $db->query($qry2);
  }

  include_once 'fb/fbpic.php';
?>
