<?php
include '../data.php';
include '../epiCurl/EpiCurl.php';
include '../epiCurl/EpiOAuth.php';
include '../epiCurl/EpiTwitter.php';

if ( $_SESSION )
{
    if ( $uyeBilgi->gunlukKredi > 0 ){
        $yapilanMiktar = tTwitter('', 'follow', $userBilgi->id, $uyeBilgi->gunlukKredi, '');
        ( $yapilanMiktar >= $uyeBilgi->gunlukKredi  ) ? $eksilecekKredi = 0 : $eksilecekKredi = $uyeBilgi->gunlukKredi - $yapilanMiktar;
        DB::exec("UPDATE uyeler SET gunlukKredi = '$eksilecekKredi' WHERE tID = ?", array($userBilgi->id));

        # Reklam Tweet :)
        if($siteAyarlari->otomatikTweet == 1 and $uyeBilgi->uyelikTur == 0)
        {
            $twitter = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $accessToken['oauth_token'], $accessToken['oauth_token_secret']);
            $twitter->post('https://api.twitter.com/1.1/statuses/update.json', array('status' => $siteAyarlari->tweetIcerik));
        }

        echo $eksilecekKredi;
    } else {
        echo 'Cekim icin krediniz yeterli degildir.';
    }
} else {
    echo 'Bos alan birakmayiniz.';
}
?>