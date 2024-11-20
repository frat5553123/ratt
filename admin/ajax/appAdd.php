<?php
session_start();
header("Content-type: text/javascript");

#Giris Kontrol
if ( isset($_SESSION['sTwityAdmin']) )
{
include "../../config.php";
    $json['hata'] = 0;
    $appBaslik = $_POST['appBaslik'];
    $consumerKey = $_POST['consumerKey'];
    $consumerScreet = $_POST['consumerScreet'];
    $ayarOtomatikTweet = $_POST['ayarOtomatikTweet'];
    ($ayarOtomatikTweet == 1) ? DB::exec("UPDATE uygulamalar SET aktif = '0' WHERE aktif = '1'") : NULL;

        if ($appBaslik && $consumerKey && $consumerScreet)
        {

            $ekle = DB::insert(
                'INSERT INTO uygulamalar (appBaslik, consumerKey, consumerScreet, aktif) VALUES (?, ?, ?, ?)',
                array($appBaslik, $consumerKey, $consumerScreet, $ayarOtomatikTweet)
            );

        if($ekle)
        {
            $json['sonuc'] = '<div class="alert alert-success">
                                  <a class="close" data-dismiss="alert" href="#">×</a>
                                  <h4 class="alert-heading">Tamamlandi!</h4>
                                  Uygulama basariyla eklenmistir.
                                </div>';
        } else {
            $json['hata'] = 1;
            $json['sonuc'] = '<div class="alert alert-error">
                                  <a class="close" data-dismiss="alert" href="#">×</a>
                                  <h4 class="alert-heading">Hata!</h4>
                                  Sistemsel hatadan ötürü eklenemedi.
                                </div>';
        }

        } else {
            $json['hata'] = 1;
            $json['sonuc'] = '<div class="alert alert-error">
                                  <a class="close" data-dismiss="alert" href="#">×</a>
                                  <h4 class="alert-heading">Hata!</h4>
                                  Bos alan birakmayin lütfen.
                                </div>';
        }
    echo json_encode($json);

}
?>