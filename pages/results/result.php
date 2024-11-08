<?php
include '../../inc/headerPages.php';
require_once "../../inc/connection.php";
require_once "../../inc/docInfo.php";
require_once "../../inc/validate_paginate.php";
require_once "../../inc/api.php";


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






$select =  "SELECT `first_name`, `last_name`,`patient`.`pat_id`, `gender`, `result`, `created_at`, `record_id`
            FROM `patient` join `model result`
            ON `patient`.`pat_id` = `model result`.`pat_id`
            WHERE `doc_id` = $doc_id
            LIMIT $limit OFFSET $offset;" ;

$result = mysqli_query($conn, $select);
if(mysqli_num_rows($result)>0){
  $patients = mysqli_fetch_all($result, MYSQLI_ASSOC);
}



?>
<?php include '../../inc/navbar.php';?>

      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="page-header">
            <h2 class="page-title"> Patients' Results </h2>
          </div>
      
          <?php
            if(!empty($patients)){
              if(!Validate($page, $total_pages)){
                header("location:".$_SERVER['PHP_SELF']."?page=1");
                }?>
            <div class="col-lg-6 grid-margin stretch-card2">
              <div class="card2">
                <div class="card-body">
                <div class="new-search">
                  <form method="post">
                    <input class="patient-search" type="search" name="search" class="form-control" placeholder="Search patients by name">
                    <input type="submit" class="btn btn-primary me-2" name="submit" value="search" style="border-radius: 5px;width:100px " hidden>
                  </form>
                </div>

                <?php
                if (isset($_POST["submit"])) {
                  $str = $_POST["search"];
                  $str = mysqli_real_escape_string($conn, $str);
                  $sth = $con->prepare("SELECT `first_name`, `last_name`,`patient`.`pat_id`, `gender`, `result`, `created_at`, `record_id`
                  FROM `patient` join `model result` 
                  ON `patient`.`pat_id` = `model result`.`pat_id`
                  WHERE (`first_name` like '%$str%' or `last_name` like '%$str%'  or concat_ws(' ',`first_name`,`last_name`)  like '%$str%') AND `doc_id` = $doc_id;");
                  $sth->setFetchMode(PDO::FETCH_ASSOC);
                  $sth->execute();
                  if ($rows = $sth->fetchAll()) {
                    
                ?>
                    <div class="table-responsive">
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th>Patient</th>
                            <th>Patient_ID</th>
                            <th>Initial Diagnosis</th>
                            <th>Gender</th>
                            <th>Date</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($rows as $row) {?>
                          <tr>
                            <td><?php echo $row['first_name']; ?> <span></span> <?php echo $row['last_name']; ?></td>
                            <td> <?php echo $row['pat_id'];?> </td>  
                            <td class="COPD"><?php echo $row['result'];?></td>
                            <td><?php echo $row['gender']; ?></td>
                            <td><?php echo $row['created_at']; ?></td>
                            <td><button type="submit" class="badge2"> <a style="text-decoration:none ; color:#fff ;" href="../../pages/results/reports.php?pat_id=<?php echo $row['pat_id']?>&record_id=<?php echo $row['record_id']?>">View Report</a></button></td>              
                          </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                    
                <?php
                  } else {

                    $message = "Name Does not exist!";
                    echo "<div style='color: red;'>$message</div>";
                  }
                }

                ?>

                <br>
                <h4 style="color :#ffab00">Recent Patients</h4>
              
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Patient</th>
                          <th>Patient_ID</th>
                          <th>Initial Diagnosis</th>
                          <th>Gender</th>
                          <th>Date</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php foreach ($patients  as $patient){?>
                        <tr>
                          <td><?=$patient['first_name']." ".$patient['last_name']?></td>
                          <td> <?=$patient['pat_id']?> </td>                         
                          <td class="COPD"><?php echo $patient['result'];?></td>
                          <td> <?=$patient['gender']?> </td>
                          <td> <?=$patient['created_at']?> </td>
                          <td><button type="submit" class="badge2"> <a href="../../pages/results/reports.php?pat_id=<?php echo $patient['pat_id']?>&record_id=<?php echo $patient['record_id']?>">View Report</a></button></td>
                        </tr>
                        <?php } ?>
                        
                      
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="container d-flex justify-content-center">
        <nav aria-label="Page navigation example">
        <ul class="pagination w-50">
          <li class="page-item <?php if($page == 1) echo "disabled" ?>">
            <a class="page-link" href="result.php?page=<?= $page-1?>">Previous</a>
          </li>
          <li class="page-item"><a class="page-link"><?=$page?></a></li>
          <li class="page-item"><a class="page-link"> OF </a></li>
          <li class="page-item"><a class="page-link"><?=$total_pages?></a></li>
          <li class="page-item <?php if($page == $total_pages) echo "disabled" ?>">
            <a class="page-link" href="result.php?page=<?= $page+1?>">Next</a>
          </li>
        </ul>
      </nav>
      </div>
          <?php }else {
            echo "There is no patients";

           }?>
            
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
