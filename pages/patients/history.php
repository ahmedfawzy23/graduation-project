<?php
include '../../inc/headerPages.php';
require_once "../../inc/connection.php";
require_once "../../inc/docInfo.php";
require_once "../../inc/validate_paginate.php";

if (!isset($_SESSION['doc_id'])) {
  header('location:../../home.php');
}

$doc_id = $docInfo['doc_id'];



$select = "SELECT * FROM `patient` 
                JOIN`model result` 
                ON `patient`.`pat_id` = `model result`.`pat_id` 
                AND `patient`.`pat_id` = {$_GET['id']} 
                AND `doc_id` = $doc_id" ;

$result = mysqli_query($conn, $select);
if(mysqli_num_rows($result)>0){
  $results = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else{?>
<h3>patient doesn't exist</h3>
<a href="patient.php"><button class="bttn">back</button></a>

<?php    
die();
}
?>



<?php //include '../../inc/navbar.php';?>


<table class="table mt-5">
  <thead>
    <tr>
      <th scope="col">Date</th>
      <th scope="col">Result 1</th>
      <th scope="col">Certainty</th>
      <th scope="col">Result 2</th>
      <th scope="col">Certainty</th>
      <th scope="col">Final Result</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($results as $result => $value): ?>
    <tr>
      <th><?= $value['created_at']?></th>
      <th><?= $value['result']?></th>
      <th><?= $value['per_1']?></th>
      <th><?= $value['result2']?></th>
      <th><?= $value['per_2']?></th>
      <?php
      $final_result = null;
      if($value['per_1'] >= $value['per_2']){
        $final_result = $value['result'];
      } else {
        $final_result = $value['result2'];
      }
      ?>
      <th><?= $final_result?></th>
    </tr>
    <?php endforeach; ?>

  </tbody>
</table>
<br>
<center><a href="patient.php"><button class="bttnh">back</button></a></center>
  <?php include '../../inc/footer.php'?>


