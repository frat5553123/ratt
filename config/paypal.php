<?php
include "../config.php";

# ayarlar
$siteAyarlari = DB::getRow("SELECT * FROM ayarlar");

$tutar = $_POST["mc_gross"];
$paypal_kesinti = $_POST["mc_fee"];
$net_tutar = $tutar - $paypal_kesinti;
$uyePayPalMail = $_POST["payer_email"];
$tID = $_POST["item_number"];
$item_name = $_POST["item_name"];
$item_name = "$tID - $item_name";

if ( $tID )
{
    DB::insert(
        'INSERT INTO odemeler (tID, aciklama, netTutar, tutar, uyePayPalMail, tarih) VALUES (?, ?, ?, ?, ?, ?)',
        array($tID, $item_name, $net_tutar, $tutar, $uyePayPalMail, time())
    );
}

# otomatik aktif etme
if ( $siteAyarlari->paypalUyeAktif == 1 ) {
    $bitisTarih = strtotime('+'.$siteAyarlari->goldUyeSureHafta.' week');
    $uyeKredi =  DB::getRow("SELECT gunlukKredi FROM uyeler WHERE tID = ?", array($tID));
    $uyeYeniKredi = $siteAyarlari->goldUyeKredi + $uyeKredi->gunlukKredi;
    DB::query("UPDATE uyeler SET gunlukKredi = '$uyeYeniKredi', uyelikTur = '1', uyelikBitisTarih = '$bitisTarih' WHERE tID = ?", array($tID));
}
?>