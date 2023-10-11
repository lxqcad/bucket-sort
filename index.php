<?php
    /// The main starting point of the project. Here's where control is transferred to various modules of the system. */
    error_reporting(E_ALL);
    require_once 'inc/config.php';
    session_start();

    $userstr = ' (Guest)';

    if (isset($_SESSION['userid']))
    {
        $loggedin = TRUE;
        $user_id = $_SESSION['userid'];
    }
    else {
        $loggedin = FALSE;
        $user_id = 0;
    }

    if (isset($_SESSION['fileid']))
    {
        $file_id = $_SESSION['fileid'];
    }
    else $file_id = 0;

    $error_message = $message = null;
    if(isset($_GET['logout']))
    {
       if (isset($_SESSION['userid']))
       { 
            destroySession();
            header("refresh:3;url=?page=home");
            echo "<div class='main'><br>" .
                "The system is logging you out.....$approot</div>";
            die();
       }  
       else echo "<div class='main'><br>" .
            "You cannot log out because you are not logged in</div>";
    }
    elseif(isset($_POST['action']))
    {          
        if($_POST['action']=="login") /// If action is login then check the database for specific user email and password 
        {
            $email = sanitizeString($_POST['username']);
            $password = sanitizeString($_POST['password']);
            $token = hash('MD5', "$salt1$password$salt2");
            $res = queryMysql("select id, user_email from user_details where user_email='$email' and user_password='$token'");
            $Results = mysqli_fetch_array($res);
            if(count($Results)>=1)
            {
                $message = $Results['user_email']." Login Sucessful!";

                $_SESSION['userid'] = $user_id = $Results['id'];
                if($file_id > 0) {
                    $res = queryMysql("UPDATE file_details SET user_id=$user_id WHERE id=".$file_id);
                    $res = queryMysql("UPDATE sort_data SET user_id=$user_id WHERE file_id=".$file_id);
                    $message .= "; Your data has been saved to finish later;";
                }
                $loggedin = TRUE;
            }
            else
            {
                $error_message = "Invalid email or password!!";
            }        
        }
        elseif($_POST['action']=="signup") /// If action is signup, then create the user id and store password for new user.
        {
            $email = sanitizeString($_POST['username']);
            $password = sanitizeString($_POST['password']);
            $token = hash('MD5', "$salt1$password$salt2");
            $res = queryMysql("INSERT INTO user_details (user_email, user_password) VALUES ('$email', '$token')");
            $_SESSION['userid'] = $user_id = lastInsertID();
            
            if($file_id > 0) { /// If a file is under process, add the file to the currently added user
                $res = queryMysql("UPDATE file_details SET user_id=$user_id WHERE id=".$file_id);
                $res = queryMysql("UPDATE sort_data SET user_id=$user_id WHERE file_id=".$file_id);
                $message .= "; Your data has been saved to finish later;";
            }
            $loggedin = true;
        }

    }
    /// Include the common header template */
    require 'header_admin.php';
    $redirect = !empty($_GET["page"]) ? sanitizeString($_GET["page"]) : "home";
    if(!empty($_GET["fileid"])) $_SESSION['fileid'] = $file_id = sanitizeString($_GET["fileid"]);
    

    if($loggedin == true) {
        /// The section for logged in users. It's got various links to the relevant pages */
        switch($redirect) {
            case "home": require "inc/model_list.php"; break;
            case "upload": require "inc/model_upload.php"; break;
            case "sort": require "inc/model_sort.php"; break;
            default:
                
                die("Invalid link specified");
        }
    }
    else {
        /// Guest users have their links available here */
        switch($redirect) {
            case "home": case "upload": require "inc/model_upload.php"; break;
            case "list": require "inc/model_list.php"; break;
            case "sort": require "inc/model_sort.php"; break;
            case "login": require "inc/login.php"; break;
        }
    }
    /// Include the common footer for all pages */
    require 'footer.php'; 
?>