<?php

/**
 * @author ScarLight
 * @copyright 2011
 */

class Util{

    public function strip_all_slashes($text)
    {
        $times = strlen($text);
        $i = 0;

        // loop will execute $times times.
        while (strstr($text, '\\') && $i != $times)
        {
            $text = stripslashes($text);
            $i++;
        }
        return $text;
    }

    public function strip_this_char($search, $replace, $subject){
        return str_replace($search, $replace, $subject);
    }

    public function sanitize_input($input, $allowedTags = "", $allowJavaScript = false, $allowFlash = false)
    {
        $input = trim($input);
        $input = strip_tags($input, $allowedTags);
        if (!$allowJavaScript)
        {
            $input = preg_replace('#]*>.*?#is', '', $input);
        }

        if (!$allowFlash)
        {
            $input = preg_replace("/<object[0-9 a-z_?*=\":\-\/\.#\,\\n\\r\\t]+/smi", "", $input);
        }

        $input = $this->strip_all_slashes($input);

        return $input;
    }

    public function check_email($input)
    {
        $pattern = "/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/";
        $email = $input;

        return (preg_match($pattern, $email)) ? $email : false;
    }

    public function check_string_is_digit($input){
        return ctype_digit($input) ? $input : false;
    }

    public function strip_zeros_from_date( $marked_string="" ){
        // first remove the marked zeros
        $no_zeros = str_replace('*0', '', $marked_string);
        // then remove any remaining marks
        $cleaned_string = str_replace('*', '', $no_zeros);
        return $cleaned_string;
    }

    public function mysql_time(){
        $mysqlAcceptedTimeStamp = strftime("%Y-%m-%d %H:%M:%S", time());
        return $mysqlAcceptedTimeStamp;
    }

    public function show_year(){
        $year = strftime("%Y", time());
        return $year;
    }

    public function datetime_to_text($datetime=""){
        $unixdatetime = strtotime($datetime);
        return strftime("%B %d, %Y at %I:%M %p", $unixdatetime);
    }

    //upload error
    public function check_upload_error($err){
        $upload_errors = array(
            UPLOAD_ERR_OK 			=> "No errors.",
            UPLOAD_ERR_INI_SIZE  	=> "Larger than upload_max_filesize.",
            UPLOAD_ERR_FORM_SIZE 	=> "Larger than form MAX_FILE_SIZE.",
            UPLOAD_ERR_PARTIAL 		=> "Partial upload.",
            UPLOAD_ERR_NO_FILE 		=> "No file.",
            UPLOAD_ERR_NO_TMP_DIR   => "No temporary directory.",
            UPLOAD_ERR_CANT_WRITE   => "Can't write to disk.",
            UPLOAD_ERR_EXTENSION 	=> "File upload stopped by extension."
        );

        return $error_message = $upload_errors[$err];
    }

    public function log_form_details($firstName, $contact, $email, $quantity, $message, $extension, $secure_file_name){
        $file = "form_log.txt";
        $insert = "========================================================"."\n"
            ."TIMESTAMP   :".mysql_time()."\n"
            ."EXTENSION   :".$extension."\n"
            ."FILE_NAME   :".$secure_file_name."\n"
            ."NAME        :".$firstName."\n"
            ."CONTACT     :".$contact."\n"
            ."EMAIL       :".$email."\n"
            ."QUANTITY    :".$quantity."\n"
            ."MESSAGE     :".$message."\n"
            ."========================================================"."\n";

        if($handle = fopen($file, 'a')){
            fwrite($handle, $insert);
            fclose($handle);
        }
        else{
            echo "Could not open file for writing.";
        }
    }
}

?>