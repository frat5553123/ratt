<?php
session_start();
include "../config.php";
(isset($_SESSION['sTwityAdmin'])) ? header("Location: index.php") :  NULL;

if ( $_POST ){
    $loginEmail = htmlspecialchars($_POST['email']);
    $loginSifre = md5(sha1(trim($_POST['sifre'])));
    $girisKontrol = DB::getVar("SELECT count(id) FROM yoneticiler WHERE yEmail = ? and ySifre = ?", array($loginEmail, $loginSifre));
    if ( $girisKontrol > 0 ){
        $_SESSION['sTwityAdmin'] = $loginEmail;
        header("Location: index.php");
    } else {
        echo '<script>alert("HATA");</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Login</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">   
    
    <!-- Styles -->
    
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <link href="css/bootstrap-overrides.css" rel="stylesheet">
    
	<link href="css/ui-lightness/jquery-ui-1.8.21.custom.css" rel="stylesheet">
        
    <link href="css/slate.css" rel="stylesheet">
    
	<link href="css/components/signin.css" rel="stylesheet" type="text/css">   
    
    
    <!-- Javascript -->
    
    <script src="js/jquery-1.7.2.min.js"></script>
	<script src="js/jquery-ui-1.8.18.custom.min.js"></script>    
	<script src="js/jquery.ui.touch-punch.min.js"></script>
	<script src="js/bootstrap.js"></script>


</head>

<body>



<div class="account-container login">
	
	<div class="content clearfix">
		
		<form action="" method="post">
		
			<h1>Giris Yap</h1>
			
			<div class="login-fields">

				<p>Sisteme girmek icin bilgilerinizi yaziniz</p>
				
				<div class="field">
					<label for="username">E-Mail:</label>
					<input type="text" id="email" name="email" value="" placeholder="E-Mail" class="login username-field" />
				</div> <!-- /field -->
				
				<div class="field">
					<label for="password">Sifre:</label>
					<input type="password" id="sifre" name="sifre" value="" placeholder="Sifre" class="login password-field"/>
				</div> <!-- /password -->
				
			</div> <!-- /login-fields -->
			
			<div class="login-actions">
									
				<button class="button btn btn-secondary btn-large">Giris</button>
				
			</div> <!-- .actions -->
			
		</form>
		
	</div> <!-- /content -->
	
</div> <!-- /account-container -->

<!-- Text Under Box -->
</body>
</html>
