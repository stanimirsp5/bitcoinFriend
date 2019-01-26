<?php
saveDbRecords();
    function saveDbRecords() {
        $servername = "localhost";
        $username = "root";
        $password = '';
        $dbname = "bitcoindb";

        $currency = $_GET['currency'];
        $btc = $_GET['btc'];

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        $sql = "INSERT INTO Bitcoin (currency, bitcoinValue)
        VALUES ('$currency', '$btc')";

        if ($conn->query($sql) === TRUE) {
           // echo "New bitcoin record created successfully <br>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
        // header("Location:http://localhost/bitcoin/action.php");
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>BitcoinPal</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
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
</style>
</head>
<body>

<div class="header">
  <h1>Saved</h1>
</form>
</div>
</div>
</body>
</html>
<!-- http://localhost/bitcoin/bitcoin.php -->