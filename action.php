


<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bitcoin Pal</title>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>
<body>
    
<?php  
require_once("phpChart_Lite/conf.php");
 include 'bitcoinDB.php';

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
    $result = loadDbRecords($currency);
    $bitcoinValue1 = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            if($row["currency"] == $currency){
               $bitcoinValue1[] = (int)$row["bitcoinValue"];
            //echo "Country currency: " . $row["currency"]. ", BitcoinValue " . $row["bitcoinValue"]. " Created on: ". $row["createdOn"].  "<br>";
            }
        }
    } else {
        echo "0 results";
    }   
    // print_r($result);
    // $x = 0;           
    // while($x < 5) {
    // // while($x < sizeof($result)) {
    //         //echo "The number is: $result["currency"][$x] <br>";
    //         echo $result["currency"][$x];
    //     $x++;
    // } 
?>
<h2>Price of one bitcoin to <?=$currency ?></h2>

<p>1 Bitcoin = <?=round($btc,2) ?> <?=$currency ?>

<form method="post">
 <input type="submit" name="loadAllRecords" id="test" value="List records" /><br/>
</form>

<form method="get" action="bitcoinDB.php">
 <input type="hidden" name="currency" value="<?=$currency?>">
 <input type="hidden" name="btc" value="<?=$bitcoinValue?>">
 <input type="submit" value="Save search info">
</form>
<input type="button" value="Go back" class="homebutton" id="btnHome" 
onClick="document.location.href='http://localhost/bitcoin/bitcoin.php'"/>
<br>

<?php if (count($result) > 0): ?>
<table>

  <thead>
    <tr>
    <th>Id</th>
    <th>Currency</th>
    <th>Value</th>
    <th>Date</th>
      <!-- <th><?php echo implode('</th><th>', array_keys(current($result))); ?></th> -->
    </tr>
  </thead>
  <tbody>
<?php foreach ($result as $row): array_map('htmlentities', $row); ?>
    <tr>
      <td><?php echo implode('</td><td>', $row); ?></td>
    </tr>
<?php endforeach; ?>
  </tbody>
</table>
<?php endif; ?>


<?php  

$pc = new C_PhpChartX(array($bitcoinValue1),'basic_chart');
$pc->set_animate(true);
$pc->set_title(array('text'=>'Bitcoin value'));
$pc->set_defaults(array(
    'stackSeries'=>true));
$pc->add_plugins(array('highlighter', 'cursor'));
$pc->draw();
?>
</body>
</html>