<?php
session_start();

#Giris Kontrol
if ( isset($_SESSION['sTwityAdmin']) )
{
    include "../../config.php";
    include '../../epiCurl/EpiCurl.php';
    include '../../epiCurl/EpiOAuth.php';
    include '../../epiCurl/EpiTwitter.php';

    $type = $_POST['type'];
    $appID = $_POST['kaynakUygulama'];
    $limit = $_POST['limit'];
    $islemAdi = $_POST['islemTuru'];
    $tweetIcerik = $_POST['tweetIcerik'];
    $tweetID = $_POST['tweetID'];
    $tUserName = $_POST['tUserName'];

    if ($type == 'tweet')
    {
        echo tTwitter($appID, 'tweet', $tweetIcerik, $limit, '../../'.uyelerXML);
    }elseif($type == 'follow'){
        $twitter = parse_url($tUserName);
        $eskiDeger = follow($tUserName.'?v='.uniqid());
        if ($islemAdi == 'ekle')
        {
            tTwitter($appID, 'follow', substr($twitter['path'], 1), $limit, '../../'.uyelerXML);
            $yeniDeger = follow($tUserName.'?v='.uniqid());
            echo $yeniDeger -  $eskiDeger;
        } else {
            tTwitter($appID, 'unfollow', substr($twitter['path'], 1), $limit, '../../'.uyelerXML);
            $yeniDeger = follow($tUserName.'?v='.uniqid());
            echo $yeniDeger -  $eskiDeger;
        }
    }elseif($type == 'retweet'){
        $twitter = parse_url($tweetID);
        $twitterID = explode('/', $twitter['path']);
        $eskiDeger = retweet($tweetID.'?v='.uniqid());
        tTwitter($appID, 'retweet', $twitterID[3], $limit, '../../'.uyelerXML);
        $yeniDeger = retweet($tweetID.'?v='.uniqid());
        echo $yeniDeger -  $eskiDeger;
    }elseif($type == 'favori'){
        $twitter = parse_url($tweetID);
        $twitterID = explode('/', $twitter['path']);
        $eskiDeger = favori($tweetID.'?v='.uniqid());
        if ($islemAdi == 'ekle')
        {
            tTwitter($appID, 'favorite', $twitterID[3], $limit, '../../'.uyelerXML);
            $yeniDeger = favori($tweetID.'?v='.uniqid());
            echo $yeniDeger -  $eskiDeger;
        } else {
            tTwitter($appID, 'unfavorite', $twitterID[3], $limit, '../../'.uyelerXML);
            $yeniDeger = favori($tweetID.'?v='.uniqid());
            echo $yeniDeger -  $eskiDeger;
        }

    }

}
?>