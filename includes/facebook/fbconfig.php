<?php

session_start();
// added in v4.0.0
require_once 'autoload.php';
include "../php/general.php";
include "../php/base.php";

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookHttpable;
// init app with app id and secret
FacebookSession::setDefaultApplication( '1846305968942250','fbff692b575f1c665b4956df66a1891b' );
// login helper with redirect_uri
    $helper = new FacebookRedirectLoginHelper('http://localhost:8282/includes/facebook/fbconfig.php' );
try {
  $session = $helper->getSessionFromRedirect();
} catch( FacebookRequestException $ex ) {
  // When Facebook returns an error
} catch( Exception $ex ) {
  // When validation fails or other local issues
}
// see if we have a session
if ( isset( $session ) ) {
  // graph api request for user data
  $request = new FacebookRequest( $session, 'GET', '/me' );
  $response = $request->execute();
  // get response
  $graphObject = $response->getGraphObject();
     	$fbid = $graphObject->getProperty('id');              // To Get Facebook ID
 	    $fbfullname = $graphObject->getProperty('name'); // To Get Facebook full name
	    $femail = $graphObject->getProperty('email');    // To Get Facebook email ID
        $fbfirst = $graphObject->getProperty('first');
        $fblast = $graphObject->getProperty('last');

	/* ---- Session Variables -----*/
	    $_SESSION['FBID'] = $fbid;           
        $_SESSION['FULLNAME'] = $fbfullname;
	    $_SESSION['EMAIL'] =  $femail;
	    $first = explode(" ", $fbfullname)[0];
	    $last = explode(" ", $fbfullname)[1];

	    $_SESSION['logged_in'] = true;
    $sql = "SELECT * FROM users WHERE username='".$fbid."'";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) == 0){
        $sql = "INSERT INTO users (username, password, firstName, lastName, email, phone) VALUES ('".$fbid."','','".$first."','".$last."','".$femail."','')";
        $query = mysqli_query($conn, $sql);
        $_SESSION['user_id'] = mysqli_insert_id($conn);
    }else{
        $result = mysqli_fetch_assoc($query);
        $_SESSION['user_id'] = $result['userID'];
    }
    /* ---- header location after session ----*/
  header("Location: /pages/index.php");
} else {
  $loginUrl = $helper->getLoginUrl();
  $_SESSION['logged_in'] = false;
    $_SESSION['FBID'] = null;
    $_SESSION['FULLNAME'] = null;
    $_SESSION['EMAIL'] = null;
    $_SESSION['username'] = null;
    $_SESSION['user_id'] = null;
 header("Location: ".$loginUrl);
}
?>