 <?php 
// session_start();
require_once "../../inc/docInfo.php";
require_once "../../inc/api.php";
require_once "../../inc/connection_report.php";

$doc_id = $docInfo['doc_id'];
?>

<?php

$first_name_errors=[];
$last_name_errors=[];
$gender_errors=[];
$date_errors=[];
$phone_errors=[];
$country_errors=[];
$city_errors=[];
$state_errors=[];
$rec_errors=[];
$registered=[];
 

if (isset($_POST['submit'])) {
    //data
    $extension = pathinfo($_FILES["record"]["name"], PATHINFO_EXTENSION);
    $dst_fname =  getcwd() . '\\records\\' . time() . uniqid(rand()) . '.' . $extension;
    $dst_fname = str_replace('\/', '//', $dst_fname);
    move_uploaded_file($_FILES["record"]["tmp_name"],  $dst_fname);
    $result = classify_record($dst_fname);

    $result_1 = $result['Disease_Name(RNN)'];
    $per_1 = $result['First_Confidence(RNN)'];
    $result_2 = $result['Disease_Name(GRU)'];
    $per_2 = $result['Second_confidence(GRU)'];
  

    extract($_POST);

    //validation
 
    //fname => required | string | min 3

    if(empty($fname))
    {
        $first_name_errors[] ="First name is required";
    }
    elseif(is_numeric($fname))
    {
        $first_name_errors[] ="First name must be string";
    }
    elseif(strlen($fname)< 3)
    {
        $first_name_errors[] ="First name must be at least 3 char";
    }

    //lname => required | string | min 3
    if(empty($lname))
    {
        $last_name_errors[] ="Last name is required";
    }
    elseif(is_numeric($lname))
    {
        $last_name_errors[] ="Last name must be string";
    }
    elseif(strlen($lname)< 3)
    {
        $last_name_errors[] ="Last name must be at least 3 char";
    }



    //gender => required | true
    if(empty($gender))
    {
        $gender_errors[] ="gender is required";
    }
    elseif( $gender != "male" && $gender != "female")
    {
        $gender_errors[] ="gender not correct";
    }
    


    //date => required
    if(empty($date))
    {
        $date_errors[]="Date is required";
    }

  //phone  => required | 11 numbers
    if(empty($phone))
    {
        $phone_errors[] ="this field is required";
    }
    elseif(strlen($phone)>11||strlen($phone)<11)
    {
        $phone_errors[]  ="phone number must be 11 numbers ";
    } 

    // country required | string
    if(empty($country))
    {
        $country_errors[] ="this field is required";
    } 
    elseif(is_numeric($country)){
        $country_errors[]  ="country must be string ";
    } 

    //city  => required | string  
    if(empty($city))
    {
        $city_errors[] ="this field is required";
    } 
    elseif(is_numeric($city)){
        $city_errors[]  ="city must be string ";
    } 

    //state  => required | string      
    if(empty($state))
    {
        $state_errors[] ="this field is required";
    } 

    elseif(is_numeric($state)){
        $state_errors[]  ="state must be string ";
    } 


$extensions = ['wav', 'mp3'];
$rec = $_FILES['record'];
$recName  = $rec['name'];
$recSize  = $rec['size'];
$recTmp  = $rec['tmp_name'];
$recFullPath  = $rec['full_path'];
$exe = pathinfo($recFullPath, PATHINFO_EXTENSION);


if(empty($recName)){
    $rec_errors[] ="record is required";

}
else if (!in_array($exe, $extensions))
{
    $rec_errors[] = 'record extension not valid';
}





    if(empty($first_name_errors) && empty($last_name_errors)&& empty($gender_errors)&& empty($date_errors)
    && empty($phone_errors) && empty($country_errors)&& empty($city_errors)&& empty($state_errors)&& empty($rec_errors))
    {
        $insertPatient = "INSERT INTO `patient` (`first_name`, `last_name`, `gender`, `date_of_birth`, `phone`, `country`, `state`, `city`, `doc_id` )
        VALUES ('$fname', '$lname', '$gender', '$date', '$phone', '$country', '$state', '$city', '$doc_id');";
        $select = "SELECT LAST_INSERT_ID();";

        
        $insert_patient_result = mysqli_query($conn, $insertPatient);
        $select_id_result = mysqli_query($conn, $select);

        if($insert_patient_result && $select_id_result){

            $select_id_result = mysqli_fetch_assoc($select_id_result);
            $pat_id = $select_id_result['LAST_INSERT_ID()'];    


        $insertRecord = "INSERT INTO `model result` (`record_path`, `result`,`result2`,`per_1`,`per_2`,    `pat_id`)
        VALUES ('$recName', '$result_1','$result_2','$per_1','$per_2', '$pat_id');";
        $Record_result = mysqli_query($conn, $insertRecord);
        if ($Record_result) {
            
            $success ="patient added successfully";
            header("location: upload.php");

        }  else {
            $errors[] = 'error while insert record';
        }

            } else {
                $errors[] = 'error while insert patient';
            }
        
        

        } 

        else{
            $_SESSION['first_name_errors'] = $first_name_errors;
            $_SESSION['last_name_errors'] = $last_name_errors;
            $_SESSION['gender_errors'] = $gender_errors;
            $_SESSION['date_errors'] = $date_errors;
            $_SESSION['phone_errors'] = $phone_errors;
            $_SESSION['country_errors'] = $country_errors;
            $_SESSION['city_errors'] = $city_errors;
            $_SESSION['state_errors'] = $state_errors;
            $_SESSION['rec_errors'] = $rec_errors;           
            $_SESSION['registered'] = $registered;            
            $_SESSION['fname'] = $fname;
            $_SESSION['lname'] = $lname;
            $_SESSION['gender'] = $gender;
            $_SESSION['date'] = $date;
            $_SESSION['phone'] = $phone;
            $_SESSION['country'] = $country;
            $_SESSION['state'] = $state;
            $_SESSION['city'] = $city;          
            header("location: upload.php");

        }
    }

else{
    header("location: upload.php");
}

        ?>
