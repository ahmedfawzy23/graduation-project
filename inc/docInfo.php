<?php
session_start();
require_once "connection.php";
$docId = $_SESSION['doc_id'];



$select = "SELECT * FROM `doctor` WHERE `doc_id` = '$docId ';";
        $result = mysqli_query($conn, $select);
        if($result){
        $numRows = mysqli_num_rows($result);
        if ($numRows>0) {
            $docInfo = mysqli_fetch_assoc($result);
            
            }
          }

          $docName = $docInfo['doc_name']; 
          $doc_email=$docInfo['doc_email'];
          $docImg = $docInfo['image_path'];


?>
