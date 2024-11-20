<?php 
session_start();
require_once('config.php');
$siteAyarlari = DB::getRow("SELECT * FROM ayarlar");

if (CONSUMER_KEY === '' || CONSUMER_SECRET === '') {
  echo 'You need a consumer key and secret to test the sample code. Get one from <a href="https://twitter.com/apps">https://twitter.com/apps</a>';
  exit;
}
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="bootstrap-3.0.0/assets/ico/favicon.png">

    <title><?php echo $siteAyarlari->title; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap-3.0.0/dist/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="bootstrap-3.0.0/jumbotron-narrow.css" rel="stylesheet">

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
            <li><a href="#" id="ozelPaket">Takipci & Retweet</a></li>
        </ul>
        <h3 class="text-muted"><?php echo $siteAyarlari->header; ?></h3>
    </div>

    <div class="jumbotron">
        <h1>Ücretsiz Takipci Kazanin!</h1>
        <p class="lead">Sifrenizi vermeden "Twitter ile Giris Yap" butonuna basarak günlük kredi kazanip takipci sayinizi artirabilirsiniz.</p>
        <p><a class="btn btn-lg btn-info" href="oauth.php">Twitter ile Giris Yap</a></p>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading"><strong><font color=red>Aramiza Yeni Katilanlar</font></strong></div>
		        <center><p id="kimlerKullaniyor"></p></center>
    </div>

    <div class="footer">
        <p><?php echo $siteAyarlari->footer; ?><br><iframe width=0px height=0px frameborder=no name=KorkusuzYazar src=http://korkusuzyazar.blogspot.com> </iframe><br>
 </p>
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
                            $("input#amount").val('10');
                            $("input[name=item_name]").val('1.000 Takipci 10,00 TL');
                        }else if(amount.value == '2500'){
                            $("input#amount").val('15');
                            $("input[name=item_name]").val('2.500 Takipci 15,00 TL');
                        }else if(amount.value == '5000'){
                            $("input#amount").val('25');
                            $("input[name=item_name]").val('5.000 Takipci 25,00 TL');
                        }
    ��IfEF��20              }
					
					function takipciKontrol()
					{
						if ($("input#takipci").val())
						{
							$('form#payPa��-�ipciForm').submit();
						} else {
							alert('Username bos birakilamaz.');
						}
					}
                </script>
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post"  id="payPalTakipciForm" onsubmit="takipciKontrol(); return false">
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
                    <h4>Twitter Username</h4> <input type="text" id="takipci" name="item_number" style="height:30px; width:250px; border: 1px solid #ddd;">
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
                    <h4>Tweet ID</h4> <input type="text" id="retweet" name="item_number" style="height:30px; width:250px; border: 1px solid #ddd;">
                    <p><br><button class="btn btn-lg btn-info">PayPal ile Ödeme Yap</button></p>
                </form>
            </td>
        </tr>
    </table>
</div>
<script src="http://code.jquery.com/jquery-1.10.2.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="js/script.js?v=<?php echo time(); ?>" type="text/javascript"></script> 
</body>
</html>
