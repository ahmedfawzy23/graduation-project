<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>B R E A T H E - W I S E </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/stylet.css">
    <link rel="shortcut icon" href="../assets/images/favicon.png" />
</head>
<body>

    <div class="main">

        <!-- Sign up form -->
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Sign up</h2>
                        <form action="handle/handleRegister.php" method="POST" class="register-form" id="register-form">
                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="name" id="name" placeholder="Your Name" value="<?php if(isset($_SESSION['name'])) echo $_SESSION['name']; unset($_SESSION['name'])?>"/>
                         
                        <!-- name error -->
                       
                         <?php 
                          if(isset($_SESSION['name_errors'])){
                          foreach($_SESSION['name_errors'] as $error){
                          echo "<p style ='font-size:16px; color: #fc424a;'>$error</p>";
                          }
                          }
                          unset($_SESSION['name_errors']);
                        ?>                            
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" placeholder="Your Email" value="<?php if(isset($_SESSION['email'])) echo $_SESSION['email']; unset($_SESSION['email'])?>"/>
                         
                        <!-- email error -->
                       
                         <?php 
                          if(isset($_SESSION['email_errors'])){
                          foreach($_SESSION['email_errors'] as $error){
                          echo "<p style ='font-size:16px; color: #fc424a;'>$error</p>";
                          }
                          }
                          unset($_SESSION['email_errors']);
                        ?> 
                         <!-- other error -->
                       
                         <?php 
                          if(isset($_SESSION['other_errors'])){
                          foreach($_SESSION['other_errors'] as $error){
                          echo "<p style ='font-size:16px; color: #fc424a;'>$error</p>";
                          }
                          }
                          unset($_SESSION['other_errors']);
                        ?>                                                   
                            </div>
                            <div class="form-group">
                                <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" id="pass" placeholder="Password" value="<?php if(isset($_SESSION['password'])) echo $_SESSION['password']; unset($_SESSION['password'])?>"/>
                         
                        <!-- password error -->
                       
                         <?php 
                          if(isset($_SESSION['password_errors'])){
                          foreach($_SESSION['password_errors'] as $error){
                          echo "<p style ='font-size:16px; color: #fc424a;'>$error</p>";
                          }
                          }
                          unset($_SESSION['password_errors']);
                        ?>                               
                                
                            </div>
                            <div class="form-group">
                                <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input type="password" name="re_password" id="re_pass" placeholder="Repeat your password" value="<?php if(isset($_SESSION['re_password'])) echo $_SESSION['re_password']; unset($_SESSION['re_password'])?>"/>                                
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" />
                                <label for="agree-term" class="label-agree-term"><span><span></span></span>I agree all statements in  <a href="#" class="term-service">Terms of service</a></label>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="register" id="signup" class="form-submit" value="Register"/>
                            </div>                           
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="images/signup-image.jpg" alt="sing up image"></figure>
                        <a href="login.php" class="signup-image-link">I am already member</a>
                    </div>
                </div>
            </div>
        </section>



    </div>

    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>