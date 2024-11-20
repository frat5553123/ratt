<?php
include "../config.php";
$kullananUyeler = DB::query("SELECT * FROM uyeler WHERE appID = ? ORDER BY RAND() LIMIT 26", array(appID));
$i = 1;
$json['sonuc'] = '';
foreach( $kullananUyeler as $kullananUye )
{
    if ( $i % 13 == 0 ) $ek = '<br />'; else $ek = '';
    $json['sonuc'] .= '<span style="margin: 2px;"><img src="'.$kullananUye->tProfileImage.'" class="img-circle" /></span>'.$ek;
    $i++;
}
echo json_encode($json);
?>