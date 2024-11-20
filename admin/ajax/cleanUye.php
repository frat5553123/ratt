<?php
session_start();
header("Content-type: text/javascript");

#Giris Kontrol
if ( isset($_SESSION['sTwityAdmin']) )
{
    include "../../config.php";
    include "../../oauth/twitteroauth.php";

    $json['hata'] = 0;

    $kaynakUygulama = intval($_POST['kaynakUygulama']);

    $uyelerCek = DB::query("SELECT * FROM uyeler WHERE appID = ? ORDER BY RAND()", array($kaynakUygulama));
    $i = 0;
    foreach($uyelerCek as $uyeDetay){
        $apiBilgi = DB::getRow("SELECT * FROM uygulamalar WHERE id = ?", array($uyeDetay->appID));
        $twitterAPI = new TwitterOAuth($apiBilgi->consumerKey, $apiBilgi->consumerScreet, $uyeDetay->oauthToken, $uyeDetay->oauthScreet);
        $gelenSonuc = $twitterAPI->post('https://api.twitter.com/1.1/account/settings.json');
        if ( $uyeDetay->tUserName != $gelenSonuc->screen_name ){
            DB::exec("DELETE FROM uyeler WHERE id = ?", array($uyeDetay->id));
            DB::insert(
                'INSERT INTO yasaklilar (appID, tID) VALUES (?, ?)',
                array($uyeDetay->appID, $uyeDetay->tID)
            );
            $i++;
        }
    }

    if($_POST)
    {
        xmlAktar('../../'.uyelerXML);
        $json['sonuc'] = '<div class="alert alert-success">
                                  <a class="close" data-dismiss="alert" href="#">×</a>
                                  <h4 class="alert-heading">Tamamlandi!</h4>
                                  Toplamda <b>'.$i.'</b> adet kisi sistemden temizlendi, yasakli listesine alindi ve <b>'.uyelerXML.'</b> dosyasi yeniden olusturulmustur.
                                </div>';
    } else {
        $json['hata'] = 1;
        $json['sonuc'] = '<div class="alert alert-error">
                                  <a class="close" data-dismiss="alert" href="#">×</a>
                                  <h4 class="alert-heading">Hata!</h4>
                                  Bilinmeyen Hata.
                                </div>';
    }

    echo json_encode($json);

}
?>