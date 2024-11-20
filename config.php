<?php
# slcQ
# mail@selcuk.at
# selcuk.at

error_reporting(0);

# Lisans Kodu
define('lisansKodu', '18f5.f1bf.df1b.b3e0');

# PDO & Fonk
include "config/function.selco.php";
include "config/db.selco.php";

# Database ayarlari
define("MYSQL_HOST", "localhost");
define("MYSQL_USER", "kemikha1_dar");
define("MYSQL_PASS", "U7Gp84GWW9DYveky7uM7");
define("MYSQL_DB", "kemikha1_dar");
define("CHARSET", "UTF8");

# # APP Ayarlari
$appAyar = DB::getRow("SELECT * FROM uygulamalar WHERE aktif = '1'");
define('appID', $appAyar->id);
define('CONSUMER_KEY', $appAyar->consumerKey);
define('CONSUMER_SECRET', $appAyar->consumerScreet);
define('OAUTH_CALLBACK', 'http://'.$_SERVER['HTTP_HOST'].'/callback');

/* 
Callback URL http://site.com/callback olarak ayarlanmistir.
Uygulamaya bu sekil girilmelidir.
*/

# XML Üyeler Dosya Adi
define('uyelerXML', 'users.xml');

# Tweetler Dosya Adi
define('tweetTXT', 'tweet.txt');
?>