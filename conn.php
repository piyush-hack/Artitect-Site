<?php

    //error_reporting(E_ALL);
    //error_reporting(0);
    //ini_set('display_errors', '1');

    $conn = mysqli_connect("localhost","root","","rajdb");
    if(!$conn)
        echo "Failed to connect to the database";
        
    mysqli_set_charset($conn, 'utf8mb4');
    date_default_timezone_set("Asia/Kolkata");
    $sql = "SET SESSION time_zone = '+5:30'";
    mysqli_query($conn, $sql);

    function verify($key) {
        if($key === "PK,4y}^(apz%8in!.8IzgpoOQ,KVG&lfVAPT()3[WzXdX-Z" || $key === "9nnZulSzmLSTKbUmShfnKY88xvHlrla81P1n1b4X") {
            return true;
        }
        return false;
    }

?>