<?php
include '../../inc/headerPages.php';
require_once "../../inc/docInfo.php";
require_once "../../inc/api.php";
require_once "../../inc/connection_report.php";



if (!isset($_SESSION['doc_id'])) {
  header('location:../../home.php');
}

$record='';
$pat_id ='';
$doc_id = $docInfo['doc_id'];
?>

<?php

$id_errors =[];
$rec_errors =[];

 

if (isset($_POST['upload'])) {
 
    //data
    extract($_POST);
    
    //validation

    if(empty($pat_id))
    {
       $id_errors[] ="patient id is required";
    }
    elseif(!is_numeric($pat_id))
    {
       $id_errors[] ="patient id must be number";
    }
    elseif($pat_id<=0)
    {
       $id_errors[] ="patient id must be more than 1";
    }

$extensions = ['wav', 'mp3'];
$rec = $_FILES['record'];
$recName  = $rec['name'];
$recSize  = $rec['size'];
$recTmp  = $rec['tmp_name'];
$recFullPath  = $rec['full_path'];
$exe = pathinfo($recFullPath, PATHINFO_EXTENSION);

$dst_fname =  getcwd() . '\\records\\' . time() . uniqid(rand()) . '.' . $exe;
    $dst_fname = str_replace('\/', '//', $dst_fname);
    move_uploaded_file($_FILES["record"]["tmp_name"],  $dst_fname);
    $result = classify_record($dst_fname);

    $result_1 = $result['Disease_Name(RNN)'];
    $per_1 = $result['First_Confidence(RNN)'];
    $result_2 = $result['Disease_Name(GRU)'];
    $per_2 = $result['Second_confidence(GRU)'];




    if(empty($recName)){
        $rec_errors[] ="record is required";

    }else if (!in_array($exe, $extensions)){
        $rec_errors[] = 'record extension not valid';
    }





    if(empty($id_errors) && empty($rec_errors))
    {
      $select = "SELECT `pat_id` FROM patient WHERE `doc_id` = $doc_id AND `pat_id` = $pat_id;";
      $select_result = mysqli_query($conn, $select);
      if (mysqli_num_rows($select_result)>0) {
            
        $insertRecord = "INSERT INTO `model result` (`record_path`, `result`,`result2`,`per_1`,`per_2`, `pat_id`)
        VALUES ('$recName', '$result_1','$result_2','$per_1','$per_2', $pat_id);";
                $Record_result = mysqli_query($conn, $insertRecord);

                if ($Record_result) {

                    header("location: old_patient.php");
        
                }   
              } else {
                $id_errors[] ="patient not exist";

              }
            }
}

        ?>
<?php include '../../inc/navbar.php';?>

      <!-- partial -->
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">

          <!-- uplaod audio section -->
          <form class="form-sample" action="old_patient.php" method="post"  enctype="multipart/form-data">
          <div class="drag-area">
            <div class="icon"><i class="fa fa-cloud-upload-alt"></i></div>
            <header> Upload Your audio file</header>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
            <br>
            <button class="uploadbutton"> <input type="file" name = "record" id="upload" accept=".wav,.mp3" value="<?php echo $record ;?>"> </button>
          <!-- record error -->            
          <?php 
                          if(isset($rec_errors)){
                          foreach($rec_errors as $error){
                          echo "<p style='font-size:16px; color: #fc424a;'>$error</p>";
                          }
                          } 
                          ?>  
            <br>
            <!-- patient id part -->
            <input class="uploadbutton" type="number"  name="pat_id" placeholder="patient id" value="<?php echo $pat_id ;?>" /> 

          <!-- patient id error -->            
                        <?php 
                          if(isset($id_errors)){
                          foreach($id_errors as $error){
                          echo "<p style = 'font-size:16px; color: #fc424a;'>$error</p>";
                          }
                          }
                        ?>           
            <br>
            <audio id="audio" controls> <source src="" id="src" /></audio>
          <!-- buttons part -->
            <br>
            <div> 
            <button type="submit" class="btn btn-primary me-2 formbutton" name="upload">Upload</button>
            <button class="btn badge-outline-danger cancelbutton ">Cancel</button>
            </div>
            
          <!-- patial -->
          <!-- Patients details form  -->
          

          
                </form>
              </div>
            </div>

          </div>
        </div>
        <!-- partial -->
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








