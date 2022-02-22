<?php

    $obj = new stdClass();
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once('../../db/conn.php');
        include_once("../../config.php");

        function uploadImage($filename) {
            $target_dir = $_SERVER['DOCUMENT_ROOT'] . '' . FOLDERS_BASE_URL . "stories_cover_images/";
            $target_file = $target_dir . basename($_FILES["cover_image"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            $target_file = $target_dir . '' . $filename . ".{$imageFileType}";

            // Check if image file is a actual image or fake image
            if(isset($_POST["submit"])) {
                $check = getimagesize($_FILES["cover_image"]["tmp_name"]);
                if($check !== false) {
                    $uploadOk = 1;
                } else {
                    throw new Exception('File is not an Image');
                    $uploadOk = 0;
                }
            }

            // // Check if file already exists
            // if (file_exists($target_file)) {
            //     throw new Exception('File already exists');
            //     $uploadOk = 0;
            // }

            // Check file size
            if ($_FILES["cover_image"]["size"] > 1000000) {
                throw new Exception('Your file is too large');
                $uploadOk = 0;
            }

            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                throw new Exception('Sorry, only JPG, JPEG & PNG files are allowed.');
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                throw new Exception('Sorry, your file was not uploaded.');
            } else {
                if (move_uploaded_file($_FILES["cover_image"]["tmp_name"], $target_file)) {
                    return $filename . ".{$imageFileType}";
                } else {
                    throw new Exception('Sorry, there was an error uploading your file.');
                }
            }
        }
        
        $headers = apache_request_headers();
        $token = $headers['Token'];

        if(verify($token)) {
            $params = json_decode(file_get_contents("php://input"), true);
            if($params != null)
                $_POST = $params;
            $userID = mysqli_real_escape_string($conn, $_POST["user_id"]);
            $storyID = mysqli_real_escape_string($conn, $_POST["story_id"]);
            $storyTitle = mysqli_real_escape_string($conn, $_POST["title"]);
            $storyText = mysqli_real_escape_string($conn, $_POST["text"]);
            $storyLanguageID = mysqli_real_escape_string($conn, $_POST["language_id"]);
            $tags = mysqli_real_escape_string($conn, $_POST["tags"]);
            $tagsIDs = explode(',',$tags);
            $isCoverImage = true;
            if (!isset($_FILES['cover_image']) || $_FILES['cover_image']['error'] == UPLOAD_ERR_NO_FILE) $isCoverImage = false;
            try {
                mysqli_begin_transaction($conn);
                $sql = "UPDATE stories SET story_title = ?, story_text = ?, f_lang_id = ? where story_id = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, 'ssss', $storyTitle, $storyText, $storyLanguageID, $storyID);
                if(mysqli_stmt_execute($stmt)) {

                    $deleteTagsSql = "DELETE FROM stories_tags where f_story_id = ?";
                    $deleteTagsStmt = mysqli_prepare($conn, $deleteTagsSql);
                    mysqli_stmt_bind_param($deleteTagsStmt, 's', $storyID);
                    mysqli_stmt_execute($deleteTagsStmt);

                    $sqlTags = "INSERT INTO stories_tags(f_story_id, f_tag_id) VALUES(?,?)";
                    $sqlTagsStmt = mysqli_prepare($conn, $sqlTags);
                    
                    $flag = false;
                    foreach ($tagsIDs as $tag) {
                        mysqli_stmt_bind_param($sqlTagsStmt, 'is', $storyID, $tag);
                        if(!mysqli_stmt_execute($sqlTagsStmt)) $flag = true;
                    }

                    if(!$flag) {
                        if(!$isCoverImage) {
                            $obj->statusCode = 200;
                            $obj->statusMessage = "success";
                            //commit
                            mysqli_commit($conn);
                        }
                        else {
                            //upload cover image
                            $filename = "IMG_{$storyID}{$userID}";
                            try {
                                $cover_image_url = uploadImage($filename);
                                //update database with the cover image URL
                                $sqlImageUpdate = "UPDATE stories SET story_cover_image_url = ? where story_id = ?";
                                $sqlImageStmt = mysqli_prepare($conn, $sqlImageUpdate);
                                //echo mysqli_error($conn);
                                mysqli_stmt_bind_param($sqlImageStmt, 'si', $cover_image_url, $storyID);
                                if(mysqli_stmt_execute($sqlImageStmt)) {
                                    $obj->statusCode = 200;
                                    $obj->statusMessage = "success";
                                    //commit
                                    mysqli_commit($conn);
                                }
                                else {
                                    $obj->statusCode = 300;
                                    $obj->statusMessage = "Unable to execute MySQL statement ".mysqli_stmt_error($stmt);
                                    //delete cover image
                                    if(file_exists($cover_image_url)) unlink($cover_image_url);
                                    //rollback
                                    mysqli_rollback($conn);
                                }
                            }
                            catch(Exception $e) {
                                $obj->statusCode = 300;
                                $obj->statusMessage = "Unable to upload the cover image ".$e->getMessage();
                                //rollback
                                mysqli_rollback($conn);
                            }
                        }
                    }
                    else {
                        $obj->statusCode = 300;
                        $obj->statusMessage = "Unable to execute MySQL statement ".mysqli_stmt_error($stmt);
                    }
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

?>