<?php
include "../config.php";
$siteAyarlari = DB::getRow("SELECT * FROM ayarlar");
$uyeler = DB::query("SELECT * FROM uyeler");
foreach ($uyeler as $uye){
    if ($uye->uyelikTur == 1)
    {
        DB::exec("UPDATE uyeler SET gunlukKredi = '$siteAyarlari->goldUyeKredi' WHERE id = '$uye->id' and uyelikTur = '1'");
    }elseif($uye->uyelikTur == 0){
        DB::exec("UPDATE uyeler SET gunlukKredi = '$siteAyarlari->gunlukKredi' WHERE id = '$uye->id' and uyelikTur = '0'");
    }
}
?>