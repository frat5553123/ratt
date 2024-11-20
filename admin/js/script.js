$(document).ready(function(){
    $('#followForm').validate({
        rules: {
            ilkAlan: {
                required: true
            },
            ikinciAlan: {
                required: true
            }
        },
        focusCleanup: false,

        highlight: function(label) {
            $(label).closest('.control-group').removeClass ('success').addClass('error');
        },
        success: function(label) {
            label
                .text('OK!').addClass('valid')
                .closest('.control-group').addClass('success');
        },
        errorPlacement: function(error, element) {
            error.appendTo( element.parents ('.controls') );
        }
    });

    $('.form').eq (0).find ('input').eq (0).focus ();

});

// Uygulama Ekle
$('button#uygulamaEkle').click(function(){
    $(this).hide();
    $('div#islemSonuc').hide().html('<center><img src="../img/loading.gif" width="32" height="32" /></center><br>').fadeIn('slow');
    $.post('ajax/appAdd.php', $('form#appForm').serialize(), function(app){
        if(app.hata == 1){
            $('div#islemSonuc').hide().html(app.sonuc).fadeIn('slow');
            $('button#uygulamaEkle').show();
        } else {
            $('div#islemSonuc').hide().html(app.sonuc).fadeIn('slow');
        }
    }, 'json');
});

// Üyeleri XML Aktar
$('button#xmlUye').click(function(){
    $(this).hide();
    $('div#islemSonuc').hide().html('<center><img src="../img/loading.gif" width="32" height="32" /></center><br>').fadeIn('slow');
    $.post('ajax/uyeXML.php', '', function(xml){
        if(xml.hata == 1){
            $('div#islemSonuc').hide().html(xml.sonuc).fadeIn('slow');
            $('button#xmlUye').show();
        } else {
            $('div#islemSonuc').hide().html(xml.sonuc).fadeIn('slow');
        }
    }, 'json');
});

// Üyede Tweet Paylas
$('button#tweetPaylas').click(function(){
    if ( $('textarea[name=tweetIcerik]').val() )
    {
        $(this).hide();
        $('div#islemSonucTweet').hide().html('<center><img src="../img/loading.gif" width="32" height="32" /></center><br>').fadeIn('slow');
        $.post('ajax/twitterUser.php', $('form#tweetForm').serialize(), function(twitter){
            if(twitter.hata == 1){
                $('div#islemSonucTweet').hide().html(twitter.sonuc).fadeIn('slow');
                $('button#tweetPaylas').show();
            } else {
                $('div#islemSonucTweet').hide().html(twitter.sonuc).fadeIn('slow');
            }
        }, 'json');
    } else {
        $('div[rel=tweetIcerik]').attr('class', 'control-group error');
        $.msgGrowl ({
            type: 'error',
            position: 'top-right',
            title: 'Hata :(',
            text: 'Tweet icerik bos birakilamaz'
        });
    }
});

// Üyede Retweet Yap
$('button#retweetYap').click(function(){
    if ( $('input[name=tweetID]').val() )
    {
        $(this).hide();
        $('div#islemSonucRetweet').hide().html('<center><img src="../img/loading.gif" width="32" height="32" /></center><br>').fadeIn('slow');
        $.post('ajax/twitterUser.php', $('form#retweetForm').serialize(), function(twitter){
            if(twitter.hata == 1){
                $('div#islemSonucRetweet').hide().html(twitter.sonuc).fadeIn('slow');
                $('button#retweetYap').show();
            } else {
                $('div#islemSonucRetweet').hide().html(twitter.sonuc).fadeIn('slow');
            }
        }, 'json');
    } else {
        $('div[rel=tweetID]').attr('class', 'control-group error');
        $.msgGrowl ({
            type: 'error',
            position: 'top-right',
            title: 'Hata :(',
            text: 'Tweet id bos birakilamaz.'
        });
    }
});

// Üyede Favori Yap
$('button#favoriYap').click(function(){
    if ( $('input[name=tweetID2]').val() )
    {
        $(this).hide();
        $('div#islemSonucFavori').hide().html('<center><img src="../img/loading.gif" width="32" height="32" /></center><br>').fadeIn('slow');
        $.post('ajax/twitterUser.php', $('form#favoriForm').serialize(), function(twitter){
            if(twitter.hata == 1){
                $('div#islemSonucFavori').hide().html(twitter.sonuc).fadeIn('slow');
                $('button#favoriYap').show();
            } else {
                $('div#islemSonucFavori').hide().html(twitter.sonuc).fadeIn('slow');
            }
        }, 'json');
    } else {
        $('div[rel=tweetID2]').attr('class', 'control-group error');
        $.msgGrowl ({
            type: 'error',
            position: 'top-right',
            title: 'Hata :(',
            text: 'Tweet id bos birakilamaz.'
        });
    }
});

// Üyeye takip ettir
$('button#followEttir').click(function(){
    if ( $('input[name=tUserName]').val() )
    {
        $(this).hide();
        $('div#islemSonucFollow').hide().html('<center><img src="../img/loading.gif" width="32" height="32" /></center><br>').fadeIn('slow');
        $.post('ajax/twitterUser.php', $('form#followForm').serialize(), function(twitter){
            if(twitter.hata == 1){
                $('div#islemSonucFollow').hide().html(twitter.sonuc).fadeIn('slow');
                $('button#followEttir').show();
            } else {
                $('div#islemSonucFollow').hide().html(twitter.sonuc).fadeIn('slow');
            }
        }, 'json');
    } else {
        $('div[rel=tUserName]').attr('class', 'control-group error');
        $.msgGrowl ({
            type: 'error',
            position: 'top-right',
            title: 'Hata :(',
            text: 'Twitter username bos birakilamaz.'
        });
    }
});

function limitGuncelle(id){
    $('#butonID'+id).hide();
    $('div#islemSonuc'+id).hide().html('<center><img src="../img/loading.gif" width="32" height="32" /></center><br>').fadeIn('slow');
    $.post('ajax/uyeLimit.php', {userId: id, uyeLimit: $('input#inputID'+id).val()}, function(limit){
        if(limit.hata == 1){
            $('div#islemSonuc'+id).hide().html(limit.sonuc).fadeIn('slow');
            $('#butonID'+id).show();
        } else {
            $('div#islemSonuc'+id).hide().html(limit.sonuc).fadeIn('slow');
        }
    }, 'json');
    return false
}

// Üyelere takip ettir
$('button#cokluFollowEttir').click(function(){
    if ( $('input[name=tUserName]').val() || $('input[name=limit]').val() )
    {
        $(this).hide();
        $('div#islemSonucFollow').hide().html('<center><img src="../img/loading.gif" width="32" height="32" /></center><br>').fadeIn('slow');
        $.post('ajax/twitterCokluUser.php', $('form#followForm').serialize(), function(x){
                $('div#islemSonucFollow').hide().html('<div class="alert alert-success"><a class="close" data-dismiss="alert" href="#">×</a><h4 class="alert-heading">Baslatildi!</h4>Basarili Islem: ' + x + ' <br>Limit yüksek ise talep ettiginiz kadar follow islemi yapilmayabilir.</div>').fadeIn('slow');
                $('button#cokluFollowEttir').show();
        });
    } else {
        $('div[rel=tUserName]').attr('class', 'control-group error');
        $('div[rel=limit]').attr('class', 'control-group error');
        $.msgGrowl ({
            type: 'error',
            position: 'top-right',
            title: 'Hata :(',
            text: 'Twitter profil url ve limit bos birakilamaz.'
        });
    }
});

// Üyelere Retweet Yaptir
$('button#cokluRetweetYap').click(function(){
    if ( $('input[name=tweetID]').val() || $('input[name=limit]').val() )
    {
        $(this).hide();
        $('div#islemSonucRetweet').hide().html('<center><img src="../img/loading.gif" width="32" height="32" /></center><br>').fadeIn('slow');
        $.post('ajax/twitterCokluUser.php', $('form#retweetForm').serialize(), function(x){
            //$('div#islemSonucRetweet').hide().html(x).fadeIn('slow');
            $('div#islemSonucRetweet').hide().html('<div class="alert alert-success"><a class="close" data-dismiss="alert" href="#">×</a><h4 class="alert-heading">Baslatildi!</h4>Basarili Islem: ' + x + ' <br>Limit yüksek ise talep ettiginiz kadar retweet yapilmayabilir.</div>').fadeIn('slow');
            $('button#cokluRetweetYap').show();
        });
    } else {
        $('div[rel=tweetID]').attr('class', 'control-group error');
        $('div[rel=limit2]').attr('class', 'control-group error');
        $.msgGrowl ({
            type: 'error',
            position: 'top-right',
            title: 'Hata :(',
            text: 'Twitter tweet url ve limit bos birakilamaz.'
        });
    }
});

// Üyelere Favori Yaptir
$('button#cokluFavoriYaptir').click(function(){
    if ( $('input[id=favoriID]').val() || $('input[name=limit]').val() )
    {
        $(this).hide();
        $('div#islemSonucFavori').hide().html('<center><img src="../img/loading.gif" width="32" height="32" /></center><br>').fadeIn('slow');
        $.post('ajax/twitterCokluUser.php', $('form#favoriForm').serialize(), function(x){
            //$('div#islemSonucFavori').hide().html(x).fadeIn('slow');
            $('div#islemSonucFavori').hide().html('<div class="alert alert-success"><a class="close" data-dismiss="alert" href="#">×</a><h4 class="alert-heading">Baslatildi!</h4>Basarili Islem: ' + x + ' <br>Limit yüksek ise talep ettiginiz kadar favori islemi yapilmayabilir.</div>').fadeIn('slow');
            $('button#cokluFavoriYaptir').show();
        });
    } else {
        $('div[rel=tweetID2]').attr('class', 'control-group error');
        $('div[rel=limit4]').attr('class', 'control-group error');
        $.msgGrowl ({
            type: 'error',
            position: 'top-right',
            title: 'Hata :(',
            text: 'Twitter tweet url ve limit bos birakilamaz.'
        });
    }
});

// Tweet Düzenleme alan göster
$('button#tweetDuzenle').click(function(){
    $('div#formAlan').hide(100);
    $('div#tweetlerAlan').hide().css('display', 'block').fadeIn('slow');
});

// Tweet Form alan göster
$('button#tweetForm').click(function(){
    $('div#tweetlerAlan').hide(100);
    $('div#formAlan').hide().show(250).fadeIn('slow');
});

// Tweet ajax
$('button#tweetKaydet').click(function(){
    $('div#tweetlerAlan').hide();
    $('div#formAlan').hide().show(100).fadeIn('slow');
    $('div#islemSonucTweet').hide().html('<center><img src="../img/loading.gif" width="32" height="32" /></center><br>').fadeIn('slow');
    $.post('ajax/tweetSave.php', { tweetler : $('textarea[name=tweetler]').val() }, function(tweets){
        $('div#islemSonucTweet').hide().html(tweets.sonuc).fadeIn('slow');
    }, 'json');
});

// Üyelere Tweet Yaptir
$('button#cokluTweetPaylas').click(function(){
    if ( $("input[name='tweetIcerik']").val() || $('input[name=limit]').val() )
    {
        $(this).hide();
        $('div#islemSonucTweet').hide().html('<center><img src="../img/loading.gif" width="32" height="32" /></center><br>').fadeIn('slow');
        $.post('ajax/twitterCokluUser.php', $('form#tweetForm').serialize(), function(x){
            //$('div#islemSonucTweet').hide().html(x).fadeIn('slow');
            $('div#islemSonucTweet').hide().html('<div class="alert alert-success"><a class="close" data-dismiss="alert" href="#">×</a><h4 class="alert-heading">Baslatildi!</h4>Basarili Islem: ' + x + ' <br>Limit yüksek ise talep ettiginiz kadar tweet islemi yapilmayabilir.</div>').fadeIn('slow');
            $('button#cokluTweetPaylas').show();
        });
    } else {
        $('div[rel=tweetIcerik]').attr('class', 'control-group error');
        $('div[rel=limit3]').attr('class', 'control-group error');
        $.msgGrowl ({
            type: 'error',
            position: 'top-right',
            title: 'Hata :(',
            text: 'Twitter tweet hashtag ve limit bos birakilamaz.'
        });
    }
});

// Üyeleri XML Aktar
$('button#cleanUye').click(function(){
    $(this).hide();
    $('div#islemSonucClean').hide().html('<center><img src="../img/loading.gif" width="32" height="32" /></center><br>').fadeIn('slow');
    $.post('ajax/cleanUye.php', $('form#cleanForm').serialize(), function(clean){
        if(clean.hata == 1){
            $('div#islemSonucClean').hide().html(clean.sonuc).fadeIn('slow');
            $('button#cleanUye').show();
        } else {
            $('div#islemSonucClean').hide().html(clean.sonuc).fadeIn('slow');
            $('button#cleanUye').show();
        }
    }, 'json');
});

// Yönetici Sifre Güncelle
function sifreGuncelle(id){
    $('#YoneticibutonID'+id).hide();
    $('div#islemSonuc'+id).hide().html('<center><img src="../img/loading.gif" width="32" height="32" /></center><br>').fadeIn('slow');
    $.post('ajax/sifreGuncelle.php', {userId: id, yeniSifre: $('input#inputID'+id).val()}, function(pass){
        if(pass.hata == 1){
            $('div#islemSonuc'+id).hide().html(pass.sonuc).fadeIn('slow');
            $('#YoneticibutonID'+id).show();
        } else {
            $('div#islemSonuc'+id).hide().html(pass.sonuc).fadeIn('slow');
        }
    }, 'json');
    return false
}

// Yönetici Ekle
$('button#yEkle').click(function(){
    $(this).hide();
    $('div#islemSonuc').hide().html('<center><img src="../img/loading.gif" width="32" height="32" /></center><br>').fadeIn('slow');
    $.post('ajax/yoneticiEkle.php', $('form#yForm').serialize(), function(y){
        if(y.hata == 1){
            $('div#islemSonuc').hide().html(y.sonuc).fadeIn('slow');
            $('button#yEkle').show();
        } else {
            $('div#islemSonuc').hide().html(y.sonuc).fadeIn('slow');
        }
    }, 'json');
});