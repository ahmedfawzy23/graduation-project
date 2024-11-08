<?php 
session_start();
require_once("../../inc/connection.php");

if (isset($_POST['register'])) {
    //data
    extract($_POST);

    //validation
    $name_errors =[];
    $email_errors =[];
    $password_errors =[];
    $other_errors =[];

    //name => required | string | min 3
    if(empty($name))
    {
        $name_errors[] ="name is required";
    }
    elseif(!is_string($name))
    {
        $name_errors[] ="name must be string";
    }
    elseif(strlen($name)<=3)
    {
        $name_errors[] ="name must be more than 3 char";
    }


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
        $password_errors[] ="password is required";
    }
    elseif(strlen($password)<4)
    {
        $password_errors[] ="password must be more than 4";
    } elseif($password != $re_password)
    {
        $password_errors[] ="password does not match";
    }



    if(empty($name_errors)&&empty($email_errors)&&empty($password_errors))
    {
        $select = "SELECT `doc_email` FROM `doctor` WHERE `doc_email` = '$email';";
        $result = mysqli_query($conn, $select);
        $numRows = mysqli_num_rows($result);
        if ($numRows>0) {
            $_SESSION['other_errors'][] ="email already exist";
            $_SESSION['name'] = $name;
            header("location: ../register.php");

        }else{
            $password = password_hash($password, PASSWORD_DEFAULT);

            $insert = "INSERT INTO `doctor` (`doc_name`, `doc_email`, `doc_password`) VALUES ('$name', '$email', '$password')";
            $select = "SELECT LAST_INSERT_ID();";
            $insert_result = mysqli_query($conn, $insert);
            $select_result = mysqli_query($conn, $select);

        if($insert_result && $select_result){

            $doc_id = mysqli_fetch_assoc($select_result);
            $_SESSION['doc_id'] = $doc_id['LAST_INSERT_ID()'];    
            require_once "../../inc/docInfo.php";
            require_once "../../registerEmail.php";
            header("location:../../index.php");
        } else{
            $_SESSION['other_errors'][] = "error";
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            $_SESSION['password'] = $password;
            $_SESSION['re_password'] = $re_password;
            header("location: ../register.php");
        }
        }
        } 
        else{

            $_SESSION['name_errors'] = $name_errors;
            $_SESSION['email_errors'] = $email_errors;
            $_SESSION['password_errors'] = $password_errors;
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            $_SESSION['password'] = $password;
            $_SESSION['re_password'] = $re_password;

            header("location: ../register.php");

        }
    }

else{
    header("location: ../register.php");
}

        ?>