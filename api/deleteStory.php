<?php  

    $obj = new stdClass();
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once('../../db/conn.php');
        $headers = apache_request_headers();
        $token = $headers['Token'];

        
        if(verify($token)) {
            $params = json_decode(file_get_contents("php://input"), true);
            if($params != null)
                $_POST = $params;
            $storyID = mysqli_real_escape_string($conn, $_POST["story_id"]);
            
            $sql = "DELETE FROM stories where story_id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, 's', $storyID);
            if(mysqli_stmt_execute($stmt)) {
                $obj->statusCode = 200;
                $obj->statusMessage = "success";
            }
            else {
                $obj->statusCode = 300;
                $obj->statusMessage = "Unable to execute the MYSQL statement: ".mysqli_stmt_error($stmt);
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

?>