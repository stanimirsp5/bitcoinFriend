<?php  
$url='https://bitpay.com/api/rates';
$json=json_decode( file_get_contents( $url ) );
$dollar=$btc=0;

$currency = $_POST['currency'];

foreach( $json as $obj ){
    if( $obj->code== $currency )$btc=$obj->rate;
}
$_SESSION['currency'] = $currency;

$dollar=1 / $btc;
$bitcoinValue = round($btc, 2);
?>

<h2>Price of one bitcoin to <?=$currency ?></h2>

   <p>1 Bitcoin = <?=round($btc,2) ?> <?=$currency ?>

<form method="get" action="bitcoinDB.php">
    <input type="hidden" name="currency" value="<?=$currency?>">
    <input type="hidden" name="btc" value="<?=$bitcoinValue?>">
    <input type="submit" value="Save search info">
</form>