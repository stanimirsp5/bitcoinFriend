<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>BitcoinPal</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
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
body {
  font-family: Arial;
  margin: 0;
}
.header {
  padding: 60px;
  text-align: center;
  background: #1abc9c;
  color: white;
  font-size: 30px;
}
.content {padding:20px;}
.navbar {
  overflow: hidden;
  background-color: #333;
  position: sticky;
  position: -webkit-sticky;
  top: 0;
  height: 43px;
}

#go-back{
    position: absolute;
    left: 69%;
    top: 2%;
}
#list-records{
    position: absolute;
    left: 45%;
    top: 2%;
}
#save-btn{
    position: absolute;
    left: 20%;
    top: 2%;
}
.button {
  background-color: #e7e7e7; color: black; /* Green */
  border: none;
  padding: 7px 12px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
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
    $filteredResult = array();

    $bitcoinValue1 = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            if($row["currency"] == $currency){
               $filteredResult[] = $row;
               $bitcoinValue1[] = (int)$row["bitcoinValue"];
            }
        }
    } else {
        echo "0 results";
    }   
?>

<div class="header">
<h2>Price of one bitcoin to <?=$currency ?></h2>
<p>1 Bitcoin = <?=round($btc,2) ?> <?=$currency ?>
</div>

<div class="navbar">

<form method="post" action="bitcoinDB.php">
 <input type="hidden" name="currency" value="<?=$currency?>">
 <input type="hidden" name="btc" value="<?=$bitcoinValue?>">
 <input class="button" id="save-btn" type="submit" value="Save search info">
</form>

 <input class="button" id="list-records" type="button" name="loadAllRecords" value="List records" />
 <input class="button" id="toggle-graph" type="button" name="loadAllRecords" value="Hide graph" />
<input class="button"  id="go-back" type="button" value="Go back" class="homebutton" id="btnHome" 
onClick="document.location.href='http://localhost/bitcoin/bitcoin.php'"/>
</div>

<br>
<script>
$(document).ready(function(){
  $("#list-records").click(function(){
    $("#records-table").toggle();
  });
});
$(document).ready(function(){
  $("#toggle-graph").click(function(){
    $("#php-graph").toggle();
  });
});
</script>

<div style="display: none" id="records-table">
<?php if (count($filteredResult) > 0): ?>
<table >
  <thead>
    <tr>
    <th>Id</th>
    <th>Currency</th>
    <th>Value</th>
    <th>Date</th>
      <!-- <th><?php echo implode('</th><th>', array_keys(current($filteredResult))); ?></th> -->
    </tr>
  </thead>
  <tbody>
<?php foreach ($filteredResult as $row): array_map('htmlentities', $row); ?>
    <tr>
      <td><?php echo implode('</td><td>', $row); ?></td>
    </tr>
<?php endforeach; ?>
  </tbody>
</table>
<?php endif; ?>
</div>

<div id="php-graph">
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