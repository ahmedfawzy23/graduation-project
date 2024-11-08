<?php 
session_start();
require_once("../../inc/connection.php");

if (isset($_POST['login'])) {
    //data
    extract($_POST);

    //validation
    $email_errors =[];
    $pass_errors =[];
    $both_errors =[];


    //email => required | email | unique
    if(empty($email))
    {
        $email_errors[] ="email is required";
    }
    elseif( !filter_var($email,FILTER_VALIDATE_EMAIL))
    {
        $email_errors[] ="email not valid";
    }
    


    //password => required | min:4
    if(empty($password))
    {
        $pass_errors[] ="password is required";
    }
    elseif(strlen($password)<4)
    {
        $pass_errors[] ="password must be more than 4";
    }


    if(empty($email_errors)&&empty($pass_errors))
    {
        $select = "SELECT * FROM `doctor` WHERE `doc_email` = '$email';";
        $result = mysqli_query($conn, $select);
        if($result){
        $numRows = mysqli_num_rows($result);
        if ($numRows==1) {
            $varify = mysqli_fetch_assoc($result);
            
            if(password_verify($password, $varify['doc_password'])){
                $_SESSION['doc_id'] = $varify['doc_id'];
                header("location:../../index.php");
 
            }
        
           else {
                $_SESSION['both_errors'][] ="email or password is wrong";
                header("location: ../login.php");
            }
        }
         else {
            $_SESSION['both_errors'][] ="email or password is wrong";
            header("location: ../login.php");
        }
    } 
    
    else{
        $_SESSION['both_errors'][] = "error";
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;
        header("location: ../login.php");
    }
    }
         else{
        $_SESSION['email_errors'] = $email_errors;
        $_SESSION['pass_errors'] = $pass_errors;   
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;
        header("location: ../login.php");
        }
        
        }else {
            header('location: ../login.php');
        }

            ?>

