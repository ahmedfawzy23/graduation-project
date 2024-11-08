<?php
include '../../inc/headerPages.php';
require_once "../../inc/connection_report.php";

        if (!isset($_SESSION['doc_id'])) {
            header('location:../../home.php');
          }
          
          if (isset ($_GET['pat_id'])){
            $pat_id=$_GET['pat_id'];
            $record_id=$_GET['record_id'];
            $patient=get_patient($pat_id);   
          }

        $doc_id = $docInfo['doc_id'];

        $select = "SELECT `patient`.`pat_id` ,`first_name`, `last_name`, `gender`,`date_of_birth`,`phone`,`country`,`state`,`city`, `result`,`result2`,`per_1`,`per_2`
        FROM patient 
               join `model result`
                   ON `patient`.`pat_id` = `model result`.`pat_id`
               WHERE `doc_id` = $doc_id &&`patient`. `pat_id` = $pat_id && `record_id` = $record_id";

        $result = mysqli_query($conn, $select);
        if(mysqli_num_rows($result)>0){
        $patients = mysqli_fetch_assoc($result);
        }
     

      /*
       $pat_id=$_GET['pat_id']
       $user=get_patient($pat_id);
       echo"<pre>";
       print_r($user);
       echo"</pre>";*/

?>
<?php include '../../inc/navbar.php';?>


 <div class="main-panel">
        <div class="content-wrapper">
          <div class="page-header">
        <h2 class="page-title"> Patient's Report </h2>
          </div>

  <h3>Patient's Personal Information </h3>
          <hr>
 
  <title>data</title>
  <style>
            table, td, th {
                border: 2px solid black;
                width: 70%;
            }
            table {
                border-collapse: collapse;
            }
            th {
                text-align: left;
                background-color: #364968;
            }
            th, td {
                padding: 15px;
            }
    </style>
 
 
    <body>
<div class="tableone">
        <table>
            <tr>
                <th>Patient's ID </th>
                <td> <span class="repodata"> <?=$patients['pat_id'] ?><span></td>    
            </tr>
            <tr>
                <th> Patient's full name </th>
                <td><span class="repodata"> <?=$patients['first_name']." ".$patient['last_name']?><span></td>
            </tr>
            <tr>
                <th>Patient's gender </th>
                <td><span class="repodata"> <?=$patients['gender']?><span></td>
            </tr>
            <tr>
                <th>Patient's date of birth</th>
                <td><span class="repodata"><?=$patients['date_of_birth']?><span></td>
            </tr>

            <tr>
                <th>Patient's phone</th>
                <td><span class="repodata"><?=$patients['phone']?><span></td>         
            </tr>

            <tr>
                <th>Patient's country </th>
                <td><span class="repodata"> <?=$patients['country']?><span></td>         
            </tr>

            <tr>
                <th>Patient's city</th>
                <td><span class="repodata"><?=$patients['city']?><span></td>         
            </tr>

            <tr>
                <th>Patient's state</th>
                <td><span class="repodata"><?=$patients['state']?><span></td>         
            </tr>
            
        </table>
        </div>
<hr>
  <h3>Patient's Diagnosis  </h3>

<div class="tableone">
        <table>
            <tr>
                <th>Result1</th>
                <td> <span class="repodata"><?=  $patients['result'] ?><span></td>    
            </tr>
            <tr>
                <th> Certainty</th>
                <td><span class="repodata"><?=$patients['per_1']?><span></td>
            </tr>
            <tr>
                <th>Result2</th>
                <td><span class="repodata"><?=$patients['result2']?><span></td>
            </tr>
            <tr>
                <th> Certainty</th>
                <td><span class="repodata"><?=$patients['per_2']?><span></td>
            </tr>
               <tr>
                <th> Final result</th>
                <td><span class="repodata"> <?php
               $p1=$patients['per_1'];
               $p2=$patients['per_2'];
               if ($p1>$p2){ 
                  print ($patients['result']);  
                }
              else{
                   print ( $patients['result2']);    
                }
                ?>
                <span>
               
            </td>
            </tr>
            
        </table>
            </div>
            <br>
            <br>
            
            <!-- <center><button class="badge2" onclick="window.print()">Print Report</button></center>  -->
            <center><a href="handle_report.php?pat_id=<?= $pat_id?>&record_id=<?= $record_id?>"><button class="badge2">Print Report</button></a></center> 

        
      </div> 
 
                  
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.php -->

        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <?php include '../../inc/footer.php' ?>
  