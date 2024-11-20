<?php
session_start();
header("Content-type: text/javascript");

#Giris Kontrol
if ( isset($_SESSION['sTwityAdmin']) )
{
include "../../config.php";
    $json['hata'] = 0;

    $yBaslik = $_POST['yBaslik'];
    $yEmail = $_POST['yEmail'];
    $ySifre = md5(sha1($_POST['ySifre']));

        if ($yBaslik && $yEmail && $ySifre)
        {

            $ekle = DB::insert(
                'INSERT INTO yoneticiler (yBaslik, yEmail, ySifre) VALUES (?, ?, ?)',
                array($yBaslik, $yEmail, $ySifre)
            );

        if($ekle)
        {
            $json['sonuc'] = '<div class="alert alert-success">
                                  <a class="close" data-dismiss="alert" href="#">×</a>
                                  <h4 class="alert-heading">Tamamlandi!</h4>
                                  Yönetici basariyla eklenmistir.
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