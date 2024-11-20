<?php
session_start();
header("Content-type: text/javascript");

#Giris Kontrol
if ( isset($_SESSION['sTwityAdmin']) )
{
include "../../config.php";
    $json['hata'] = 0;

    $userId = intval($_POST['userId']);
    $uyeLimit = intval($_POST['uyeLimit']);

    if ( $_POST )
    {
        $guncelle = DB::query("UPDATE uyeler SET gunlukKredi = '$uyeLimit' WHERE id = ?", array($userId));
        if($guncelle)
        {
            $json['sonuc'] = '<div class="alert alert-success">
                                  <a class="close" data-dismiss="alert" href="#">×</a>
                                  <h4 class="alert-heading">Tamamlandi!</h4>
                                  Üyenin limiti '.$uyeLimit.' olarak güncellenmistir.
                                </div>';
        } else {
            $json['hata'] = 1;
            $json['sonuc'] = '<div class="alert alert-error">
                                  <a class="close" data-dismiss="alert" href="#">×</a>
                                  <h4 class="alert-heading">Hata!</h4>
                                  Sistemsel Hata.
                                </div>';
        }
        echo json_encode($json);
    }

}
?>