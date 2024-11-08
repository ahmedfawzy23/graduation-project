<?php
// session_start();
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

function connection2(){
     mysqli_report(MYSQLI_REPORT_ERROR|MYSQLI_REPORT_STRICT);
     $object=mysqli_connect('localhost','root','','breathewise');
     return $object;
        }
        
// Create function to get patient info
function get_patient($pat_id){
    $conn=connection2();
    $stmt=mysqli_prepare($conn,"select * from patient where pat_id=?");
    mysqli_stmt_bind_param($stmt,'i',$pat_id);
    mysqli_stmt_execute($stmt);
    $result=mysqli_stmt_get_result($stmt);
    $patient=mysqli_fetch_assoc($result);
    return $patient;
}
?>