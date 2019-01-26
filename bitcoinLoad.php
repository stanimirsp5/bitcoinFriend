<?php
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
?>
