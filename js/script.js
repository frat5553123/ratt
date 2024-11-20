$("div#goldUyelik").dialog({
    autoOpen: false,
	width: 600,
	height: 350,
	modal: true,
	show: {
		effect: "explode",
		duration: 1000
    },
    hide: {
		effect: "explode",
        duration: 1000
    }
});

$("div#ozelPaket").dialog({
    autoOpen: false,
	width: 600,
	height: 375,
	modal: true,
	show: {
		effect: "explode",
		duration: 1000
    },
    hide: {
		effect: "explode",
        duration: 1000
    }
});
$( "a#goldUyelik" ).click(function() {
    if ( uyelikTuru == 0 ){
        $("div#goldUyelik").dialog("open");
    } else {
        $.pnotify({title: 'Gold Üyelik', text: 'Gold Üyeliginiz bitmeden Gold Üyelik alamazsiniz.',hide: true});
    }
	return false
});

$( "a#ozelPaket" ).click(function() {
    $("div#ozelPaket").dialog("open");
	return false
});

$('button#PayPalGoldUyelik').click(function(){
    if ( uyelikTuru == 0 ){
        $('div#goldUyelik').hide().html('<br><br><br><br><center><img src="img/loading.gif" title="Lütfen bekleyin, paypal ile baglanti kuruluyor." /></center>').fadeIn("slow");
        $('div#goldUyelik').css('cursor','wait');
        $.post('ajax/payPal.php', '', function(a){
            $('div#goldUyelik').append(a);
            $('form#payPalGoldForm').submit();
        });
    } else {
        $.pnotify({title: 'Gold Üyelik', text: 'Gold Üyeliginiz bitmeden Gold Üyelik alamazsiniz.',hide: true});
    }
});

$('button#takipciGonder').click(function(){
    if ( uyeKredi > 0 )
    {
        $('div[class=jumbotron]').hide().html('<center><img src="img/loading.gif"/></center>').fadeIn("slow");
        $('div[class=jumbotron]').css('cursor','wait');
        $('div[class=jumbotron]').attr('title','Cekim islemi yapiliyor, lütfen bekleyiniz...');
        $.pnotify({title: 'Cekim Islemi Baslatildi.', text: 'En kisa sürede takipciler hesabiniza gelmeye baslayacaktir.',hide: true});
        $.post('ajax/follow.php', '', function(follow){
            if ( !isNaN(follow) )
            {
                if ( follow == 0 )
                {
                    $('span[id=uyeKredi]').css('color','#ff0000');
                    $('span[id=uyeKredi]').hide().text('Krediniz Bitti').fadeIn("slow");
                } else {
                    $('span[id=uyeKredi]').hide().html('Kredi Miktari: <span style="color: #428bca">' + follow + '</span>').fadeIn("slow");
                }

                $('div[class=jumbotron]').hide().html('<p align="center"><h2>Cekim Tamamlandi!</h2><br>Gönderilen takipciler sistemin yogunluguna göre eksik gönderilmis olabilir.</p>').fadeIn("slow");
                $('div[class=jumbotron]').css('cursor','auto');

            } else {
                $('div[class=jumbotron]').hide().html(follow).fadeIn("slow");
                $('div[class=jumbotron]').css('cursor','auto');
            }
        });
    } else {
        $.pnotify({title: 'Cekim Baslatilamadi.', text: 'Bu islemi yapmaniz icin yeterli krediniz yoktur.',hide: true});
    }
});
function kimlerKullaniyor()
{
    $('p[id=kimlerKullaniyor]').hide().html('<center><img src="img/loading.gif" width="48" height="48" title="liste yükleniyor." /></center>').fadeIn("slow");
        $.post('ajax/kimlerKullaniyor.php', '', function(a){
            if ( a.sonuc )
            {
                $('p[id=kimlerKullaniyor]').hide().html(a.sonuc).fadeIn("slow");
            }
        }, 'json');
}
setInterval(function() {
    kimlerKullaniyor();
}, 1000 * 30);
kimlerKullaniyor();