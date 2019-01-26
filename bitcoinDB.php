<?php
    function saveDbRecords() {
        echo "etstettettset";
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
        $conn->close();
        return $result;
    }
    
    if(array_key_exists('test',$_POST)){
        loadDbRecords();
    }
    if(array_key_exists('saveData',$_POST)){
        saveDbRecords();
    }
?>
<!-- <h2>Current bitcoin saved</h2>

<form method="post">
    <input type="submit" name="test" id="test" value="List records" /><br/>
</form> -->
