<?php
header("Content-Type: text/html; charset=utf-8"); 
session_start();
include './oauth/twitteroauth.php';
include './config.php';
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
$request_token = $connection->getRequestToken(OAUTH_CALLBACK);
$_SESSION['oauth_token'] = $token = $request_token['oauth_token'];
$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
switch ($connection->http_code) {
  case 200:
    $url = $connection->getAuthorizeURL($token);
    header('Location: ' . $url); 
    break;
  default:
    echo 'Could not connect to Twitter. Refresh the page or try again later. <br> Uygulama Twitter a bağlanamıyor daha sonra tekrar deneyin.';
}
?>
