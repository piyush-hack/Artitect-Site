<?php

    $obj = new stdClass();
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once('../conn.php');
        include_once("../config.php");
        
        $headers = apache_request_headers();
        $token = $headers['Token'];

        if(verify($token)) {
            $params = json_decode(file_get_contents("php://input"), true);
            
            if($params != null)
                $_POST = $params;

            $obj->params = $params;
            $title = mysqli_real_escape_string($conn, $_POST["title"]);
            $imgUrl = mysqli_real_escape_string($conn, $_POST["imgUrl"]);
            $dataType = mysqli_real_escape_string($conn, $_POST["dataType"]);
            $projectType = mysqli_real_escape_string($conn, $_POST["projectType"]);
            $subText = mysqli_real_escape_string($conn, $_POST["text"]);
            try {
                mysqli_begin_transaction($conn);
                $sql = "INSERT INTO posts(title, imgUrl, dataType, projectType , subText) VALUES(?,?,?,?,?)";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, 'sssss', $title, $imgUrl, $dataType, $projectType, $subText);
                if(mysqli_stmt_execute($stmt)) {
                    // $storyID = mysqli_insert_id($conn);

                            $obj->statusCode = 200;
                            $obj->statusMessage = "success";
                            //commit
                            mysqli_commit($conn);   
                }
                else {
                    $obj->statusCode = 300;
                    $obj->statusMessage = "Unable to execute MySQL statement ".mysqli_stmt_error($stmt);
                }
            }
            catch(Exception $e) {
                $obj->statusCode = 300;
                $obj->statusMessage = $e->getMessage();
            }
        }
        else {
            $obj->statusCode = 400;
            $obj->statusMessage = "Invalid API token";
        }
    }
    else {
        $obj->statusCode = 400;
        $obj->statusMessage = "Invalid request type";
    }
    echo json_encode($obj);
