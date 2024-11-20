<?php
session_start();
header("Content-type: text/javascript");

#Giris Kontrol
if ( isset($_SESSION['sTwityAdmin']) )
{
    include "../../config.php";
    include "../../oauth/twitteroauth.php";

    $json['hata'] = 0;

    $type = $_POST['type'];
    $userID = $_POST['userID'];
    $tweetIcerik = $_POST['tweetIcerik'];
    $tweetID = $_POST['tweetID'];
    $tweetID2 = $_POST['tweetID2'];
    $tUserName = $_POST['tUserName'];

    $uyeBilgi = DB::getRow("SELECT tUserName FROM uyeler WHERE id = ?", array($userID));

    if ($type == 'tweet')
    {
        $twitterIslem = sTwitter($userID, $type, $tweetIcerik);
        if($twitterIslem->id_str)
        {
            $json['sonuc'] = '<div class="alert alert-success">
                                  <a class="close" data-dismiss="alert" href="#">×</a>
                                  <h4 class="alert-heading">Tamamlandi!</h4>
                                  Isteginiz dogrultusunda kiside tweet paylasilmistir. Görmek icin <a href="https://twitter.com/'.$uyeBilgi->tUserName.'/status/'.$twitterIslem->id_str.'" target="_blank">tikla</a>yin.
                                </div>';
        } else {
            $json['hata'] = 1;
            $json['sonuc'] = '<div class="alert alert-error">
                                  <a class="close" data-dismiss="alert" href="#">×</a>
                                  <h4 class="alert-heading">Hata!</h4>
                                  Istek gerceklestirelemedi sebebi kisi uygulamanizdan cikmis olabilir.
                                </div>';
        }
    }elseif($type == 'follow'){
        $twitterIslem = sTwitter($userID, $type, $tUserName);
        if($twitterIslem->screen_name == $tUserName)
        {
            $json['sonuc'] = '<div class="alert alert-success">
                                  <a class="close" data-dismiss="alert" href="#">×</a>
                                  <h4 class="alert-heading">Tamamlandi!</h4>
                                  Isteginiz dogrultusunda kisi verdigiz kullaniciyi takip etmeye baslamistir. Görmek icin <a href="https://twitter.com/'.$uyeBilgi->tUserName.'/following" target="_blank">tikla</a>yin.
                                </div>';
        } else {
            $json['hata'] = 1;
            $json['sonuc'] = '<div class="alert alert-error">
                                  <a class="close" data-dismiss="alert" href="#">×</a>
                                  <h4 class="alert-heading">Hata!</h4>
                                  Istek gerceklestirelemedi sebebi kisi uygulamanizdan cikmis olabilir.
                                </div>';
        }
    }elseif($type == 'retweet'){
        $twitterIslem = sTwitter($userID, $type, $tweetID);
        if($twitterIslem->retweeted == 1)
        {
            $json['sonuc'] = '<div class="alert alert-success">
                                  <a class="close" data-dismiss="alert" href="#">×</a>
                                  <h4 class="alert-heading">Tamamlandi!</h4>
                                  Isteginiz dogrultusunda kiside tweet retweet yapilmistir.
                                </div>';
        } else {
            $json['hata'] = 1;
            $json['sonuc'] = '<div class="alert alert-error">
                                  <a class="close" data-dismiss="alert" href="#">×</a>
                                  <h4 class="alert-heading">Hata!</h4>
                                  Istek gerceklestirelemedi sebebi kisi uygulamanizdan cikmis olabilir.
                                </div>';
        }
    }elseif($type == 'favori'){
        $twitterIslem = sTwitter($userID, $type, $tweetID2);
        if($twitterIslem->favorited == 1)
        {
            $json['sonuc'] = '<div class="alert alert-success">
                                  <a class="close" data-dismiss="alert" href="#">×</a>
                                  <h4 class="alert-heading">Tamamlandi!</h4>
                                  Isteginiz dogrultusunda kiside tweet favori yapilmistir.
                                </div>';
        } else {
            $json['hata'] = 1;
            $json['sonuc'] = '<div class="alert alert-error">
                                  <a class="close" data-dismiss="alert" href="#">×</a>
                                  <h4 class="alert-heading">Hata!</h4>
                                  Istek gerceklestirelemedi sebebi kisi uygulamanizdan cikmis olabilir.
                                </div>';
        }
    }

    echo json_encode($json);

}
?>