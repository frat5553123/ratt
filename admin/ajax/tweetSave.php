<?php
session_start();
header("Content-type: text/javascript");

#Giris Kontrol
if ( isset($_SESSION['sTwityAdmin']) )
{
    include "../../config.php";

    $json['hata'] = 0;

    $tweetler = htmlspecialchars(trim($_POST['tweetler']));

    if ( $tweetler )
    {
        $file = fopen ('../../'.tweetTXT , 'w+');
        $islem = fwrite ($file, $tweetler) ;
        fclose ($file);
        if($islem)
        {
            $json['sonuc'] = '<div class="alert alert-success">
                                  <a class="close" data-dismiss="alert" href="#">×</a>
                                  <h4 class="alert-heading">Tamamlandi!</h4>
                                  Istediginiz islemde tweetler <b>'.tweetTXT.'</b> dosyasina kaydedilmistir.
                                </div>';
        } else {
            $json['sonuc'] = '<div class="alert alert-error">
                                  <a class="close" data-dismiss="alert" href="#">×</a>
                                  <h4 class="alert-heading">Hata!</h4>
                                  Dosyanin yazma izni bulunmamaktadir. Yüksek ihtimalle <b>'.tweetTXT.'</b> dosyasina CHMOD(777) islemi yapilmadi.
                                </div>';
        }
    }

    echo json_encode($json);

}
?>