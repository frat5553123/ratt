<?php
session_start();

#Giris Kontrol
if ( isset($_SESSION['sTwityAdmin']) )
{

include "../config.php";
include "../config/page.selco.php";
include "oauth/twitteroauth.php";

$yoneticiDetay = DB::getRow("SELECT * FROM yoneticiler WHERE yEmail = ?", array($_SESSION['sTwityAdmin']));
(!$yoneticiDetay->id) ? session_destroy() : NULL;

$page = $_GET['go'];
define('_go', $page);

# ayarlar
$siteAyarlari = DB::getRow("SELECT * FROM ayarlar");
$toplamUygulama = DB::getVar("SELECT count(id) FROM uygulamalar");
$toplamUye = DB::getVar("SELECT count(id) FROM uyeler");
$toplamYoneticiler = DB::getVar("SELECT count(id) FROM yoneticiler");
$toplamUygulamaAktifUye = DB::getVar("SELECT count(id) FROM uyeler WHERE appID = ?", array(appID));
$toplamOdeme = DB::getVar("SELECT count(id) FROM odemeler");

# Aktif uygulama
$aktifUygulamaKontrol = DB::getVar("SELECT count(id) FROM uygulamalar WHERE aktif = '1'");
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
<meta charset="utf-8">
<title><?php echo $siteAyarlari->title; ?> - Admin Paneli</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">

    <!-- Styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <link href="css/bootstrap-overrides.css" rel="stylesheet">

    <link href="css/ui-lightness/jquery-ui-1.8.21.custom.css" rel="stylesheet">
    <link href="js/plugins/datatables/DT_bootstrap.css" rel="stylesheet">
    <link href="js/plugins/responsive-tables/responsive-tables.css" rel="stylesheet">

    <link href="css/slate.css" rel="stylesheet">
    <link href="css/slate-responsive.css" rel="stylesheet">

    <link href="css/pages/dashboard.css" rel="stylesheet">
    <link href="css/pages/reports.css" rel="stylesheet">
    <link href="js/plugins/msgGrowl/css/msgGrowl.css" rel="stylesheet">


    <!-- Javascript -->
    <script src="js/jquery-1.7.2.min.js"></script>
    <script src="js/jquery-ui-1.8.21.custom.min.js"></script>
    <script src="js/jquery.ui.touch-punch.min.js"></script>
    <script src="js/bootstrap.js"></script>

    <script src="js/plugins/datatables/jquery.dataTables.js"></script>
    <script src="js/plugins/datatables/DT_bootstrap.js"></script>
    <script src="js/plugins/responsive-tables/responsive-tables.js"></script>

    <script src="js/plugins/msgGrowl/js/msgGrowl.js"></script>

    <script src="js/Slate.js"></script>

    <script type="text/javascript">
        $(function () {
            $('#sTwityTablo').dataTable( {
                sDom: "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
                sPaginationType: "bootstrap",
                oLanguage: {
                    "sLengthMenu": "_MENU_"
                }
            });
        });
    </script>



<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>

<body>
 	
  	
<div id="header">
	
	<div class="container">			
		
		<h1><a href="index.php"><?php echo $siteAyarlari->header; ?></a></h1>

        <div id="info">

            <a href="javascript:;" id="info-trigger">
                <i class="icon-cog"></i>
            </a>

            <div id="info-menu">

                <div class="info-details">

                    <h4><?php echo $yoneticiDetay->yBaslik; ?></h4>

                    <p>
                        <a href="?go=cikiS">Cikis Yap</a>
                    </p>

                </div> <!-- /.info-details -->

                <div class="info-avatar">

                    <img src="./img/avatar.jpg" alt="avatar">

                </div> <!-- /.info-avatar -->

            </div> <!-- /#info-menu -->

        </div> <!-- /#info -->
		
	</div> <!-- /.container -->

</div> <!-- /#header -->

<?php
( _go == '' ) ? $anaSayfaAktif = 'active' : $anaSayfaAktif = NULL;
( _go == 'appS' ) ? $appSAktif = 'active' : $appSAktif = NULL;
( _go == 'userS' ) ? $userSAktif = 'active' : $userSAktif = NULL;
( _go == 'paymentS' ) ? $paymentSAktif = 'active' : $paymentSAktif = NULL;
( _go == 'adminS' ) ? $adminSAktif = 'active' : $adminSAktif = NULL;
( _go == 'tAppS' ) ? $ozelSAktif = 'active' : $ozelSAktif = NULL;
?>

<div id="nav">
		
	<div class="container">
		
		<a href="javascript:;" class="btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        	<i class="icon-reorder"></i>
      	</a>
		
		<div class="nav-collapse">
			
			<ul class="nav">
		
				<li class="nav-icon <?php echo $anaSayfaAktif; ?>">
					<a href="index.php">
						<i class="icon-home"></i>
						<span>AnaSayfa</span>
					</a>	    				
				</li>
				
				<li class="<?php echo $appSAktif; ?>">
					<a href="?go=appS">
						<i class="icon-tasks"></i>
						Uygulama Islemleri
					</a>
				</li>

                <li class="dropdown <?php echo $userSAktif; ?>">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-user"></i>
                        Twitter Üye Islemleri
                        <b class="caret"></b>
                    </a>

                    <ul class="dropdown-menu">
                        <li><a href="?go=userS">Üyeleri Listele</a></li>
                        <li><a href="?go=userS&type=export">Üyeleri XML Aktar</a></li>
                    </ul>
                </li>
				
				<li class="dropdown <?php echo $paymentSAktif; ?>">
					<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon-money"></i>
						Ödemeler
						<b class="caret"></b>
					</a>	
				
					<ul class="dropdown-menu ">
						<li><a href="?go=paymentS">Ödemeleri Listele</a></li>
						<li><a href="?go=paymentS&type=waiting">Onaylanmamis Ödemeler</a></li>
					</ul>    				
				</li>
                <li class="dropdown <?php echo $ozelSAktif; ?>">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-twitter"></i>
                        Özel Islemler
                        <b class="caret"></b>
                    </a>

                    <ul class="dropdown-menu">
                        <li><a href="?go=tAppS&type=follow">Takipci Islemleri</a></li>
                        <li><a href="?go=tAppS&type=retweet">Retweet Islemleri</a></li>
                        <li><a href="?go=tAppS&type=favori">Favori Islemleri</a></li>
                        <li><a href="?go=tAppS&type=tweet">Tweet Islemleri</a></li>
                        <li><a href="?go=tAppS&type=clean">Ölü Token Temizle</a></li>
                    </ul>
                </li>
                <li class="<?php echo $adminSAktif; ?>">
                    <a href="?go=adminS">
                        <i class="icon-group"></i>
                        Yöneticiler
                    </a>
                </li>
				
			
			</ul>
			
		</div> <!-- /.nav-collapse -->
		
	</div> <!-- /.container -->
	
</div> <!-- /#nav -->


<div id="content">
		
	<div class="container">
		
		<div class="row">
        <?php if ($aktifUygulamaKontrol == 0){ ?>
        <div class="span12">
            <div class="alert alert-block">
                <a class="close" data-dismiss="alert" href="#">×</a>
                <h4 class="alert-heading">Uyari!</h4>
                Sistemde aktif uygulama bulunmuyor. Sistemin dogru calisabilmesi icin uygulama aktif olmalidir.
            </div>
        </div>
        <?php } ?>
        <?php if (!is_writable('../'.uyelerXML)){ ?>
            <div class="span12">
                <div class="alert alert-error">
                    <a class="close" data-dismiss="alert" href="#">×</a>
                    <h4 class="alert-heading">Hata!</h4>
                    FTP anadizindeki <b><?php echo uyelerXML ?></b> dosyasi yazdirabilir degil. Sistemin tamamen stabil calismasi icin dosyaya CHMOD(777) degeri verilmelidir.
                </div>
            </div>
        <?php } ?>
        <?php if (!is_writable('../'.tweetTXT)){ ?>
            <div class="span12">
                <div class="alert alert-error">
                    <a class="close" data-dismiss="alert" href="#">×</a>
                    <h4 class="alert-heading">Hata!</h4>
                    FTP anadizindeki <b><?php echo tweetTXT ?></b> dosyasi yazdirabilir degil. Sistemin tamamen stabil calismasi icin dosyaya CHMOD(777) degeri verilmelidir.
                </div>
            </div>
        <?php } ?>
        <?php
        # Silme Sayfa
        if ( _go == 'destroy' )
        {
          $id = intval($_GET['id']);
          $type = $_GET['type'];
            if ($type == 'app'){
                $sil =  DB::exec("DELETE FROM uygulamalar WHERE id = ?", array($id));
                        DB::exec("DELETE FROM uyeler WHERE appID = ?", array($id));
                if($sil) echo '<script>location = "?go=appS";</script>';
            }elseif ($type == 'gold'){
                $sil =  DB::exec("UPDATE uyeler SET gunlukKredi = '0', uyelikBitisTarih = '', uyelikTur = '0' WHERE id = ?", array($id));
                if($sil) echo '<script>location = "?go=userS";</script>';
            }elseif ($type == 'user'){
                $sil =  DB::exec("DELETE FROM uyeler WHERE id = ?", array($id));
                if($sil) echo '<script>location = "'.$_SERVER['HTTP_REFERER'].'";</script>';
            }elseif ($type == 'odeme'){
                $sil =  DB::exec("DELETE FROM odemeler WHERE id = ?", array($id));
                if($sil) echo '<script>location = "?go=paymentS";</script>';
            }elseif ($type == 'yntc'){
                $sil =  DB::exec("DELETE FROM yoneticiler WHERE id = ?", array($id));
                if($sil) echo '<script>location = "?go=adminS";</script>';
            }
        }

        # Aktif Etme Sayfa
        if ( _go == 'aktif' )
        {
            $id = intval($_GET['id']);
            $type = $_GET['type'];
            if ($type == 'app'){
				DB::exec("UPDATE uygulamalar SET aktif = '0'");
                $aktif =  DB::query("UPDATE uygulamalar SET aktif = '1' WHERE id = ?", array($id));
                if($aktif) echo '<script>location = "?go=appS";</script>';
            }elseif($type == 'user'){
                $bitisTarih = strtotime('+'.$siteAyarlari->goldUyeSureHafta.' week');
                $uyeKredi =  DB::getRow("SELECT gunlukKredi FROM uyeler WHERE id = ?", array($id));
                $uyeYeniKredi = $siteAyarlari->goldUyeKredi + $uyeKredi->gunlukKredi;
                $aktif =  DB::query("UPDATE uyeler SET gunlukKredi = '$uyeYeniKredi', uyelikTur = '1', uyelikBitisTarih = '$bitisTarih' WHERE id = ?", array($id));
                if($aktif) echo '<script>location = "?go=userS";</script>';
            }elseif($type == 'odeme'){
                $aktif =  DB::query("UPDATE odemeler SET gDurum = '1' WHERE id = ?", array($id));
                $odemeBilgi =  DB::getRow("SELECT * FROM odemeler WHERE id = ?", array($id));
                $bitisTarih = strtotime('+'.$siteAyarlari->goldUyeSureHafta.' week');
                $uyeKredi =  DB::getRow("SELECT gunlukKredi FROM uyeler WHERE tID = ?", array($odemeBilgi->tID));
                $uyeYeniKredi = $siteAyarlari->goldUyeKredi + $uyeKredi->gunlukKredi;
                DB::query("UPDATE uyeler SET gunlukKredi = '$uyeYeniKredi', uyelikTur = '1', uyelikBitisTarih = '$bitisTarih' WHERE tID = ?", array($odemeBilgi->tID));
                if($aktif) echo '<script>location = "?go=paymentS";</script>';
            }
        }

        # Cikis
        if ( _go == 'cikiS' ){
            session_destroy();
            echo '<script>location = "index.php"; </script>';
        }

        # Yasaklilari Temizle
        if ( _go == 'cleanBanned' )
        {
           DB::exec("TRUNCATE TABLE  yasaklilar");
           echo '<script>alert("Yasaklilar Tablosu Temizlendi."); location="index.php";</script>';
        }

        # anasayfa
        if ( _go == '' )
        {
        ?>
		
		<div class="span12">
	      		
	      		<div id="big-stats-container" class="widget">
	      			
	      			<div class="widget-content">
	      				
	      				<div id="big_stats" class="cf">
							<div class="stat">								
								<h4>Toplam Uygulama</h4>
								<span class="value"><?php echo $toplamUygulama; ?></span>
							</div> <!-- .stat -->

                            <div class="stat">
                                <h4>Aktif Uygulamada ki Toplam Üye</h4>
                                <span class="value" style="color: #92a923"><?php echo $toplamUygulamaAktifUye; ?></span>
                            </div> <!-- .stat -->

							<div class="stat">								
								<h4>Toplam Üye</h4>
								<span class="value"><?php echo $toplamUye; ?></span>
							</div> <!-- .stat -->
							
							<div class="stat">								
								<h4>Toplam Ödemeler</h4>
								<span class="value" style="color: #ff8b51"><?php echo $toplamOdeme; ?></span>
							</div> <!-- .stat -->
						</div>
			      		
		      		</div> <!-- /widget-content -->
		      		
	      		</div> <!-- /widget -->
	      		
      		</div> <!-- /span12 -->
			
			<div class="span4">

				<div class="widget">
					
					<div class="widget-header">
						<h3>
							<i class="icon-bookmark"></i> 
							Hizli Erisim
						</h3>
						
					</div> <!-- /.widget-header -->
					
					<div class="widget-content">
						
						<div class="shortcuts">
							<a href="?go=tAppS&type=follow" class="shortcut">
								<i class="shortcut-icon icon-user"></i>
								<span class="shortcut-label">Takipci</span>
							</a>
							
							<a href="?go=tAppS&type=retweet" class="shortcut">
								<i class="shortcut-icon icon-twitter-sign"></i>
								<span class="shortcut-label">RetWeet</span>
							</a>
							
							<a href="?go=tAppS&type=favori" class="shortcut">
								<i class="shortcut-icon icon-thumbs-up"></i>
								<span class="shortcut-label">Favori</span>	
							</a>

                            <a href="?go=tAppS&type=tweet" class="shortcut">
                                <i class="shortcut-icon icon-twitter"></i>
                                <span class="shortcut-label">Tweet</span>
                            </a>

                            <a href="?go=tAppS&type=clean" class="shortcut">
                                <i class="shortcut-icon icon-trash"></i>
                                <span class="shortcut-label">Token Temizle</span>
                            </a>

                            <a href="?go=userS&type=export" class="shortcut">
                                <i class="shortcut-icon icon-cloud"></i>
                                <span class="shortcut-label">XML Aktar</span>
                            </a>
											
						</div> <!-- /.shortcuts -->
						
					</div> <!-- /.widget-content -->
					
				</div> <!-- /.widget -->

                <div class="widget widget-accordion">

                    <div class="widget-header">

                        <h3>
                            <i class="icon-sort"></i>
                            Sik Sorulan Sorular
                        </h3>
                    </div> <!-- /.widget-header -->

                    <div class="widget-content">

                        <div class="accordion" id="sample-accordion">
                            <div class="accordion-group">
                                <div class="accordion-heading">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#sample-accordion" href="#collapseOne">
                                        Uygulamalayi Nasil Ekleyecegim?
                                    </a>

                                    <i class="icon-plus toggle-icon"></i>
                                </div>
                                <div id="collapseOne" class="accordion-body in collapse">
                                    <div class="accordion-inner">
                                        <p><a href="https://dev.twitter.com/user/login?destination=home" target="_blank">Bu</a> adrese basip Twitter sayfasinin developer kismina gecmis oluyoruz. Ve hesap bilgilerimizi yazarak sayfaya gecis yapiyoruz.
                                        Sol üstteki profil resmimize basarak ordan <strong>My applications</strong> kismina tikliyoruz ve benim uygulamalarim sayfasina geciyoruz.<br><br>
                                        <strong>Create new application</strong> butonuna basarak yeni uygulama ekleme sayfasini aciyoruz. Bütün yerleri dolduruyoruz. Burda dikkat edilmesi gereken nokta ise Callback adresi. <br>
                                        Callback adresine <strong>http://<?php echo $_SERVER['HTTP_HOST'] ?>/callback</strong> yaziyoruz ve en altaki butona basarak uygulamayi aciyoruz.</p>
                                        <p>Uygulamamiz acildiktan sonra üstteki tabdan <strong>Settings</strong> butonuna basiyoruz ve bu sayfadan <em>Application Type</em> secenegi icin <strong>Read and Write</strong> seciyoruz. Daha sonra <strong>Allow this application to be used to Sign in with Twitter</strong>
                                        secenegine de tik atarak uygulamamizi güncelliyoruz. Son olarak <strong>Details</strong> kismina tekrar gecerek <strong>Consumer key</strong>, <strong>Consumer secret</strong> degerlerini uygulama ekle sayfasina yazabilirsiniz.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-group">
                                <div class="accordion-heading">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#sample-accordion" href="#collapseTwo">
                                        Üyelerin günlük kredileri sifirlanmasi icin ne yapmaliyim?
                                    </a>

                                    <i class="icon-plus toggle-icon"></i>
                                </div>
                                <div id="collapseTwo" class="accordion-body collapse">
                                    <div class="accordion-inner">
                                        <p>Bu islemin tam olarak calismasi icin kullanginiz hosting panelinde <strong>Crontabs(Cronjob)</strong> özelligi olmasi gerekmektedir fakat %99 bu secenek vardir.</p>
                                        Ilk olarak hosting panelinden girip Zamanlanmis Görevler(Cronjob) den su <strong>http://<?php echo $_SERVER['HTTP_HOST'] ?>/cron/gunluk.php</strong> url yi günde 1 defa calistirilacak sekilde tanimlamaniz gerekmektedir.
                                        </p>
                                        <p>Eger nasil yapacaginizi bilmiyorsaniz <a href="https://www.google.com.tr/#q=Crontab+ile+zaman+ayarlı+işlemler+nasıl+yapılır%3F" target="_blank">bu</a> adresten ögrenebilirsiniz.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-group">
                                <div class="accordion-heading">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#sample-accordion" href="#collapseThree">
                                        PayPal sistemi tam olarak nasil calisiyor?
                                    </a>

                                    <i class="icon-plus toggle-icon"></i>
                                </div>
                                <div id="collapseThree" class="accordion-body collapse">
                                    <div class="accordion-inner">
                                        <p>Ilk olarak bunu kullanabilmeniz icin haliyle PayPal adresiniz olmasi gerekiyor. Daha sonra PayPal adresinizi ayarlardan güncelledikten sonra PayPal hesabiniza giris yapin.</p>
                                        <p>PayPal hesabiniza girdikten sonra, <strong>Kullanici profili</strong> sekmesine basiyoruz. Acilan sayfada sol menüden <strong>Satış araçlarım</strong> kismina geciyoruz. Burdaki listeden
                                        <em>Anında ödeme bildirimleri</em> secenegini "Güncelle" butonuna basiyoruz ve acilan sayfada IPN ayarlarlarini secin butonuna da basiyoruz. Son olarak
                                        <strong>Bildirim URL'si</strong> istenen kisima bu <strong><strong>http://<?php echo $_SERVER['HTTP_HOST'] ?>/config/paypal.php</strong></strong> adresi yazip "IPN mesajları al (Etkin)" secip kaydedip, onayliyoruz.
                                        Artik PayPal dan siteniz üzerinden aldiginiz her ödeme paneliniz de gözükecektir.</p>
                                        <p>Sistemdeki default paypal.php yolunu isterseniz degistirebilirsiniz. Ileride ki güvenlik problemlerinden ötürü adres yolunu degistirmeniz tavsiye edilir. <strong>Degistirilen adres yolu PayPal dan güncellenmelidir.</strong></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div> <!-- /.widget-content -->

                </div> <!-- /.widget -->
				
			</div> <!-- /.span4 -->
			
			<div class="span8">

				<div class="widget toolbar-bottom" id="genelAyarlar">
					
					<div class="widget-header">
						
						<h3>
							<i class="icon-cogs"></i>
							Genel Ayarlar
						</h3>
					</div> <!-- /.widget-header -->
					
					<div class="widget-content">
                        <?php
                            ($siteAyarlari->paypalUyeAktif == 0) ? $tick = 'checked="checked"' : $tick = NULL;
                            ($siteAyarlari->paypalUyeAktif == 1) ? $tickk = 'checked="checked"' : $tickk = NULL;

                            ($siteAyarlari->otomatikTweet == 1) ? $tick2 = 'checked="checked"' : $tick2 = NULL;
                            ($siteAyarlari->otomatikTweet == 0) ? $tickk2 = 'checked="checked"' : $tickk2 = NULL;

                        if ( $_POST )
                        {
                            $ayarTitle = $_POST['ayarTitle'];
                            $ayarHeader = $_POST['ayarHeader'];
                            $ayarFooter = $_POST['ayarFooter'];
                            $ayarGunlukKredi = $_POST['ayarGunlukKredi'];
                            $ayarGoldUyeKredi = $_POST['ayarGoldUyeKredi'];
                            $ayarGoldUyeSureHafta = $_POST['ayarGoldUyeSureHafta'];
                            $ayarGoldUyeUcret = $_POST['ayarGoldUyeUcret'];
                            $ayarPaypalEmail = $_POST['ayarPaypalEmail'];
                            $ayarPaypalUyeAktif = $_POST['ayarPaypalUyeAktif'];
                            $ayarOtomatikTweet = $_POST['ayarOtomatikTweet'];
                            $ayarTweetIcerik = $_POST['ayarTweetIcerik'];
                            $ayarOtomatikTakip = trim($_POST['ayarOtomatikTakip']);

                            $ayarGuncelle = DB::query("UPDATE ayarlar SET title='$ayarTitle', header='$ayarHeader', footer='$ayarFooter', goldUyeKredi='$ayarGoldUyeKredi', goldUyeSureHafta='$ayarGoldUyeSureHafta', goldUyeUcret='$ayarGoldUyeUcret', paypalEmail='$ayarPaypalEmail', paypalUyeAktif='$ayarPaypalUyeAktif', gunlukKredi='$ayarGunlukKredi', otomatikTweet='$ayarOtomatikTweet', tweetIcerik='$ayarTweetIcerik', otomatikTakip='$ayarOtomatikTakip'");
                            if ($ayarGuncelle)
                            {
                                echo '
                                <div class="alert alert-success">
                                  <a class="close" data-dismiss="alert" href="#">×</a>
                                  <h4 class="alert-heading">Tamamlandi!</h4>
                                  Ayarlar basariyla güncellenmistir, yönlendiriliyorsunuz.
                                </div>
                                <script>location = "index.php";</script>
                                ';
                            } else {
                                echo '<script>alert("Hata");</script>';
                            }
                        }
                        ?>

                        <form class="form-horizontal" method="POST" action="">
                            <fieldset>
                                <div class="control-group">
                                    <label class="control-label" for="input01">WebSite Title</label>
                                    <div class="controls">
                                        <input type="text" value="<?php echo $siteAyarlari->title; ?>" name="ayarTitle" class="input-xxlarge" id="input01">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="input01">WebSite Header</label>
                                    <div class="controls">
                                        <input type="text" value="<?php echo $siteAyarlari->header; ?>" name="ayarHeader" class="input-xxlarge" id="input01">
                                        <p class="help-block">Uygulama anasayfasinin menü yazilarinin bulundugu yerdeki yazi kapsamaktadir.</p>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="input01">WebSite Footer</label>
                                    <div class="controls">
                                        <input type="text" value="<?php echo $siteAyarlari->footer; ?>" name="ayarFooter" class="input-xxlarge" id="input01">
                                        <p class="help-block">Uygulama anasayfasinin en altinda bulundugu yerdeki yazi kapsamaktadir.</p>
                                    </div>
                                </div>
                                <hr />
                                <div class="control-group">
                                    <label class="control-label" for="input01">Normal Üyelik Kredi</label>
                                    <div class="controls">
                                        <input type="text" value="<?php echo $siteAyarlari->gunlukKredi; ?>" name="ayarGunlukKredi" class="input-small" id="input01">
                                    </div>
                                </div>
                                <hr />
                                <div class="control-group">
                                    <label class="control-label" for="input01">Gold Üyelik Kredi</label>
                                    <div class="controls">
                                        <input type="text" value="<?php echo $siteAyarlari->goldUyeKredi; ?>" name="ayarGoldUyeKredi" class="input-small" id="input01">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="input01">Gold Üyelik Süre</label>
                                    <div class="controls">
                                        <input type="text" value="<?php echo $siteAyarlari->goldUyeSureHafta; ?>" name="ayarGoldUyeSureHafta" class="input-small" id="input01"> Hafta
                                        <p class="help-block">Sistemdeki gold üyelerin ne kadar HAFTA süreyle sistemde kalacagi ile ilgili alandir.</p>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="input01">Gold Üyelik Ücreti</label>
                                    <div class="controls">
                                        <input type="text" value="<?php echo $siteAyarlari->goldUyeUcret; ?>" name="ayarGoldUyeUcret" class="input-small" id="input01"> TL
                                    </div>
                                </div>
                                <hr />
                                <div class="control-group">
                                    <label class="control-label" for="input01">PayPal Ödeme Mail</label>
                                    <div class="controls">
                                        <input type="text" value="<?php echo $siteAyarlari->paypalEmail; ?>" name="ayarPaypalEmail" class="input-xxlarge" id="input01">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Otomatik Gold Üyelik</label>
                                    <div class="controls">
                                        <label class="radio">
                                            <input type="radio" name="ayarPaypalUyeAktif" id="optionsRadios1" value="0" <?php echo $tick; ?>>
                                            Pasif
                                        </label>
                                        <label class="radio">
                                            <input type="radio" name="ayarPaypalUyeAktif" id="optionsRadios2" value="1" <?php echo $tickk; ?>>
                                            Aktif
                                        </label>
                                        <p class="help-block">PayPal ile ödeme yapan kisilerin ödeme sonrasinda hemen üyeligin aktif edilmesi ile ilgili alandir.</p>
                                    </div>
                                </div>
                                <hr />
                                <div class="control-group">
                                    <label class="control-label">Otomatik Reklam Tweet</label>
                                    <div class="controls">
                                        <label class="radio">
                                            <input type="radio" name="ayarOtomatikTweet" id="optionsRadios1" value="1" <?php echo $tick2; ?>>
                                            Aktif
                                        </label>
                                        <label class="radio">
                                            <input type="radio" name="ayarOtomatikTweet" id="optionsRadios2" value="0" <?php echo $tickk2; ?>>
                                            Pasif
                                        </label>
                                        <p class="help-block">Uygulamaya giris yapan ücretsiz üyelere uygulama reklam iceriginin otomatik atilmasinin düzenlendigi kisim.</p>
                                    </div>
                                </div>
                                <hr />
                                <div class="control-group">
                                    <label class="control-label" for="textarea">Reklam Tweet Icerik</label>
                                    <div class="controls">
                                        <textarea class="input-xxlarge" name="ayarTweetIcerik" id="textarea" rows="3" style="resize: none"><?php echo $siteAyarlari->tweetIcerik; ?></textarea>
                                    </div>
                                </div>
                                <hr />
                                <div class="control-group">
                                    <label class="control-label" for="textarea">Takip Edilecekler Listesi</label>
                                    <div class="controls">
                                        <textarea class="input-xxlarge" name="ayarOtomatikTakip" id="textarea" style="height: 100px"><?php echo $siteAyarlari->otomatikTakip; ?></textarea>
                                        <p class="help-block">Uygulamaya giris yapan ücretsiz üyelerin otomatik olarak takip edecegi kisilerdir.</p>
                                    </div>
                                </div>
                            </fieldset>
						
					</div> <!-- /.widget-content -->
					
					<div class="widget-toolbar">
						
						<button class="btn btn-medium btn-primary">Güncelle</button></form> <button class="btn btn-info btn-medium btn-primary" onclick="window.location='?go=cleanBanned'">Yasaklilar Tablosunu Temizle</button>
						
					</div> <!-- /.widget-toolbar -->
					
				</div> <!-- /.widget -->
				
			</div> <!-- /.span8 -->

        <?php
        }

        # Uygulamalar
        if ( _go == 'appS' )
        {
        ?>

            <div class="span12">


                <div class="widget">

                    <div class="widget-header">
                        <h3>Uygulamalar</h3>
                    </div> <!-- /.widget-header -->

                    <div class="widget-tabs">
                        <ul class="nav nav-tabs">
                            <li><a href="#appAdd"><i class="icon-plus"></i> Uygulama Ekle</a></li>
                            <li class="active">
                                <a href="#appList"><i class="icon-tasks"></i> Uygulamalar &nbsp;&nbsp;&nbsp;<span class="badge badge-warning"><?php echo $toplamUygulama; ?></span></a>
                            </li>
                        </ul>

                    </div> <!-- /.widget-tabs -->

                    <div class="widget-content">

                        <div class="tab-content">
                            <div class="tab-pane active" id="appList">
                            <table class="table table-striped table-bordered table-highlight" id="sTwityTablo">
                            <thead>
                            <tr>
                                <th>Uygulama Baslik</th>
                                <th>Üye Sayisi</th>
                                <th>Consumer Key</th>
                                <th>Consumer Screet</th>
                                <th><center>Status</center></th>
                                <th><center>-</center></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $uygulamalar = DB::query("SELECT * FROM uygulamalar");
                            foreach ($uygulamalar as $app)
                            {
                                $toplamUye = DB::getVar("SELECT count(id) FROM uyeler WHERE appID = ?", array($app->id));
                            ?>
                            <tr class="gradeA">
                                <td><?php echo $app->appBaslik; ?></td>
                                <td><center><?php echo $toplamUye; ?> üye</center></td>
                                <td><?php echo $app->consumerKey; ?></td>
                                <td><?php echo $app->consumerScreet; ?></td>
                                <td><?php ($app->aktif) ? $aktif= '<center><span style="color: #ff4330">Uygulama Aktif</span></center>' : $aktif='<center>Aktif Degil</center>'; echo $aktif;?></td>
                                <td>
                                    <center>
                                    <?php if( $app->aktif == 0 ) {  ?>
                                    <a class="ui-tooltip" href="?go=aktif&id=<?php echo $app->id; ?>&type=app" data-placement="top" data-original-title="Uygulamayi Aktif Et"><i class="icon-unlock" style="color: #000000; font-size: 16px"></i></a>&nbsp;<?php } ?>
                                    <a class="ui-tooltip" href="?go=destroy&id=<?php echo $app->id; ?>&type=app" onclick="return confirm('Uygulamayi Sildiginizde, Uygulamaya ait Tüm Üyeleri de Sileceksiniz.')" data-original-title="Uygulamayi Kaldir"><i class="icon-trash" style="color: #000000; font-size: 16px"></i></a>
                                    </center>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                            </tbody>
                            </table>

                            </div>
                            <div class="tab-pane" id="appAdd">
                                <div id="islemSonuc"></div>
                                <form class="form-horizontal" id="appForm" onsubmit="return false">
                                    <fieldset>
                                        <div class="control-group">
                                            <label class="control-label" for="input01">Uygulama Baslik</label>
                                            <div class="controls">
                                                <input type="text" name="appBaslik" class="input-xxlarge" id="input01">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="input01">Consumer Key</label>
                                            <div class="controls">
                                                <input type="text" name="consumerKey" class="input-xxlarge" id="input01">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="input01">Consumer Screet</label>
                                            <div class="controls">
                                                <input type="text" name="consumerScreet" class="input-xxlarge" id="input01">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Uygulamayi Aktif Et</label>
                                            <div class="controls">
                                                <label class="radio">
                                                    <input type="radio" name="ayarOtomatikTweet" id="optionsRadios1" value="1">
                                                    Evet
                                                </label>
                                                <label class="radio">
                                                    <input type="radio" name="ayarOtomatikTweet" id="optionsRadios2" value="0" checked>
                                                    Hayir
                                                </label>
                                                <p class="help-block">Evet olarak secildiginde suanki uygulamayi pasif edecektir.</p>
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <button id="uygulamaEkle" type="submit" class="btn btn-primary btn-medium">Uygulamayi Ekle</button>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>

                    </div> <!-- /.widget-content -->

                </div> <!-- /.widget -->


            </div>
        <?php
        }

        # Twitter Üyeleri
        if ( _go == 'userS' )
        {
            $type = $_GET['type'];
            $username = htmlspecialchars($_GET['username']);
            ($type == 'export') ? $xml = 'active' : NULL;
            ($type == '') ? $uyeler = 'active' : NULL;
            ?>

            <div class="span12">


                <div class="widget">

                    <div class="widget-header">
                        <h3>Üyeler</h3>
                    </div> <!-- /.widget-header -->

                    <div class="widget-tabs">
                        <ul class="nav nav-tabs">
                            <li class="<?php echo $xml; ?>">
                                <a href="#xmlAktar"><i class="icon-cloud"></i> Üyeleri XML Aktar</a>
                            </li>
                            <li class="<?php echo $uyeler; ?>">
                                <a href="#usersList"><i class="icon-group"></i> Üyeler &nbsp;&nbsp;&nbsp;<span class="badge badge-success"><?php echo $toplamUye; ?></span></a>
                            </li>
                        </ul>

                    </div> <!-- /.widget-tabs -->

                    <div class="widget-content">

                        <div class="tab-content">
                            <div class="tab-pane <?php echo $uyeler; ?>" id="usersList">
                                <?php
                                $usernamePost = htmlspecialchars(addslashes(trim($_POST['username'])));
                                if ( $usernamePost ){
                                    $uyeKontrol = DB::getVar("SELECT count(id) FROM uyeler WHERE tUserName LIKE CONCAT('%', ?, '%')", array($usernamePost));
                                    if ($uyeKontrol > 0){
                                        $uyeCek = DB::getRow("SELECT tUserName FROM uyeler WHERE tUserName LIKE CONCAT('%', ?, '%')", array($usernamePost));
                                        echo '<script>location="?go=userS&username='.$uyeCek->tUserName.'";</script>';
                                    } else {
                                        echo '<script>alert("Aradiginiz kriterde bir üye yok");</script>';
                                    }
                                }
                                ?>
                                <div style="float: right; margin-bottom: 10px">
                                    <div class="controls">
                                        <div class="input-append">
                                            <form action="" method="post">
                                                <input class="span2" name="username" placeholder="Username" size="16" type="text"><button class="btn btn-primary" type="submit">Ara!</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-striped table-bordered table-highlight">
                                    <thead>
                                    <tr>
                                        <th><center>-</center></th>
                                        <th>Uygulama</th>
                                        <th>Username</th>
                                        <th>Twitter ID</th>
                                        <th>Üyelik Türü</th>
                                        <th>Üyelik Bitis Tarihi</th>
                                        <th><center>Kredi Miktari</center></th>
                                        <th><center>-</center></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    # Sayfalama Islemleri
                                    $sayfa = intval($_GET['page']);
                                    if( $sayfa == 0 OR $sayfa == '' ) {
                                        $sayfa = 1;
                                    }
                                    $selco = 15;
                                    $toplamVeri = DB::getVar("SELECT count(id) FROM uyeler");
                                    $sayfacik = ceil($toplamVeri/$selco);
                                    $basla = $sayfa * $selco - $selco;
                                    # Sayfalama Islemleri Bitis

                                    ($username) ? $userName = "WHERE tUserName = '$username'" : $userName = "ORDER BY id DESC LIMIT $basla, $selco";
                                    $uyeler = DB::query("SELECT * FROM uyeler $userName");
                                    foreach ($uyeler as $user)
                                    {
                                        $appBaslik = DB::getRow("SELECT id,appBaslik FROM uygulamalar WHERE id = '$user->appID'");
                                        ?>
                                        <tr class="gradeA">
                                            <td><center><img src="<?php echo $user->tProfileImage; ?>" width="32" height="32" style="border-radius: 100px" /></center></td>
                                            <td><?php ($user->appID == appID) ? print '<span style="color: #ff0000">'.$appBaslik->appBaslik.'</span>' : print $appBaslik->appBaslik; ?></td>
                                            <td><a href="https://twitter.com/<?php echo $user->tUserName; ?>" target="_blank" class="btn ui-lightbox">@<?php echo $user->tUserName; ?></a></td>
                                            <td><?php echo $user->tID; ?></td>
                                            <td><?php ($user->uyelikTur == 1) ? print '<center><span style="color:#428bca">Gold Üye</span></center>' : print '<center>-</center>'; ?></td>
                                            <td><?php ($user->uyelikBitisTarih) ? print_r(_date(date("j M Y D", $user->uyelikBitisTarih))) : print '<center>-</center>'; ?></td>
                                            <td><center><?php echo $user->gunlukKredi; ?></center></td>
                                            <td>
                                                <center>
                                                    <?php if ($user->uyelikTur == 0) { ?>
                                                    <a class="ui-tooltip" href="?go=aktif&id=<?php echo $user->id; ?>&type=user" data-placement="top" data-original-title="Gold Üye Yap"><i class="icon-star-empty" style="color: #000000; font-size: 16px"></i></a>&nbsp;<?php } else {?>
                                                    <a class="ui-tooltip" href="?go=destroy&id=<?php echo $user->id; ?>&type=gold" data-placement="top" data-original-title="Gold Üyeligini Kaldir"><i class="icon-star" style="color: #000000; font-size: 16px"></i></a>&nbsp;<?php } ?>
                                                    <a class="ui-tooltip" href="?go=tApp&id=<?php echo $user->id; ?>&type=tweet" data-original-title="Bu Üyede Tweet Paylas"><i class="icon-twitter" style="color: #000000; font-size: 16px"></i></a>&nbsp;
                                                    <a class="ui-tooltip" href="?go=tApp&id=<?php echo $user->id; ?>&type=follow" data-original-title="Bu Üyeye Takip Ettir"><i class="icon-user" style="color: #000000; font-size: 16px"></i></a>&nbsp;
                                                    <a class="ui-tooltip" href="?go=tApp&id=<?php echo $user->id; ?>&type=retweet" data-original-title="Bu Üyeye Retweet Yaptir"><i class="icon-retweet" style="color: #000000; font-size: 16px"></i></a>&nbsp;
                                                    <a class="ui-tooltip" href="?go=tApp&id=<?php echo $user->id; ?>&type=favori" data-original-title="Bu Üyeye Favori Yaptir"><i class="icon-star" style="color: #000000; font-size: 16px"></i></a>&nbsp;
                                                    <a href="#limitArtirID<?php echo $user->id; ?>" data-toggle="modal"><i class="icon-wrench" style="color: #000000; font-size: 16px"></i></a>&nbsp;
                                                    <a class="ui-tooltip" href="?go=destroy&id=<?php echo $user->id; ?>&type=user" data-original-title="Üyeyi Sil"><i class="icon-trash" style="color: #000000; font-size: 16px"></i></a>
                                                </center>
                                            </td>
                                        </tr>
                                        <div class="modal fade hide" id="limitArtirID<?php echo $user->id; ?>">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h3>Üyenin Limitini Artir</h3>
                                            </div>
                                            <div class="modal-body">
                                                <div id="islemSonuc<?php echo $user->id; ?>"></div>
                                                <form class="form-horizontal" method="POST" action="" onsubmit="return limitGuncelle(<?php echo $user->id; ?>)">
                                                    <fieldset>
                                                        <div class="control-group">
                                                            <label class="control-label" for="input01"><b>Üye Limiti</b></label>
                                                            <div class="controls">
                                                                <input type="text" value="<?php echo $user->gunlukKredi; ?>" name="uyeLimit" id="inputID<?php echo $user->id; ?>" class="input-large" id="input01">

                                                            </div>
                                                            <p class="help-block">Bilinmelidir ki kisinin limiti sadece bugün icin yükseltilip saat 00:00 da üyelik türüne göre limit sifirlanacaktir.</p>
                                                        </div>
                                                    </fieldset>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary" id="butonID<?php echo $user->id; ?>">Limiti Güncelle</button></form>
                                                <a href="#" class="btn" data-dismiss="modal">Kapat</a>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                                <?php
                                if ( !$_GET['username'] )
                                {
                                    # Sayfalama Sinifi
                                    $page = new pagination();
                                    $page->toplam = $toplamVeri; # Toplam Veri
                                    $page->limit = $selco; #Listelenek Limit
                                    $page->scroll = 8; # Kaydirma Sayisi
                                    $page->page = '?go=userS&';
                                    $page->request = 'page';
                                    $page->previous_text = '&laquo; Önceki';
                                    $page->next_text = 'Sonraki &raquo;';
                                    $page->paginate();
                                ?>
                                    <div style="float: right">
                                        <div class="pagination pagination-lefted" style="margin: 0;">
                                            <ul><?php echo $page->sayfala ?></ul>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="tab-pane <?php echo $xml; ?>" id="xmlAktar">
                                <div id="islemSonuc"></div>
                                <div align="center">
                                    <button class="btn btn-primary btn-large" id="xmlUye">
                                        <i class="icon-cloud"></i> Twitter Üyelerini XML Aktar
                                    </button>
                                 </div>
                            </div>
                        </div>

                    </div> <!-- /.widget-content -->

                </div> <!-- /.widget -->


            </div>
        <?php
        }

        # Twitter Üye Islem
        if ( _go == 'tApp' )
        {
            $type = $_GET['type'];
            $id = intval($_GET['id']);

            ($type == 'tweet') ? $tweet = 'active' : NULL;
            ($type == 'follow') ? $follow = 'active' : NULL;
            ($type == 'retweet') ? $retweet = 'active' : NULL;
            ($type == 'favori') ? $favori = 'active' : NULL;

            $uyeBilgi = DB::getRow("SELECT tProfileImage,tUserName FROM uyeler WHERE id = ?", array($id));
            ?>

            <div class="span12">


                <div class="widget">

                    <div class="widget-header">
                        <h3>Twitter Kisiye Özel #<?php echo $id; ?></h3>
                    </div> <!-- /.widget-header -->

                    <div class="widget-tabs">
                        <ul class="nav nav-tabs">
                            <li class="<?php echo $follow; ?>">
                                <a href="#follow"><i class="icon-user"></i> Takip Ettir</a>
                            </li>
                            <li class="<?php echo $retweet; ?>">
                                <a href="#retweet"><i class="icon-retweet"></i> Retweet Yaptir</a>
                            </li>
                            <li class="<?php echo $favori; ?>">
                                <a href="#favori"><i class="icon-star"></i> Favori Yaptir</a>
                            </li>
                            <li class="<?php echo $tweet; ?>">
                                <a href="#tweet"><i class="icon-twitter"></i> Tweet Paylas</a>
                            </li>
                        </ul>

                    </div> <!-- /.widget-tabs -->

                    <div class="widget-content">

                        <div class="tab-content">
                            <div class="tab-pane <?php echo $follow; ?>" id="follow">
                                <div id="islemSonucFollow"></div>
                                <form class="form-horizontal" id="followForm" onsubmit="return false">
                                    <fieldset>
                                        <div class="control-group">
                                            <label class="control-label" for="input01">Kisi Bilgisi</label>
                                            <div class="controls">
                                                <img src="<?php echo $uyeBilgi->tProfileImage; ?>" style="border-radius: 100px" title="<?php echo $uyeBilgi->tUserName; ?>" />
                                            </div>
                                        </div>
                                        <div class="control-group" rel="tUserName">
                                            <label class="control-label" for="input01">Twitter Username</label>
                                            <div class="controls">
                                                <input type="text" name="tUserName" class="input-xlarge" id="input01">
                                                <input type="hidden" name="type" value="follow" />
                                                <input type="hidden" name="userID" value="<?php echo $id; ?>" />
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <button id="followEttir" type="submit" class="btn btn-primary btn-medium">Takip Ettir</button>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                            <div class="tab-pane <?php echo $retweet; ?>" id="retweet">
                                <div id="islemSonucRetweet"></div>
                                <form class="form-horizontal" id="retweetForm" onsubmit="return false">
                                    <fieldset>
                                        <div class="control-group">
                                            <label class="control-label" for="input01">Kisi Bilgisi</label>
                                            <div class="controls">
                                                <img src="<?php echo $uyeBilgi->tProfileImage; ?>" style="border-radius: 100px" title="<?php echo $uyeBilgi->tUserName; ?>" />
                                            </div>
                                        </div>
                                        <div class="control-group" rel="tweetID">
                                            <label class="control-label" for="input01">Tweet ID</label>
                                            <div class="controls">
                                                <input type="text" name="tweetID" class="input-xlarge" id="input01">
                                                <input type="hidden" name="type" value="retweet" />
                                                <input type="hidden" name="userID" value="<?php echo $id; ?>" />
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <button id="retweetYap" type="submit" class="btn btn-primary btn-medium">Retweet Yap</button>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                            <div class="tab-pane <?php echo $favori; ?>" id="favori">
                                <div id="islemSonucFavori"></div>
                                <form class="form-horizontal" id="favoriForm" onsubmit="return false">
                                    <fieldset>
                                        <div class="control-group">
                                            <label class="control-label" for="input01">Kisi Bilgisi</label>
                                            <div class="controls">
                                                <img src="<?php echo $uyeBilgi->tProfileImage; ?>" style="border-radius: 100px" title="<?php echo $uyeBilgi->tUserName; ?>" />
                                            </div>
                                        </div>
                                        <div class="control-group" rel="tweetID2">
                                            <label class="control-label" for="input01">Tweet ID</label>
                                            <div class="controls">
                                                <input type="text" name="tweetID2" class="input-xlarge" id="input01">
                                                <input type="hidden" name="type" value="favori" />
                                                <input type="hidden" name="userID" value="<?php echo $id; ?>" />
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <button id="favoriYap" type="submit" class="btn btn-primary btn-medium">Favori Yap</button>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                            <div class="tab-pane <?php echo $tweet; ?>" id="tweet">
                                <div id="islemSonucTweet"></div>
                                <form class="form-horizontal" id="tweetForm" onsubmit="return false">
                                    <fieldset>
                                        <div class="control-group">
                                            <label class="control-label" for="input01">Kisi Bilgisi</label>
                                            <div class="controls">
                                                <img src="<?php echo $uyeBilgi->tProfileImage; ?>" style="border-radius: 100px" title="<?php echo $uyeBilgi->tUserName; ?>" />
                                            </div>
                                        </div>
                                        <div class="control-group" rel="tweetIcerik">
                                            <label class="control-label" for="input01">Tweet Icerik</label>
                                            <div class="controls">
                                                <textarea class="input-xxlarge" name="tweetIcerik" id="textarea" rows="3" style="resize: none"></textarea>
                                                <input type="hidden" name="type" value="tweet" />
                                                <input type="hidden" name="userID" value="<?php echo $id; ?>" />
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <button id="tweetPaylas" type="submit" class="btn btn-primary btn-medium">Tweet Paylas</button>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>

                    </div> <!-- /.widget-content -->

                </div> <!-- /.widget -->


            </div>
        <?php
        }

        # odemeler
        if ( _go == 'paymentS' ){

            $type = $_GET['type'];
            ($type == 'waiting') ? $onaysiz = "WHERE gDurum = '0'" : NULL;
        ?>
            <div class="span12">

            <div class="widget widget-table">

            <div class="widget-header">
                <h3>
                    <i class="icon-money"></i>
                    Ödemeler
                </h3>
            </div> <!-- /widget-header -->

            <div class="widget-content">

            <table class="table table-striped table-bordered table-highlight" id="sTwityTablo">
            <thead>
            <tr>
                <th>Ödemeyi Yapan</th>
                <th>Net Tutar</th>
                <th>Tutar</th>
                <th>Aciklama</th>
                <th>PayPal Mail</th>
                <th>Tarih</th>
                <th><center>Status</center></th>
                <th><center></center>-</center></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $odemeler = DB::query("SELECT * FROM odemeler $onaysiz ORDER BY id DESC");
            foreach ($odemeler as $odeme)
            {
                $user = DB::getRow("SELECT * FROM uyeler WHERE tID = '$odeme->tID'");
            ?>
            <tr class="even gradeA">
                <td><center><img src="<?php echo $user->tProfileImage; ?>" width="32" height="32" style="border-radius: 100px" /> <a href="?go=userS&username=<?php echo $user->tUserName; ?>" target="_blank" class="btn ui-lightbox">@<?php echo $user->tUserName; ?></a></center></td>
                <td><center><?php echo $odeme->netTutar; ?> TL</center></td>
                <td><center><?php echo $odeme->tutar; ?> TL</center></td>
                <td><center><?php echo $odeme->aciklama; ?></center></td>
                <td><center><?php echo $odeme->uyePayPalMail; ?></center></td>
                <td><center><?php echo _date(date("j M Y D H:i", $odeme->tarih)); ?></center></td>
                <td><center><?php ($odeme->gDurum == 1) ? print 'Ödeme Onayli' : print '<b>Ödeme Onaylanmamis</b>'; ?></center></td>
                <td>
                    <center>
                        <?php if ($odeme->gDurum == 0) { ?>
                        <a class="ui-tooltip" href="?go=aktif&id=<?php echo $odeme->id; ?>&type=odeme" data-placement="top" onclick="return confirm('Ödemeyi onayladiginiz da kisiye gold üyelik sistem tarafindan verilecektir.')" data-original-title="Ödemeyi Onayla"><i class="icon-check" style="color: #000000; font-size: 16px"></i></a>&nbsp;<?php } ?>
                        <a class="ui-tooltip" href="?go=destroy&id=<?php echo $odeme->id; ?>&type=odeme" data-original-title="Üyeyi Sil"><i class="icon-trash" style="color: #000000; font-size: 16px"></i></a>
                    </center>
                </td>
            </tr>
             <?php } ?>
            </tbody>
            </table>


            </div> <!-- /widget-content -->

            </div> <!-- /widget -->

            </div>
        <?php
        }# Twitter Üye Islem
        if ( _go == 'tAppS' )
        {
            $type = $_GET['type'];
            $id = intval($_GET['id']);

            ($type == 'tweet') ? $tweet = 'active' : NULL;
            ($type == 'follow') ? $follow = 'active' : NULL;
            ($type == 'retweet') ? $retweet = 'active' : NULL;
            ($type == 'favori') ? $favori = 'active' : NULL;
            ($type == 'clean') ? $clean = 'active' : NULL;
            ?>

            <div class="span12">


                <div class="widget">

                    <div class="widget-header">
                        <h3>Coklu Islemler</h3>
                    </div> <!-- /.widget-header -->

                    <div class="widget-tabs">
                        <ul class="nav nav-tabs">
                            <li class="<?php echo $follow; ?>">
                                <a href="#follow"><i class="icon-user"></i> Takip Ettir</a>
                            </li>
                            <li class="<?php echo $retweet; ?>">
                                <a href="#retweet"><i class="icon-retweet"></i> Retweet Yaptir</a>
                            </li>
                            <li class="<?php echo $favori; ?>">
                                <a href="#favori"><i class="icon-star"></i> Favori Yaptir</a>
                            </li>
                            <li class="<?php echo $tweet; ?>">
                                <a href="#tweet"><i class="icon-twitter"></i> Tweet Paylas</a>
                            </li>
                            <li class="<?php echo $clean; ?>">
                                <a href="#clean"><i class="icon-trash"></i> Uygulamadan Cikanlari Temizle</a>
                            </li>
                        </ul>

                    </div> <!-- /.widget-tabs -->

                    <div class="widget-content">

                        <div class="tab-content">
                            <div class="tab-pane <?php echo $follow; ?>" id="follow">
                                <div id="islemSonucFollow"></div>
                                <form class="form-horizontal" rel="validate" id="followForm" onsubmit="return false">
                                    <fieldset>
                                        <div class="control-group">
                                            <label class="control-label" for="select01">Kaynak Uygulama</label>
                                            <div class="controls">
                                                <select id="select01" name="kaynakUygulama">
                                                    <?php
                                                    $uygulamalar = DB::query("SELECT * FROM uygulamalar ORDER BY id DESC");
                                                    foreach ($uygulamalar as $uygulama){
                                                        ($uygulama->aktif == 1) ? $select = 'selected="selected"' : $select = NULL;
                                                        echo '<option value="'.$uygulama->id.'" '.$select.'>'.$uygulama->appBaslik.'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control-group" rel="tUserName">
                                            <label class="control-label" for="input01">Twitter Profil URL</label>
                                            <div class="controls">
                                                <input type="text" name="tUserName" id="ilkAlan" placeholder="https://twitter.com/username" class="input-xxlarge" id="input01">
                                            </div>
                                        </div>
                                        <div class="control-group" rel="limit">
                                            <label class="control-label" for="input01">Yapilacak Miktar</label>
                                            <div class="controls">
                                                <input type="text" name="limit" class="input-small" id="ikinciAlan" id="input01">
                                                <input type="hidden" name="type" value="follow" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Yapilacak Islem</label>
                                            <div class="controls">
                                                <label class="radio">
                                                    <input type="radio" name="islemTuru" id="optionsRadios1" value="ekle" checked="checked">
                                                    Takipci Ekleme
                                                </label>
                                                <label class="radio">
                                                    <input type="radio" name="islemTuru" id="optionsRadios2" value="sil">
                                                    Takipci Cikarma
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <button id="cokluFollowEttir" type="submit" class="btn btn-primary btn-medium">Takip Ettir</button>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                            <div class="tab-pane <?php echo $retweet; ?>" id="retweet">
                                <div id="islemSonucRetweet"></div>
                                <form class="form-horizontal" id="retweetForm" onsubmit="return false">
                                    <fieldset>
                                        <div class="control-group">
                                            <label class="control-label" for="select01">Kaynak Uygulama</label>
                                            <div class="controls">
                                                <select id="select01" name="kaynakUygulama">
                                                    <?php
                                                    $uygulamalar = DB::query("SELECT * FROM uygulamalar ORDER BY id DESC");
                                                    foreach ($uygulamalar as $uygulama){
                                                        ($uygulama->aktif == 1) ? $select = 'selected="selected"' : $select = NULL;
                                                        echo '<option value="'.$uygulama->id.'" '.$select.'>'.$uygulama->appBaslik.'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control-group" rel="tweetID">
                                            <label class="control-label" for="input01">Tweet Url</label>
                                            <div class="controls">
                                                <input type="text" name="tweetID" placeholder="https://twitter.com/username/status/id" class="input-xxlarge" id="input01">
                                            </div>
                                        </div>
                                        <div class="control-group" rel="limit2">
                                            <label class="control-label" for="input01">Yapilacak Miktar</label>
                                            <div class="controls">
                                                <input type="text" name="limit" class="input-small" id="input01">
                                                <input type="hidden" name="type" value="retweet" />
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <button id="cokluRetweetYap" type="submit" class="btn btn-primary btn-medium">Retweet Yap</button>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                            <div class="tab-pane <?php echo $tweet; ?>" id="tweet">
                                <div id="tweetlerAlan" style="display: none">
                                    <textarea name="tweetler" style="width: 99%; height: 500px"><?php echo file_get_contents('../'.tweetTXT); ?></textarea>
                                    <br />
                                    <button id="tweetKaydet" type="submit" class="btn btn-secondary btn-medium"><i class="icon-edit"></i> Dosyayi Kaydet</button>
                                    <button id="tweetForm" type="submit" class="btn btn-primary btn-medium"><i class="icon-undo"></i> Form Alanina Dön</button>
                                </div>
                                <div id="formAlan">
                                    <div id="islemSonucTweet"></div>
                                    <button id="tweetDuzenle" type="submit" class="btn btn-primary btn-medium"><i class="icon-list"></i> Tweetleri Düzenle</button><br><br>
                                    <form class="form-horizontal" id="tweetForm" onsubmit="return false">
                                        <fieldset>
                                            <div class="control-group">
                                                <label class="control-label" for="select01">Kaynak Uygulama</label>
                                                <div class="controls">
                                                    <select id="select01" name="kaynakUygulama">
                                                        <?php
                                                        $uygulamalar = DB::query("SELECT * FROM uygulamalar ORDER BY id DESC");
                                                        foreach ($uygulamalar as $uygulama){
                                                            ($uygulama->aktif == 1) ? $select = 'selected="selected"' : $select = NULL;
                                                            echo '<option value="'.$uygulama->id.'" '.$select.'>'.$uygulama->appBaslik.'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div id="tweetS">
                                                <div class="control-group" rel="tweetIcerik">
                                                    <label class="control-label" for="input01">Tweet Hashtag</label>
                                                    <div class="controls">
                                                        <input type="text" name="tweetIcerik" placeholder="#sTwitySuperBirScripttir" maxlength="140" class="input-xxlarge" id="tweetAlan">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="control-group" rel="limit3">
                                                <label class="control-label" for="input01">Yapilacak Miktar</label>
                                                <div class="controls">
                                                    <input type="text" name="limit" class="input-small" id="input01">
                                                    <input type="hidden" name="type" value="tweet" />
                                                </div>
                                            </div>
                                            <div class="form-actions">
                                                <button id="cokluTweetPaylas" type="submit" class="btn btn-primary btn-medium">Tweet Paylas</button>
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane <?php echo $favori; ?>" id="favori">
                                <div id="islemSonucFavori"></div>
                                <form class="form-horizontal" id="favoriForm" onsubmit="return false">
                                    <fieldset>
                                        <div class="control-group">
                                            <label class="control-label" for="select01">Kaynak Uygulama</label>
                                            <div class="controls">
                                                <select id="select01" name="kaynakUygulama">
                                                    <?php
                                                    $uygulamalar = DB::query("SELECT * FROM uygulamalar ORDER BY id DESC");
                                                    foreach ($uygulamalar as $uygulama){
                                                        ($uygulama->aktif == 1) ? $select = 'selected="selected"' : $select = NULL;
                                                        echo '<option value="'.$uygulama->id.'" '.$select.'>'.$uygulama->appBaslik.'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control-group" rel="tweetID2">
                                            <label class="control-label" for="input01">Tweet Url</label>
                                            <div class="controls">
                                                <input type="text" name="tweetID" id="favoriID" placeholder="https://twitter.com/username/status/id" class="input-xxlarge" id="input01">
                                            </div>
                                        </div>
                                        <div class="control-group" rel="limit4">
                                            <label class="control-label" for="input01">Yapilacak Miktar</label>
                                            <div class="controls">
                                                <input type="text" name="limit" class="input-small" id="input01">
                                                <input type="hidden" name="type" value="favori" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Yapilacak Islem</label>
                                            <div class="controls">
                                                <label class="radio">
                                                    <input type="radio" name="islemTuru" id="optionsRadios1" value="ekle" checked="checked">
                                                    Favori Ekleme
                                                </label>
                                                <label class="radio">
                                                    <input type="radio" name="islemTuru" id="optionsRadios2" value="sil">
                                                    Favori Cikarma
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <button id="cokluFavoriYaptir" type="submit" class="btn btn-primary btn-medium">Favori Yaptir</button>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                            <div class="tab-pane <?php echo $clean; ?>" id="clean">
                                <div id="islemSonucClean"></div>
                                <form class="form-horizontal" id="cleanForm" onsubmit="return false">
                                    <fieldset>
                                        <div class="control-group">
                                            <label class="control-label" for="select01">Kaynak Uygulama</label>
                                            <div class="controls">
                                                <select id="select01" name="kaynakUygulama">
                                                    <?php
                                                    $uygulamalar = DB::query("SELECT * FROM uygulamalar ORDER BY id DESC");
                                                    foreach ($uygulamalar as $uygulama){
                                                        ($uygulama->aktif == 1) ? $select = 'selected="selected"' : $select = NULL;
                                                        echo '<option value="'.$uygulama->id.'" '.$select.'>'.$uygulama->appBaslik.'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <button class="btn btn-primary btn-medium" id="cleanUye">
                                                <i class="icon-cloud"></i> Temizle
                                            </button>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>

                    </div> <!-- /.widget-content -->

                </div> <!-- /.widget -->


            </div>
        <?php
        }

        # Yöneticiler
        if ( _go == 'adminS' )
        {
            ?>

            <div class="span12">


                <div class="widget">

                    <div class="widget-header">
                        <h3>Uygulamalar</h3>
                    </div> <!-- /.widget-header -->

                    <div class="widget-tabs">
                        <ul class="nav nav-tabs">
                            <li><a href="#yAdd"><i class="icon-plus"></i> Yönetici Ekle</a></li>
                            <li class="active">
                                <a href="#yList"><i class="icon-group"></i> Yöneticiler &nbsp;&nbsp;<span class="badge badge-success"><?php echo $toplamYoneticiler; ?></span></a>
                            </li>
                        </ul>

                    </div> <!-- /.widget-tabs -->

                    <div class="widget-content">

                        <div class="tab-content">
                            <div class="tab-pane active" id="yList">
                                <table class="table table-striped table-bordered table-highlight" id="sTwityTablo">
                                    <thead>
                                    <tr>
                                        <th>Yönetici Isim</th>
                                        <th>Yönetici Mail</th>
                                        <th><center>-</center></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $yoneticiler = DB::query("SELECT * FROM yoneticiler");
                                    foreach ($yoneticiler as $yonetici)
                                    {
                                        ?>
                                        <tr class="gradeA">
                                            <td><?php echo $yonetici->yBaslik; ?></td>
                                            <td><?php echo $yonetici->yEmail; ?></td>
                                            <td>
                                                <center>
                                                    <a class="ui-tooltip" href="#sifreDegistir<?php echo $yonetici->id; ?>" data-original-title="Sifresini Degistir" data-toggle="modal"><i class="icon-unlock" style="color: #000000; font-size: 16px"></i></a>&nbsp;
                                                    <a class="ui-tooltip" href="?go=destroy&id=<?php echo $yonetici->id; ?>&type=yntc" data-original-title="Yönetici Sil"><i class="icon-trash" style="color: #000000; font-size: 16px"></i></a>
                                                </center>
                                            </td>
                                        </tr>
                                        <div class="modal fade hide" id="sifreDegistir<?php echo $yonetici->id; ?>">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h3>Yönetici Sifresini Degistir</h3>
                                            </div>
                                            <div class="modal-body">
                                                <div id="islemSonuc<?php echo $yonetici->id; ?>"></div>
                                                <form class="form-horizontal" method="POST" action="" onsubmit="return sifreGuncelle(<?php echo $yonetici->id; ?>)">
                                                    <fieldset>
                                                        <div class="control-group">
                                                            <label class="control-label" for="input01"><b>Yeni Sifre</b></label>
                                                            <div class="controls">
                                                                <input type="password" value="" name="yeniSifre" id="inputID<?php echo $yonetici->id; ?>" class="input-large" id="input01">

                                                            </div>
                                                            <p class="help-block">Degistirilen yönetici sifresi bir sonraki giriste aktif olacaktir.</p>
                                                        </div>
                                                    </fieldset>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary" id="YoneticibutonID<?php echo $yonetici->id; ?>">Sifresini Degistir</button></form>
                                                <a href="#" class="btn" data-dismiss="modal">Kapat</a>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>

                            </div>
                            <div class="tab-pane" id="yAdd">
                                <div id="islemSonuc"></div>
                                <form class="form-horizontal" id="yForm" onsubmit="return false">
                                    <fieldset>
                                        <div class="control-group">
                                            <label class="control-label" for="input01">Yönetici Isim</label>
                                            <div class="controls">
                                                <input type="text" name="yBaslik" class="input-large" id="input01">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="input01">Yönetici Email</label>
                                            <div class="controls">
                                                <input type="text" name="yEmail" class="input-large" id="input01">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="input01">Yönetici Sifre</label>
                                            <div class="controls">
                                                <input type="text" name="ySifre" class="input-large" id="input01">
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <button id="yEkle" type="submit" class="btn btn-primary btn-medium">Yöneticiyi Ekle</button>
                                        </div>
                                    </fieldset>
                                </form>
                                </div>
                            </div>
                        </div>

                    </div> <!-- /.widget-content -->

                </div> <!-- /.widget -->


            </div>
        <?php
        }
        ?>
			
		</div> <!-- /.row -->
		
		
	</div> <!-- /.container -->
	
</div> <!-- /#content -->



<div id="footer">	
		
	<div class="container">

        <?php echo $siteAyarlari->footer; ?>
		
	</div> <!-- /.container -->		
	
</div> <!-- /#footer -->




<script src="js/script.js?v=<?php echo time(); ?>"></script>
  </body>
</html>
<?php
} else {
    header("Location: login.php");
}
?>