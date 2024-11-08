<?php
include '../../inc/headerPages.php';
 require_once "../../inc/docInfo.php";

if (!isset($_SESSION['doc_id'])) {
  header('location:../../home.php');
}

// doctor settings part

    if(isset($_POST['update_profile'])){

      $errors=[];
      $message=[];
      $update_name = $_POST['update_name'];
      $update_email = $_POST['update_email'];
      
// mysqli_query($conn, "UPDATE `doctor` SET doc_name = '$update_name',doc_email = '$update_email'  WHERE doc_id = '$docId'") or die('query failed');


      if($update_name != $docName){
      mysqli_query($conn, "UPDATE `doctor` SET doc_name = '$update_name' WHERE doc_id = '$docId'") or die('query failed');
      $message[] = 'your name is updated successfully';
      }

      if($update_email !== $doc_email ){
        mysqli_query($conn, "UPDATE `doctor` SET doc_email = '$update_email' WHERE doc_id = '$docId'") or die('query failed');
        $message[] = 'your email is updated successfully';  
        }

    $old_pass = $_POST['old_pass'];
    $update_pass = $_POST['update_pass'];
    $new_pass = $_POST['new_pass'];
    $confirm_pass = $_POST['confirm_pass'];
    
    if(!empty($update_pass) || !empty($new_pass) || !empty($confirm_pass)){


        
        if(!password_verify($update_pass, $old_pass)){
          $errors[] = 'old password not correct!';
        }elseif($new_pass != $confirm_pass){
          $errors[] = 'confirm password not matched!'; 

        }elseif($new_pass == ""){  
          $errors[]="New password is required";
        }elseif(strlen($new_pass)<4){
            $errors[] ="password must be more than 4";
        }else{
          $confirm_pass = password_hash($confirm_pass, PASSWORD_DEFAULT);
          mysqli_query($conn, "UPDATE `doctor` SET doc_password = '$confirm_pass' WHERE doc_id = '$docId'") or die('query failed');
          $message[] = 'password updated successfully!';
        }

      }


          
              $extensions = ['png', 'jpg', 'jpeg'];
              $img = $_FILES['update_image'];
              $imgName  = $img['name'];
              $imgSize  = $img['size'];
              $imgTmp  = $img['tmp_name'];
              $imgFullPath  = $img['full_path'];
              $exe = pathinfo($imgFullPath, PATHINFO_EXTENSION);
              if(!empty($imgName)){
                if($imgSize > 2000000){
                  $errors[] = 'image is too large';
              }else if (!in_array($exe, $extensions)){
                $errors[] = 'image not valid';
              }else{
                $imgNewName = uniqid().".".$exe;
                  $image_update_query = mysqli_query($conn, "UPDATE `doctor` SET  image_path = '$imgNewName' WHERE doc_id = '$docId'") or die('query failed');
                  if($image_update_query){
                    move_uploaded_file($imgTmp, '../../assets/uploads/'.$imgNewName);
                    $docImg = $imgNewName;

                  }
                  $message[] = 'your image updated succssfully!';
              }
            }
          }
            






      
        
?>
<?php include '../../inc/navbar.php';?>

    
      <!-- partial -->
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="page-header">
          </div>

          <div class="container w-75">

            <div class="card">

              <div class="card-bodyset">

                    <?php
                    $select = mysqli_query($conn, "SELECT * FROM `doctor` WHERE doc_id = '$docId'") or die('query failed');
                    if(mysqli_num_rows($select) > 0){
                      $fetch = mysqli_fetch_assoc($select);
                    }
                    ?>

                   <form class="forms-sample" method="post" enctype="multipart/form-data">
                  <div class="profile-pic-div" >
                  <?php            
                  
                  echo '<img style="width: 100%; height: 100px; border-radius: 50px;"  src="../../assets/uploads/'.$fetch['image_path'].'">';
                      
                    
                  ?>
                   </div>
                   <button class="btn btn-primary imgbutton"    >  <input type="file" name="update_image" class="uploadimgbutton" accept="image/jpg, image/jpeg, image/png" ></button> 
<?php 
if(isset($message)){
  foreach($message as $mess)
  {
    echo'<center><strong><div class="alert alert-success" role="alert"><div class="message">';
    echo $mess;                         
    echo '</div></div></strong></center>';
  unset($mess);
  }
  require_once "../../settingEmail.php";
}
?>


<?php
if(isset($errors)){
  foreach($errors as $error)
  {
    echo'<center><strong><div class="alert alert-danger" role="alert"><div class="message">';
    echo $error;                         
    echo '</div></div></strong></center>';

  }
  unset($error);
}
?> 

                  <div class="form-group">
                    <label for="exampleInputUsername1">Your Name</label>
                    <input type="text" name="update_name" value="<?php echo $fetch['doc_name']; ?>"  class="form-control setting" id="exampleInputUsername1" placeholder="Your Name">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" name="update_email" value="<?php echo $fetch['doc_email']; ?>" class="form-control setting" id="exampleInputEmail1" placeholder="Email">
                  </div>
                  <div class="form-group">
                  <input type="hidden" name="old_pass" value="<?php echo $fetch['doc_password']; ?>">
                    <label for="exampleInputPassword1">Old Password</label>
                    <input type="password" name="update_pass"  class="form-control setting" id="exampleInputPassword1" placeholder="Password">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">New Password</label>
                    <input type="password" name="new_pass" class="form-control setting" id="exampleInputPassword1"
                      placeholder="Password">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputConfirmPassword1">Confirm Password</label>
                    <input type="password" name="confirm_pass" class="form-control setting" id="exampleInputConfirmPassword1" placeholder="Password">
                  </div>
                  <div class="form-check form-check-flat form-check-primary">
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input"> Remember me </label>
                  </div>
                  <button type="submit" class="btn btn-primary me-2 formbutton" name="update_profile">Save</button>
                  <button class="btn badge-outline-danger cancelbutton ">Cancel</button>
                 </form>
              </div>
            </div>
          </div>

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

<?php

//  image section   
        
        //     $update_image = $_FILES['update_image']['name'];
        //     $update_image_size = $_FILES['update_image']['size'];
        //     $update_image_tmp_name = $_FILES['update_image']['tmp_name'];

        //     $update_image_folder = '../../assets/uploads/'.$update_image;
           
        //      if(!empty($update_image)){
        //        if($update_image_size > 2000000){
        //           $message[] = 'image is too large';
        //        }else{
        //           $image_update_query = mysqli_query($conn, "UPDATE `doctor` SET  image_path = '$update_image_folder' WHERE doc_id = '$docId'") or die('query failed');
        //           if($image_update_query){

        //             move_uploaded_file($update_image_tmp_name, $update_image_folder);
        //             $docImg = $update_image_folder;

        //           }
        //            $message[] = 'image updated succssfully!';
        //        }
        //     }
        
        //  }


        //  if(mysqli_query($conn, "UPDATE `doctor` SET doc_name = '$update_name' WHERE doc_id = '$docId'") or die('query failed')){
        //       if($update_name != $docName){
        //       $message[] = 'your name is updated';
        //       }
        //     }
        //     if(mysqli_query($conn, "UPDATE `doctor` SET doc_email = '$update_email' WHERE doc_id = '$docId'") or die('query failed')){
        //       if($update_email != $doc_email ){
        //       $message[] = 'your email is updated';  
        //       }
        //     }



        // if(isset($_SESSION['errors'])){
//   foreach($_SESSION['errors'] as $error)
// {
      
//   echo'<center><strong><div class="alert alert-danger" role="alert"><div class="message">';
//   echo $error;                         
//   echo '</div></div></strong></center>';
// }
// }

?>

