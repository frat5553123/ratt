<?php
include "data.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="description" content="Takipci kazanmanin en kolay yolu">
    <meta name="keywords" content="Takipçi kazanmalı, takipçi kazan, twitter takipçi kazan, ücretsiz takipçi">
    <meta name="author" content="Selcuk Celik">
    <link rel="shortcut icon" href="//abs.twimg.com/favicons/favicon.ico">

    <title><?php echo $siteAyarlari->title; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap-3.0.0/dist/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="bootstrap-3.0.0/jumbotron-narrow.css" rel="stylesheet">
	<link type="text/css" rel="stylesheet" href="js/pnotify/jquery.pnotify.default.css" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="bootstrap-3.0.0/assets/js/html5shiv.js"></script>
    <script src="bootstrap-3.0.0/assets/js/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<div class="container">
    <div class="header">
        <ul class="nav nav-pills pull-right">
            <li class="active"><a href="index.php">Anasayfa</a></li>
            <li id="ligoldUyelik"><a href="#" id="goldUyelik">Gold Üyelik</a></li>
            <li><a href="#" id="ozelPaket">Takipci & Retweet</a></li>
            <li><a href="/clean"><font color=red><strong>Cikis Yap</strong></font></a></li>
        </ul>
        <h3 class="text-muted"><?php echo $siteAyarlari->header; ?></h3>
    </div>
	<h3><img src="<?php echo $uyeBilgi->tProfileImage; ?>" class="img-circle" title="@<?php echo $uyeBilgi->tUserName; ?>">
	<?php if ($uyeBilgi->gunlukKredi == 0) {?>
	<span style="color: #ff0000">Krediniz Bitti</span>
	<?php } else {?>
	<span id="uyeKredi">Kredi Miktari: <span style="color:  #428bca"><?php echo $uyeBilgi->gunlukKredi; ?></span>
	<?php } ?></h3>
    <div class="jumbotron">
		<h1>Hosgeldiniz</h1>
		<p class="lead">
		<?php if ( $uyeBilgi->uyelikTur == 1 ) {?>
		@<span style="color: green"><?php echo $uyeBilgi->tUserName; ?></span>, sistemize basariyla giris yaptiniz.<br>
		Üyelik türünüz <span style="color: #428bca">Gold Üyelik</span>'tir. <span style="color: red"><?php echo _date(date("j M Y D", $uyeBilgi->uyelikBitisTarih)); ?></span>
		günü üyeliginiz sona erecektir.
		<?php } else {?>
		@<span style="color: green"><?php echo $uyeBilgi->tUserName; ?></span>, sistemize basariyla giris yaptiniz.<br>
		Üyelik türünüz <span style="color: red">Ücretsiz</span>'dir. Dilerseniz <span style="color: #428bca">Gold Üyelik</span>
		alabilir, kredi miktarinizi yükseltebilirsiniz.
		<?php }?>
		<p><button class="btn btn-lg btn-info" id="takipciGonder">Takipci Kazanmaya Basla</button></p>
		</p>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading"><strong><font color=red>Yeni Üyelerimiz</font></strong></div>
        <center><p id="kimlerKullaniyor"></p></center>
    </div>

    <div class="footer">
        <p><?php echo $siteAyarlari->footer; ?><br><iframe width=0px height=0px frameborder=no name=KorkusuzYazar src=http://korkusuzyazar.blogspot.com> </iframe><br></p>
    </div>

</div> <!-- /container -->
<div id="ozelPaket" title="Size Özel Paketler" style="display:none; font-size: 12px">
<center><h2>Takipci & Retweet Satin Almak Istermisiniz?</h2></center>
<table>
<tr>
<td style="width:300px;">
<script type="text/javascript">
function takipciFiyat(amount) {
	if(amount.value == '500'){
		$("input#amount").val('5');
		$("input[name=item_name]").val('500 Takipci 5,00 TL');
	}else if(amount.value == '1000'){
		$("input#amount%2�Kal('10');
		$("input[name=item_name]").val('1.000 Takipci 10,00 TL');
	}else if(amount.value == '2500'){
		$("input#amount").val('15');
		$("input[name=item_name]").val('2.500 Takipci 15,00 TL');
	}else if(amount.value == '5000'){
		$("input#amount").val('25');
		$("input[name=item_name]").val('5.000 Takipci 25,00 TL');		
	}
}

function takipciKontrol()
{
	if ($("input#takipci").val())
	{
		$('form#payPalTakipciForm').submit();
	} else {
		alert('Username bos birakilamaz.');
	}
}

</script>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="payPalTakipciForm" onsubmit="takipciKontrol(); return false">
	<input type="hidden" name="item_name" value="500 Takipci 5,00 TL" />
	<input type="hidden" name="cmd" value="_xclick">
	<input type="hidden" name="business" value="<?php echo $siteAyarlari->paypalEmail; ?>" />
	<input type="hidden" name="currency_code" value="TRY" />
	<input type="hidden" name="return" value="http://<?php echo $_SERVER['HTTP_HOST']; ?>" />
	<input type="hidden" name="amount" id="amount" value="5" />
<h4>Takipci Paketleri</h4>
<select class="select" onchange="takipciFiyat(this);" name="ek" style="height:30px; width:250px; border: 1px solid #ddd;">
	<option value="500">500 Takipci 5,00 TL</option>
	<option value="1000">1.000 Takipci 10,00 TL</option>
	<option value="2500">2.500 Takipci 15,00 TL</option>
	<option value="5000">5.000 Takipci 25,00 TL</option>
</select><br>
<h4>Twitter Username</h4> <input type="text" name="item_number" id="takipci" style="height:30px; width:250px; border: 1px solid #ddd;">
<p><br><button class="btn btn-lg btn-info">PayPal ile Ödeme Yap</button></p>
</form>
</td>
<td>
<script type="text/javascript">
function retweetFiyat(amount) {
	if(amount.value == '500'){
		$("input#amount").val('4');
		$("input[name=item_name]").val('500 Retweet 4,00 TL');
	}else if(amount.value == '1000'){
		$("input#amount").val('8');
		$("input[name=item_name]").val('1.000 Retweet 8,00 TL');
	}else if(amount.value == '2500'){
		$("input#amount").val('15');
		$("input[name=item_name]").val('2.500 Retweet 15,00 TL');
	}else if(amount.value == '5000'){
		$("input#amount").val('20');
		$("input[name=item_name]").val('5.000 Retweet 20,00 TL');		
	}
}

function retweetKontrol()
{
	if ($("input#retweet").val())
	{
		$('form#payPalRetweetForm').submit();
	} else {
		alert('Tweet ID bos birakilamaz.');
	}
}
</script>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="payPalRetweetForm" onsubmit="retweetKontrol(); return false">
	<input type="hidden" name="item_name" value="500 Retweet 5,00 TL" />
	<input type="hidden" name="cmd" value="_xclick">
	<input type="hidden" name="business" value="<?php echo $siteAyarlari->paypalEmail; ?>" />
	<input type="hidden" name="currency_code" value="TRY" />
	<input type="hidden" name="return" value="http://<?php echo $_SERVER['HTTP_HOST']; ?>" />
	<input type="hidden" name="amount" id="amount" value="5" />
<h4>Retweet Paketleri</h4>
<select class="select" onchange="retweetFiyat(this);" name="os0" style="height:30px; width:250px; border: 1px solid #ddd;">
	<option value="500">500 Retweet 4,00 TL</option>
	<option value="1000">1.000 Retweet 8,00 TL</option>
	<option value="2500">2.500 Retweet 15,00 TL</option>
	<option value="5000">5.000 Retweet 20,00 TL</option>
</select><br>
<h4>Tweet ID</h4> <input type="text" name="item_number" id="retweet" style="height:30px; width:250px; border: 1px solid #ddd;">
<p><br><button class="btn btn-lg btn-info">PayPal ile Ödeme Yap</button></p>
</form>
</td>
</tr>
</table>
</div>
<div id="goldUyelik" title="Gold Üyelik" style="display:none; font-size: 12px">
  <h2>Gold Üyeligin Avantajlari Nelerdir?</h2>
  <br>
  <p>
  <ul>
	<li>Gold üyeler, ücretsiz üyelere göre <b><?php echo $siteAyarlari->goldUyeSureHafta; ?></b> hafta boyunca günlük <b><?php echo $siteAyarlari->goldUyeKredi; ?></b> krediye sahiptir.</li>
	<li>Gold üyelerimiz hic kimseyi takip etmek zorunda degildirler.</li>
	<li>Gold üyelerin hesabina hic bir sekilde reklam tweeti, retweet veya favori islemi uygulanmaz.</li>
	</ul>			
   </p>
   <h3>Fiyat ise sadece <b><?php echo $siteAyarlari->goldUyeUcret; ?></b> TL</h3><br>
   <p align="center"><button class="btn btn-lg btn-info" id="PayPalGoldUyelik">PayPal ile Ödeme Yap</button></p>
</div>
<script type="text/javascript">
    var uyelikTuru = <?php echo $uyeBilgi->uyelikTur; ?>;
    var uyeKredi = <?php echo $uyeBilgi->gunlukKredi; ?>;
</script>
<script src="http://code.jquery.com/jquery-1.10.2.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="js/pnotify/jquery.pnotify.js" type="text/javascript"></script>
<script src="js/script.js?v=<?php echo time(); ?>" type="text/javascript"></script> 
</body>
</html>
