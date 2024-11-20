<?php
session_start();
header("Content-type: text/javascript");

#Giris Kontrol
if ( isset($_SESSION['sTwityAdmin']) )
{
include "../../config.php";
    $json['hata'] = 0;

    $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n";
    $get_data = DB::query("SELECT * FROM uyeler WHERE uyelikTur = '0' ORDER BY RAND() LIMIT 50000");
    $xml .= "<users>\n";
    $i = 0;
    foreach ( $get_data as $data ) {
        $xml .= "\n<user>\n";
        $xml .= "\t<appID>".$data->appID."</appID>\n";
        $xml .= "\t<tID>".$data->tID."</tID>\n";
        $xml .= "\t<oauthToken>".$data->oauthToken."</oauthToken>\n";
        $xml .= "\t<oauthScreet>".$data->oauthScreet."</oauthScreet>\n";
        $xml .= "</user>\n";
        $i++;
    }
    $xml .= "\n</users>\n";
    $yazmaIslemi = @file_put_contents('../../'.uyelerXML, $xml);

        if($yazmaIslemi)
        {
            $json['sonuc'] = '<div class="alert alert-success">
                                  <a class="close" data-dismiss="alert" href="#">×</a>
                                  <h4 class="alert-heading">Tamamlandi!</h4>
                                  Toplamda <b>'.$i.'</b> adet kisi <b>'.uyelerXML.'</b> dosyasina aktarildi.
                                </div>';
        } else {
            $json['hata'] = 1;
            $json['sonuc'] = '<div class="alert alert-error">
                                  <a class="close" data-dismiss="alert" href="#">×</a>
                                  <h4 class="alert-heading">Hata!</h4>
                                  Dosyada yazma izni yok.
                                </div>';
        }

    echo json_encode($json);

}
?>