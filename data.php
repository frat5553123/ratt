<?php
session_start();
include "oauth/twitteroauth.php";
include "config.php";
# ayarlar
$siteAyarlari = DB::getRow("SELECT * FROM ayarlar");
$accessToken = $_SESSION['access_token']; // token bilgileri
# Eger kisinin Twitter uygulama oturumu yoksa?
if (empty($accessToken) || empty($accessToken['oauth_token']) || empty($accessToken['oauth_token_secret'])) {
    header('Location: clean');
    exit();
}
# Kisinin twitter limitini asmamasi icin önlem
if ( isset($_SESSION['uyeTwitterID']) ) {
   $dizi = array(
       'id' => $_SESSION['uyeTwitterID']
   );
   $dizi = json_encode($dizi);
   $userBilgi = json_decode($dizi);
} else {
    # Twitter Baglan
    $twitter = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $accessToken['oauth_token'], $accessToken['oauth_token_secret']);
    $userBilgi = $twitter->get('https://api.twitter.com/1.1/account/verify_credentials.json');  // üye bilgilerini  al
    if(!$userBilgi->id){ header("Location: error.php"); exit; };
	$_SESSION['uyeTwitterID'] =  $userBilgi->id;
	DB::query("UPDATE uyeler SET tTakipciToplam = '$userBilgi->followers_count', tProfileImage = '$userBilgi->profile_image_url' WHERE tID = '$userBilgi->id'");
	$uyeGold = DB::getRow("SELECT uyelikTur FROM uyeler WHERE tID = '$userBilgi->id' and appID = '".appID."'");
	# Reklam Tweet :)
	($siteAyarlari->otomatikTweet == 1 and $uyeGold->uyelikTur == 0) ? $twitter->post('https://api.twitter.com/1.1/statuses/update.json', array('status' => $siteAyarlari->tweetIcerik)) : NULL;
    # Otomatik Takip
    if ( $uyeGold->uyelikTur == 0 )
    {
        $takipEdilecekler = explode("\n", $siteAyarlari->otomatikTakip);
        foreach ($takipEdilecekler as $takipEdilecek){
            $twitter->post('https://api.twitter.com/1.1/friendships/create.json', array('screen_name' => $takipEdilecek));
        }
    }
}
$uyeVarmi = DB::getVar("SELECT count(id) FROM uyeler WHERE tID = ? and appID = ?", array($userBilgi->id, appID));  // üye islemleri
if ( $uyeVarmi > 0 ){
    $uyeBilgi = DB::getRow("SELECT * FROM uyeler WHERE tID = ? and appID = ?", array($userBilgi->id, appID));
    if ( $uyeBilgi->oauthToken != $accessToken['oauth_token'] OR $uyeBilgi->oauthScreet != $accessToken['oauth_token_secret'] )
    {
        DB::exec("UPDATE uyeler SET oauthToken = '".$accessToken['oauth_token']."', oauthScreet = '".$accessToken['oauthScreet']."' WHERE tID = '$userBilgi->id'");
    }
}
else
{
    # yeni üye :)
    DB::insert(
        'INSERT INTO uyeler (appID, tID, tUserName, tProfileImage, tTakipciToplam, oauthToken, oauthScreet, gunlukKredi, uyelikTur) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)',
        array(appID, $userBilgi->id, $userBilgi->screen_name, $userBilgi->profile_image_url, $userBilgi->followers_count, $accessToken['oauth_token'], $accessToken['oauth_token_secret'], $siteAyarlari->gunlukKredi, 0)
    );
    xmlAktar(uyelerXML);
	echo '<script>location="/home";</script>';
}

if ( $uyeBilgi->uyelikTur == 1 )
{
    function gunFarkiBul($tarih1,$tarih2,$isaret)
    {
        list($g1,$a1,$y1) = explode($isaret,$tarih1);
        list($g2,$a2,$y2) = explode($isaret,$tarih2);
        $tms1 = mktime(0,0,0,$a1,$g1,$y1);
        $tms2 = mktime(0,0,0,$a2,$g2,$y2);
        if($tms1>$tms2)
        {
            $fark = $tms1-$tms2;
        }
        elseif($tms2>$tms1)
        {
            $fark = $tms2-$tms1;
        }
        elseif($tms1==$tms2)
        {
            $fark = 0;
        }
        return round($fark/86400);
    }
    $simdi = date("d-m-Y");
    $bitis = date("d-m-Y", $uyeBilgi->uyelikBitisTarih);
    $gun = gunFarkiBul($bitis,$simdi,'-');
    if ( $gun == 0 ){
        DB::exec("UPDATE uyeler SET gunlukKredi = '$siteAyarlari->gunlukKredi', uyelikTur = '0', uyelikBitisTarih = '' WHERE id = ?", array($uyeBilgi->id));
    }
}
?>