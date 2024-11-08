<?php session_start();?>
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

        <!-- Login  Form -->
        <section class="sign-in">
            <div class="container">
 
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="images/signin-image.jpg" alt="sing up image"></figure>
                        <a href="register.php" class="signup-image-link">Create an account</a>
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">Login</h2>
                        <form action="handle/handleLogin.php" method="POST" class="register-form" id="login-form">
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
                            </div>
                            <div class="form-group">
                                <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" id="your_pass" placeholder="Password" value="<?php if(isset($_SESSION['password'])) echo $_SESSION['password']; unset($_SESSION['password'])?>"/>
                         <!-- password error -->
                       
                         <?php 
                          if(isset($_SESSION['pass_errors'])){
                          foreach($_SESSION['pass_errors'] as $error){
                          echo "<p style ='font-size:16px; color: #fc424a;'>$error</p>";
                          }
                          }
                          unset($_SESSION['pass_errors']);
                        ?>                               
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="remember-me" id="remember-me" class="agree-term" />
                                <label for="remember-me" class="label-agree-term"><span><span></span></span>Remember me</label>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="login" id="signin" class="form-submit" value="Log in"/>
                            </div>

                         <!-- email or password error -->
                       
                         <?php 
                          if(isset($_SESSION['both_errors'])){
                          foreach($_SESSION['both_errors'] as $error){
                          echo "<p style ='font-size:16px; color: #fc424a;'>$error</p>";
                          }
                          }
                          unset($_SESSION['both_errors']);
                        ?> 


                        </form>
                        <div class="social-login">
                            <span class="social-label">Or login with</span>
                            <ul class="socials">
                                <li><a href="#"><i class="display-flex-center zmdi zmdi-facebook"></i></a></li>
                                <li><a href="#"><i class="display-flex-center zmdi zmdi-twitter"></i></a></li>
                                <li><a href="#"><i class="display-flex-center zmdi zmdi-google"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
</body>
</html>