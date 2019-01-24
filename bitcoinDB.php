<?php
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
            echo "New bitcoin record created successfully <br>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
    //saveDbRecords();

    function loadDbRecords($currency) {
        $servername = "localhost";
        $username = "root";
        $password = '';
        $dbname = "bitcoindb";
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        $sql = "SELECT id, currency, bitcoinValue, createdOn FROM Bitcoin";
        $result = $conn->query($sql);
        // if ($result->num_rows > 0) {
        //     // output data of each row
        //     while($row = $result->fetch_assoc()) {
        //         echo "Country currency: " . $row["currency"]. ", BitcoinValue " . $row["bitcoinValue"]. " Created on: ". $row["createdOn"].  "<br>";
        //     }
        // } else {
        //     echo "0 results";
        // }
        $conn->close();
        return $result;
    }
    
    if(array_key_exists('test',$_POST)){
        loadDbRecords();
    }
?>
<!-- <h2>Current bitcoin saved</h2>

<form method="post">
    <input type="submit" name="test" id="test" value="List records" /><br/>
</form> -->
