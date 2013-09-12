<?php

include_once("include/configz.php");

$success_reply = array();
$error_reply = array();
$err_list_form = array();
$err_list_name = array();
$err_list_email = array();
$err_list_phone = array();
$err_list_message = array();
$err_list_recaptcha = array();

if(($_SERVER['REQUEST_METHOD'] == 'POST') && (!empty($_POST['submit']))){

    $u = new Util();
    $legit = false;
    $checklist = array(
        "name" => false,
        "email" => false,
        "phone" => false,
        "message" => false,
        "recaptcha" => false
    );

    //check name
    if (isset($_POST['name']) && !empty($_POST['name'])){// required
        $err_list_name["fieldvalue"] =$_POST['name'];
        $name = $u->sanitize_input($_POST['name']);
        if(strlen($name) >= 3){
            $checklist["name"] = true;
        }
        else{
            $err_list_name["minlength"] = "Name minimum 3 letters.";
            $err_list_name["fieldvalue"] = $_POST['name'];
        }
    }
    else{
        $err_list_name["required"] = "Please enter a name.";
        $err_list_name["fieldvalue"] = $_POST['name'];
    }

    //check email
    if (isset($_POST['email']) && !empty($_POST['email'])){// required
        $err_list_email["fieldvalue"] = $_POST['email'];
        $email = $u->check_email($_POST['email']);

        if($email){
            $checklist["email"] = true;
        }
        else{
            $err_list_email["email"] = "Please provide a valid email.";
            $err_list_email["fieldvalue"] = $_POST['email'];
        }
    }
    else{
        $err_list_email["required"] = "Please provide an email.";
        $err_list_email["fieldvalue"] = $_POST['email'];
    }

    //check phone
    if (isset($_POST['phone']) && !empty($_POST['phone'])){// required
        $err_list_phone["fieldvalue"] = $_POST['phone'];
        $phone = $u->check_string_is_digit($_POST['phone']);

        if($phone){
            if(strlen($phone) <=12 ){
                $checklist["phone"] = true;
            }
            else{
                $err_list_phone["maxlength"] = "Phone is less than 12 digits.";
                $err_list_phone["fieldvalue"] = $_POST['phone'];
            }
        }
        else{
            $err_list_phone["digits"] = "Phone is in digits only.";
            $err_list_phone["fieldvalue"] = $_POST['phone'];
        }
    }
    else{
        $err_list_phone["required"] = "Please enter a contact number.";
        $err_list_phone["fieldvalue"] = $_POST['phone'];
    }

    //check message
    if (isset($_POST['message']) && !empty($_POST['message'])){// required
        $err_list_message["fieldvalue"] = $_POST['message'];
        $message = $u->sanitize_input($_POST['message']);

        if(strlen($message) <= 300){
            $checklist["message"] = true;
        }
        else{
            $err_list_message["maxlength"] = "Message exceeds 300 character.";
            $err_list_message["fieldvalue"] = $_POST['message'];
        }
    }
    else{
        $err_list_message["required"] = "Please provide your feedback.";
        $err_list_message["fieldvalue"] = $_POST['message'];
    }

    //check recaptcha
    $privatekey = "GET_THE_PRIVATE_KEY_HERE >> HTTPS://WWW.GOOGLE.COM/RECAPTCHA/ADMIN/CREATE";
    $resp = recaptcha_check_answer ($privatekey,
        $_SERVER["REMOTE_ADDR"],
        $_POST["recaptcha_challenge_field"],
        $_POST["recaptcha_response_field"]);
    if (!$resp->is_valid) {
        $err_list_recaptcha["bad-recaptcha"] = "Captcha failed, try again.";
    }
    else{
        $checklist["recaptcha"] = true;
    }

    function check_legit($checklist){
        $problem = 0;
        foreach($checklist as $key => $value){
            if($value == false){
                $problem += 1;
            }
        }
        if($problem){
            return false;
        }else{
            return true;
        }
    }

    $legit = check_legit($checklist);

    if ($legit){

        $mail = new PHPMailer(true);
        $mail->IsSMTP();
        $mail->IsHTML();

        try
        {
            $mail->SMTPDebug = false;// set to true to see all the lines of message when running the SMTP protocol
            $mail->SMTPAuth = true;
            $mail->CharSet = "utf-8";
            $mail->SMTPSecure = "ssl";
            $mail->Port = MAILPORT;
            $mail->Host = MAILHOST;
            $mail->Username = MAILUSER;
            $mail->Password = MAILPASS;
            $mail->SetFrom(MAILFROM, ADMIN2NAME);
            $mail->AddAddress(ADMIN1EMAIL, ADMIN1NAME);
            $mail->AddAddress(ADMIN2EMAIL, ADMIN2NAME);
            $mail->Subject = "ADD_YOUR_EMAIL_SUBJECT_HERE";
            $createdTime = $u->datetime_to_text($u->mysql_time());
            $mail->Body =<<<EMAILBODY
<!DOCTYPE html>
<html>
<head>
<title>Website Form Submission</title>
</head>
<body style="background-color:#efefef;">
<div style="padding:20px;">
<h1 style="color:#444444; margin:0; padding:0;">Dear Administrator;</h1>
<span style="font-size:3.8em; color:#666666; margin:0; padding:0;">You have a message!</span>
<hr>
<p style="margin-bottom:15px;"></p>
<div style="padding:20px; background-color:#ffffff;">
<h3 style="color:#333333;">Message: {$message}</h3>
<h3 style="color:#333333;">Name: {$name}</h3>
<h3 style="color:#333333;">Email: {$email}</h3>
<h3 style="color:#333333;">Phone: {$phone}</h3>
</div>
<p style="margin-bottom:20px;"></p>
</div>
</body>
</html>
EMAILBODY;
            //$mail->WordWrap = 70;
            if($mail->Send()){
                $success_reply["success"] = "Great, we received your message and will get in touch with you soon. Thank you.";
                echo json_encode($success_reply);
            }

        }
        catch (phpmailerException $e)
        {
            echo "Mailer error " . $e->errorMessage();
        }
        catch (exception $e)
        {
            echo "Other error ";
            $e->getMessage();
        }
    }
    else{
        $err_list_form["bad-submit"] = "Please try again with respective fields corrected.";
        $error_reply = [
            "name"=>$err_list_name,
            "email"=>$err_list_email,
            "phone"=>$err_list_phone,
            "message"=>$err_list_message,
            "form"=>$err_list_form,
            "captcha-test"=>$err_list_recaptcha
        ];

        echo json_encode($error_reply);
    }

}
else{
    $err_list_form["no-submit"] = "Please submit the form.";
    echo json_encode($err_list_form);
}
