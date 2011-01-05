<?
//fql query example using legacy method call and passing parameter
try{
  $url = $_GET['picurl'];
  //get user id
  $uid    = $facebook->getUser();
  $aid;
  //or you can use $uid = $fbme['id'];

  $fql    =   "select name, hometown_location, sex, pic_big, pic_with_logo from user where uid=" . $uid;
  $fql    =   "select aid,name from album where owner=" . $uid;
  $param  =   array(
    'method'    => 'fql.query',
    'query'     => $fql,
    'callback'  => ''
  );
  $albums   =   $facebook->api($param);

  foreach($albums as $key=>$val)  {
    if( $val['name'] == 'Profile Pictures' )  {
      $fql  = "SELECT src_big, src_small from photo where aid = ".$val['aid']." and owner = " . $uid ;
      $param  =   array(
        'method'    => 'fql.query',
        'query'     => $fql,
        'callback'  => ''
      );
      $photo   =   $facebook->api($param);
    }
  }
}
catch(Exception $o){
  //p($o);
}
?>
