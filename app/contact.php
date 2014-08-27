<?php

    $to_Email       = "talktwomey@gmail.com"; //Replace with recipient email address
    $subject        = 'RSVP'.generateRandomString(); //Subject line for emails
    
    
    //check if its an ajax request, exit if not
    // if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    
    //     //exit script outputting json data
    //     $output = json_encode(
    //     array(
    //         'type'=>'error', 
    //         'text' => 'Request must come from Ajax'
    //     ));
        
    //     die($output);
    // } 
    

    //Sanitize input data using PHP filter_var().
    $user_name        = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
    $user_contact       = filter_var($_POST["contact"], FILTER_SANITIZE_EMAIL);
    $user_response       = filter_var($_POST["response"], FILTER_SANITIZE_STRING);
    $user_comments     = filter_var($_POST["comments"], FILTER_SANITIZE_STRING);
    $user_bus     = filter_var($_POST["bus"], FILTER_SANITIZE_STRING);
    
    
    //proceed with PHP email.
    $headers = 'From: rsvp@annieandtim.info' . "\r\n" .
    'Reply-To: rsvp@annieandtim.info' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
    
        // send mail
    $sentMail = @mail($to_Email, $subject, $_POST["name"].' - '.$user_contact.' - '.$user_response.' - '.$user_comments.' - '.$user_bus, $headers);
    
    if(!$sentMail)
    {
        $output = json_encode(array('type'=>'error', 'text' => 'Opps, something went wrong. Perhaps you could email your repsonse instead.'));
        die($output);
    }else{
        $output = json_encode(array('type'=>'message', 'text' => "Thank you for your response. If you have any questions or comments, we'll be sure to get back to you as soon as we can."));
        die($output);
    }


function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}
?>