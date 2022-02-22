<?php

include_once("../config.php");
function sendGCM($message, $id)
{



    $url = 'https://fcm.googleapis.com/fcm/send';

    $fields = array(
        'to' => $id,
        'notification' =>  $message,
        'webpush' => array(
            "fcm_options" => array(
                "link" => "https://piyushxyz.com"
            )
        )
    );
    $fields = json_encode($fields);

    $headers = array(
        'Authorization: key=' . "AAAAll7CucQ:APA91bGPd0RYXWX0RI0sYvgQ8tSRws3zqs0w_RDhkx4vYDBdT9-XoKTJMxJP4CiVSduYvUIPevU_LHIwJlCSuAtj_jkRSeYNJ5PJPOWlVxP91QpNiUHYTG61l0cTm0nhRZ7P6DFPDF0r",
        'Content-Type: application/json'
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

    $result = curl_exec($ch);
    echo $result;
    curl_close($ch);
}

$data = array(
    "title" => "Testing",
    "body" => "new message"
);
sendGCM($data, "f1FTqfKziGZECGm_j1L_Ic:APA91bFhr6wW9kRg0BHUIuRXGMaLD19YtX7nBraQcpAAYuF_GyWsbMebUftqn1Ys1XsE19lwvfdO0XPf_D971O5NhRE1UMa3MiIWqs86MnaBV6CEdAdJOcpEGro0ExYQ5YYKj1BHGHep");
