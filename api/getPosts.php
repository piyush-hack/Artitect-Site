<?php

$obj = new stdClass();
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    require_once('..//conn.php');
    include_once("../config.php");
    $headers = apache_request_headers();
    $token = $headers['Token'];

    if (verify($token)) {
        $params = json_decode(file_get_contents("php://input"), true);
        if ($params != null)
            $_GET = $params;


        $sql = "SELECT * FROM posts ";

        if (isset($_GET["dataType"]) && $_GET["dataType"] == true) {
            $filter = mysqli_real_escape_string($conn, $_GET["filter"]);    

            $sql = "SELECT * FROM posts where dataType LIKE '%$filter%' ";
        }

        if (isset($_GET["projectType"]) && $_GET["projectType"] == true) {
            $filter = mysqli_real_escape_string($conn, $_GET["filter"]);    

            $sql = "SELECT * FROM posts where projectType LIKE '%$filter%' ";
        }
        // echo "<script>console.log('Debug Objects: " . $filter . "' );</script>";
        $stmt = mysqli_prepare($conn, $sql);
        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_all($res);

            $obj->statusCode = 200;
            $obj->statusMessage = "success";
            $obj->res = $row;
        } else {
            $obj->statusCode = 300;
            $obj->statusMessage = "Unable to execute the MYSQL statement: " . mysqli_stmt_error($stmt);
        }
    } else {
        $obj->statusCode = 400;
        $obj->statusMessage = "Invalid API token";
    }
} else {
    $obj->statusCode = 400;
    $obj->statusMessage = "Invalid request type";
}
echo json_encode($obj);
