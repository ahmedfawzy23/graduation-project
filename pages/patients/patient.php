<?php
include '../../inc/headerPages.php';
require_once "../../inc/connection.php";
require_once "../../inc/docInfo.php";
require_once "../../inc/validate_paginate.php";

if (!isset($_SESSION['doc_id'])) {
  header('location:../../home.php');
}

$doc_id = $docInfo['doc_id'];

$select_count = "SELECT count(*) AS 'count' FROM `patient` WHERE `doc_id` = $doc_id;";
$result_count = mysqli_query($conn, $select_count);
$fetch_count = mysqli_fetch_assoc($result_count);
$count = $fetch_count['count']; // total rows
$limit = 8;
$total_pages = ceil($count / $limit);
$page = isset($_GET['page'])? (int)$_GET['page'] : 1;
$offset = ($page - 1)*$limit;


$select = "SELECT `first_name`, `last_name`, `gender`,`patient`.`pat_id` 
          FROM patient WHERE `doc_id` = $doc_id
          LIMIT $limit OFFSET $offset;" ;

$result = mysqli_query($conn, $select);
if(mysqli_num_rows($result)>0){
  $patients = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>



<?php include '../../inc/navbar.php';?>

      <div class=" patient_container">
        <div class="patient">
          <div class="t">Patients</div>
        </div>


        <div class="r" >
            <!--First User design starts here-->
            <?php
            if(!empty($patients)){
              if(!Validate($page, $total_pages)){
                header("location:".$_SERVER['PHP_SELF']."?page=1");
              }
            foreach ($patients  as $patient){?>
            <div class="profile-card">
                <div class="profile-content">
                    <div class="profile-image">
                      <img src="images/img2.jpg" alt=" frist image">
                    </div>
                    <div class="desc">
                        <h2><?=$patient['first_name']." ".$patient['last_name']?></h2>
                        <p><?=$patient['gender']?></p>
                    </div>
                    
                    <div class="bttn-div">
                        <a href="https://web.whatsapp.com/"><button class="bttn">CHAT</button></a>
                        <a href="history.php?id=<?= $patient['pat_id']?>"><button class="bttnh">HISTORY</button></a>
                        <br>
                        
                    
                    </div>
                </div>
            </div>
            <?php }
            ?>
        </div>
        <div class="container d-flex justify-content-center">
        <nav aria-label="Page navigation example">
        <ul class="pagination w-50">
          <li class="page-item <?php if($page == 1) echo "disabled" ?>">
            <a class="page-link" href="patient.php?page=<?= $page-1?>">Previous</a>
          </li>
          <li class="page-item"><a class="page-link"><?=$page?></a></li>
          <li class="page-item"><a class="page-link"> OF </a></li>
          <li class="page-item"><a class="page-link"><?=$total_pages?></a></li>
          <li class="page-item <?php if($page == $total_pages) echo "disabled" ?>">
            <a class="page-link" href="patient.php?page=<?= $page+1?>">Next</a>
          </li>
        </ul>
      </nav>
      </div>
    <?php }else {
            echo "There is no patients";

           }?>
    </div> 
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <?php include '../../inc/footer.php'?>


 