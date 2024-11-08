 <?php
 include '../../inc/headerPages.php';
 require_once "../../inc/docInfo.php"; 
 require_once "../../inc/api.php";


if (!isset($_SESSION['doc_id'])) {
  header('location:../../home.php');
}

?>

<?php include '../../inc/navbar.php';?>

      <!-- partial -->
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">

          <center>
          <a href="old_patient.php" class="btn btn-primary me-2">patient already exist? </a>
          </center>


          <!-- uplaod audio section -->
          <form class="form-sample" action="handle-upload.php" method="post"  enctype="multipart/form-data">
          <div class="drag-area">
            <div class="icon"><i class="fa fa-cloud-upload-alt"></i></div>
            <header> Upload Your audio file</header>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
            <br>
            <button class="uploadbutton">
            <input  type="file" name = "record" id="upload" accept=".wav,.mp3"
             title="Please Upload an Record From The Specific Device E-Littman"  >
            </button>
            <br>
            <audio id="audio" controls>
              <source src="" id="src" />
            </audio>
            <br>
                       <!-- record error -->
                       
                       <?php 
                          if(isset($_SESSION['rec_errors'])){
                          foreach($_SESSION['rec_errors'] as $error){
                          echo "<p style ='font-size:18px ;color: #fc424a;'>$error</p>";
                          }
                          }
                          unset($_SESSION['rec_errors']);
                        ?>
          </div>
          <!-- patial -->
          <!-- Patients details form  -->
          <div class="col-12 grid-margin">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Patients details form</h4>
                  <p class="card-description"> Personal info </p>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">First Name</label>
                        <div class="col-sm-9">
                          <input type="text" name="fname" class="form-control" value="<?php if(isset($_SESSION['fname'])) echo $_SESSION['fname']; unset($_SESSION['fname'])?>" />

                       <!-- firstname error -->
                       
                        <?php 
                          if(isset($_SESSION['first_name_errors'])){
                          foreach($_SESSION['first_name_errors'] as $error){
                          echo "<p style ='font-size:16px; color: #fc424a;'>$error</p>";
                          }
                          }
                          unset($_SESSION['first_name_errors']);
                        ?>

                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Last Name</label>
                        <div class="col-sm-9">
                          <input type="text" name="lname" class="form-control" value="<?php if(isset($_SESSION['lname'])) echo $_SESSION['lname']; unset($_SESSION['lname'])?>"  />
                       <!-- last name error -->
                       
                       <?php 
                          if(isset($_SESSION['last_name_errors'])){
                          foreach($_SESSION['last_name_errors'] as $error){
                          echo "<p style ='font-size:16px; color: #fc424a;'>$error</p>";
                          }
                          }
                          unset($_SESSION['last_name_errors']);
                        ?>

                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Gender</label>
                        <div class="col-sm-9">
                          <select class="form-control" name="gender" value="<?php if(isset($_SESSION['gender'])) echo $_SESSION['gender']; unset($_SESSION['gender'])?>">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                          </select>

                           <!-- gender error -->
                           <?php 
                          if(isset($_SESSION['gender_errors'])){
                          foreach($_SESSION['gender_errors'] as $error){
                          echo "<p style ='font-size:16px; color: #fc424a;'>$error</p>";
                          }
                          }
                          unset($_SESSION['gender_errors']);
                           ?> 

                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Date of Birth</label>
                        <div class="col-sm-9">
                          <input type="date" class="form-control" name="date" placeholder="dd/mm/yyyy" value="<?php if(isset($_SESSION['date'])) echo $_SESSION['date']; unset($_SESSION['date'])?>" />
                           
                          <!-- date error -->
                          <?php 
                          if(isset($_SESSION['date_errors'])){
                          foreach($_SESSION['date_errors'] as $error){
                          echo "<p style ='font-size:16px; color: #fc424a;'>$error</p>";
                          }
                          }
                          unset($_SESSION['date_errors']);
                           ?> 

                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Phone</label>
                        <div class="col-sm-9">
                          <input type="tel" class="form-control" name="phone" value="<?php if(isset($_SESSION['phone'])) echo $_SESSION['phone']; unset($_SESSION['phone'])?>" />
                           
                          <!-- phone error -->
                           <?php 
                          if(isset($_SESSION['phone_errors'])){
                          foreach($_SESSION['phone_errors'] as $error){
                          echo "<p style ='font-size:16px; color: #fc424a;'>$error</p>";
                          }
                          }
                          unset($_SESSION['phone_errors']);
                           ?> 

                        </div>
                      </div>
                    </div>
                    <p class="card-description"> Address </p>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Country</label>
                          <div class="col-sm-9">
                            <select class="form-control" name="country" value="<?php if(isset($_SESSION['country'])) echo $_SESSION['country']; unset($_SESSION['country'])?>" >
                              <option>Egypt</option>
                              <option>Italy</option>
                              <option>Japan</option>
                              <option>America</option>
                              <option>Others</option>
                            </select>
                           <!-- country error -->
                       
                           <?php 
                          if(isset($_SESSION['country_errors'])){
                          foreach($_SESSION['country_errors'] as $error){
                          echo "<p style ='font-size:16px; color: #fc424a;'>$error</p>";
                          }
                          }
                          unset($_SESSION['country_errors']);
                           ?>   

                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label" >City</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="city" value="<?php if(isset($_SESSION['city'])) echo $_SESSION['city']; unset($_SESSION['city'])?>" />
                          
                        <!-- city error -->

                        <?php 
                          if(isset($_SESSION['city_errors'])){
                          foreach($_SESSION['city_errors'] as $error){
                          echo "<p style ='font-size:16px; color: #fc424a;'>$error</p>";
                          }
                          }
                          unset($_SESSION['city_errors']);
                        ?>

                          </div>
                        </div>

                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">State</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="state" value="<?php if(isset($_SESSION['state'])) echo $_SESSION['state']; unset($_SESSION['state'])?>" />
                          
                          <!-- state error -->                          
                          <?php 
                          if(isset($_SESSION['state_errors'])){
                          foreach($_SESSION['state_errors'] as $error){
                          echo "<p style ='font-size:16px; color: #fc424a;'>$error</p>";
                          }
                          }
                          unset($_SESSION['state_errors']);
                           ?> 

                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                  <input type="submit" class="btn btn-primary me-2 formbutton" name="submit"> 
                  <button class="btn badge-outline-danger cancelbutton ">Cancel</button>

                         <!-- confirm registration -->                  
                         <?php 
                          if(isset($_SESSION['registered'])){
                          foreach($_SESSION['registered'] as $error){
                          echo "<p style ='font-size:16px; color: #fc424a;'>$error</p>";
                          }
                          }
                          unset($_SESSION['registered']);
                          ?> 
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
