<?php
session_start();
header("Content-type: text/javascript");

#Giris Kontrol
if ( isset($_SESSION['sTwityAdmin']) )
{
include "../../config.php";
    $json['hata'] = 0;

    $userId = intval($_POST['userId']);
    $yeniSifre = md5(sha1($_POST['yeniSifre']));

    if ( trim($_POST['yeniSifre']) )
    {
        $guncelle = DB::query("UPDATE yoneticiler SET ySifre = '$yeniSifre' WHERE id = ?", array($userId));
        if($guncelle)
        {
            $json['sonuc'] = '<div class="alert alert-success">
                                  <a class="close" data-dismiss="alert" href="#">×</a>
                                  <h4 class="alert-heading">Tamamlandi!</h4>
                                  Yöneticinin sifresi güncellenmistir.
                                </div>';
        } else {
            $json['hata'] = 1;
            $json['sonuc'] = '<div class="alert alert-error">
                                  <a class="close" data-dismiss="alert" href="#">×</a>
                                  <h4 class="alert-heading">Hata!</h4>
                                  Sistemsel Hata.
                                </div>';
        }
    } else {
        $json['hata'] = 1;
        $json['sonuc'] = '<div class="alert alert-error">
                                  <a class="close" data-dismiss="alert" href="#">×</a>
                                  <h4 class="alert-heading">Hata!</h4>
                                  Bos alan birakmayin
                                </div>';
    }
    echo json_encode($json);
}
?>