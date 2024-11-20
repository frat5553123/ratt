<?php
include "../data.php";
?>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="payPalGoldForm">
	<input type="hidden" name="item_number" value="<?php echo $userBilgi->id; ?>">
	<input type="hidden" name="cmd" value="_xclick">
	<input type="hidden" name="business" value="<?php echo $siteAyarlari->paypalEmail; ?>" />
	<input type="hidden" name="currency_code" value="TRY" />
	<input type="hidden" name="return" value="http://<?php echo $_SERVER['HTTP_HOST']; ?>" />
	<input type="hidden" name="item_name" id="item_name" value="<?php echo $siteAyarlari->title; ?> Gold Uyelik" />
	<input type="hidden" name="amount" id="amount" value="<?php echo $siteAyarlari->goldUyeUcret; ?>" />
</form>